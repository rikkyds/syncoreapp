<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Users Management</h3>
                            <p class="text-gray-600 mb-4">Manage system users and their roles</p>
                            <a href="{{ route('users.index') }}" class="text-indigo-600 hover:text-indigo-900">Manage Users →</a>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Roles Management</h3>
                            <p class="text-gray-600 mb-4">Configure system roles and permissions</p>
                            <a href="{{ route('roles.index') }}" class="text-indigo-600 hover:text-indigo-900">Manage Roles →</a>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">System Settings</h3>
                            <p class="text-gray-600 mb-4">Configure system-wide settings</p>
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Manage Settings →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
