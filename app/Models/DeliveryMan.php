<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryMan extends Model
{
    protected $table="delivery_man";
    //relation of delivery_man and delivery_man_status
    public function deliveryManStatus()
    {
        return $this->belongsTo('App\Models\DeliveryManStatus');
    }

    //relation of delivery_man and delivery_man_details
    public function deliveryManDetails()
    {
        return $this->hasMany('App\Models\DeliveryManDetails','delivery_man_id');
    }
}
