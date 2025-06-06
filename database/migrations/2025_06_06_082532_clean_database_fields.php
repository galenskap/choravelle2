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
            $table->dropForeign(['current_team_id']);
            $table->dropColumn('current_team_id');
        });

        // Remove the old block template field from the blocks table
        Schema::table('blocks', function (Blueprint $table) {
            $table->dropColumn('template');
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
            $table->unsignedBigInteger('current_team_id')->nullable();
            $table->foreign('current_team_id')->references('id')->on('teams')->nullOnDelete();
        });

        // Add the old block template field to the blocks table
        Schema::table('blocks', function (Blueprint $table) {
            $table->string('template')->nullable();
        });
    }
};
