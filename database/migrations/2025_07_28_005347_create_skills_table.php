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
        Schema::dropIfExists('skills');
        Schema::dropIfExists('skill_categories');
    }
};
