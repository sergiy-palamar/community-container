<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class MakeCommunityIdUnique
 */
class MakeCommunityIdUnique extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->unique('id_code', 'communities_id_code_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropUnique('communities_id_code_unique');
        });
    }
}
