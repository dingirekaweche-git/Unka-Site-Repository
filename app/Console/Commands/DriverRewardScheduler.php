<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Str;


class DriverRewardScheduler extends Command
{
    protected $signature = 'onde:driver-reward';
    protected $description = 'Grant daily rewards to eligible drivers who completed paid rides and notify via SMS.';

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

        // 2️⃣ Find eligible driver orders
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $orders = Orders::where('order_status', 'FINISHED_PAID')
            ->whereNull('driver_reward_data')
            ->whereBetween('created_at', [$today, $tomorrow])
            ->where('driver_phone', 'like', '+26098%')
            ->get();

        if ($orders->isEmpty()) {
         
            return;
        }

        Log::info("📋 Found {$orders->count()} eligible finished paid orders for drivers.");

        foreach ($orders as $order) {
            $phone = $order->driver_phone;

            // Avoid duplicate rewards per day
            $alreadyRewarded = Orders::whereDate('driver_reward_data', $today)
                ->where('driver_phone', $phone)
                ->exists();

            if ($alreadyRewarded) {
                Log::info("⏩ Skipping {$phone} (already rewarded today)");
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
                    Log::error("❌ Driver reward API failed for {$phone}: " . $response->body());
                    continue;
                }

                $data = $response->json();
             
                // Update order as rewarded
                $order->update([
                    'driver_reward_data' => now(),
                ]);

                // 3️⃣ Send SMS notification
                $smsApiUrl = "https://102.208.220.165:8086/api/SubmitSMS/";
                $smsPayload = [
                    "UId" => "74d70a3e-e5a6-4a7a-b10d-1ff329710a09",
                    "ApiKey" => "C26mEEGltEDOP4qakS30Ef7tjU0BQMW4",
                    "Recipient" => str_replace('+260', '0', $phone),
                    "Message" => "Congratulations! For completing a ride as a driver with Unka Go, 1GB ZedMobile data has been awarded.",
                    "SenderId" => "Unka",
                    "MessageTitle" => "Unka Go Driver Reward"
                ];

                try {
                    $smsResponse = Http::withOptions(['verify' => false])
                        ->post($smsApiUrl, $smsPayload);

                    if ($smsResponse->failed()) {
                        Log::error("❌ SMS failed for driver {$phone}: " . $smsResponse->body());
                    } else {
                      
                    }
                } catch (\Exception $e) {
                    Log::error("💥 SMS exception for driver {$phone}: " . $e->getMessage());
                }

            } catch (\Exception $e) {
                Log::error("💥 Exception for driver {$phone}: " . $e->getMessage());
            }
        }

       
    }
}
