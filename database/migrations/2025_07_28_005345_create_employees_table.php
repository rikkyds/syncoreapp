<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // Personal Information
            $table->string('full_name');
            $table->string('nik')->unique(); // Nomor Induk Kependudukan
            $table->string('ktp_photo')->nullable();
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->text('address');
            $table->string('phone_number');
            $table->string('personal_email');
            
            // Insurance & Financial Information
            $table->string('bpjs_health')->nullable();
            $table->string('bpjs_health_photo')->nullable();
            $table->string('bpjs_employment')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('npwp')->nullable();
            $table->string('npwp_photo')->nullable();
            
            // Company Information
            $table->string('employee_id')->unique(); // NIP
            $table->foreignId('work_unit_id')->constrained()->onDelete('restrict');
            $table->foreignId('position_id')->constrained()->onDelete('restrict');
            $table->enum('employment_status', ['permanent', 'contract', 'probation', 'intern']);
            $table->date('join_date');
            
            // Relations to other tables
            $table->foreignId('company_id')->constrained()->onDelete('restrict');
            $table->foreignId('branch_office_id')->constrained()->onDelete('restrict');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
