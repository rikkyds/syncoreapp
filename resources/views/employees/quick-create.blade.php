<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Karyawan Cepat
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Header Section -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Tambah Karyawan Baru (Data Minimal)
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Isi data minimal untuk membuat karyawan baru. Data lengkap dapat diperbarui nanti.
                        </p>
                    </div>

                    <!-- Info Alert -->
                    <div class="mb-6 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                    Informasi Penting
                                </h3>
                                <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Sistem akan otomatis membuat akun login untuk karyawan</li>
                                        <li>Email yang dimasukkan akan digunakan sebagai username login</li>
                                        <li>Password default: <strong>syncore123</strong></li>
                                        <li>Role default: <strong>Karyawan</strong></li>
                                        <li>Data lengkap (NIK, alamat, dll) dapat diperbarui nanti melalui menu edit</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('employees.quick-store') }}" class="space-y-6">
                        @csrf

                        <!-- Basic Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">
                                Data Dasar Karyawan
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Full Name -->
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="full_name" 
                                           id="full_name" 
                                           value="{{ old('full_name') }}"
                                           required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                           placeholder="Masukkan nama lengkap karyawan">
                                    @error('full_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone Number -->
                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Nomor Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="phone_number" 
                                           id="phone_number" 
                                           value="{{ old('phone_number') }}"
                                           required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                           placeholder="Contoh: 08123456789">
                                    @error('phone_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="md:col-span-2">
                                    <label for="personal_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Email (untuk Login) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           name="personal_email" 
                                           id="personal_email" 
                                           value="{{ old('personal_email') }}"
                                           required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                           placeholder="contoh@email.com">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Email ini akan digunakan sebagai username untuk login ke sistem
                                    </p>
                                    @error('personal_email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Auto-Generated Info -->
                        <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg">
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">
                                Data yang Akan Dibuat Otomatis
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Employee ID:</span>
                                    <span class="text-gray-600 dark:text-gray-400">Auto-generate (EMP0001, EMP0002, dst.)</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Password Login:</span>
                                    <span class="text-gray-600 dark:text-gray-400">syncore123</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Role:</span>
                                    <span class="text-gray-600 dark:text-gray-400">Karyawan</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Status:</span>
                                    <span class="text-gray-600 dark:text-gray-400">Probation</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Tanggal Bergabung:</span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ date('d/m/Y') }} (hari ini)</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">NIK:</span>
                                    <span class="text-gray-600 dark:text-gray-400">Temporary (dapat diperbarui nanti)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-600">
                            <a href="{{ route('employees.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Batal
                            </a>

                            <div class="flex space-x-3">
                                <a href="{{ route('employees.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-blue-300 rounded-md shadow-sm text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Form Lengkap
                                </a>

                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Buat Karyawan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
