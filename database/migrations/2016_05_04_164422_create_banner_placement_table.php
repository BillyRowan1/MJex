<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerPlacementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_placements', function(Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->integer('max_slot');
            $table->integer('price');
            $table->string('placement'); // home_header, sidebar_left, sidebar_right
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('banner_placements');
    }
}
