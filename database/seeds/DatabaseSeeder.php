<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Categories::class);
        $this->call(Shipping_address::class);
        $this->call(Products::class);
        $this->call(Product_Orders::class);
        $this->call(Users::class);
        $this->call(Orders::class);
    }
}
