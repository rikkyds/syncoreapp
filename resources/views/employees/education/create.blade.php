<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Tambah Riwayat Pendidikan
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Tambah data pendidikan untuk {{ $employee->full_name }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6">
                    <form action="{{ route('employees.education.store', $employee) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Employee Info Card -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-lg p-4 mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $employee->full_name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $employee->employee_id }} - {{ $employee->position->name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Education Level -->
                            <div>
                                <label for="education_level_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jenjang Pendidikan <span class="text-red-500">*</span>
                                </label>
                                <select id="education_level_id" name="education_level_id" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Pilih Jenjang Pendidikan</option>
                                    @foreach($educationLevels as $level)
                                        <option value="{{ $level->id }}" {{ old('education_level_id') == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('education_level_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Institution Name -->
                            <div>
                                <label for="institution_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Institusi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="institution_name" name="institution_name" 
                                       value="{{ old('institution_name') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: Universitas Indonesia">
                                @error('institution_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Major -->
                            <div>
                                <label for="major" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jurusan/Bidang Studi
                                </label>
                                <input type="text" id="major" name="major" 
                                       value="{{ old('major') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: Teknik Informatika">
                                @error('major')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Degree -->
                            <div>
                                <label for="degree" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Gelar
                                </label>
                                <input type="text" id="degree" name="degree" 
                                       value="{{ old('degree') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: S.Kom, S.T, S.E">
                                @error('degree')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Kota <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="city" name="city" 
                                       value="{{ old('city') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: Jakarta">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Country -->
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Negara <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="country" name="country" 
                                       value="{{ old('country', 'Indonesia') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: Indonesia">
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Year -->
                            <div>
                                <label for="start_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tahun Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="start_year" name="start_year" 
                                       value="{{ old('start_year') }}" min="1950" max="{{ date('Y') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: 2018">
                                @error('start_year')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Year -->
                            <div>
                                <label for="end_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tahun Selesai
                                </label>
                                <input type="number" id="end_year" name="end_year" 
                                       value="{{ old('end_year') }}" min="1950" max="{{ date('Y') + 10 }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Kosongkan jika masih berlangsung">
                                @error('end_year')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="graduated" {{ old('status') == 'graduated' ? 'selected' : '' }}>Lulus</option>
                                    <option value="not_graduated" {{ old('status') == 'not_graduated' ? 'selected' : '' }}>Tidak Lulus</option>
                                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Sedang Berjalan</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- GPA -->
                            <div>
                                <label for="gpa" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    IPK/GPA
                                </label>
                                <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="4.00"
                                       value="{{ old('gpa') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: 3.75">
                                @error('gpa')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Certificate Upload -->
                        <div>
                            <label for="certificate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sertifikat/Ijazah
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-gray-400 dark:hover:border-gray-500 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="certificate" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
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
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Data Pendidikan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
