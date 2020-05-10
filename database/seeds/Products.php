<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products=[
        ["name"=>"A","price"=>12.34,"stock"=>1234,"description"=>"A","image_path"=>"/images/1.jpg","category_id"=>1],
        ["name"=>"B","price"=>12.34,"stock"=>1234,"description"=>"B","image_path"=>"/images/1.jpg","category_id"=>1],
        ["name"=>"C","price"=>12.34,"stock"=>1234,"description"=>"C","image_path"=>"/images/2.jpg","category_id"=>2],
        ["name"=>"D","price"=>12.34,"stock"=>1234,"description"=>"D","image_path"=>"/images/3.jpg","category_id"=>3],
        ["name"=>"E","price"=>12.34,"stock"=>1234,"description"=>"E","image_path"=>"/images/4.jpg","category_id"=>4],];
        DB::table('products')->insert($products);
    }
}
