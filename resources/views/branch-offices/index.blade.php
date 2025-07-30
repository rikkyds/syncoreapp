<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kantor Cabang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Kantor Cabang</h3>
                        <a href="{{ route('branch-offices.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Kantor Cabang
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left">Perusahaan</th>
                                    <th class="px-6 py-3 text-left">Nama</th>
                                    <th class="px-6 py-3 text-left">Alamat</th>
                                    <th class="px-6 py-3 text-left">Telepon</th>
                                    <th class="px-6 py-3 text-left">Email</th>
                                    <th class="px-6 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($branchOffices as $office)
                                    <tr class="border-b">
                                        <td class="px-6 py-4">{{ $office->company ? $office->company->name : 'Tidak ada perusahaan' }}</td>
                                        <td class="px-6 py-4">{{ $office->name }}</td>
                                        <td class="px-6 py-4">{{ $office->address }}</td>
                                        <td class="px-6 py-4">{{ $office->phone }}</td>
                                        <td class="px-6 py-4">{{ $office->email }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('branch-offices.show', $office) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                                <a href="{{ route('branch-offices.edit', $office) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                <form action="{{ route('branch-offices.destroy', $office) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus kantor cabang ini?')">
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
