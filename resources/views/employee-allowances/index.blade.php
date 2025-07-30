<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tunjangan Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Daftar Tunjangan Karyawan</h3>
                        <a href="{{ route('employee-allowances.create') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Tunjangan Baru
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($allowances->count() > 0)
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
                                            Jenis Tunjangan
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Jumlah
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Frekuensi
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Periode
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($allowances as $allowance)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $allowance->employee_name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $allowance->nip_nik }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $allowance->work_unit }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $allowance->position }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $allowance->allowance_type_badge_class }}">
                                                    {{ $allowance->allowance_type_name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $allowance->formatted_allowance_amount }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $allowance->payment_frequency_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $allowance->allowance_status_badge_class }}">
                                                    {{ $allowance->allowance_status_name }}
                                                </span>
                                                @if($allowance->is_expired)
                                                    <div class="text-xs text-red-500 mt-1">Expired</div>
                                                @elseif($allowance->remaining_days && $allowance->remaining_days <= 30)
                                                    <div class="text-xs text-yellow-500 mt-1">{{ $allowance->remaining_days }} hari lagi</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $allowance->start_date->format('d/m/Y') }}
                                                </div>
                                                @if($allowance->end_date)
                                                    <div class="text-sm text-gray-500 dark:text-gray-300">
                                                        s/d {{ $allowance->end_date->format('d/m/Y') }}
                                                    </div>
                                                @else
                                                    <div class="text-sm text-gray-500 dark:text-gray-300">
                                                        Tidak terbatas
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('employee-allowances.show', $allowance) }}" 
                                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                        Lihat
                                                    </a>
                                                    <a href="{{ route('employee-allowances.edit', $allowance) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                        Edit
                                                    </a>
                                                    @if($allowance->allowance_status === 'aktif')
                                                        <form action="{{ route('employee-allowances.deactivate', $allowance) }}" 
                                                              method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                                                    onclick="return confirm('Apakah Anda yakin ingin menonaktifkan tunjangan ini?')">
                                                                Nonaktifkan
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('employee-allowances.activate', $allowance) }}" 
                                                              method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                                Aktifkan
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('employee-allowances.destroy', $allowance) }}" 
                                                          method="POST" 
                                                          class="inline"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data tunjangan ini?')">
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
                            {{ $allowances->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500 dark:text-gray-400 text-lg">
                                Belum ada data tunjangan karyawan
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('employee-allowances.create') }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Tambah Tunjangan Pertama
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
