<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sikoja;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SikojaController extends Controller
{
    /**
     * Display a listing of SIKOJA
     */
    public function index(Request $request)
    {
        $query = Project::with(['submitter', 'submitterPosition', 'initiator', 'initiatorPosition'])
            ->whereIn('status', ['approved', 'in_progress', 'completed'])
            ->orderBy('submission_date', 'desc');

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%")
                  ->orWhere('final_project_code', 'like', "%{$search}%")
                  ->orWhere('objective', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan program
        if ($request->filled('program')) {
            $query->where('program_name', 'like', "%{$request->program}%");
        }

        $projects = $query->paginate(10);

        return view('sikojas.index', compact('projects'));
    }

    /**
     * Show the form for creating a new SIKOJA
     */
    public function create(Project $project)
    {
        // Check if SIKOJA already exists for this project
        if ($project->sikoja) {
            return redirect()->route('sikojas.edit', $project->sikoja)
                ->with('info', 'SIKOJA untuk proyek ini sudah ada. Anda dapat mengeditnya.');
        }

        $employees = Employee::select('id', 'full_name', 'employee_id')->get();
        $cooperationTypes = Sikoja::getCooperationTypeOptions();

        return view('sikojas.create', compact('project', 'employees', 'cooperationTypes'));
    }

    /**
     * Store a newly created SIKOJA
     */
    public function store(Request $request, Project $project)
    {
        $user = Auth::user();
        $creator = Employee::where('user_id', $user->id)->first();

        if (!$creator) {
            return redirect()->back()->with('error', 'Employee record tidak ditemukan untuk user ini.');
        }

        $validated = $request->validate([
            'situation_description' => 'nullable|string',
            'output_description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'budget_amount' => 'nullable|numeric|min:0',
            'budget_include_tax' => 'boolean',
            'budget_notes' => 'nullable|string',
            'cooperation_type' => 'nullable|in:mou,spk,cl_loa,other',
            'cooperation_other' => 'nullable|string|max:255',
            'cooperation_number' => 'nullable|string|max:255',
            'cooperation_date' => 'nullable|date',
            'other_verifier_type' => 'nullable|string|max:255',
        ]);

        $validated['project_id'] = $project->id;
        $validated['created_by'] = $creator->id;
        $validated['budget_include_tax'] = $request->has('budget_include_tax');

        $sikoja = Sikoja::create($validated);

        return redirect()->route('sikojas.show', $sikoja)
            ->with('success', 'SIKOJA berhasil dibuat dengan nomor: ' . $sikoja->sikoja_number);
    }

    /**
     * Display the specified SIKOJA
     */
    public function show(Sikoja $sikoja)
    {
        $sikoja->load([
            'project.submitter', 'project.submitterPosition', 
            'project.initiator', 'project.initiatorPosition',
            'creator', 'pmoVerifier', 'financeVerifier', 'otherVerifier'
        ]);

        return view('sikojas.show', compact('sikoja'));
    }

    /**
     * Show the form for editing SIKOJA
     */
    public function edit(Sikoja $sikoja)
    {
        if (!$sikoja->canBeEdited()) {
            return redirect()->route('sikojas.show', $sikoja)
                ->with('error', 'SIKOJA tidak dapat diedit karena sudah dalam proses verifikasi atau sudah terverifikasi.');
        }

        $employees = Employee::select('id', 'full_name', 'employee_id')->get();
        $cooperationTypes = Sikoja::getCooperationTypeOptions();

        return view('sikojas.edit', compact('sikoja', 'employees', 'cooperationTypes'));
    }

    /**
     * Update SIKOJA
     */
    public function update(Request $request, Sikoja $sikoja)
    {
        if (!$sikoja->canBeEdited()) {
            return redirect()->route('sikojas.show', $sikoja)
                ->with('error', 'SIKOJA tidak dapat diedit karena sudah dalam proses verifikasi atau sudah terverifikasi.');
        }

        $user = Auth::user();
        $updater = Employee::where('user_id', $user->id)->first();

        $validated = $request->validate([
            'situation_description' => 'nullable|string',
            'output_description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'budget_amount' => 'nullable|numeric|min:0',
            'budget_include_tax' => 'boolean',
            'budget_notes' => 'nullable|string',
            'cooperation_type' => 'nullable|in:mou,spk,cl_loa,other',
            'cooperation_other' => 'nullable|string|max:255',
            'cooperation_number' => 'nullable|string|max:255',
            'cooperation_date' => 'nullable|date',
            'other_verifier_type' => 'nullable|string|max:255',
        ]);

        $validated['updated_by'] = $updater->id ?? null;
        $validated['budget_include_tax'] = $request->has('budget_include_tax');

        $sikoja->update($validated);

        return redirect()->route('sikojas.show', $sikoja)
            ->with('success', 'SIKOJA berhasil diperbarui.');
    }

    /**
     * Generate SIKOJA form for a project (original method, now enhanced)
     */
    public function generateSikoja(Project $project)
    {
        $project->load(['submitter', 'submitterPosition', 'initiator', 'initiatorPosition', 'approver', 'sikoja']);
        
        // If SIKOJA exists, use data from database
        if ($project->sikoja) {
            $project->sikoja->load(['pmoVerifier', 'financeVerifier', 'otherVerifier']);
        }
        
        return view('projects.sikoja', compact('project'));
    }

    /**
     * Submit SIKOJA for verification
     */
    public function submit(Sikoja $sikoja)
    {
        if ($sikoja->status !== 'draft') {
            return redirect()->route('sikojas.show', $sikoja)
                ->with('error', 'SIKOJA sudah diajukan untuk verifikasi.');
        }

        $sikoja->update(['status' => 'pending_verification']);

        return redirect()->route('sikojas.show', $sikoja)
            ->with('success', 'SIKOJA berhasil diajukan untuk verifikasi.');
    }

    /**
     * Verify SIKOJA by PMO
     */
    public function verifyPmo(Request $request, Sikoja $sikoja)
    {
        if (!$sikoja->canBeVerified()) {
            return redirect()->route('sikojas.show', $sikoja)
                ->with('error', 'SIKOJA tidak dapat diverifikasi.');
        }

        $user = Auth::user();
        $verifier = Employee::where('user_id', $user->id)->first();

        $request->validate([
            'pmo_notes' => 'nullable|string',
        ]);

        $sikoja->update([
            'verified_by_pmo' => true,
            'pmo_verifier_id' => $verifier->id,
            'pmo_verified_at' => now(),
            'pmo_notes' => $request->pmo_notes,
        ]);

        $sikoja->updateStatusBasedOnVerification();

        return redirect()->route('sikojas.show', $sikoja)
            ->with('success', 'SIKOJA berhasil diverifikasi oleh PMO.');
    }

    /**
     * Verify SIKOJA by Finance
     */
    public function verifyFinance(Request $request, Sikoja $sikoja)
    {
        if (!$sikoja->canBeVerified()) {
            return redirect()->route('sikojas.show', $sikoja)
                ->with('error', 'SIKOJA tidak dapat diverifikasi.');
        }

        $user = Auth::user();
        $verifier = Employee::where('user_id', $user->id)->first();

        $request->validate([
            'finance_notes' => 'nullable|string',
        ]);

        $sikoja->update([
            'verified_by_finance' => true,
            'finance_verifier_id' => $verifier->id,
            'finance_verified_at' => now(),
            'finance_notes' => $request->finance_notes,
        ]);

        $sikoja->updateStatusBasedOnVerification();

        return redirect()->route('sikojas.show', $sikoja)
            ->with('success', 'SIKOJA berhasil diverifikasi oleh Finance.');
    }

    /**
     * Verify SIKOJA by Other
     */
    public function verifyOther(Request $request, Sikoja $sikoja)
    {
        if (!$sikoja->canBeVerified()) {
            return redirect()->route('sikojas.show', $sikoja)
                ->with('error', 'SIKOJA tidak dapat diverifikasi.');
        }

        $user = Auth::user();
        $verifier = Employee::where('user_id', $user->id)->first();

        $request->validate([
            'other_notes' => 'nullable|string',
        ]);

        $sikoja->update([
            'verified_by_other' => true,
            'other_verifier_id' => $verifier->id,
            'other_verified_at' => now(),
            'other_notes' => $request->other_notes,
        ]);

        $sikoja->updateStatusBasedOnVerification();

        return redirect()->route('sikojas.show', $sikoja)
            ->with('success', 'SIKOJA berhasil diverifikasi.');
    }

    /**
     * Reject SIKOJA
     */
    public function reject(Request $request, Sikoja $sikoja)
    {
        if (!$sikoja->canBeVerified()) {
            return redirect()->route('sikojas.show', $sikoja)
                ->with('error', 'SIKOJA tidak dapat ditolak.');
        }

        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $sikoja->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('sikojas.show', $sikoja)
            ->with('success', 'SIKOJA berhasil ditolak.');
    }
}
