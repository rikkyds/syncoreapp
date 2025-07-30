<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Formulir 
            @if($type === 'ppt') PPT - Pengajuan Penugasan Tim
            @elseif($type === 'pdk') PDK - Pengajuan Dukungan Keuangan
            @elseif($type === 'pdh') PDH - Pengajuan Dukungan HRD
            @elseif($type === 'pds') PDS - Pengajuan Dukungan Sarpras
            @elseif($type === 'pdd') PDD - Pengajuan Dukungan Digitalisasi
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('support-requests.store') }}" method="POST" id="supportRequestForm">
                        @csrf
                        <input type="hidden" name="request_type" value="{{ $type }}">

                        <!-- Header Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Proyek <span class="text-red-500">*</span>
                                </label>
                                <select name="project_id" id="project_id" required 
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih Proyek</option>
                                    @foreach($projects as $proj)
                                        <option value="{{ $proj->id }}" 
                                                {{ ($project && $project->id == $proj->id) || old('project_id') == $proj->id ? 'selected' : '' }}
                                                data-objective="{{ $proj->objective }}"
                                                data-unit="{{ $proj->unit }}"
                                                data-program="{{ $proj->program }}"
                                                data-activity="{{ $proj->activity }}"
                                                data-key-result="{{ $proj->key_result }}">
                                            {{ $proj->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="request_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Pengajuan <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="request_date" id="request_date" required
                                       value="{{ old('request_date', date('Y-m-d')) }}"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Project Information Display -->
                        <div id="projectInfo" class="mb-8 p-4 bg-gray-50 rounded-lg" style="display: none;">
                            <h3 class="text-lg font-semibold mb-4">Informasi Proyek</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <strong>Objective:</strong> <span id="projectObjective"></span>
                                </div>
                                <div>
                                    <strong>Unit:</strong> <span id="projectUnit"></span>
                                </div>
                                <div>
                                    <strong>Program:</strong> <span id="projectProgram"></span>
                                </div>
                                <div>
                                    <strong>Kegiatan:</strong> <span id="projectActivity"></span>
                                </div>
                                <div class="md:col-span-2">
                                    <strong>Key Result:</strong> <span id="projectKeyResult"></span>
                                </div>
                            </div>
                        </div>

                        @if($type === 'ppt')
                            <!-- PPT Specific Fields -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold mb-4">Detail Penugasan Tim</h3>
                                
                                <div id="pptDetailsContainer">
                                    <div class="ppt-detail-row border border-gray-200 rounded-lg p-4 mb-4">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Proses Bisnis <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="ppt_details[0][business_process]" required
                                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="e.g., Consulting">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Fungsi <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="ppt_details[0][function_type]" required
                                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="e.g., Implementator">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Peran <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="ppt_details[0][role]" required
                                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="e.g., Narasumber">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Karyawan yang Ditugaskan
                                                </label>
                                                <select name="ppt_details[0][assigned_employee_id]"
                                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    <option value="">Pilih Karyawan</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Lokasi <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="ppt_details[0][location]" required
                                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="e.g., Prima SR Hotel">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Tanggal Mulai <span class="text-red-500">*</span>
                                                </label>
                                                <input type="date" name="ppt_details[0][start_date]" required
                                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Tanggal Selesai <span class="text-red-500">*</span>
                                                </label>
                                                <input type="date" name="ppt_details[0][end_date]" required
                                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Deskripsi Tugas <span class="text-red-500">*</span>
                                                </label>
                                                <textarea name="ppt_details[0][task_description]" required rows="3"
                                                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                          placeholder="e.g., Narasumber Kelas Evaluasi"></textarea>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Output yang Diharapkan <span class="text-red-500">*</span>
                                                </label>
                                                <textarea name="ppt_details[0][output_description]" required rows="3"
                                                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                          placeholder="e.g., Paparan Materi, Artikel, MOM"></textarea>
                                            </div>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="button" class="remove-ppt-detail bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="addPptDetail" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Tambah Detail Penugasan
                                </button>
                            </div>

                        @elseif($type === 'pdk')
                            <!-- PDK Specific Fields -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold mb-4">Informasi Anggaran</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                    <div>
                                        <label for="program_budget" class="block text-sm font-medium text-gray-700 mb-2">
                                            Anggaran Program
                                        </label>
                                        <input type="number" name="program_budget" id="program_budget" step="0.01"
                                               value="{{ old('program_budget') }}"
                                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               placeholder="0">
                                    </div>
                                    <div>
                                        <label for="contribution" class="block text-sm font-medium text-gray-700 mb-2">
                                            Kontribusi
                                        </label>
                                        <input type="number" name="contribution" id="contribution" step="0.01"
                                               value="{{ old('contribution') }}"
                                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               placeholder="0">
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="tax_included" id="tax_included" 
                                               {{ old('tax_included') ? 'checked' : '' }}
                                               class="mr-2">
                                        <label for="tax_included" class="text-sm font-medium text-gray-700">
                                            Sudah Termasuk Pajak
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="budget_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Catatan Anggaran
                                    </label>
                                    <textarea name="budget_notes" id="budget_notes" rows="2"
                                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                              placeholder="e.g., Pendapatan belum dipotong pajak">{{ old('budget_notes') }}</textarea>
                                </div>
                            </div>

                            <!-- PDK Details -->
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold mb-4">I. Biaya Langsung Personil</h3>
                                
                                <div id="pdkPersonilContainer">
                                    <div class="pdk-detail-row border border-gray-200 rounded-lg p-4 mb-4" data-category="personil">
                                        <input type="hidden" name="pdk_details[0][cost_category]" value="personil">
                                        <input type="hidden" name="pdk_details[0][sort_order]" value="1">
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Nama Kegiatan <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="pdk_details[0][activity_name]" required
                                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="e.g., Honor Narasumber Maulana R.M">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Rincian <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="pdk_details[0][description]" required
                                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="e.g., 1 orang x 1 sesi">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Volume <span class="text-red-500">*</span>
                                                </label>
                                                <input type="number" name="pdk_details[0][volume]" required step="0.01"
                                                       class="volume-input w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="1">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Satuan <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="pdk_details[0][unit]" required
                                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="OS">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Harga Satuan <span class="text-red-500">*</span>
                                                </label>
                                                <input type="number" name="pdk_details[0][unit_price]" required step="0.01"
                                                       class="unit-price-input w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="50000">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Total Harga
                                                </label>
                                                <input type="text" class="total-price-display w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100" 
                                                       readonly placeholder="0">
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Catatan
                                            </label>
                                            <textarea name="pdk_details[0][notes]" rows="2"
                                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="button" class="remove-pdk-detail bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="add-pdk-detail bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4" data-category="personil">
                                    Tambah Item Personil
                                </button>

                                <div class="text-right mb-6">
                                    <strong>Total Biaya Personil: Rp <span id="totalPersonil">0</span></strong>
                                </div>
                            </div>

                            <div class="mb-8">
                                <h3 class="text-lg font-semibold mb-4">II. Biaya Non Personil</h3>
                                
                                <div id="pdkNonPersonilContainer">
                                    <div class="pdk-detail-row border border-gray-200 rounded-lg p-4 mb-4" data-category="non_personil">
                                        <input type="hidden" name="pdk_details[1][cost_category]" value="non_personil">
                                        <input type="hidden" name="pdk_details[1][sort_order]" value="1">
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Nama Kegiatan <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="pdk_details[1][activity_name]" required
                                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="e.g., Makan Siang Tim Gamping">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Rincian <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="pdk_details[1][description]" required
                                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="e.g., 2 orang x 1 hari">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Volume <span class="text-red-500">*</span>
                                                </label>
                                                <input type="number" name="pdk_details[1][volume]" required step="0.01"
                                                       class="volume-input w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="2">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Satuan <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="pdk_details[1][unit]" required
                                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="OH">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Harga Satuan <span class="text-red-500">*</span>
                                                </label>
                                                <input type="number" name="pdk_details[1][unit_price]" required step="0.01"
                                                       class="unit-price-input w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                       placeholder="25000">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Total Harga
                                                </label>
                                                <input type="text" class="total-price-display w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100" 
                                                       readonly placeholder="0">
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Catatan
                                            </label>
                                            <textarea name="pdk_details[1][notes]" rows="2"
                                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="button" class="remove-pdk-detail bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="add-pdk-detail bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4" data-category="non_personil">
                                    Tambah Item Non Personil
                                </button>

                                <div class="text-right mb-6">
                                    <strong>Total Biaya Non Personil: Rp <span id="totalNonPersonil">0</span></strong>
                                </div>
                            </div>

                            <!-- Total Summary -->
                            <div class="mb-8 p-4 bg-blue-50 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Ringkasan Pengajuan</h3>
                                <div class="text-right">
                                    <div class="text-xl font-bold text-blue-600">
                                        Total Pengajuan: Rp <span id="grandTotal">0</span>
                                    </div>
                                </div>
                                <input type="hidden" name="total_request" id="totalRequestInput" value="0">
                            </div>

                        @else
                            <!-- Placeholder for other form types -->
                            <div class="mb-8 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-yellow-800">
                                    Formulir {{ strtoupper($type) }} sedang dalam pengembangan. 
                                    Silakan gunakan formulir PPT atau PDK untuk saat ini.
                                </p>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex justify-between">
                            <a href="{{ route('support-requests.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            
                            <div class="space-x-2">
                                <button type="submit" name="action" value="draft"
                                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Simpan sebagai Draft
                                </button>
                                <button type="submit" name="action" value="submit"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Simpan dan Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let pptDetailIndex = 1;
        let pdkDetailIndex = 2;

        // Project selection handler
        document.getElementById('project_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const projectInfo = document.getElementById('projectInfo');
            
            if (selectedOption.value) {
                document.getElementById('projectObjective').textContent = selectedOption.dataset.objective || '-';
                document.getElementById('projectUnit').textContent = selectedOption.dataset.unit || '-';
                document.getElementById('projectProgram').textContent = selectedOption.dataset.program || '-';
                document.getElementById('projectActivity').textContent = selectedOption.dataset.activity || '-';
                document.getElementById('projectKeyResult').textContent = selectedOption.dataset.keyResult || '-';
                projectInfo.style.display = 'block';
            } else {
                projectInfo.style.display = 'none';
            }
        });

        // Trigger project info display if project is pre-selected
        if (document.getElementById('project_id').value) {
            document.getElementById('project_id').dispatchEvent(new Event('change'));
        }

        @if($type === 'ppt')
        // PPT Detail Management
        document.getElementById('addPptDetail').addEventListener('click', function() {
            const container = document.getElementById('pptDetailsContainer');
            const newRow = createPptDetailRow(pptDetailIndex);
            container.appendChild(newRow);
            pptDetailIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-ppt-detail')) {
                if (document.querySelectorAll('.ppt-detail-row').length > 1) {
                    e.target.closest('.ppt-detail-row').remove();
                } else {
                    alert('Minimal harus ada satu detail penugasan');
                }
            }
        });

        function createPptDetailRow(index) {
            const div = document.createElement('div');
            div.className = 'ppt-detail-row border border-gray-200 rounded-lg p-4 mb-4';
            div.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Proses Bisnis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="ppt_details[${index}][business_process]" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., Consulting">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Fungsi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="ppt_details[${index}][function_type]" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., Implementator">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Peran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="ppt_details[${index}][role]" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., Narasumber">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Karyawan yang Ditugaskan
                        </label>
                        <select name="ppt_details[${index}][assigned_employee_id]"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Karyawan</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="ppt_details[${index}][location]" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., Prima SR Hotel">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="ppt_details[${index}][start_date]" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="ppt_details[${index}][end_date]" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Tugas <span class="text-red-500">*</span>
                        </label>
                        <textarea name="ppt_details[${index}][task_description]" required rows="3"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="e.g., Narasumber Kelas Evaluasi"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Output yang Diharapkan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="ppt_details[${index}][output_description]" required rows="3"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="e.g., Paparan Materi, Artikel, MOM"></textarea>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="remove-ppt-detail bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Hapus
                    </button>
                </div>
            `;
            return div;
        }
        @endif

        @if($type === 'pdk')
        // PDK Detail Management
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-pdk-detail')) {
                const category = e.target.dataset.category;
                const container = document.getElementById(category === 'personil' ? 'pdkPersonilContainer' : 'pdkNonPersonilContainer');
                const newRow = createPdkDetailRow(pdkDetailIndex, category);
                container.appendChild(newRow);
                pdkDetailIndex++;
                
                // Add event listeners for calculation
                addCalculationListeners(newRow);
            }
            
            if (e.target.classList.contains('remove-pdk-detail')) {
                const category = e.target.closest('.pdk-detail-row').dataset.category;
                const container = document.getElementById(category === 'personil' ? 'pdkPersonilContainer' : 'pdkNonPersonilContainer');
                
                if (container.children.length > 1) {
                    e.target.closest('.pdk-detail-row').remove();
                    updateTotals();
                } else {
                    alert('Minimal harus ada satu item per kategori');
                }
            }
        });

        function createPdkDetailRow(index, category) {
            const div = document.createElement('div');
            div.className = 'pdk-detail-row border border-gray-200 rounded-lg p-4 mb-4';
            div.dataset.category = category;
            
            const sortOrder = document.querySelectorAll(`[data-category="${category}"]`).length + 1;
            
            div.innerHTML = `
                <input type="hidden" name="pdk_details[${index}][cost_category]" value="${category}">
                <input type="hidden" name="pdk_details[${index}][sort_order]" value="${sortOrder}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="pdk_details[${index}][activity_name]" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., ${category === 'personil' ? 'Honor Narasumber' : 'Makan Siang Tim'}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Rincian <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="pdk_details[${index}][description]" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="e.g., ${category === 'personil' ? '1 orang x 1 sesi' : '2 orang x 1 hari'}">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Volume <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="pdk_details[${index}][volume]" required step="0.01"
                               class="volume-input w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="${category === 'personil' ? '1' : '2'}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Satuan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="pdk_details[${index}][unit]" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="${category === 'personil' ? 'OS' : 'OH'}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Satuan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="pdk_details[${index}][unit_price]" required step="0.01"
                               class="unit-price-input w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="${category === 'personil' ? '50000' : '25000'}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Total Harga
                        </label>
                        <input type="text" class="total-price-display w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100" 
                               readonly placeholder="0">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan
                    </label>
                    <textarea name="pdk_details[${index}][notes]" rows="2"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="remove-pdk-detail bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Hapus
                    </button>
                </div>
            `;
            return div;
        }

        // Add calculation listeners to existing rows
        document.querySelectorAll('.pdk-detail-row').forEach(row => {
            addCalculationListeners(row);
        });

        function addCalculationListeners(row) {
            const volumeInput = row.querySelector('.volume-input');
            const unitPriceInput = row.querySelector('.unit-price-input');
            const totalDisplay = row.querySelector('.total-price-display');

            function calculateRowTotal() {
                const volume = parseFloat(volumeInput.value) || 0;
                const unitPrice = parseFloat(unitPriceInput.value) || 0;
                const total = volume * unitPrice;
                
                totalDisplay.value = formatCurrency(total);
                updateTotals();
            }

            volumeInput.addEventListener('input', calculateRowTotal);
            unitPriceInput.addEventListener('input', calculateRowTotal);
        }

        function updateTotals() {
            let totalPersonil = 0;
            let totalNonPersonil = 0;

            // Calculate personil total
            document.querySelectorAll('[data-category="personil"] .volume-input').forEach((input, index) => {
                const row = input.closest('.pdk-detail-row');
                const volume = parseFloat(input.value) || 0;
                const unitPrice = parseFloat(row.querySelector('.unit-price-input').value) || 0;
                totalPersonil += volume * unitPrice;
            });

            // Calculate non personil total
            document.querySelectorAll('[data-category="non_personil"] .volume-input').forEach((input, index) => {
                const row = input.closest('.pdk-detail-row');
                const volume = parseFloat(input.value) || 0;
                const unitPrice = parseFloat(row.querySelector('.unit-price-input').value) || 0;
                totalNonPersonil += volume * unitPrice;
            });

            const grandTotal = totalPersonil + totalNonPersonil;

            // Update displays
            document.getElementById('totalPersonil').textContent = formatNumber(totalPersonil);
            document.getElementById('totalNonPersonil').textContent = formatNumber(totalNonPersonil);
            document.getElementById('grandTotal').textContent = formatNumber(grandTotal);
            document.getElementById('totalRequestInput').value = grandTotal;
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID').format(amount);
        }

        function formatNumber(amount) {
            return new Intl.NumberFormat('id-ID').format(amount);
        }

        // Initial calculation
        updateTotals();
        @endif

        // Form submission handler
        document.getElementById('supportRequestForm').addEventListener('submit', function(e) {
            const action = e.submitter.value;
            
            if (action === 'submit') {
                if (!confirm('Apakah Anda yakin ingin mengirim formulir ini untuk persetujuan? Setelah dikirim, formulir tidak dapat diedit lagi.')) {
                    e.preventDefault();
                    return;
                }
            }
        });
    </script>
</x-app-layout>
