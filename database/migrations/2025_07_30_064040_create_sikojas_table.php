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
        Schema::create('sikojas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            
            // Informasi SIKOJA
            $table->string('sikoja_number')->unique(); // Auto-generated SIKOJA number
            $table->date('sikoja_date'); // Tanggal SIKOJA dibuat
            $table->string('unit_code')->default('211'); // Kode unit (BUMDES.id)
            
            // Ringkasan Kegiatan - Detail yang bisa diubah
            $table->text('situation_description')->nullable(); // Situasi (bisa custom)
            $table->text('output_description')->nullable(); // Output yang diharapkan
            $table->date('start_date')->nullable(); // Tanggal mulai kegiatan
            $table->date('end_date')->nullable(); // Tanggal selesai kegiatan
            $table->string('location')->nullable(); // Lokasi kegiatan
            
            // Anggaran
            $table->decimal('budget_amount', 15, 2)->nullable(); // Jumlah anggaran
            $table->string('budget_currency', 3)->default('IDR'); // Mata uang
            $table->boolean('budget_include_tax')->default(false); // Sudah termasuk pajak atau belum
            $table->text('budget_notes')->nullable(); // Catatan anggaran
            
            // Jenis Kerjasama
            $table->enum('cooperation_type', ['mou', 'spk', 'cl_loa', 'other'])->nullable();
            $table->string('cooperation_other')->nullable(); // Jika pilih "other"
            $table->string('cooperation_number')->nullable(); // Nomor dokumen kerjasama
            $table->date('cooperation_date')->nullable(); // Tanggal dokumen kerjasama
            
            // Verifikasi
            $table->boolean('verified_by_pmo')->default(false);
            $table->foreignId('pmo_verifier_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->timestamp('pmo_verified_at')->nullable();
            $table->text('pmo_notes')->nullable();
            
            $table->boolean('verified_by_finance')->default(false);
            $table->foreignId('finance_verifier_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->timestamp('finance_verified_at')->nullable();
            $table->text('finance_notes')->nullable();
            
            $table->boolean('verified_by_other')->default(false);
            $table->string('other_verifier_type')->nullable(); // Jenis verifikator lain
            $table->foreignId('other_verifier_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->timestamp('other_verified_at')->nullable();
            $table->text('other_notes')->nullable();
            
            // Status SIKOJA
            $table->enum('status', ['draft', 'pending_verification', 'partially_verified', 'fully_verified', 'rejected'])->default('draft');
            $table->text('rejection_reason')->nullable();
            
            // Metadata
            $table->foreignId('created_by')->constrained('employees')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('employees')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['project_id', 'status']);
            $table->index('sikoja_number');
            $table->index('sikoja_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sikojas');
    }
};
