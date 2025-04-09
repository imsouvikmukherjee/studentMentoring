<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Try to drop unique constraint if exists
        try {
            if (Schema::hasTable('student_challenges')) {
                Schema::table('student_challenges', function (Blueprint $table) {
                    $table->dropIndex('student_challenges_student_id_semester_unique');
                });
            }
        } catch (\Exception $e) {
            // Index might not exist, continue
        }

        // Add columns to match our model
        Schema::table('student_challenges', function (Blueprint $table) {
            if (!Schema::hasColumn('student_challenges', 'name')) {
                $table->string('name')->after('semester');
            }
            
            if (!Schema::hasColumn('student_challenges', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            
            if (!Schema::hasColumn('student_challenges', 'result')) {
                $table->string('result')->nullable()->after('description');
            }
            
            if (Schema::hasColumn('student_challenges', 'challenges')) {
                $table->dropColumn('challenges');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_challenges', function (Blueprint $table) {
            if (Schema::hasColumn('student_challenges', 'name')) {
                $table->dropColumn('name');
            }
            
            if (Schema::hasColumn('student_challenges', 'description')) {
                $table->dropColumn('description');
            }
            
            if (Schema::hasColumn('student_challenges', 'result')) {
                $table->dropColumn('result');
            }
            
            if (!Schema::hasColumn('student_challenges', 'challenges')) {
                $table->text('challenges')->nullable()->after('semester');
            }
            
            // Re-add unique constraint
            try {
                $table->unique(['student_id', 'semester']);
            } catch (\Exception $e) {
                // Index might already exist, continue
            }
        });
    }
}; 