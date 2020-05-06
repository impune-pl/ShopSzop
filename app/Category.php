<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'name','description'
    ];

    public function products()
    {
        return $this->hasMany(Product::Class);
    }
}
