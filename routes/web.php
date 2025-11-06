<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DriverRegistrationController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverPerformanceController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderReportController;
use App\Http\Controllers\PassengerController;

Route::get('/', fn() => view('welcome'));

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

   
    Route::get('/drivers/create', [DriverRegistrationController::class, 'create'])->name('drivers.create');
    Route::post('/drivers', [DriverRegistrationController::class, 'store'])->name('drivers.store');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/drivers/applications', [DriverRegistrationController::class, 'applications'])->name('drivers.applications');
});

Route::middleware([Authenticate::class, RoleMiddleware::class . ':system_admin'])->group(function () {
    Route::post('/drivers/{id}/approve', [DriverRegistrationController::class, 'approve'])->name('drivers.approve');
    Route::post('/drivers/{id}/reject', [DriverRegistrationController::class, 'reject'])->name('drivers.reject');
});
// Only system_admin can manage associations
Route::middleware([Authenticate::class, RoleMiddleware::class . ':system_admin'])
    ->group(function () {
        Route::resource('associations', AssociationController::class);
    });

    Route::middleware([Authenticate::class, RoleMiddleware::class . ':system_admin'])->group(function () {
     Route::resource('users', App\Http\Controllers\UserController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::get('/driver-performance', [DriverPerformanceController::class, 'index'])
        ->name('driver-performance.index');
});
Route::middleware([Authenticate::class, RoleMiddleware::class . ':system_admin'])->group(function () {
    Route::get('/order-report', [OrderReportController::class, 'index'])->name('order_report.index');
});
Route::middleware([Authenticate::class, RoleMiddleware::class . ':system_admin'])->group(function () {
    Route::get('/usage-based-revenue', [OrderReportController::class, 'usageBasedRevenue'])->name('order_report.revenue');
    Route::get('/passengers/dashboard', [PassengerController::class, 'dashboard'])->name('passengers.dashboard');
      Route::get('/driver-performance/dashboard', [DriverPerformanceController::class, 'dashboard'])->name('driver-performance.dashboard');
});
// Public pages
Route::view('/policies', 'policies')->name('policies');
Route::view('/terms', 'terms')->name('terms');
Route::view('/copyright', 'copyright')->name('copyright');
Route::view('/services', 'services')->name('services');
Route::view('/partner', 'partner')->name('partner');
Route::view('/driver', 'driver')->name('driver');
Route::view('/about', 'about')->name('about');
Route::view('/float_purchase', 'float_purchase')->name('purchase');
Route::post('/topup-driver', [DriverController::class, 'topupDriver'])->name('topup.driver');
Route::post('/topup/customer', [PaymentController::class, 'topupCustomerWallet'])->name('topup.customer');
Route::view('/wallet-top-up', 'wallet-top-up')->name('wallet-top-up');

require __DIR__.'/auth.php';
