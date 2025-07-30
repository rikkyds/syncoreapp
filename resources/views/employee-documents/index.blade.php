<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Dokumen Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Daftar Dokumen Karyawan</h3>
                        <a href="{{ route('employee-documents.create') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Dokumen Baru
                        </a>
                    </div>

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

                    @if($documents->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nama Karyawan
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Jenis Dokumen
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nomor Dokumen
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tanggal Terbit
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Masa Berlaku
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Lokasi Penyimpanan
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            File
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($documents as $document)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $document->employee_name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $document->nip_nik }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $document->document_type_badge_class }}">
                                                    {{ $document->document_type_name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $document->document_number ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $document->issue_date->format('d/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $document->effective_date->format('d/m/Y') }}
                                                    @if($document->expiry_date)
                                                        - {{ $document->expiry_date->format('d/m/Y') }}
                                                    @else
                                                        - Permanen
                                                    @endif
                                                </div>
                                                @if($document->is_expired)
                                                    <div class="text-xs text-red-500">
                                                        Kadaluarsa
                                                    </div>
                                                @elseif($document->is_expiring_soon)
                                                    <div class="text-xs text-yellow-500">
                                                        {{ $document->days_until_expiry }} hari lagi
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $document->document_status_badge_class }}">
                                                    {{ $document->document_status_name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $document->storage_location_badge_class }}">
                                                    {{ $document->storage_location_name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($document->has_file)
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="text-xs text-green-600">Ada File</span>
                                                    </div>
                                                    @if($document->file_size)
                                                        <div class="text-xs text-gray-500">
                                                            {{ $document->file_size }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 text-gray-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4.586a1 1 0 01.707.293L12 6h4a1 1 0 110 2h-4.586l-2.707-2.707A1 1 0 008 5H4v10a1 1 0 01-1-1V4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="text-xs text-gray-400">Tidak Ada</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('employee-documents.show', $document) }}" 
                                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                        Lihat
                                                    </a>
                                                    <a href="{{ route('employee-documents.edit', $document) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                        Edit
                                                    </a>
                                                    
                                                    @if($document->has_file)
                                                        <a href="{{ route('employee-documents.download', $document) }}" 
                                                           class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                            Download
                                                        </a>
                                                    @endif

                                                    @if($document->document_status === 'aktif')
                                                        <form action="{{ route('employee-documents.archive', $document) }}" 
                                                              method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                                                    onclick="return confirm('Arsipkan dokumen ini?')">
                                                                Arsip
                                                            </button>
                                                        </form>
                                                    @elseif($document->document_status === 'arsip')
                                                        <form action="{{ route('employee-documents.restore', $document) }}" 
                                                              method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                                                    onclick="return confirm('Pulihkan dokumen dari arsip?')">
                                                                Pulihkan
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if($document->needsRenewal())
                                                        <form action="{{ route('employee-documents.renew', $document) }}" 
                                                              method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300"
                                                                    onclick="return confirm('Buat dokumen baru untuk pembaruan?')">
                                                                Perbarui
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <form action="{{ route('employee-documents.duplicate', $document) }}" 
                                                          method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="text-cyan-600 hover:text-cyan-900 dark:text-cyan-400 dark:hover:text-cyan-300"
                                                                onclick="return confirm('Duplikasi dokumen ini?')">
                                                            Duplikasi
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('employee-documents.destroy', $document) }}" 
                                                          method="POST" 
                                                          class="inline"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
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

                        <div class="mt-6">
                            {{ $documents->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500 dark:text-gray-400 text-lg">
                                Belum ada dokumen karyawan
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('employee-documents.create') }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Tambah Dokumen Pertama
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
