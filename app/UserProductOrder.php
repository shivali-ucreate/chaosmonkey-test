<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProductOrder extends Model
{
    protected $table = 'user_product_orders';
    protected $fillable = [
        'user_id','product_id','quantity',
    ];

    public static function saveUserProductOrder($product_data)
    {
       return static::create($product_data);
    }
}
