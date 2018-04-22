<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $table='product_size';
    //relation of product and product_size
    public function products()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
