<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\FamilyMember;
use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{
    public function create(Employee $employee)
    {
        return view('employees.family-members.create', compact('employee'));
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'relationship' => 'required|in:father,mother,spouse,child,sibling,grandfather,grandmother,father_in_law,mother_in_law,other',
            'other_relationship' => 'required_if:relationship,other|nullable|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'is_alive' => 'boolean',
            'death_date' => 'required_if:is_alive,0|nullable|date|before:today|after:birth_date',
            'education_level' => 'nullable|in:sd,smp,sma,smk,d1,d2,d3,d4,s1,s2,s3,other',
            'occupation' => 'nullable|string|max:255',
            'is_financial_dependent' => 'boolean',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'is_emergency_contact' => 'boolean',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string'
        ]);

        $employee->familyMembers()->create($validated);

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Family member added successfully.');
    }

    public function edit(Employee $employee, FamilyMember $familyMember)
    {
        return view('employees.family-members.edit', compact('employee', 'familyMember'));
    }

    public function update(Request $request, Employee $employee, FamilyMember $familyMember)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'relationship' => 'required|in:father,mother,spouse,child,sibling,grandfather,grandmother,father_in_law,mother_in_law,other',
            'other_relationship' => 'required_if:relationship,other|nullable|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:male,female',
            'is_alive' => 'boolean',
            'death_date' => 'required_if:is_alive,0|nullable|date|before:today|after:birth_date',
            'education_level' => 'nullable|in:sd,smp,sma,smk,d1,d2,d3,d4,s1,s2,s3,other',
            'occupation' => 'nullable|string|max:255',
            'is_financial_dependent' => 'boolean',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'is_emergency_contact' => 'boolean',
            'phone_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string'
        ]);

        $familyMember->update($validated);

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Family member updated successfully.');
    }

    public function destroy(Employee $employee, FamilyMember $familyMember)
    {
        $familyMember->delete();

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Family member deleted successfully.');
    }
}
