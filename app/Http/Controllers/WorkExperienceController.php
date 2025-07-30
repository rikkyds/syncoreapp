<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\WorkExperience;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    public function create(Employee $employee)
    {
        return view('employees.work-experiences.create', compact('employee'));
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'main_responsibilities' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'employment_status' => 'required|in:full_time,part_time,contract,internship',
            'location' => 'required|string|max:255',
            'is_remote' => 'boolean',
            'salary' => 'nullable|numeric|min:0',
            'salary_currency' => 'nullable|string|size:3',
            'leaving_reason' => 'nullable|string',
            'reference_name' => 'nullable|string|max:255',
            'reference_position' => 'nullable|string|max:255',
            'reference_contact' => 'nullable|string|max:255',
            'reference_email' => 'nullable|email|max:255'
        ]);

        if ($validated['is_current'] ?? false) {
            $validated['end_date'] = null;
        }

        $employee->workExperiences()->create($validated);

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Work experience added successfully.');
    }

    public function edit(Employee $employee, WorkExperience $workExperience)
    {
        return view('employees.work-experiences.edit', compact('employee', 'workExperience'));
    }

    public function update(Request $request, Employee $employee, WorkExperience $workExperience)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'main_responsibilities' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'employment_status' => 'required|in:full_time,part_time,contract,internship',
            'location' => 'required|string|max:255',
            'is_remote' => 'boolean',
            'salary' => 'nullable|numeric|min:0',
            'salary_currency' => 'nullable|string|size:3',
            'leaving_reason' => 'nullable|string',
            'reference_name' => 'nullable|string|max:255',
            'reference_position' => 'nullable|string|max:255',
            'reference_contact' => 'nullable|string|max:255',
            'reference_email' => 'nullable|email|max:255'
        ]);

        if ($validated['is_current'] ?? false) {
            $validated['end_date'] = null;
        }

        $workExperience->update($validated);

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Work experience updated successfully.');
    }

    public function destroy(Employee $employee, WorkExperience $workExperience)
    {
        $workExperience->delete();

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Work experience deleted successfully.');
    }
}
