<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('folders', function (Blueprint $table) {
            $table->boolean('is_current')->default(false);
            $table->integer('order')->default(0);
        });
    }

    public function down()
    {
        Schema::table('folders', function (Blueprint $table) {
            $table->dropColumn(['is_current', 'order']);
        });
    }
}; 