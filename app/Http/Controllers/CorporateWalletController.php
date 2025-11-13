<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CorporateWallet;
use App\Models\CorporateAccount;
use Illuminate\Support\Facades\Auth;

class CorporateWalletController extends Controller
{
    // Show prepaid accounts only
    public function index()
    {
        $wallets = CorporateAccount::where('account_type', 'prepaid')
            ->leftJoin('corporate_wallets', 'corporate_accounts.corporate_id', '=', 'corporate_wallets.corporate_id')
            ->select('corporate_accounts.*', 'corporate_wallets.balance', 'corporate_wallets.updated_at as last_updated')
            ->get();

        return view('corporate.wallets.index', compact('wallets'));
    }

    // Store balance updates (Admin only)
   public function updateBalance(Request $request, $corporate_id)
{
    // Allow only system_admin
    if (auth()->user()->role !== 'system_admin') {
        return redirect()->back()->with('error', 'Unauthorized: Only system admin can update balances.');
    }

    $request->validate([
        'amount' => 'required|numeric|min:0.01',
    ]);

    // Find or create wallet
    $wallet = \App\Models\CorporateWallet::firstOrCreate(['corporate_id' => $corporate_id], [
        'balance' => 0,
    ]);

    // Increment balance
    $wallet->balance += $request->amount;
    $wallet->last_topup = $request->amount;
    $wallet->added_by = auth()->user()->name;
    $wallet->save();

    return redirect()->back()->with('success', 'Balance updated successfully.');
}

}
