<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeDocumentController extends Controller
{
    public function index()
    {
        $documents = EmployeeDocument::with('employee')
            ->orderBy('issue_date', 'desc')
            ->paginate(10);
        
        return view('employee-documents.index', compact('documents'));
    }

    public function create()
    {
        $employees = Employee::with(['workUnit', 'position'])
            ->select('id', 'full_name', 'employee_id', 'nik', 'work_unit_id', 'position_id')
            ->get();
        
        $documentTypes = EmployeeDocument::getDocumentTypeOptions();
        $documentStatuses = EmployeeDocument::getDocumentStatusOptions();
        $storageLocations = EmployeeDocument::getStorageLocationOptions();
        
        return view('employee-documents.create', compact(
            'employees',
            'documentTypes',
            'documentStatuses',
            'storageLocations'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'employee_name' => 'required|string|max:255',
            'nip_nik' => 'required|string|max:255',
            'document_type' => 'required|in:' . implode(',', array_keys(EmployeeDocument::getDocumentTypeOptions())),
            'document_number' => 'nullable|string|max:255',
            'issue_date' => 'required|date',
            'effective_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:effective_date',
            'signatory' => 'required|string|max:255',
            'document_status' => 'required|in:' . implode(',', array_keys(EmployeeDocument::getDocumentStatusOptions())),
            'storage_location' => 'required|in:' . implode(',', array_keys(EmployeeDocument::getStorageLocationOptions())),
            'file_path' => 'nullable|string|max:500',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB max
            'additional_notes' => 'nullable|string',
        ]);

        // Handle file upload
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $filename, 'public');
            $validated['file_path'] = $path;
        }

        $validated['data_updated_at'] = now();

        EmployeeDocument::create($validated);

        return redirect()->route('employee-documents.index')
            ->with('success', 'Dokumen karyawan berhasil ditambahkan.');
    }

    public function show(EmployeeDocument $employeeDocument)
    {
        $employeeDocument->load('employee');
        return view('employee-documents.show', compact('employeeDocument'));
    }

    public function edit(EmployeeDocument $employeeDocument)
    {
        $employees = Employee::with(['workUnit', 'position'])
            ->select('id', 'full_name', 'employee_id', 'nik', 'work_unit_id', 'position_id')
            ->get();
        
        $documentTypes = EmployeeDocument::getDocumentTypeOptions();
        $documentStatuses = EmployeeDocument::getDocumentStatusOptions();
        $storageLocations = EmployeeDocument::getStorageLocationOptions();
        
        return view('employee-documents.edit', compact(
            'employeeDocument',
            'employees',
            'documentTypes',
            'documentStatuses',
            'storageLocations'
        ));
    }

    public function update(Request $request, EmployeeDocument $employeeDocument)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'employee_name' => 'required|string|max:255',
            'nip_nik' => 'required|string|max:255',
            'document_type' => 'required|in:' . implode(',', array_keys(EmployeeDocument::getDocumentTypeOptions())),
            'document_number' => 'nullable|string|max:255',
            'issue_date' => 'required|date',
            'effective_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:effective_date',
            'signatory' => 'required|string|max:255',
            'document_status' => 'required|in:' . implode(',', array_keys(EmployeeDocument::getDocumentStatusOptions())),
            'storage_location' => 'required|in:' . implode(',', array_keys(EmployeeDocument::getStorageLocationOptions())),
            'file_path' => 'nullable|string|max:500',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB max
            'additional_notes' => 'nullable|string',
        ]);

        // Handle file upload
        if ($request->hasFile('document_file')) {
            // Delete old file if exists
            if ($employeeDocument->file_path && Storage::disk('public')->exists($employeeDocument->file_path)) {
                Storage::disk('public')->delete($employeeDocument->file_path);
            }

            $file = $request->file('document_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $filename, 'public');
            $validated['file_path'] = $path;
        }

        $validated['data_updated_at'] = now();

        $employeeDocument->update($validated);

        return redirect()->route('employee-documents.index')
            ->with('success', 'Dokumen karyawan berhasil diperbarui.');
    }

    public function destroy(EmployeeDocument $employeeDocument)
    {
        // Delete file if exists
        if ($employeeDocument->file_path && Storage::disk('public')->exists($employeeDocument->file_path)) {
            Storage::disk('public')->delete($employeeDocument->file_path);
        }

        $employeeDocument->delete();

        return redirect()->route('employee-documents.index')
            ->with('success', 'Dokumen karyawan berhasil dihapus.');
    }

    // Additional methods for document management
    public function getByEmployee(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $documents = EmployeeDocument::with('employee')
            ->byEmployee($employeeId)
            ->orderBy('issue_date', 'desc')
            ->get();

        return response()->json($documents);
    }

    public function getByDocumentType(Request $request)
    {
        $documentType = $request->get('document_type');
        $documents = EmployeeDocument::with('employee')
            ->byDocumentType($documentType)
            ->orderBy('issue_date', 'desc')
            ->get();

        return response()->json($documents);
    }

    public function getActiveDocuments()
    {
        $documents = EmployeeDocument::with('employee')
            ->active()
            ->orderBy('issue_date', 'desc')
            ->get();

        return response()->json($documents);
    }

    public function getExpiredDocuments()
    {
        $documents = EmployeeDocument::with('employee')
            ->expired()
            ->orderBy('expiry_date', 'desc')
            ->get();

        return response()->json($documents);
    }

    public function getExpiringSoonDocuments()
    {
        $documents = EmployeeDocument::with('employee')
            ->expiringSoon()
            ->orderBy('expiry_date', 'asc')
            ->get();

        return response()->json($documents);
    }

    // Get employee data for AJAX
    public function getEmployeeData(Employee $employee)
    {
        return response()->json([
            'employee_name' => $employee->full_name,
            'nip_nik' => $employee->employee_id . ' / ' . $employee->nik,
        ]);
    }

    // Download document file
    public function downloadFile(EmployeeDocument $employeeDocument)
    {
        if (!$employeeDocument->has_file) {
            return redirect()->back()
                ->with('error', 'File dokumen tidak tersedia.');
        }

        $filePath = storage_path('app/public/' . $employeeDocument->file_path);
        
        if (!file_exists($filePath)) {
            return redirect()->back()
                ->with('error', 'File dokumen tidak ditemukan.');
        }

        return response()->download($filePath);
    }

    // Update document status
    public function updateStatus(Request $request, EmployeeDocument $employeeDocument)
    {
        $validated = $request->validate([
            'document_status' => 'required|in:' . implode(',', array_keys(EmployeeDocument::getDocumentStatusOptions())),
        ]);

        $employeeDocument->update([
            'document_status' => $validated['document_status'],
            'data_updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Status dokumen berhasil diperbarui.');
    }

    // Bulk operations
    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'document_ids' => 'required|array',
            'document_ids.*' => 'exists:employee_documents,id',
            'document_status' => 'required|in:' . implode(',', array_keys(EmployeeDocument::getDocumentStatusOptions())),
        ]);

        EmployeeDocument::whereIn('id', $validated['document_ids'])
            ->update([
                'document_status' => $validated['document_status'],
                'data_updated_at' => now(),
            ]);

        return redirect()->back()
            ->with('success', 'Status untuk ' . count($validated['document_ids']) . ' dokumen berhasil diperbarui.');
    }

    // Generate document report
    public function generateReport(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'document_type' => 'nullable|string',
            'document_status' => 'nullable|string',
            'storage_location' => 'nullable|string',
        ]);

        $query = EmployeeDocument::with('employee')
            ->whereBetween('issue_date', [$validated['start_date'], $validated['end_date']]);

        if ($validated['document_type'] ?? false) {
            $query->byDocumentType($validated['document_type']);
        }

        if ($validated['document_status'] ?? false) {
            $query->byStatus($validated['document_status']);
        }

        if ($validated['storage_location'] ?? false) {
            $query->byStorageLocation($validated['storage_location']);
        }

        $documents = $query->orderBy('issue_date', 'desc')->get();
        
        $statistics = [
            'total_documents' => $documents->count(),
            'active_documents' => $documents->where('document_status', 'aktif')->count(),
            'expired_documents' => $documents->filter(function($doc) {
                return $doc->is_expired;
            })->count(),
            'expiring_soon' => $documents->filter(function($doc) {
                return $doc->is_expiring_soon;
            })->count(),
            'with_files' => $documents->whereNotNull('file_path')->count(),
            'without_files' => $documents->whereNull('file_path')->count(),
        ];

        return response()->json([
            'documents' => $documents,
            'statistics' => $statistics,
            'period' => [
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ],
            'filters' => [
                'document_type' => $validated['document_type'] ?? null,
                'document_status' => $validated['document_status'] ?? null,
                'storage_location' => $validated['storage_location'] ?? null,
            ],
        ]);
    }

    // Get document statistics
    public function getStatistics(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $statistics = EmployeeDocument::getDocumentStatistics($employeeId);

        return response()->json($statistics);
    }

    // Archive document
    public function archive(EmployeeDocument $employeeDocument)
    {
        $employeeDocument->update([
            'document_status' => 'arsip',
            'data_updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Dokumen berhasil diarsipkan.');
    }

    // Restore archived document
    public function restore(EmployeeDocument $employeeDocument)
    {
        $employeeDocument->update([
            'document_status' => 'aktif',
            'data_updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Dokumen berhasil dipulihkan dari arsip.');
    }

    // Renew document (create new version)
    public function renew(EmployeeDocument $employeeDocument)
    {
        // Mark current document as updated
        $employeeDocument->update([
            'document_status' => 'diperbarui',
            'data_updated_at' => now(),
        ]);

        // Create new document based on current one
        $newDocument = $employeeDocument->replicate();
        $newDocument->document_status = 'draft';
        $newDocument->issue_date = now()->toDateString();
        $newDocument->effective_date = now()->toDateString();
        $newDocument->expiry_date = null;
        $newDocument->file_path = null;
        $newDocument->additional_notes = 'Pembaruan dari dokumen sebelumnya';
        $newDocument->data_updated_at = now();
        $newDocument->save();

        return redirect()->route('employee-documents.edit', $newDocument)
            ->with('success', 'Dokumen baru telah dibuat untuk pembaruan. Silakan lengkapi data yang diperlukan.');
    }

    // Get expiring documents notification
    public function getExpiringNotifications()
    {
        $expiringDocuments = EmployeeDocument::getExpiringDocuments(30);
        
        return response()->json([
            'count' => $expiringDocuments->count(),
            'documents' => $expiringDocuments->map(function($doc) {
                return [
                    'id' => $doc->id,
                    'employee_name' => $doc->employee_name,
                    'document_type_name' => $doc->document_type_name,
                    'expiry_date' => $doc->expiry_date->format('d/m/Y'),
                    'days_until_expiry' => $doc->days_until_expiry,
                ];
            }),
        ]);
    }

    // Duplicate document
    public function duplicate(EmployeeDocument $employeeDocument)
    {
        $newDocument = $employeeDocument->replicate();
        $newDocument->document_number = null;
        $newDocument->issue_date = now()->toDateString();
        $newDocument->effective_date = now()->toDateString();
        $newDocument->expiry_date = null;
        $newDocument->document_status = 'draft';
        $newDocument->file_path = null;
        $newDocument->additional_notes = 'Duplikasi dari dokumen ID: ' . $employeeDocument->id;
        $newDocument->data_updated_at = now();
        $newDocument->save();

        return redirect()->route('employee-documents.edit', $newDocument)
            ->with('success', 'Dokumen berhasil diduplikasi. Silakan sesuaikan data yang diperlukan.');
    }
}
