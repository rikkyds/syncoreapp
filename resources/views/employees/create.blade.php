<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Karyawan Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Informasi Pribadi</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="full_name" value="Nama Lengkap" />
                                    <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
                                </div>

                                <div>
                                    <x-input-label for="nik" value="NIK" />
                                    <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                                </div>

                                <div>
                                    <x-input-label for="ktp_photo" value="Foto KTP" />
                                    <input type="file" id="ktp_photo" name="ktp_photo" class="mt-1 block w-full" />
                                    <x-input-error class="mt-2" :messages="$errors->get('ktp_photo')" />
                                </div>

                                <div>
                                    <x-input-label for="birth_place" value="Tempat Lahir" />
                                    <x-text-input id="birth_place" name="birth_place" type="text" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('birth_place')" />
                                </div>

                                <div>
                                    <x-input-label for="birth_date" value="Tanggal Lahir" />
                                    <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                                </div>

                                <div>
                                    <x-input-label for="gender" value="Jenis Kelamin" />
                                    <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="male">Laki-laki</option>
                                        <option value="female">Perempuan</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                                </div>

                                <div>
                                    <x-input-label for="marital_status" value="Status Pernikahan" />
                                    <select id="marital_status" name="marital_status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="single">Belum Menikah</option>
                                        <option value="married">Menikah</option>
                                        <option value="divorced">Bercerai</option>
                                        <option value="widowed">Janda/Duda</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('marital_status')" />
                                </div>

                                <div class="col-span-2">
                                    <x-input-label for="address" value="Alamat" />
                                    <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                                </div>

                                <div>
                                    <x-input-label for="phone_number" value="Nomor Telepon" />
                                    <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                                </div>

                                <div>
                                    <x-input-label for="personal_email" value="Email Pribadi" />
                                    <x-text-input id="personal_email" name="personal_email" type="email" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('personal_email')" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Informasi Asuransi & Keuangan</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="bpjs_health" value="BPJS Kesehatan" />
                                    <x-text-input id="bpjs_health" name="bpjs_health" type="text" class="mt-1 block w-full" />
                                    <x-input-error class="mt-2" :messages="$errors->get('bpjs_health')" />
                                </div>

                                <div>
                                    <x-input-label for="bpjs_health_photo" value="Foto Kartu BPJS Kesehatan" />
                                    <input type="file" id="bpjs_health_photo" name="bpjs_health_photo" class="mt-1 block w-full" />
                                    <x-input-error class="mt-2" :messages="$errors->get('bpjs_health_photo')" />
                                </div>

                                <div>
                                    <x-input-label for="bpjs_employment" value="BPJS Ketenagakerjaan" />
                                    <x-text-input id="bpjs_employment" name="bpjs_employment" type="text" class="mt-1 block w-full" />
                                    <x-input-error class="mt-2" :messages="$errors->get('bpjs_employment')" />
                                </div>

                                <div>
                                    <x-input-label for="bank_name" value="Nama Bank" />
                                    <x-text-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full" />
                                    <x-input-error class="mt-2" :messages="$errors->get('bank_name')" />
                                </div>

                                <div>
                                    <x-input-label for="bank_account" value="Nomor Rekening Bank" />
                                    <x-text-input id="bank_account" name="bank_account" type="text" class="mt-1 block w-full" />
                                    <x-input-error class="mt-2" :messages="$errors->get('bank_account')" />
                                </div>

                                <div>
                                    <x-input-label for="npwp" value="NPWP" />
                                    <x-text-input id="npwp" name="npwp" type="text" class="mt-1 block w-full" />
                                    <x-input-error class="mt-2" :messages="$errors->get('npwp')" />
                                </div>

                                <div>
                                    <x-input-label for="npwp_photo" value="Foto NPWP" />
                                    <input type="file" id="npwp_photo" name="npwp_photo" class="mt-1 block w-full" />
                                    <x-input-error class="mt-2" :messages="$errors->get('npwp_photo')" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Informasi Perusahaan</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="employee_id" value="ID Karyawan (NIP)" />
                                    <x-text-input id="employee_id" name="employee_id" type="text" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('employee_id')" />
                                </div>

                                <div>
                                    <x-input-label for="work_unit_id" value="Unit Kerja" />
                                    <select id="work_unit_id" name="work_unit_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        @foreach($workUnits as $workUnit)
                                            <option value="{{ $workUnit->id }}">{{ $workUnit->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('work_unit_id')" />
                                </div>

                                <div>
                                    <x-input-label for="position_id" value="Jabatan" />
                                    <select id="position_id" name="position_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('position_id')" />
                                </div>

                                <div>
                                    <x-input-label for="employment_status" value="Status Kepegawaian" />
                                    <select id="employment_status" name="employment_status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="permanent">Tetap</option>
                                        <option value="contract">Kontrak</option>
                                        <option value="probation">Masa Percobaan</option>
                                        <option value="intern">Magang</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('employment_status')" />
                                </div>

                                <div>
                                    <x-input-label for="join_date" value="Tanggal Bergabung" />
                                    <x-text-input id="join_date" name="join_date" type="date" class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('join_date')" />
                                </div>

                                <div>
                                    <x-input-label for="company_id" value="Perusahaan" />
                                    <select id="company_id" name="company_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        @foreach(App\Models\Company::all() as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('company_id')" />
                                </div>

                                <div>
                                    <x-input-label for="branch_office_id" value="Kantor Cabang" />
                                    <select id="branch_office_id" name="branch_office_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        @foreach(App\Models\BranchOffice::all() as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('branch_office_id')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button onclick="window.history.back()" type="button" class="mr-3">
                                Batal
                            </x-secondary-button>
                            <x-primary-button>
                                Tambah Karyawan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
