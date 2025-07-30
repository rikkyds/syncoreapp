<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id();
            
            // Employee Information
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('employee_name'); // Nama Karyawan
            $table->string('nip_nik'); // NIP/NIK
            
            // Document Information
            $table->enum('document_type', [
                'kontrak_kerja',
                'sk_pengangkatan',
                'sk_mutasi',
                'sk_promosi',
                'sk_demosi',
                'surat_peringatan',
                'surat_teguran',
                'perjanjian_kerja',
                'addendum_kontrak',
                'surat_penugasan',
                'surat_izin',
                'surat_cuti',
                'surat_resign',
                'surat_phk',
                'sertifikat',
                'ijazah',
                'transkrip',
                'cv',
                'foto',
                'ktp',
                'kk',
                'npwp',
                'bpjs',
                'dokumen_lainnya'
            ]); // Jenis Dokumen
            
            $table->string('document_number')->nullable(); // Nomor Dokumen
            $table->date('issue_date'); // Tanggal Terbit Dokumen
            $table->date('effective_date'); // Tanggal Berlaku
            $table->date('expiry_date')->nullable(); // Tanggal Berakhir (jika ada)
            
            $table->string('signatory'); // Pihak Penandatangan
            
            $table->enum('document_status', [
                'aktif',
                'kadaluarsa',
                'diperbarui',
                'sedang_diproses',
                'draft',
                'ditolak',
                'dibatalkan',
                'arsip'
            ])->default('aktif'); // Status Dokumen
            
            $table->enum('storage_location', [
                'hardcopy',
                'drive_internal',
                'cloud_storage',
                'aplikasi_tertentu',
                'server_lokal',
                'email',
                'kombinasi'
            ])->default('hardcopy'); // Lokasi Penyimpanan Dokumen
            
            $table->string('file_path')->nullable(); // File Dokumen (Link/Path)
            $table->text('additional_notes')->nullable(); // Catatan Tambahan
            $table->timestamp('data_updated_at')->nullable(); // Tanggal Update Data
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index(['employee_id', 'document_type']);
            $table->index('document_status');
            $table->index(['effective_date', 'expiry_date']);
            $table->index('issue_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
    }
};
