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
        Schema::table('profile_change_requests', function (Blueprint $table) {
            $table->timestamp('notified_at')->nullable()->after('processed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_change_requests', function (Blueprint $table) {
            $table->dropColumn('notified_at');
        });
    }
}; 