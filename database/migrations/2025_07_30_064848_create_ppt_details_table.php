<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ppt_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_request_id')->constrained()->onDelete('cascade');
            
            // Proses Bisnis Detail
            $table->string('business_process'); // Consulting, Event, dll
            $table->string('function_type'); // Fungsi Implementator, Fungsi Administrasi
            $table->string('role'); // Narasumber, PIC Administrasi
            $table->foreignId('assigned_employee_id')->constrained('employees')->onDelete('cascade');
            $table->text('task_description'); // Deskripsi tugas
            $table->text('output_description'); // Output yang diharapkan
            $table->date('start_date'); // Tanggal mulai
            $table->date('end_date')->nullable(); // Tanggal selesai (optional)
            $table->string('location'); // Lokasi
            $table->text('notes')->nullable(); // Catatan tambahan
            
            // Status per item
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('completion_notes')->nullable(); // Catatan penyelesaian
            $table->timestamp('completed_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['support_request_id', 'assigned_employee_id']);
            $table->index(['start_date', 'end_date']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppt_details');
    }
};
