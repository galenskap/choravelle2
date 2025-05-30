<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TABLES = [
        'activity_logs',
        'blocks',
        'contact_messages',
        'events',
        'files',
        'folders',
        'menu_items',
        'messages',
        'pages',
        'pupitres',
        'settings',
        'songs',
        'users',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        foreach ($this::TABLES as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'tenant_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    // D'abord ajouter la colonne sans contrainte
                    $table->unsignedBigInteger('tenant_id')->nullable();
                });

                // Ensuite ajouter la clé étrangère dans une opération séparée
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreign('tenant_id')
                        ->references('id')
                        ->on('tenants')
                        ->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        foreach ($this::TABLES as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'tenant_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropForeign(['tenant_id']);
                    $table->dropColumn('tenant_id');
                });
            }
        }
    }
}; 