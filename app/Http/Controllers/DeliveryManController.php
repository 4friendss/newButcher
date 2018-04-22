<?php

namespace App\Http\Controllers;
class DeliveryManController extends Controller
{
    //
    public function deliveryMansManagement()
    {
        $data=DeliveryMan::all();
        return view('admin.deliveryMansManagement',compact('data'));
    }

    //
    public function addDeliveryMan()
    {
        $data=User::all();
        return view('admin.addDeliveryMan',compact('data'));
    }
}
