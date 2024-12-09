<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('genre')->nullable()->after('description');
            $table->string('platform')->nullable()->after('genre');
            $table->date('release_date')->nullable()->after('platform');
        });
    }

    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['genre', 'platform', 'release_date']);
        });
    }
};
