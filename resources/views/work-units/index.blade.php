<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Work Units') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">{{ __('Work Unit List') }}</h3>
                        <a href="{{ route('work-units.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Add Work Unit') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left">{{ __('Branch Office') }}</th>
                                    <th class="px-6 py-3 text-left">{{ __('Name') }}</th>
                                    <th class="px-6 py-3 text-left">{{ __('Address') }}</th>
                                    <th class="px-6 py-3 text-left">{{ __('Phone') }}</th>
                                    <th class="px-6 py-3 text-left">{{ __('Email') }}</th>
                                    <th class="px-6 py-3 text-left">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($workUnits as $unit)
                                    <tr class="border-b">
                                        <td class="px-6 py-4">{{ $unit->branchOffice->name }}</td>
                                        <td class="px-6 py-4">{{ $unit->name }}</td>
                                        <td class="px-6 py-4">{{ $unit->address }}</td>
                                        <td class="px-6 py-4">{{ $unit->phone }}</td>
                                        <td class="px-6 py-4">{{ $unit->email }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('work-units.show', $unit) }}" class="text-blue-600 hover:text-blue-900">{{ __('View') }}</a>
                                                <a href="{{ route('work-units.edit', $unit) }}" class="text-yellow-600 hover:text-yellow-900">{{ __('Edit') }}</a>
                                                <form action="{{ route('work-units.destroy', $unit) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure you want to delete this work unit?') }}')">
                                                        {{ __('Delete') }}
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
