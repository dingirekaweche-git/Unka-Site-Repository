<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function topupCustomerWallet(Request $request)
    {
        $request->validate([
            'registeredNumber' => 'required|string',  // Driver number
            'paymentNumber' => 'required|string',     // Customer MoMo number
            'amount' => 'required|numeric|min:1',
        ]);

        $registeredNumber = $request->registeredNumber;
        $paymentNumber = $request->paymentNumber;
        $amount = $request->amount;
        $paymentAmount = $amount; // scale amount for API
        $currency = 'ZMW';
        $comment = "Customer wallet top-up from {$paymentNumber}";

        $companyId = 'a0d7d87b-231f-4736-ae30-2af6819525e4';
        $ondeBaseUrl = "https://api.onde.app/v1/merchant/$companyId";
        $ondeApiKey = '8a1421ed-9b7a-4931-b2c8-06df542ef62a';
        $paymentBaseUrl = "http://102.208.220.62:4500/Api";
        $reference = time();

        try {
            // 1️⃣ CHECK DRIVER FIRST
            $response = Http::withHeaders([
                'Authorization' => $ondeApiKey,
                'Content-Type' => 'application/json',
            ])->get("$ondeBaseUrl/wallet");

            if ($response->failed()) {
                Log::error('❌ Onde API failed to fetch drivers', ['response' => $response->body()]);
                return response()->json(['error' => 'Failed to fetch drivers'], 500);
            }

            $wallets = $response->json();
            $matchedDriver = collect($wallets)->first(function ($wallet) use ($registeredNumber) {
                $driverPhone = preg_replace('/\D/', '', $wallet['phone']);
                $inputPhone = preg_replace('/\D/', '', $registeredNumber);
                return substr($driverPhone, -9) === substr($inputPhone, -9);
            });

            if (!$matchedDriver) {
                Log::warning('⚠️ No driver found for number', ['input' => $registeredNumber]);
                return response()->json(['error' => 'Driver not found'], 404);
            }

            $walletId = $matchedDriver['walletId'];
            Log::info("✅ Driver verified before payment", ['walletId' => $walletId]);

            // 2️⃣ INITIATE PAYMENT
            $cleanNumber = preg_replace('/\D/', '', $paymentNumber);
            if (str_starts_with($cleanNumber, '0')) {
                $cleanNumber = '260' . substr($cleanNumber, 1);
            } elseif (!str_starts_with($cleanNumber, '260')) {
                $cleanNumber = '260' . $cleanNumber;
            }
            $prefix = substr($cleanNumber, 0, 5);
            $paymentMethod = match ($prefix) {
                '26098', '26078' => 'ZEDMOBILE',
                '26097', '26050', '26077' => 'AIRTEL',
                '26096', '26076' => 'MTN',
                '26095', '26075' => 'ZAMTEL',
                default => 'UNKNOWN',
            };

            $paymentRequest = [
                "reference" => (string) $reference,
                "subscriber" => [
                    "country" => "ZM",
                    "currency" => $currency,
                    "msisdn" => (int) preg_replace('/\D/', '', $paymentNumber),
                ],
                "transaction" => [
                    "amount" => $paymentAmount,
                    "description" => $comment,
                    "id" => (string) $reference,
                ],
                "customer" => [
                    "first_name" => $registeredNumber,
                    "last_name" => $registeredNumber,
                    "email" => "noemail@unka.com",
                    "mobile" => $paymentNumber,
                    "address" => "Zambia"
                ]
            ];

            $initResponse = Http::withOptions([
                'verify' => false,
                'timeout' => 30,
                'connect_timeout' => 15,
            ])->post("$paymentBaseUrl/merchant/v1/payments/", $paymentRequest);

            if ($initResponse->failed()) {
                Log::error('❌ Payment initialization failed', ['response' => $initResponse->body()]);
                return response()->json(['error' => 'Payment request failed'], 500);
            }

            $transactionData = $initResponse->json('data.transatcion') ?? [];
            $transactionId = $transactionData['id'] ?? null;

            if (!$transactionId) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment requires PIN/OTP. Follow the prompt on your phone.',
                    'transactionReference' => $reference
                ]);
            }

            Log::info("💰 Payment initiated", ['transactionId' => $transactionId]);

            // 3️⃣ Insert transaction record into DB using mysql connection
            $paymentRecordId = DB::connection('mysql')->table('payments')->insertGetId([
               'payment_number' => $paymentNumber,
                'driver_phone' => $registeredNumber,
                'amount' => $amount,
                'customer_name' => $registeredNumber, // ✅ Added
                'transaction_id' => $transactionId,
                'momo_provider_id' => null,
                'payment_method' => $paymentMethod,
                'status' => 'INITIATED',
                'description' => $comment,
                'paid_to' => 'customer_wallet',
                'paid_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info("📄 Payment record created in DB", ['paymentRecordId' => $paymentRecordId]);

            // 4️⃣ POLL PAYMENT STATUS UNTIL COMPLETION
            $startTime = Carbon::now();
            $status = 'TIP'; // Transaction in progress

            while (true) {
                sleep(5);

                try {
                    $statusResponse = Http::withOptions(['verify' => false, 'timeout' => 10])
                        ->get("$paymentBaseUrl/standard/v1/payments/$transactionId");
                } catch (\Exception $e) {
                    Log::warning("⚠️ Failed to fetch payment status: " . $e->getMessage());
                    continue;
                }

                  $transactionNode = $statusResponse->json('data.transaction') ?? $statusResponse->json('data.transatcion') ?? [];
                $status = $transactionNode['status'] ?? 'TIP';
                $momoProviderId = $transactionNode['momo_provider_id'] ?? null;

                DB::connection('mysql')->table('payments')->where('id', $paymentRecordId)
                    ->update([
                        'status' => $status,
                        'momo_provider_id' => $momoProviderId,
                        'updated_at' => now()
                    ]);

                Log::info("🔄 Payment status updated", [
                    'transactionId' => $transactionId,
                    'status' => $status,
                    'momo_provider_id' => $momoProviderId
                ]);

                Log::info("🔄 Payment status update", ['transactionId' => $transactionId, 'status' => $status]);

                if ($status === 'TS' || $status === 'TF') break;

                if ($startTime->diffInMinutes(Carbon::now()) >= 5) {
                    $status = 'TF';
                    DB::connection('mysql')->table('payments')->where('id', $paymentRecordId)
                        ->update(['status' => 'TF']);
                    break;
                }
            }

            // 5️⃣ HANDLE FINAL PAYMENT STATUS
            if ($status === 'TF') {
                $this->sendSMS($paymentNumber, "Your top-up payment failed. Please try again.", "Unka Go");
                return response()->json(['error' => 'Payment failed or timed out'], 400);
            }

            if ($status === 'TS') {
                Log::info('✅ Payment successful. Proceeding with Onde top-up.', ['transactionId' => $transactionId]);

                // 6️⃣ CREATE DRIVER TOP-UP
                $topupResponse = Http::withHeaders([
                    'Authorization' => $ondeApiKey,
                    'Content-Type' => 'application/json',
                ])->post("$ondeBaseUrl/wallet/$walletId/topup", [
                    "money" => [
                        "amount" => $paymentAmount * 100,
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

                // 7️⃣ COMMIT TOP-UP
                $commitResponse = Http::withHeaders([
                    'Authorization' => $ondeApiKey,
                    'Content-Type' => 'application/json',
                ])->post("$ondeBaseUrl/wallet/$walletId/commit", [
                    "invoiceId" => $invoiceId,
                ]);

                if ($commitResponse->failed()) {
                    Log::error('❌ Onde API commit failed', ['response' => $commitResponse->body()]);
                    $this->sendSMS($paymentNumber, "Your payment succeeded, but top-up confirmation failed. Please contact support.", "Unka Go");
                    return response()->json(['error' => 'Commit failed'], 500);
                }

                // 8️⃣ FETCH UPDATED WALLET BALANCE
                $walletResponse = Http::withHeaders([
                    'Authorization' => $ondeApiKey,
                    'Content-Type' => 'application/json',
                ])->get("$ondeBaseUrl/wallet/$walletId");

                $walletBalance = 0;
                if ($walletResponse->ok()) {
                    $walletData = $walletResponse->json();
                    if (isset($walletData['balance'][0]['amount'])) {
                        $walletBalance = $walletData['balance'][0]['amount'] / 100;
                    }
                }

                // 9️⃣ SEND SUCCESS SMS
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

    // Helper: Send SMS
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
