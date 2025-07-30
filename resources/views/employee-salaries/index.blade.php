<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Gaji Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Daftar Data Gaji Karyawan</h3>
                        <a href="{{ route('employee-salaries.create') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Data Gaji Baru
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($salaries->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nama Karyawan
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Unit Kerja
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Jabatan
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Periode Gaji
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Gaji Pokok
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Total Bersih
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status Bayar
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($salaries as $salary)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $salary->employee_name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $salary->nip_nik }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $salary->work_unit }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $salary->position }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $salary->employee_status_badge_class }}">
                                                    {{ $salary->employee_status_name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $salary->salary_period }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $salary->salary_date->format('d/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $salary->formatted_basic_salary }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-green-600">
                                                    {{ $salary->formatted_net_salary }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-300">
                                                    Kotor: {{ $salary->formatted_gross_salary }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $salary->payment_status_badge_class }}">
                                                    {{ $salary->payment_status_name }}
                                                </span>
                                                @if($salary->is_overdue)
                                                    <div class="text-xs text-red-500 mt-1">
                                                        Terlambat {{ $salary->days_overdue }} hari
                                                    </div>
                                                @endif
                                                @if($salary->payment_date)
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ $salary->payment_date->format('d/m/Y') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('employee-salaries.show', $salary) }}" 
                                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                        Lihat
                                                    </a>
                                                    <a href="{{ route('employee-salaries.edit', $salary) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                        Edit
                                                    </a>
                                                    
                                                    @if($salary->payment_status === 'belum_dibayar')
                                                        <form action="{{ route('employee-salaries.mark-paid', $salary) }}" 
                                                              method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                                                    onclick="return confirm('Tandai gaji ini sebagai sudah dibayar?')">
                                                                Bayar
                                                            </button>
                                                        </form>
                                                    @elseif($salary->payment_status === 'sudah_dibayar')
                                                        <form action="{{ route('employee-salaries.mark-unpaid', $salary) }}" 
                                                              method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                                                    onclick="return confirm('Ubah status menjadi belum dibayar?')">
                                                                Batal Bayar
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <form action="{{ route('employee-salaries.duplicate', $salary) }}" 
                                                          method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300"
                                                                onclick="return confirm('Duplikasi gaji untuk bulan berikutnya?')">
                                                            Duplikasi
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('employee-salaries.destroy', $salary) }}" 
                                                          method="POST" 
                                                          class="inline"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data gaji ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $salaries->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500 dark:text-gray-400 text-lg">
                                Belum ada data gaji karyawan
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('employee-salaries.create') }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Tambah Data Gaji Pertama
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
