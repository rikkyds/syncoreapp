<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    public function create(Employee $employee)
    {
        $skillCategories = SkillCategory::all();
        $skills = Skill::with('category')->get();
        return view('employees.skills.create', compact('employee', 'skillCategories', 'skills'));
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'skill_id' => 'required|exists:skills,id',
            'proficiency_level' => 'required|in:beginner,intermediate,advanced,expert',
            'notes' => 'nullable|string',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        // Check if employee already has this skill
        if ($employee->skills()->where('skill_id', $validated['skill_id'])->exists()) {
            return back()->withErrors(['skill_id' => 'Employee already has this skill.']);
        }

        $pivotData = [
            'proficiency_level' => $validated['proficiency_level'],
            'notes' => $validated['notes'] ?? null,
        ];

        if ($request->hasFile('certificate')) {
            $pivotData['certificate'] = $request->file('certificate')
                ->store('employees/' . $employee->id . '/skill-certificates', 'public');
        }

        $employee->skills()->attach($validated['skill_id'], $pivotData);

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Skill added successfully.');
    }

    public function edit(Employee $employee, $skillId)
    {
        $employeeSkill = $employee->skills()->where('skill_id', $skillId)->first();
        
        if (!$employeeSkill) {
            abort(404);
        }

        $skills = Skill::with('category')->get();
        return view('employees.skills.edit', compact('employee', 'employeeSkill', 'skills'));
    }

    public function update(Request $request, Employee $employee, $skillId)
    {
        $validated = $request->validate([
            'proficiency_level' => 'required|in:beginner,intermediate,advanced,expert',
            'notes' => 'nullable|string',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $employeeSkill = $employee->skills()->where('skill_id', $skillId)->first();
        
        if (!$employeeSkill) {
            abort(404);
        }

        $pivotData = [
            'proficiency_level' => $validated['proficiency_level'],
            'notes' => $validated['notes'] ?? null,
        ];

        if ($request->hasFile('certificate')) {
            // Delete old certificate if exists
            if ($employeeSkill->pivot->certificate) {
                Storage::disk('public')->delete($employeeSkill->pivot->certificate);
            }
            
            $pivotData['certificate'] = $request->file('certificate')
                ->store('employees/' . $employee->id . '/skill-certificates', 'public');
        }

        $employee->skills()->updateExistingPivot($skillId, $pivotData);

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Skill updated successfully.');
    }

    public function destroy(Employee $employee, $skillId)
    {
        $employeeSkill = $employee->skills()->where('skill_id', $skillId)->first();
        
        if (!$employeeSkill) {
            abort(404);
        }

        // Delete certificate file if exists
        if ($employeeSkill->pivot->certificate) {
            Storage::disk('public')->delete($employeeSkill->pivot->certificate);
        }
        
        $employee->skills()->detach($skillId);

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Skill removed successfully.');
    }
}
