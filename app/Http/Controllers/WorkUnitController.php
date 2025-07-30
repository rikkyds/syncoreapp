<?php

namespace App\Http\Controllers;

use App\Models\BranchOffice;
use App\Models\WorkUnit;
use Illuminate\Http\Request;

class WorkUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workUnits = WorkUnit::with('branchOffice.company')->get();
        return view('work-units.index', compact('workUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branchOffices = BranchOffice::with('company')->get();
        return view('work-units.create', compact('branchOffices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_office_id' => 'required|exists:branch_offices,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255'
        ]);

        WorkUnit::create($validated);

        return redirect()->route('work-units.index')
            ->with('success', 'Work unit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkUnit $workUnit)
    {
        return view('work-units.show', compact('workUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkUnit $workUnit)
    {
        $branchOffices = BranchOffice::with('company')->get();
        return view('work-units.edit', compact('workUnit', 'branchOffices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkUnit $workUnit)
    {
        $validated = $request->validate([
            'branch_office_id' => 'required|exists:branch_offices,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255'
        ]);

        $workUnit->update($validated);

        return redirect()->route('work-units.index')
            ->with('success', 'Work unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkUnit $workUnit)
    {
        $workUnit->delete();

        return redirect()->route('work-units.index')
            ->with('success', 'Work unit deleted successfully.');
    }
}
