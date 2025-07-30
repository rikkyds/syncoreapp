<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('skill_category_id')->constrained()->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('employee_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced', 'expert']);
            $table->text('notes')->nullable();
            $table->string('certificate')->nullable(); // Path to skill certificate if any
            $table->timestamps();
            $table->softDeletes();
        });

        // Seed skill categories
        DB::table('skill_categories')->insert([
            ['name' => 'Technical Skills'],
            ['name' => 'Soft Skills'],
            ['name' => 'Language Skills'],
            ['name' => 'Computer Skills'],
            ['name' => 'Management Skills'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_skills');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('skill_categories');
    }
};
