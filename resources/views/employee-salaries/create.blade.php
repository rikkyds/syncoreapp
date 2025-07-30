<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Gaji Karyawan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('employee-salaries.store') }}" class="space-y-6">
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
                                <x-input-label for="employee_nik" value="NIK" />
                                <x-text-input id="employee_nik" name="employee_nik" type="text" class="mt-1 block w-full" :value="old('employee_nik')" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('employee_nik')" />
                            </div>

                            <div>
                                <x-input-label for="employee_status" value="Status Karyawan" />
                                <select id="employee_status" name="employee_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Status</option>
                                    @foreach($employeeStatuses as $key => $status)
                                        <option value="{{ $key }}" {{ old('employee_status') == $key ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('employee_status')" />
                            </div>

                            <div>
                                <x-input-label for="work_unit_id" value="Unit Kerja" />
                                <select id="work_unit_id" name="work_unit_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach($workUnits as $unit)
                                        <option value="{{ $unit->id }}" {{ old('work_unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('work_unit_id')" />
                            </div>

                            <div>
                                <x-input-label for="position_id" value="Jabatan" />
                                <select id="position_id" name="position_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Jabatan</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                            {{ $position->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('position_id')" />
                            </div>

                            <div>
                                <x-input-label for="basic_salary" value="Gaji Pokok" />
                                <x-text-input id="basic_salary" name="basic_salary" type="number" step="0.01" class="mt-1 block w-full" :value="old('basic_salary')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('basic_salary')" />
                            </div>

                            <div>
                                <x-input-label for="allowances" value="Tunjangan" />
                                <x-text-input id="allowances" name="allowances" type="number" step="0.01" class="mt-1 block w-full" :value="old('allowances', 0)" />
                                <x-input-error class="mt-2" :messages="$errors->get('allowances')" />
                            </div>

                            <div>
                                <x-input-label for="deductions" value="Potongan" />
                                <x-text-input id="deductions" name="deductions" type="number" step="0.01" class="mt-1 block w-full" :value="old('deductions', 0)" />
                                <x-input-error class="mt-2" :messages="$errors->get('deductions')" />
                            </div>

                            <div>
                                <x-input-label for="overtime_hours" value="Jam Lembur" />
                                <x-text-input id="overtime_hours" name="overtime_hours" type="number" step="0.01" class="mt-1 block w-full" :value="old('overtime_hours', 0)" />
                                <x-input-error class="mt-2" :messages="$errors->get('overtime_hours')" />
                            </div>

                            <div>
                                <x-input-label for="overtime_rate" value="Tarif Lembur" />
                                <x-text-input id="overtime_rate" name="overtime_rate" type="number" step="0.01" class="mt-1 block w-full" :value="old('overtime_rate', 0)" />
                                <x-input-error class="mt-2" :messages="$errors->get('overtime_rate')" />
                            </div>

                            <div>
                                <x-input-label for="total_salary" value="Total Gaji" />
                                <x-text-input id="total_salary" name="total_salary" type="number" step="0.01" class="mt-1 block w-full" :value="old('total_salary')" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('total_salary')" />
                            </div>

                            <div>
                                <x-input-label for="salary_period" value="Periode Gaji" />
                                <x-text-input id="salary_period" name="salary_period" type="month" class="mt-1 block w-full" :value="old('salary_period')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('salary_period')" />
                            </div>

                            <div>
                                <x-input-label for="payment_date" value="Tanggal Pembayaran" />
                                <x-text-input id="payment_date" name="payment_date" type="date" class="mt-1 block w-full" :value="old('payment_date')" />
                                <x-input-error class="mt-2" :messages="$errors->get('payment_date')" />
                            </div>

                            <div>
                                <x-input-label for="payment_method" value="Metode Pembayaran" />
                                <select id="payment_method" name="payment_method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Metode</option>
                                    @foreach($paymentMethods as $key => $method)
                                        <option value="{{ $key }}" {{ old('payment_method') == $key ? 'selected' : '' }}>
                                            {{ $method }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('payment_method')" />
                            </div>

                            <div>
                                <x-input-label for="payment_status" value="Status Pembayaran" />
                                <select id="payment_status" name="payment_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Status</option>
                                    @foreach($paymentStatuses as $key => $status)
                                        <option value="{{ $key }}" {{ old('payment_status') == $key ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('payment_status')" />
                            </div>
                        </div>

                        <div class="col-span-2">
                            <x-input-label for="notes" value="Catatan" />
                            <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Simpan</x-primary-button>
                            <a href="{{ route('employee-salaries.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
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
            const employeeNikInput = document.getElementById('employee_nik');
            const basicSalaryInput = document.getElementById('basic_salary');
            const allowancesInput = document.getElementById('allowances');
            const deductionsInput = document.getElementById('deductions');
            const overtimeHoursInput = document.getElementById('overtime_hours');
            const overtimeRateInput = document.getElementById('overtime_rate');
            const totalSalaryInput = document.getElementById('total_salary');

            const employees = @json($employees);

            employeeSelect.addEventListener('change', function() {
                const selectedEmployee = employees.find(emp => emp.id == this.value);
                if (selectedEmployee) {
                    employeeNameInput.value = selectedEmployee.full_name;
                    employeeNikInput.value = selectedEmployee.nik;
                } else {
                    employeeNameInput.value = '';
                    employeeNikInput.value = '';
                }
                calculateTotal();
            });

            function calculateTotal() {
                const basicSalary = parseFloat(basicSalaryInput.value) || 0;
                const allowances = parseFloat(allowancesInput.value) || 0;
                const deductions = parseFloat(deductionsInput.value) || 0;
                const overtimeHours = parseFloat(overtimeHoursInput.value) || 0;
                const overtimeRate = parseFloat(overtimeRateInput.value) || 0;
                
                const overtimePay = overtimeHours * overtimeRate;
                const total = basicSalary + allowances + overtimePay - deductions;
                
                totalSalaryInput.value = total.toFixed(2);
            }

            [basicSalaryInput, allowancesInput, deductionsInput, overtimeHoursInput, overtimeRateInput].forEach(input => {
                input.addEventListener('input', calculateTotal);
            });
        });
    </script>
</x-app-layout>
