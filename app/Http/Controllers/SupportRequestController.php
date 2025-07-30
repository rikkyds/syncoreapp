<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use App\Models\PptDetail;
use App\Models\PdkDetail;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class SupportRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supportRequests = SupportRequest::with(['project', 'requesterEmployee', 'approvedByEmployee'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('support-requests.index', compact('supportRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->get('type', 'ppt'); // Default to PPT
        $projectId = $request->get('project_id');
        
        $projects = Project::all();
        $employees = Employee::all();
        
        $project = null;
        if ($projectId) {
            $project = Project::find($projectId);
        }

        return view('support-requests.create', compact('type', 'projects', 'employees', 'project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'request_type' => 'required|in:ppt,pdh,pds,pdd,pdk',
            'request_date' => 'required|date',
        ]);

        DB::beginTransaction();
        
        try {
            // Generate request number
            $requestNumber = $this->generateRequestNumber($request->request_type);
            
            // Create support request
            $supportRequest = SupportRequest::create([
                'project_id' => $request->project_id,
                'request_type' => $request->request_type,
                'request_number' => $requestNumber,
                'request_date' => $request->request_date,
                'requester_employee_id' => Auth::user()->employee_id ?? 1, // Fallback for testing
                'status' => 'draft',
                'total_request' => $request->total_request ?? 0,
                'program_budget' => $request->program_budget ?? 0,
                'contribution' => $request->contribution ?? 0,
                'tax_included' => $request->has('tax_included'),
                'budget_notes' => $request->budget_notes,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            // Handle PPT details
            if ($request->request_type === 'ppt' && $request->has('ppt_details')) {
                foreach ($request->ppt_details as $detail) {
                    if (!empty($detail['business_process'])) {
                        PptDetail::create([
                            'support_request_id' => $supportRequest->id,
                            'business_process' => $detail['business_process'],
                            'function_type' => $detail['function_type'],
                            'role' => $detail['role'],
                            'assigned_employee_id' => $detail['assigned_employee_id'] ?? null,
                            'task_description' => $detail['task_description'],
                            'output_description' => $detail['output_description'],
                            'start_date' => $detail['start_date'],
                            'end_date' => $detail['end_date'],
                            'location' => $detail['location'],
                            'status' => 'pending',
                        ]);
                    }
                }
            }

            // Handle PDK details
            if ($request->request_type === 'pdk' && $request->has('pdk_details')) {
                $totalRequest = 0;
                foreach ($request->pdk_details as $detail) {
                    if (!empty($detail['activity_name'])) {
                        $totalPrice = ($detail['volume'] ?? 0) * ($detail['unit_price'] ?? 0);
                        $totalRequest += $totalPrice;
                        
                        PdkDetail::create([
                            'support_request_id' => $supportRequest->id,
                            'cost_category' => $detail['cost_category'],
                            'activity_name' => $detail['activity_name'],
                            'description' => $detail['description'],
                            'volume' => $detail['volume'] ?? 0,
                            'unit' => $detail['unit'],
                            'unit_price' => $detail['unit_price'] ?? 0,
                            'total_price' => $totalPrice,
                            'sort_order' => $detail['sort_order'] ?? 1,
                            'notes' => $detail['notes'],
                        ]);
                    }
                }
                
                // Update total request
                $supportRequest->update(['total_request' => $totalRequest]);
            }

            DB::commit();
            
            return redirect()->route('support-requests.show', $supportRequest)
                ->with('success', 'Formulir pengajuan berhasil dibuat!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportRequest $supportRequest)
    {
        $supportRequest->load([
            'project', 
            'requesterEmployee', 
            'approvedByEmployee',
            'financeVerifier',
            'pptDetails.assignedEmployee',
            'pdkDetails'
        ]);

        return view('support-requests.show', compact('supportRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportRequest $supportRequest)
    {
        if ($supportRequest->status !== 'draft') {
            return redirect()->route('support-requests.show', $supportRequest)
                ->with('error', 'Hanya formulir dengan status draft yang dapat diedit.');
        }

        $supportRequest->load(['pptDetails', 'pdkDetails']);
        $projects = Project::all();
        $employees = Employee::all();

        return view('support-requests.edit', compact('supportRequest', 'projects', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupportRequest $supportRequest)
    {
        if ($supportRequest->status !== 'draft') {
            return redirect()->route('support-requests.show', $supportRequest)
                ->with('error', 'Hanya formulir dengan status draft yang dapat diedit.');
        }

        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'request_date' => 'required|date',
        ]);

        DB::beginTransaction();
        
        try {
            // Update support request
            $supportRequest->update([
                'project_id' => $request->project_id,
                'request_date' => $request->request_date,
                'total_request' => $request->total_request ?? 0,
                'program_budget' => $request->program_budget ?? 0,
                'contribution' => $request->contribution ?? 0,
                'tax_included' => $request->has('tax_included'),
                'budget_notes' => $request->budget_notes,
                'updated_by' => Auth::id(),
            ]);

            // Update PPT details
            if ($supportRequest->request_type === 'ppt') {
                $supportRequest->pptDetails()->delete();
                
                if ($request->has('ppt_details')) {
                    foreach ($request->ppt_details as $detail) {
                        if (!empty($detail['business_process'])) {
                            PptDetail::create([
                                'support_request_id' => $supportRequest->id,
                                'business_process' => $detail['business_process'],
                                'function_type' => $detail['function_type'],
                                'role' => $detail['role'],
                                'assigned_employee_id' => $detail['assigned_employee_id'] ?? null,
                                'task_description' => $detail['task_description'],
                                'output_description' => $detail['output_description'],
                                'start_date' => $detail['start_date'],
                                'end_date' => $detail['end_date'],
                                'location' => $detail['location'],
                                'status' => 'pending',
                            ]);
                        }
                    }
                }
            }

            // Update PDK details
            if ($supportRequest->request_type === 'pdk') {
                $supportRequest->pdkDetails()->delete();
                
                $totalRequest = 0;
                if ($request->has('pdk_details')) {
                    foreach ($request->pdk_details as $detail) {
                        if (!empty($detail['activity_name'])) {
                            $totalPrice = ($detail['volume'] ?? 0) * ($detail['unit_price'] ?? 0);
                            $totalRequest += $totalPrice;
                            
                            PdkDetail::create([
                                'support_request_id' => $supportRequest->id,
                                'cost_category' => $detail['cost_category'],
                                'activity_name' => $detail['activity_name'],
                                'description' => $detail['description'],
                                'volume' => $detail['volume'] ?? 0,
                                'unit' => $detail['unit'],
                                'unit_price' => $detail['unit_price'] ?? 0,
                                'total_price' => $totalPrice,
                                'sort_order' => $detail['sort_order'] ?? 1,
                                'notes' => $detail['notes'],
                            ]);
                        }
                    }
                }
                
                $supportRequest->update(['total_request' => $totalRequest]);
            }

            DB::commit();
            
            return redirect()->route('support-requests.show', $supportRequest)
                ->with('success', 'Formulir pengajuan berhasil diperbarui!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportRequest $supportRequest)
    {
        if ($supportRequest->status !== 'draft') {
            return redirect()->route('support-requests.index')
                ->with('error', 'Hanya formulir dengan status draft yang dapat dihapus.');
        }

        $supportRequest->delete();
        
        return redirect()->route('support-requests.index')
            ->with('success', 'Formulir pengajuan berhasil dihapus!');
    }

    /**
     * Submit the support request for approval
     */
    public function submit(SupportRequest $supportRequest)
    {
        if ($supportRequest->status !== 'draft') {
            return redirect()->route('support-requests.show', $supportRequest)
                ->with('error', 'Formulir ini sudah disubmit.');
        }

        $supportRequest->update([
            'status' => 'submitted',
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('support-requests.show', $supportRequest)
            ->with('success', 'Formulir pengajuan berhasil disubmit untuk persetujuan!');
    }

    /**
     * Approve the support request
     */
    public function approve(SupportRequest $supportRequest)
    {
        if ($supportRequest->status !== 'submitted') {
            return redirect()->route('support-requests.show', $supportRequest)
                ->with('error', 'Formulir ini tidak dapat disetujui.');
        }

        $supportRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::user()->employee_id ?? 1,
            'approved_at' => now(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('support-requests.show', $supportRequest)
            ->with('success', 'Formulir pengajuan berhasil disetujui!');
    }

    /**
     * Reject the support request
     */
    public function reject(Request $request, SupportRequest $supportRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        if ($supportRequest->status !== 'submitted') {
            return redirect()->route('support-requests.show', $supportRequest)
                ->with('error', 'Formulir ini tidak dapat ditolak.');
        }

        $supportRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('support-requests.show', $supportRequest)
            ->with('success', 'Formulir pengajuan berhasil ditolak!');
    }

    /**
     * Export support request to PDF
     */
    public function exportPdf(SupportRequest $supportRequest)
    {
        $supportRequest->load([
            'project', 
            'requesterEmployee', 
            'approvedByEmployee',
            'financeVerifier',
            'pptDetails.assignedEmployee',
            'pdkDetails'
        ]);

        $pdf = Pdf::loadView('support-requests.pdf', compact('supportRequest'));
        
        $filename = 'formulir-pengajuan-' . $supportRequest->request_number . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Export support requests to Excel
     */
    public function exportExcel(Request $request)
    {
        $query = SupportRequest::with(['project', 'requesterEmployee', 'approvedByEmployee']);
        
        // Apply filters if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('type')) {
            $query->where('request_type', $request->type);
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('request_date', [$request->start_date, $request->end_date]);
        }
        
        $supportRequests = $query->get();
        
        return Excel::create('formulir-pengajuan-' . date('Y-m-d'), function($excel) use ($supportRequests) {
            $excel->sheet('Formulir Pengajuan', function($sheet) use ($supportRequests) {
                // Headers
                $sheet->row(1, [
                    'No',
                    'Nomor Pengajuan',
                    'Jenis',
                    'Tanggal Pengajuan',
                    'Proyek',
                    'Pengaju',
                    'Status',
                    'Total Pengajuan',
                    'Tanggal Disetujui'
                ]);
                
                // Data
                $row = 2;
                foreach ($supportRequests as $index => $sr) {
                    $sheet->row($row, [
                        $index + 1,
                        $sr->request_number,
                        $sr->type_label,
                        $sr->request_date->format('d/m/Y'),
                        $sr->project->project_name ?? '-',
                        $sr->requesterEmployee->full_name ?? '-',
                        $sr->status_label,
                        'Rp ' . number_format($sr->total_request, 0, ',', '.'),
                        $sr->approved_at ? $sr->approved_at->format('d/m/Y') : '-'
                    ]);
                    $row++;
                }
                
                // Styling
                $sheet->row(1, function($row) {
                    $row->setBackground('#4472C4');
                    $row->setFontColor('#FFFFFF');
                    $row->setFontWeight('bold');
                });
            });
        })->download('xlsx');
    }

    /**
     * Generate request number based on type
     */
    private function generateRequestNumber($type)
    {
        $prefix = strtoupper($type);
        $year = date('Y');
        $month = date('m');
        
        $lastRequest = SupportRequest::where('request_type', $type)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastRequest ? (int)substr($lastRequest->request_number, -4) + 1 : 1;
        
        return sprintf('%s/%s/%s/%04d', $prefix, $year, $month, $sequence);
    }
}
