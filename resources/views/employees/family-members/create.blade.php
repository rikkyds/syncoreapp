<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Tambah Anggota Keluarga
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Tambah data anggota keluarga untuk {{ $employee->full_name }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6">
                    <form action="{{ route('employees.family-members.store', $employee) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Employee Info Card -->
                        <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-gray-700 dark:to-gray-600 rounded-lg p-4 mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $employee->full_name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $employee->employee_id }} - {{ $employee->position->name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="full_name" name="full_name" 
                                       value="{{ old('full_name') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: Ahmad Suryadi">
                                @error('full_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Relationship -->
                            <div>
                                <label for="relationship" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Hubungan Keluarga <span class="text-red-500">*</span>
                                </label>
                                <select id="relationship" name="relationship" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Pilih Hubungan Keluarga</option>
                                    <option value="father" {{ old('relationship') == 'father' ? 'selected' : '' }}>Ayah</option>
                                    <option value="mother" {{ old('relationship') == 'mother' ? 'selected' : '' }}>Ibu</option>
                                    <option value="spouse" {{ old('relationship') == 'spouse' ? 'selected' : '' }}>Suami/Istri</option>
                                    <option value="child" {{ old('relationship') == 'child' ? 'selected' : '' }}>Anak</option>
                                    <option value="sibling" {{ old('relationship') == 'sibling' ? 'selected' : '' }}>Saudara Kandung</option>
                                    <option value="grandfather" {{ old('relationship') == 'grandfather' ? 'selected' : '' }}>Kakek</option>
                                    <option value="grandmother" {{ old('relationship') == 'grandmother' ? 'selected' : '' }}>Nenek</option>
                                    <option value="father_in_law" {{ old('relationship') == 'father_in_law' ? 'selected' : '' }}>Ayah Mertua</option>
                                    <option value="mother_in_law" {{ old('relationship') == 'mother_in_law' ? 'selected' : '' }}>Ibu Mertua</option>
                                    <option value="other" {{ old('relationship') == 'other' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('relationship')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Other Relationship -->
                            <div id="otherRelationshipField" class="hidden">
                                <label for="other_relationship" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Sebutkan Hubungan Keluarga <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="other_relationship" name="other_relationship" 
                                       value="{{ old('other_relationship') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: Sepupu, Keponakan">
                                @error('other_relationship')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Birth Place -->
                            <div>
                                <label for="birth_place" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="birth_place" name="birth_place" 
                                       value="{{ old('birth_place') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: Jakarta">
                                @error('birth_place')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="birth_date" name="birth_date" 
                                       value="{{ old('birth_date') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white">
                                @error('birth_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select id="gender" name="gender" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white">
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Education Level -->
                            <div>
                                <label for="education_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tingkat Pendidikan (Opsional)
                                </label>
                                <select id="education_level" name="education_level" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Pilih Tingkat Pendidikan</option>
                                    <option value="sd" {{ old('education_level') == 'sd' ? 'selected' : '' }}>SD</option>
                                    <option value="smp" {{ old('education_level') == 'smp' ? 'selected' : '' }}>SMP</option>
                                    <option value="sma" {{ old('education_level') == 'sma' ? 'selected' : '' }}>SMA</option>
                                    <option value="smk" {{ old('education_level') == 'smk' ? 'selected' : '' }}>SMK</option>
                                    <option value="d1" {{ old('education_level') == 'd1' ? 'selected' : '' }}>D1</option>
                                    <option value="d2" {{ old('education_level') == 'd2' ? 'selected' : '' }}>D2</option>
                                    <option value="d3" {{ old('education_level') == 'd3' ? 'selected' : '' }}>D3</option>
                                    <option value="d4" {{ old('education_level') == 'd4' ? 'selected' : '' }}>D4</option>
                                    <option value="s1" {{ old('education_level') == 's1' ? 'selected' : '' }}>S1</option>
                                    <option value="s2" {{ old('education_level') == 's2' ? 'selected' : '' }}>S2</option>
                                    <option value="s3" {{ old('education_level') == 's3' ? 'selected' : '' }}>S3</option>
                                </select>
                                @error('education_level')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Occupation -->
                            <div>
                                <label for="occupation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Pekerjaan (Opsional)
                                </label>
                                <input type="text" id="occupation" name="occupation" 
                                       value="{{ old('occupation') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: Guru, Dokter, Ibu Rumah Tangga">
                                @error('occupation')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Marital Status -->
                            <div>
                                <label for="marital_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Status Pernikahan (Opsional)
                                </label>
                                <select id="marital_status" name="marital_status" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Pilih Status Pernikahan</option>
                                    <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Belum Menikah</option>
                                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Menikah</option>
                                    <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Cerai</option>
                                    <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Janda/Duda</option>
                                </select>
                                @error('marital_status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nomor Telepon (Opsional)
                                </label>
                                <input type="text" id="phone_number" name="phone_number" 
                                       value="{{ old('phone_number') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: +62 812 3456 7890">
                                @error('phone_number')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email (Opsional)
                                </label>
                                <input type="email" id="email" name="email" 
                                       value="{{ old('email') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: email@example.com">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Checkboxes -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Is Alive -->
                            <div class="flex items-center">
                                <input type="hidden" name="is_alive" value="0">
                                <input id="is_alive" type="checkbox" name="is_alive" value="1" 
                                       class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500" 
                                       {{ old('is_alive', '1') == '1' ? 'checked' : '' }}>
                                <label for="is_alive" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Masih Hidup</label>
                            </div>

                            <!-- Financial Dependent -->
                            <div class="flex items-center">
                                <input type="hidden" name="is_financial_dependent" value="0">
                                <input id="is_financial_dependent" type="checkbox" name="is_financial_dependent" value="1" 
                                       class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500" 
                                       {{ old('is_financial_dependent') == '1' ? 'checked' : '' }}>
                                <label for="is_financial_dependent" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Tanggungan Finansial</label>
                            </div>

                            <!-- Emergency Contact -->
                            <div class="flex items-center">
                                <input type="hidden" name="is_emergency_contact" value="0">
                                <input id="is_emergency_contact" type="checkbox" name="is_emergency_contact" value="1" 
                                       class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500" 
                                       {{ old('is_emergency_contact') == '1' ? 'checked' : '' }}>
                                <label for="is_emergency_contact" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Kontak Darurat</label>
                            </div>
                        </div>

                        <!-- Death Date -->
                        <div id="deathDateField" class="hidden">
                            <label for="death_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Meninggal <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="death_date" name="death_date" 
                                   value="{{ old('death_date') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white">
                            @error('death_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Alamat (Opsional)
                            </label>
                            <textarea id="address" name="address" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                      placeholder="Masukkan alamat lengkap...">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('employees.show', $employee) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Data Keluarga
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const relationshipSelect = document.querySelector('#relationship');
            const otherRelationshipField = document.querySelector('#otherRelationshipField');
            const isAliveCheckbox = document.querySelector('#is_alive');
            const deathDateField = document.querySelector('#deathDateField');
            const isEmergencyContactCheckbox = document.querySelector('#is_emergency_contact');
            const phoneInput = document.querySelector('#phone_number');

            function toggleOtherRelationship() {
                otherRelationshipField.classList.toggle('hidden', relationshipSelect.value !== 'other');
                const otherInput = document.querySelector('#other_relationship');
                if (relationshipSelect.value === 'other') {
                    otherInput.setAttribute('required', 'required');
                } else {
                    otherInput.removeAttribute('required');
                    otherInput.value = '';
                }
            }

            function toggleDeathDate() {
                deathDateField.classList.toggle('hidden', isAliveCheckbox.checked);
                const deathDateInput = document.querySelector('#death_date');
                if (!isAliveCheckbox.checked) {
                    deathDateInput.setAttribute('required', 'required');
                } else {
                    deathDateInput.removeAttribute('required');
                    deathDateInput.value = '';
                }
            }

            function togglePhoneRequired() {
                if (isEmergencyContactCheckbox.checked) {
                    phoneInput.setAttribute('required', 'required');
                    phoneInput.parentElement.querySelector('label').innerHTML = 'Nomor Telepon <span class="text-red-500">*</span>';
                } else {
                    phoneInput.removeAttribute('required');
                    phoneInput.parentElement.querySelector('label').innerHTML = 'Nomor Telepon (Opsional)';
                }
            }

            relationshipSelect.addEventListener('change', toggleOtherRelationship);
            isAliveCheckbox.addEventListener('change', toggleDeathDate);
            isEmergencyContactCheckbox.addEventListener('change', togglePhoneRequired);

            // Initialize states
            toggleOtherRelationship();
            toggleDeathDate();
            togglePhoneRequired();
        });
    </script>
    @endpush
</x-app-layout>
