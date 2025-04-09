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
        Schema::create('student_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('subject_id');
            $table->integer('semester');
            $table->string('academic_year');
            
            // Theory assessment marks
            $table->unsignedTinyInteger('ca1')->nullable()->comment('Continuous Assessment 1 (0-25)');
            $table->unsignedTinyInteger('ca2')->nullable()->comment('Continuous Assessment 2 (0-25)');
            $table->unsignedTinyInteger('ca3')->nullable()->comment('Continuous Assessment 3 (0-25)');
            $table->unsignedTinyInteger('ca4')->nullable()->comment('Continuous Assessment 4 (0-25)');
            
            // Practical assessment marks
            $table->unsignedTinyInteger('pca1')->nullable()->comment('Practical Assessment 1 (0-40)');
            $table->unsignedTinyInteger('pca2')->nullable()->comment('Practical Assessment 2 (0-40)');
            
            // Common fields
            $table->unsignedTinyInteger('attendance')->nullable();
            $table->char('grade', 2)->nullable();
            $table->unsignedTinyInteger('points')->nullable();
            $table->timestamps();
            
            $table->foreign('student_id')->references('id')->on('student_details')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            
            $table->unique(['student_id', 'subject_id', 'semester', 'academic_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subjects');
    }
};
