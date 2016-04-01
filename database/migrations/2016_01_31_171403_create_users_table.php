<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['seeker','seller']);
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('anonymous_email')->unique();
            $table->string('community_name')->unique();
            $table->boolean('delivery')->null();
            $table->string('purpose');
            $table->integer('patients_available')->null(); // seller is grower only
            $table->string('state');
            $table->enum('package',['none','free','weekly','weekly_pro']);

            // Seeker has purpose Medical only
            $table->string('medical_card_number')->null();
            $table->string('desired_alotment')->null();

            $table->string('accepted_payment')->null();

            $table->string('zipcode')->null();
            $table->string('country')->null();

            $table->string('lat')->null();
            $table->string('lng')->null();

            $table->string('logo')->null();

            $table->boolean('active');
            $table->string('activation_code')->null();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
