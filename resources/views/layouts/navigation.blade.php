<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @if(auth()->user()->role && auth()->user()->role->name !== 'admin')
                        <x-nav-link :href="route('employees.index')" :active="request()->routeIs('employees.*')">
                            Karyawan
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->role && auth()->user()->role->name === 'admin')
                        <!-- Settings Group -->
                        <x-nav-dropdown :active="request()->routeIs(['users.*', 'roles.*', 'companies.*', 'branch-offices.*', 'work-units.*'])">
                            <x-slot name="trigger">
                                Pengaturan
                            </x-slot>
                            <x-slot name="content">
                                <x-nav-dropdown-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                                    Manajemen Pengguna
                                </x-nav-dropdown-link>
                                <x-nav-dropdown-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                                    Manajemen Role
                                </x-nav-dropdown-link>
                                <x-nav-dropdown-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                                    Perusahaan
                                </x-nav-dropdown-link>
                                <x-nav-dropdown-link :href="route('branch-offices.index')" :active="request()->routeIs('branch-offices.*')">
                                    Kantor Cabang
                                </x-nav-dropdown-link>
                                <x-nav-dropdown-link :href="route('work-units.index')" :active="request()->routeIs('work-units.*')">
                                    Unit Kerja
                                </x-nav-dropdown-link>
                            </x-slot>
                        </x-nav-dropdown>

                        <!-- Employee Group -->
                        <x-nav-dropdown :active="request()->routeIs(['employees.*', 'positions.*'])">
                            <x-slot name="trigger">
                                Karyawan
                            </x-slot>
                            <x-slot name="content">
                                <x-nav-dropdown-link :href="route('employees.index')" :active="request()->routeIs('employees.*')">
                                    Daftar Karyawan
                                </x-nav-dropdown-link>
                                <x-nav-dropdown-link :href="route('positions.index')" :active="request()->routeIs('positions.*')">
                                    Jabatan
                                </x-nav-dropdown-link>
                                <x-nav-dropdown-link :href="route('employee-leaves.index')" :active="request()->routeIs('employee-leaves.*')">
                                    Cuti Karyawan
                                </x-nav-dropdown-link>
                                <x-nav-dropdown-link :href="route('employee-shifts.index')" :active="request()->routeIs('employee-shifts.*')">
                                    Jadwal Shift
                                </x-nav-dropdown-link>
                                <x-nav-dropdown-link :href="route('employee-allowances.index')" :active="request()->routeIs('employee-allowances.*')">
                                    Tunjangan Karyawan
                                </x-nav-dropdown-link>
                                <x-nav-dropdown-link :href="route('employee-salaries.index')" :active="request()->routeIs('employee-salaries.*')">
                                    Gaji Karyawan
                                </x-nav-dropdown-link>
                                <x-nav-dropdown-link :href="route('employee-documents.index')" :active="request()->routeIs('employee-documents.*')">
                                    Dokumen Karyawan
                                </x-nav-dropdown-link>
                                <x-nav-dropdown-link :href="route('employee-attendances.index')" :active="request()->routeIs('employee-attendances.*')">
                                    Absensi Karyawan
                                </x-nav-dropdown-link>
                            </x-slot>
                        </x-nav-dropdown>

                        <!-- Project Group -->
                        <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')">
                            Proyek
                        </x-nav-link>

                        <!-- Support Requests Group -->
                        <x-nav-dropdown :active="request()->routeIs(['support-requests.*', 'projects.sikoja'])">
                            <x-slot name="trigger">
                                Formulir
                            </x-slot>
                            <x-slot name="content">
                                <x-nav-dropdown-link :href="route('support-requests.index')" :active="request()->routeIs('support-requests.*')">
                                    Formulir Pengajuan
                                </x-nav-dropdown-link>
                                <x-nav-dropdown-link :href="route('sikojas.index')" :active="request()->routeIs('sikojas.*')">
                                    Formulir SIKOJA
                                </x-nav-dropdown-link>
                            </x-slot>
                        </x-nav-dropdown>
                    @endif

                    @if(auth()->user()->role && auth()->user()->role->name === 'hrd')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('hrd.*')">
                            Dashboard HRD
                        </x-nav-link>
                        <x-nav-link :href="route('employees.index')" :active="request()->routeIs('employees.*')">
                            Manajemen Karyawan
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->role && auth()->user()->role->name === 'kepala_unit')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('unit.*')">
                            Dashboard Unit
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('reports.*')">
                            Laporan Unit
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->role && auth()->user()->role->name === 'keuangan')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('finance.*')">
                            Dashboard Keuangan
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('transactions.*')">
                            Transaksi Keuangan
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->role && auth()->user()->role->name === 'karyawan')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('attendance.*')">
                            Absensi
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('leaves.*')">
                            Pengajuan Cuti
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profil
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-responsive-nav-link>
                    
                    <!-- Employee Management -->
                    <x-responsive-nav-link :href="route('employees.index')" :active="request()->routeIs('employees.*')">
                        Karyawan
                    </x-responsive-nav-link>
                    
                    @if(auth()->user()->role && auth()->user()->role->name === 'admin')
                <!-- Settings Group -->
                <div class="pt-2 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">Pengaturan</div>
                    </div>
                    <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                        Manajemen Pengguna
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                        Manajemen Role
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                        Perusahaan
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('branch-offices.index')" :active="request()->routeIs('branch-offices.*')">
                        Kantor Cabang
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('work-units.index')" :active="request()->routeIs('work-units.*')">
                        Unit Kerja
                    </x-responsive-nav-link>
                </div>

                <!-- Employee Group -->
                <div class="pt-2 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">Karyawan</div>
                    </div>
                    <x-responsive-nav-link :href="route('employees.index')" :active="request()->routeIs('employees.*')">
                        Daftar Karyawan
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('positions.index')" :active="request()->routeIs('positions.*')">
                        Jabatan
                    </x-responsive-nav-link>
                </div>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Keluar
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
