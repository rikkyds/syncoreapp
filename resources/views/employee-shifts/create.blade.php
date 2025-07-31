<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Shift Kerja Karyawan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('employee-shifts.store') }}" method="POST">
                        @csrf

                        <!-- Informasi Karyawan -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Karyawan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="employee_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Pilih Karyawan
                                    </label>
                                    <select name="employee_id" id="employee_id" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" 
                                                {{ old('employee_id') == $employee->id ? 'selected' : '' }}
                                                {{ isset($selectedEmployee) && $selectedEmployee->id == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->full_name }} ({{ $employee->employee_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="employee_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Nama Lengkap
                                    </label>
                                    <input type="text" name="employee_name" id="employee_name" 
                                           value="{{ old('employee_name') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           readonly>
                                    @error('employee_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="nip_nik" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        NIP/NIK
                                    </label>
                                    <input type="text" name="nip_nik" id="nip_nik" 
                                           value="{{ old('nip_nik') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           readonly>
                                    @error('nip_nik')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Shift -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Shift</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="shift_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Tanggal
                                    </label>
                                    <input type="date" name="shift_date" id="shift_date" 
                                           value="{{ old('shift_date', date('Y-m-d')) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                    @error('shift_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shift_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Shift
                                    </label>
                                    <select name="shift_name" id="shift_name" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required>
                                        <option value="">-- Pilih Shift --</option>
                                        @foreach($shiftNames as $key => $value)
                                            <option value="{{ $key }}" {{ old('shift_name') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shift_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Jam Mulai Kerja
                                    </label>
                                    <input type="time" name="start_time" id="start_time" 
                                           value="{{ old('start_time') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                    @error('start_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Jam Selesai Kerja
                                    </label>
                                    <input type="time" name="end_time" id="end_time" 
                                           value="{{ old('end_time') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                    @error('end_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="work_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Lokasi Kerja
                                    </label>
                                    <select name="work_location" id="work_location" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required>
                                        <option value="">-- Pilih Lokasi Kerja --</option>
                                        @foreach($workLocations as $location)
                                            <option value="{{ $location->name }}" {{ old('work_location') == $location->name ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('work_location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Tambahan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="work_day_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Jenis Hari Kerja
                                    </label>
                                    <select name="work_day_type" id="work_day_type" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required>
                                        @foreach($workDayTypes as $key => $value)
                                            <option value="{{ $key }}" {{ old('work_day_type', 'hari_biasa') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('work_day_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="supervisor_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Nama Atasan/PIC
                                    </label>
                                    <input type="text" name="supervisor_name" id="supervisor_name" 
                                           value="{{ old('supervisor_name') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                    @error('supervisor_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                            <div class="mt-4">
                                <label for="shift_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Catatan Shift
                                </label>
                                <textarea name="shift_notes" id="shift_notes" rows="4" 
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                          placeholder="Catatan tambahan, pergantian shift, atau instruksi khusus...">{{ old('shift_notes') }}</textarea>
                                @error('shift_notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('employee-shifts.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                BATAL
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                SIMPAN SHIFT
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to load employee data
        function loadEmployeeData(employeeId) {
            if (employeeId) {
                fetch(`/employees/${employeeId}/shift-data`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('employee_name').value = data.employee_name;
                        document.getElementById('nip_nik').value = data.nip_nik;
                        if (data.work_location) {
                            document.getElementById('work_location').value = data.work_location;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('employee_name').value = '';
                document.getElementById('nip_nik').value = '';
            }
        }
        
        // Load employee data on change
        document.getElementById('employee_id').addEventListener('change', function() {
            loadEmployeeData(this.value);
        });
        
        // Load initial employee data if pre-selected
        document.addEventListener('DOMContentLoaded', function() {
            const employeeSelect = document.getElementById('employee_id');
            if (employeeSelect.value) {
                loadEmployeeData(employeeSelect.value);
            }
        });
    </script>
</x-app-layout>
