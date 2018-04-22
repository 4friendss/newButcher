<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    //relation of product and basket
    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('count','product_price','date','time','comments');
    }

    //relation of basket and user
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    //relation of baskets and orders
    public function orders()
    {
        return $this->hasOne('App\Models\Order','basket_id');
    }


}
