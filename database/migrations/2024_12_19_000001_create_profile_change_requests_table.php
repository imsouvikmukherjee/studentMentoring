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
        Schema::create('profile_change_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('student_details', 'id')->onDelete('cascade');
            $table->foreignId('mentor_id')->nullable();
            $table->text('changes')->comment('JSON encoded changes');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reject_reason')->nullable();
            $table->dateTime('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_change_requests');
    }
}; 