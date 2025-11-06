<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Orders;

class OndeUsageRevenueReport extends Command
{
    protected $signature = 'onde:usage-revenue-report';
    protected $description = 'Send hourly Unka usage revenue report';

    protected $recipients = ['0978817141','0979459414','0976290607','0980888133','0980888111'];

    protected $subscriptionPlans = ['10 SUBSCRIPTION','12.5 SUBSCRIPTION','8.0 SUBSCRIPTION'];

    public function handle()
    {
        $now = Carbon::now();
        $lastHour = $now->copy()->subHour();

        // Revenue Last Hour
        $revenueLastHour = $this->calculateRevenue($lastHour, $now);

        // Revenue Today
        $revenueToday = $this->calculateRevenue($now->copy()->startOfDay(), $now);

        // Revenue Yesterday from 00:00 to same hour as now
        $yesterdayStart = $now->copy()->subDay()->startOfDay();
        $yesterdayEnd = $yesterdayStart->copy()->addHours($now->hour); // same hour as now
        $revenueYesterday = $this->calculateRevenue($yesterdayStart, $yesterdayEnd);

        // Build SMS
        $message = sprintf(
            "Unka Usage Revenue Report\n".
            "Time: %s\n".
            "Revenue (Last Hour): K%.2f\n".
            "Revenue (Today): K%.2f\n".
            "Revenue (Y-day Same Time): K%.2f",
            $now->format('H:i'),
            $revenueLastHour,
            $revenueToday,
            $revenueYesterday
        );

        foreach ($this->recipients as $recipient) {
            $this->sendSMS($recipient, $message);
        }

        Log::info("📤 Unka Usage Revenue report sent at {$now->format('H:i')}");
    }

    protected function calculateRevenue($startDate, $endDate)
    {
        $subOrders = Orders::where('order_status', 'FINISHED_PAID')
            ->whereIn('driver_rate_plan', $this->subscriptionPlans)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return $subOrders->sum(function($order) {
            $rate = floatval(preg_replace('/[^0-9.]/','',$order->driver_rate_plan));
            return $rate > 0 ? ($order->final_cost * ($rate / 100)) : 0;
        });
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
            "MessageTitle" => "Unka Usage Revenue"
        ];

        try {
            $response = Http::withOptions(['verify' => false])->post($smsApiUrl, $payload);

            if ($response->failed()) {
                Log::error("❌ SMS failed for {$phone}: " . $response->body());
            } else {
                Log::info("📩 Revenue report SMS sent to {$phone}");
            }
        } catch (\Exception $e) {
            Log::error("💥 SMS exception for {$phone}: " . $e->getMessage());
        }
    }
}
