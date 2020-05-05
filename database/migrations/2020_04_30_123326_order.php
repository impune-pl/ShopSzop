<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('payment_id')->unsigned();
            //$table->foreign('payment_id')->references('id')->on('payments');
            $table->bigInteger('shipping_address_id')->unsigned();
            $table->foreign('shipping_address_id')->references('id')->on('shipping_address');
            $table->timestamp('order_date')->useCurrent();
            $table->boolean('is_delivered')->default(FALSE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
