<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserTableSeeder::class);
    }
}

class UserTableSeeder extends Seeder{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Mjex\User::create([
            'type' => 'seeker',
            'email' => 'tjntun@yopmail.com',
            'password' => \Hash::make('hunter'),
            'anonymous_email' => 'aQeKJ@mjex.com',
            'community_name' => 'tjntun seeker',
            'zipcode' => '90001',
            'delivery' => false,
            'purpose' => '["medical"]',
            'state' => 'California',
            'country' => 'us',
            'package' => 'none',
            'active' => 0,
            'activation_code' => \Hash::make('tjntun@yopmail.com')
        ]);

        \Mjex\User::create([
            'type' => 'seller',
            'email' => 'tjntunseller@yopmail.com',
            'password' => \Hash::make('hunter'),
            'anonymous_email' => 'eQeKJ@mjex.com',
            'community_name' => 'tjntun seller',
            'zipcode' => '90002',
            'delivery' => false,
            'purpose' => '["medical"]',
            'state' => 'California',
            'country' => 'us',
            'package' => 'none',
            'active' => 1,
            'activation_code' => \Hash::make('tjntunseller@yopmail.com')
        ]);
    }
}
