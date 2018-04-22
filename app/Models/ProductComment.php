<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    //relation of product and comments
    public function products()
    {
        return $this->belongsTo('App\Models\product');
    }
}
