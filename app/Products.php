<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'user_id','product_name',
    ];

    public static function saveProductData($product_data)
    {
        return  static::create($product_data);
    }
}
