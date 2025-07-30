<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Tambah Pengalaman Kerja
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Tambah data pengalaman kerja untuk {{ $employee->full_name }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6">
                    <form action="{{ route('employees.work-experiences.store', $employee) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Employee Info Card -->
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-600 rounded-lg p-4 mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $employee->full_name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $employee->employee_id }} - {{ $employee->position->name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Company Name -->
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Perusahaan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="company_name" name="company_name" 
                                       value="{{ old('company_name') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: PT. Teknologi Indonesia">
                                @error('company_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Industry -->
                            <div>
                                <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Industri <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="industry" name="industry" 
                                       value="{{ old('industry') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: Teknologi Informasi">
                                @error('industry')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Position -->
                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jabatan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="position" name="position" 
                                       value="{{ old('position') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: Software Developer">
                                @error('position')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Employment Status -->
                            <div>
                                <label for="employment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Status Kepegawaian <span class="text-red-500">*</span>
                                </label>
                                <select id="employment_status" name="employment_status" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                                    <option value="full_time" {{ old('employment_status') == 'full_time' ? 'selected' : '' }}>Penuh Waktu</option>
                                    <option value="part_time" {{ old('employment_status') == 'part_time' ? 'selected' : '' }}>Paruh Waktu</option>
                                    <option value="contract" {{ old('employment_status') == 'contract' ? 'selected' : '' }}>Kontrak</option>
                                    <option value="internship" {{ old('employment_status') == 'internship' ? 'selected' : '' }}>Magang</option>
                                </select>
                                @error('employment_status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Lokasi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="location" name="location" 
                                       value="{{ old('location') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Contoh: Jakarta, Indonesia">
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remote Work -->
                            <div class="flex items-center mt-6">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_remote" 
                                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500" 
                                           {{ old('is_remote') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Kerja Remote</span>
                                </label>
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="month" id="start_date" name="start_date" 
                                       value="{{ old('start_date') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Tanggal Selesai
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="is_current" id="is_current"
                                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500" 
                                               {{ old('is_current') ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Posisi Saat Ini</span>
                                    </label>
                                </div>
                                <input type="month" id="end_date" name="end_date" 
                                       value="{{ old('end_date') }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Salary -->
                            <div class="md:col-span-2">
                                <label for="salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Gaji (Opsional)
                                </label>
                                <div class="flex gap-2">
                                    <select name="salary_currency" 
                                            class="w-24 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                                        <option value="IDR" {{ old('salary_currency') == 'IDR' ? 'selected' : '' }}>IDR</option>
                                        <option value="USD" {{ old('salary_currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                        <option value="SGD" {{ old('salary_currency') == 'SGD' ? 'selected' : '' }}>SGD</option>
                                        <option value="EUR" {{ old('salary_currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                    </select>
                                    <input type="number" id="salary" name="salary" step="0.01" 
                                           value="{{ old('salary') }}"
                                           class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Contoh: 8000000">
                                </div>
                                @error('salary')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Main Responsibilities -->
                        <div>
                            <label for="main_responsibilities" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggung Jawab Utama <span class="text-red-500">*</span>
                            </label>
                            <textarea id="main_responsibilities" name="main_responsibilities" rows="4" required
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                      placeholder="Jelaskan tanggung jawab utama, proyek yang dikerjakan, pencapaian, dll...">{{ old('main_responsibilities') }}</textarea>
                            @error('main_responsibilities')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Leaving Reason -->
                        <div>
                            <label for="leaving_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Alasan Keluar (Opsional)
                            </label>
                            <textarea id="leaving_reason" name="leaving_reason" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                      placeholder="Jelaskan alasan keluar dari perusahaan...">{{ old('leaving_reason') }}</textarea>
                            @error('leaving_reason')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Reference Details -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Detail Referensi (Opsional)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="reference_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Nama Referensi
                                    </label>
                                    <input type="text" id="reference_name" name="reference_name" 
                                           value="{{ old('reference_name') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Contoh: John Doe">
                                    @error('reference_name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="reference_position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Jabatan Referensi
                                    </label>
                                    <input type="text" id="reference_position" name="reference_position" 
                                           value="{{ old('reference_position') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Contoh: Project Manager">
                                    @error('reference_position')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="reference_contact" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Nomor Kontak
                                    </label>
                                    <input type="text" id="reference_contact" name="reference_contact" 
                                           value="{{ old('reference_contact') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Contoh: +62 812 3456 7890">
                                    @error('reference_contact')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="reference_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Email Referensi
                                    </label>
                                    <input type="email" id="reference_email" name="reference_email" 
                                           value="{{ old('reference_email') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Contoh: john.doe@company.com">
                                    @error('reference_email')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
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
                                    class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Pengalaman Kerja
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
            const isCurrentCheckbox = document.querySelector('#is_current');
            const endDateInput = document.querySelector('#end_date');

            function toggleEndDate() {
                endDateInput.disabled = isCurrentCheckbox.checked;
                if (isCurrentCheckbox.checked) {
                    endDateInput.value = '';
                    endDateInput.classList.add('bg-gray-100', 'dark:bg-gray-600');
                } else {
                    endDateInput.classList.remove('bg-gray-100', 'dark:bg-gray-600');
                }
            }

            isCurrentCheckbox.addEventListener('change', toggleEndDate);
            toggleEndDate();
        });
    </script>
    @endpush
</x-app-layout>
