<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\VerifyTicketDates;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('onde:fetch-orders')->everyMinute();
Schedule::command('onde:customer-reward')->everyMinute();
Schedule::command('onde:driver-reward')->everyMinute();
Schedule::command('onde:sync-drivers')->everyMinute();
Schedule::command('onde:driver-report')
        ->hourly()
        ->between('8:00', '22:00');
Schedule::command('onde:order-report')
        ->hourly()
        ->between('8:00', '22:00');
Schedule::command('onde:passengers-report')
        ->hourly()
        ->between('8:00', '22:00');
Schedule::command('payments:check-driver')->everyFiveMinutes();
Schedule::command('payments:check-customer')->everyFiveMinutes();
Schedule::command('onde:fetch-passengers')->everyMinute();
Schedule::command('corporate:deduct-balances')->hourly();