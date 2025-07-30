<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_shifts', function (Blueprint $table) {
            $table->id();
            
            // Employee Information
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('employee_name'); // Nama Karyawan
            $table->string('nip_nik'); // NIP/NIK
            
            // Shift Information
            $table->date('shift_date'); // Tanggal
            $table->string('shift_name'); // Shift (A, B, C, dll)
            $table->time('start_time'); // Jam Mulai Kerja
            $table->time('end_time'); // Jam Selesai Kerja
            $table->decimal('shift_duration', 4, 2); // Durasi Shift (dalam jam)
            
            // Work Location
            $table->string('work_location'); // Lokasi Kerja
            
            // Attendance Status
            $table->enum('attendance_status', [
                'hadir', 
                'izin', 
                'sakit', 
                'alpha', 
                'terlambat',
                'pulang_cepat'
            ])->default('hadir'); // Status Kehadiran
            
            // Work Day Type
            $table->enum('work_day_type', [
                'hari_biasa',
                'akhir_pekan', 
                'hari_libur',
                'lembur',
                'hari_khusus'
            ])->default('hari_biasa'); // Jenis Hari Kerja
            
            // Supervisor Information
            $table->string('supervisor_name'); // Nama Atasan/PIC
            
            // Additional Information
            $table->text('shift_notes')->nullable(); // Catatan Shift
            $table->timestamp('data_updated_at')->nullable(); // Tanggal Update
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index(['employee_id', 'shift_date']);
            $table->index('shift_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_shifts');
    }
};
