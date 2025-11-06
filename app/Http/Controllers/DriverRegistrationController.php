<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Association;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DriverRegistrationController extends Controller
{
    /**
     * Show driver registration form
     */
    public function create()
    {
        $associations = Association::all();
        return view('drivers.create', compact('associations'));
    }

    /**
     * Store new driver
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:drivers',
            'subscription_plan' => 'required|in:commision,daily,weekly,monthly',
            'email' => 'nullable|email|max:255',
            'license_number' => 'required|string|max:255',
            'service_type' => 'required|in:classic,business,airport,moto',
            'plate_number' => 'required|string|max:50',
            'vehicle_model' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'board_number' => 'required|string|max:50',
            'number_of_passenger_seats' => 'required|string|max:10',
            'vehicle_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'license_front_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'license_back_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'association_id' => 'required|exists:associations,id',
        ]);

        // Upload images
        $vehicleImage = $request->file('vehicle_image')->store('drivers/vehicles', 'public');
        $licenseFront = $request->file('license_front_image')->store('drivers/licenses', 'public');
        $licenseBack = $request->file('license_back_image')->store('drivers/licenses', 'public');

        // Create driver
        Driver::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'subscription_plan' => $request->subscription_plan,
            'email' => $request->email,
            'license_number' => $request->license_number,
            'service_type' => $request->service_type,
            'plate_number' => $request->plate_number,
            'vehicle_model' => $request->vehicle_model,
            'color' => $request->color,
            'board_number' => $request->board_number,
            'number_of_passenger_seats' => $request->number_of_passenger_seats,
            'vehicle_image' => $vehicleImage,
            'license_front_image' => $licenseFront,
            'license_back_image' => $licenseBack,
            'association_id' => $request->association_id,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Driver registered successfully! Pending approval.');
    }
        public function applications()
    {
        $user = Auth::user();

        if ($user->role === 'system_admin') {
            $pending = Driver::with('association', 'user')->where('status', 'pending')->latest()->get();
            $approved = Driver::with('association', 'user')->where('status', 'approved')->latest()->get();
            $rejected = Driver::with('association', 'user')->where('status', 'rejected')->latest()->get();
        } elseif ($user->role === 'association_admin') {
            $pending = Driver::with('association', 'user')
                ->where('association_id', $user->association_id)
                ->where('status', 'pending')->latest()->get();

            $approved = Driver::with('association', 'user')
                ->where('association_id', $user->association_id)
                ->where('status', 'approved')->latest()->get();

            $rejected = Driver::with('association', 'user')
                ->where('association_id', $user->association_id)
                ->where('status', 'rejected')->latest()->get();
        } else {
            $pending = Driver::with('association', 'user')->where('user_id', $user->id)->where('status', 'pending')->latest()->get();
            $approved = Driver::with('association', 'user')->where('user_id', $user->id)->where('status', 'approved')->latest()->get();
            $rejected = Driver::with('association', 'user')->where('user_id', $user->id)->where('status', 'rejected')->latest()->get();
        }

        return view('drivers.applications', compact('pending', 'approved', 'rejected', 'user'));
    }

    /**
     * Approve a driver.
     */
    public function approve($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Driver approved successfully.');
    }

    /**
     * Reject a driver.
     */
    public function reject($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Driver application rejected.');
    }

}
