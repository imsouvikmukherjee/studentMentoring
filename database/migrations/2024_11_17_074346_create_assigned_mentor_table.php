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
        Schema::create('assigned_mentor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mentor_id');
            $table->foreign('mentor_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('mentee_id');
            $table->foreign('mentee_id')->references('id')->on('student_details')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_mentor');
    }
};
