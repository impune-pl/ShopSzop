<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_basket extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product_id','user_id','amount','version'
    ];
    public function product()
    {
        return $this->hasOne(Product::Class,'id','product_id');
    }

    public function basket()
    {
        return $this->belongsTo(User::Class,'user_id','id');
    }
}
