<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DriverController extends Controller
{
    public function topupDriver(Request $request)
    {
        $request->validate([
            'registeredNumber' => 'required|string',
            'paymentNumber' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $registeredNumber = $request->registeredNumber;
        $paymentNumber = $request->paymentNumber;
        $amount = (float) $request->amount;
        $currency = 'ZMW';
        $comment = "Driver Float Top-up";

        $companyId = '591f0997-20a3-4156-8463-97dc793bc002';
        $ondeBaseUrl = "https://api.onde.app/v1/company/$companyId";
        $ondeApiKey = '017bea83-152c-4981-84a1-5c6ed2e5d773';

        $paymentBaseUrl = "http://102.208.220.62:4500/Api";
        $paymentApiKey = "P7b2yFJdt8KDb2Hdv5gruxjkvLh5ZBGV";
        $reference = time();

        try {
            // 1️⃣ Verify driver exists
            $response = Http::withHeaders([
                'Authorization' => $ondeApiKey,
                'Content-Type' => 'application/json',
            ])->get("$ondeBaseUrl/driver");

            if ($response->failed()) {
                Log::error('❌ Onde API failed to fetch drivers', ['response' => $response->body()]);
                return response()->json(['error' => 'Failed to fetch drivers'], 500);
            }

            $drivers = $response->json();
            $matchedDriver = collect($drivers)->first(function ($driver) use ($registeredNumber) {
                $driverPhone = preg_replace('/\D/', '', $driver['phone']);
                $inputPhone = preg_replace('/\D/', '', $registeredNumber);
                return substr($driverPhone, -9) === substr($inputPhone, -9);
            });

            if (!$matchedDriver) {
                Log::warning('⚠️ No driver found for number', ['input' => $registeredNumber]);
                return response()->json(['error' => 'Driver not found'], 404);
            }

            $driverId = $matchedDriver['driverId'];
            Log::info("✅ Driver verified before payment", ['driverId' => $driverId]);

            // 2️⃣ Determine payment method
            $cleanNumber = preg_replace('/\D/', '', $paymentNumber);

            // Normalize to full international format (always start with 260)
            if (str_starts_with($cleanNumber, '0')) {
                $cleanNumber = '260' . substr($cleanNumber, 1);
            } elseif (!str_starts_with($cleanNumber, '260')) {
                $cleanNumber = '260' . $cleanNumber;
            }

            // Detect provider
            $prefix = substr($cleanNumber, 0, 5);
            $paymentMethod = match ($prefix) {
                '26098', '26078' => 'ZEDMOBILE',
                '26097', '26050', '26077' => 'AIRTEL',
                '26096', '26076' => 'MTN',
                '26095', '26075' => 'ZAMTEL',
                default => 'UNKNOWN',
            };

            Log::info('📱 Detected Payment Method', [
                'cleanNumber' => $cleanNumber,
                'prefix' => $prefix,
                'method' => $paymentMethod
            ]);

            // 3️⃣ Initiate payment
            $paymentRequest = [
                "reference" => (string) $reference,
                "subscriber" => [
                    "country" => "ZM",
                    "currency" => $currency,
                    "msisdn" => (int) $cleanNumber,
                ],
                "transaction" => [
                    "amount" => $amount,
                    "description" => $comment,
                    "id" => (string) $reference,
                ],
                "customer" => [
                    "first_name" => "Driver",
                    "last_name" => "TopUp",
                    "email" => "noemail@unka.com",
                    "mobile" => $cleanNumber,
                    "address" => "Zambia"
                ]
            ];

            $initResponse = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => $paymentApiKey,
                ])
                ->post("$paymentBaseUrl/merchant/v1/payments/", $paymentRequest);

            Log::debug("🧾 Payment initiation raw response", ['body' => $initResponse->body()]);

            if ($initResponse->failed()) {
                Log::error('❌ Payment initialization failed', ['response' => $initResponse->body()]);
                return response()->json(['error' => 'Payment request failed'], 500);
            }

            // ✅ Fix API typo: "transatcion" vs "transaction"
            $data = $initResponse->json('data');
            $transactionNode = $data['transaction'] ?? $data['transatcion'] ?? null;
            $transactionId = $transactionNode['id'] ?? $data['id'] ?? null;

            if (!$transactionId) {
                Log::warning("⚠️ Transaction ID missing in init response", ['body' => $initResponse->body()]);
                return response()->json(['error' => 'Missing transaction ID'], 500);
            }

            Log::info("💰 Payment initiated", ['transactionId' => $transactionId]);

            // 4️⃣ Insert transaction record
            $paymentRecordId = DB::connection('mysql')->table('payments')->insertGetId([
                'driver_phone' => $registeredNumber,
                'amount' => $amount,
                'transaction_id' => $transactionId,
                'momo_provider_id' => null,
                'payment_method' => $paymentMethod,
                'status' => 'INITIATED',
                'description' => $comment,
                'paid_to' => 'driver_wallet',
                'paid_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 5️⃣ Poll payment status
            $maxRetries = 30;
            $retryCount = 0;
            $status = 'INITIATED';

            while (true) {
                sleep(10);
                $retryCount++;

                $statusUrl = "$paymentBaseUrl/standard/v1/payments/$transactionId";
                Log::debug("🌍 Checking payment status", ['url' => $statusUrl]);

                try {
                    $statusResponse = Http::withOptions(['verify' => false])
                        ->withHeaders([
                            'Content-Type' => 'application/json',
                            'Authorization' => $paymentApiKey,
                        ])
                        ->get($statusUrl);

                    $body = $statusResponse->body();
                    Log::debug('Payment status raw response', ['body' => $body]);

                    if ($statusResponse->failed()) {
                        Log::warning("⚠️ Failed to fetch payment status for {$transactionId}", ['body' => $body]);
                        continue;
                    }

                    $statusData = $statusResponse->json('data');
                    $status = $statusData['transaction']['status']
                        ?? $statusData['transatcion']['status']
                        ?? $statusData['status']
                        ?? 'UNKNOWN';

                    Log::info("🔄 Payment status update", ['transactionId' => $transactionId, 'status' => $status]);

                    DB::connection('mysql')->table('payments')
                        ->where('id', $paymentRecordId)
                        ->update([
                            'status' => $status,
                            'updated_at' => now(),
                        ]);

                    if (in_array($status, ['TS', 'TF', 'SUCCESS', 'FAILED'])) {
                        DB::connection('mysql')->table('payments')
                            ->where('id', $paymentRecordId)
                            ->update([
                                'status' => in_array($status, ['TS', 'SUCCESS']) ? 'SUCCESS' : 'FAILED',
                                'paid_at' => in_array($status, ['TS', 'SUCCESS']) ? Carbon::now() : null,
                                'updated_at' => now(),
                            ]);
                        break;
                    }

                    if ($retryCount >= $maxRetries) {
                        DB::connection('mysql')->table('payments')
                            ->where('id', $paymentRecordId)
                            ->update([
                                'status' => 'FAILED',
                                'updated_at' => now(),
                            ]);
                        Log::warning("⏰ Payment pending too long — marking as failed", ['transactionId' => $transactionId]);
                        break;
                    }

                } catch (\Exception $e) {
                    Log::error("💥 Exception fetching payment status for {$transactionId}: " . $e->getMessage());
                    continue;
                }
            }

            // 6️⃣ Handle payment result
            if (in_array($status, ['TF', 'FAILED'])) {
                $this->sendSMS($paymentNumber, "Your top-up payment failed. Please try again.", "Unka Go");
                return response()->json(['error' => 'Payment failed or timed out'], 400);
            }

            if (in_array($status, ['TS', 'SUCCESS'])) {
                Log::info('✅ Payment successful. Proceeding with Onde top-up.', ['transactionId' => $transactionId]);

                $topupResponse = Http::withHeaders([
                    'Authorization' => $ondeApiKey,
                    'Content-Type' => 'application/json',
                ])->post("$ondeBaseUrl/driver/$driverId/topup", [
                    "money" => [
                        "amount" => $amount,
                        "currency" => $currency,
                    ],
                    "comment" => $comment,
                ]);

                if ($topupResponse->failed()) {
                    Log::error('❌ Onde API top-up failed', ['response' => $topupResponse->body()]);
                    $this->sendSMS($paymentNumber, "Your payment succeeded, but driver top-up failed. Please contact support.", "Unka Go");
                    return response()->json(['error' => 'Failed to create top-up'], 500);
                }

                $invoiceId = $topupResponse->json('invoiceId');

                $commitResponse = Http::withHeaders([
                    'Authorization' => $ondeApiKey,
                    'Content-Type' => 'application/json',
                ])->post("$ondeBaseUrl/driver/$driverId/commit", [
                    "invoiceId" => $invoiceId,
                ]);

                if ($commitResponse->failed()) {
                    Log::error('❌ Onde API commit failed', ['response' => $commitResponse->body()]);
                    $this->sendSMS($paymentNumber, "Your payment succeeded, but top-up confirmation failed. Please contact support.", "Unka Go");
                    return response()->json(['error' => 'Commit failed'], 500);
                }

                // ✅ Fetch updated wallet
                $walletBalance = 0;
                $walletResponse = Http::withHeaders([
                    'Authorization' => $ondeApiKey,
                    'Content-Type' => 'application/json',
                ])->get("$ondeBaseUrl/driver/$driverId");

                if ($walletResponse->ok()) {
                    $walletData = $walletResponse->json();
                    if (isset($walletData['wallet'][0]['amount'])) {
                        $walletBalance = $walletData['wallet'][0]['amount'];
                    }
                }

                $message = "Your top-up of K{$amount} was successful. Current wallet balance: K{$walletBalance}.";
                $this->sendSMS($paymentNumber, $message, "Unka Go");

                return response()->json([
                    'success' => true,
                    'message' => 'Top-up completed successfully!',
                    'driver' => $matchedDriver,
                    'invoiceId' => $invoiceId,
                    'walletBalance' => $walletBalance,
                ]);
            }

        } catch (\Exception $e) {
            Log::error('💥 Exception during top-up process', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function sendSMS($phone, $message, $title)
    {
        $smsApiUrl = "https://102.208.220.165:8086/api/SubmitSMS/";
         // Normalize phone number
    $recipient = $phone;
    if (str_starts_with($recipient, '+260')) {
        $recipient = '0' . substr($recipient, 4);
    } elseif (!str_starts_with($recipient, '0')) {
        $recipient = '0' . $recipient;
    }
        $payload = [
            "UId" => "74d70a3e-e5a6-4a7a-b10d-1ff329710a09",
            "ApiKey" => "C26mEEGltEDOP4qakS30Ef7tjU0BQMW4",
            "Recipient" => $recipient,
            "Message" => $message,
            "SenderId" => "Unka",
            "MessageTitle" => $title
        ];

        try {
            $response = Http::withOptions(['verify' => false])->post($smsApiUrl, $payload);
            if ($response->failed()) {
                Log::error("❌ SMS failed for {$recipient}: " . $response->body());
            } else {
                Log::info("📩 SMS sent successfully to {$recipient}");
            }
        } catch (\Exception $e) {
            Log::error("💥 SMS exception for {$recipient}: " . $e->getMessage());
        }
    }
}
