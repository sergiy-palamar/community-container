<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterCommunityIdCode extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->string('id_code')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->string('id_code')->nullable(false)->change();
        });
    }
}
