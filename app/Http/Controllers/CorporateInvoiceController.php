<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class CorporateInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $role = $user->role;
        $today = Carbon::today();

        // Default: current month range
        $startDate = $request->input('start_date', $today->copy()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', $today->copy()->endOfMonth()->toDateString());
        $selectedCorporate = $request->input('corporate_account');

        $query = DB::table('orders')
            ->where('payment_method', 'CORPORATE_ACCOUNT')
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($role === 'corporate') {
            $query->where('corporate_account', $user->corporate_account);
        } elseif ($role === 'system_admin' && $selectedCorporate) {
            $query->where('corporate_account', $selectedCorporate);
        }

        $orders = $query->select(
            'corporate_account',
            'passenger_phone',
            'passenger_name',
            'origin_address',
            'destination_address',
            'started_at',
            'arrived_at',
            'order_status',
            'total_cost'
        )->orderBy('created_at', 'desc')->get();

        // Group by employee phone
        $grouped = $orders->groupBy('passenger_phone');

        // Summary per employee
        $summary = $grouped->map(function ($trips) {
            return [
                'trips' => $trips->count(),
                'total_cost' => $trips->sum('total_cost'),
                'details' => $trips
            ];
        });

        // Corporate list for admin filter
        $corporates = [];
        if ($role === 'system_admin') {
            $corporates = DB::table('corporate_accounts')->select('corporate_id', 'name')->get();
        }

        return view('corporate.invoices.index', compact(
            'summary',
            'startDate',
            'endDate',
            'corporates',
            'selectedCorporate',
            'role'
        ));
    }

   public function download(Request $request)
{
    $user = auth()->user();
    $role = $user->role;

    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $corporateId = $role === 'corporate'
        ? $user->corporate_account
        : $request->input('corporate_account');

    // ✅ Fetch corporate info
    $corporate = DB::table('corporate_accounts')
        ->where('corporate_id', $corporateId)
        ->first();

    if (!$corporate) {
        return back()->with('error', 'Corporate account not found.');
    }

    // Fetch orders for this corporate account and period
    $orders = DB::table('orders')
        ->where('payment_method', 'CORPORATE_ACCOUNT')
        ->where('corporate_account', $corporateId)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->get();

    // Group by employee phone
    $grouped = $orders->groupBy('passenger_phone');

    // Prepare summary per employee
    $summary = $grouped->map(function ($trips) {
        return [
            'trips' => $trips->count(),
            'total_cost' => $trips->sum('total_cost'),
            'details' => $trips // trips details include origin → destination
        ];
    });

    // Subtotal and total
    $subtotal = $orders->sum('total_cost');
    $tax = 0; // adjust if needed
    $total_cost = $subtotal + $tax;

    $pdf = Pdf::loadView('corporate.invoices.pdf', [
        'corporate' => $corporate,
        'orders' => $orders,
        'summary' => $summary,
        'subtotal' => $subtotal,
        'tax' => $tax,
        'total_cost' => $total_cost,
        'startDate' => $startDate,
        'endDate' => $endDate,
    ])->setPaper('a4', 'portrait');

    return $pdf->download("Invoice_{$corporate->corporate_id}.pdf");
}

}
