<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class AlterCommunityTable
 */
class AlterCommunityTable extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->string('avatar', 1024)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasColumn('communities', 'avatar')) {
            Schema::table('communities', function (Blueprint $table) {
                $table->dropColumn('avatar');
            });
        }
    }
}
