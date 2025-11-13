<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CorporateAccountEmployee;
use App\Models\CorporateAccount;

class EmployeeViewController extends Controller
{
   public function index()
{
    $user = Auth::user();

    if ($user->role === 'corporate') {
        $corporate_id = $user->corporate_account;
        $employees = CorporateAccountEmployee::where('corporate_id', $corporate_id)->paginate(10);
    } else {
        $corporate_id = null;
        $employees = collect(); // Empty for admin summary
    }

    $corporates = CorporateAccount::with('employees')->paginate(10);

    return view('employees.index', [
        'user' => $user,
        'corporate_id' => $corporate_id,
        'employees' => $employees,
        'corporates' => $corporates,
        'totalEmployees' => CorporateAccountEmployee::count(),
        'activeEmployees' => CorporateAccountEmployee::where('active', 1)->count(),
        'inactiveEmployees' => CorporateAccountEmployee::where('active', 0)->count(),
    ]);
}

}
