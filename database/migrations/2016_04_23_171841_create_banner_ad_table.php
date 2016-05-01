<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_ads', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->string('image');
            $table->string('placement'); // home_header, sidebar_left, sidebar_right
            $table->bigInteger('expired_date');
            $table->boolean('active');
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
        Schema::drop('banner_ads');
    }
}
