<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Orders;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CustomerRewardScheduler extends Command
{
    protected $signature = 'onde:customer-reward';
    protected $description = 'Grant daily rewards to eligible customers who completed paid rides and notify via SMS.';

    public function handle()
    {
      
        $baseUrl = 'https://openlite.zedmobile.net';
        $username = 'production@unkago.com';
        $password = 'zedmobilegw@1234';

        // 1️⃣ Login to get token dynamically
        try {
            $loginResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$baseUrl}/api/auth/login", [
                "username" => $username,
                "password" => $password,
            ]);

            if ($loginResponse->failed()) {
                Log::error('❌ Login failed: ' . $loginResponse->body());
                return;
            }

            $tokenData = $loginResponse->json();
            $authToken = $tokenData['token'] ?? null;

            if (!$authToken) {
                Log::error('❌ Token missing in login response.', ['response' => $tokenData]);
                return;
            }

          
        } catch (\Exception $e) {
            Log::error('💥 Login exception: ' . $e->getMessage());
            return;
        }

        // 2️⃣ Find eligible orders
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $orders = Orders::where('order_status', 'FINISHED_PAID')
            ->whereNull('customer_reward_data')
            ->whereBetween('created_at', [$today, $tomorrow])
            ->where('passenger_phone', 'like', '+26098%')
            ->get();

        if ($orders->isEmpty()) {
           
            return;
        }

     
        foreach ($orders as $order) {
            $phone = $order->passenger_phone;

            // Avoid duplicate rewards per day
            $alreadyRewarded = Orders::whereDate('customer_reward_data', $today)
                ->where('passenger_phone', $phone)
                ->exists();

            if ($alreadyRewarded) {
           
                continue;
            }

            // Generate a unique transaction ID
            $outTransactionId = 'TXN-' . uniqid() . '-' . strtoupper(Str::random(4));

            $payload = [
                "offerId" => 206014,
                "phoneId" => str_replace('+260', '0', $phone),
                "busiCode" => 1001,
                "dealerUserPhone" => "0980019457",
                "outTransactionId" => $outTransactionId
            ];

          
            try {
                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$authToken}",
                    'Content-Type' => 'application/json',
                ])->post("{$baseUrl}/openLite/ussd/dealerOrder", $payload);

                if ($response->failed()) {
                    Log::error("❌ Reward API failed for {$phone}: " . $response->body());
                    continue;
                }

                $data = $response->json();
             
                // Update order as rewarded
                $order->update([
                    'customer_reward_data' => now(),
                ]);

                // 3️⃣ Send SMS notification
                $smsApiUrl = "https://102.208.220.165:8086/api/SubmitSMS/";
                $smsPayload = [
                    "UId" => "74d70a3e-e5a6-4a7a-b10d-1ff329710a09",
                    "ApiKey" => "C26mEEGltEDOP4qakS30Ef7tjU0BQMW4",
                    "Recipient" => str_replace('+260', '0', $phone),
                    "Message" => "Congratulations! For completing a ride with Unka Go, 1GB ZedMobile data has been awarded.",
                    "SenderId" => "Unka",
                    "MessageTitle" => "Unka Go Reward"
                ];

                try {
                    $smsResponse = Http::withOptions(['verify' => false])
                        ->post($smsApiUrl, $smsPayload);

                    if ($smsResponse->failed()) {
                        Log::error("❌ SMS failed for {$phone}: " . $smsResponse->body());
                    } else {
                    }
                } catch (\Exception $e) {
                    Log::error("💥 SMS exception for {$phone}: " . $e->getMessage());
                }

            } catch (\Exception $e) {
                Log::error("💥 Exception for {$phone}: " . $e->getMessage());
            }
        }

    }
}
