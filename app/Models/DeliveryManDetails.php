<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryManDetails extends Model
{
    //relation of delivery_man and delivery_man_details
    public function deliveryMan()
    {
        return $this->belongsTo('App\Models\DeliveryMan');
    }

    //relation of orders and delivery_man details
    public function orders()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
