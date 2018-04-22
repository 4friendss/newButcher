<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $table="product_option";
    protected $fillable=['title','product_id','active'];
    //relation of productOption and product
    public function products()
    {
        return $this->belongsToMany('App\Models\Product','product_id');
    }
}
