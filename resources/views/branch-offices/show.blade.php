<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Kantor Cabang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('branch-offices.index') }}" class="text-blue-600 hover:text-blue-900">
                            ← Kembali ke Kantor Cabang
                        </a>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Perusahaan</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $branchOffice->company->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Nama</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $branchOffice->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Alamat</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $branchOffice->address }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Telepon</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $branchOffice->phone }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Email</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $branchOffice->email }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Unit Kerja</h3>
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
                                    @foreach($branchOffice->workUnits as $unit)
                                        <tr class="border-b">
                                            <td class="px-6 py-4">{{ $unit->name }}</td>
                                            <td class="px-6 py-4">{{ $unit->address }}</td>
                                            <td class="px-6 py-4">{{ $unit->phone }}</td>
                                            <td class="px-6 py-4">{{ $unit->email }}</td>
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
