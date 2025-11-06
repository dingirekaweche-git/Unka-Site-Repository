<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncOndeDrivers extends Command
{
    protected $signature = 'onde:sync-drivers';
    protected $description = 'Sync Onde drivers and send SMS notifications based on their state';

    public function handle()
    {
        $companyId = '591f0997-20a3-4156-8463-97dc793bc002';
        $token = '017bea83-152c-4981-84a1-5c6ed2e5d773';
        $apiUrl = "https://api.onde.app/v1/company/{$companyId}/driver";

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->get($apiUrl);

            if (!$response->successful()) {
                Log::error('❌ Failed to fetch Onde drivers: ' . $response->status());
                return;
            }

            $data = $response->json();
            $drivers = $data['data'] ?? $data ?? [];
            $driverCount = is_array($drivers) ? count($drivers) : 0;
            Log::info("✅ Onde Sync: {$driverCount} drivers fetched from API.");

            if ($driverCount === 0) {
                Log::warning('⚠️ No drivers returned from Onde API.');
                return;
            }

            $inserted = 0;
            $updated = 0;
            $apiDriverIds = []; // Collect all driverIds from API

            foreach ($drivers as $driver) {
                $driverId = $driver['driverId'] ?? null;
                $companyId = $driver['companyId'] ?? $companyId;
                $phone = $driver['phone'] ?? null;
                $state = $driver['state'] ?? 'UNKNOWN';

                $car = $driver['car'] ?? [];
                $boardNumber = $car['boardNumber'] ?? null;

                $fullName = $driver['fullName'] ?? $driver['name'] ?? ($phone ?? 'Unknown');

                if (!$driverId || !$phone) {
                    Log::warning("⚠️ Skipping driver with missing ID or phone: " . json_encode($driver));
                    continue;
                }

                $apiDriverIds[] = $driverId; // Add to API driver list

                $existing = DB::table('driver_onde')->where('driverId', $driverId)->first();

                if ($existing) {
                    DB::table('driver_onde')->where('driverId', $driverId)->update([
                        'fullName' => $fullName,
                        'phone' => $phone,
                        'state' => $state,
                        'boardNumber' => $boardNumber,
                        'updated_at' => now(),
                    ]);
                    $updated++;
                } else {
                    DB::table('driver_onde')->insert([
                        'driverId' => $driverId,
                        'companyId' => $companyId,
                        'fullName' => $fullName,
                        'phone' => $phone,
                        'state' => $state,
                        'boardNumber' => $boardNumber,
                        'invited_message_sent' => false,
                        'active_message_sent' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $inserted++;
                } 

                $name = $fullName ?: 'Driver';

                if ($state === 'NOT_ACTIVATED' && empty($existing?->invited_message_sent)) {
                    $message = "Hi {$name}, your driver activation has been initiated. Please complete your details for activation within 1 hour.";
                    $this->sendSMS($phone, $message);
                    DB::table('driver_onde')->where('driverId', $driverId)
                        ->update(['invited_message_sent' => true]);
                }

                if ($state === 'ACTIVE' && empty($existing?->active_message_sent)) {
                    $message = "Hi {$name}, your driver account has been approved. You can now login and start working.";
                    $this->sendSMS($phone, $message);
                    DB::table('driver_onde')->where('driverId', $driverId)
                        ->update(['active_message_sent' => true]);
                }
            }

            // ✅ Delete drivers in DB not present in Onde API
            $deleted = DB::table('driver_onde')
                ->whereNotIn('driverId', $apiDriverIds)
                ->delete();

            Log::info("✅ Onde Sync completed: Inserted {$inserted}, Updated {$updated}, Deleted {$deleted} drivers.");

        } catch (\Exception $e) {
            Log::error("💥 Onde sync exception: " . $e->getMessage());
        }
    }

    protected function sendSMS($phone, $message)
    {
        $smsApiUrl = "https://102.208.220.165:8086/api/SubmitSMS/";
        $payload = [
            "UId" => "74d70a3e-e5a6-4a7a-b10d-1ff329710a09",
            "ApiKey" => "C26mEEGltEDOP4qakS30Ef7tjU0BQMW4",
            "Recipient" => str_replace('+260', '0', $phone),
            "Message" => $message,
            "SenderId" => "Unka",
            "MessageTitle" => "Unka Driver Update"
        ];

        try {
            $smsResponse = Http::withOptions(['verify' => false])->post($smsApiUrl, $payload);

            if ($smsResponse->failed()) {
                Log::error("❌ SMS failed for {$phone}: " . $smsResponse->body());
            } else {
                Log::info("📩 SMS sent successfully to {$phone}");
            }
        } catch (\Exception $e) {
            Log::error("💥 SMS exception for {$phone}: " . $e->getMessage());
        }
    }
}
