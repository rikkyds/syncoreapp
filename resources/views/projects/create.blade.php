<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Proyek Baru
            </h2>
            <a href="{{ route('projects.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- 1. Informasi Umum -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">1. Informasi Umum</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="submission_date" class="block text-sm font-medium text-gray-700">
                                        Tanggal Pengajuan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="submission_date" id="submission_date" 
                                           value="{{ old('submission_date', date('Y-m-d')) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="submitter_employee_id" class="block text-sm font-medium text-gray-700">
                                        Nama Pengaju <span class="text-red-500">*</span>
                                    </label>
                                    <select name="submitter_employee_id" id="submitter_employee_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            onchange="updateSubmitterPosition()">
                                        <option value="">Pilih Pengaju</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" 
                                                    data-position="{{ $employee->position_id }}"
                                                    {{ old('submitter_employee_id') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->full_name }} ({{ $employee->employee_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="submitter_position_id" class="block text-sm font-medium text-gray-700">
                                        Jabatan Pengaju <span class="text-red-500">*</span>
                                    </label>
                                    <select name="submitter_position_id" id="submitter_position_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Pilih Jabatan</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}" {{ old('submitter_position_id') == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="initiator_employee_id" class="block text-sm font-medium text-gray-700">
                                        Inisiator <span class="text-red-500">*</span>
                                    </label>
                                    <select name="initiator_employee_id" id="initiator_employee_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            onchange="updateInitiatorPosition()">
                                        <option value="">Pilih Inisiator</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" 
                                                    data-position="{{ $employee->position_id }}"
                                                    {{ old('initiator_employee_id') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->full_name }} ({{ $employee->employee_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="initiator_position_id" class="block text-sm font-medium text-gray-700">
                                        Jabatan Inisiator <span class="text-red-500">*</span>
                                    </label>
                                    <select name="initiator_position_id" id="initiator_position_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Pilih Jabatan</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}" {{ old('initiator_position_id') == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Detail Program dan Proyek -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">2. Detail Program dan Proyek</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="objective" class="block text-sm font-medium text-gray-700">
                                        Objective <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="objective" id="objective" rows="3" required
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                              placeholder="Masukkan tujuan proyek...">{{ old('objective') }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="program_name" class="block text-sm font-medium text-gray-700">
                                            Nama Program <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="program_name" id="program_name" 
                                               value="{{ old('program_name') }}" required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div>
                                        <label for="program_code" class="block text-sm font-medium text-gray-700">
                                            Kode Program <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="program_code" id="program_code" 
                                               value="{{ old('program_code') }}" required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div>
                                        <label for="activity_name" class="block text-sm font-medium text-gray-700">
                                            Nama Kegiatan <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="activity_name" id="activity_name" 
                                               value="{{ old('activity_name') }}" required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div>
                                        <label for="activity_code" class="block text-sm font-medium text-gray-700">
                                            Kode Kegiatan <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="activity_code" id="activity_code" 
                                               value="{{ old('activity_code') }}" required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               onchange="updateFinalProjectCode()">
                                    </div>

                                    <div>
                                        <label for="project_name" class="block text-sm font-medium text-gray-700">
                                            Nama Proyek <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="project_name" id="project_name" 
                                               value="{{ old('project_name') }}" required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div>
                                        <label for="project_sequence_number" class="block text-sm font-medium text-gray-700">
                                            No Urut Proyek <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" name="project_sequence_number" id="project_sequence_number" 
                                               value="{{ old('project_sequence_number', 1) }}" min="1" required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               onchange="updateFinalProjectCode()">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="final_project_code_display" class="block text-sm font-medium text-gray-700">
                                            Kode Proyek Final (Auto Generate)
                                        </label>
                                        <input type="text" id="final_project_code_display" readonly
                                               class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                                    </div>

                                    <div>
                                        <label for="target" class="block text-sm font-medium text-gray-700">
                                            Target <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" name="target" id="target" 
                                               value="{{ old('target') }}" min="1" required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div>
                                        <label for="specific_target" class="block text-sm font-medium text-gray-700">
                                            Target Spesifik dari Proyek <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" name="specific_target" id="specific_target" 
                                               value="{{ old('specific_target') }}" min="1" required
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div>
                                        <label for="current_achievement" class="block text-sm font-medium text-gray-700">
                                            Capaian Saat Ini
                                        </label>
                                        <input type="number" name="current_achievement" id="current_achievement" 
                                               value="{{ old('current_achievement', 0) }}" min="0"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>

                                <div>
                                    <label for="key_result" class="block text-sm font-medium text-gray-700">
                                        Key Result <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="key_result" id="key_result" rows="3" required
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                              placeholder="Masukkan key result...">{{ old('key_result') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Kebutuhan Pengajuan -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">3. Kebutuhan Pengajuan</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <input type="checkbox" name="need_team_assignment" id="need_team_assignment" 
                                           value="1" {{ old('need_team_assignment') ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="need_team_assignment" class="ml-2 block text-sm text-gray-900">
                                        Pengajuan Penugasan Tim (PPT)
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="need_hrd_support" id="need_hrd_support" 
                                           value="1" {{ old('need_hrd_support') ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="need_hrd_support" class="ml-2 block text-sm text-gray-900">
                                        Pengajuan Dukungan HRD (PDH)
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="need_facility_support" id="need_facility_support" 
                                           value="1" {{ old('need_facility_support') ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="need_facility_support" class="ml-2 block text-sm text-gray-900">
                                        Pengajuan Dukungan Sarpras (PDS)
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="need_digitalization_support" id="need_digitalization_support" 
                                           value="1" {{ old('need_digitalization_support') ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="need_digitalization_support" class="ml-2 block text-sm text-gray-900">
                                        Pengajuan Dukungan Digitalisasi (PDD)
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="need_financial_support" id="need_financial_support" 
                                           value="1" {{ old('need_financial_support') ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="need_financial_support" class="ml-2 block text-sm text-gray-900">
                                        Pengajuan Dukungan Keuangan (PDK)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Lampiran Dokumen -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">4. Lampiran Dokumen</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="proposal_document" class="block text-sm font-medium text-gray-700">
                                        Dokumen Proposal
                                    </label>
                                    <input type="file" name="proposal_document" id="proposal_document" 
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <p class="mt-1 text-xs text-gray-500">Format: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</p>
                                </div>

                                <div>
                                    <label for="evidence_document" class="block text-sm font-medium text-gray-700">
                                        Dokumen Bukti Kegiatan
                                    </label>
                                    <input type="file" name="evidence_document" id="evidence_document" 
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    <p class="mt-1 text-xs text-gray-500">Format: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</p>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Catatan Tambahan -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">5. Catatan Tambahan</h3>
                            
                            <div>
                                <label for="additional_notes" class="block text-sm font-medium text-gray-700">
                                    Note atau Komentar
                                </label>
                                <textarea name="additional_notes" id="additional_notes" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                          placeholder="Masukkan catatan tambahan (opsional)...">{{ old('additional_notes') }}</textarea>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('projects.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" name="action" value="draft"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Simpan sebagai Draft
                            </button>
                            <button type="submit" name="action" value="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Ajukan Proyek
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateSubmitterPosition() {
            const employeeSelect = document.getElementById('submitter_employee_id');
            const positionSelect = document.getElementById('submitter_position_id');
            
            if (employeeSelect.value) {
                const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
                const positionId = selectedOption.getAttribute('data-position');
                
                if (positionId) {
                    positionSelect.value = positionId;
                }
            } else {
                positionSelect.value = '';
            }
        }

        function updateInitiatorPosition() {
            const employeeSelect = document.getElementById('initiator_employee_id');
            const positionSelect = document.getElementById('initiator_position_id');
            
            if (employeeSelect.value) {
                const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
                const positionId = selectedOption.getAttribute('data-position');
                
                if (positionId) {
                    positionSelect.value = positionId;
                }
            } else {
                positionSelect.value = '';
            }
        }

        function updateFinalProjectCode() {
            const activityCode = document.getElementById('activity_code').value;
            const sequenceNumber = document.getElementById('project_sequence_number').value;
            const displayField = document.getElementById('final_project_code_display');
            
            if (activityCode && sequenceNumber) {
                const paddedNumber = sequenceNumber.padStart(3, '0');
                displayField.value = activityCode + '-' + paddedNumber;
            } else {
                displayField.value = '';
            }
        }

        // Initialize final project code on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateFinalProjectCode();
        });
    </script>
</x-app-layout>
