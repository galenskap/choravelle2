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
        Schema::table('users', function (Blueprint $table) {
            // add new fields
            // pupitre_id (foreign key) : Référence vers le pupitre.
            // is_active (boolean) : Statut actif/inactif.
            // is_admin (boolean) : Si l'utilisateur est administrateur.
            // email_notifications (boolean) : Si l'utilisateur souhaite recevoir des notifications par e-mail.
            // last_read_timestamp (datetime) : Timestamp de la dernière lecture d'une chanson ou fichier.
            $table->foreignId('pupitre_id')->nullable()->constrained();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->boolean('email_notifications')->default(true);
            $table->timestamp('last_read_timestamp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['pupitre_id']);
            $table->dropColumn('pupitre_id');
            $table->dropColumn('is_active');
            $table->dropColumn('is_admin');
            $table->dropColumn('email_notifications');
            $table->dropColumn('last_read_timestamp');
        });
    }
};
