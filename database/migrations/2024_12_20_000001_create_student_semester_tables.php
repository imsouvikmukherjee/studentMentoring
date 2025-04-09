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
        // Create student_semester_data table
        Schema::create('student_semester_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->integer('semester')->comment('Semester number 1-8');
            $table->json('subjects')->nullable()->comment('JSON array of subjects with marks and attendance');
            $table->text('projects')->nullable()->comment('Projects done in the semester');
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('student_details')->onDelete('cascade');
            $table->unique(['student_id', 'semester']);
        });

        // Create student_certifications table
        Schema::create('student_certifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->integer('semester');
            $table->string('course_name');
            $table->string('issued_by');
            $table->date('completion_date');
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('student_details')->onDelete('cascade');
        });

        // Create student_workshops table
        Schema::create('student_workshops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->integer('semester');
            $table->string('name');
            $table->string('organizer');
            $table->date('date');
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('student_details')->onDelete('cascade');
        });

        // Create student_internships table
        Schema::create('student_internships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->integer('semester');
            $table->string('company');
            $table->string('duration');
            $table->text('work_done');
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('student_details')->onDelete('cascade');
        });

        // Create student_challenges table
        Schema::create('student_challenges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->integer('semester');
            $table->text('challenges');
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('student_details')->onDelete('cascade');
            $table->unique(['student_id', 'semester']);
        });

        // Create mentoring_change_requests table
        Schema::create('mentoring_change_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('mentor_id')->nullable();
            $table->integer('semester');
            $table->string('section')->comment('performance, projects, certifications, workshops, internships, challenges');
            $table->json('changes')->comment('JSON data of the changes requested');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reject_reason')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('student_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentoring_change_requests');
        Schema::dropIfExists('student_challenges');
        Schema::dropIfExists('student_internships');
        Schema::dropIfExists('student_workshops');
        Schema::dropIfExists('student_certifications');
        Schema::dropIfExists('student_semester_data');
    }
}; 