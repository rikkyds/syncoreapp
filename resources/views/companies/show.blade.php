<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Perusahaan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('companies.index') }}" class="text-blue-600 hover:text-blue-900">
                            ← Kembali ke Perusahaan
                        </a>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Nama</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $company->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Alamat</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $company->address }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Telepon</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $company->phone }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Email</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $company->email }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Kantor Cabang</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-6 py-3 text-left">Nama</th>
                                        <th class="px-6 py-3 text-left">Alamat</th>
                                        <th class="px-6 py-3 text-left">Telepon</th>
                                        <th class="px-6 py-3 text-left">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($company->branchOffices as $office)
                                        <tr class="border-b">
                                            <td class="px-6 py-4">{{ $office->name }}</td>
                                            <td class="px-6 py-4">{{ $office->address }}</td>
                                            <td class="px-6 py-4">{{ $office->phone }}</td>
                                            <td class="px-6 py-4">{{ $office->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
