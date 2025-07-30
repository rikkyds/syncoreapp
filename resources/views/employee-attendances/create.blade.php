<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Absensi Karyawan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('employee-attendances.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="employee_id" value="Karyawan" />
                                <select id="employee_id" name="employee_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Karyawan</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->employee_id }} - {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('employee_id')" />
                            </div>

                            <div>
                                <x-input-label for="employee_name" value="Nama Karyawan" />
                                <x-text-input id="employee_name" name="employee_name" type="text" class="mt-1 block w-full" :value="old('employee_name')" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('employee_name')" />
                            </div>

                            <div>
                                <x-input-label for="nip_nik" value="NIP/NIK" />
                                <x-text-input id="nip_nik" name="nip_nik" type="text" class="mt-1 block w-full" :value="old('nip_nik')" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('nip_nik')" />
                            </div>

                            <div>
                                <x-input-label for="attendance_date" value="Tanggal Absensi" />
                                <x-text-input id="attendance_date" name="attendance_date" type="date" class="mt-1 block w-full" :value="old('attendance_date', date('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('attendance_date')" />
                            </div>

                            <div>
                                <x-input-label for="day_type" value="Jenis Hari" />
                                <select id="day_type" name="day_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Jenis Hari</option>
                                    @foreach($dayTypes as $key => $type)
                                        <option value="{{ $key }}" {{ old('day_type') == $key ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('day_type')" />
                            </div>

                            <div>
                                <x-input-label for="shift_schedule" value="Jadwal Shift" />
                                <select id="shift_schedule" name="shift_schedule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Pilih Jadwal Shift</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}" {{ old('shift_schedule') == $shift->id ? 'selected' : '' }}>
                                            {{ $shift->employee ? $shift->employee->full_name : 'Tidak ada karyawan' }} - {{ $shift->shift_date }} ({{ $shift->start_time }} - {{ $shift->end_time }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('shift_schedule')" />
                            </div>

                            <div>
                                <x-input-label for="scheduled_in" value="Jadwal Masuk" />
                                <x-text-input id="scheduled_in" name="scheduled_in" type="time" class="mt-1 block w-full" :value="old('scheduled_in')" />
                                <x-input-error class="mt-2" :messages="$errors->get('scheduled_in')" />
                            </div>

                            <div>
                                <x-input-label for="scheduled_out" value="Jadwal Keluar" />
                                <x-text-input id="scheduled_out" name="scheduled_out" type="time" class="mt-1 block w-full" :value="old('scheduled_out')" />
                                <x-input-error class="mt-2" :messages="$errors->get('scheduled_out')" />
                            </div>

                            <div>
                                <x-input-label for="actual_in" value="Waktu Masuk Aktual" />
                                <x-text-input id="actual_in" name="actual_in" type="time" class="mt-1 block w-full" :value="old('actual_in')" />
                                <x-input-error class="mt-2" :messages="$errors->get('actual_in')" />
                            </div>

                            <div>
                                <x-input-label for="actual_out" value="Waktu Keluar Aktual" />
                                <x-text-input id="actual_out" name="actual_out" type="time" class="mt-1 block w-full" :value="old('actual_out')" />
                                <x-input-error class="mt-2" :messages="$errors->get('actual_out')" />
                            </div>

                            <div>
                                <x-input-label for="break_start" value="Mulai Istirahat" />
                                <x-text-input id="break_start" name="break_start" type="time" class="mt-1 block w-full" :value="old('break_start')" />
                                <x-input-error class="mt-2" :messages="$errors->get('break_start')" />
                            </div>

                            <div>
                                <x-input-label for="break_end" value="Selesai Istirahat" />
                                <x-text-input id="break_end" name="break_end" type="time" class="mt-1 block w-full" :value="old('break_end')" />
                                <x-input-error class="mt-2" :messages="$errors->get('break_end')" />
                            </div>

                            <div>
                                <x-input-label for="total_hours" value="Total Jam Kerja" />
                                <x-text-input id="total_hours" name="total_hours" type="number" step="0.01" class="mt-1 block w-full" :value="old('total_hours')" readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('total_hours')" />
                            </div>

                            <div>
                                <x-input-label for="overtime_hours" value="Jam Lembur" />
                                <x-text-input id="overtime_hours" name="overtime_hours" type="number" step="0.01" class="mt-1 block w-full" :value="old('overtime_hours', 0)" />
                                <x-input-error class="mt-2" :messages="$errors->get('overtime_hours')" />
                            </div>

                            <div>
                                <x-input-label for="late_minutes" value="Terlambat (Menit)" />
                                <x-text-input id="late_minutes" name="late_minutes" type="number" class="mt-1 block w-full" :value="old('late_minutes', 0)" readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('late_minutes')" />
                            </div>

                            <div>
                                <x-input-label for="early_departure_minutes" value="Pulang Cepat (Menit)" />
                                <x-text-input id="early_departure_minutes" name="early_departure_minutes" type="number" class="mt-1 block w-full" :value="old('early_departure_minutes', 0)" readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('early_departure_minutes')" />
                            </div>

                            <div>
                                <x-input-label for="attendance_status" value="Status Absensi" />
                                <select id="attendance_status" name="attendance_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Status</option>
                                    @foreach($attendanceStatuses as $key => $status)
                                        <option value="{{ $key }}" {{ old('attendance_status') == $key ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('attendance_status')" />
                            </div>

                            <div>
                                <x-input-label for="work_location" value="Lokasi Kerja" />
                                <select id="work_location" name="work_location" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Lokasi</option>
                                    @foreach($workLocations as $key => $location)
                                        <option value="{{ $key }}" {{ old('work_location') == $key ? 'selected' : '' }}>
                                            {{ $location }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('work_location')" />
                            </div>

                            <div>
                                <x-input-label for="attendance_method" value="Metode Absensi" />
                                <select id="attendance_method" name="attendance_method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Metode</option>
                                    @foreach($attendanceMethods as $key => $method)
                                        <option value="{{ $key }}" {{ old('attendance_method') == $key ? 'selected' : '' }}>
                                            {{ $method }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('attendance_method')" />
                            </div>

                            <div>
                                <x-input-label for="device_info" value="Info Perangkat" />
                                <x-text-input id="device_info" name="device_info" type="text" class="mt-1 block w-full" :value="old('device_info')" />
                                <x-input-error class="mt-2" :messages="$errors->get('device_info')" />
                            </div>

                            <div>
                                <x-input-label for="ip_address" value="Alamat IP" />
                                <x-text-input id="ip_address" name="ip_address" type="text" class="mt-1 block w-full" :value="old('ip_address')" />
                                <x-input-error class="mt-2" :messages="$errors->get('ip_address')" />
                            </div>

                            <div>
                                <x-input-label for="location_coordinates" value="Koordinat Lokasi" />
                                <x-text-input id="location_coordinates" name="location_coordinates" type="text" class="mt-1 block w-full" :value="old('location_coordinates')" placeholder="latitude,longitude" />
                                <x-input-error class="mt-2" :messages="$errors->get('location_coordinates')" />
                            </div>

                            <div>
                                <x-input-label for="supervisor_verification" value="Verifikasi Supervisor" />
                                <select id="supervisor_verification" name="supervisor_verification" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Pilih Status Verifikasi</option>
                                    @foreach($supervisorVerifications as $key => $verification)
                                        <option value="{{ $key }}" {{ old('supervisor_verification') == $key ? 'selected' : '' }}>
                                            {{ $verification }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('supervisor_verification')" />
                            </div>

                            <div>
                                <x-input-label for="verified_by" value="Diverifikasi Oleh" />
                                <x-text-input id="verified_by" name="verified_by" type="text" class="mt-1 block w-full" :value="old('verified_by')" />
                                <x-input-error class="mt-2" :messages="$errors->get('verified_by')" />
                            </div>
                        </div>

                        <div class="col-span-2">
                            <x-input-label for="notes" value="Catatan" />
                            <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('notes') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Simpan</x-primary-button>
                            <a href="{{ route('employee-attendances.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const employeeSelect = document.getElementById('employee_id');
            const employeeNameInput = document.getElementById('employee_name');
            const nipNikInput = document.getElementById('nip_nik');
            const scheduledInInput = document.getElementById('scheduled_in');
            const scheduledOutInput = document.getElementById('scheduled_out');
            const actualInInput = document.getElementById('actual_in');
            const actualOutInput = document.getElementById('actual_out');
            const breakStartInput = document.getElementById('break_start');
            const breakEndInput = document.getElementById('break_end');
            const totalHoursInput = document.getElementById('total_hours');
            const lateMinutesInput = document.getElementById('late_minutes');
            const earlyDepartureInput = document.getElementById('early_departure_minutes');

            const employees = @json($employees);

            // Auto-fill employee data when selecting employee
            employeeSelect.addEventListener('change', function() {
                const selectedEmployee = employees.find(emp => emp.id == this.value);
                if (selectedEmployee) {
                    employeeNameInput.value = selectedEmployee.full_name;
                    nipNikInput.value = selectedEmployee.employee_id + ' / ' + selectedEmployee.nik;
                } else {
                    employeeNameInput.value = '';
                    nipNikInput.value = '';
                }
            });

            // Calculate total hours, late minutes, and early departure
            function calculateAttendance() {
                const scheduledIn = scheduledInInput.value;
                const scheduledOut = scheduledOutInput.value;
                const actualIn = actualInInput.value;
                const actualOut = actualOutInput.value;
                const breakStart = breakStartInput.value;
                const breakEnd = breakEndInput.value;

                if (actualIn && actualOut) {
                    // Calculate total hours
                    const actualInTime = new Date('1970-01-01T' + actualIn + ':00');
                    const actualOutTime = new Date('1970-01-01T' + actualOut + ':00');
                    let totalMinutes = (actualOutTime - actualInTime) / (1000 * 60);

                    // Subtract break time if provided
                    if (breakStart && breakEnd) {
                        const breakStartTime = new Date('1970-01-01T' + breakStart + ':00');
                        const breakEndTime = new Date('1970-01-01T' + breakEnd + ':00');
                        const breakMinutes = (breakEndTime - breakStartTime) / (1000 * 60);
                        totalMinutes -= breakMinutes;
                    }

                    const totalHours = totalMinutes / 60;
                    totalHoursInput.value = totalHours.toFixed(2);
                }

                // Calculate late minutes
                if (scheduledIn && actualIn) {
                    const scheduledInTime = new Date('1970-01-01T' + scheduledIn + ':00');
                    const actualInTime = new Date('1970-01-01T' + actualIn + ':00');
                    const lateMinutes = Math.max(0, (actualInTime - scheduledInTime) / (1000 * 60));
                    lateMinutesInput.value = Math.round(lateMinutes);
                }

                // Calculate early departure minutes
                if (scheduledOut && actualOut) {
                    const scheduledOutTime = new Date('1970-01-01T' + scheduledOut + ':00');
                    const actualOutTime = new Date('1970-01-01T' + actualOut + ':00');
                    const earlyMinutes = Math.max(0, (scheduledOutTime - actualOutTime) / (1000 * 60));
                    earlyDepartureInput.value = Math.round(earlyMinutes);
                }
            }

            // Add event listeners for time calculations
            [scheduledInInput, scheduledOutInput, actualInInput, actualOutInput, breakStartInput, breakEndInput].forEach(input => {
                input.addEventListener('change', calculateAttendance);
            });

            // Get current location if supported
            const locationInput = document.getElementById('location_coordinates');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    locationInput.value = lat + ',' + lng;
                });
            }

            // Auto-fill IP address (this would typically be done server-side)
            const ipInput = document.getElementById('ip_address');
            fetch('https://api.ipify.org?format=json')
                .then(response => response.json())
                .then(data => {
                    ipInput.value = data.ip;
                })
                .catch(error => {
                    console.log('Could not fetch IP address');
                });
        });
    </script>
</x-app-layout>
