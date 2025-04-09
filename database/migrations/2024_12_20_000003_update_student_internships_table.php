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
        Schema::table('student_internships', function (Blueprint $table) {
            if (!Schema::hasColumn('student_internships', 'role')) {
                $table->string('role')->nullable()->after('company');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_internships', function (Blueprint $table) {
            if (Schema::hasColumn('student_internships', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
}; 