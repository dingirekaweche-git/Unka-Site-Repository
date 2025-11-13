<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Passenger;
use App\Models\DriverOnde;
use App\Models\Orders;
use App\Models\CorporateAccount;
use App\Models\CorporateAccountEmployee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
public function index(Request $request)
{
       $user = auth()->user();
    $startDate = $request->start_date 
    ? Carbon::parse($request->start_date) 
    : now()->startOfMonth();

$endDate = $request->end_date 
    ? Carbon::parse($request->end_date) 
    : now()->endOfMonth();
    if ($user->role === 'system_admin') {
        $drivers = DriverOnde::with('association')->get();
    } else {
        $drivers = DriverOnde::with('association')
                    ->where('boardNumber', $user->association->boardNumber)
                    ->get();
    }

    // Group by state instead of status
    $driversGrouped = [
        'not_activated' => $drivers->where('state', 'NOT_ACTIVATED'),
        'active' => $drivers->where('state', 'ACTIVE'),
        'suspended' => $drivers->where('state', 'SUSPENDED'),
    ];

    // Optional: statistics
    $stats = [
        'total' => $drivers->count(),
        'not_activated' => $driversGrouped['not_activated']->count(),
        'active' => $driversGrouped['active']->count(),
        'suspended' => $driversGrouped['suspended']->count(),
    ];



    // Passenger Stats
  

    // Driver Stats
    if ($user->role === 'system_admin') {
        $drivers = DriverOnde::with('association')->get();
    } else {
        $drivers = DriverOnde::with('association')
            ->where('boardNumber', $user->association->boardNumber)
            ->get();
    }

     $driverStats = [
        'total'         => $drivers->count(),
        'not_activated' => $drivers->where('state', 'NOT_ACTIVATED')->count(),
        'active'        => $drivers->where('state', 'ACTIVE')->count(),
        'suspended'     => $drivers->where('state', 'SUSPENDED')->count(),
    ];

    // --- Passenger Stats ---
    $report = Passenger::select(
        DB::raw("SUM(CASE WHEN profile_state = 'INVITED' THEN 1 ELSE 0 END) as invited"),
        DB::raw("SUM(CASE WHEN profile_state = 'ACTIVE' THEN 1 ELSE 0 END) as active"),
        DB::raw("SUM(CASE WHEN profile_state = 'SUSPENDED' THEN 1 ELSE 0 END) as suspended"),
        DB::raw("SUM(CASE WHEN profile_state = 'CLOSED' THEN 1 ELSE 0 END) as closed"),
        DB::raw("COUNT(*) as total")
    )->first();

    // --- Orders ---
    $statuses = [
        'CANCELLED_BY_OPERATOR','CANCELLED_BY_DRIVER','CANCELLED_NO_CUSTOMER',
        'OBSOLETE_CANCELLED_PASSENGER_OUT_OF_CONDITION','CANCELLED_DECIDED_NOT_TO_GO',
        'CANCELLED_NO_TAXI','OBSOLETE_CANCELLED_ORDER_KILLED','CANCELLED_DRIVER_OFFLINE',
        'CANCELLED_SEARCH_EXCEEDED','OBSOLETE_CANCELLED_NO_RADIO_CAR',
        'OBSOLETE_CANCELLED_NO_CONFIRM','CANCELLED_EXPIRED','CANCELLED_BY_SYSTEM',
        'DISPOSED','OBSOLETE_OPEN','SEARCH','OBSOLETE_SEARCH_BROADCAST',
        'OBSOLETE_SEARCH_MANUAL','ASSIGNED','OBSOLETE_CONFIRM','STARTED','ARRIVED',
        'OBSOLETE_NO_CONTACT_BY_DRIVER','OBSOLETE_NO_CONTACT_BY_PASSENGER','TRANSFERRING',
        'REVIEW_SUMMARY','PAYMENT','FINISHED_PAID','FINISHED_UNPAID','OBSOLETE_NEW',
        'PICK_UP_POINT','DROP_OFF_POINT','STOP_POINT'
    ];

    $orders = Orders::whereIn('order_status', $statuses)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->get();

    $cancelledStatuses = [
        'CANCELLED_BY_OPERATOR','CANCELLED_BY_DRIVER','CANCELLED_NO_CUSTOMER',
        'OBSOLETE_CANCELLED_PASSENGER_OUT_OF_CONDITION','CANCELLED_DECIDED_NOT_TO_GO',
        'CANCELLED_NO_TAXI','OBSOLETE_CANCELLED_ORDER_KILLED','CANCELLED_DRIVER_OFFLINE',
        'CANCELLED_SEARCH_EXCEEDED','OBSOLETE_CANCELLED_NO_RADIO_CAR',
        'OBSOLETE_CANCELLED_NO_CONFIRM','CANCELLED_EXPIRED','CANCELLED_BY_SYSTEM','DISPOSED'
    ];

    $totalOrders     = $orders->count();
    $cancelledCount  = $orders->whereIn('order_status', $cancelledStatuses)->count();
    $totalRevenue    = $orders->sum('total_cost');
    $completedOrders = $totalOrders - $cancelledCount;

    // --- Usage Revenue (Subscription Orders) ---
    $subscriptionPlans = ['10 SUBSCRIPTION','12.5 SUBSCRIPTION','8.0 SUBSCRIPTION'];

    $subOrders = Orders::where('order_status', 'FINISHED_PAID')
        ->whereIn('driver_rate_plan', $subscriptionPlans)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->get();

$usageRevenue = $subOrders->sum(function($order) {
    $rate = floatval(preg_replace('/[^0-9.]/','',$order->driver_rate_plan));
    return $rate > 0 ? ($order->total_cost * ($rate / 100)) : 0;
});

$corporate_id = $user->corporate_account;

    // Employees
    $employeesQuery = CorporateAccountEmployee::where('corporate_id', $corporate_id);
    $totalEmployees = $employeesQuery->count();
    $activeEmployees = $employeesQuery->where('active', 1)->count();
    $inactiveEmployees = $employeesQuery->where('active', 0)->count();

    // Orders for this corporate account
    $completedStatuses = ['FINISHED_PAID'];

    $ordersQuery = Orders::where('corporate_account', $corporate_id)
        ->where('payment_method', 'CORPORATE_ACCOUNT')
        ->whereBetween('created_at', [$startDate, $endDate]);

    $totalTrips = $ordersQuery->count();
    $totalCost = $ordersQuery->whereIn('order_status', $completedStatuses)->sum('total_cost');
    // Corporate Account
    $corporate = \App\Models\CorporateAccount::where('corporate_id', $corporate_id)->first();

    $wallet = null;
    if ($corporate && $corporate->account_type === 'prepaid') {
        $wallet = \App\Models\CorporateWallet::where('corporate_id', $corporate_id)->first();
    }
return view('dashboard', compact(
    'driversGrouped', 
    'user',
    'stats',
    'driverStats',
    'report',
        'totalOrders',
        'completedOrders',
        'cancelledCount',
        'totalRevenue',
        'usageRevenue',
        'startDate',
        'endDate',
         'totalEmployees',
        'activeEmployees',
        'inactiveEmployees',
        'totalTrips',
        'totalCost',
         'corporate',
        'wallet'
));

}

}
