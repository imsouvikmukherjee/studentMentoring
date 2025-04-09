<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mentor_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('student_details')->onDelete('cascade');
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->integer('semester');
            $table->text('academic_feedback')->nullable();
            $table->text('personal_feedback')->nullable();
            $table->text('recommendations')->nullable();
            $table->date('feedback_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mentor_feedbacks');
    }
}; 