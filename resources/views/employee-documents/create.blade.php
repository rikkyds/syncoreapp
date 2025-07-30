<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Dokumen Karyawan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('employee-documents.store') }}" enctype="multipart/form-data" class="space-y-6">
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
                                <x-input-label for="document_type" value="Jenis Dokumen" />
                                <select id="document_type" name="document_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Jenis Dokumen</option>
                                    @foreach($documentTypes as $key => $type)
                                        <option value="{{ $key }}" {{ old('document_type') == $key ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('document_type')" />
                            </div>

                            <div>
                                <x-input-label for="document_name" value="Nama Dokumen" />
                                <x-text-input id="document_name" name="document_name" type="text" class="mt-1 block w-full" :value="old('document_name')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('document_name')" />
                            </div>

                            <div>
                                <x-input-label for="document_number" value="Nomor Dokumen" />
                                <x-text-input id="document_number" name="document_number" type="text" class="mt-1 block w-full" :value="old('document_number')" />
                                <x-input-error class="mt-2" :messages="$errors->get('document_number')" />
                            </div>

                            <div>
                                <x-input-label for="issue_date" value="Tanggal Terbit" />
                                <x-text-input id="issue_date" name="issue_date" type="date" class="mt-1 block w-full" :value="old('issue_date')" />
                                <x-input-error class="mt-2" :messages="$errors->get('issue_date')" />
                            </div>

                            <div>
                                <x-input-label for="expiry_date" value="Tanggal Kadaluarsa" />
                                <x-text-input id="expiry_date" name="expiry_date" type="date" class="mt-1 block w-full" :value="old('expiry_date')" />
                                <x-input-error class="mt-2" :messages="$errors->get('expiry_date')" />
                            </div>

                            <div>
                                <x-input-label for="issuing_authority" value="Instansi Penerbit" />
                                <x-text-input id="issuing_authority" name="issuing_authority" type="text" class="mt-1 block w-full" :value="old('issuing_authority')" />
                                <x-input-error class="mt-2" :messages="$errors->get('issuing_authority')" />
                            </div>

                            <div>
                                <x-input-label for="document_status" value="Status Dokumen" />
                                <select id="document_status" name="document_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Pilih Status</option>
                                    @foreach($documentStatuses as $key => $status)
                                        <option value="{{ $key }}" {{ old('document_status') == $key ? 'selected' : '' }}>
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
                                        <option value="{{ $key }}" {{ old('storage_location') == $key ? 'selected' : '' }}>
                                            {{ $location }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('storage_location')" />
                            </div>

                            <div>
                                <x-input-label for="file_path" value="File Dokumen" />
                                <input type="file" id="file_path" name="file_path" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" />
                                <x-input-error class="mt-2" :messages="$errors->get('file_path')" />
                                <p class="text-sm text-gray-500 mt-1">Format yang didukung: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 5MB)</p>
                            </div>

                            <div>
                                <x-input-label for="file_size" value="Ukuran File (KB)" />
                                <x-text-input id="file_size" name="file_size" type="number" class="mt-1 block w-full" :value="old('file_size')" readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('file_size')" />
                            </div>

                            <div>
                                <x-input-label for="uploaded_by" value="Diunggah Oleh" />
                                <x-text-input id="uploaded_by" name="uploaded_by" type="text" class="mt-1 block w-full" :value="old('uploaded_by', auth()->user()->name)" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('uploaded_by')" />
                            </div>

                            <div>
                                <x-input-label for="upload_date" value="Tanggal Upload" />
                                <x-text-input id="upload_date" name="upload_date" type="date" class="mt-1 block w-full" :value="old('upload_date', date('Y-m-d'))" required readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('upload_date')" />
                            </div>

                            <div>
                                <x-input-label for="access_level" value="Tingkat Akses" />
                                <select id="access_level" name="access_level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="public" {{ old('access_level') == 'public' ? 'selected' : '' }}>Publik</option>
                                    <option value="private" {{ old('access_level') == 'private' ? 'selected' : '' }}>Pribadi</option>
                                    <option value="confidential" {{ old('access_level') == 'confidential' ? 'selected' : '' }}>Rahasia</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('access_level')" />
                            </div>
                        </div>

                        <div class="col-span-2">
                            <x-input-label for="description" value="Deskripsi" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="col-span-2">
                            <x-input-label for="notes" value="Catatan" />
                            <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="2">{{ old('notes') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Simpan</x-primary-button>
                            <a href="{{ route('employee-documents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Batal</a>
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
            const fileInput = document.getElementById('file_path');
            const fileSizeInput = document.getElementById('file_size');

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

            // Calculate file size when file is selected
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const fileSize = Math.round(this.files[0].size / 1024); // Convert to KB
                    fileSizeInput.value = fileSize;
                    
                    // Check file size limit (5MB = 5120KB)
                    if (fileSize > 5120) {
                        alert('Ukuran file terlalu besar. Maksimal 5MB.');
                        this.value = '';
                        fileSizeInput.value = '';
                    }
                } else {
                    fileSizeInput.value = '';
                }
            });

            // Auto-generate document name based on document type
            const documentTypeSelect = document.getElementById('document_type');
            const documentNameInput = document.getElementById('document_name');
            
            documentTypeSelect.addEventListener('change', function() {
                if (this.value && employeeNameInput.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    const documentTypeName = selectedOption.text;
                    documentNameInput.value = documentTypeName + ' - ' + employeeNameInput.value;
                }
            });
        });
    </script>
</x-app-layout>
