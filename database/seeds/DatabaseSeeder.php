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
            'community_name' => 'tjntun',
            'zipcode' => '100000',
            'delivery' => false,
            'purpose' => '["medical"]',
            'state' => 'hanoi',
            'country' => 'vn',
            'package' => 'none',
        ]);
    }
}
