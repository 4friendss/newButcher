<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostOrderStatus extends Model
{
  //relation of orders and post_order_status
    public function orders()
    {
        return $this->hasMany('App\Models\Order','post_order_status_id');
    }
}
