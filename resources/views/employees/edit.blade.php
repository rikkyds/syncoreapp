<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Informasi Pribadi</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2 flex justify-center mb-4">
                                    <div class="text-center">
                                        <div class="mb-2">
                                            @if($employee->profile_photo)
                                                <img src="{{ asset('storage/' . $employee->profile_photo) }}" alt="Foto Profil" class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-gray-200">
                                            @else
                                                <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center mx-auto border-4 border-gray-200">
                                                    <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <x-input-label for="profile_photo" value="Foto Profil" />
                                        <input type="file" id="profile_photo" name="profile_photo" class="mt-1 block w-full" />
                                        <p class="text-xs text-gray-500 mt-1">Unggah foto profil karyawan (opsional)</p>
                                        <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
                                    </div>
                                </div>
                                
                                <div>
                                    <x-input-label for="full_name" value="Nama Lengkap" />
                                    <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="$employee->full_name" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
                                </div>

                                <div>
                                    <x-input-label for="nik" value="NIK" />
                                    <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full" :value="$employee->nik" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                                </div>

                                <div>
                                    <x-input-label for="ktp_photo" value="Foto KTP" />
                                    <input type="file" id="ktp_photo" name="ktp_photo" class="mt-1 block w-full" />
                                    @if($employee->ktp_photo)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $employee->ktp_photo) }}" alt="Foto KTP" class="w-32">
                                        </div>
                                    @endif
                                    <x-input-error class="mt-2" :messages="$errors->get('ktp_photo')" />
                                </div>

                                <div>
                                    <x-input-label for="birth_place" value="Tempat Lahir" />
                                    <x-text-input id="birth_place" name="birth_place" type="text" class="mt-1 block w-full" :value="$employee->birth_place" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('birth_place')" />
                                </div>

                                <div>
                                    <x-input-label for="birth_date" value="Tanggal Lahir" />
                                    <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="$employee->birth_date->format('Y-m-d')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                                </div>

                                <div>
                                    <x-input-label for="gender" value="Jenis Kelamin" />
                                    <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="male" {{ $employee->gender == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="female" {{ $employee->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                                </div>

                                <div>
                                    <x-input-label for="marital_status" value="Status Pernikahan" />
                                    <select id="marital_status" name="marital_status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="single" {{ $employee->marital_status == 'single' ? 'selected' : '' }}>Belum Menikah</option>
                                        <option value="married" {{ $employee->marital_status == 'married' ? 'selected' : '' }}>Menikah</option>
                                        <option value="divorced" {{ $employee->marital_status == 'divorced' ? 'selected' : '' }}>Cerai</option>
                                        <option value="widowed" {{ $employee->marital_status == 'widowed' ? 'selected' : '' }}>Janda/Duda</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('marital_status')" />
                                </div>

                                <div class="col-span-2">
                                    <x-input-label for="address" value="Alamat" />
                                    <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ $employee->address }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                                </div>

                                <div>
                                    <x-input-label for="phone_number" value="Nomor Telepon" />
                                    <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="$employee->phone_number" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                                </div>

                                <div>
                                    <x-input-label for="personal_email" value="Email Pribadi" />
                                    <x-text-input id="personal_email" name="personal_email" type="email" class="mt-1 block w-full" :value="$employee->personal_email" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('personal_email')" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Informasi Asuransi & Keuangan</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="bpjs_health" value="BPJS Health" />
                                    <x-text-input id="bpjs_health" name="bpjs_health" type="text" class="mt-1 block w-full" :value="$employee->bpjs_health" />
                                    <x-input-error class="mt-2" :messages="$errors->get('bpjs_health')" />
                                </div>

                                <div>
                                    <x-input-label for="bpjs_health_photo" value="Foto Kartu BPJS Kesehatan" />
                                    <input type="file" id="bpjs_health_photo" name="bpjs_health_photo" class="mt-1 block w-full" />
                                    @if($employee->bpjs_health_photo)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $employee->bpjs_health_photo) }}" alt="Foto Kartu BPJS Kesehatan" class="w-32">
                                        </div>
                                    @endif
                                    <x-input-error class="mt-2" :messages="$errors->get('bpjs_health_photo')" />
                                </div>

                                <div>
                                    <x-input-label for="bpjs_employment" value="BPJS Ketenagakerjaan" />
                                    <x-text-input id="bpjs_employment" name="bpjs_employment" type="text" class="mt-1 block w-full" :value="$employee->bpjs_employment" />
                                    <x-input-error class="mt-2" :messages="$errors->get('bpjs_employment')" />
                                </div>

                                <div>
                                    <x-input-label for="bank_name" value="Nama Bank" />
                                    <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full" :value="$employee->bank_name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
                                </div>

                                <div>
                                    <x-input-label for="bank_account" value="Nomor Rekening Bank" />
                                    <x-text-input id="bank_account" name="bank_account" type="text" class="mt-1 block w-full" :value="$employee->bank_account" />
                                    <x-input-error class="mt-2" :messages="$errors->get('bank_account')" />
                                </div>

                                <div>
                                    <x-input-label for="npwp" value="NPWP" />
                                    <x-text-input id="npwp" name="npwp" type="text" class="mt-1 block w-full" :value="$employee->npwp" />
                                    <x-input-error class="mt-2" :messages="$errors->get('npwp')" />
                                </div>

                                <div>
                                    <x-input-label for="npwp_photo" value="Foto NPWP" />
                                    <input type="file" id="npwp_photo" name="npwp_photo" class="mt-1 block w-full" />
                                    @if($employee->npwp_photo)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $employee->npwp_photo) }}" alt="Foto NPWP" class="w-32">
                                        </div>
                                    @endif
                                    <x-input-error class="mt-2" :messages="$errors->get('npwp_photo')" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Informasi Perusahaan</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="employee_id" value="ID Karyawan (NIP)" />
                                    <x-text-input id="employee_id" name="employee_id" type="text" class="mt-1 block w-full" :value="$employee->employee_id" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('employee_id')" />
                                </div>

                                <div>
                                    <x-input-label for="work_unit_id" value="Unit Kerja" />
                                    <select id="work_unit_id" name="work_unit_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        @foreach($workUnits as $workUnit)
                                            <option value="{{ $workUnit->id }}" {{ $employee->work_unit_id == $workUnit->id ? 'selected' : '' }}>
                                                {{ $workUnit->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('work_unit_id')" />
                                </div>

                                <div>
                                    <x-input-label for="position_id" value="Jabatan" />
                                    <select id="position_id" name="position_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('position_id')" />
                                </div>

                                <div>
                                    <x-input-label for="employment_status" value="Status Kepegawaian" />
                                    <select id="employment_status" name="employment_status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="permanent" {{ $employee->employment_status == 'permanent' ? 'selected' : '' }}>Tetap</option>
                                        <option value="contract" {{ $employee->employment_status == 'contract' ? 'selected' : '' }}>Kontrak</option>
                                        <option value="probation" {{ $employee->employment_status == 'probation' ? 'selected' : '' }}>Masa Percobaan</option>
                                        <option value="intern" {{ $employee->employment_status == 'intern' ? 'selected' : '' }}>Magang</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('employment_status')" />
                                </div>

                                <div>
                                    <x-input-label for="join_date" value="Tanggal Bergabung" />
                                    <x-text-input id="join_date" name="join_date" type="date" class="mt-1 block w-full" :value="$employee->join_date->format('Y-m-d')" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('join_date')" />
                                </div>

                                <div>
                                    <x-input-label for="company_id" value="Perusahaan" />
                                    <select id="company_id" name="company_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        @foreach(App\Models\Company::all() as $company)
                                            <option value="{{ $company->id }}" {{ $employee->company_id == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('company_id')" />
                                </div>

                                <div>
                                    <x-input-label for="branch_office_id" value="Kantor Cabang" />
                                    <select id="branch_office_id" name="branch_office_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        @foreach(App\Models\BranchOffice::all() as $branch)
                                            <option value="{{ $branch->id }}" {{ $employee->branch_office_id == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('branch_office_id')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button onclick="window.history.back()" type="button" class="mr-3">
                                {{ __('Batal') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Perbarui Karyawan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
