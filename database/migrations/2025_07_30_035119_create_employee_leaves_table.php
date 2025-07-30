<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->id();
            
            // Employee Information
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('full_name'); // Nama Lengkap
            $table->string('nip_nik'); // NIP/NIK
            
            // Leave Information
            $table->enum('leave_type', [
                'annual', 
                'sick', 
                'maternity', 
                'paternity', 
                'special', 
                'unpaid', 
                'emergency'
            ]); // Jenis Cuti
            $table->date('application_date'); // Tanggal Pengajuan
            $table->date('start_date'); // Tanggal Mulai
            $table->date('end_date'); // Tanggal Berakhir
            $table->integer('duration_days'); // Durasi Cuti (hari)
            
            // Approval Information
            $table->enum('status', [
                'pending', 
                'approved', 
                'rejected'
            ])->default('pending'); // Status Pengajuan
            $table->string('supervisor_name'); // Nama Atasan
            
            // Leave Balance
            $table->integer('remaining_leave_balance')->nullable(); // Sisa Cuti Terakhir
            
            // Additional Information
            $table->text('leave_reason')->nullable(); // Alasan Cuti
            $table->date('return_to_work_date')->nullable(); // Tanggal Kembali Bekerja
            $table->string('supporting_document')->nullable(); // Dokumen Pendukung
            $table->timestamp('data_updated_at')->nullable(); // Tanggal Update Data
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_leaves');
    }
};
