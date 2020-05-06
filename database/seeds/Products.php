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
        ["name"=>"A","price"=>12.34,"stock"=>1234,"description"=>"A","image_path"=>"https://images.unsplash.com/photo-1507823782123-27db7f9fd196","category_id"=>1],
        ["name"=>"B","price"=>12.34,"stock"=>1234,"description"=>"B","image_path"=>"https://images.unsplash.com/photo-1507823782123-27db7f9fd196","category_id"=>1],
        ["name"=>"C","price"=>12.34,"stock"=>1234,"description"=>"C","image_path"=>"https://images-na.ssl-images-amazon.com/images/I/61D6WKwXlGL._AC_SX425_.jpg","category_id"=>2],
        ["name"=>"D","price"=>12.34,"stock"=>1234,"description"=>"D","image_path"=>"https://images-na.ssl-images-amazon.com/images/I/61HQwHD03xL._AC_SL1055_.jpg","category_id"=>3],
        ["name"=>"E","price"=>12.34,"stock"=>1234,"description"=>"E","image_path"=>"https://movieposterhd.com/wp-content/uploads/2019/03/Rocket-Raccoon-Avengers-Endgame-Wallpaper-HD.jpg","category_id"=>4],];
        DB::table('products')->insert($products);
    }
}
