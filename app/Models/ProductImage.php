<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    //relation of products and product_images
    public function products()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
