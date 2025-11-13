<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use Carbon\Carbon;

class OrderReportController extends Controller
{
    public function index(Request $request)
    {
        // Default date filter: today
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date'))->startOfDay() 
            : Carbon::today()->startOfDay();

        $endDate = $request->input('end_date') 
            ? Carbon::parse($request->input('end_date'))->endOfDay() 
            : Carbon::today()->endOfDay();

        // Status list
        $statuses = [
            'CANCELLED_BY_OPERATOR', 'CANCELLED_BY_DRIVER', 'CANCELLED_NO_CUSTOMER',
            'OBSOLETE_CANCELLED_PASSENGER_OUT_OF_CONDITION',
            'CANCELLED_DECIDED_NOT_TO_GO', 'CANCELLED_NO_TAXI',
            'OBSOLETE_CANCELLED_ORDER_KILLED', 'CANCELLED_DRIVER_OFFLINE',
            'CANCELLED_SEARCH_EXCEEDED', 'OBSOLETE_CANCELLED_NO_RADIO_CAR',
            'OBSOLETE_CANCELLED_NO_CONFIRM', 'CANCELLED_EXPIRED',
            'CANCELLED_BY_SYSTEM', 'DISPOSED', 'OBSOLETE_OPEN', 'SEARCH',
            'OBSOLETE_SEARCH_BROADCAST', 'OBSOLETE_SEARCH_MANUAL', 'ASSIGNED',
            'OBSOLETE_CONFIRM', 'STARTED', 'ARRIVED', 'OBSOLETE_NO_CONTACT_BY_DRIVER',
            'OBSOLETE_NO_CONTACT_BY_PASSENGER', 'TRANSFERRING', 'REVIEW_SUMMARY',
            'PAYMENT', 'FINISHED_PAID', 'FINISHED_UNPAID', 'OBSOLETE_NEW', 
            'PICK_UP_POINT', 'DROP_OFF_POINT', 'STOP_POINT'
        ];

        // Fetch filtered orders
    $orders = Orders::whereIn('order_status', $statuses)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')
                ->get();
    $listorders = Orders::whereIn('order_status', $statuses)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        return view('order_report.index', compact('orders', 'startDate', 'endDate','listorders'));
    }

    public function usageBasedRevenue(Request $request)
{
    // 📅 Filters
  $startDate = $request->input('start_date') 
        ? Carbon::parse($request->input('start_date')) 
        : Carbon::now()->startOfMonth();

    $endDate = $request->input('end_date') 
        ? Carbon::parse($request->input('end_date')) 
        : Carbon::now();

    $search    = $request->input('search');

    // 🎯 Target order statuses and rate plans
    $statuses = ['FINISHED_PAID'];
    $ratePlans = ['10 SUBSCRIPTION', '12.5 SUBSCRIPTION', '8.0 SUBSCRIPTION'];

    // 📦 Fetch filtered orders
    $orders = \App\Models\Orders::whereIn('order_status', $statuses)
        ->whereIn('driver_rate_plan', $ratePlans)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('passenger_name', 'like', "%{$search}%")
                  ->orWhere('driver_name', 'like', "%{$search}%");
            });
        })
        ->whereBetween('created_at', [$startDate, $endDate])
        ->orderBy('created_at', 'desc')
        ->get();
        $listorders = \App\Models\Orders::whereIn('order_status', $statuses)
        ->whereIn('driver_rate_plan', $ratePlans)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('passenger_name', 'like', "%{$search}%")
                  ->orWhere('driver_name', 'like', "%{$search}%");
            });
        })
        ->whereBetween('created_at', [$startDate, $endDate])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    // 💰 Calculate total revenue
    $totalRevenue = $orders->sum(function ($order) {
        $rateValue = floatval(preg_replace('/[^0-9.]/', '', $order->driver_rate_plan));
   
         return $rateValue > 0 ? ($order->total_cost * ($rateValue / 100)) : 0;
    });
    $orderscount = \App\Models\Orders::whereIn('order_status', $statuses)
        ->whereIn('driver_rate_plan', $ratePlans)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('passenger_name', 'like', "%{$search}%")
                  ->orWhere('driver_name', 'like', "%{$search}%");
            });
        })
        ->whereBetween('created_at', [$startDate, $endDate])
        ->orderBy('created_at', 'desc')
        ->count();

    return view('order_report.revenue', compact('orders', 'totalRevenue', 'startDate', 'endDate', 'search','listorders','orderscount'));
}

}
