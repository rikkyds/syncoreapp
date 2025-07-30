<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Tunjangan Karyawan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('employee-allowances.store') }}" method="POST">
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
                                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
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

                                <div>
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

                                <div>
                                    <label for="work_unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Unit Kerja
                                    </label>
                                    <input type="text" name="work_unit" id="work_unit" 
                                           value="{{ old('work_unit') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           readonly>
                                    @error('work_unit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Jabatan
                                    </label>
                                    <input type="text" name="position" id="position" 
                                           value="{{ old('position') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           readonly>
                                    @error('position')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Tunjangan -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informasi Tunjangan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="allowance_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Jenis Tunjangan
                                    </label>
                                    <select name="allowance_type" id="allowance_type" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required>
                                        <option value="">-- Pilih Jenis Tunjangan --</option>
                                        @foreach($allowanceTypes as $key => $value)
                                            <option value="{{ $key }}" {{ old('allowance_type') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('allowance_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="allowance_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Jumlah Tunjangan (Rp)
                                    </label>
                                    <input type="number" name="allowance_amount" id="allowance_amount" 
                                           value="{{ old('allowance_amount') }}"
                                           min="0" step="0.01"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           placeholder="0"
                                           required>
                                    @error('allowance_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="payment_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Frekuensi Pembayaran
                                    </label>
                                    <select name="payment_frequency" id="payment_frequency" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required>
                                        @foreach($paymentFrequencies as $key => $value)
                                            <option value="{{ $key }}" {{ old('payment_frequency', 'bulanan') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('payment_frequency')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="allowance_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Status Tunjangan
                                    </label>
                                    <select name="allowance_status" id="allowance_status" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required>
                                        @foreach($allowanceStatuses as $key => $value)
                                            <option value="{{ $key }}" {{ old('allowance_status', 'aktif') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('allowance_status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Metode Pembayaran
                                    </label>
                                    <select name="payment_method" id="payment_method" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required>
                                        @foreach($paymentMethods as $key => $value)
                                            <option value="{{ $key }}" {{ old('payment_method', 'bersamaan_gaji') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Periode Berlaku -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Periode Berlaku</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Tanggal Mulai Berlaku
                                    </label>
                                    <input type="date" name="start_date" id="start_date" 
                                           value="{{ old('start_date', date('Y-m-d')) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Tanggal Berakhir (Opsional)
                                    </label>
                                    <input type="date" name="end_date" id="end_date" 
                                           value="{{ old('end_date') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <p class="mt-1 text-sm text-gray-500">Kosongkan jika tunjangan berlaku tanpa batas waktu</p>
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Ketentuan & Syarat -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Ketentuan & Syarat</h3>
                            
                            <div>
                                <label for="terms_conditions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Ketentuan & Syarat
                                </label>
                                <textarea name="terms_conditions" id="terms_conditions" rows="4" 
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                          placeholder="Contoh: Tunjangan bergantung pada performa, kehadiran minimal 95%, atau syarat lainnya...">{{ old('terms_conditions') }}</textarea>
                                @error('terms_conditions')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('employee-allowances.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                BATAL
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                SIMPAN TUNJANGAN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('employee_id').addEventListener('change', function() {
            const employeeId = this.value;
            if (employeeId) {
                fetch(`/employees/${employeeId}/allowance-data`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('employee_name').value = data.employee_name;
                        document.getElementById('nip_nik').value = data.nip_nik;
                        document.getElementById('work_unit').value = data.work_unit;
                        document.getElementById('position').value = data.position;
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('employee_name').value = '';
                document.getElementById('nip_nik').value = '';
                document.getElementById('work_unit').value = '';
                document.getElementById('position').value = '';
            }
        });

        // Format number input
        document.getElementById('allowance_amount').addEventListener('input', function() {
            let value = this.value.replace(/[^\d]/g, '');
            if (value) {
                this.value = parseInt(value).toLocaleString('id-ID');
            }
        });
    </script>
</x-app-layout>
