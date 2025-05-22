<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('theme')->default('default');
            $table->timestamps();
        });

        // Insérer les paramètres par défaut
        DB::table('settings')->insert([
            'theme' => 'default',
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
}; 