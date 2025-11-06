<?php

namespace App\Http\Controllers;

use App\Models\Association;
use Illuminate\Http\Request;

class AssociationController extends Controller
{
    public function index()
    {
        $associations = Association::all();
        return view('associations.index', compact('associations'));
    }

    public function create()
    {
        return view('associations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:associations,name|max:255',
            'description' => 'nullable|string',
        ]);

        Association::create($request->only('name', 'description'));

        return redirect()->route('associations.index')->with('success', 'Association created successfully.');
    }

    public function edit(Association $association)
    {
        return view('associations.edit', compact('association'));
    }

    public function update(Request $request, Association $association)
    {
        $request->validate([
            'name' => 'required|unique:associations,name,' . $association->id . '|max:255',
            'description' => 'nullable|string',
        ]);

        $association->update($request->only('name', 'description'));

        return redirect()->route('associations.index')->with('success', 'Association updated successfully.');
    }

    public function destroy(Association $association)
    {
        $association->delete();
        return redirect()->route('associations.index')->with('success', 'Association deleted successfully.');
    }
}
