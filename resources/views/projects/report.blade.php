<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengajuan Proyek - {{ $project->final_project_code }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
        }
        
        .company-name {
            font-size: 18pt;
            font-weight: bold;
            margin: 5px 0;
        }
        
        .company-subtitle {
            font-size: 14pt;
            margin: 5px 0;
        }
        
        .document-title {
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
            margin: 30px 0 20px;
            text-decoration: underline;
        }
        
        .identity-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .identity-table td {
            padding: 8px;
            border: 1px solid #000;
            vertical-align: top;
        }
        
        .identity-table .label {
            background-color: #f0f0f0;
            font-weight: bold;
            width: 30%;
        }
        
        .detail-section {
            margin: 20px 0;
        }
        
        .detail-section h3 {
            font-size: 14pt;
            font-weight: bold;
            margin: 15px 0 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }
        
        .content-text {
            text-align: justify;
            margin: 15px 0;
            line-height: 1.8;
        }
        
        .support-list {
            margin: 15px 0;
            padding-left: 20px;
        }
        
        .support-list li {
            margin: 5px 0;
        }
        
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            margin: 60px 0 10px;
            height: 1px;
        }
        
        .status-box {
            border: 2px solid #000;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        
        .status-approved {
            background-color: #d4edda;
            border-color: #28a745;
        }
        
        .status-rejected {
            background-color: #f8d7da;
            border-color: #dc3545;
        }
        
        .status-pending {
            background-color: #fff3cd;
            border-color: #ffc107;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <button class="print-button no-print" onclick="window.print()">🖨️ Cetak</button>
    
    <!-- 1. Header Surat -->
    <div class="header">
        <div class="logo">
            <!-- Logo placeholder - bisa diganti dengan logo actual -->
            <div style="width: 80px; height: 80px; border: 2px solid #000; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                LOGO
            </div>
        </div>
        <div class="company-name">SYNCORE INDONESIA GROUP</div>
        <div class="company-subtitle">BUMDES.ID</div>
        <div style="font-size: 10pt; margin-top: 5px;">
            Jl. Contoh Alamat No. 123, Kota, Provinsi 12345<br>
            Telp: (021) 1234-5678 | Email: info@syncore.id
        </div>
    </div>
    
    <!-- Document Title -->
    <div class="document-title">
        SURAT PENGAJUAN KEGIATAN
    </div>
    
    <!-- 2. Identitas Pengajuan -->
    <table class="identity-table">
        <tr>
            <td class="label">Nomor Proyek</td>
            <td>{{ $project->final_project_code }}</td>
        </tr>
        <tr>
            <td class="label">Judul Kegiatan</td>
            <td>{{ $project->project_name }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td>{{ $project->submission_date->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Pengaju</td>
            <td>{{ $project->submitter->full_name }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan Pengaju</td>
            <td>{{ $project->submitterPosition->name }}</td>
        </tr>
        <tr>
            <td class="label">Inisiator</td>
            <td>{{ $project->initiator->full_name }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan Inisiator</td>
            <td>{{ $project->initiatorPosition->name }}</td>
        </tr>
    </table>
    
    <!-- 3. Detail Proyek -->
    <div class="detail-section">
        <h3>DETAIL PROYEK</h3>
        
        <p><strong>Perihal:</strong> Pengajuan Kegiatan {{ $project->project_name }}</p>
        
        <p><strong>Objective:</strong> {{ $project->objective }}</p>
        
        <p><strong>Program:</strong> {{ $project->program_name }} ({{ $project->program_code }})</p>
        
        <p><strong>Kegiatan:</strong> {{ $project->activity_name }} ({{ $project->activity_code }})</p>
        
        <p><strong>Key Result:</strong> {{ $project->key_result }}</p>
        
        <p><strong>Target:</strong> {{ number_format($project->target) }}</p>
        
        <p><strong>Target Spesifik:</strong> {{ number_format($project->specific_target) }}</p>
        
        @if($project->current_achievement > 0)
        <p><strong>Capaian Saat Ini:</strong> {{ number_format($project->current_achievement) }} ({{ $project->progress_percentage }}%)</p>
        @endif
    </div>
    
    <!-- 4. Isi Surat Pengajuan -->
    <div class="detail-section">
        <h3>ISI SURAT PENGAJUAN</h3>
        
        <div class="content-text">
            Dengan hormat, sehubungan dengan pelaksanaan kegiatan 
            <strong>{{ $project->project_name }} ({{ $project->final_project_code }})</strong> 
            yang akan dilaksanakan pada {{ $project->submission_date->format('d F Y') }}, 
            maka dengan ini saya mengajukan permohonan:
        </div>
        
        @if($project->support_needs && count($project->support_needs) > 0)
        <ul class="support-list">
            @foreach($project->support_needs as $need)
            <li>{{ $need }}</li>
            @endforeach
        </ul>
        @endif
        
        @if($project->additional_notes)
        <div class="content-text">
            <strong>Catatan Tambahan:</strong><br>
            {{ $project->additional_notes }}
        </div>
        @endif
        
        <div class="content-text">
            Demikian pengajuan ini saya buat, mohon untuk dapat ditindaklanjuti. 
            Atas perhatiannya saya ucapkan terima kasih.
        </div>
    </div>
    
    <!-- 5. Status dan Tanda Tangan -->
    <div class="detail-section">
        <h3>STATUS PENGAJUAN</h3>
        
        <div class="status-box 
            @if($project->status == 'approved') status-approved
            @elseif($project->status == 'rejected') status-rejected  
            @else status-pending
            @endif">
            <strong>STATUS: 
                @if($project->status == 'approved') 
                    DISETUJUI
                @elseif($project->status == 'rejected')
                    DITOLAK
                @else
                    MENUNGGU PERSETUJUAN
                @endif
            </strong>
            
            @if($project->status == 'approved' && $project->approved_at)
                <br><small>Disetujui pada: {{ $project->approved_at->format('d F Y H:i') }}</small>
            @endif
            
            @if($project->status == 'rejected' && $project->rejection_reason)
                <br><small>Alasan: {{ $project->rejection_reason }}</small>
            @endif
        </div>
    </div>
    
    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-box">
            <div><strong>Inisiator</strong></div>
            <div class="signature-line"></div>
            <div>{{ $project->initiator->full_name }}</div>
            <div><small>{{ $project->initiatorPosition->name }}</small></div>
        </div>
        
        <div class="signature-box">
            <div><strong>
                @if($project->status == 'approved' || $project->status == 'rejected')
                    Otorisator
                @else
                    Menunggu Persetujuan
                @endif
            </strong></div>
            <div class="signature-line"></div>
            <div>
                @if($project->approver)
                    {{ $project->approver->full_name }}
                    <br><small>{{ $project->approver->position->name ?? 'Admin' }}</small>
                @else
                    ___________________
                    <br><small>Nama & Jabatan</small>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div style="margin-top: 50px; text-align: center; font-size: 10pt; color: #666;">
        <hr style="border: 1px solid #ccc; margin: 20px 0;">
        Dokumen ini digenerate secara otomatis pada {{ now()->format('d F Y H:i') }} WIB<br>
        Syncore Indonesia Group - Project Management System
    </div>
    
    <script>
        // Auto print when opened in new window
        if (window.location.search.includes('print=1')) {
            window.onload = function() {
                window.print();
            }
        }
    </script>
</body>
</html>
