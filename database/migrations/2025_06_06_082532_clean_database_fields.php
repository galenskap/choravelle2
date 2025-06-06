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
        // Remove the is_admin field and current_team_id field from the users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
            $table->dropColumn('current_team_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add the is_admin field and current_team_id field to the users table
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
            $table->foreignId('current_team_id')->nullable()->constrained('teams')->nullOnDelete();
        });
    }
};
