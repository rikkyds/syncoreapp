<?php

namespace App\Http\Controllers;

use App\Models\BranchOffice;
use App\Models\Company;
use Illuminate\Http\Request;

class BranchOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branchOffices = BranchOffice::with('company')->get();
        return view('branch-offices.index', compact('branchOffices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return view('branch-offices.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255'
        ]);

        BranchOffice::create($validated);

        return redirect()->route('branch-offices.index')
            ->with('success', 'Branch office created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BranchOffice $branchOffice)
    {
        return view('branch-offices.show', compact('branchOffice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BranchOffice $branchOffice)
    {
        $companies = Company::all();
        return view('branch-offices.edit', compact('branchOffice', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BranchOffice $branchOffice)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255'
        ]);

        $branchOffice->update($validated);

        return redirect()->route('branch-offices.index')
            ->with('success', 'Branch office updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BranchOffice $branchOffice)
    {
        $branchOffice->delete();

        return redirect()->route('branch-offices.index')
            ->with('success', 'Branch office deleted successfully.');
    }
}
