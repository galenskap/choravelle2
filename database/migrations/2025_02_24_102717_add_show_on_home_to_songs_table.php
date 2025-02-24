<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->boolean('show_on_home')->default(false);
        });
    }

    public function down()
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('show_on_home');
        });
    }
}; 