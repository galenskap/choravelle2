<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('blocks', 'block_template_id')) {
            Schema::table('blocks', function (Blueprint $table) {
                $table->foreignId('block_template_id')
                    ->after('id')
                    ->nullable()
                    ->constrained();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('blocks', 'block_template_id')) {
            Schema::table('blocks', function (Blueprint $table) {
                $table->dropForeign(['block_template_id']);
                $table->dropColumn('block_template_id');
            });
        }
    }
}; 