<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Detail Karyawan
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Informasi lengkap profil karyawan {{ $employee->full_name }}
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('employees.edit', $employee) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors duration-200"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Profile Header Card -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center space-x-6">
                    <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center">
                        @if($employee->profile_photo)
                            <img src="{{ asset('storage/' . $employee->profile_photo) }}" alt="Foto {{ $employee->full_name }}" 
                                 class="w-20 h-20 rounded-full object-cover">
                        @else
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold">{{ $employee->full_name }}</h1>
                        <p class="text-blue-100 text-lg">{{ $employee->position->name }}</p>
                        <div class="flex items-center space-x-4 mt-2">
                            <span class="bg-white/20 px-3 py-1 rounded-full text-sm">
                                {{ $employee->employee_id }}
                            </span>
                            <span class="bg-white/20 px-3 py-1 rounded-full text-sm">
                                {{ $employee->workUnit->name }}
                            </span>
                            <span class="bg-white/20 px-3 py-1 rounded-full text-sm">
                                @switch($employee->employment_status)
                                    @case('permanent') Tetap @break
                                    @case('contract') Kontrak @break
                                    @case('probation') Masa Percobaan @break
                                    @case('intern') Magang @break
                                    @default {{ ucfirst($employee->employment_status) }}
                                @endswitch
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-blue-100 text-sm">Bergabung sejak</p>
                        <p class="text-xl font-semibold">{{ $employee->join_date->format('d M Y') }}</p>
                        <p class="text-blue-100 text-sm">{{ $employee->join_date->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <button onclick="showTab('personal')" id="tab-personal" 
                                class="tab-button border-b-2 border-blue-500 text-blue-600 dark:text-blue-400 py-4 px-1 text-sm font-medium">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informasi Pribadi
                            </div>
                        </button>
                        <button onclick="showTab('education')" id="tab-education" 
                                class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Pendidikan
                            </div>
                        </button>
                        <button onclick="showTab('skills')" id="tab-skills" 
                                class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                Keahlian
                            </div>
                        </button>
                        <button onclick="showTab('experience')" id="tab-experience" 
                                class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                </svg>
                                Pengalaman Kerja
                            </div>
                        </button>
                        <button onclick="showTab('family')" id="tab-family" 
                                class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Keluarga
                            </div>
                        </button>
                        <button onclick="showTab('shifts')" id="tab-shifts" 
                                class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Shift Kerja
                            </div>
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    
                    <!-- Personal Information Tab -->
                    <div id="content-personal" class="tab-content">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            
                            <!-- Personal Information -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data Pribadi</h3>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">NIK</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->nik }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tempat, Tanggal Lahir</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->birth_place }}, {{ $employee->birth_date->format('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pernikahan</label>
                                        <p class="text-gray-900 dark:text-white">
                                            @switch($employee->marital_status)
                                                @case('single') Belum Menikah @break
                                                @case('married') Menikah @break
                                                @case('divorced') Cerai @break
                                                @case('widowed') Janda/Duda @break
                                                @default {{ ucfirst($employee->marital_status) }}
                                            @endswitch
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->address }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Telepon</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->phone_number }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Pribadi</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->personal_email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Company Information -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data Perusahaan</h3>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">ID Karyawan (NIP)</label>
                                        <p class="text-gray-900 dark:text-white font-mono">{{ $employee->employee_id }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Perusahaan</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->company->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Kantor Cabang</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->branchOffice->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Unit Kerja</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->workUnit->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Jabatan</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->position->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Kepegawaian</label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @switch($employee->employment_status)
                                                @case('permanent') bg-green-100 text-green-800 @break
                                                @case('contract') bg-blue-100 text-blue-800 @break
                                                @case('probation') bg-yellow-100 text-yellow-800 @break
                                                @case('intern') bg-purple-100 text-purple-800 @break
                                                @default bg-gray-100 text-gray-800
                                            @endswitch">
                                            @switch($employee->employment_status)
                                                @case('permanent') Tetap @break
                                                @case('contract') Kontrak @break
                                                @case('probation') Masa Percobaan @break
                                                @case('intern') Magang @break
                                                @default {{ ucfirst($employee->employment_status) }}
                                            @endswitch
                                        </span>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Bergabung</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->join_date->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Information -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data Keuangan</h3>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">BPJS Kesehatan</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->bpjs_health ?? 'Belum terdaftar' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">BPJS Ketenagakerjaan</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->bpjs_employment ?? 'Belum terdaftar' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Rekening Bank</label>
                                        <p class="text-gray-900 dark:text-white">
                                            @if($employee->bank_name && $employee->bank_account)
                                                {{ $employee->bank_name }} - {{ $employee->bank_account }}
                                            @else
                                                Belum terdaftar
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">NPWP</label>
                                        <p class="text-gray-900 dark:text-white">{{ $employee->npwp ?? 'Belum terdaftar' }}</p>
                                    </div>
                                </div>

                                <!-- Document Photos -->
                                @if($employee->bpjs_health_photo || $employee->npwp_photo)
                                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-600">
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3 block">Dokumen</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        @if($employee->bpjs_health_photo)
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Kartu BPJS Kesehatan</p>
                                                <img src="{{ asset('storage/' . $employee->bpjs_health_photo) }}" alt="BPJS Kesehatan" 
                                                     class="w-full h-20 object-cover rounded-lg border">
                                            </div>
                                        @endif
                                        @if($employee->npwp_photo)
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Kartu NPWP</p>
                                                <img src="{{ asset('storage/' . $employee->npwp_photo) }}" alt="NPWP" 
                                                     class="w-full h-20 object-cover rounded-lg border">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Education Tab -->
                    <div id="content-education" class="tab-content hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Pendidikan</h3>
                            <a href="{{ route('employees.education.create', $employee) }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Pendidikan
                            </a>
                        </div>

                        @forelse($employee->educations as $education)
                            <div class="mb-4 p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $education->educationLevel->name }}</h4>
                                        <p class="text-indigo-600 dark:text-indigo-400 font-medium">{{ $education->institution_name }}</p>
                                        @if($education->major)
                                            <p class="text-gray-600 dark:text-gray-400">{{ $education->major }}</p>
                                        @endif
                                        <div class="flex items-center space-x-4 mt-2">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                📍 {{ $education->city }}, {{ $education->country }}
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                📅 {{ $education->start_year }} - {{ $education->end_year ?? 'Sekarang' }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if($education->status == 'graduated') bg-green-100 text-green-800
                                                @elseif($education->status == 'ongoing') bg-blue-100 text-blue-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                @switch($education->status)
                                                    @case('graduated') Lulus @break
                                                    @case('not_graduated') Tidak Lulus @break
                                                    @case('ongoing') Sedang Berjalan @break
                                                    @default {{ ucfirst($education->status) }}
                                                @endswitch
                                            </span>
                                        </div>
                                        @if($education->gpa)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">IPK: {{ $education->gpa }}</p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2 ml-4">
                                        <button class="text-yellow-600 hover:text-yellow-800 p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800 p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">Belum ada data pendidikan</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Skills Tab -->
                    <div id="content-skills" class="tab-content hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Keahlian & Keterampilan</h3>
                            <a href="{{ route('employees.skills.create', $employee) }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Keahlian
                            </a>
                        </div>

                        @forelse($employee->skills as $skill)
                            <div class="mb-4 p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $skill->name }}</h4>
                                        <p class="text-gray-600 dark:text-gray-400">{{ $skill->category->name }}</p>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                Level: 
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                    @switch($skill->pivot->proficiency_level)
                                                        @case('beginner') bg-red-100 text-red-800 @break
                                                        @case('intermediate') bg-yellow-100 text-yellow-800 @break
                                                        @case('advanced') bg-green-100 text-green-800 @break
                                                        @case('expert') bg-blue-100 text-blue-800 @break
                                                        @default bg-gray-100 text-gray-800
                                                    @endswitch">
                                                    @switch($skill->pivot->proficiency_level)
                                                        @case('beginner') Pemula @break
                                                        @case('intermediate') Menengah @break
                                                        @case('advanced') Mahir @break
                                                        @case('expert') Ahli @break
                                                        @default {{ ucfirst($skill->pivot->proficiency_level) }}
                                                    @endswitch
                                                </span>
                                            </span>
                                            @if($skill->pivot->certificate)
                                                <span class="text-sm text-green-600 dark:text-green-400">📜 Bersertifikat</span>
                                            @endif
                                        </div>
                                        @if($skill->pivot->notes)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $skill->pivot->notes }}</p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2 ml-4">
                                        <button class="text-yellow-600 hover:text-yellow-800 p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800 p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">Belum ada data keahlian</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Work Experience Tab -->
                    <div id="content-experience" class="tab-content hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pengalaman Kerja</h3>
                            <a href="{{ route('employees.work-experiences.create', $employee) }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Pengalaman
                            </a>
                        </div>

                        @forelse($employee->workExperiences as $experience)
                            <div class="mb-4 p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $experience->position }}</h4>
                                            @if($experience->is_current)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Saat Ini
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-indigo-600 dark:text-indigo-400 font-medium">{{ $experience->company_name }}</p>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                📍 {{ $experience->location }}
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                📅 {{ $experience->start_date->format('M Y') }} - {{ $experience->end_date ? $experience->end_date->format('M Y') : 'Sekarang' }}
                                            </span>
                                        </div>
                                        @if($experience->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $experience->description }}</p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2 ml-4">
                                        <button class="text-yellow-600 hover:text-yellow-800 p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800 p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">Belum ada data pengalaman kerja</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Family Tab -->
                    <div id="content-family" class="tab-content hidden">
                    
                    <!-- Shifts Tab -->
                    <div id="content-shifts" class="tab-content hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Jadwal Shift Kerja</h3>
                            <a href="{{ route('employee-shifts.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Shift Baru
                            </a>
                        </div>

                        @php
                            $shifts = $employee->shifts()->orderBy('shift_date', 'desc')->take(10)->get();
                        @endphp

                        @if($shifts->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Tanggal
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Shift
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Jam Kerja
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Durasi
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($shifts as $shift)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $shift->shift_date->format('d/m/Y') }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $shift->shift_date->format('l') }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $shift->shift_name }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 dark:text-white">
                                                        {{ $shift->formatted_start_time }} - {{ $shift->formatted_end_time }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 dark:text-white">
                                                        {{ $shift->formatted_shift_duration }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $shift->attendance_status_badge_class }}">
                                                        {{ $shift->attendance_status_name }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('employee-shifts.show', $shift) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                                                        Lihat
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('employee-shifts.index') }}?employee_id={{ $employee->id }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium">
                                    Lihat Semua Shift →
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">Belum ada data shift kerja</p>
                                <div class="mt-4">
                                    <a href="{{ route('employee-shifts.create') }}?employee_id={{ $employee->id }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Tambah Shift Pertama
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data Keluarga</h3>
                            <a href="{{ route('employees.family-members.create', $employee) }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Anggota Keluarga
                            </a>
                        </div>

                        @forelse($employee->familyMembers as $family)
                            <div class="mb-4 p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $family->name }}</h4>
                                            @if($family->is_emergency_contact)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Kontak Darurat
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            @switch($family->relationship)
                                                @case('spouse') Pasangan @break
                                                @case('child') Anak @break
                                                @case('parent') Orang Tua @break
                                                @case('sibling') Saudara @break
                                                @default {{ ucfirst($family->relationship) }}
                                            @endswitch
                                        </p>
                                        <div class="flex items-center space-x-4 mt-2">
                                            @if($family->birth_date)
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    🎂 {{ $family->birth_date->format('d F Y') }}
                                                </span>
                                            @endif
                                            @if($family->phone_number)
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    📞 {{ $family->phone_number }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($family->address)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">📍 {{ $family->address }}</p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2 ml-4">
                                        <button class="text-yellow-600 hover:text-yellow-800 p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800 p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">Belum ada data keluarga</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="flex justify-between items-center">
                <a href="{{ route('employees.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Karyawan
                </a>
                
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Terakhir diperbarui: {{ $employee->updated_at->format('d F Y, H:i') }}
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Tab Functionality -->
    <script>
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active state from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('border-blue-500', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });

            // Show selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');

            // Add active state to selected tab button
            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            activeButton.classList.add('border-blue-500', 'text-blue-600');
        }

        // Initialize first tab as active
        document.addEventListener('DOMContentLoaded', function() {
            showTab('personal');
        });
    </script>
</x-app-layout>
