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
        Schema::create('student_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('aadhaar_no');
            $table->string('father_name');
            $table->string('mother_name');
            $table->date('dob');
            $table->string('nationality');
            $table->string('category');
            $table->string('sex');
            $table->string('blood_group');
            $table->string('religion');
            $table->string('gurdian_name');
            $table->string('gurdian_address');
            $table->string('guardian_mobile');
            $table->string('relation_with_guardian');
            $table->string('residence_status');
            $table->text('student_address');
            $table->string('state');
            $table->string('district');
            $table->string('pin');
            $table->string('alternate_mobile')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_details');
    }
};
