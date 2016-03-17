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
//        \Mjex\User::create([
//            'type' => 'seeker',
//            'email' => 'seeker@yopmail.com',
//            'password' => \Hash::make('hunter'),
//            'anonymous_email' => 'aQeKJ@mjex.com',
//            'community_name' => 'tjntun seeker',
//            'zipcode' => '90001',
//            'delivery' => false,
//            'purpose' => '["medical"]',
//            'state' => 'California',
//            'country' => 'us',
//            'package' => 'none',
//            'active' => 1,
//            'activation_code' => \Hash::make('seeker@yopmail.com')
//        ]);
//
//        \Mjex\User::create([
//            'type' => 'seller',
//            'email' => 'sellerfree@yopmail.com',
//            'password' => \Hash::make('hunter'),
//            'anonymous_email' => 'eQeKJ@mjex.com',
//            'community_name' => 'seller free',
//            'zipcode' => '90002',
//            'delivery' => false,
//            'purpose' => '["medical"]',
//            'state' => 'California',
//            'country' => 'us',
//            'package' => 'free',
//            'active' => 1,
//            'activation_code' => \Hash::make('sellerfree@yopmail.com')
//        ]);
//
//        \Mjex\User::create([
//            'type' => 'seller',
//            'email' => 'sellerweekly@yopmail.com',
//            'password' => \Hash::make('hunter'),
//            'anonymous_email' => 'eQeKW@mjex.com',
//            'community_name' => 'seller weekly',
//            'zipcode' => '90002',
//            'delivery' => false,
//            'purpose' => '["medical"]',
//            'state' => 'California',
//            'country' => 'us',
//            'package' => 'weekly',
//            'active' => 1,
//            'activation_code' => \Hash::make('sellerfree@yopmail.com')
//        ]);
        \Mjex\Review::create([
            'user_id' => 1,
            'content' => 'Quality was better than expected',
            'reviewer' => 'Jim'
        ]);
    }
}
