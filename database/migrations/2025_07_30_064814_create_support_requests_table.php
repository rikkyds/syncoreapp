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
        Schema::create('support_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            
            // Informasi Pengajuan
            $table->enum('request_type', ['ppt', 'pdh', 'pds', 'pdd', 'pdk']); // PPT, PDH, PDS, PDD, PDK
            $table->string('request_number')->unique(); // Auto-generated request number
            $table->date('request_date'); // Tanggal pengajuan
            $table->foreignId('requester_employee_id')->constrained('employees')->onDelete('cascade');
            
            // Status
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected', 'completed'])->default('draft');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('employees')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            
            // Metadata
            $table->foreignId('created_by')->constrained('employees')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('employees')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['project_id', 'request_type']);
            $table->index('request_number');
            $table->index(['request_type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_requests');
    }
};
