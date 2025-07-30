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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            
            // 1. Informasi Umum
            $table->date('submission_date');
            $table->foreignId('submitter_employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('submitter_position_id')->constrained('positions')->onDelete('cascade');
            $table->foreignId('initiator_employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('initiator_position_id')->constrained('positions')->onDelete('cascade');
            
            // 2. Detail Program dan Proyek
            $table->text('objective');
            $table->string('program_name');
            $table->string('program_code');
            $table->string('activity_name');
            $table->string('activity_code');
            $table->string('project_name');
            $table->integer('project_sequence_number');
            $table->string('final_project_code'); // auto generate dari nomor + kode kegiatan
            $table->integer('target');
            $table->integer('specific_target');
            $table->integer('current_achievement')->default(0);
            $table->text('key_result');
            
            // 3. Kebutuhan Pengajuan (checkbox)
            $table->boolean('need_team_assignment')->default(false); // PPT
            $table->boolean('need_hrd_support')->default(false); // PDH
            $table->boolean('need_facility_support')->default(false); // PDS
            $table->boolean('need_digitalization_support')->default(false); // PDD
            $table->boolean('need_financial_support')->default(false); // PDK
            
            // 4. Catatan Tambahan
            $table->text('additional_notes')->nullable();
            
            // 5. Lampiran Dokumen
            $table->string('proposal_document')->nullable();
            $table->string('proposal_document_original_name')->nullable();
            $table->string('evidence_document')->nullable();
            $table->string('evidence_document_original_name')->nullable();
            
            // Status dan tracking (Updated: pending instead of submitted)
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'in_progress', 'completed'])->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('employees')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['status', 'submission_date']);
            $table->index(['submitter_employee_id', 'status']);
            $table->index(['program_code', 'activity_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
