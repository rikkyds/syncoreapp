<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Unit Kerja
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Unit Kerja</h3>
                        <a href="{{ route('work-units.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Unit Kerja
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left">Kantor Cabang</th>
                                    <th class="px-6 py-3 text-left">Nama</th>
                                    <th class="px-6 py-3 text-left">Alamat</th>
                                    <th class="px-6 py-3 text-left">Telepon</th>
                                    <th class="px-6 py-3 text-left">Email</th>
                                    <th class="px-6 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($workUnits as $unit)
                                    <tr class="border-b">
                                        <td class="px-6 py-4">{{ $unit->branchOffice ? $unit->branchOffice->name : 'Tidak ada kantor cabang' }}</td>
                                        <td class="px-6 py-4">{{ $unit->name }}</td>
                                        <td class="px-6 py-4">{{ $unit->address }}</td>
                                        <td class="px-6 py-4">{{ $unit->phone }}</td>
                                        <td class="px-6 py-4">{{ $unit->email }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('work-units.show', $unit) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                                <a href="{{ route('work-units.edit', $unit) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                <form action="{{ route('work-units.destroy', $unit) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus unit kerja ini?')">
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
