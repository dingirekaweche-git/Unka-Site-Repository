<?php

namespace App\Jobs;

use App\Models\DriverPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProcessDriverPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payment;
    public $timeout = 300; // 5 minutes max

    public function __construct(DriverPayment $payment)
    {
        $this->payment = $payment;
    }

    public function handle()
    {
        $payment = $this->payment;

        $paymentBaseUrl = "http://10.10.99.107:4500/Api";
        $ondeBaseUrl = "https://api.onde.app/v1/company/019f2ec4-35ed-42b4-bd51-9cdbd85ac8d6";
        $ondeApiKey = '96473ff0-f016-4496-8722-2022cfcf6a27';
        $currency = $payment->currency;
        $comment = $payment->comment ?? "Driver Float Top-up";

        $startTime = Carbon::now();
        $status = 'pending';

        // Poll payment status
        while (true) {
            sleep(10);

            $statusResponse = Http::withOptions(['verify' => false])
                ->get("$paymentBaseUrl/standard/v1/payments/{$payment->transaction_id}");

            if ($statusResponse->failed()) {
                Log::warning("⚠️ Failed to fetch payment status for {$payment->transaction_id}");
                continue;
            }

            $transactionData = $statusResponse->json('data.transatcion');

            $status = $transactionData['status'] ?? 'pending';
            $momoProviderId = $transactionData['momo_provider_id'] ?? null;

            Log::info("🔄 Payment status update", ['transactionId' => $payment->transaction_id, 'status' => $status]);

            $payment->update([
                'status' => $status === 'TS' ? 'success' : ($status === 'TF' ? 'failed' : 'pending'),
                'momo_provider_id' => $momoProviderId,
            ]);

            // Stop polling if success or fail
            if (in_array($status, ['TS','TF'])) break;

            if ($startTime->diffInSeconds(Carbon::now()) >= $this->timeout) {
                $status = 'TF';
                $payment->update(['status' => 'failed']);
                Log::warning("⏰ Payment pending too long, marking as failed", ['transactionId' => $payment->transaction_id]);
                break;
            }
        }

        if ($payment->status === 'success') {
            // Proceed with Onde top-up
            $response = Http::withHeaders([
                'Authorization' => $ondeApiKey,
                'Content-Type' => 'application/json',
            ])->get("$ondeBaseUrl/driver");

            if ($response->failed()) {
                Log::error('❌ Onde API failed to fetch drivers', ['response' => $response->body()]);
                return;
            }

            $drivers = $response->json();
            $matchedDriver = collect($drivers)->first(function ($driver) use ($payment) {
                $driverPhone = preg_replace('/\D/', '', $driver['phone']);
                $inputPhone = preg_replace('/\D/', '', $payment->registered_number);
                return substr($driverPhone, -9) === substr($inputPhone, -9);
            });

            if (!$matchedDriver) {
                Log::warning('⚠️ No driver found', ['input' => $payment->registered_number]);
                return;
            }

            $driverId = $matchedDriver['driverId'];

            // Top-up
            $topupResponse = Http::withHeaders([
                'Authorization' => $ondeApiKey,
                'Content-Type' => 'application/json',
            ])->post("$ondeBaseUrl/driver/$driverId/topup", [
                "money" => [
                    "amount" => $payment->amount,
                    "currency" => $currency,
                ],
                "comment" => $comment,
            ]);

            if ($topupResponse->failed()) {
                Log::error('❌ Onde API top-up failed', ['response' => $topupResponse->body()]);
                return;
            }

            $invoiceId = $topupResponse->json('invoiceId');
            $payment->update(['invoice_id' => $invoiceId]);

            // Commit top-up
            $commitResponse = Http::withHeaders([
                'Authorization' => $ondeApiKey,
                'Content-Type' => 'application/json',
            ])->post("$ondeBaseUrl/driver/$driverId/commit", [
                "invoiceId" => $invoiceId,
            ]);

            if ($commitResponse->failed()) {
                Log::error('❌ Onde API commit failed', ['response' => $commitResponse->body()]);
                return;
            }

            // Send SMS
            $this->sendSMS($payment->payment_number, "Your top-up of K{$payment->amount} was successful!", "Unka Go");
        }
    }

    private function sendSMS($phone, $message, $title)
    {
        $smsApiUrl = "https://102.208.220.165:8086/api/SubmitSMS/";
        $payload = [
            "UId" => "74d70a3e-e5a6-4a7a-b10d-1ff329710a09",
            "ApiKey" => "C26mEEGltEDOP4qakS30Ef7tjU0BQMW4",
            "Recipient" => str_replace('+260', '0', $phone),
            "Message" => $message,
            "SenderId" => "Unka",
            "MessageTitle" => $title
        ];

        try {
            $response = Http::withOptions(['verify' => false])->post($smsApiUrl, $payload);
            if ($response->failed()) {
                Log::error("❌ SMS failed for {$phone}: " . $response->body());
            } else {
                Log::info("📩 SMS sent successfully to {$phone}");
            }
        } catch (\Exception $e) {
            Log::error("💥 SMS exception for {$phone}: " . $e->getMessage());
        }
    }
}
