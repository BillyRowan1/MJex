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
            $table->boolean('delivery')->nullable();
            $table->string('purpose');
            $table->integer('patients_available')->nullable(); // seller is grower only
            $table->enum('package',['none','free','weekly','weekly_pro']);

            // Seeker has purpose Medical only
            $table->string('medical_card_number')->nullable();
            $table->string('desired_alotment')->nullable();

            $table->string('accepted_payment')->nullable();

            $table->string('state');
            $table->string('zipcode')->nullable();
            $table->string('country')->nullable();

            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            $table->string('logo')->nullable();

            $table->boolean('active');
            $table->string('activation_code')->nullable();
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
