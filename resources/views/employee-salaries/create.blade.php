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
                                <x-input-label for="nip_nik" value="NIK" />
                                <x-text-input id="nip_nik" name="nip_nik" type="text" class="mt-1 block w-full" :value="old('nip_nik')" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('nip_nik')" />
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
                                <x-input-label for="work_unit" value="Unit Kerja" />
                                <x-text-input id="work_unit" name="work_unit" type="text" class="mt-1 block w-full" :value="old('work_unit')" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('work_unit')" />
                            </div>

                            <div>
                                <x-input-label for="position" value="Jabatan" />
                                <x-text-input id="position" name="position" type="text" class="mt-1 block w-full" :value="old('position')" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('position')" />
                            </div>

                            <div>
                                <x-input-label for="basic_salary" value="Gaji Pokok" />
                                <x-text-input id="basic_salary" name="basic_salary" type="number" step="0.01" class="mt-1 block w-full" :value="old('basic_salary')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('basic_salary')" />
                            </div>

                            <div>
                                <x-input-label for="fixed_allowances" value="Tunjangan Tetap" />
                                <x-text-input id="fixed_allowances" name="fixed_allowances" type="number" step="0.01" class="mt-1 block w-full" :value="old('fixed_allowances', 0)" />
                                <x-input-error class="mt-2" :messages="$errors->get('fixed_allowances')" />
                            </div>

                            <div>
                                <x-input-label for="deductions" value="Potongan" />
                                <x-text-input id="deductions" name="deductions" type="number" step="0.01" class="mt-1 block w-full" :value="old('deductions', 0)" />
                                <x-input-error class="mt-2" :messages="$errors->get('deductions')" />
                            </div>

                            <div>
                                <x-input-label for="variable_allowances" value="Tunjangan Variabel" />
                                <x-text-input id="variable_allowances" name="variable_allowances" type="number" step="0.01" class="mt-1 block w-full" :value="old('variable_allowances', 0)" />
                                <x-input-error class="mt-2" :messages="$errors->get('variable_allowances')" />
                            </div>

                            <div>
                                <x-input-label for="net_salary" value="Total Gaji Bersih" />
                                <x-text-input id="net_salary" name="net_salary" type="number" step="0.01" class="mt-1 block w-full" :value="old('net_salary')" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('net_salary')" />
                            </div>

                            <div>
                                <x-input-label for="salary_date" value="Tanggal Gaji" />
                                <x-text-input id="salary_date" name="salary_date" type="date" class="mt-1 block w-full" :value="old('salary_date', now()->format('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('salary_date')" />
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
                                <x-input-label for="account_number" value="Nomor Rekening" />
                                <x-text-input id="account_number" name="account_number" type="text" class="mt-1 block w-full" :value="old('account_number')" />
                                <x-input-error class="mt-2" :messages="$errors->get('account_number')" />
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
            const employeeNikInput = document.getElementById('nip_nik');
            const basicSalaryInput = document.getElementById('basic_salary');
            const fixedAllowancesInput = document.getElementById('fixed_allowances');
            const variableAllowancesInput = document.getElementById('variable_allowances');
            const deductionsInput = document.getElementById('deductions');
            const netSalaryInput = document.getElementById('net_salary');

            const employees = @json($employees);

            employeeSelect.addEventListener('change', function() {
                const selectedEmployee = employees.find(emp => emp.id == this.value);
                if (selectedEmployee) {
                    employeeNameInput.value = selectedEmployee.full_name;
                    employeeNikInput.value = selectedEmployee.employee_id + ' / ' + selectedEmployee.nik;
                    document.getElementById('position').value = selectedEmployee.position ? selectedEmployee.position.name : '';
                    document.getElementById('work_unit').value = selectedEmployee.work_unit ? selectedEmployee.work_unit.name : '';
                    document.getElementById('employee_status').value = selectedEmployee.employment_status || 'tetap';
                } else {
                    employeeNameInput.value = '';
                    employeeNikInput.value = '';
                    document.getElementById('position').value = '';
                    document.getElementById('work_unit').value = '';
                    document.getElementById('employee_status').value = '';
                }
                calculateTotal();
            });

            function calculateTotal() {
                const basicSalary = parseFloat(basicSalaryInput.value) || 0;
                const fixedAllowances = parseFloat(fixedAllowancesInput.value) || 0;
                const variableAllowances = parseFloat(variableAllowancesInput.value) || 0;
                const deductions = parseFloat(deductionsInput.value) || 0;
                
                const total = basicSalary + fixedAllowances + variableAllowances - deductions;
                
                netSalaryInput.value = total.toFixed(2);
            }

            [basicSalaryInput, fixedAllowancesInput, variableAllowancesInput, deductionsInput].forEach(input => {
                input.addEventListener('input', calculateTotal);
            });
        });
    </script>
</x-app-layout>
