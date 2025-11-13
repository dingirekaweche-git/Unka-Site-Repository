<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OndeOrderReport extends Command
{
    protected $signature = 'onde:order-report';
    protected $description = 'Send hourly Onde orders report between 08:00 and 22:00';

    protected $recipients = ['0978817141','0979459414','0976290607','0980888133','0980888111','0980777888','0980888666','0980888114'];

    public function handle()
    {
        $now = Carbon::now();
        $hour = (int) $now->format('H');

        // Only run between 08:00 and 22:00
        if ($hour < 8 || $hour > 22) {
            Log::info("⏰ Skipping orders report at {$now->format('H:i')} (outside allowed hours)");
            return;
        }

        $lastHour = $now->copy()->subHour();

        // === Count orders per status group (hourly) ===
        $cancelledStatuses = [
            'CANCELLED_BY_DISPATCH',
            'CANCELLED_BY_DRIVER',
            'CANCELLED_NO_PASSENGER',
            'CANCELLED_DECIDED_NOT_TO_GO',
            'CANCELLED_NO_TAXI',
            'CANCELLED_DRIVER_OFFLINE',
            'CANCELLED_SEARCH_EXCEEDED'
        ];

        $ordersHourly = [
            'Cancelled' => DB::table('orders')
                ->whereIn('order_status', $cancelledStatuses)
                ->whereBetween('created_at', [$lastHour, $now])
                ->count(),
            'Finished Paid' => DB::table('orders')
                ->where('order_status', 'FINISHED_PAID')
                ->whereBetween('created_at', [$lastHour, $now])
                ->count(),
            'Finished Unpaid' => DB::table('orders')
                ->where('order_status', 'FINISHED_UNPAID')
                ->whereBetween('created_at', [$lastHour, $now])
                ->count(),
        ];

        $hourlyTotal = array_sum($ordersHourly);

        // Daily totals
        $ordersDaily = [
            'Cancelled' => DB::table('orders')
                ->whereIn('order_status', $cancelledStatuses)
                ->whereDate('created_at', $now->toDateString())
                ->count(),
            'Finished Paid' => DB::table('orders')
                ->where('order_status', 'FINISHED_PAID')
                ->whereDate('created_at', $now->toDateString())
                ->count(),
            'Finished Unpaid' => DB::table('orders')
                ->where('order_status', 'FINISHED_UNPAID')
                ->whereDate('created_at', $now->toDateString())
                ->count(),
        ];

        $dailyTotal = array_sum($ordersDaily);

        // === Prepare SMS ===
        $message = sprintf(
            "Unka Orders Report\nTime: %s\nOrders (hour): %d\nCancelled: %d\nFinished Paid: %d\nFinished Unpaid: %d\nOrders (day): %d",
            $now->format('H:i'),
            $hourlyTotal,
            $ordersHourly['Cancelled'],
            $ordersHourly['Finished Paid'],
            $ordersHourly['Finished Unpaid'],
            $dailyTotal
        );

        foreach ($this->recipients as $recipient) {
            $this->sendSMS($recipient, $message);
        }

        Log::info("📤 Onde orders report sent at {$now->format('H:i')}");
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
            "MessageTitle" => "Unka Orders Report"
        ];

        try {
            $response = Http::withOptions(['verify' => false])->post($smsApiUrl, $payload);

            if ($response->failed()) {
                Log::error("❌ SMS failed for {$phone}: " . $response->body());
            } else {
                Log::info("📩 Orders report SMS sent to {$phone}");
            }
        } catch (\Exception $e) {
            Log::error("💥 SMS exception for {$phone}: " . $e->getMessage());
        }
    }
}
