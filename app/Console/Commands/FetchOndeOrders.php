<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Orders;
use Carbon\Carbon;

class FetchOndeOrders extends Command
{
    protected $signature = 'onde:fetch-orders';
    protected $description = 'Fetch Onde ORDERS report and insert new records into the orders table';

    public function handle()
    {
        $companyId = '591f0997-20a3-4156-8463-97dc793bc002';
        $authToken = '017bea83-152c-4981-84a1-5c6ed2e5d773';
        $baseUrl = 'https://api.onde.app';

        $from = Carbon::now()->startOfDay()->timestamp * 1000;
        $to = Carbon::now()->endOfDay()->timestamp * 1000;

        // Create the report
        $response = Http::withHeaders([
            'Authorization' => $authToken,
            'Content-Type' => 'application/json',
        ])->post("{$baseUrl}/v1/company/{$companyId}/report", [
            'from' => $from,
            'to' => $to,
            'reports' => ['ORDERS'],
        ]);

        if ($response->failed()) {
            Log::error("❌ Failed to create report: " . $response->body());
            return;
        }

        $reportArray = $response->json();
        if (!isset($reportArray[0]['reportId'])) {
            Log::error("❌ No reportId found: " . json_encode($reportArray));
            return;
        }

        $reportId = $reportArray[0]['reportId'];
       
        // Download report
        $downloadResp = Http::withHeaders([
            'Authorization' => $authToken,
        ])->get("{$baseUrl}/v1/company/{$companyId}/report/{$reportId}/ORDERS/download");

        if ($downloadResp->failed()) {
            Log::error("❌ Failed to get download URL: " . $downloadResp->body());
            return;
        }

        $downloadData = $downloadResp->json();
        $downloadUrl = $downloadData['downloadUrl'] ?? null;

        if (!$downloadUrl) {
            Log::error("❌ downloadUrl not found in response");
            return;
        }

        if (str_starts_with($downloadUrl, '/')) {
            $downloadUrl = "{$baseUrl}{$downloadUrl}";
        }

        $fileResp = Http::withHeaders([
            'Authorization' => $authToken,
        ])->get($downloadUrl);

        if ($fileResp->failed()) {
            Log::error("❌ Failed to download CSV: " . $fileResp->body());
            return;
        }

        $reportsPath = storage_path('app/reports');
        if (!is_dir($reportsPath)) mkdir($reportsPath, 0755, true);

        $filePath = "{$reportsPath}/orders_" . now()->format('Ymd_His') . ".csv";
        file_put_contents($filePath, $fileResp->body());
     
        // Helper functions with better error handling
        $parseDate = function ($value) {
            if (empty($value) || strtoupper($value) === 'ASAP') return null;
            $formats = [
                'd/m/Y H:i:s O',
                'd/m/Y H:i:s',
                'Y-m-d H:i:s',
                'Y-m-d\TH:i:sP',
            ];
            foreach ($formats as $format) {
                try { 
                    return Carbon::createFromFormat($format, $value)->toDateTimeString(); 
                } catch (\Exception $e) { 
                    continue; 
                }
            }
            try { 
                return Carbon::parse($value)->toDateTimeString(); 
            } catch (\Exception $e) { 
                return null; 
            }
        };

        $parseLocation = function ($value) {
            if (empty($value)) return null;
            // Parse "lat,lng" string to array
            $coords = explode(',', $value);
            if (count($coords) === 2) {
                return [
                    'lat' => (float) trim($coords[0]),
                    'lng' => (float) trim($coords[1])
                ];
            }
            return null;
        };

        $parseTimeToSeconds = function ($value) {
            if (empty($value)) return null;
            
            // Handle "30 sec", "10m 0s", etc.
            if (str_contains($value, 'sec')) {
                return (int) preg_replace('/[^0-9]/', '', $value);
            }
            
            // Handle "10m 0s" format
            if (preg_match('/(\d+)m\s*(\d+)s/', $value, $matches)) {
                return (int) $matches[1] * 60 + (int) $matches[2];
            }
            
            return (int) $value;
        };

        $parseDistance = function ($value) {
            if (empty($value)) return null;
            // Remove " km" and convert to float
            $cleaned = str_replace(' km', '', $value);
            return is_numeric($cleaned) ? (float) $cleaned : null;
        };

        $parseCurrency = function ($value) {
            if (empty($value)) return null;
            // Remove currency notation and convert to float
            $cleaned = preg_replace('/[^0-9.-]/', '', $value);
            return is_numeric($cleaned) ? (float) $cleaned : null;
        };

        $parseDecimal = function ($value) {
            if (empty($value)) return null;
            // More robust decimal parsing
            $cleaned = preg_replace('/[^0-9.-]/', '', $value);
            return is_numeric($cleaned) ? (float) $cleaned : null;
        };

        $parseJson = function ($value) {
            if (empty($value)) return null;
            
            // If it's already a JSON string, decode it
            if (is_string($value) && str_starts_with($value, '{') && str_ends_with($value, '}')) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $decoded;
                }
            }
            
            // If it's a simple string, return as is
            return $value;
        };

        $parseInteger = function ($value) {
            if (empty($value)) return null;
            $cleaned = preg_replace('/[^0-9-]/', '', $value);
            return is_numeric($cleaned) ? (int) $cleaned : null;
        };

        $parseBoolean = function ($value) {
            if (empty($value)) return null;
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        };

        // Insert CSV data into DB
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            Log::error("❌ Cannot open CSV file");
            return;
        }

        $header = fgetcsv($handle);
        $inserted = 0;
        $updated = 0;
        $errors = 0;
        $rowNumber = 1; // Start from 1 to account for header row

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            $orderId = 'unknown';
            
            try {
                // Check if header and row have the same number of columns
                if (count($header) !== count($row)) {
                    Log::warning("⚠️ Row {$rowNumber} has different number of columns than header. Skipping.");
                    $errors++;
                    continue;
                }

                $data = array_combine($header, $row);
                if (!isset($data['order id'])) {
                    Log::warning("⚠️ Row {$rowNumber} missing order id. Skipping.");
                    $errors++;
                    continue;
                }

                $orderId = $data['order id'] ?? 'unknown';

                $orderData = [
                    'order_id' => $orderId,
                    'created_at_api' => $parseDate($data['created at'] ?? null),
                    'author_id' => $data['author id'] ?? null,
                    'order_source' => $data['order source'] ?? null,
                    'bundle' => $data['bundle'] ?? null,
                    'requested_vehicle_type' => $data['requested vehicle type'] ?? null,
                    'requested_pickup_time' => $parseDate($data['requested pickup time'] ?? null),
                    'origin_type' => $data['origin type'] ?? null,
                    'origin_location' => $parseLocation($data['origin location'] ?? null),
                    'origin_address' => $data['origin address'] ?? null,
                    'destination_type' => $data['destination type'] ?? null,
                    'destination_location' => $parseLocation($data['destination location'] ?? null),
                    'destination_address' => $data['destination address'] ?? null,
                    'dropoff_type' => $data['dropoff type'] ?? null,
                    'dropoff_location' => $parseLocation($data['dropoff location'] ?? null),
                    'dropoff_address' => $data['dropoff address'] ?? null,
                    'dropoffs_count' => $parseInteger($data['dropoffs count'] ?? null),
                    'order_notes' => $data['order notes'] ?? null,
                    'passengers_number' => $parseInteger($data['passengers number'] ?? null),
                    'client_documents' => $parseJson($data['client documents'] ?? null),
                    'driver_payment_documents' => $parseJson($data['driver payment documents'] ?? null),
                    
                    // Passenger info
                    'passenger_id' => $data['passenger id'] ?? null,
                    'passenger_name' => $data['passenger name'] ?? null,
                    'passenger_email' => $data['passenger email'] ?? null,
                    'passenger_phone' => $data['passenger phone'] ?? null,
                    'passenger_operator_id' => $data['passenger operator id'] ?? null,
                    'passenger_operator_name' => $data['passenger operator name'] ?? null,
                    'passenger_operator_email' => $data['passenger operator email'] ?? null,
                    
                    // Driver operator info
                    'driver_operator_id' => $data['driver operator id'] ?? null,
                    'driver_operator_name' => $data['driver operator name'] ?? null,
                    'driver_operator_email' => $data['driver operator email'] ?? null,
                    
                    // Driver info
                    'driver_id' => $data['driver id'] ?? null,
                    'driver_custom_key' => $data['driver custom key'] ?? null,
                    'driver_name' => $data['driver name'] ?? null,
                    'driver_email' => $data['driver email'] ?? null,
                    'driver_phone' => $data['driver phone'] ?? null,
                    
                    // Vehicle info
                    'vehicle_type' => $data['vehicle type'] ?? null,
                    'vehicle_plate_number' => $data['vehicle plate number'] ?? null,
                    'vehicle_board_number' => $data['vehicle board number'] ?? null,
                    
                    // Ratings and reputation - use parseDecimal for better handling
                    'driver_reputation' => $parseDecimal($data['driver reputation'] ?? null),
                    'driver_reputation_correction' => $parseDecimal($data['driver reputation correction'] ?? null),
                    
                    // Estimations
                    'estimation_time' => $parseTimeToSeconds($data['estimation time'] ?? null),
                    'estimation_distance' => $parseDistance($data['estimation distance'] ?? null),
                    
                    // Bidding and rate plans
                    'driver_rate_plan' => $data['driver rate plan'] ?? null,
                    'offer_count' => $parseInteger($data['offer#'] ?? null),
                    'reject_count' => $parseInteger($data['reject#'] ?? null),
                    'total_bid_count' => $parseInteger($data['total bid#'] ?? null),
                    'driver_bid_count' => $parseInteger($data['driver bid#'] ?? null),
                    'dispatcher_bid_count' => $parseInteger($data['dispatcher bid#'] ?? null),
                    
                    // Status and reason info
                    'order_status' => $data['order status'] ?? null,
                    'unpaid_reason' => $data['unpaidReason'] ?? null,
                    'unpaid_message' => $data['unpaidMessage'] ?? null,
                    'cancellation_reason' => $data['cancellation reason'] ?? null,
                    'cancellation_comment' => $data['cancellation comment'] ?? null,
                    
                    // Trip metrics
                    'trip_distance' => $parseDistance($data['trip distance'] ?? null),
                    'trip_time' => $parseTimeToSeconds($data['trip time'] ?? null),
                    'intermediate_driver_ids' => $parseJson($data['intermediate driver ids'] ?? null),
                    
                    // Costs - use parseDecimal for all currency fields
                    'passenger_cancellation_fee' => $parseDecimal($data['passenger cancellation fee, ZMW'] ?? null),
                    'driver_cancellation_fee' => $parseDecimal($data['driver cancellation fee, ZMW'] ?? null),
                    'trip_cost' => $parseDecimal($data['trip cost, ZMW'] ?? null),
                    'extra_cost' => $parseDecimal($data['extra cost, ZMW'] ?? null),
                    'total_cost' => $parseDecimal($data['total cost, ZMW'] ?? null),
                    'coupon_discount' => $parseDecimal($data['coupon discount, ZMW'] ?? null),
                    'tips' => $parseDecimal($data['tips, ZMW'] ?? null),
                    'bonus_amount' => $parseDecimal($data['bonus amount, ZMW'] ?? null),
                    'including_tax' => $parseDecimal($data['including tax, ZMW'] ?? null),
                    'tax' => $parseDecimal($data['tax, ZMW'] ?? null),
                    'transactional_fee' => $parseDecimal($data['transactional fee, ZMW'] ?? null),
                    'final_cost' => $parseDecimal($data['final cost, ZMW'] ?? null),
                    'unpaid_cost' => $parseDecimal($data['unpaid costZMW'] ?? null),
                    'rounding_correction_value' => $parseDecimal($data['rounding correction value, ZMW'] ?? null),
                    'excess_payment' => $parseDecimal($data['excess payment, ZMW'] ?? null),
                    
                    // Payment
                    'payment_method' => $data['payment method'] ?? null,
                    'payment_card' => $data['payment card'] ?? null,
                    'corporate_account' => $data['corporate account'] ?? null,
                    'payment_errors' => $data['payment errors'] ?? null,
                    
                    // Ratings
                    'rating_by_driver' => $parseInteger($data['rating by driver'] ?? null),
                    'rating_by_passenger' => $parseInteger($data['rating by passenger'] ?? null),
                    
                    // Timestamps and locations
                    'started_at' => $parseDate($data['started at'] ?? null),
                    'started_location' => $parseLocation($data['started location'] ?? null),
                    'arrived_at' => $parseDate($data['arrived at'] ?? null),
                    'arrived_location' => $parseLocation($data['arrived location'] ?? null),
                    'loaded_at' => $parseDate($data['loaded at'] ?? null),
                    'loaded_location' => $parseLocation($data['loaded location'] ?? null),
                    'finished_at' => $parseDate($data['finished at'] ?? null),
                    'finished_location' => $parseLocation($data['finished location'] ?? null),
                    'closed_at' => $parseDate($data['closed at'] ?? null),
                    'closed_location' => $parseLocation($data['closed location'] ?? null),
                    
                    // Misc
                    'service_space' => $data['service space'] ?? null,
                    'active' => $parseBoolean($data['active'] ?? true),
                    'linked_order' => $data['linked order'] ?? null,
                    'price_multiplier' => $parseDecimal($data['price multiplier'] ?? null),
                    'coupon_code' => $data['coupon code'] ?? null,
                    'promo_campaign_name' => $data['promo campaign name'] ?? null,
                    
                    // Reward data (not in CSV, set as null)
                    'customer_reward_data' => null,
                    'driver_reward_data' => null,
                ];

                // Remove null values to allow database defaults
                $orderData = array_filter($orderData, function ($value) {
                    return $value !== null;
                });

                $result = Orders::updateOrCreate(
                    ['order_id' => $orderData['order_id']], 
                    $orderData
                );

                if ($result->wasRecentlyCreated) {
                    $inserted++;
                } else {
                    $updated++;
                }

            } catch (\Exception $e) {
                $errors++;
                Log::error("❌ Error processing order {$orderId} at row {$rowNumber}: " . $e->getMessage());
                continue;
            }
        }

        fclose($handle);
     
        $this->info("✅ Orders processing completed: {$inserted} inserted, {$updated} updated, {$errors} errors");

        // --- Delete report from Onde API ---
        $deleteResp = Http::withHeaders([
            'Authorization' => $authToken,
        ])->delete("{$baseUrl}/v1/company/{$companyId}/report/{$reportId}/ORDERS");

        if ($deleteResp->failed()) {
            Log::warning("⚠️ Failed to delete report {$reportId}: " . $deleteResp->body());
        } else {
            $this->info("✅ Report {$reportId} deleted successfully");
        }

        // --- Delete CSV from storage ---
        if (file_exists($filePath)) {
            unlink($filePath);
            $this->info("✅ CSV file deleted from storage");
        }
    }
}