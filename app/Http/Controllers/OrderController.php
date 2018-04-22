<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //below function .....
    public function ordersManagement()
    {
        $pageTitle = 'مدیریت سفارشات';
        $data=Order::where([['transaction_code','<>',null],['pay','<>',null],['order_status',null]])->get();
        foreach ($data as $datum)
        {
            $datum->persianDate = $this->toPersian($datum->date);
        }
        return view('admin.ordersManagement',compact('data','pageTitle'));
    }


    //
    public function toPersian($date)
    {
        if (count($date) > 0) {
            $gDate = $date;
            if ($date = explode('-', $gDate)) {
                $year = $date[0];
                $month = $date[1];
                $day = $date[2];
            }
            $date = Verta::getJalali($year, $month, $day);
            $myDate = $date[0] . '/' . $date[1] . '/' . $date[2];
            return $myDate;
        }
        return;
    }

    public function adminShowFactor($id)
    {
        $order = Basket::find($id)->orders;
        $pageTitle      = 'فاکتور سفارش';
        $baskets        = Basket::find($id);
        $total          = 0;
        $totalDiscount  = 0 ;
        $totalPostPrice = 0;
        $finalPrice     = 0;
        if(!empty($baskets))
        {
            foreach ($baskets->products as $basket)
            {
                $basket->count         = $basket->pivot->count;
                $basket->price         = $basket->pivot->product_price;
                $basket->sum           = $basket->pivot->count * $basket->pivot->product_price;
                $basket->basketComment = $basket->pivot->comments;
                $total                += $basket->sum;
                $basket->basket_id     = $basket->pivot->basket_id;
                $totalPostPrice       += $basket->post_price;
                if($basket->discount_volume != null )
                {
                    $totalDiscount        += $basket->discount_volume;
                    if($totalDiscount > 0)
                    {
                        $basket->sumOfDiscount = ($total * $totalDiscount ) / 100 ;
                    }
                }

            }
            $finalPrice += ($total + $totalPostPrice) - $basket->sumOfDiscount;
            return view('admin.adminFactor',compact('pageTitle','baskets','total','totalPostPrice','finalPrice','paymentTypes','order'));
        }else
        {
            return view('errors.403');
        }

    }


    //below function is related to check orders
    public function checkOrders()
    {
        $oneSecondAgo = Carbon::now()->subSecond(1);
        $checkOrders  = Order::where([['transaction_code','<>',null],['pay','<>',null],['created_at','>',$oneSecondAgo]])->value('basket_id');
        if($checkOrders)
        {
            return response()->json(['data' => $checkOrders , 'code' => 1]);
        }else
            {
                return response()->json(['data' => 'no data' , 'code' => 0]);
            }
    }

    //
    public function connectToPrinter()
    {
        $handle = printer_open("HP Deskjet 930c");
        //$handle = printer_open();
        if($handle)
        {
            dd('connected....');
        }else
            {
                dd('not connected....');
            }
    }

    //
    public function checkOrderStatus()
    {

        if(Order::where([['transaction_code','<>',null],['pay','<>',null],['order_status',null]])->count() > 0)
        {
            return response()->json(['message' => 'exist']);
        }
        else
            {
                return response()->json(['message' => 'not exist']);
            }
    }

    //below function is to change order status
    public function changeOrderStatus(Request $request)
    {
        $order = Order::find($request->orderId);
        $order->order_status = 'OK';
        $order->save();
        if($order)
        {
            return response()->json(['message' => 'success']);
        }else
            {
                return response()->json(['message' => 'error']);
            }
    }

    //below function is related to get old orders
    public function oldOrders()
    {
        $pageTitle = "سفارش های پیگیری شده";
        $data = Order::where([['transaction_code','<>',null],['pay','<>',null],['order_status','<>',null]])->get();
        foreach ($data as $datum)
        {
            $datum->persianDate = $this->toPersian($datum->created_at);
        }
        return view('admin.oldOrders',compact('data','pageTitle'));
    }
}
