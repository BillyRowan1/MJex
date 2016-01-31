<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('password', 60);
            $table->string('anonymous_email')->unique();
            $table->string('community_name');
            $table->string('zipcode');
            $table->boolean('delivery');
            $table->string('purpose');
            $table->enum('package',['free','monthly','monthly_pro']);
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
        Schema::drop('sellers');
    }
}
