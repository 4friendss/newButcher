<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductScore extends Model
{
    protected $table='product_scores';
    //relation of products and score
    public function products()
    {
      return $this->belongsTo('App\Models\Product');
    }
}
