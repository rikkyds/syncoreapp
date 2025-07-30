<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Cuti Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('employee-leaves.update', $employeeLeave) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Informasi Karyawan</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="employee_id" value="Pilih Karyawan" />
                                    <select id="employee_id" name="employee_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ (old('employee_id', $employeeLeave->employee_id) == $employee->id) ? 'selected' : '' }}>
                                                {{ $employee->full_name }} ({{ $employee->employee_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('employee_id')" />
                                </div>

                                <div>
                                    <x-input-label for="full_name" value="Nama Lengkap" />
                                    <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" value="{{ old('full_name', $employeeLeave->full_name) }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
                                </div>

                                <div class="col-span-2">
                                    <x-input-label for="nip_nik" value="NIP/NIK" />
                                    <x-text-input id="nip_nik" name="nip_nik" type="text" class="mt-1 block w-full" value="{{ old('nip_nik', $employeeLeave->nip_nik) }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('nip_nik')" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Informasi Cuti</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="leave_type" value="Jenis Cuti" />
                                    <select id="leave_type" name="leave_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="">-- Pilih Jenis Cuti --</option>
                                        @foreach($leaveTypes as $key => $value)
                                            <option value="{{ $key }}" {{ (old('leave_type', $employeeLeave->leave_type) == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('leave_type')" />
                                </div>

                                <div>
                                    <x-input-label for="application_date" value="Tanggal Pengajuan" />
                                    <x-text-input id="application_date" name="application_date" type="date" class="mt-1 block w-full" value="{{ old('application_date', $employeeLeave->application_date->format('Y-m-d')) }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('application_date')" />
                                </div>

                                <div>
                                    <x-input-label for="start_date" value="Tanggal Mulai" />
                                    <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" value="{{ old('start_date', $employeeLeave->start_date->format('Y-m-d')) }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                                </div>

                                <div>
                                    <x-input-label for="end_date" value="Tanggal Berakhir" />
                                    <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" value="{{ old('end_date', $employeeLeave->end_date->format('Y-m-d')) }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                                </div>

                                <div>
                                    <x-input-label for="return_to_work_date" value="Tanggal Kembali Bekerja" />
                                    <x-text-input id="return_to_work_date" name="return_to_work_date" type="date" class="mt-1 block w-full" value="{{ old('return_to_work_date', $employeeLeave->return_to_work_date?->format('Y-m-d')) }}" />
                                    <x-input-error class="mt-2" :messages="$errors->get('return_to_work_date')" />
                                </div>

                                <div>
                                    <x-input-label for="remaining_leave_balance" value="Sisa Cuti Terakhir" />
                                    <x-text-input id="remaining_leave_balance" name="remaining_leave_balance" type="number" class="mt-1 block w-full" value="{{ old('remaining_leave_balance', $employeeLeave->remaining_leave_balance) }}" min="0" />
                                    <x-input-error class="mt-2" :messages="$errors->get('remaining_leave_balance')" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Informasi Persetujuan</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="status" value="Status Pengajuan" />
                                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        @foreach($statusOptions as $key => $value)
                                            <option value="{{ $key }}" {{ (old('status', $employeeLeave->status) == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                                </div>

                                <div>
                                    <x-input-label for="supervisor_name" value="Nama Atasan" />
                                    <x-text-input id="supervisor_name" name="supervisor_name" type="text" class="mt-1 block w-full" value="{{ old('supervisor_name', $employeeLeave->supervisor_name) }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('supervisor_name')" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Informasi Tambahan</h3>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <x-input-label for="leave_reason" value="Alasan Cuti" />
                                    <textarea id="leave_reason" name="leave_reason" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('leave_reason', $employeeLeave->leave_reason) }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('leave_reason')" />
                                </div>

                                <div>
                                    <x-input-label for="supporting_document" value="Dokumen Pendukung" />
                                    @if($employeeLeave->supporting_document)
                                        <div class="mb-2">
                                            <span class="text-sm text-gray-600">Dokumen saat ini: </span>
                                            <a href="{{ Storage::url($employeeLeave->supporting_document) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                                                Lihat Dokumen
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" id="supporting_document" name="supporting_document" class="mt-1 block w-full" accept=".pdf,.jpg,.jpeg,.png" />
                                    <p class="text-sm text-gray-500 mt-1">Format yang diizinkan: PDF, JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah dokumen.</p>
                                    <x-input-error class="mt-2" :messages="$errors->get('supporting_document')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button onclick="window.history.back()" type="button" class="mr-3">
                                {{ __('Batal') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Update Cuti') }}
                            </x-primary-button>
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
                fetch(`/employees/${employeeId}/data`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('full_name').value = data.full_name;
                        document.getElementById('nip_nik').value = data.nip_nik;
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('full_name').value = '';
                document.getElementById('nip_nik').value = '';
            }
        });

        // Auto calculate return to work date
        document.getElementById('end_date').addEventListener('change', function() {
            const endDate = new Date(this.value);
            if (endDate) {
                const returnDate = new Date(endDate);
                returnDate.setDate(returnDate.getDate() + 1);
                document.getElementById('return_to_work_date').value = returnDate.toISOString().split('T')[0];
            }
        });
    </script>
</x-app-layout>
