<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Perusahaan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Daftar Perusahaan</h3>
                        <a href="{{ route('companies.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Perusahaan
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left">Nama</th>
                                    <th class="px-6 py-3 text-left">Alamat</th>
                                    <th class="px-6 py-3 text-left">Telepon</th>
                                    <th class="px-6 py-3 text-left">Email</th>
                                    <th class="px-6 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companies as $company)
                                    <tr class="border-b">
                                        <td class="px-6 py-4">{{ $company->name }}</td>
                                        <td class="px-6 py-4">{{ $company->address }}</td>
                                        <td class="px-6 py-4">{{ $company->phone }}</td>
                                        <td class="px-6 py-4">{{ $company->email }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('companies.show', $company) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                                <a href="{{ route('companies.edit', $company) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                <form action="{{ route('companies.destroy', $company) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus perusahaan ini?')">
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
