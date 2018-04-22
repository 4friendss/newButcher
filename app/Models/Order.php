<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //relation of user and order
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    //relation of orders and delivery_man_details
    public function deliveryManDetails()
    {
        return $this->hasOne('App\Models\DeliveryManDetails','order_id');
    }
    //relation of orders and order_status
    public function orderStatus()
    {
        return $this->belongsTo('App\Models\OrderStatus');
    }
    //relation of orders and post_order_status
    public function postOrderStatus()
    {
        return $this->belongsTo('App\Models\PostOrderStatus');
    }

    //relation of orders and payment_type
    public function paymentTypes()
    {
        return $this->belongsTo('App\Models\PaymentType');
    }

    //relation of baskets and orders
    public function baskets()
    {
        return $this->belongsTo('App\Models\Basket');
    }
}
