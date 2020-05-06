<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name','price','stock','description','image_path','category_id'
    ];

    public function orders()
    {
        return $this->belongsToMany(Product_Order::Class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::Class,'category_id');
    }
}
