<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    //relation of product and category n:m
    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
}
