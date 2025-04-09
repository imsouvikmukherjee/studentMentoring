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
        Schema::table('student_certifications', function (Blueprint $table) {
            if (Schema::hasColumn('student_certifications', 'course_name') && !Schema::hasColumn('student_certifications', 'title')) {
                $table->renameColumn('course_name', 'title');
            }
            
            if (Schema::hasColumn('student_certifications', 'issued_by') && !Schema::hasColumn('student_certifications', 'issuer')) {
                $table->renameColumn('issued_by', 'issuer');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_certifications', function (Blueprint $table) {
            if (Schema::hasColumn('student_certifications', 'title') && !Schema::hasColumn('student_certifications', 'course_name')) {
                $table->renameColumn('title', 'course_name');
            }
            
            if (Schema::hasColumn('student_certifications', 'issuer') && !Schema::hasColumn('student_certifications', 'issued_by')) {
                $table->renameColumn('issuer', 'issued_by');
            }
        });
    }
}; 