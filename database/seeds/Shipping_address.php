<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Shipping_address extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shipping_address = [
            ["first_line"=>"ul. A",
            "second_line"=>"Budynek A 1/1",
            "postal_code"=>"00-000",
            "city"=>"A",
            "country"=>"A"],
            ["first_line"=>"ul. B",
                "second_line"=>"Budynek B 1/1",
                "postBl_code"=>"00-000",
                "city"=>"B",
                "country"=>"B"],
            ["first_line"=>"ul. C",
                "second_line"=>"Budynek C 1/1",
                "postCl_code"=>"00-000",
                "city"=>"C",
                "country"=>"C"],
            ["first_line"=>"ul. D",
                "second_line"=>"Budynek D 1/1",
                "postDl_code"=>"00-000",
                "city"=>"D",
                "country"=>"D"],
        ];
        DB::table('shipping_address')->insert($shipping_address);
    }
}
