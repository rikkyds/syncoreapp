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
        Schema::create('pdk_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_request_id')->constrained()->onDelete('cascade');
            
            // Kategori Biaya
            $table->enum('cost_category', ['personil', 'non_personil']); // Biaya Langsung Personil atau Non Personil
            $table->string('activity_name'); // Nama kegiatan/item
            $table->text('description'); // Rincian detail
            $table->decimal('volume', 10, 2); // Volume/jumlah
            $table->string('unit'); // Satuan (OS, OH, MH, paket, dll)
            $table->decimal('unit_price', 15, 2); // Harga per satuan
            $table->decimal('total_price', 15, 2); // Total harga (volume x unit_price)
            
            // Metadata
            $table->integer('sort_order')->default(0); // Urutan tampilan
            $table->text('notes')->nullable(); // Catatan tambahan
            
            $table->timestamps();
            
            // Indexes
            $table->index(['support_request_id', 'cost_category']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdk_details');
    }
};
