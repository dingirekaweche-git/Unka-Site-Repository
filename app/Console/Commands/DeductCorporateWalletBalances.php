<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Orders;
use App\Models\CorporateAccount;
use App\Models\CorporateWallet;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DeductCorporateWalletBalances extends Command
{
    protected $signature = 'corporate:deduct-balances';
    protected $description = 'Deduct prepaid corporate order costs from their wallets';

    public function handle()
    {
        Log::info('🔄 Starting prepaid corporate wallet deductions...');

        // Fetch all prepaid corporate accounts
        $prepaidCorporates = CorporateAccount::where('account_type', 'prepaid')->pluck('corporate_id');

        // Fetch all completed unpaid corporate orders for prepaid accounts
        $orders = Orders::where('payment_method', 'CORPORATE_ACCOUNT')
            ->whereIn('corporate_account', $prepaidCorporates)
            ->where('order_status', 'FINISHED_PAID')
            ->where('wallet_deducted', false)
            ->get();

        if ($orders->isEmpty()) {
            Log::info('✅ No pending corporate wallet deductions found.');
            return Command::SUCCESS;
        }

        foreach ($orders as $order) {
            try {
                $wallet = CorporateWallet::firstOrCreate(
                    ['corporate_id' => $order->corporate_account],
                    ['balance' => 0]
                );

                if ($wallet->balance >= $order->total_cost) {
                    $wallet->balance -= $order->total_cost;
                    $wallet->save();

                    // Mark order as deducted
                    $order->wallet_deducted = true;
                    $order->deducted_at = Carbon::now();
                    $order->save();

                    Log::info("💰 Deducted K{$order->total_cost} from {$order->corporate_account}");
                } else {
                    Log::warning("⚠️ Insufficient balance for {$order->corporate_account}, Order ID: {$order->id}");
                }
            } catch (\Exception $e) {
                Log::error("❌ Error deducting for order {$order->id}: " . $e->getMessage());
            }
        }

        Log::info('✅ Finished prepaid corporate wallet deductions.');
        return Command::SUCCESS;
    }
}
