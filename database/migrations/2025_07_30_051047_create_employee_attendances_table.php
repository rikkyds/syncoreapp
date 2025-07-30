<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_attendances', function (Blueprint $table) {
            $table->id();
            
            // Employee Information
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('employee_name'); // Nama Karyawan
            $table->string('nip_nik'); // NIP/NIK
            
            // Attendance Information
            $table->date('attendance_date'); // Tanggal
            $table->time('time_in')->nullable(); // Jam Masuk
            $table->time('time_out')->nullable(); // Jam Keluar
            $table->integer('work_duration_minutes')->nullable(); // Durasi Kerja dalam menit
            
            $table->enum('attendance_status', [
                'hadir',
                'terlambat',
                'izin',
                'sakit',
                'cuti',
                'alpha',
                'lembur',
                'dinas_luar',
                'wfh',
                'setengah_hari',
                'pulang_cepat'
            ])->default('hadir'); // Status Kehadiran
            
            $table->enum('day_type', [
                'hari_kerja',
                'akhir_pekan',
                'hari_libur_nasional',
                'hari_libur_khusus',
                'hari_cuti_bersama'
            ])->default('hari_kerja'); // Jenis Hari
            
            $table->enum('work_location', [
                'kantor_pusat',
                'kantor_cabang',
                'wfh',
                'proyek',
                'dinas_luar',
                'client_site',
                'lapangan',
                'lainnya'
            ])->default('kantor_pusat'); // Lokasi Kerja
            
            $table->text('notes')->nullable(); // Keterangan/Alasan
            $table->string('supporting_document')->nullable(); // Bukti Pendukung (file path)
            
            $table->enum('attendance_method', [
                'gps',
                'selfie',
                'fingerprint',
                'rfid',
                'aplikasi',
                'manual',
                'qr_code',
                'face_recognition'
            ])->default('aplikasi'); // Metode Absensi
            
            $table->enum('supervisor_verification', [
                'pending',
                'approved',
                'rejected',
                'not_required'
            ])->default('not_required'); // Verifikasi Atasan
            
            $table->foreignId('employee_shift_id')->nullable()->constrained()->onDelete('set null'); // Shift Terkait
            $table->text('hrd_notes')->nullable(); // Catatan Khusus HRD
            $table->timestamp('attendance_input_date')->nullable(); // Tanggal Input Absensi
            $table->timestamp('data_updated_at')->nullable(); // Tanggal Update Data
            
            // Additional fields for multiple time-in/time-out support
            $table->json('time_logs')->nullable(); // JSON array untuk multiple time-in/time-out
            $table->decimal('latitude', 10, 8)->nullable(); // GPS coordinates
            $table->decimal('longitude', 11, 8)->nullable(); // GPS coordinates
            $table->string('device_info')->nullable(); // Device information
            $table->string('ip_address')->nullable(); // IP address for security
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index(['employee_id', 'attendance_date'], 'emp_att_emp_date_idx');
            $table->index('attendance_status', 'emp_att_status_idx');
            $table->index('attendance_date', 'emp_att_date_idx');
            $table->index(['work_location', 'attendance_date'], 'emp_att_loc_date_idx');
            $table->index('supervisor_verification', 'emp_att_supervisor_idx');
            $table->index(['employee_id', 'attendance_date', 'attendance_status'], 'emp_att_emp_date_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_attendances');
    }
};
