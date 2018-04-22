<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    //relation of warehouse and product
    public function products()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
