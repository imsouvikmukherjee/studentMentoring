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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->unsignedBigInteger('department_id');
            $table->string('session')->comment('Academic year/session e.g., 2023-2024');
            $table->integer('semester')->comment('Semester number 1-8');
            $table->enum('type', ['theory', 'practical', 'other'])->default('theory');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('credits')->default(3);
            $table->timestamps();
            
            $table->foreign('department_id')->references('id')->on('department')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
