<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\DriverPayment;

class CheckDriverPaymentStatus extends Command
{
    protected $signature = 'driver:check-payments';
    protected $description = 'Check pending driver payment statuses';

    public function handle()
    {
        $paymentBaseUrl = "https://momo.zedmobile.net:4500/Api";
        $pending = DriverPayment::where('status', 'PENDING')->get();

        foreach ($pending as $payment) {
            $response = Http::withOptions(['verify' => false])
                ->get("$paymentBaseUrl/standard/v1/payments/{$payment->transaction_id}");

            if ($response->failed()) {
                Log::warning("Failed to fetch status for {$payment->transaction_id}");
                continue;
            }

            $status = $response->json('data.transatcion.status');

            if ($status === 'TS') {
                $payment->status = 'SUCCESS';
                $payment->save();
                Log::info("✅ Payment {$payment->transaction_id} confirmed as successful.");

                // Optionally call Onde top-up here or queue a Job
            } elseif ($status === 'TF') {
                $payment->status = 'FAILED';
                $payment->save();
                Log::warning("❌ Payment {$payment->transaction_id} failed.");
            }
        }

        return 0;
    }
}
