<?php

namespace App\Http\Controllers;

use App\Models\CorporateAccount;
use App\Models\CorporateAccountEmployee;
use Illuminate\Http\Request;

class CorporateAccountEmployeeController extends Controller
{
    // List employees for a corporate account
    public function index($corporate_id)
    {
        $corporate = CorporateAccount::findOrFail($corporate_id);
        $employees = CorporateAccountEmployee::where('corporate_id', $corporate_id)->paginate(10);
        return view('corporate_employees.index', compact('corporate', 'employees'));
    }

    // Show create form
    public function create($corporate_id)
    {
        $corporate = CorporateAccount::findOrFail($corporate_id);
        return view('corporate_employees.create', compact('corporate'));
    }

    // Store employee
    public function store(Request $request, $corporate_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
        ]);

        CorporateAccountEmployee::create([
            'corporate_id' => $corporate_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department' => $request->department,
            'active' => $request->active ?? true,
        ]);

        return redirect()->route('corporate_employees.index', $corporate_id)
                         ->with('success', 'Employee added successfully.');
    }

    // Show single employee
    public function show($corporate_id, $id)
    {
        $corporate = CorporateAccount::findOrFail($corporate_id);
        $employee = CorporateAccountEmployee::findOrFail($id);
        return view('corporate_employees.show', compact('corporate', 'employee'));
    }

    // Edit employee
    public function edit($corporate_id, $id)
    {
        $corporate = CorporateAccount::findOrFail($corporate_id);
        $employee = CorporateAccountEmployee::findOrFail($id);
        return view('corporate_employees.edit', compact('corporate', 'employee'));
    }

    // Update employee
    public function update(Request $request, $corporate_id, $id)
    {
        $employee = CorporateAccountEmployee::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
        ]);

        $employee->update($request->all());

        return redirect()->route('corporate_employees.index', $corporate_id)
                         ->with('success', 'Employee updated successfully.');
    }

    // Delete employee
    public function destroy($corporate_id, $id)
    {
        CorporateAccountEmployee::findOrFail($id)->delete();

        return redirect()->route('corporate_employees.index', $corporate_id)
                         ->with('success', 'Employee deleted successfully.');
    }
}
