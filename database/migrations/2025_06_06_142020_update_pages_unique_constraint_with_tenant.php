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
        Schema::table('pages', function (Blueprint $table) {
            // Supprimer l'ancienne contrainte unique sur slug
            $table->dropUnique(['slug']);
            
            // Créer une nouvelle contrainte unique sur slug + tenant_id
            $table->unique(['slug', 'tenant_id'], 'pages_slug_tenant_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Supprimer la contrainte unique composite
            $table->dropUnique('pages_slug_tenant_unique');
            
            // Remettre l'ancienne contrainte unique sur slug seul
            $table->unique('slug');
        });
    }
};
