<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::with(['submitter', 'submitterPosition', 'initiator', 'initiatorPosition', 'approver'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('submission_date', [$request->start_date, $request->end_date]);
        }

        // Filter berdasarkan pengaju (jika bukan admin)
        $user = Auth::user();
        if ($user->role->name !== 'admin') {
            $employee = Employee::where('user_id', $user->id)->first();
            if ($employee) {
                $query->where('submitter_employee_id', $employee->id);
            }
        }

        $projects = $query->paginate(10);
        $statusOptions = Project::getStatusOptions();

        return view('projects.index', compact('projects', 'statusOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::with(['workUnit', 'position'])
            ->select('id', 'full_name', 'employee_id', 'work_unit_id', 'position_id')
            ->get();

        $positions = Position::select('id', 'name')->get();

        return view('projects.create', compact('employees', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'submission_date' => 'required|date',
            'submitter_employee_id' => 'required|exists:employees,id',
            'submitter_position_id' => 'required|exists:positions,id',
            'initiator_employee_id' => 'required|exists:employees,id',
            'initiator_position_id' => 'required|exists:positions,id',
            'objective' => 'required|string',
            'program_name' => 'required|string|max:255',
            'program_code' => 'required|string|max:50',
            'activity_name' => 'required|string|max:255',
            'activity_code' => 'required|string|max:50',
            'project_name' => 'required|string|max:255',
            'project_sequence_number' => 'required|integer|min:1',
            'target' => 'required|integer|min:1',
            'specific_target' => 'required|integer|min:1',
            'current_achievement' => 'nullable|integer|min:0',
            'key_result' => 'required|string',
            'need_team_assignment' => 'boolean',
            'need_hrd_support' => 'boolean',
            'need_facility_support' => 'boolean',
            'need_digitalization_support' => 'boolean',
            'need_financial_support' => 'boolean',
            'additional_notes' => 'nullable|string',
            'proposal_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'evidence_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        // Set default values for checkboxes
        $validated['need_team_assignment'] = $request->has('need_team_assignment');
        $validated['need_hrd_support'] = $request->has('need_hrd_support');
        $validated['need_facility_support'] = $request->has('need_facility_support');
        $validated['need_digitalization_support'] = $request->has('need_digitalization_support');
        $validated['need_financial_support'] = $request->has('need_financial_support');

        // Set current achievement default
        $validated['current_achievement'] = $validated['current_achievement'] ?? 0;

        // Handle file uploads
        if ($request->hasFile('proposal_document')) {
            $file = $request->file('proposal_document');
            $filename = time() . '_proposal_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/projects'), $filename);
            $validated['proposal_document'] = $filename;
            $validated['proposal_document_original_name'] = $file->getClientOriginalName();
        }

        if ($request->hasFile('evidence_document')) {
            $file = $request->file('evidence_document');
            $filename = time() . '_evidence_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/projects'), $filename);
            $validated['evidence_document'] = $filename;
            $validated['evidence_document_original_name'] = $file->getClientOriginalName();
        }

        // Set status based on action
        if ($request->input('action') === 'submit') {
            $validated['status'] = 'pending';
        } else {
            $validated['status'] = 'draft';
        }

        Project::create($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil ' . ($validated['status'] === 'pending' ? 'diajukan' : 'disimpan sebagai draft'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['submitter', 'submitterPosition', 'initiator', 'initiatorPosition', 'approver']);
        
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        // Check if project can be edited
        if (!$project->canBeEdited()) {
            return redirect()->route('projects.index')
                ->with('error', 'Proyek tidak dapat diedit karena sudah diajukan atau disetujui');
        }

        $employees = Employee::with(['workUnit', 'position'])
            ->select('id', 'full_name', 'employee_id', 'work_unit_id', 'position_id')
            ->get();

        $positions = Position::select('id', 'name')->get();

        return view('projects.edit', compact('project', 'employees', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        // Check if project can be edited
        if (!$project->canBeEdited()) {
            return redirect()->route('projects.index')
                ->with('error', 'Proyek tidak dapat diedit karena sudah diajukan atau disetujui');
        }

        $validated = $request->validate([
            'submission_date' => 'required|date',
            'submitter_employee_id' => 'required|exists:employees,id',
            'submitter_position_id' => 'required|exists:positions,id',
            'initiator_employee_id' => 'required|exists:employees,id',
            'initiator_position_id' => 'required|exists:positions,id',
            'objective' => 'required|string',
            'program_name' => 'required|string|max:255',
            'program_code' => 'required|string|max:50',
            'activity_name' => 'required|string|max:255',
            'activity_code' => 'required|string|max:50',
            'project_name' => 'required|string|max:255',
            'project_sequence_number' => 'required|integer|min:1',
            'target' => 'required|integer|min:1',
            'specific_target' => 'required|integer|min:1',
            'current_achievement' => 'nullable|integer|min:0',
            'key_result' => 'required|string',
            'need_team_assignment' => 'boolean',
            'need_hrd_support' => 'boolean',
            'need_facility_support' => 'boolean',
            'need_digitalization_support' => 'boolean',
            'need_financial_support' => 'boolean',
            'additional_notes' => 'nullable|string',
        ]);

        // Set default values for checkboxes
        $validated['need_team_assignment'] = $request->has('need_team_assignment');
        $validated['need_hrd_support'] = $request->has('need_hrd_support');
        $validated['need_facility_support'] = $request->has('need_facility_support');
        $validated['need_digitalization_support'] = $request->has('need_digitalization_support');
        $validated['need_financial_support'] = $request->has('need_financial_support');

        // Set current achievement default
        $validated['current_achievement'] = $validated['current_achievement'] ?? 0;

        // Set status based on action
        if ($request->input('action') === 'submit') {
            $validated['status'] = 'submitted';
        } else {
            $validated['status'] = 'draft';
        }

        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil ' . ($validated['status'] === 'submitted' ? 'diajukan' : 'diperbarui'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Check if project can be deleted (only draft and rejected)
        if (!$project->canBeEdited()) {
            return redirect()->route('projects.index')
                ->with('error', 'Proyek tidak dapat dihapus karena sudah diajukan atau disetujui');
        }

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil dihapus');
    }

    /**
     * Approve project
     */
    public function approve(Request $request, Project $project)
    {
        if (!$project->canBeApproved()) {
            return redirect()->route('projects.index')
                ->with('error', 'Proyek tidak dapat disetujui');
        }

        $user = Auth::user();
        $approver = Employee::where('user_id', $user->id)->first();

        $project->update([
            'status' => 'approved',
            'approved_by' => $approver->id,
            'approved_at' => now(),
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil disetujui');
    }

    /**
     * Reject project
     */
    public function reject(Request $request, Project $project)
    {
        if (!$project->canBeApproved()) {
            return redirect()->route('projects.index')
                ->with('error', 'Proyek tidak dapat ditolak');
        }

        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $project->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil ditolak');
    }

    /**
     * Start project (change status to in_progress)
     */
    public function start(Project $project)
    {
        if (!$project->canBeStarted()) {
            return redirect()->route('projects.index')
                ->with('error', 'Proyek tidak dapat dimulai');
        }

        $project->update(['status' => 'in_progress']);

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil dimulai');
    }

    /**
     * Complete project
     */
    public function complete(Project $project)
    {
        if ($project->status !== 'in_progress') {
            return redirect()->route('projects.index')
                ->with('error', 'Hanya proyek yang sedang berjalan yang dapat diselesaikan');
        }

        $project->update(['status' => 'completed']);

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil diselesaikan');
    }

    /**
     * Update project progress
     */
    public function updateProgress(Request $request, Project $project)
    {
        $request->validate([
            'current_achievement' => 'required|integer|min:0|max:' . $project->target,
        ]);

        $project->update([
            'current_achievement' => $request->current_achievement,
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Progress proyek berhasil diperbarui');
    }

    /**
     * Generate project report (Surat Pengajuan)
     */
    public function generateReport(Project $project)
    {
        $project->load(['submitter', 'submitterPosition', 'initiator', 'initiatorPosition', 'approver']);
        
        return view('projects.report', compact('project'));
    }
}
