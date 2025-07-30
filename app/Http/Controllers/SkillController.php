<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function create(Employee $employee)
    {
        $skillCategories = SkillCategory::all();
        return view('employees.skills.create', compact('employee', 'skillCategories'));
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'skill_category_id' => 'required|exists:skill_categories,id',
            'name' => 'required|string|max:255',
            'proficiency_level' => 'required|in:beginner,intermediate,advanced,expert',
            'years_of_experience' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'certification' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'certification_date' => 'nullable|date',
            'certification_expiry' => 'nullable|date|after:certification_date',
            'issuing_organization' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('certification')) {
            $validated['certification'] = $request->file('certification')
                ->store('employees/' . $employee->id . '/certifications', 'public');
        }

        $employee->skills()->create($validated);

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Skill added successfully.');
    }

    public function edit(Employee $employee, Skill $skill)
    {
        $skillCategories = SkillCategory::all();
        return view('employees.skills.edit', compact('employee', 'skill', 'skillCategories'));
    }

    public function update(Request $request, Employee $employee, Skill $skill)
    {
        $validated = $request->validate([
            'skill_category_id' => 'required|exists:skill_categories,id',
            'name' => 'required|string|max:255',
            'proficiency_level' => 'required|in:beginner,intermediate,advanced,expert',
            'years_of_experience' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'certification' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'certification_date' => 'nullable|date',
            'certification_expiry' => 'nullable|date|after:certification_date',
            'issuing_organization' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('certification')) {
            if ($skill->certification) {
                Storage::disk('public')->delete($skill->certification);
            }
            $validated['certification'] = $request->file('certification')
                ->store('employees/' . $employee->id . '/certifications', 'public');
        }

        $skill->update($validated);

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Skill updated successfully.');
    }

    public function destroy(Employee $employee, Skill $skill)
    {
        if ($skill->certification) {
            Storage::disk('public')->delete($skill->certification);
        }
        
        $skill->delete();

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Skill deleted successfully.');
    }
}
