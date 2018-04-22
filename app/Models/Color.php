<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    //relation of color and product
    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
}
