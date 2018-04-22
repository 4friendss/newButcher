<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryManStatus extends Model
{
    //relation of delivery_man and delivery_man_status
    public function deliveryman()
    {
        return $this->hasMany('App\Models\DeliveryMan','delivery_man_status_id');
    }
}
