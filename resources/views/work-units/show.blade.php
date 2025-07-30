<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Work Unit Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('work-units.index') }}" class="text-blue-600 hover:text-blue-900">
                            ← {{ __('Back to Work Units') }}
                        </a>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Branch Office') }}</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $workUnit->branchOffice->company->name }} - {{ $workUnit->branchOffice->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Name') }}</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $workUnit->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Address') }}</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $workUnit->address }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Phone') }}</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $workUnit->phone }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Email') }}</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $workUnit->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
