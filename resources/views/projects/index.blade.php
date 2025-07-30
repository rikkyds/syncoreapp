<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Proyek
            </h2>
            <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Proyek Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('projects.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Status</option>
                                @foreach($statusOptions as $key => $label)
                                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Filter
                            </button>
                            <a href="{{ route('projects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Projects Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kode Proyek
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Proyek
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pengaju
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Pengajuan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Progress
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($projects as $project)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $project->final_project_code }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $project->project_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $project->program_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $project->submitter->full_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $project->submitterPosition->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $project->submission_date->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($project->status == 'draft') bg-gray-100 text-gray-800
                                                @elseif($project->status == 'submitted') bg-yellow-100 text-yellow-800
                                                @elseif($project->status == 'approved') bg-green-100 text-green-800
                                                @elseif($project->status == 'rejected') bg-red-100 text-red-800
                                                @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800
                                                @elseif($project->status == 'completed') bg-purple-100 text-purple-800
                                                @endif">
                                                {{ $project->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-1 bg-gray-200 rounded-full h-2 mr-2">
                                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                                                </div>
                                                <span class="text-sm text-gray-600">{{ $project->progress_percentage }}%</span>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $project->current_achievement }}/{{ $project->target }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    Lihat
                                                </a>
                                                
                                                <a href="{{ route('projects.report', $project) }}" target="_blank" class="text-purple-600 hover:text-purple-900">
                                                    Laporan
                                                </a>
                                                
                                                <a href="{{ route('projects.sikoja', $project) }}" target="_blank" class="text-green-600 hover:text-green-900">
                                                    SIKOJA
                                                </a>
                                                
                                                @if($project->canBeEdited())
                                                    <a href="{{ route('projects.edit', $project) }}" class="text-yellow-600 hover:text-yellow-900">
                                                        Edit
                                                    </a>
                                                @endif
                                                
                                                @if($project->canBeApproved() && auth()->user()->role->name == 'admin')
                                                    <form method="POST" action="{{ route('projects.approve', $project) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:text-green-900" 
                                                                onclick="return confirm('Apakah Anda yakin ingin menyetujui proyek ini?')">
                                                            Setujui
                                                        </button>
                                                    </form>
                                                    
                                                    <button onclick="openRejectModal({{ $project->id }})" class="text-red-600 hover:text-red-900">
                                                        Tolak
                                                    </button>
                                                @endif
                                                
                                                @if($project->canBeStarted())
                                                    <form method="POST" action="{{ route('projects.start', $project) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-blue-600 hover:text-blue-900" 
                                                                onclick="return confirm('Apakah Anda yakin ingin memulai proyek ini?')">
                                                            Mulai
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                @if($project->status == 'in_progress')
                                                    <form method="POST" action="{{ route('projects.complete', $project) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-purple-600 hover:text-purple-900" 
                                                                onclick="return confirm('Apakah Anda yakin ingin menyelesaikan proyek ini?')">
                                                            Selesai
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                @if($project->canBeEdited())
                                                    <form method="POST" action="{{ route('projects.destroy', $project) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Tidak ada data proyek
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Tolak Proyek</h3>
                <form id="rejectForm" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 text-left">
                            Alasan Penolakan
                        </label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeRejectModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Tolak Proyek
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(projectId) {
            document.getElementById('rejectForm').action = `/projects/${projectId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejection_reason').value = '';
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</x-app-layout>
