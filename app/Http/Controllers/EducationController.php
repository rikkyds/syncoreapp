<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\EducationLevel;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EducationController extends Controller
{
    public function create(Employee $employee)
    {
        $educationLevels = EducationLevel::all();
        return view('employees.education.create', compact('employee', 'educationLevels'));
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'education_level_id' => 'required|exists:education_levels,id',
            'institution_name' => 'required|string|max:255',
            'major' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:' . date('Y'),
            'end_year' => 'nullable|integer|min:1900|max:' . date('Y') . '|gte:start_year',
            'degree' => 'nullable|string|max:255',
            'status' => 'required|in:graduated,not_graduated,ongoing',
            'gpa' => 'nullable|numeric|min:0|max:4.00',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('certificate')) {
            $validated['certificate'] = $request->file('certificate')
                ->store('employees/' . $employee->id . '/certificates', 'public');
        }

        $employee->educations()->create($validated);

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Education record added successfully.');
    }

    public function edit(Employee $employee, Education $education)
    {
        $educationLevels = EducationLevel::all();
        return view('employees.education.edit', compact('employee', 'education', 'educationLevels'));
    }

    public function update(Request $request, Employee $employee, Education $education)
    {
        $validated = $request->validate([
            'education_level_id' => 'required|exists:education_levels,id',
            'institution_name' => 'required|string|max:255',
            'major' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:' . date('Y'),
            'end_year' => 'nullable|integer|min:1900|max:' . date('Y') . '|gte:start_year',
            'degree' => 'nullable|string|max:255',
            'status' => 'required|in:graduated,not_graduated,ongoing',
            'gpa' => 'nullable|numeric|min:0|max:4.00',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('certificate')) {
            if ($education->certificate) {
                Storage::disk('public')->delete($education->certificate);
            }
            $validated['certificate'] = $request->file('certificate')
                ->store('employees/' . $employee->id . '/certificates', 'public');
        }

        $education->update($validated);

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Education record updated successfully.');
    }

    public function destroy(Employee $employee, Education $education)
    {
        if ($education->certificate) {
            Storage::disk('public')->delete($education->certificate);
        }
        
        $education->delete();

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Education record deleted successfully.');
    }
}
