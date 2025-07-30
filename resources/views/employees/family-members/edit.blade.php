<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Family Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('employees.family-members.update', [$employee, $familyMember]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <x-input-label for="full_name" value="Full Name" />
                                <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', $familyMember->full_name)" required />
                                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                            </div>

                            <!-- Relationship -->
                            <div>
                                <x-input-label for="relationship" value="Relationship" />
                                <select id="relationship" name="relationship" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Select Relationship</option>
                                    <option value="father" {{ old('relationship', $familyMember->relationship) == 'father' ? 'selected' : '' }}>Ayah</option>
                                    <option value="mother" {{ old('relationship', $familyMember->relationship) == 'mother' ? 'selected' : '' }}>Ibu</option>
                                    <option value="spouse" {{ old('relationship', $familyMember->relationship) == 'spouse' ? 'selected' : '' }}>Suami/Istri</option>
                                    <option value="child" {{ old('relationship', $familyMember->relationship) == 'child' ? 'selected' : '' }}>Anak</option>
                                    <option value="sibling" {{ old('relationship', $familyMember->relationship) == 'sibling' ? 'selected' : '' }}>Saudara Kandung</option>
                                    <option value="grandfather" {{ old('relationship', $familyMember->relationship) == 'grandfather' ? 'selected' : '' }}>Kakek</option>
                                    <option value="grandmother" {{ old('relationship', $familyMember->relationship) == 'grandmother' ? 'selected' : '' }}>Nenek</option>
                                    <option value="father_in_law" {{ old('relationship', $familyMember->relationship) == 'father_in_law' ? 'selected' : '' }}>Ayah Mertua</option>
                                    <option value="mother_in_law" {{ old('relationship', $familyMember->relationship) == 'mother_in_law' ? 'selected' : '' }}>Ibu Mertua</option>
                                    <option value="other" {{ old('relationship', $familyMember->relationship) == 'other' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                <x-input-error :messages="$errors->get('relationship')" class="mt-2" />
                            </div>

                            <!-- Other Relationship -->
                            <div id="otherRelationshipField" class="hidden">
                                <x-input-label for="other_relationship" value="Specify Relationship" />
                                <x-text-input id="other_relationship" name="other_relationship" type="text" class="mt-1 block w-full" :value="old('other_relationship', $familyMember->other_relationship)" />
                                <x-input-error :messages="$errors->get('other_relationship')" class="mt-2" />
                            </div>

                            <!-- Birth Place -->
                            <div>
                                <x-input-label for="birth_place" value="Birth Place" />
                                <x-text-input id="birth_place" name="birth_place" type="text" class="mt-1 block w-full" :value="old('birth_place', $familyMember->birth_place)" required />
                                <x-input-error :messages="$errors->get('birth_place')" class="mt-2" />
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <x-input-label for="birth_date" value="Birth Date" />
                                <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', $familyMember->birth_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                            </div>

                            <!-- Gender -->
                            <div>
                                <x-input-label for="gender" value="Gender" />
                                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="male" {{ old('gender', $familyMember->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', $familyMember->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <!-- Is Alive -->
                            <div>
                                <div class="flex items-center mt-4">
                                    <input type="hidden" name="is_alive" value="0">
                                    <input id="is_alive" type="checkbox" name="is_alive" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_alive', $familyMember->is_alive) ? 'checked' : '' }}>
                                    <label for="is_alive" class="ml-2 block text-sm text-gray-900">Masih Hidup</label>
                                </div>
                            </div>

                            <!-- Death Date -->
                            <div id="deathDateField" class="hidden">
                                <x-input-label for="death_date" value="Death Date" />
                                <x-text-input id="death_date" name="death_date" type="date" class="mt-1 block w-full" :value="old('death_date', $familyMember->death_date?->format('Y-m-d'))" />
                                <x-input-error :messages="$errors->get('death_date')" class="mt-2" />
                            </div>

                            <!-- Education Level -->
                            <div>
                                <x-input-label for="education_level" value="Education Level (Optional)" />
                                <select id="education_level" name="education_level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select Education Level</option>
                                    <option value="sd" {{ old('education_level', $familyMember->education_level) == 'sd' ? 'selected' : '' }}>SD</option>
                                    <option value="smp" {{ old('education_level', $familyMember->education_level) == 'smp' ? 'selected' : '' }}>SMP</option>
                                    <option value="sma" {{ old('education_level', $familyMember->education_level) == 'sma' ? 'selected' : '' }}>SMA</option>
                                    <option value="smk" {{ old('education_level', $familyMember->education_level) == 'smk' ? 'selected' : '' }}>SMK</option>
                                    <option value="d1" {{ old('education_level', $familyMember->education_level) == 'd1' ? 'selected' : '' }}>D1</option>
                                    <option value="d2" {{ old('education_level', $familyMember->education_level) == 'd2' ? 'selected' : '' }}>D2</option>
                                    <option value="d3" {{ old('education_level', $familyMember->education_level) == 'd3' ? 'selected' : '' }}>D3</option>
                                    <option value="d4" {{ old('education_level', $familyMember->education_level) == 'd4' ? 'selected' : '' }}>D4</option>
                                    <option value="s1" {{ old('education_level', $familyMember->education_level) == 's1' ? 'selected' : '' }}>S1</option>
                                    <option value="s2" {{ old('education_level', $familyMember->education_level) == 's2' ? 'selected' : '' }}>S2</option>
                                    <option value="s3" {{ old('education_level', $familyMember->education_level) == 's3' ? 'selected' : '' }}>S3</option>
                                </select>
                                <x-input-error :messages="$errors->get('education_level')" class="mt-2" />
                            </div>

                            <!-- Occupation -->
                            <div>
                                <x-input-label for="occupation" value="Occupation (Optional)" />
                                <x-text-input id="occupation" name="occupation" type="text" class="mt-1 block w-full" :value="old('occupation', $familyMember->occupation)" />
                                <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                            </div>

                            <!-- Financial Dependent -->
                            <div>
                                <div class="flex items-center mt-4">
                                    <input type="hidden" name="is_financial_dependent" value="0">
                                    <input id="is_financial_dependent" type="checkbox" name="is_financial_dependent" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_financial_dependent', $familyMember->is_financial_dependent) ? 'checked' : '' }}>
                                    <label for="is_financial_dependent" class="ml-2 block text-sm text-gray-900">Tanggungan Finansial</label>
                                </div>
                            </div>

                            <!-- Marital Status -->
                            <div>
                                <x-input-label for="marital_status" value="Marital Status (Optional)" />
                                <select id="marital_status" name="marital_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select Marital Status</option>
                                    <option value="single" {{ old('marital_status', $familyMember->marital_status) == 'single' ? 'selected' : '' }}>Belum Menikah</option>
                                    <option value="married" {{ old('marital_status', $familyMember->marital_status) == 'married' ? 'selected' : '' }}>Menikah</option>
                                    <option value="divorced" {{ old('marital_status', $familyMember->marital_status) == 'divorced' ? 'selected' : '' }}>Cerai</option>
                                    <option value="widowed" {{ old('marital_status', $familyMember->marital_status) == 'widowed' ? 'selected' : '' }}>Janda/Duda</option>
                                </select>
                                <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
                            </div>

                            <!-- Emergency Contact -->
                            <div>
                                <div class="flex items-center mt-4">
                                    <input type="hidden" name="is_emergency_contact" value="0">
                                    <input id="is_emergency_contact" type="checkbox" name="is_emergency_contact" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_emergency_contact', $familyMember->is_emergency_contact) ? 'checked' : '' }}>
                                    <label for="is_emergency_contact" class="ml-2 block text-sm text-gray-900">Kontak Darurat</label>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <x-input-label for="phone_number" value="Phone Number (Optional)" />
                                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $familyMember->phone_number)" />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" value="Email (Optional)" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $familyMember->email)" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <x-input-label for="address" value="Address (Optional)" />
                                <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('address', $familyMember->address) }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Update Family Member
                            </x-primary-button>
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
                if (relationshipSelect.value === 'other') {
                    document.querySelector('#other_relationship').setAttribute('required', 'required');
                } else {
                    document.querySelector('#other_relationship').removeAttribute('required');
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
                } else {
                    phoneInput.removeAttribute('required');
                }
            }

            relationshipSelect.addEventListener('change', toggleOtherRelationship);
            isAliveCheckbox.addEventListener('change', toggleDeathDate);
            isEmergencyContactCheckbox.addEventListener('change', togglePhoneRequired);

            toggleOtherRelationship();
            toggleDeathDate();
            togglePhoneRequired();
        });
    </script>
    @endpush
</x-app-layout>
