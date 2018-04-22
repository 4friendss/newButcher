<?php

namespace App\Http\Controllers\webService;

use App\Http\Requests\RegisterValidation;
use App\Models\Basket;
use App\Models\Category;
use App\Models\PaymentType;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class GeneralController extends Controller
{
    //return slider Images
    public function sliderImages()
    {
        $sliser=Array();
        $sliser[0]=Array('url'=>'http://gushtomorghebaradaran.ir/public/main/assets/slider/1.jpg','title'=>'سوپر گوشت برادران');
        $sliser[1]=Array('url'=>'http://gushtomorghebaradaran.ir/public/main/assets/slider/4.jpg','title'=>'اعتماد شما،افتخار ماست');
        $sliser[2]=Array('url'=>'http://gushtomorghebaradaran.ir/public/main/assets/slider/3.jpg','title'=>'محصولات مرغوب و تازه و با کیفیت را از ما بخواهید');
        return response()->json($sliser);

    }
    //below function is related to get main menu
    public function getMainMenu()
    {
        $mainMenu  = Category::where([['parent_id',null],['grand_parent_id',null]])->get();
        foreach ($mainMenu as $main)
        {
            $main->picture = 'http://gushtomorghebaradaran.ir/'.'public/dashboard/image/'.$main->image_src;
        }
        return response()->json(['mainMenu' => $mainMenu]);
    }

    //below function is related to get sub menu
    public function getSubMenu($id)
    {
        $subMenu  = Category::where('parent_id',$id)->get();
        foreach ($subMenu as $sub)
        {
            $sub->picture = 'http://gushtomorghebaradaran.ir/'.'public/dashboard/image/'.$sub->image_src;
        }
        return response()->json(['subMenu' =>$subMenu ]);
    }

    //below function is related to get brands
    public function getBrands($id)
    {
        $brands = Category::where('parent_id',$id)->get();
        return response()->json(['brands' => $brands]);
    }

    //below function is related to show basket detail
    public function order(Request $request)
    {
        if($basket = Basket::where([['id',$request->basketId],['payment',0]])->count() > 0)
        {
            switch ($request->parameter)
            {
                case 'basketDetail':
                    if($request->basketId)
                    {
                        $baskets   = Basket::find($request->basketId);
                        $total     = 0;
                        foreach ($baskets->products as $basket)
                        {
                            $basket->count          = $basket->pivot->count;
                            $basket->price          = $basket->pivot->product_price;
                            $basket->sum            = $basket->pivot->count * $basket->pivot->product_price;
                            $total                  += $basket->sum;
                            $basket->basket_id      = $basket->pivot->basket_id;
                            $basket->productOption  = $basket->ProductOption;
                        }
                        return response()->json(compact(['basket' => 'baskets' , 'total' => 'total']));
                    }else
                    {
                        return response()->json(['message' => 'سبد خرید وجود ندارد']);
                    }

                    break;

                case 'orderDetail':
                    $paymentTypes = PaymentType::where('active',1)->get();
                    $baskets   = Basket::find($request->basketId);
                    $total          = 0;
                    $totalDiscount  = 0 ;
                    $totalPostPrice = 0;
                    $finalPrice     = 0;
                    $payPrice       = 0;
                    if(!empty($baskets))
                    {
                        foreach ($baskets->products as $basket)
                        {
                            $basket->count         = $basket->pivot->count;
                            $basket->price         = $basket->pivot->product_price;
                            $basket->sum           = $basket->pivot->count * $basket->pivot->product_price;
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
                        $payPrice   += (($total + $totalPostPrice) - $basket->sumOfDiscount) / 2;
                        return response()->json(compact('baskets','total','totalPostPrice','finalPrice','paymentTypes','payPrice'));
                    }else
                    {
                        return resposne()->json(['message' => 'سبد خرید خالی است']);
                    }

                    break;
            }

        }else
        {
            return response()->json(['message' => 'سبد خرید ایجاد نشده است']);
        }

    }
public function register(RegisterValidation $request)
    {
        $user = new User();
        $user->cellphone = trim($request->cellphone);
        $user->password  = Hash::make($request->password);
        $user->save();
        if($user)
        {
            return response()->json(["message" => "ثبت نام با موفقیت انجام شد" , "code" => "success"]);
        }else
            {
                return response()->json(["message" => "در ثبت اطلاعات خطایی رخ داده است" , "code" => "error"]);
            }
    }
}
