<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Skill') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('employees.skills.store', $employee) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Skill Category -->
                            <div>
                                <x-input-label for="skill_category_id" value="Skill Category" />
                                <select id="skill_category_id" name="skill_category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select Skill Category</option>
                                    @foreach($skillCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('skill_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('skill_category_id')" class="mt-2" />
                            </div>

                            <!-- Skill Name -->
                            <div>
                                <x-input-label for="name" value="Skill Name" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Proficiency Level -->
                            <div>
                                <x-input-label for="proficiency_level" value="Proficiency Level" />
                                <select id="proficiency_level" name="proficiency_level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="beginner" {{ old('proficiency_level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('proficiency_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('proficiency_level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                    <option value="expert" {{ old('proficiency_level') == 'expert' ? 'selected' : '' }}>Expert</option>
                                </select>
                                <x-input-error :messages="$errors->get('proficiency_level')" class="mt-2" />
                            </div>

                            <!-- Years of Experience -->
                            <div>
                                <x-input-label for="years_of_experience" value="Years of Experience" />
                                <x-text-input id="years_of_experience" name="years_of_experience" type="number" min="0" class="mt-1 block w-full" :value="old('years_of_experience')" />
                                <x-input-error :messages="$errors->get('years_of_experience')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" value="Description" />
                                <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Certification -->
                            <div>
                                <x-input-label for="certification" value="Certification" />
                                <input type="file" id="certification" name="certification" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('certification')" class="mt-2" />
                            </div>

                            <!-- Certification Date -->
                            <div>
                                <x-input-label for="certification_date" value="Certification Date" />
                                <x-text-input id="certification_date" name="certification_date" type="date" class="mt-1 block w-full" :value="old('certification_date')" />
                                <x-input-error :messages="$errors->get('certification_date')" class="mt-2" />
                            </div>

                            <!-- Certification Expiry -->
                            <div>
                                <x-input-label for="certification_expiry" value="Certification Expiry" />
                                <x-text-input id="certification_expiry" name="certification_expiry" type="date" class="mt-1 block w-full" :value="old('certification_expiry')" />
                                <x-input-error :messages="$errors->get('certification_expiry')" class="mt-2" />
                            </div>

                            <!-- Issuing Organization -->
                            <div>
                                <x-input-label for="issuing_organization" value="Issuing Organization" />
                                <x-text-input id="issuing_organization" name="issuing_organization" type="text" class="mt-1 block w-full" :value="old('issuing_organization')" />
                                <x-input-error :messages="$errors->get('issuing_organization')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button>
                                Save Skill
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
