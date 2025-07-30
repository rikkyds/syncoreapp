<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir SIKOJA - {{ $project->final_project_code }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
            color: #000;
            background-color: #fff;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #007bff;
        }
        
        .header h1 {
            font-size: 24pt;
            font-weight: bold;
            color: #007bff;
            margin: 0 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .header-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 15px;
            font-size: 10pt;
        }
        
        .header-info div {
            text-align: left;
        }
        
        .header-info strong {
            color: #007bff;
        }
        
        .section {
            margin: 25px 0;
        }
        
        .section-title {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 8px 15px;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }
        
        .section-title::before {
            content: "🔹";
            margin-right: 8px;
            font-size: 14pt;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 10pt;
        }
        
        .info-table th,
        .info-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            vertical-align: top;
        }
        
        .info-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 25%;
            color: #495057;
        }
        
        .info-table td {
            background-color: #fff;
        }
        
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 10pt;
        }
        
        .summary-table th,
        .summary-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        
        .summary-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        
        .summary-table .no-col {
            width: 5%;
            text-align: center;
            font-weight: bold;
        }
        
        .summary-table .desc-col {
            width: 20%;
            font-weight: bold;
            background-color: #f8f9fa;
        }
        
        .signature-section {
            margin-top: 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }
        
        .signature-box {
            text-align: center;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
        
        .signature-box h4 {
            margin: 0 0 10px 0;
            color: #007bff;
            font-size: 11pt;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            margin: 50px 20px 10px 20px;
            height: 1px;
        }
        
        .signature-name {
            font-weight: bold;
            margin-top: 5px;
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
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .print-button:hover {
            background: #218838;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 10px;
            }
            
            .container {
                box-shadow: none;
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
            
            .section {
                page-break-inside: avoid;
            }
        }
        
        .highlight {
            background-color: #fff3cd;
            padding: 2px 4px;
            border-radius: 3px;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 9pt;
            font-weight: bold;
            border-radius: 12px;
            color: white;
            background-color: #007bff;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <button class="print-button no-print" onclick="window.print()">🖨️ Cetak SIKOJA</button>
    
    <div class="container">
        <!-- Header Formulir -->
        <div class="header">
            <h1>Formulir SIKOJA</h1>
            <div class="header-info">
                <div>
                    <strong>Nomor Pengajuan:</strong> {{ $project->final_project_code }}<br>
                    <strong>Tanggal Pengajuan:</strong> {{ $project->submission_date->format('d F Y') }}
                </div>
                <div>
                    <strong>Yang Mengajukan:</strong> {{ $project->initiator->full_name }}<br>
                    <strong>Kode Proyek:</strong> <span class="highlight">{{ $project->final_project_code }}</span>
                </div>
            </div>
        </div>
        
        <!-- Informasi Detail -->
        <div class="section">
            <div class="section-title">Informasi Detail</div>
            <table class="info-table">
                <tr>
                    <th>Objective</th>
                    <td>{{ $project->objective }}</td>
                </tr>
                <tr>
                    <th>Unit</th>
                    <td>BUMDES.id (211)</td>
                </tr>
                <tr>
                    <th>Program</th>
                    <td>{{ $project->program_name }} ({{ $project->program_code }})</td>
                </tr>
                <tr>
                    <th>Kegiatan</th>
                    <td>{{ $project->activity_name }} ({{ $project->activity_code }})</td>
                </tr>
                <tr>
                    <th>Proyek</th>
                    <td>{{ $project->project_name }} ({{ $project->final_project_code }})</td>
                </tr>
                <tr>
                    <th>Key Result</th>
                    <td>{{ $project->key_result }} <span class="badge">Target {{ $project->current_achievement }} dari {{ $project->target }}</span></td>
                </tr>
            </table>
        </div>
        
        <!-- Ringkasan Kegiatan -->
        <div class="section">
            <div class="section-title">Ringkasan Kegiatan</div>
            <table class="summary-table">
                <thead>
                    <tr>
                        <th class="no-col">No</th>
                        <th class="desc-col">Keterangan</th>
                        <th>Uraian</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="no-col">1</td>
                        <td class="desc-col">Situasi</td>
                        <td>
                            Proyek {{ $project->project_name }} merupakan bagian dari program {{ $project->program_name }} 
                            yang bertujuan untuk {{ strtolower($project->objective) }}. Kegiatan ini dilaksanakan 
                            sebagai upaya mencapai target {{ number_format($project->target) }} sesuai dengan key result yang telah ditetapkan.
                        </td>
                    </tr>
                    <tr>
                        <td class="no-col">2</td>
                        <td class="desc-col">Identitas</td>
                        <td>
                            <strong>Pengaju:</strong> {{ $project->submitter->full_name }} ({{ $project->submitterPosition->name }})<br>
                            <strong>Inisiator:</strong> {{ $project->initiator->full_name }} ({{ $project->initiatorPosition->name }})<br>
                            <strong>Unit:</strong> BUMDES.id - Syncore Indonesia Group
                        </td>
                    </tr>
                    <tr>
                        <td class="no-col">3</td>
                        <td class="desc-col">Kebutuhan</td>
                        <td>
                            @if($project->support_needs && count($project->support_needs) > 0)
                                @foreach($project->support_needs as $need)
                                    • {{ $need }}<br>
                                @endforeach
                            @else
                                Tidak ada kebutuhan khusus yang diajukan
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="no-col">4</td>
                        <td class="desc-col">Output</td>
                        <td>
                            • Laporan pelaksanaan kegiatan<br>
                            • Dokumentasi foto dan video<br>
                            • Summary hasil kegiatan<br>
                            • Minutes of Meeting (MoM)<br>
                            • Branding materials (Story/Reels Instagram)<br>
                            @if($project->proposal_document)
                            • Dokumen proposal: {{ $project->proposal_document_original_name }}<br>
                            @endif
                            @if($project->evidence_document)
                            • Dokumen bukti: {{ $project->evidence_document_original_name }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="no-col">5</td>
                        <td class="desc-col">Jadwal</td>
                        <td>
                            <strong>Tanggal Pengajuan:</strong> {{ $project->submission_date->format('d F Y') }}<br>
                            <strong>Status:</strong> 
                            <span class="badge" style="background-color: 
                                @if($project->status == 'approved') #28a745
                                @elseif($project->status == 'rejected') #dc3545
                                @elseif($project->status == 'in_progress') #007bff
                                @elseif($project->status == 'completed') #6f42c1
                                @else #ffc107; color: #000
                                @endif">
                                {{ $project->status_label }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="no-col">6</td>
                        <td class="desc-col">Anggaran</td>
                        <td>
                            <em>Informasi anggaran akan diisi sesuai dengan kebutuhan proyek</em><br>
                            <small>*) Belum termasuk pajak dan biaya administrasi</small>
                        </td>
                    </tr>
                    <tr>
                        <td class="no-col">7</td>
                        <td class="desc-col">Jenis Kerjasama</td>
                        <td>
                            ☐ MOU (Memorandum of Understanding)<br>
                            ☐ SPK (Surat Perintah Kerja)<br>
                            ☐ CL/LoA (Contract Letter/Letter of Agreement)<br>
                            ☐ Lainnya: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>
                            <small>Nomor: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        @if($project->additional_notes)
        <!-- Catatan Tambahan -->
        <div class="section">
            <div class="section-title">Catatan Tambahan</div>
            <div style="padding: 15px; background-color: #f8f9fa; border-left: 4px solid #007bff; border-radius: 0 5px 5px 0;">
                {{ $project->additional_notes }}
            </div>
        </div>
        @endif
        
        <!-- Tanda Tangan & Verifikasi -->
        <div class="section">
            <div class="section-title">Tanda Tangan & Verifikasi</div>
            <div class="signature-section">
                <div class="signature-box">
                    <h4>Yang Mengajukan</h4>
                    <div class="signature-line"></div>
                    <div class="signature-name">( {{ $project->submitter->full_name }} )</div>
                    <div style="font-size: 9pt; color: #666; margin-top: 5px;">
                        {{ $project->submitterPosition->name }}
                    </div>
                </div>
                
                <div class="signature-box">
                    <h4>Verifikasi</h4>
                    <div style="text-align: left; margin-bottom: 20px; font-size: 10pt;">
                        ☐ PMO (Project Management Office)<br>
                        ☐ Keuangan<br>
                        ☐ Lainnya: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    </div>
                    <div class="signature-line"></div>
                    <div class="signature-name">
                        @if($project->approver)
                            ( {{ $project->approver->full_name }} )
                            <div style="font-size: 9pt; color: #666; margin-top: 5px;">
                                {{ $project->approver->position->name ?? 'Verifikator' }}
                            </div>
                        @else
                            ( _________________ )
                            <div style="font-size: 9pt; color: #666; margin-top: 5px;">
                                Nama & Jabatan Verifikator
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Note -->
        <div class="note">
            <strong>Keterangan:</strong> (*) diisi oleh verifikator.<br>
            Formulir ini digenerate secara otomatis dari sistem Project Management pada {{ now()->format('d F Y H:i') }} WIB.
        </div>
        
        <!-- Footer -->
        <div style="margin-top: 30px; text-align: center; font-size: 9pt; color: #666; border-top: 1px solid #ddd; padding-top: 15px;">
            <strong>SYNCORE INDONESIA GROUP - BUMDES.ID</strong><br>
            Project Management System | SIKOJA (Sistem Informasi Koordinasi Kegiatan)
        </div>
    </div>
    
    <script>
        // Auto print when opened with print parameter
        if (window.location.search.includes('print=1')) {
            window.onload = function() {
                window.print();
            }
        }
    </script>
</body>
</html>
