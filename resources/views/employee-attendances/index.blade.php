<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Absensi Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Daftar Absensi Karyawan</h3>
                        <a href="{{ route('employee-attendances.create') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Absensi Baru
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

                    @if($attendances->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Karyawan
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Waktu
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Durasi Kerja
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Lokasi Kerja
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Metode
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Verifikasi
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($attendances as $attendance)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $attendance->employee_name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $attendance->nip_nik }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $attendance->attendance_date->format('d/m/Y') }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $attendance->day_type_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    @if($attendance->time_in)
                                                        <div>Masuk: {{ $attendance->time_in->format('H:i') }}</div>
                                                    @endif
                                                    @if($attendance->time_out)
                                                        <div>Keluar: {{ $attendance->time_out->format('H:i') }}</div>
                                                    @endif
                                                </div>
                                                @if($attendance->time_logs_count > 0)
                                                    <div class="text-xs text-blue-500">
                                                        {{ $attendance->time_logs_count }} log waktu
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $attendance->formatted_total_work_duration }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attendance->attendance_status_badge_class }}">
                                                    {{ $attendance->attendance_status_name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attendance->work_location_badge_class }}">
                                                    {{ $attendance->work_location_name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $attendance->attendance_method_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attendance->supervisor_verification_badge_class }}">
                                                    {{ $attendance->supervisor_verification_name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('employee-attendances.show', $attendance) }}" 
                                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                        Lihat
                                                    </a>
                                                    <a href="{{ route('employee-attendances.edit', $attendance) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                        Edit
                                                    </a>
                                                    
                                                    @if($attendance->has_supporting_document)
                                                        <a href="{{ route('employee-attendances.download-document', $attendance) }}" 
                                                           class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                            Download
                                                        </a>
                                                    @endif

                                                    @if($attendance->supervisor_verification === 'pending')
                                                        <form action="{{ route('employee-attendances.approve', $attendance) }}" 
                                                              method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                                                    onclick="return confirm('Setujui absensi ini?')">
                                                                Setujui
                                                            </button>
                                                        </form>
                                                        
                                                        <button type="button" 
                                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                                onclick="openRejectModal({{ $attendance->id }})">
                                                            Tolak
                                                        </button>
                                                    @endif

                                                    <form action="{{ route('employee-attendances.destroy', $attendance) }}" 
                                                          method="POST" 
                                                          class="inline"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data absensi ini?')">
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
                            {{ $attendances->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500 dark:text-gray-400 text-lg">
                                Belum ada data absensi karyawan
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('employee-attendances.create') }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Tambah Absensi Pertama
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Tolak Absensi</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mt-4">
                        <label for="hrd_notes" class="block text-sm font-medium text-gray-700">Alasan Penolakan:</label>
                        <textarea id="hrd_notes" name="hrd_notes" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                  required></textarea>
                    </div>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button type="button" onclick="closeRejectModal()" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(attendanceId) {
            document.getElementById('rejectForm').action = `/employee-attendances/${attendanceId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('hrd_notes').value = '';
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</x-app-layout>
