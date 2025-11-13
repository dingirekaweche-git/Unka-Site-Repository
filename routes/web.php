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
use App\Http\Controllers\CorporateAccountController;
use App\Http\Controllers\CorporateAccountEmployeeController;
use App\Http\Controllers\CashOutController;
use App\Http\Controllers\EmployeeViewController;
use App\Http\Controllers\CorporateOrdersController;
use App\Http\Controllers\CorporateInvoiceController;
use App\Http\Controllers\CorporateWalletController;

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
    Route::resource('corporate_accounts', CorporateAccountController::class);
        Route::get('/corporate/wallets', [CorporateWalletController::class, 'index'])->name('corporate.wallets.index');
    Route::post('/corporate/wallets/{corporate_id}/topup', [CorporateWalletController::class, 'updateBalance'])->name('corporate.wallets.topup');
});

Route::middleware([Authenticate::class, RoleMiddleware::class . ':system_admin'])->prefix('corporate_accounts/{corporate_id}/employees')->group(function () {
    Route::get('/', [CorporateAccountEmployeeController::class, 'index'])->name('corporate_employees.index');
    Route::get('/create', [CorporateAccountEmployeeController::class, 'create'])->name('corporate_employees.create');
    Route::post('/', [CorporateAccountEmployeeController::class, 'store'])->name('corporate_employees.store');
    Route::get('/{id}', [CorporateAccountEmployeeController::class, 'show'])->name('corporate_employees.show');
    Route::get('/{id}/edit', [CorporateAccountEmployeeController::class, 'edit'])->name('corporate_employees.edit');
    Route::put('/{id}', [CorporateAccountEmployeeController::class, 'update'])->name('corporate_employees.update');
    Route::delete('/{id}', [CorporateAccountEmployeeController::class, 'destroy'])->name('corporate_employees.destroy');
});
Route::middleware([Authenticate::class, RoleMiddleware::class . ':system_admin|corporate'])
    ->group(function () {
        Route::get('/employees', [EmployeeViewController::class, 'index'])->name('employees.index');
    });
Route::middleware([Authenticate::class, RoleMiddleware::class . ':corporate|system_admin'])
    ->group(function () {
        Route::get('/corporate-orders', [CorporateOrdersController::class, 'index'])->name('corporate.orders.index');
          Route::get('/corporate/invoices', [CorporateInvoiceController::class, 'index'])->name('corporate.invoices.index');
        Route::get('/corporate/invoices/download', [CorporateInvoiceController::class, 'download'])->name('corporate.invoices.download');
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

Route::get('/cashout', [CashOutController::class, 'index'])->name('cashout.form');
Route::post('/cashout', [CashOutController::class, 'cashOut'])->name('cashout.process');


require __DIR__.'/auth.php';
