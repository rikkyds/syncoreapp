<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->timestamps();
        });

        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('education_level_id')->constrained('education_levels')->onDelete('restrict');
            $table->string('institution_name');
            $table->string('major')->nullable(); // Program studi/jurusan
            $table->string('city');
            $table->string('country')->default('Indonesia');
            $table->year('start_year');
            $table->year('end_year')->nullable();
            $table->string('degree')->nullable(); // Gelar akademik
            $table->enum('status', ['graduated', 'not_graduated', 'ongoing']);
            $table->decimal('gpa', 3, 2)->nullable(); // IPK
            $table->string('certificate')->nullable(); // Path to certificate file
            $table->timestamps();
            $table->softDeletes();
        });

        // Seed education levels
        DB::table('education_levels')->insert([
            ['name' => 'Elementary School', 'code' => 'SD'],
            ['name' => 'Junior High School', 'code' => 'SMP'],
            ['name' => 'Senior High School', 'code' => 'SMA'],
            ['name' => 'Vocational High School', 'code' => 'SMK'],
            ['name' => 'Diploma 3', 'code' => 'D3'],
            ['name' => 'Bachelor Degree', 'code' => 'S1'],
            ['name' => 'Master Degree', 'code' => 'S2'],
            ['name' => 'Doctoral Degree', 'code' => 'S3'],
            ['name' => 'Others', 'code' => 'OTHER'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
        Schema::dropIfExists('education_levels');
    }
};
