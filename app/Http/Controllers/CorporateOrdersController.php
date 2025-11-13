<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\CorporateAccount;
use App\Models\CorporateAccountEmployee;
use App\Models\Orders; // adjust namespace if different
use Illuminate\Support\Collection;

class CorporateOrdersController extends Controller
{
    // define cancelled/complete statuses
    protected $cancelledStatuses = [
        'CANCELLED_BY_OPERATOR', 'CANCELLED_BY_DRIVER', 'CANCELLED_NO_CUSTOMER',
        'OBSOLETE_CANCELLED_PASSENGER_OUT_OF_CONDITION','CANCELLED_DECIDED_NOT_TO_GO', 'CANCELLED_NO_TAXI',
        'OBSOLETE_CANCELLED_ORDER_KILLED', 'CANCELLED_DRIVER_OFFLINE', 'CANCELLED_SEARCH_EXCEEDED',
        'OBSOLETE_CANCELLED_NO_RADIO_CAR','OBSOLETE_CANCELLED_NO_CONFIRM', 'CANCELLED_EXPIRED',
        'CANCELLED_BY_SYSTEM',
    ];

    protected $completedStatuses = [
        'FINISHED_PAID' // costs only from these
    ];

    public function index(Request $request)
    {
        $user = Auth::user();

        // Date range defaults to current month
        $start = $request->input('start_date')
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->startOfMonth()->startOfDay();

        $end = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfMonth()->endOfDay();

        $corporateFilter = $request->input('corporate_account'); // for admin filter

        // Base query for Orders where payment was CORPORATE_ACCOUNT
        $baseQuery = Orders::where('payment_method', 'CORPORATE_ACCOUNT')
            ->whereBetween('created_at', [$start, $end]);

        // If corporate user — restrict to their corporate_account
        if ($user->role === 'corporate') {
            $corporate_id = $user->corporate_account;
            // employees for this corporate
            $employees = CorporateAccountEmployee::where('corporate_id', $corporate_id)->get();
            $corporates = null;
        } else {
            // admin: optionally filter by corporate_account param
            $corporate_id = null;
            $employees = collect(); // will be filled per corporate below
            // get all corporates for filter dropdown
            $corporates = CorporateAccount::orderBy('name')->get();
        }

        // For admin: if corporateFilter specified, load that corporate employees only, else will iterate all corporates
        // We'll build $report structure:
        // - For corporate user: $report = collection of employees with trips info
        // - For admin: $reportByCorporate = collection of corporate => employees with data

        if ($user->role === 'corporate') {
            $report = $this->buildEmployeeReportForCorporate($employees, $baseQuery, $start, $end);
            // global stats for dashboard
            $globalStats = $this->calculateGlobalStats($baseQuery->clone());
            return view('corporate.orders.dashboard', compact(
                'user', 'corporate_id','start','end','report','globalStats'
            ));
        }

        // admin
        // choose corporates to include
        if ($corporateFilter) {
            $selectedCorporates = CorporateAccount::where('corporate_id', $corporateFilter)->get();
        } else {
            $selectedCorporates = CorporateAccount::orderBy('name')->get();
        }

        $reportByCorporate = [];
        $totalTripsAll = 0;
        $totalCostAll = 0;
        $totalCancelledAll = 0;
        $totalCompletedAll = 0;

        foreach ($selectedCorporates as $corp) {
            $emps = CorporateAccountEmployee::where('corporate_id', $corp->corporate_id)->get();
            $report = $this->buildEmployeeReportForCorporate($emps, $baseQuery->where('corporate_account', $corp->corporate_id), $start, $end);

            // aggregate corporate totals
            $corpTrips = $report->sum('trips_count');
            $corpCost  = $report->sum('completed_total_cost');
            $corpCancelled = $report->sum('cancelled_count');
            $corpCompleted = $report->sum('completed_count');

            $reportByCorporate[] = [
                'corporate' => $corp,
                'employees' => $report,
                'corporate_trips' => $corpTrips,
                'corporate_cost' => $corpCost,
                'corporate_cancelled' => $corpCancelled,
                'corporate_completed' => $corpCompleted,
            ];

            $totalTripsAll += $corpTrips;
            $totalCostAll += $corpCost;
            $totalCancelledAll += $corpCancelled;
            $totalCompletedAll += $corpCompleted;
        }

        // global stats (for the filter)
        $globalStats = [
            'total_trips' => $totalTripsAll,
            'total_cost' => $totalCostAll,
            'total_cancelled' => $totalCancelledAll,
            'total_completed' => $totalCompletedAll,
        ];

        return view('corporate.orders.dashboard', compact(
            'user','start','end','corporates','reportByCorporate','corporateFilter','globalStats'
        ));
    }

    /**
     * Build report (Collection) for given employees using the provided baseQuery.
     * $ordersBaseQuery should be an Orders query prefiltered by date and payment_method.
     */
    protected function buildEmployeeReportForCorporate(Collection $employees, $ordersBaseQuery, $start, $end)
    {
        $report = collect();

        // Normalize phones (trim) to avoid mismatches
        foreach ($employees as $emp) {
            $phone = trim((string)$emp->phone);

            // Query orders for this employee by passenger_phone and date range and payment_method already in base
            // We clone the query to avoid mutating the passed base
            $ordersQuery = clone $ordersBaseQuery;
            $ordersForEmployee = $ordersQuery->where('passenger_phone', $phone)
                ->orderBy('started_at', 'desc')
                ->get();

            $tripsCount = $ordersForEmployee->count();

            // Completed orders cost sum (only from completed statuses)
            $completedTotalCost = $ordersForEmployee
                ->whereIn('order_status', $this->completedStatuses)
                ->sum(function ($o) {
                    return (float) $o->total_cost;
                });

            $completedCount = $ordersForEmployee->whereIn('order_status', $this->completedStatuses)->count();
            $cancelledCount = $ordersForEmployee->whereIn('order_status', $this->cancelledStatuses)->count();

            // Build trip details array (map only columns we need)
            $tripDetails = $ordersForEmployee->map(function ($o) {
                return [
                    'id' => $o->id,
                    'order_ref' => $o->order_ref ?? null,
                    'origin_address' => $o->origin_address,
                    'destination_address' => $o->destination_address,
                    'started_at' => $o->started_at,
                    'arrived_at' => $o->arrived_at,
                    'order_status' => $o->order_status,
                    'total_cost' => $o->total_cost,
                    'created_at' => $o->created_at,
                ];
            });

            $report->push((object)[
                'employee' => $emp,
                'phone' => $phone,
                'trips_count' => $tripsCount,
                'completed_total_cost' => $completedTotalCost,
                'completed_count' => $completedCount,
                'cancelled_count' => $cancelledCount,
                'trip_details' => $tripDetails,
            ]);
        }

        return $report;
    }

    /**
     * Optional: calculate global stats for given base query (clone outside).
     */
    protected function calculateGlobalStats($ordersBaseQuery)
    {
        $totalTrips = (clone $ordersBaseQuery)->count();
        $totalCompleted = (clone $ordersBaseQuery)->whereIn('order_status', $this->completedStatuses)->count();
        $totalCancelled = (clone $ordersBaseQuery)->whereIn('order_status', $this->cancelledStatuses)->count();
        $totalCost = (clone $ordersBaseQuery)->whereIn('order_status', $this->completedStatuses)->sum('total_cost');

        return [
            'total_trips' => $totalTrips,
            'total_completed' => $totalCompleted,
            'total_cancelled' => $totalCancelled,
            'total_cost' => $totalCost,
        ];
    }
}
