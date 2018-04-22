<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    //relation of orders and payment_type
    public function orders()
    {
        return $this->hasMany('App\Models\Order','payment_type_id');
    }
}
