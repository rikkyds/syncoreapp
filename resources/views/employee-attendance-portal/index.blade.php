<x-app-layout>
    <x-slot name="header">
        <div class="hidden">Portal Karyawan</div>
    </x-slot>
    
    <style>
        /* Hide default navbar and header */
        nav, header {
            display: none !important;
        }
        
        /* Remove top padding that's usually reserved for navbar and header */
        main {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }
        
        /* Remove any margins from the main container */
        .py-12 {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }
        
        /* Make sure the content takes full width on mobile */
        .max-w-7xl {
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    </style>

    @if(isset($isAdminView) && $isAdminView)
    <div class="max-w-md mx-auto px-4 mt-4">
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Mode Admin:</strong> Anda sedang melihat portal absensi dalam mode demo. Data yang ditampilkan adalah data karyawan pertama dalam database. Fitur absensi tidak akan berfungsi dalam mode ini.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Include Flexible Header Component -->
    <div class="-mt-6 mb-8">
        @include('employee-attendance-portal.partials.header', ['employee' => $employee])
    </div>

    <div class="pb-20"> <!-- Added bottom padding for mobile nav -->
        <div class="max-w-md mx-auto px-4">
            <!-- Main Content - Mobile App Style -->
            <div class="space-y-6">
                <!-- Attendance Status Summary Card - Enhanced Design -->
                <div class="bg-gradient-to-br from-white to-blue-50 rounded-xl shadow-lg p-6 mt-4 relative z-20 border border-blue-100" style="background: linear-gradient(to bottom right, #ffffff, #f0f9ff);">
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-500 font-medium">Regular</span>
                        </div>
                        <div id="attendance-status-badge" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Belum Absen
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ date('l, d F Y') }}</p>
                            <p class="font-medium text-gray-800">{{ $todayShift ? $todayShift->start_time . ' - ' . $todayShift->end_time : '08:00 - 17:00' }} WIB</p>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800" id="current-time">--:--</h2>
                            <p class="text-xs text-right text-gray-500" id="current-date">--</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <div class="flex justify-between items-center text-sm">
                            <div class="flex flex-col items-center">
                                <div class="flex items-center mb-1">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                    <span class="text-gray-800 font-medium">{{ $statistics['present_days'] }}</span>
                                </div>
                                <span class="text-xs text-gray-500">Hadir</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="flex items-center mb-1">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                    <span class="text-gray-800 font-medium">1</span>
                                </div>
                                <span class="text-xs text-gray-500">Telat</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="flex items-center mb-1">
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                    <span class="text-gray-800 font-medium">0</span>
                                </div>
                                <span class="text-xs text-gray-500">Cuti</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Grid - Enhanced with Modern Design -->
                <div class="bg-white rounded-xl shadow-md p-5 relative overflow-hidden">
                    <!-- Decorative element -->
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-50 rounded-tr-full opacity-30"></div>
                    
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <h3 class="text-lg font-bold text-gray-800">Menu Utama</h3>
                        <a href="#" class="text-xs text-blue-500 flex items-center">
                            Lihat Semua
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 relative z-10">
                        <a href="#" class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-100 group hover:shadow-md transition-all duration-200">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center mr-3 shadow-sm" style="background: linear-gradient(to bottom right, #dbeafe, #bfdbfe);">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Absensi</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-100 group hover:shadow-md transition-all duration-200">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center mr-3 shadow-sm" style="background: linear-gradient(to bottom right, #dcfce7, #bbf7d0);">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Cuti</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-100 group hover:shadow-md transition-all duration-200">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg flex items-center justify-center mr-3 shadow-sm" style="background: linear-gradient(to bottom right, #f3e8ff, #e9d5ff);">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Laporan</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-white rounded-lg shadow-sm border border-gray-100 group hover:shadow-md transition-all duration-200">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-lg flex items-center justify-center mr-3 shadow-sm" style="background: linear-gradient(to bottom right, #fef9c3, #fde68a);">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Pengaturan</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Stats - Enhanced Cards -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl shadow-sm relative overflow-hidden" style="background: linear-gradient(to bottom right, #eff6ff, #dbeafe);">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-blue-200 rounded-bl-full opacity-30"></div>
                        <div class="flex items-center mb-2 relative z-10">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-200 text-blue-600 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <p class="text-sm font-medium text-blue-600">Hadir Bulan Ini</p>
                        </div>
                        <p class="text-3xl font-bold text-blue-800 ml-10">{{ $statistics['present_days'] }}</p>
                        <p class="text-xs text-blue-500 mt-1 ml-10">dari {{ date('t') }} hari</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl shadow-sm relative overflow-hidden" style="background: linear-gradient(to bottom right, #ecfdf5, #d1fae5);">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-green-200 rounded-bl-full opacity-30"></div>
                        <div class="flex items-center mb-2 relative z-10">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-200 text-green-600 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <p class="text-sm font-medium text-green-600">Jam Kerja</p>
                        </div>
                        <p class="text-3xl font-bold text-green-800 ml-10">{{ number_format($statistics['total_work_hours'], 1) }}</p>
                        <p class="text-xs text-green-500 mt-1 ml-10">jam bulan ini</p>
                    </div>
                </div>
                
                <!-- Note about History -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-4 text-center">
                        <p class="text-sm text-gray-500">Lihat riwayat absensi lengkap di menu <span class="font-medium text-blue-600">History</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Time In Modal -->
    <div id="time-in-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Absen Masuk</h3>
                <form id="time-in-form">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Metode Absensi</label>
                        <select id="time-in-method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @foreach($attendanceMethods as $key => $method)
                                <option value="{{ $key }}">{{ $method }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Lokasi Kerja</label>
                        <select id="time-in-location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @foreach($workLocations as $key => $location)
                                <option value="{{ $key }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="selfie-container" class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Selfie</label>
                        <div class="mt-1 flex flex-col items-center">
                            <div id="camera-container" class="w-full h-48 bg-gray-100 flex items-center justify-center rounded-lg overflow-hidden mb-2">
                                <video id="camera-preview" class="w-full h-full object-cover hidden"></video>
                                <div id="camera-placeholder" class="text-gray-400 flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Kamera tidak tersedia</span>
                                </div>
                                <canvas id="selfie-canvas" class="hidden"></canvas>
                                <img id="selfie-preview" class="w-full h-full object-cover hidden" />
                            </div>
                            <div class="flex space-x-2">
                                <button type="button" id="start-camera-btn" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Buka Kamera
                                </button>
                                <button type="button" id="take-selfie-btn" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                                    </svg>
                                    Ambil Foto
                                </button>
                                <button type="button" id="retake-selfie-btn" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Ambil Ulang
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea id="time-in-notes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="2"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="time-in-cancel" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </button>
                        <button type="submit" id="time-in-submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Absen Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Time Out Modal -->
    <div id="time-out-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Absen Pulang</h3>
                <form id="time-out-form">
                    <div id="selfie-out-container" class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Selfie</label>
                        <div class="mt-1 flex flex-col items-center">
                            <div id="camera-out-container" class="w-full h-48 bg-gray-100 flex items-center justify-center rounded-lg overflow-hidden mb-2">
                                <video id="camera-out-preview" class="w-full h-full object-cover hidden"></video>
                                <div id="camera-out-placeholder" class="text-gray-400 flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Kamera tidak tersedia</span>
                                </div>
                                <canvas id="selfie-out-canvas" class="hidden"></canvas>
                                <img id="selfie-out-preview" class="w-full h-full object-cover hidden" />
                            </div>
                            <div class="flex space-x-2">
                                <button type="button" id="start-camera-out-btn" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Buka Kamera
                                </button>
                                <button type="button" id="take-selfie-out-btn" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                                    </svg>
                                    Ambil Foto
                                </button>
                                <button type="button" id="retake-selfie-out-btn" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Ambil Ulang
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                        <textarea id="time-out-notes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="2"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="time-out-cancel" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </button>
                        <button type="submit" id="time-out-submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Absen Pulang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation - Enhanced Modern Design -->
    <div class="bg-white border-t border-gray-200 rounded-xl shadow-lg mt-6 mb-10 overflow-hidden">
        <div class="flex justify-around items-center h-20 relative py-2">
            <!-- Home -->
            <a href="{{ route('attendance-portal.index') }}" class="flex flex-col items-center justify-center w-full h-full text-blue-600 relative group">
                <div class="absolute inset-x-0 top-0 h-1 bg-blue-600 rounded-b-lg"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs mt-1 font-medium">Home</span>
            </a>
            
            <!-- History -->
            <a href="#" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-blue-500 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs mt-1 font-medium">History</span>
            </a>
            
            <!-- Scan Button (Middle) - For Attendance -->
            <div class="flex flex-col items-center justify-center w-full relative">
                <button id="scan-attendance-btn" class="flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg border-4 border-white mb-1 transform hover:scale-105 transition-transform duration-200" style="background: linear-gradient(to right, #3b82f6, #4f46e5);" {{ isset($isAdminView) && $isAdminView ? 'disabled' : '' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                    </svg>
                </button>
                <span class="text-xs font-medium text-gray-500">Absensi</span>
            </div>
            
            <!-- Project -->
            <a href="#" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-blue-500 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="text-xs mt-1 font-medium">Project</span>
            </a>
            
            <!-- Task Harian -->
            <a href="#" class="flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-blue-500 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <span class="text-xs mt-1 font-medium">Task</span>
            </a>
        </div>
    </div>

    <!-- Include JavaScript -->
    <script src="{{ asset('js/attendance-portal.js') }}"></script>
</x-app-layout>
