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
        Schema::table('support_requests', function (Blueprint $table) {
            // Ringkasan Pengajuan (khusus untuk PDK)
            $table->decimal('total_request', 15, 2)->nullable()->after('approved_at'); // Total pengajuan
            $table->decimal('program_budget', 15, 2)->nullable(); // Anggaran program
            $table->decimal('contribution', 15, 2)->nullable(); // Kontribusi
            $table->decimal('remaining_budget', 15, 2)->nullable(); // Sisa anggaran (diisi verifikator)
            $table->text('budget_notes')->nullable(); // Catatan anggaran
            $table->boolean('tax_included')->default(false); // Sudah termasuk pajak atau belum
            
            // Verifikasi khusus keuangan
            $table->foreignId('finance_verifier_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->timestamp('finance_verified_at')->nullable();
            $table->text('finance_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('support_requests', function (Blueprint $table) {
            $table->dropColumn([
                'total_request',
                'program_budget', 
                'contribution',
                'remaining_budget',
                'budget_notes',
                'tax_included',
                'finance_verifier_id',
                'finance_verified_at',
                'finance_notes'
            ]);
        });
    }
};
