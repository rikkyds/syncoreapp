<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->enum('relationship', [
                'father', 'mother', 'spouse', 'child', 'sibling', 
                'grandfather', 'grandmother', 'father_in_law', 'mother_in_law',
                'other'
            ]);
            $table->string('other_relationship')->nullable();
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->boolean('is_alive')->default(true);
            $table->date('death_date')->nullable();
            $table->enum('education_level', [
                'sd', 'smp', 'sma', 'smk', 'd1', 'd2', 'd3', 
                'd4', 's1', 's2', 's3', 'other'
            ])->nullable();
            $table->string('occupation')->nullable();
            $table->boolean('is_financial_dependent')->default(false);
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            $table->boolean('is_emergency_contact')->default(false);
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
