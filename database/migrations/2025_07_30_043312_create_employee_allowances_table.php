<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_allowances', function (Blueprint $table) {
            $table->id();
            
            // Employee Information
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('employee_name'); // Nama Karyawan
            $table->string('nip_nik'); // NIP/NIK
            $table->string('work_unit'); // Unit Kerja
            $table->string('position'); // Jabatan
            
            // Allowance Information
            $table->enum('allowance_type', [
                'tunjangan_tetap',
                'tunjangan_tidak_tetap',
                'tunjangan_transportasi',
                'tunjangan_makan',
                'tunjangan_kesehatan',
                'tunjangan_anak',
                'tunjangan_jabatan',
                'tunjangan_kinerja',
                'tunjangan_lembur',
                'tunjangan_khusus'
            ]); // Jenis Tunjangan
            
            $table->decimal('allowance_amount', 15, 2); // Jumlah Tunjangan
            
            $table->enum('payment_frequency', [
                'bulanan',
                'mingguan',
                'sekali',
                'tahunan',
                'per_proyek',
                'harian',
                'per_kehadiran'
            ])->default('bulanan'); // Frekuensi Pembayaran
            
            $table->enum('allowance_status', [
                'aktif',
                'tidak_aktif',
                'ditangguhkan',
                'sementara'
            ])->default('aktif'); // Status Tunjangan
            
            // Date Information
            $table->date('start_date'); // Tanggal Mulai Berlaku
            $table->date('end_date')->nullable(); // Tanggal Berakhir (opsional)
            
            // Terms and Conditions
            $table->text('terms_conditions')->nullable(); // Ketentuan & Syarat
            
            $table->enum('payment_method', [
                'bersamaan_gaji',
                'terpisah',
                'reimburse',
                'transfer_langsung',
                'tunai'
            ])->default('bersamaan_gaji'); // Metode Pembayaran
            
            $table->timestamp('data_updated_at')->nullable(); // Tanggal Update Data
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index(['employee_id', 'allowance_type']);
            $table->index('allowance_status');
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_allowances');
    }
};
