<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ["name"=>"Animals","description"=>"Live animals"],
            ["name"=>"Stuffed animals","description"=>"Favourite toy of your children"],
            ["name"=>"Hats and caps","description"=>"Become a racoonhead"],
            ["name"=>"Posters","description"=>"Hang a racoon on your wall"],
        ];
        DB::table('categories')->insert($categories);
    }
}
