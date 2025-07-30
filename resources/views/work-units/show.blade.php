<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Unit Kerja
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('work-units.index') }}" class="text-blue-600 hover:text-blue-900">
                            ← Kembali ke Unit Kerja
                        </a>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Kantor Cabang</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $workUnit->branchOffice->company->name }} - {{ $workUnit->branchOffice->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Nama</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $workUnit->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Alamat</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $workUnit->address }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Telepon</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $workUnit->phone }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Email</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $workUnit->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
