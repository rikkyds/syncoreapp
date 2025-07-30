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
        Schema::create('employee_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'expert']);
            $table->text('notes')->nullable();
            $table->string('certificate')->nullable(); // Path to skill certificate if any
            $table->timestamps();
            $table->softDeletes();
            
            // Ensure unique combination of employee and skill
            $table->unique(['employee_id', 'skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_skills');
    }
};
