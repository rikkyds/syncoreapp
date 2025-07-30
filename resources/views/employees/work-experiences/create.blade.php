<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Work Experience') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('employees.work-experiences.store', $employee) }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Company Name -->
                            <div>
                                <x-input-label for="company_name" value="Company Name" />
                                <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name')" required />
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>

                            <!-- Industry -->
                            <div>
                                <x-input-label for="industry" value="Industry" />
                                <x-text-input id="industry" name="industry" type="text" class="mt-1 block w-full" :value="old('industry')" required />
                                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                            </div>

                            <!-- Position -->
                            <div>
                                <x-input-label for="position" value="Position" />
                                <x-text-input id="position" name="position" type="text" class="mt-1 block w-full" :value="old('position')" required />
                                <x-input-error :messages="$errors->get('position')" class="mt-2" />
                            </div>

                            <!-- Employment Status -->
                            <div>
                                <x-input-label for="employment_status" value="Employment Status" />
                                <select id="employment_status" name="employment_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="full_time" {{ old('employment_status') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="part_time" {{ old('employment_status') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                    <option value="contract" {{ old('employment_status') == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="internship" {{ old('employment_status') == 'internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                                <x-input-error :messages="$errors->get('employment_status')" class="mt-2" />
                            </div>

                            <!-- Start Date -->
                            <div>
                                <x-input-label for="start_date" value="Start Date" />
                                <x-text-input id="start_date" name="start_date" type="month" class="mt-1 block w-full" :value="old('start_date')" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <!-- End Date -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <x-input-label for="end_date" value="End Date" class="flex-1" />
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="is_current" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_current') ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">Current Position</span>
                                    </label>
                                </div>
                                <x-text-input id="end_date" name="end_date" type="month" class="mt-1 block w-full" :value="old('end_date')" />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>

                            <!-- Location -->
                            <div>
                                <x-input-label for="location" value="Location" />
                                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')" required />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <!-- Remote Work -->
                            <div>
                                <label class="inline-flex items-center mt-6">
                                    <input type="checkbox" name="is_remote" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_remote') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Remote Work</span>
                                </label>
                            </div>

                            <!-- Salary -->
                            <div>
                                <x-input-label for="salary" value="Salary (Optional)" />
                                <div class="flex gap-2">
                                    <select name="salary_currency" class="w-24 border-gray-300 rounded-md shadow-sm">
                                        <option value="IDR" {{ old('salary_currency') == 'IDR' ? 'selected' : '' }}>IDR</option>
                                        <option value="USD" {{ old('salary_currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                        <option value="SGD" {{ old('salary_currency') == 'SGD' ? 'selected' : '' }}>SGD</option>
                                        <option value="EUR" {{ old('salary_currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                    </select>
                                    <x-text-input id="salary" name="salary" type="number" step="0.01" class="mt-0 block w-full" :value="old('salary')" />
                                </div>
                                <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                            </div>

                            <!-- Main Responsibilities -->
                            <div class="md:col-span-2">
                                <x-input-label for="main_responsibilities" value="Main Responsibilities" />
                                <textarea id="main_responsibilities" name="main_responsibilities" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('main_responsibilities') }}</textarea>
                                <x-input-error :messages="$errors->get('main_responsibilities')" class="mt-2" />
                            </div>

                            <!-- Leaving Reason -->
                            <div class="md:col-span-2">
                                <x-input-label for="leaving_reason" value="Reason for Leaving (Optional)" />
                                <textarea id="leaving_reason" name="leaving_reason" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('leaving_reason') }}</textarea>
                                <x-input-error :messages="$errors->get('leaving_reason')" class="mt-2" />
                            </div>

                            <!-- Reference Details -->
                            <div>
                                <x-input-label value="Reference Details (Optional)" class="mb-2" />
                                
                                <div class="space-y-2">
                                    <div>
                                        <x-input-label for="reference_name" value="Name" class="text-sm" />
                                        <x-text-input id="reference_name" name="reference_name" type="text" class="mt-1 block w-full" :value="old('reference_name')" />
                                    </div>

                                    <div>
                                        <x-input-label for="reference_position" value="Position" class="text-sm" />
                                        <x-text-input id="reference_position" name="reference_position" type="text" class="mt-1 block w-full" :value="old('reference_position')" />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <x-input-label value="&nbsp;" class="mb-2" />
                                
                                <div class="space-y-2">
                                    <div>
                                        <x-input-label for="reference_contact" value="Contact Number" class="text-sm" />
                                        <x-text-input id="reference_contact" name="reference_contact" type="text" class="mt-1 block w-full" :value="old('reference_contact')" />
                                    </div>

                                    <div>
                                        <x-input-label for="reference_email" value="Email" class="text-sm" />
                                        <x-text-input id="reference_email" name="reference_email" type="email" class="mt-1 block w-full" :value="old('reference_email')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Save Work Experience
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
            const isCurrentCheckbox = document.querySelector('input[name="is_current"]');
            const endDateInput = document.querySelector('#end_date');

            function toggleEndDate() {
                endDateInput.disabled = isCurrentCheckbox.checked;
                if (isCurrentCheckbox.checked) {
                    endDateInput.value = '';
                }
            }

            isCurrentCheckbox.addEventListener('change', toggleEndDate);
            toggleEndDate();
        });
    </script>
    @endpush
</x-app-layout>
