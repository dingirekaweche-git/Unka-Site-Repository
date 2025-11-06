<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Passenger;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PassengerController extends Controller
{
    public function dashboard(Request $request)
    {
        // Filter dates, default to current month
        $from = $request->input('from') 
            ? Carbon::parse($request->input('from'))->startOfDay() 
            : Carbon::now()->startOfMonth();
        $to = $request->input('to') 
            ? Carbon::parse($request->input('to'))->endOfDay() 
            : Carbon::now()->endOfMonth(); 

        // Passenger report summary
        $report = Passenger::select(
                DB::raw("SUM(CASE WHEN profile_state = 'INVITED' THEN 1 ELSE 0 END) as invited"),
                DB::raw("SUM(CASE WHEN profile_state = 'ACTIVE' THEN 1 ELSE 0 END) as active"),
                DB::raw("SUM(CASE WHEN profile_state = 'SUSPENDED' THEN 1 ELSE 0 END) as suspended"),
                DB::raw("SUM(CASE WHEN profile_state = 'CLOSED' THEN 1 ELSE 0 END) as closed"),
                DB::raw("COUNT(*) as total")
            )
         
            ->first();

        // Daily trend
        $trend = Passenger::select(
                DB::raw("DATE(created_at) as date"),
                DB::raw("COUNT(*) as total_joined")
            )
            ->whereBetween('created_at', [$from, $to])
            ->groupBy(DB::raw("DATE(created_at)"))
            ->orderBy('date')
            ->get();

        // Prepare trend data for chart
        $dates = [];
        $counts = [];
        $period = new \DatePeriod(
            new \DateTime($from->toDateString()),
            new \DateInterval('P1D'),
            (new \DateTime($to->toDateString()))->modify('+1 day')
        );

        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
            $counts[] = $trend->firstWhere('date', $date->format('Y-m-d'))->total_joined ?? 0;
        }

        return view('passengers.dashboard', compact('report', 'dates', 'counts', 'from', 'to'));
    }
}
