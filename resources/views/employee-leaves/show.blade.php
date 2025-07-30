<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Cuti Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Detail Cuti Karyawan</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('employee-leaves.edit', $employeeLeave) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            <a href="{{ route('employee-leaves.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informasi Karyawan -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-md font-semibold mb-3 text-gray-700">Informasi Karyawan</h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="font-medium text-gray-600">Nama Lengkap:</span>
                                    <span class="ml-2">{{ $employeeLeave->full_name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">NIP/NIK:</span>
                                    <span class="ml-2">{{ $employeeLeave->nip_nik }}</span>
                                </div>
                                @if($employeeLeave->employee)
                                <div>
                                    <span class="font-medium text-gray-600">Unit Kerja:</span>
                                    <span class="ml-2">{{ $employeeLeave->employee->workUnit->name ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Posisi:</span>
                                    <span class="ml-2">{{ $employeeLeave->employee->position->name ?? '-' }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Informasi Cuti -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-md font-semibold mb-3 text-gray-700">Informasi Cuti</h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="font-medium text-gray-600">Jenis Cuti:</span>
                                    <span class="ml-2">{{ $employeeLeave->leave_type_name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Tanggal Pengajuan:</span>
                                    <span class="ml-2">{{ $employeeLeave->application_date->format('d/m/Y') }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Tanggal Mulai:</span>
                                    <span class="ml-2">{{ $employeeLeave->start_date->format('d/m/Y') }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Tanggal Berakhir:</span>
                                    <span class="ml-2">{{ $employeeLeave->end_date->format('d/m/Y') }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Durasi:</span>
                                    <span class="ml-2">{{ $employeeLeave->duration_days }} hari</span>
                                </div>
                                @if($employeeLeave->return_to_work_date)
                                <div>
                                    <span class="font-medium text-gray-600">Tanggal Kembali Bekerja:</span>
                                    <span class="ml-2">{{ $employeeLeave->return_to_work_date->format('d/m/Y') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Status dan Persetujuan -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-md font-semibold mb-3 text-gray-700">Status dan Persetujuan</h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="font-medium text-gray-600">Status:</span>
                                    <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $employeeLeave->status_badge_class }}">
                                        {{ $employeeLeave->status_name }}
                                    </span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Nama Atasan:</span>
                                    <span class="ml-2">{{ $employeeLeave->supervisor_name }}</span>
                                </div>
                                @if($employeeLeave->remaining_leave_balance !== null)
                                <div>
                                    <span class="font-medium text-gray-600">Sisa Cuti Terakhir:</span>
                                    <span class="ml-2">{{ $employeeLeave->remaining_leave_balance }} hari</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-md font-semibold mb-3 text-gray-700">Informasi Tambahan</h4>
                            <div class="space-y-2">
                                @if($employeeLeave->leave_reason)
                                <div>
                                    <span class="font-medium text-gray-600">Alasan Cuti:</span>
                                    <p class="mt-1 text-gray-800">{{ $employeeLeave->leave_reason }}</p>
                                </div>
                                @endif
                                @if($employeeLeave->supporting_document)
                                <div>
                                    <span class="font-medium text-gray-600">Dokumen Pendukung:</span>
                                    <div class="mt-1">
                                        <a href="{{ Storage::url($employeeLeave->supporting_document) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                                            Lihat Dokumen
                                        </a>
                                    </div>
                                </div>
                                @endif
                                @if($employeeLeave->data_updated_at)
                                <div>
                                    <span class="font-medium text-gray-600">Terakhir Diperbarui:</span>
                                    <span class="ml-2">{{ $employeeLeave->data_updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons for Pending Status -->
                    @if($employeeLeave->status === 'pending')
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <h4 class="text-md font-semibold mb-3 text-yellow-800">Aksi Persetujuan</h4>
                        <div class="flex space-x-4">
                            <form action="{{ route('employee-leaves.approve', $employeeLeave) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Setujui cuti ini?')">
                                    Setujui Cuti
                                </button>
                            </form>
                            <form action="{{ route('employee-leaves.reject', $employeeLeave) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Tolak cuti ini?')">
                                    Tolak Cuti
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Timeline/History -->
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="text-md font-semibold mb-3 text-blue-800">Riwayat</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>Dibuat:</span>
                                <span>{{ $employeeLeave->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($employeeLeave->updated_at != $employeeLeave->created_at)
                            <div class="flex justify-between">
                                <span>Diperbarui:</span>
                                <span>{{ $employeeLeave->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
