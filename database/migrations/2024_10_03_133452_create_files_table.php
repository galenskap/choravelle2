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
        /*
        filename (string) : Nom du fichier.
        song_id (foreign key) : Référence vers la chanson.
        pupitre_id (foreign key, nullable) : Référence vers un pupitre spécifique ou null pour tous.
        */
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->foreignId('song_id')->constrained();
            $table->foreignId('pupitre_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
