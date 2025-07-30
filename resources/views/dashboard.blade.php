<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Dashboard
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Selamat datang, {{ $user->name }}! Berikut adalah ringkasan sistem hari ini.
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('l, d F Y') }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">{{ now()->format('H:i') }} WIB</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Quick Actions -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-lg font-semibold mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('employees.quick-create') }}" class="bg-white/20 hover:bg-white/30 rounded-lg p-4 text-center transition-all duration-200 hover:scale-105">
                        <div class="text-2xl mb-2">👤</div>
                        <div class="text-sm font-medium">Tambah Karyawan</div>
                    </a>
                    <a href="{{ route('projects.create') }}" class="bg-white/20 hover:bg-white/30 rounded-lg p-4 text-center transition-all duration-200 hover:scale-105">
                        <div class="text-2xl mb-2">📋</div>
                        <div class="text-sm font-medium">Buat Proyek</div>
                    </a>
                    <a href="{{ route('employee-leaves.create') }}" class="bg-white/20 hover:bg-white/30 rounded-lg p-4 text-center transition-all duration-200 hover:scale-105">
                        <div class="text-2xl mb-2">📅</div>
                        <div class="text-sm font-medium">Ajukan Cuti</div>
                    </a>
                    <a href="{{ route('support-requests.create') }}" class="bg-white/20 hover:bg-white/30 rounded-lg p-4 text-center transition-all duration-200 hover:scale-105">
                        <div class="text-2xl mb-2">🎫</div>
                        <div class="text-sm font-medium">Support Request</div>
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Employees -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Karyawan</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_employees'] }}</p>
                            <p class="text-xs text-green-600 mt-1">
                                +{{ $stats['new_employees_this_month'] }} bulan ini
                            </p>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Projects -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Proyek Aktif</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['active_projects'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $stats['completed_projects'] }} selesai
                            </p>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Leaves -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Cuti Pending</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_leaves'] }}</p>
                            <p class="text-xs text-blue-600 mt-1">
                                {{ $stats['approved_leaves_today'] }} cuti hari ini
                            </p>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Attendance Today -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Absensi Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['attendance_today'] }}</p>
                            <p class="text-xs text-red-600 mt-1">
                                {{ $stats['late_attendance_today'] }} terlambat
                            </p>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Recent Activities -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Employee Status Chart -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status Karyawan</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Permanent</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-900 dark:text-white mr-2">{{ $stats['permanent_employees'] }}</span>
                                <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $stats['total_employees'] > 0 ? ($stats['permanent_employees'] / $stats['total_employees']) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Probation</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-900 dark:text-white mr-2">{{ $stats['employees_on_probation'] }}</span>
                                <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $stats['total_employees'] > 0 ? ($stats['employees_on_probation'] / $stats['total_employees']) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Organization Overview -->
                    <div class="mt-8">
                        <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Struktur Organisasi</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['total_companies'] }}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Perusahaan</div>
                            </div>
                            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['total_branches'] }}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Cabang</div>
                            </div>
                            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['total_work_units'] }}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Unit Kerja</div>
                            </div>
                            <div class="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['total_positions'] }}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Jabatan</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aktivitas Terbaru</h3>
                    
                    <!-- Recent Employees -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Karyawan Baru</h4>
                        <div class="space-y-3">
                            @forelse($stats['recent_employees'] as $employee)
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400">
                                        {{ substr($employee->full_name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $employee->full_name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $employee->position->name ?? 'Staff' }} • {{ $employee->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada karyawan baru</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Projects -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Proyek Terbaru</h4>
                        <div class="space-y-3">
                            @forelse($stats['recent_projects'] as $project)
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $project->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ ucfirst($project->status) }} • {{ $project->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada proyek</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support Requests Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Support Requests</h3>
                    <a href="{{ route('support-requests.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Lihat Semua
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['pending_support_requests'] }}</p>
                                <p class="text-sm text-yellow-700 dark:text-yellow-300">Pending</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['approved_support_requests'] }}</p>
                                <p class="text-sm text-green-700 dark:text-green-300">Approved</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['pending_support_requests'] + $stats['approved_support_requests'] }}</p>
                                <p class="text-sm text-blue-700 dark:text-blue-300">Total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
