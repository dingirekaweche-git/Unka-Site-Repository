<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckPendingCustomerPayments extends Command
{
    protected $signature = 'payments:check-customer';
    protected $description = 'Check pending customer_wallet payments and update status, adjust wallet balance and send SMS';

    public function handle()
    {
        $paymentBaseUrl = "http://102.208.220.62:4500/Api";
        $ondeApiKey = '8a1421ed-9b7a-4931-b2c8-06df542ef62a';
        $companyId = 'a0d7d87b-231f-4736-ae30-2af6819525e4';
        $ondeBaseUrl = "https://api.onde.app/v1/merchant/$companyId";

        // Fetch all pending customer_wallet payments
        $pendingPayments = DB::connection('mysql')
            ->table('payments')
            ->where('paid_to', 'customer_wallet')
            ->where('status', 'TIP')
            ->get();

        foreach ($pendingPayments as $payment) {
            $transactionId = $payment->transaction_id;
            $statusUrl = "$paymentBaseUrl/standard/v1/payments/$transactionId";

            try {
                $statusResponse = Http::withOptions(['verify' => false, 'timeout' => 10])
                    ->get($statusUrl);

                if ($statusResponse->failed()) {
                    Log::warning("⚠️ Failed to fetch payment status for transaction {$transactionId}");
                    continue;
                }

                $status = $statusResponse->json('data.transatcion.status') ?? 'TIP';

                if ($status !== $payment->status) {
                    DB::connection('mysql')->table('payments')
                        ->where('id', $payment->id)
                        ->update([
                            'status' => $status,
                            'updated_at' => now()
                        ]);

                    Log::info("🔄 Payment status updated", [
                        'transactionId' => $transactionId,
                        'status' => $status
                    ]);
                }

                if ($status === 'TS') {
                    // Payment successful: adjust customer wallet
                    $customerPhone = '+260' . ltrim($payment->driver_phone, '0');

                    // Fetch customer wallet ID from Onde API
                    $walletsResponse = Http::withHeaders([
                        'Authorization' => $ondeApiKey,
                        'Content-Type' => 'application/json'
                    ])->get("$ondeBaseUrl/wallet");

                    if ($walletsResponse->ok()) {
                        $wallets = $walletsResponse->json();
                        $matchedWallet = collect($wallets)->first(function ($wallet) use ($customerPhone) {
                            return substr($wallet['phone'], -9) === substr($customerPhone, -9);
                        });

                        if ($matchedWallet) {
                            $walletId = $matchedWallet['walletId'];

                            // Top-up customer wallet
                            $topupResponse = Http::withHeaders([
                                'Authorization' => $ondeApiKey,
                                'Content-Type' => 'application/json',
                            ])->post("$ondeBaseUrl/wallet/$walletId/topup", [
                                "money" => [
                                    "amount" => $payment->amount * 100,
                                    "currency" => 'ZMW',
                                ],
                                "comment" => "Customer wallet top-up from completed payment"
                            ]);

                            if ($topupResponse->ok()) {
                                $invoiceId = $topupResponse->json('invoiceId');

                                // Commit top-up
                                Http::withHeaders([
                                    'Authorization' => $ondeApiKey,
                                    'Content-Type' => 'application/json',
                                ])->post("$ondeBaseUrl/wallet/$walletId/commit", [
                                    "invoiceId" => $invoiceId,
                                ]);

                                // Fetch updated wallet balance
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

                                // Send success SMS
                                $this->sendSMS($customerPhone, "Your wallet top-up of K{$payment->amount} was successful. Current balance: K{$walletBalance}.", "Unka Go");
                            }
                        }
                    }
                }

                if ($status === 'TF') {
                    $customerPhone = '+260' . ltrim($payment->driver_phone, '0');
                    $this->sendSMS($customerPhone, "Your wallet top-up of K{$payment->amount} failed. Please try again.", "Unka Go");
                }

            } catch (\Exception $e) {
                Log::error("💥 Exception checking payment {$transactionId}: " . $e->getMessage());
                continue;
            }
        }

        $this->info('✅ Pending customer_wallet payments checked.');
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
