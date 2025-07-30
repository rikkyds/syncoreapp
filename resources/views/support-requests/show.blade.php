<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Formulir {{ strtoupper($supportRequest->request_type) }} - {{ $supportRequest->request_number }}
            </h2>
            <div class="flex space-x-2">
                @if($supportRequest->status === 'draft')
                    <a href="{{ route('support-requests.edit', $supportRequest) }}" 
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                    <form action="{{ route('support-requests.submit', $supportRequest) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                onclick="return confirm('Apakah Anda yakin ingin mengirim formulir ini untuk persetujuan?')"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Submit untuk Persetujuan
                        </button>
                    </form>
                @endif

                @if($supportRequest->status === 'submitted')
                    <button onclick="showApproveModal()" 
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Setujui
                    </button>
                    <button onclick="showRejectModal()" 
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Tolak
                    </button>
                @endif

                <a href="{{ route('support-requests.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
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

            <!-- Header Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Umum</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nomor Pengajuan</label>
                                <p class="text-lg font-semibold text-blue-600">{{ $supportRequest->request_number }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Jenis Formulir</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($supportRequest->request_type === 'ppt') bg-blue-100 text-blue-800
                                    @elseif($supportRequest->request_type === 'pdk') bg-green-100 text-green-800
                                    @elseif($supportRequest->request_type === 'pdh') bg-purple-100 text-purple-800
                                    @elseif($supportRequest->request_type === 'pds') bg-yellow-100 text-yellow-800
                                    @elseif($supportRequest->request_type === 'pdd') bg-indigo-100 text-indigo-800
                                    @endif">
                                    @if($supportRequest->request_type === 'ppt') PPT - Pengajuan Penugasan Tim
                                    @elseif($supportRequest->request_type === 'pdk') PDK - Pengajuan Dukungan Keuangan
                                    @elseif($supportRequest->request_type === 'pdh') PDH - Pengajuan Dukungan HRD
                                    @elseif($supportRequest->request_type === 'pds') PDS - Pengajuan Dukungan Sarpras
                                    @elseif($supportRequest->request_type === 'pdd') PDD - Pengajuan Dukungan Digitalisasi
                                    @endif
                                </span>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Proyek</label>
                                <p class="text-gray-900">{{ $supportRequest->project->name ?? '-' }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                                <p class="text-gray-900">{{ \Carbon\Carbon::parse($supportRequest->request_date)->format('d F Y') }}</p>
                            </div>
                        </div>

                        <div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($supportRequest->status === 'draft') bg-gray-100 text-gray-800
                                    @elseif($supportRequest->status === 'submitted') bg-yellow-100 text-yellow-800
                                    @elseif($supportRequest->status === 'approved') bg-green-100 text-green-800
                                    @elseif($supportRequest->status === 'rejected') bg-red-100 text-red-800
                                    @elseif($supportRequest->status === 'completed') bg-blue-100 text-blue-800
                                    @endif">
                                    @if($supportRequest->status === 'draft') Draft
                                    @elseif($supportRequest->status === 'submitted') Disubmit
                                    @elseif($supportRequest->status === 'approved') Disetujui
                                    @elseif($supportRequest->status === 'rejected') Ditolak
                                    @elseif($supportRequest->status === 'completed') Selesai
                                    @endif
                                </span>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Pengaju</label>
                                <p class="text-gray-900">{{ $supportRequest->requesterEmployee->name ?? '-' }}</p>
                            </div>

                            @if($supportRequest->total_request > 0)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Total Pengajuan</label>
                                    <p class="text-lg font-semibold text-green-600">Rp {{ number_format($supportRequest->total_request, 0, ',', '.') }}</p>
                                </div>
                            @endif

                            @if($supportRequest->approved_by && $supportRequest->approved_at)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Disetujui Oleh</label>
                                    <p class="text-gray-900">{{ $supportRequest->approvedByEmployee->name ?? '-' }}</p>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($supportRequest->approved_at)->format('d F Y H:i') }}</p>
                                </div>
                            @endif

                            @if($supportRequest->rejection_reason)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                                    <p class="text-red-600">{{ $supportRequest->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Information -->
            @if($supportRequest->project)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Informasi Proyek</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Objective</label>
                                    <p class="text-gray-900">{{ $supportRequest->project->objective ?? '-' }}</p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Unit</label>
                                    <p class="text-gray-900">{{ $supportRequest->project->unit ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Program</label>
                                    <p class="text-gray-900">{{ $supportRequest->project->program ?? '-' }}</p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Kegiatan</label>
                                    <p class="text-gray-900">{{ $supportRequest->project->activity ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Key Result</label>
                                    <p class="text-gray-900">{{ $supportRequest->project->key_result ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($supportRequest->request_type === 'ppt' && $supportRequest->pptDetails->count() > 0)
                <!-- PPT Details -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Detail Penugasan Tim</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proses Bisnis</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fungsi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Karyawan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tugas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Output</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($supportRequest->pptDetails as $detail)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->business_process }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->function_type }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->role }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->assignedEmployee->name ?? '-' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->task_description }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->output_description }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($detail->start_date)->format('d/m/Y') }} - 
                                                {{ \Carbon\Carbon::parse($detail->end_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->location }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($detail->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($detail->status === 'in_progress') bg-blue-100 text-blue-800
                                                    @elseif($detail->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($detail->status === 'cancelled') bg-red-100 text-red-800
                                                    @endif">
                                                    @if($detail->status === 'pending') Pending
                                                    @elseif($detail->status === 'in_progress') Dalam Proses
                                                    @elseif($detail->status === 'completed') Selesai
                                                    @elseif($detail->status === 'cancelled') Dibatalkan
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @elseif($supportRequest->request_type === 'pdk' && $supportRequest->pdkDetails->count() > 0)
                <!-- Budget Information -->
                @if($supportRequest->program_budget > 0 || $supportRequest->contribution > 0 || $supportRequest->budget_notes)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Informasi Anggaran</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @if($supportRequest->program_budget > 0)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Anggaran Program</label>
                                        <p class="text-lg font-semibold text-blue-600">Rp {{ number_format($supportRequest->program_budget, 0, ',', '.') }}</p>
                                    </div>
                                @endif
                                
                                @if($supportRequest->contribution > 0)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Kontribusi</label>
                                        <p class="text-lg font-semibold text-green-600">Rp {{ number_format($supportRequest->contribution, 0, ',', '.') }}</p>
                                    </div>
                                @endif

                                @if($supportRequest->remaining_budget !== null)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Sisa Anggaran</label>
                                        <p class="text-lg font-semibold text-purple-600">Rp {{ number_format($supportRequest->remaining_budget, 0, ',', '.') }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4 flex items-center">
                                <input type="checkbox" {{ $supportRequest->tax_included ? 'checked' : '' }} disabled class="mr-2">
                                <label class="text-sm text-gray-700">Sudah Termasuk Pajak</label>
                            </div>

                            @if($supportRequest->budget_notes)
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700">Catatan Anggaran</label>
                                    <p class="text-gray-900">{{ $supportRequest->budget_notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- PDK Details -->
                @php
                    $personilDetails = $supportRequest->pdkDetails->where('cost_category', 'personil');
                    $nonPersonilDetails = $supportRequest->pdkDetails->where('cost_category', 'non_personil');
                    $totalPersonil = $personilDetails->sum('total_price');
                    $totalNonPersonil = $nonPersonilDetails->sum('total_price');
                @endphp

                @if($personilDetails->count() > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">I. Biaya Langsung Personil</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kegiatan</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rincian</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Volume</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($personilDetails->sortBy('sort_order') as $index => $detail)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->activity_name }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->description }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($detail->volume, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->unit }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-gray-50">
                                            <td colspan="6" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Total Biaya Personil:</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">Rp {{ number_format($totalPersonil, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                @if($nonPersonilDetails->count() > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">II. Biaya Non Personil</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kegiatan</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rincian</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Volume</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($nonPersonilDetails->sortBy('sort_order') as $index => $detail)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->activity_name }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->description }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($detail->volume, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->unit }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-gray-50">
                                            <td colspan="6" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Total Biaya Non Personil:</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">Rp {{ number_format($totalNonPersonil, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Total Summary -->
                <div class="bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Ringkasan Pengajuan</h3>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-blue-600">
                                Total Pengajuan: Rp {{ number_format($supportRequest->total_request, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Setujui Formulir</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menyetujui formulir ini?
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <form action="{{ route('support-requests.approve', $supportRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-green-600">
                            Setujui
                        </button>
                        <button type="button" onclick="hideApproveModal()"
                                class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600">
                            Batal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 text-center">Tolak Formulir</h3>
                <form action="{{ route('support-requests.reject', $supportRequest) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Alasan Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="rejection_reason" id="rejection_reason" required rows="4"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                                  placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" 
                                class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600">
                            Tolak
                        </button>
                        <button type="button" onclick="hideRejectModal()"
                                class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showApproveModal() {
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function hideApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function showRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const approveModal = document.getElementById('approveModal');
            const rejectModal = document.getElementById('rejectModal');
            
            if (event.target === approveModal) {
                hideApproveModal();
            }
            
            if (event.target === rejectModal) {
                hideRejectModal();
            }
        });
    </script>
</x-app-layout>
