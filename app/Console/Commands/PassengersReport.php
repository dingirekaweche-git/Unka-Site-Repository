<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PassengersReport extends Command
{
    protected $signature = 'onde:passengers-report';
    protected $description = 'Send hourly Onde passengers registration report between 08:00 and 22:00';

      protected $recipients = ['0978817141','0979459414','0976290607','0980888133','0980888111','0980777888','0980888666','0980888114'];
 
    public function handle()
    {
        $now = Carbon::now();
        $hour = (int) $now->format('H');

        // Only run between 08:00 and 22:00
        if ($hour < 8 || $hour > 22) {
            Log::info("⏰ Skipping report at {$now->format('H:i')} (outside allowed hours)");
            return;
        }

        $lastHour = $now->copy()->subHour();

        // ✅ Hourly total
        $hourlyTotal = DB::table('passengers')
            ->whereBetween('created_at', [$lastHour, $now])
            ->count();

        // ✅ Daily total
        $dailyTotal = DB::table('passengers')
            ->whereDate('created_at', $now->toDateString())
            ->count();

        // ✅ All-time total
        $allTimeTotal = DB::table('passengers')->count();

        // ✅ SMS text
        $message = sprintf(
            "Unka Passenger Report\nTime: %s\nNew Passengers (Last Hour): %d\nNew Passengers (Today): %d\nTotal Passengers (Overall): %d",
            $now->format('H:i'),
            $hourlyTotal,
            $dailyTotal,
            $allTimeTotal
        );

        foreach ($this->recipients as $recipient) {
            $this->sendSMS($recipient, $message);
        }

        Log::info("📤 Onde driver report sent at {$now->format('H:i')}");
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
