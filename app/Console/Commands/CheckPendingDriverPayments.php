<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckPendingDriverPayments extends Command
{
    protected $signature = 'payments:check-driver';
    protected $description = 'Check pending driver_wallet payments and update status, top-up wallet if successful';

    public function handle()
    {
        $paymentBaseUrl = "http://102.208.220.62:4500/Api";
        $companyId = '591f0997-20a3-4156-8463-97dc793bc002';
        $ondeBaseUrl = "https://api.onde.app/v1/company/$companyId";
        $ondeApiKey = '017bea83-152c-4981-84a1-5c6ed2e5d773';

        $pendingPayments = DB::connection('mysql')
            ->table('payments')
            ->where('paid_to', 'driver_wallet')
            ->where('status', 'TIP')
            ->get();

        foreach ($pendingPayments as $payment) {
            $transactionId = $payment->transaction_id;
            $statusUrl = "$paymentBaseUrl/standard/v1/payments/$transactionId";

            try {
                // Fetch current payment status
                $statusResponse = Http::withOptions(['verify' => false, 'timeout' => 10])->get($statusUrl);
                if ($statusResponse->failed()) {
                    Log::warning("⚠️ Failed to fetch payment status for transaction {$transactionId}");
                    continue;
                }

                $status = $statusResponse->json('data.transatcion.status') ?? 'TIP';

                // Update DB if status changed
                if ($status !== $payment->status) {
                    DB::connection('mysql')->table('payments')->where('id', $payment->id)
                        ->update(['status' => $status, 'updated_at' => now()]);
                    Log::info("🔄 Payment status updated", ['transactionId' => $transactionId, 'status' => $status]);
                }

                // Normalize phone
                $driverPhone = preg_replace('/\D/', '', $payment->driver_phone);

                if ($status === 'TS') {
                    // Fetch driver list from Onde API
                    $driversResponse = Http::withHeaders([
                        'Authorization' => $ondeApiKey,
                        'Content-Type' => 'application/json'
                    ])->get("$ondeBaseUrl/driver");

                    if ($driversResponse->ok()) {
                        $drivers = $driversResponse->json();
                        $matchedDriver = collect($drivers)->first(function ($driver) use ($driverPhone) {
                            return substr(preg_replace('/\D/', '', $driver['phone']), -9) === substr($driverPhone, -9);
                        });

                        if ($matchedDriver) {
                            $driverId = $matchedDriver['driverId'];

                            // Top-up driver wallet
                            $topupResponse = Http::withHeaders([
                                'Authorization' => $ondeApiKey,
                                'Content-Type' => 'application/json',
                            ])->post("$ondeBaseUrl/driver/$driverId/topup", [
                                "money" => [
                                    "amount" => $payment->amount,
                                    "currency" => "ZMW",
                                ],
                                "comment" => "Top-up from completed payment"
                            ]);

                            if ($topupResponse->ok()) {
                                $invoiceId = $topupResponse->json('invoiceId');

                                // Commit top-up
                                Http::withHeaders([
                                    'Authorization' => $ondeApiKey,
                                    'Content-Type' => 'application/json',
                                ])->post("$ondeBaseUrl/driver/$driverId/commit", ["invoiceId" => $invoiceId]);

                                // Fetch updated wallet balance
                                $walletBalance = 0;
                                $walletResponse = Http::withHeaders([
                                    'Authorization' => $ondeApiKey,
                                    'Content-Type' => 'application/json',
                                ])->get("$ondeBaseUrl/driver/$driverId");

                                if ($walletResponse->ok()) {
                                    $walletData = $walletResponse->json();
                                    $walletBalance = $walletData['wallet'][0]['amount'] ?? 0;
                                }

                                // Send success SMS
                                $this->sendSMS($payment->driver_phone, "Your top-up of K{$payment->amount} was successful. Current wallet balance: K{$walletBalance}.", "Unka Go");
                            }
                        }
                    }

                } elseif ($status === 'TF') {
                    // Failed payment
                    $this->sendSMS($payment->driver_phone, "Your top-up payment of K{$payment->amount} failed. Please try again.", "Unka Go");
                }

            } catch (\Exception $e) {
                Log::error("💥 Exception checking payment {$transactionId}: " . $e->getMessage());
                continue;
            }
        }

        $this->info('✅ Pending driver_wallet payments checked.');
    }

    private function sendSMS($phone, $message, $title)
    {
        $smsApiUrl = "https://102.208.220.165:8086/api/SubmitSMS/";

        // Normalize phone number for SMS
        $recipient = preg_replace('/\D/', '', $phone);
        if (str_starts_with($recipient, '260')) {
            $recipient = '0' . substr($recipient, 3);
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
