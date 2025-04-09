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
        Schema::table('student_details', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('roll_no');
            $table->unsignedTinyInteger('picture_changes_left')->default(3)->after('profile_picture');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_details', function (Blueprint $table) {
            $table->dropColumn('profile_picture');
            $table->dropColumn('picture_changes_left');
        });
    }
};
