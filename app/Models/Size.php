<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    //relation of size and product
    public function products()
    {
        return $this->belongsToMany('App\Models\Product','product_option_id');
    }
}
