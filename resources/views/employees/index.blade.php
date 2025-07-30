<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Karyawan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Daftar Karyawan</h3>
                        <a href="{{ route('employees.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Karyawan Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">ID Karyawan</th>
                                    <th class="px-4 py-2">Nama Lengkap</th>
                                    <th class="px-4 py-2">Jabatan</th>
                                    <th class="px-4 py-2">Unit Kerja</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $employee)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $employee->employee_id }}</td>
                                        <td class="border px-4 py-2">{{ $employee->full_name }}</td>
                                        <td class="border px-4 py-2">{{ $employee->position ? $employee->position->name : 'Tidak ada jabatan' }}</td>
                                        <td class="border px-4 py-2">{{ $employee->workUnit ? $employee->workUnit->name : 'Tidak ada unit kerja' }}</td>
                                        <td class="border px-4 py-2">{{ ucfirst($employee->employment_status) }}</td>
                                        <td class="border px-4 py-2">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('employees.show', $employee) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                                <a href="{{ route('employees.edit', $employee) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
