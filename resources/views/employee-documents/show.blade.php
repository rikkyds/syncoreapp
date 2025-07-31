<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detail Dokumen Karyawan
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Informasi lengkap dokumen {{ $employeeDocument->document_type_name }}
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('employee-documents.edit', $employeeDocument) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('employee-documents.destroy', $employeeDocument) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors duration-200"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Document Information -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold">Informasi Dokumen</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Jenis Dokumen</label>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $employeeDocument->document_type_badge_class }}">
                                            {{ $employeeDocument->document_type_name }}
                                        </span>
                                    </div>
                                </div>
                                
                                @if($employeeDocument->document_number)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nomor Dokumen</label>
                                    <p class="text-gray-900">{{ $employeeDocument->document_number }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Tanggal Terbit</label>
                                    <p class="text-gray-900">{{ $employeeDocument->issue_date->format('d F Y') }}</p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Tanggal Berlaku</label>
                                    <p class="text-gray-900">{{ $employeeDocument->effective_date->format('d F Y') }}</p>
                                </div>
                                
                                @if($employeeDocument->expiry_date)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Tanggal Kadaluarsa</label>
                                    <p class="text-gray-900">
                                        {{ $employeeDocument->expiry_date->format('d F Y') }}
                                        @if($employeeDocument->is_expired)
                                            <span class="inline-flex items-center ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Kadaluarsa
                                            </span>
                                        @elseif($employeeDocument->is_expiring_soon)
                                            <span class="inline-flex items-center ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Segera Kadaluarsa ({{ $employeeDocument->days_until_expiry }} hari lagi)
                                            </span>
                                        @endif
                                    </p>
                                </div>
                                @endif
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Penandatangan</label>
                                    <p class="text-gray-900">{{ $employeeDocument->signatory }}</p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Status Dokumen</label>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $employeeDocument->document_status_badge_class }}">
                                            {{ $employeeDocument->document_status_name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employee Information -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold">Informasi Karyawan</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Nama Karyawan</label>
                                    <p class="text-gray-900">{{ $employeeDocument->employee_name }}</p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">NIP/NIK</label>
                                    <p class="text-gray-900">{{ $employeeDocument->nip_nik }}</p>
                                </div>
                                
                                @if($employeeDocument->employee)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Jabatan</label>
                                    <p class="text-gray-900">{{ $employeeDocument->employee->position->name ?? '-' }}</p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Unit Kerja</label>
                                    <p class="text-gray-900">{{ $employeeDocument->employee->workUnit->name ?? '-' }}</p>
                                </div>
                                @endif
                                
                                <div class="pt-4">
                                    <a href="{{ route('employees.show', $employeeDocument->employee_id) }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Lihat Detail Karyawan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Storage Information -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold">Informasi Penyimpanan</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Lokasi Penyimpanan</label>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $employeeDocument->storage_location_badge_class }}">
                                            {{ $employeeDocument->storage_location_name }}
                                        </span>
                                    </div>
                                </div>
                                
                                @if($employeeDocument->has_file)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">File Dokumen</label>
                                    <div class="mt-2 flex items-center space-x-2">
                                        <div class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                            @php
                                                $extension = $employeeDocument->file_extension;
                                                $iconClass = match(strtolower($extension)) {
                                                    'pdf' => 'text-red-600',
                                                    'doc', 'docx' => 'text-blue-600',
                                                    'jpg', 'jpeg', 'png' => 'text-green-600',
                                                    default => 'text-gray-600'
                                                };
                                            @endphp
                                            <svg class="w-6 h-6 {{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ basename($employeeDocument->file_path) }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ strtoupper($employeeDocument->file_extension) }} · {{ $employeeDocument->file_size }}
                                            </p>
                                        </div>
                                        <div>
                                            <a href="{{ route('employee-documents.download', $employeeDocument) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div>
                                    <label class="text-sm font-medium text-gray-500">File Dokumen</label>
                                    <p class="text-gray-500 italic">Tidak ada file yang diunggah</p>
                                </div>
                                @endif
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Terakhir Diperbarui</label>
                                    <p class="text-gray-900">{{ $employeeDocument->data_updated_at->format('d F Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    @if($employeeDocument->additional_notes)
                    <div class="mt-6 bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold mb-3">Catatan Tambahan</h3>
                        <div class="prose max-w-none">
                            <p>{{ $employeeDocument->additional_notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-6 flex flex-wrap gap-4">
                        <a href="{{ route('employee-documents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                        
                        @if($employeeDocument->document_status !== 'arsip')
                        <form action="{{ route('employee-documents.archive', $employeeDocument) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                                Arsipkan
                            </button>
                        </form>
                        @else
                        <form action="{{ route('employee-documents.restore', $employeeDocument) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Pulihkan
                            </button>
                        </form>
                        @endif
                        
                        <a href="{{ route('employee-documents.duplicate', $employeeDocument) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Duplikasi
                        </a>
                        
                        @if($employeeDocument->is_expired || $employeeDocument->is_expiring_soon)
                        <a href="{{ route('employee-documents.renew', $employeeDocument) }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Perbarui Dokumen
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
