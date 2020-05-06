<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'user_id','shipping_address_id','payment_id','order_date','is_delivered'
    ];

    public function user()
    {
        return $this->belongsTo(User::Class, 'user_id');
    }

    public function shipping_address()
    {
        return $this->hasOne(Shipping_address::Class,'shipping_address_id');
    }

//    public function payment()
//    {
//        return $this->hasOne(Payment::Class, 'payment_io');
//    }

    public function products()
    {
        return $this->hasMany(Product_Order::Class);
    }
}
