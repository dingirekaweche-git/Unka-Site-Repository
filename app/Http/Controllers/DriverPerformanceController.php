<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DriverOnde;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class DriverPerformanceController extends Controller
{
public function index(Request $request)
{
    $user = Auth::user();

    // Base query: only active drivers
    $query = DriverOnde::with('association')->where('state', 'ACTIVE');

    // Restrict drivers based on role
    if (in_array($user->role, ['association_admin', 'user'])) {
        $query->where('boardNumber', $user->association->boardNumber);
    }

    // Search by driver name
    if ($request->filled('driver_name')) {
        $query->where('fullName', 'like', '%' . $request->driver_name . '%');
    }

    // Paginate drivers: 10 per page
    $drivers = $query->orderBy('fullName')->paginate(10)->withQueryString();

    // Date filtering inputs
    $startDate = $request->input('start_date') ? Carbon::parse($request->start_date)->startOfDay() : null;
    $endDate = $request->input('end_date') ? Carbon::parse($request->end_date)->endOfDay() : null;
    $period = $request->input('period'); // daily, weekly, monthly

    // Compute driver performance
    $driversPerformance = $drivers->map(function ($driver) use ($startDate, $endDate, $period) {

        $ordersQuery = Orders::where('driver_phone', $driver->phone)
            ->whereIn('order_status', [
                'FINISHED_PAID',
                'FINISHED_UNPAID',
                'CANCELLED_BY_DRIVER',
                'CANCELLED_NO_PASSENGER'
            ])
            ->orderBy('created_at', 'desc');

        // Period filter
        if ($period === 'daily') {
            $ordersQuery->whereDate('created_at', Carbon::today());
        } elseif ($period === 'weekly') {
            $ordersQuery->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        } elseif ($period === 'monthly') {
            $ordersQuery->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year);
        } elseif ($startDate && $endDate) {
            $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Limit orders to 3 per driver
        $orders = $ordersQuery->take(3)->get();

        // Summary data
        return [
            'driver' => $driver,
            'orders' => $orders,
            'total_orders' => $ordersQuery->count(), // total orders (all, not just 3)
            'finished_paid' => $ordersQuery->clone()->where('order_status', 'FINISHED_PAID')->count(),
            'finished_unpaid' => $ordersQuery->clone()->where('order_status', 'FINISHED_UNPAID')->count(),
            'cancelled_by_driver' => $ordersQuery->clone()->where('order_status', 'CANCELLED_BY_DRIVER')->count(),
            'cancelled_no_passenger' => $ordersQuery->clone()->where('order_status', 'CANCELLED_NO_PASSENGER')->count(),
        ];
    });

    return view('driver-performance.index', compact('driversPerformance', 'drivers'));
}

public function dashboard()
{
    $user = Auth::user();

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

    return view('driver-performance.dashboard', compact('driversGrouped', 'user', 'stats'));
} 

}
