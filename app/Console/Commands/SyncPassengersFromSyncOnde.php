<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Passenger; // <- Use the Passenger model
use Carbon\Carbon;

class SyncPassengersFromSyncOnde extends Command
{
    protected $signature = 'onde:fetch-passengers';
    protected $description = 'Fetch Onde passengers report and insert/update records into the passengers table';

    public function handle()
    {
        $companyId = '591f0997-20a3-4156-8463-97dc793bc002';
        $authToken = '017bea83-152c-4981-84a1-5c6ed2e5d773';
        $baseUrl = 'https://api.onde.app';

  // First and last day of the current month
$from = Carbon::now()->startOfDay()->timestamp * 1000;
        $to = Carbon::now()->endOfDay()->timestamp * 1000;

 
        // Create the report
        $response = Http::withHeaders([
            'Authorization' => $authToken,
            'Content-Type' => 'application/json',
        ])->post("{$baseUrl}/v1/company/{$companyId}/report", [
            'from' => $from,
            'to' => $to,
            'reports' => ['PASSENGERS'],
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
        ])->get("{$baseUrl}/v1/company/{$companyId}/report/{$reportId}/PASSENGERS/download");

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

        $filePath = "{$reportsPath}/passenger_" . now()->format('Ymd_His') . ".csv";
        file_put_contents($filePath, $fileResp->body());

        // Read CSV and update passengers table
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            Log::error("❌ Cannot open CSV file");
            return;
        }

        $header = fgetcsv($handle);
        $inserted = 0;
        $updated = 0;
        $errors = 0;
        $rowNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            try {
                if (count($header) !== count($row)) {
                    Log::warning("⚠️ Row {$rowNumber} has different number of columns than header. Skipping.");
                    $errors++;
                    continue;
                }

                $data = array_combine($header, $row);

                // Map CSV columns to passengers table columns
       $passengerData = [
    'passenger_id' => $data['passenger id'] ?? null,
    'passenger_source' => $data['passenger source'] ?? null,
    'name' => $data['name'] ?? 'Unknown',
    'email' => $data['email'] ?? null,
    'phone' => $data['phone'] ?? null,
    'company_note' => $data['company note'] ?? null,
    'profile_state' => $data['profile state'] ?? null,
    'client_documents' => (int) ($data['client documents'] ?? 0),
    'total_orders' => (int) ($data['total orders'] ?? 0),
    'paid_orders_total_zmw' => (float) ($data['paid orders total, ZMW'] ?? 0),
    'unpaid_orders_total_zmw' => (float) ($data['unpaid orders total, ZMW'] ?? 0),
    'cancelled_by_dispatcher' => (int) ($data['CANCELLED_BY_DISPATCHER'] ?? 0),
    'cancelled_by_driver' => (int) ($data['CANCELLED_BY_DRIVER'] ?? 0),
    'cancelled_no_passenger' => (int) ($data['CANCELLED_NO_PASSENGER'] ?? 0),
    'cancelled_decided_not_to_go' => (int) ($data['CANCELLED_DECIDED_NOT_TO_GO'] ?? 0),
    'cancelled_no_taxi' => (int) ($data['CANCELLED_NO_TAXI'] ?? 0),
    'cancelled_driver_offline' => (int) ($data['CANCELLED_DRIVER_OFFLINE'] ?? 0),
    'cancelled_search_exceeded' => (int) ($data['CANCELLED_SEARCH_EXCEEDED'] ?? 0),
    'cancelled_expired' => (int) ($data['CANCELLED_EXPIRED'] ?? 0),
    'finished_paid' => (int) ($data['FINISHED_PAID'] ?? 0),
    'finished_unpaid' => (int) ($data['FINISHED_UNPAID'] ?? 0),
];


                // Update or insert
                $passenger = Passenger::updateOrCreate(
                    ['passenger_id' => $passengerData['passenger_id']], 
                    $passengerData
                );

                if ($passenger->wasRecentlyCreated) {
                    $inserted++;
                } else {
                    $updated++;
                }

            } catch (\Exception $e) {
                $errors++;
                Log::error("❌ Error processing passenger at row {$rowNumber}: " . $e->getMessage());
                continue;
            }
        }

        fclose($handle);

        $this->info("✅ Passengers processing completed: {$inserted} inserted, {$updated} updated, {$errors} errors");

        // Delete CSV file after processing
        if (file_exists($filePath)) {
            unlink($filePath);
            $this->info("✅ CSV file deleted from storage");
        }

        // Delete report from Onde API
        $deleteResp = Http::withHeaders(['Authorization' => $authToken])
                          ->delete("{$baseUrl}/v1/company/{$companyId}/report/{$reportId}/PASSENGERS");

        if ($deleteResp->failed()) {
            Log::warning("⚠️ Failed to delete report {$reportId}: " . $deleteResp->body());
        } else {
            $this->info("✅ Report {$reportId} deleted successfully");
        }
    }
}
