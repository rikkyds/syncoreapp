<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            
            // Employee Information
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('employee_name'); // Nama Karyawan
            $table->string('nip_nik'); // NIP/NIK
            $table->string('position'); // Jabatan/Posisi
            $table->string('work_unit'); // Unit Kerja
            $table->enum('employee_status', [
                'tetap',
                'kontrak',
                'magang',
                'lepas',
                'paruh_waktu',
                'freelance'
            ]); // Status Karyawan
            
            // Salary Period
            $table->date('salary_date'); // Tanggal Gaji (periode)
            $table->string('salary_period'); // Format: "Juli 2025" untuk display
            
            // Salary Components
            $table->decimal('basic_salary', 15, 2); // Gaji Pokok
            $table->decimal('fixed_allowances', 15, 2)->default(0); // Tunjangan Tetap
            $table->decimal('variable_allowances', 15, 2)->default(0); // Tunjangan Tidak Tetap
            $table->decimal('deductions', 15, 2)->default(0); // Potongan
            $table->decimal('net_salary', 15, 2); // Total Gaji Bersih
            
            // Payment Information
            $table->enum('payment_method', [
                'transfer_bank',
                'tunai',
                'e_wallet',
                'cek',
                'giro'
            ])->default('transfer_bank'); // Metode Pembayaran
            
            $table->string('account_number')->nullable(); // Nomor Rekening
            
            $table->enum('payment_status', [
                'sudah_dibayar',
                'belum_dibayar',
                'gagal_bayar',
                'pending',
                'dibatalkan'
            ])->default('belum_dibayar'); // Status Pembayaran
            
            $table->date('payment_date')->nullable(); // Tanggal Pembayaran
            
            // Additional Information
            $table->text('notes')->nullable(); // Catatan HR atau Finance
            $table->timestamp('data_updated_at')->nullable(); // Tanggal Update Data
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index(['employee_id', 'salary_date']);
            $table->index('payment_status');
            $table->index('salary_date');
            $table->index(['work_unit', 'salary_date']);
            $table->unique(['employee_id', 'salary_date']); // Prevent duplicate salary for same period
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_salaries');
    }
};
