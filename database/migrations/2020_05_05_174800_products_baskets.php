<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductsBaskets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('product_baskets', function (Blueprint $table) {
    $table->id();
    $table->bigInteger('product_id')->unsigned();
    $table->foreign('product_id')->references('id')->on('products');
    $table->bigInteger('user_id')->unsigned();
    $table->foreign('user_id')->references('id')->on('users');
    $table->integer('amount');
});
    }

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{

    Schema::dropIfExists('product_baskets');
}
}
