<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Order extends Model
{
    protected $fillable = [
        'product_id','order_id','amount'
    ];

    public function product()
    {
        return $this->hasOne(Product::Class,'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::Class,'order_id');
    }
}
