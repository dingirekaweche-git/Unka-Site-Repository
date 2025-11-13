<?php

namespace App\Http\Controllers;

use App\Models\CorporateAccount;
use Illuminate\Http\Request;

class CorporateAccountController extends Controller
{
    // Show all corporate accounts
    public function index()
    {
         $corporates = CorporateAccount::withCount('employees')->latest()->paginate(10);
        return view('corporate_accounts.index', compact('corporates'));
    }

    // Show form to create new corporate account
    public function create()
    {
        return view('corporate_accounts.create');
    }

    // Store a new corporate account
    public function store(Request $request)
    {
        $request->validate([
            'corporate_id' => 'required|unique:corporate_accounts,corporate_id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'account_type' => 'required|in:prepaid,postpaid',
        ]);

        CorporateAccount::create($request->all());

        return redirect()->route('corporate_accounts.index')
                         ->with('success', 'Corporate account created successfully.');
    }

    // Show form to edit corporate account
    public function edit($corporate_id)
    {
        $corporate = CorporateAccount::findOrFail($corporate_id);
        return view('corporate_accounts.edit', compact('corporate'));
    }

    // Update corporate account
    public function update(Request $request, $corporate_id)
    {
        $corporate = CorporateAccount::findOrFail($corporate_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'account_type' => 'required|in:prepaid,postpaid',
        ]);

        $corporate->update($request->all());

        return redirect()->route('corporate_accounts.index')
                         ->with('success', 'Corporate account updated successfully.');
    }

    // View a single corporate account
    public function show($corporate_id)
    {
        $corporate = CorporateAccount::findOrFail($corporate_id);
        return view('corporate_accounts.show', compact('corporate'));
    }

    // Delete
    public function destroy($corporate_id)
    {
        CorporateAccount::findOrFail($corporate_id)->delete();
        return redirect()->route('corporate_accounts.index')
                         ->with('success', 'Corporate account deleted successfully.');
    }
}
