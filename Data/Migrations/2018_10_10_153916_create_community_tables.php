<?php

/**
 * Copyright © 2018 Inoxoft. All rights reserved.
 * @author Sergiy Palamar <sergiy.palamar@inoxoft.com>
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateCommunityTables
 */
class CreateCommunityTables extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('communities', function (Blueprint $table) {

            $table->increments('id');

            $table->string('title')->nullable(false);
            $table->string('description', 1024)->nullable(true);
            $table->string('verification_code')->nullable(true);
            $table->string('id_code')->nullable(false);
            $table->string('address')->nullable(false);
            $table->boolean('forever_active')->default(false);
            $table->timestamp('start_date', 0)->nullable(true);
            $table->timestamp('end_date', 0)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('communities');
    }
}
