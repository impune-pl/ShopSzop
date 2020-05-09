<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Order extends Model
{
    public $timestamps = false;
    protected $table="product_orders";
    protected $fillable = [
        'product_id','order_id','amount'
    ];

    public function product()
    {
        return $this->hasOne(Product::Class,'id','product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::Class,'id','order_id');
    }
}
