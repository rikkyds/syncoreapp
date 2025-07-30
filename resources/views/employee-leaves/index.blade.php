<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cuti Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Daftar Cuti Karyawan</h3>
                        <a href="{{ route('employee-leaves.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Cuti Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Nama Karyawan</th>
                                    <th class="px-4 py-2">NIP/NIK</th>
                                    <th class="px-4 py-2">Jenis Cuti</th>
                                    <th class="px-4 py-2">Tanggal Mulai</th>
                                    <th class="px-4 py-2">Tanggal Berakhir</th>
                                    <th class="px-4 py-2">Durasi</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leaves as $leave)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $leave->full_name }}</td>
                                        <td class="border px-4 py-2">{{ $leave->nip_nik }}</td>
                                        <td class="border px-4 py-2">{{ $leave->leave_type_name }}</td>
                                        <td class="border px-4 py-2">{{ $leave->start_date->format('d/m/Y') }}</td>
                                        <td class="border px-4 py-2">{{ $leave->end_date->format('d/m/Y') }}</td>
                                        <td class="border px-4 py-2">{{ $leave->duration_days }} hari</td>
                                        <td class="border px-4 py-2">
                                            <span class="px-2 py-1 text-xs rounded-full {{ $leave->status_badge_class }}">
                                                {{ $leave->status_name }}
                                            </span>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('employee-leaves.show', $leave) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                                <a href="{{ route('employee-leaves.edit', $leave) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                
                                                @if($leave->status === 'pending')
                                                    <form action="{{ route('employee-leaves.approve', $leave) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Setujui cuti ini?')">Setujui</button>
                                                    </form>
                                                    <form action="{{ route('employee-leaves.reject', $leave) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tolak cuti ini?')">Tolak</button>
                                                    </form>
                                                @endif
                                                
                                                <form action="{{ route('employee-leaves.destroy', $leave) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="border px-4 py-2 text-center text-gray-500">
                                            Belum ada data cuti karyawan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $leaves->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
