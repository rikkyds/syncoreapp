<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('industry');
            $table->string('position');
            $table->text('main_responsibilities');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->enum('employment_status', ['full_time', 'part_time', 'contract', 'internship']);
            $table->string('location');
            $table->boolean('is_remote')->default(false);
            $table->decimal('salary', 15, 2)->nullable();
            $table->string('salary_currency', 3)->nullable();
            $table->text('leaving_reason')->nullable();
            $table->string('reference_name')->nullable();
            $table->string('reference_position')->nullable();
            $table->string('reference_contact')->nullable();
            $table->string('reference_email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
