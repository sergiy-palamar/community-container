<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class AddConnectionDateColumn
 */
class AddConnectionDateColumn extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->timestamp('connection_date', 0)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasColumn('communities', 'connection_date')) {
            Schema::table('communities', function (Blueprint $table) {
                $table->dropColumn('connection_date');
            });
        }
    }
}
