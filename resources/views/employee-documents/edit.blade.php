<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Dokumen Karyawan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('employee-documents.update', $employeeDocument) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="employee_id" value="Karyawan" />
                                <select id="employee_id" name="employee_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Karyawan</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id', $employeeDocument->employee_id) == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->employee_id }} - {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('employee_id')" />
                            </div>

                            <div>
                                <x-input-label for="employee_name" value="Nama Karyawan" />
                                <x-text-input id="employee_name" name="employee_name" type="text" class="mt-1 block w-full" :value="old('employee_name', $employeeDocument->employee_name)" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('employee_name')" />
                            </div>

                            <div>
                                <x-input-label for="nip_nik" value="NIP/NIK" />
                                <x-text-input id="nip_nik" name="nip_nik" type="text" class="mt-1 block w-full" :value="old('nip_nik', $employeeDocument->nip_nik)" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('nip_nik')" />
                            </div>

                            <div>
                                <x-input-label for="document_type" value="Jenis Dokumen" />
                                <select id="document_type" name="document_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Jenis Dokumen</option>
                                    @foreach($documentTypes as $key => $type)
                                        <option value="{{ $key }}" {{ old('document_type', $employeeDocument->document_type) == $key ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('document_type')" />
                            </div>

                            <div>
                                <x-input-label for="signatory" value="Penandatangan" />
                                <x-text-input id="signatory" name="signatory" type="text" class="mt-1 block w-full" :value="old('signatory', $employeeDocument->signatory)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('signatory')" />
                            </div>

                            <div>
                                <x-input-label for="document_number" value="Nomor Dokumen" />
                                <x-text-input id="document_number" name="document_number" type="text" class="mt-1 block w-full" :value="old('document_number', $employeeDocument->document_number)" />
                                <x-input-error class="mt-2" :messages="$errors->get('document_number')" />
                            </div>

                            <div>
                                <x-input-label for="issue_date" value="Tanggal Terbit" />
                                <x-text-input id="issue_date" name="issue_date" type="date" class="mt-1 block w-full" :value="old('issue_date', $employeeDocument->issue_date->format('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('issue_date')" />
                            </div>

                            <div>
                                <x-input-label for="effective_date" value="Tanggal Berlaku" />
                                <x-text-input id="effective_date" name="effective_date" type="date" class="mt-1 block w-full" :value="old('effective_date', $employeeDocument->effective_date->format('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('effective_date')" />
                            </div>

                            <div>
                                <x-input-label for="expiry_date" value="Tanggal Kadaluarsa" />
                                <x-text-input id="expiry_date" name="expiry_date" type="date" class="mt-1 block w-full" :value="old('expiry_date', $employeeDocument->expiry_date ? $employeeDocument->expiry_date->format('Y-m-d') : '')" />
                                <p class="text-xs text-gray-500 mt-1">Kosongkan jika dokumen tidak memiliki tanggal kadaluarsa</p>
                                <x-input-error class="mt-2" :messages="$errors->get('expiry_date')" />
                            </div>

                            <div>
                                <x-input-label for="document_status" value="Status Dokumen" />
                                <select id="document_status" name="document_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Status</option>
                                    @foreach($documentStatuses as $key => $status)
                                        <option value="{{ $key }}" {{ old('document_status', $employeeDocument->document_status) == $key ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('document_status')" />
                            </div>

                            <div>
                                <x-input-label for="storage_location" value="Lokasi Penyimpanan" />
                                <select id="storage_location" name="storage_location" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Lokasi</option>
                                    @foreach($storageLocations as $key => $location)
                                        <option value="{{ $key }}" {{ old('storage_location', $employeeDocument->storage_location) == $key ? 'selected' : '' }}>
                                            {{ $location }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('storage_location')" />
                            </div>

                            <div>
                                <x-input-label for="document_file" value="File Dokumen" />
                                <input type="file" id="document_file" name="document_file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" />
                                <x-input-error class="mt-2" :messages="$errors->get('document_file')" />
                                <p class="text-sm text-gray-500 mt-1">Format yang didukung: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 10MB)</p>
                                
                                @if($employeeDocument->file_path)
                                <div class="mt-2 flex items-center space-x-2">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                        @php
                                            $extension = pathinfo($employeeDocument->file_path, PATHINFO_EXTENSION);
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
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            File saat ini: {{ basename($employeeDocument->file_path) }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Unggah file baru untuk mengganti file yang ada
                                        </p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-span-2">
                            <x-input-label for="additional_notes" value="Catatan Tambahan" />
                            <textarea id="additional_notes" name="additional_notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('additional_notes', $employeeDocument->additional_notes) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('additional_notes')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Simpan Perubahan</x-primary-button>
                            <a href="{{ route('employee-documents.show', $employeeDocument) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
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
            const fileInput = document.getElementById('document_file');

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

            // Check file size when file is selected
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const fileSize = Math.round(this.files[0].size / 1024); // Convert to KB
                    
                    // Check file size limit (10MB = 10240KB)
                    if (fileSize > 10240) {
                        alert('Ukuran file terlalu besar. Maksimal 10MB.');
                        this.value = '';
                    }
                }
            });
        });
    </script>
</x-app-layout>
