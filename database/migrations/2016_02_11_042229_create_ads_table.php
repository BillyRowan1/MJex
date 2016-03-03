<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->string('content');
            $table->string('type_of_product');
            $table->string('unit_desc');
            $table->string('amount');
            $table->string('header_color');
            $table->string('location');
            $table->string('type_of_strain');
            $table->string('price_per_unit');
            $table->string('price_per_quantity');
            $table->string('thumb');
            $table->text('gallery');

            $table->bigInteger('expired_date');

            $table->string('ad_type');

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
        Schema::drop('ads');
    }
}
