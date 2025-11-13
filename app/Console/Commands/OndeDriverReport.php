<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OndeDriverReport extends Command
{
    protected $signature = 'onde:driver-report';
    protected $description = 'Send hourly Onde driver registration report between 08:00 and 22:00';

    protected $recipients = [
        '0978817141'
    ];

    public function handle()
    {
        $now = Carbon::now();
        $hour = (int) $now->format('H');

        // Run only between 08:00 and 22:00
        if ($hour < 8 || $hour > 22) {
            Log::info("⏰ Skipping report at {$now->format('H:i')} (outside allowed hours)");
            return;
        }

        $lastHour = $now->copy()->subHour();

        // Registrations in the last hour
        $registrationsLastHour = DB::table('driver_onde')
            ->whereBetween('created_at', [$lastHour, $now])
            ->count();

        // Registrations today
        $registrationsToday = DB::table('driver_onde')
            ->whereDate('created_at', $now->toDateString())
            ->count();

        // Overall pending
        $overallPending = DB::table('driver_onde')
            ->whereIn('state', ['NOT_ACTIVATED', 'INVITED'])
            ->count();

        // Overall Active (split by vehicle type)
        $overallActiveVehicles = DB::table('driver_onde')
            ->where('state', 'ACTIVE')
            ->whereNotIn('vehicleType', ['MOTO', 'COURIER','BICYCLE'])
            ->count();

        $overallActiveDelivery = DB::table('driver_onde')
            ->where('state', 'ACTIVE')
            ->whereIn('vehicleType', ['MOTO', 'COURIER','BICYCLE'])
            ->count();

        $overallActiveTotal = $overallActiveVehicles + $overallActiveDelivery;

        // SMS Message
        $message = sprintf(
            "Unka Driver Report\n".
            "Time: %s\n".
            "Reg. (Last Hour): %d\n".
            "Reg. (Today): %d\n".
            "Overall Pending: %d\n".
            "Overall Active: %d\n".
            "Active Vehicles: %d\n".
            "Active Delivery: %d",
            $now->format('H:i'),
            $registrationsLastHour,
            $registrationsToday,
            $overallPending,
            $overallActiveTotal,
            $overallActiveVehicles,
            $overallActiveDelivery
        );

        foreach ($this->recipients as $recipient) {
            $this->sendSMS($recipient, $message);
        }

        Log::info("📤 Onde driver report sent successfully at {$now->format('H:i')}");
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
            "MessageTitle" => "Unka Driver Report"
        ];

        try {
            $response = Http::withOptions(['verify' => false])->post($smsApiUrl, $payload);

            if ($response->failed()) {
                Log::error("❌ SMS failed for {$phone}: " . $response->body());
            } else {
                Log::info("📩 Report SMS sent to {$phone}");
            }
        } catch (\Exception $e) {
            Log::error("💥 SMS exception for {$phone}: " . $e->getMessage());
        }
    }
}
