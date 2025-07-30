<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Education Record') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('employees.education.update', [$employee, $education]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Education Level -->
                            <div>
                                <x-input-label for="education_level_id" value="Education Level" />
                                <select id="education_level_id" name="education_level_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select Education Level</option>
                                    @foreach($educationLevels as $level)
                                        <option value="{{ $level->id }}" {{ (old('education_level_id', $education->education_level_id) == $level->id) ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('education_level_id')" class="mt-2" />
                            </div>

                            <!-- Institution Name -->
                            <div>
                                <x-input-label for="institution_name" value="Institution Name" />
                                <x-text-input id="institution_name" name="institution_name" type="text" class="mt-1 block w-full" :value="old('institution_name', $education->institution_name)" />
                                <x-input-error :messages="$errors->get('institution_name')" class="mt-2" />
                            </div>

                            <!-- Major -->
                            <div>
                                <x-input-label for="major" value="Major/Field of Study" />
                                <x-text-input id="major" name="major" type="text" class="mt-1 block w-full" :value="old('major', $education->major)" />
                                <x-input-error :messages="$errors->get('major')" class="mt-2" />
                            </div>

                            <!-- City -->
                            <div>
                                <x-input-label for="city" value="City" />
                                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $education->city)" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <!-- Country -->
                            <div>
                                <x-input-label for="country" value="Country" />
                                <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $education->country)" />
                                <x-input-error :messages="$errors->get('country')" class="mt-2" />
                            </div>

                            <!-- Start Year -->
                            <div>
                                <x-input-label for="start_year" value="Start Year" />
                                <x-text-input id="start_year" name="start_year" type="number" class="mt-1 block w-full" :value="old('start_year', $education->start_year)" />
                                <x-input-error :messages="$errors->get('start_year')" class="mt-2" />
                            </div>

                            <!-- End Year -->
                            <div>
                                <x-input-label for="end_year" value="End Year" />
                                <x-text-input id="end_year" name="end_year" type="number" class="mt-1 block w-full" :value="old('end_year', $education->end_year)" />
                                <x-input-error :messages="$errors->get('end_year')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" value="Status" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="graduated" {{ old('status', $education->status) == 'graduated' ? 'selected' : '' }}>Graduated</option>
                                    <option value="not_graduated" {{ old('status', $education->status) == 'not_graduated' ? 'selected' : '' }}>Not Graduated</option>
                                    <option value="ongoing" {{ old('status', $education->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Degree -->
                            <div>
                                <x-input-label for="degree" value="Degree" />
                                <x-text-input id="degree" name="degree" type="text" class="mt-1 block w-full" :value="old('degree', $education->degree)" />
                                <x-input-error :messages="$errors->get('degree')" class="mt-2" />
                            </div>

                            <!-- GPA -->
                            <div>
                                <x-input-label for="gpa" value="GPA" />
                                <x-text-input id="gpa" name="gpa" type="number" step="0.01" class="mt-1 block w-full" :value="old('gpa', $education->gpa)" />
                                <x-input-error :messages="$errors->get('gpa')" class="mt-2" />
                            </div>

                            <!-- Certificate -->
                            <div>
                                <x-input-label for="certificate" value="Certificate" />
                                <input type="file" id="certificate" name="certificate" class="mt-1 block w-full" />
                                @if($education->certificate)
                                    <div class="mt-2">
                                        <a href="{{ Storage::url($education->certificate) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                            View Current Certificate
                                        </a>
                                    </div>
                                @endif
                                <x-input-error :messages="$errors->get('certificate')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Update Education Record
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
