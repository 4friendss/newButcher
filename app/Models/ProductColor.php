<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table="color_product";
    //relation of product and product_colors
    public function products()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
