<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFlag extends Model
{
    protected $table='product_flags';
    //relation of products and product_flags
    public function products()
    {
        return $this->belongsTo('App\Models\Product');
    }

}
