<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $supportRequest->type_label }} - {{ $supportRequest->request_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #007bff;
        }
        
        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            color: #007bff;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }
        
        .header-info {
            display: table;
            width: 100%;
            margin-top: 15px;
        }
        
        .header-info .left,
        .header-info .right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .section {
            margin: 20px 0;
        }
        
        .section-title {
            background: #007bff;
            color: white;
            padding: 8px 15px;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        .info-table th,
        .info-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        
        .info-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 25%;
        }
        
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 10pt;
        }
        
        .detail-table th,
        .detail-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        
        .detail-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        
        .detail-table .no-col {
            width: 5%;
            text-align: center;
        }
        
        .detail-table .currency {
            text-align: right;
        }
        
        .signature-section {
            margin-top: 40px;
            display: table;
            width: 100%;
        }
        
        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 20px;
            vertical-align: top;
        }
        
        .signature-box h4 {
            margin: 0 0 10px 0;
            color: #007bff;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            margin: 50px 20px 10px 20px;
            height: 1px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9pt;
            font-weight: bold;
            color: white;
        }
        
        .status-draft { background-color: #6c757d; }
        .status-submitted { background-color: #ffc107; color: #000; }
        .status-approved { background-color: #28a745; }
        .status-rejected { background-color: #dc3545; }
        .status-completed { background-color: #6f42c1; }
        
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .note {
            font-size: 9pt;
            color: #666;
            font-style: italic;
            margin-top: 20px;
            padding: 10px;
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ $supportRequest->type_label }}</h1>
        <div class="header-info">
            <div class="left">
                <strong>Nomor:</strong> {{ $supportRequest->request_number }}<br>
                <strong>Tanggal:</strong> {{ $supportRequest->request_date->format('d F Y') }}
            </div>
            <div class="right">
                <strong>Status:</strong> 
                <span class="status-badge status-{{ $supportRequest->status }}">
                    {{ $supportRequest->status_label }}
                </span><br>
                <strong>Pengaju:</strong> {{ $supportRequest->requesterEmployee->full_name ?? '-' }}
            </div>
        </div>
    </div>

    <!-- Informasi Proyek -->
    <div class="section">
        <div class="section-title">Informasi Proyek</div>
        <table class="info-table">
            <tr>
                <th>Nama Proyek</th>
                <td>{{ $supportRequest->project->project_name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Kode Proyek</th>
                <td>{{ $supportRequest->project->final_project_code ?? '-' }}</td>
            </tr>
            <tr>
                <th>Objective</th>
                <td>{{ $supportRequest->project->objective ?? '-' }}</td>
            </tr>
            <tr>
                <th>Program</th>
                <td>{{ $supportRequest->project->program_name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Kegiatan</th>
                <td>{{ $supportRequest->project->activity_name ?? '-' }}</td>
            </tr>
        </table>
    </div>

    @if($supportRequest->request_type === 'ppt' && $supportRequest->pptDetails->count() > 0)
    <!-- Detail PPT -->
    <div class="section">
        <div class="section-title">Detail Penugasan Tim (PPT)</div>
        <table class="detail-table">
            <thead>
                <tr>
                    <th class="no-col">No</th>
                    <th>Proses Bisnis</th>
                    <th>Fungsi</th>
                    <th>Peran</th>
                    <th>Karyawan</th>
                    <th>Tugas</th>
                    <th>Output</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($supportRequest->pptDetails as $index => $detail)
                <tr>
                    <td class="no-col">{{ $index + 1 }}</td>
                    <td>{{ $detail->business_process }}</td>
                    <td>{{ $detail->function_type }}</td>
                    <td>{{ $detail->role }}</td>
                    <td>{{ $detail->assignedEmployee->full_name ?? '-' }}</td>
                    <td>{{ $detail->task_description }}</td>
                    <td>{{ $detail->output_description }}</td>
                    <td>{{ $detail->start_date->format('d/m/Y') }} - {{ $detail->end_date->format('d/m/Y') }}</td>
                    <td>{{ $detail->location }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($supportRequest->request_type === 'pdk' && $supportRequest->pdkDetails->count() > 0)
    <!-- Detail PDK -->
    <div class="section">
        <div class="section-title">Detail Dukungan Keuangan (PDK)</div>
        
        @php
            $personilDetails = $supportRequest->pdkDetails->where('cost_category', 'personil');
            $nonPersonilDetails = $supportRequest->pdkDetails->where('cost_category', 'non_personil');
        @endphp

        @if($personilDetails->count() > 0)
        <h4>Biaya Langsung Personil</h4>
        <table class="detail-table">
            <thead>
                <tr>
                    <th class="no-col">No</th>
                    <th>Kegiatan</th>
                    <th>Deskripsi</th>
                    <th>Volume</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($personilDetails as $index => $detail)
                <tr>
                    <td class="no-col">{{ $index + 1 }}</td>
                    <td>{{ $detail->activity_name }}</td>
                    <td>{{ $detail->description }}</td>
                    <td class="currency">{{ number_format($detail->volume, 2, ',', '.') }}</td>
                    <td>{{ $detail->unit }}</td>
                    <td class="currency">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                    <td class="currency">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="6"><strong>Sub Total Biaya Personil</strong></td>
                    <td class="currency"><strong>Rp {{ number_format($personilDetails->sum('total_price'), 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
        @endif

        @if($nonPersonilDetails->count() > 0)
        <h4>Biaya Non Personil</h4>
        <table class="detail-table">
            <thead>
                <tr>
                    <th class="no-col">No</th>
                    <th>Kegiatan</th>
                    <th>Deskripsi</th>
                    <th>Volume</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nonPersonilDetails as $index => $detail)
                <tr>
                    <td class="no-col">{{ $index + 1 }}</td>
                    <td>{{ $detail->activity_name }}</td>
                    <td>{{ $detail->description }}</td>
                    <td class="currency">{{ number_format($detail->volume, 2, ',', '.') }}</td>
                    <td>{{ $detail->unit }}</td>
                    <td class="currency">Rp {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                    <td class="currency">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="6"><strong>Sub Total Biaya Non Personil</strong></td>
                    <td class="currency"><strong>Rp {{ number_format($nonPersonilDetails->sum('total_price'), 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
        @endif

        <!-- Summary Budget -->
        <div class="section">
            <div class="section-title">Ringkasan Anggaran</div>
            <table class="info-table">
                <tr>
                    <th>Total Pengajuan</th>
                    <td class="currency">Rp {{ number_format($supportRequest->total_request, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Anggaran Program</th>
                    <td class="currency">Rp {{ number_format($supportRequest->program_budget, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Kontribusi</th>
                    <td class="currency">Rp {{ number_format($supportRequest->contribution, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Sisa Anggaran</th>
                    <td class="currency">Rp {{ number_format($supportRequest->remaining_budget, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Termasuk Pajak</th>
                    <td>{{ $supportRequest->tax_included ? 'Ya' : 'Tidak' }}</td>
                </tr>
            </table>
            @if($supportRequest->budget_notes)
            <p><strong>Catatan Anggaran:</strong><br>{{ $supportRequest->budget_notes }}</p>
            @endif
        </div>
    </div>
    @endif

    <!-- Status & Approval -->
    @if($supportRequest->status !== 'draft')
    <div class="section">
        <div class="section-title">Status & Persetujuan</div>
        <table class="info-table">
            @if($supportRequest->approved_at)
            <tr>
                <th>Disetujui Oleh</th>
                <td>{{ $supportRequest->approvedByEmployee->full_name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Disetujui</th>
                <td>{{ $supportRequest->approved_at->format('d F Y H:i') }}</td>
            </tr>
            @endif
            @if($supportRequest->rejection_reason)
            <tr>
                <th>Alasan Penolakan</th>
                <td>{{ $supportRequest->rejection_reason }}</td>
            </tr>
            @endif
        </table>
    </div>
    @endif

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-box">
            <h4>Yang Mengajukan</h4>
            <div class="signature-line"></div>
            <div>{{ $supportRequest->requesterEmployee->full_name ?? '-' }}</div>
            <div style="font-size: 9pt; color: #666;">
                {{ $supportRequest->requesterEmployee->position->name ?? 'Pengaju' }}
            </div>
        </div>
        
        <div class="signature-box">
            <h4>Menyetujui</h4>
            <div class="signature-line"></div>
            <div>
                @if($supportRequest->approvedByEmployee)
                    {{ $supportRequest->approvedByEmployee->full_name }}
                @else
                    ( _________________ )
                @endif
            </div>
            <div style="font-size: 9pt; color: #666;">
                @if($supportRequest->approvedByEmployee)
                    {{ $supportRequest->approvedByEmployee->position->name ?? 'Penyetuju' }}
                @else
                    Nama & Jabatan Penyetuju
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="note">
        <strong>Keterangan:</strong><br>
        Dokumen ini digenerate secara otomatis dari sistem pada {{ now()->format('d F Y H:i') }} WIB.<br>
        <strong>SYNCORE INDONESIA GROUP - Project Management System</strong>
    </div>
</body>
</html>
