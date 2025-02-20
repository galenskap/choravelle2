<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('file_pupitre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained()->onDelete('cascade');
            $table->foreignId('pupitre_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Remove the old pupitre_id column from files table
        Schema::table('files', function (Blueprint $table) {
            $table->dropForeign(['pupitre_id']);
            $table->dropColumn('pupitre_id');
        });
    }

    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->foreignId('pupitre_id')->nullable()->constrained();
        });

        Schema::dropIfExists('file_pupitre');
    }
};