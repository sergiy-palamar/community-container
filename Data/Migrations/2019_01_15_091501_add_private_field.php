<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class AddPrivateField
 */
class AddPrivateField extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->boolean('is_private')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasColumn('communities', 'is_private')) {
            Schema::table('communities', function (Blueprint $table) {
                $table->dropColumn('is_private');
            });
        }
    }
}
