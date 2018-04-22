<?php

namespace App\Http\Controllers\webService;

use App\Http\Requests\NewPasswordValidation;
use App\Models\Basket;
use App\Models\Order;
use App\Models\ProductScore;
use App\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
class PanelController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('jwt.auth', ['only' => ['userOrders','orderDetails','userShowFactor','scoreDetails','addScore','saveNewPassword']]);
    }
  //below function is related to show user orders
    public function userOrders()
    {
        if (!$user = JWTAuth::parseToken()->authenticate())
        {
            return response()->json(['message' => 'user not found']);
        }
        else
            {
                $data = Order::where([['user_id', $user->id], ['pay', '<>', null], ['transaction_code', '<>', null]])->get();
                if(count($data) > 0){
                        $baskets = Basket::find($data[0]->basket_id);
                    foreach ($data as $datum) {
                        $datum->orderDate = $this->toPersian($datum->created_at->toDateString());
                    }
                    if(count($baskets) > 0)
                    {
                        return response()->json(compact('data','baskets'));
                    }
                    else
                    {
                        return response()->json(['message' => 'no match found' , 'code' => 'success']);
                    }    
                }else
                {
                    return response()->json(['message' => 'no match found' , 'code' => 'success']);
                }
                
            }
    }

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

    //below function is related to show order detail
    public function orderDetails($id)
    {
        $comments = Basket::find($id)->orders->comments;
        $baskets = Basket::find($id);
        if (count($baskets) > 0) {
            foreach ($baskets->products as $basket){
                $basket->product_price = $basket->pivot->product_price;
                $basket->basket_id = $basket->pivot->basket_id;
                $basket->basketComment = $basket->pivot->comments;
                $basket->basketCount = $basket->pivot->count;
            }
            return response()->json(compact('baskets',  'comments'));
        } else {
            return response()->json(['message' => 'no match found']);
        }
    }

    //below function is related to show information of factor
    public function userShowFactor($id)
    {
        $comments = Basket::find($id)->orders->comments;
        $baskets = Basket::find($id);
        $total = 0;
        $totalDiscount = 0;
        $totalPostPrice = 0;
        $finalPrice = 0;
        $payPrice   = 0;
        if (!empty($baskets)) {
            foreach ($baskets->products as $basket) {
                $basket->count = $basket->pivot->count;
                $basket->price = $basket->pivot->product_price;
                $basket->sum = $basket->pivot->count * $basket->pivot->product_price;
                $basket->basketComment = $basket->pivot->comments;
                $total += $basket->sum;
                $basket->basket_id = $basket->pivot->basket_id;
                $totalPostPrice += $basket->post_price;
                if ($basket->discount_volume != null) {
                    $totalDiscount += $basket->discount_volume;
                    if ($totalDiscount > 0) {
                        $basket->sumOfDiscount = ($total * $totalDiscount) / 100;
                    }
                }
            }
            $finalPrice += ($total + $totalPostPrice) - $basket->sumOfDiscount;
            $payPrice   += (($total + $totalPostPrice) - $basket->sumOfDiscount) / 2;
            return response()->json( compact( 'baskets', 'total', 'totalPostPrice', 'finalPrice', 'paymentTypes', 'comments','payPrice'));
        } else {
            return response()->json(['message' => 'no match found']);
        }

    }

    //below function is to information of scores
    public function scoreDetails($id)
    {
        if (!$user = JWTAuth::parseToken()->authenticate())
        {
            return response()->json(['message' => 'user not found']);
        }else
            {
//                'password'        => 'required|min:6|max:25',
//                'confirmPassword' => 'required|min:6|max:25',
//                'oldPassword'     => 'required|min:6|max:25'
                $baskets = Basket::find($id);
                if(count($baskets) > 0)
                {
                    foreach ($baskets->products as $basket) {
                        $basket->product_price = $basket->pivot->product_price;
                    }
                    $i = 0;
while ($i < count($baskets->products)) {
                        foreach ($baskets->products[$i]->scores as $score) {
                            $baskets->products[$i]->totalScore += $score->score;
                            $baskets->products[$i]->count += 1;
                            $baskets->products[$i]->productScore = $baskets->products[$i]->totalScore / $baskets->products[$i]->count;
                            if ($score->user_id == $user->id && $score->product_id == $baskets->products[$i]->id) {
                                $baskets->products[$i]->scoreFlag = 1;
                            }
                        }
                        $i++;
                    }
                    return response()->json(["scoreInfo" => $baskets]);
                }else
                {
                    return response()->json(['no match found']);
                }
            }
    }

    //below function is related to add score for each product
    public function addScore(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate())
        {
            return response()->json(['message' => 'user not found']);
        }else
            {
                if (ProductScore::where([['user_id', $user->id], ['product_id', $request->productId]])->count() > 0) {
                    return response()->json(['message' => 'شما قبلا امتیاز خود را برای این محصول ثبت نموده اید ، لطفا درخواست مجدد  نفرمائید']);
                } else {
                    $score = new ProductScore();
                    $score->product_id = $request->productId;
                    $score->user_id = $user->id;
                    $score->score = $request->score;
                    $score->save();
                    if ($score) {
                        return response()->json(['message' => 'امتیاز برای محصول مورد نظر ثبت گردید', 'code' => 'success']);
                    } else {
                        return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
                    }
                }
            }
    }

    //below function is related to change old password and save new password
    public function saveNewPassword(Request $request)
    {
        //return response()->json('1');
        if (!$user = JWTAuth::parseToken()->authenticate())
        {
            return response()->json(['message' => 'user not found']);
        } else {
            $validation=Validator::make($request->all(),[

                'password'        => 'required|min:6|max:25',
                'confirmPassword' => 'required|min:6|max:25',
                'oldPassword'     => 'required|min:6|max:25'
            ],
                [
                    'password.required'          => 'وارد کردن پسورد الزامی است',
                    'password.min'               => 'تعداد کارکترهای پسورد نباید کمتر از 6 رقم باشد',
                    'password.max'               => 'تعداد کارکترهای پسورد نباید بیشتر از 25 رقم باشد',
                    'confirmPassword.required'   => 'تکرار پسورد الزامی است',
                    'confirmPassword.min'        => 'تعداد کارکترهای تکرار پسورد نباید کمتر از 6 رقم باشد',
                    'confirmPassword.max'        => 'تعداد کارکترهای تکرار پسورد نباید بیشتر از 25 رقم باشد',
                    'oldPassword.required'       => 'وارد کردن پسورد قبلی الزامی است',
                    'oldPassword.min'            => 'تعداد کارکترهای  پسورد قبلی نباید کمتر از 6 رقم باشد',
                    'oldPassword.max'            => 'تعداد کارکترهای  پسورد قبلی نباید بیشتر از 25 رقم باشد'
                ]);
            $errors = $validation->errors();
            if(!$errors->isEmpty())
                return response()->json($errors);
            else
//                if ($user->id == $request->userId) {
                    $oldPassword = User::where([['id', $user->id], ['active', 1]])->value('password');
                    if (Hash::check($request->oldPassword, $oldPassword)) {
                        if ($request->password === $request->confirmPassword) {
$q = DB::table('users')->where('id', $user->id)
                                ->update(['password' => Hash::make($request->password)]);
                            if ($q) {
                                JWTAuth::invalidate(JWTAuth::getToken());
                                return response()->json(['message' => 'رمز عبور شما تغییر یافت' , 'code' => 'success']);
                            } else {
                                return response()->json(['message' => 'متاسفانه در فرآیند تغییر رمز خطایی رخ داده است!']);
                            }
                        } else {
                            return response()->json(['message' => 'رمز و تکرار رمز با یکدیگر یکسان نیست']);
                        }
                    } else {
                        return response()->json(['message' => 'رمز قبلی صحیح نیست']);
                    }
//                } else {
//                    return response()->json(['message' => 'مشکلی در شناسایی کاربر بوجود آمده است!']);
//                }
        }
    }
}
