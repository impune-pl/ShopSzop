<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping_address extends Model
{
    public $timestamps = false;
    protected $table="shipping_address";
    protected $fillable = [
        'first_line', 'second_line', 'postal_code', 'city', 'country'
    ];
}
