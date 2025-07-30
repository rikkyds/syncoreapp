<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Formulir Kebutuhan Pengajuan
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('support-requests.create', ['type' => 'ppt']) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Buat PPT
                </a>
                <a href="{{ route('support-requests.create', ['type' => 'pdk']) }}" 
                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Buat PDK
                </a>
                <div class="relative">
                    <button id="dropdownButton" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                        Lainnya
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                        <a href="{{ route('support-requests.create', ['type' => 'pdh']) }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">PDH - Dukungan HRD</a>
                        <a href="{{ route('support-requests.create', ['type' => 'pds']) }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">PDS - Dukungan Sarpras</a>
                        <a href="{{ route('support-requests.create', ['type' => 'pdd']) }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">PDD - Dukungan Digitalisasi</a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Filter Section -->
                    <div class="mb-6 flex flex-wrap gap-4">
                        <select id="typeFilter" class="border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Semua Jenis</option>
                            <option value="ppt">PPT - Penugasan Tim</option>
                            <option value="pdk">PDK - Dukungan Keuangan</option>
                            <option value="pdh">PDH - Dukungan HRD</option>
                            <option value="pds">PDS - Dukungan Sarpras</option>
                            <option value="pdd">PDD - Dukungan Digitalisasi</option>
                        </select>
                        
                        <select id="statusFilter" class="border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Semua Status</option>
                            <option value="draft">Draft</option>
                            <option value="submitted">Disubmit</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                            <option value="completed">Selesai</option>
                        </select>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nomor Pengajuan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Proyek
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pengaju
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Pengajuan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($supportRequests as $request)
                                    <tr class="hover:bg-gray-50" data-type="{{ $request->request_type }}" data-status="{{ $request->status }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $request->request_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($request->request_type === 'ppt') bg-blue-100 text-blue-800
                                                @elseif($request->request_type === 'pdk') bg-green-100 text-green-800
                                                @elseif($request->request_type === 'pdh') bg-purple-100 text-purple-800
                                                @elseif($request->request_type === 'pds') bg-yellow-100 text-yellow-800
                                                @elseif($request->request_type === 'pdd') bg-indigo-100 text-indigo-800
                                                @endif">
                                                {{ strtoupper($request->request_type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $request->project->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $request->requesterEmployee->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($request->request_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($request->status === 'draft') bg-gray-100 text-gray-800
                                                @elseif($request->status === 'submitted') bg-yellow-100 text-yellow-800
                                                @elseif($request->status === 'approved') bg-green-100 text-green-800
                                                @elseif($request->status === 'rejected') bg-red-100 text-red-800
                                                @elseif($request->status === 'completed') bg-blue-100 text-blue-800
                                                @endif">
                                                @if($request->status === 'draft') Draft
                                                @elseif($request->status === 'submitted') Disubmit
                                                @elseif($request->status === 'approved') Disetujui
                                                @elseif($request->status === 'rejected') Ditolak
                                                @elseif($request->status === 'completed') Selesai
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($request->total_request > 0)
                                                Rp {{ number_format($request->total_request, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('support-requests.show', $request) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                                
                                                @if($request->status === 'draft')
                                                    <a href="{{ route('support-requests.edit', $request) }}" 
                                                       class="text-blue-600 hover:text-blue-900">Edit</a>
                                                    
                                                    <form action="{{ route('support-requests.destroy', $request) }}" 
                                                          method="POST" class="inline"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus formulir ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada formulir pengajuan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $supportRequests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dropdown functionality
        document.getElementById('dropdownButton').addEventListener('click', function() {
            document.getElementById('dropdownMenu').classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            const button = document.getElementById('dropdownButton');
            
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Filter functionality
        document.getElementById('typeFilter').addEventListener('change', function() {
            filterTable();
        });

        document.getElementById('statusFilter').addEventListener('change', function() {
            filterTable();
        });

        function filterTable() {
            const typeFilter = document.getElementById('typeFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('tbody tr[data-type]');

            rows.forEach(row => {
                const rowType = row.getAttribute('data-type');
                const rowStatus = row.getAttribute('data-status');
                
                const typeMatch = !typeFilter || rowType === typeFilter;
                const statusMatch = !statusFilter || rowStatus === statusFilter;
                
                if (typeMatch && statusMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</x-app-layout>
