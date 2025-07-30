<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Tambah Keahlian
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Tambah data keahlian untuk {{ $employee->full_name }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6">
                    <form action="{{ route('employees.skills.store', $employee) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Employee Info Card -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-600 rounded-lg p-4 mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $employee->full_name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $employee->employee_id }} - {{ $employee->position->name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Skill Selection -->
                            <div class="md:col-span-2">
                                <label for="skill_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Pilih Keahlian <span class="text-red-500">*</span>
                                </label>
                                <select id="skill_id" name="skill_id" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Pilih Keahlian</option>
                                    @foreach($skillCategories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($skills->where('category_id', $category->id) as $skill)
                                                <option value="{{ $skill->id }}" {{ old('skill_id') == $skill->id ? 'selected' : '' }}>
                                                    {{ $skill->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('skill_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Proficiency Level -->
                            <div>
                                <label for="proficiency_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tingkat Keahlian <span class="text-red-500">*</span>
                                </label>
                                <select id="proficiency_level" name="proficiency_level" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                                    <option value="beginner" {{ old('proficiency_level') == 'beginner' ? 'selected' : '' }}>Pemula</option>
                                    <option value="intermediate" {{ old('proficiency_level') == 'intermediate' ? 'selected' : '' }}>Menengah</option>
                                    <option value="advanced" {{ old('proficiency_level') == 'advanced' ? 'selected' : '' }}>Mahir</option>
                                    <option value="expert" {{ old('proficiency_level') == 'expert' ? 'selected' : '' }}>Ahli</option>
                                </select>
                                @error('proficiency_level')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Catatan Keahlian
                            </label>
                            <textarea id="notes" name="notes" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                                      placeholder="Jelaskan detail keahlian, proyek yang pernah dikerjakan, atau pencapaian terkait...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Certificate Upload -->
                        <div>
                            <label for="certificate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                File Sertifikat
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-gray-400 dark:hover:border-gray-500 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="certificate" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                            <span>Upload file</span>
                                            <input id="certificate" name="certificate" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        PDF, PNG, JPG hingga 2MB
                                    </p>
                                </div>
                            </div>
                            @error('certificate')
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
                                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Data Keahlian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
