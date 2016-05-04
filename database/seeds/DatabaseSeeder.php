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
         $this->call(BannerPlacementSeeder::class);
    }
}

class BannerPlacementSeeder extends Seeder{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Mjex\BannerPlacement::create([
            'max_slot' => 2,
            'title' => 'Home header',
            'placement' => 'home_header',
            'price' => 30
        ]);
        \Mjex\BannerPlacement::create([
            'max_slot' => 1,
            'title' => 'Sidebar left',
            'placement' => 'sidebar_left',
            'price' => 20
        ]);
        \Mjex\BannerPlacement::create([
            'max_slot' => 1,
            'title' => 'Sidebar right',
            'placement' => 'sidebar_right',
            'price' => 20
        ]);
    }
}
