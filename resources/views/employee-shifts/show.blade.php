<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Shift Kerja Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Detail Shift Kerja</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('employee-shifts.edit', $employeeShift) }}" 
                               class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            <a href="{{ route('employee-shifts.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Informasi Karyawan -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Informasi Karyawan</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama Karyawan
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $employeeShift->employee_name }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    NIP/NIK
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $employeeShift->nip_nik }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Shift -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Informasi Shift</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tanggal
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $employeeShift->shift_date->format('d/m/Y') }}
                                    <span class="text-gray-500 dark:text-gray-400">
                                        ({{ $employeeShift->shift_date->format('l') }})
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Shift
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $employeeShift->shift_name }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Jam Mulai Kerja
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $employeeShift->formatted_start_time }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Jam Selesai Kerja
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $employeeShift->formatted_end_time }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Durasi Shift
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $employeeShift->formatted_shift_duration }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Lokasi Kerja
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $employeeShift->work_location }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Kehadiran -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Informasi Kehadiran</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Status Kehadiran
                                </label>
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $employeeShift->attendance_status_badge_class }}">
                                        {{ $employeeShift->attendance_status_name }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Jenis Hari Kerja
                                </label>
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $employeeShift->work_day_type_badge_class }}">
                                        {{ $employeeShift->work_day_type_name }}
                                    </span>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama Atasan/PIC
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $employeeShift->supervisor_name }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    @if($employeeShift->shift_notes)
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Catatan Shift</h4>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">
                                {{ $employeeShift->shift_notes }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Informasi Sistem -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">Informasi Sistem</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tanggal Dibuat
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $employeeShift->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Terakhir Diperbarui
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $employeeShift->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </div>

                            @if($employeeShift->data_updated_at)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tanggal Update Data
                                </label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $employeeShift->data_updated_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                        <form action="{{ route('employee-shifts.destroy', $employeeShift) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data shift ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Hapus Shift
                            </button>
                        </form>
                        
                        <a href="{{ route('employee-shifts.edit', $employeeShift) }}" 
                           class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Edit Shift
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
