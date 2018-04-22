<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRegistrationValidation;
use App\Http\Requests\NewPasswordValidation;
use App\Http\SelfClasses\BankModule;
use App\Http\SelfClasses\CheckProductExistence;
use App\Http\SelfClasses\CheckUserCellphone;
use App\Http\SelfClasses\RollBackWarehouseCount;
use App\Models\Basket;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductScore;
use App\User;
use Carbon\Carbon;
use function Couchbase\defaultDecoder;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Kavenegar;
class UserController extends Controller
{
    //below function returns all users to the usersManagement blade ...
    public function usersManagement()
    {
        $data = User::all();
        return view('admin.usersManagement', compact('data'));
    }


    //below function is related to add products into basket with cookie
    public function addToBasket(Request $request)
    {
        //order option of a product send in input array format
        //below function concatenate array value in a one variable for save in database
        $orderOptionArr = '';
        $countOption = count($request->orderOption);
        if ($countOption) {
            for ($i = 0; $i < $countOption; $i++) {
                if ($i+1 < $countOption )
                    $orderOptionArr .= $request->orderOption[$i] . "،";
                else
                    $orderOptionArr .= $request->orderOption[$i];
            }
        }
        $now = Carbon::now(new \DateTimeZone('Asia/Tehran'));
        if (isset($_COOKIE['addToBasket'])) {
            $basketId = DB::table('baskets')->where([['cookie', $_COOKIE['addToBasket']], ['payment', 0]])->value('id');
            $count = DB::table('basket_product')->where([['basket_id', $basketId], ['product_id', $request->productId]])->count();

            if ($oldBasket = DB::table('baskets')->where([['cookie', $_COOKIE['addToBasket']], ['payment', 0]])->count() > 0 && $count > 0) {

                $update = DB::table('basket_product')->where([['basket_id', $basketId], ['product_id', $request->productId]])->increment('count');
                if ($update) {
                    return response()->json(['message' => 'محصول مورد نظر شما به سبد خرید اضافه گردید', 'code' => 1]);
                } else {
                    return response()->json(['message' => 'خطایی رخ داده است']);
                }

            } else if ($oldBasket = DB::table('baskets')->where([['cookie', $_COOKIE['addToBasket']], ['payment', 1]])->count() > 0) {
                return $this->newCookie($now, $request);
            } else {
                $pivotInsert = DB::table('basket_product')->insert
                ([
                    'basket_id' => $basketId,
                    'product_id' => $request->productId,
                    'product_price' => $request->productFlag,
                    'time' => $now->toTimeString(),
                    'date' => $now->toDateString(),
                    //'comments' => $orderOptionArr,
                    //'extra_comment' => $request->extraComment,
                    'count' => 1
                ]);
                if ($pivotInsert) {
                    return response()->json(['message' => 'محصول مورد نظر شما به سبد خرید اضافه گردید', 'code' => 1]);
                } else {
                    return response()->json(['message' => 'خطایی رخ داده است']);
                }
            }
        } else {
            return $this->newCookie($now, $request);
        }
    }

    //below function is related to make new cookie
    public function newCookie($now, $request)
    {
        $cookieValue = mt_rand(1, 1000) . microtime();
        $cookie = setcookie('addToBasket', $cookieValue, time() + (86400 * 30), "/");
        if ($cookie) {
            $basket = new Basket();
            $basket->cookie = $cookieValue;
            $basket->save();
            if ($basket) {
                $pivotInsert = DB::table('basket_product')->insert
                ([
                    'basket_id' => $basket->id,
                    'product_id' => $request->productId,
                    'product_price' => $request->productFlag,
                    'time' => $now->toTimeString(),
                    'date' => $now->toDateString(),
                    //'comments' => $orderOptionArr,
                    //'extra_comment' => $request->extraComment,
                    'count' => 1
                ]);
                if ($pivotInsert) {
                    return response()->json(['message' => 'محصول مورد نظر شما به سبد خرید اضافه گردید', 'code' => 1]);
                } else {
                    return response()->json(['message' => 'خطایی رخ داده است']);
                }

            } else {
                return response()->json(['message' => 'خطایی رخ داده است']);
            }
        }
    }

    //below function is related to get basket count
    public function getBasketCountNotify()
    {
        if(isset($_COOKIE['addToBasket']))
        {
            $basketId = DB::table('baskets')->where([['cookie', $_COOKIE['addToBasket']], ['payment', 0]])->value('id');
            $count = DB::table('basket_product')->where('basket_id', $basketId)->count();
            return response()->json(['basketCount' => $count]);
        }else
        {
            return response()->json(0);
        }
    }

    //below function is related to get basket total price
    public function getBasketTotalPrice()
    {
        if(isset($_COOKIE['addToBasket']))
        {
            $basketId = DB::table('baskets')->where([['cookie', $_COOKIE['addToBasket']], ['payment', 0]])->value('id');
            $baskets = DB::table('basket_product')->where('basket_id', $basketId)->get();
            $totalPrice = '';
            foreach ($baskets as $basket) {
                $totalPrice += $basket->count * $basket->product_price;
            }
            return response()->json($totalPrice);
        }else
            {
                return response()->json(0);
            }

    }

    //below function is related to get basket content
    public function getBasketContent()
    {
        if(isset($_COOKIE['addToBasket']))
        {
        $basketId = DB::table('baskets')->where([['cookie', $_COOKIE['addToBasket']], ['payment', 0]])->value('id');
        $baskets = Basket::find($basketId);
        foreach ($baskets->products as $product) {
            $product->count = $product->pivot->count;
            $product->price = $product->pivot->product_price;
            $product->basket_id = $product->pivot->basket_id;
            $product->product_id = $product->pivot->product_id;

        }
             return response()->json($baskets);
        }else
        {
            return response()->json(0);
        }
    }

    //below function is related to remove item from basket
    public function removeItemFromBasket(Request $request)
    {
        if (!$request->ajax()) {
            abort(403);
        }
        $delete = DB::table('basket_product')->where([['basket_id', $request->basketId], ['product_id', $request->productId]])->delete();
        $count = DB::table('basket_product')->where('basket_id', $request->basketId)->count();
        if ($delete) {
            return response()->json(['message' => 'محصول مورد نظر از سبد خرید حذف گردید', 'code' => 1, 'count' => $count]);
        } else {
            return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
        }
    }

    //below function is related to update basket payment field
    public function orderFixed()
    {
        if (isset($_COOKIE['addToBasket'])) {
            $update = DB::table('baskets')->where('cookie', $_COOKIE['addToBasket'])->update(['payment' => 1]);
            if ($update) {
                return response()->json(['message' => '', 'code' => 1]);
            }
        }
    }

    //below function is related to add or sub count of basket
    public function addOrSubCount(Request $request)
    {
        switch ($request->parameter) {
            case 'addToCount' :
                $update = DB::table('basket_product')->where([['basket_id', $request->basketId], ['product_id', $request->productId]])->increment('count');
                if ($update) {
                    return response()->json(['code' => 1]);
                } else {
                    return response()->json(['code' => 0]);
                }
                break;
            case 'subFromCount' :
                $update = DB::table('basket_product')->where([['basket_id', $request->basketId], ['product_id', $request->productId]])->decrement('count');
                if ($update) {
                    return response()->json(['code' => 1]);
                } else {
                    return response()->json(['code' => 0]);
                }
                break;
        }
    }


    //below function is related to add order registration
    public function orderRegistration(OrderRegistrationValidation $request)
    {
        if ($basket = Basket::where([['id', $request->basketId], ['payment', 0]])->count() > 0) {
            $checkProductExistence = new CheckProductExistence();
            $result = $checkProductExistence->checkProductExistence($request);
            if(is_bool($result))
            {
                $bankModule =  new BankModule();
                $result1    =  $bankModule->bankOperation($request->payPrice);
                if(is_bool($result1))
                {
                    $user = User::where('cellphone', $request->userCellphone)->get();
                    if (count($user) > 0) {
                        $newPassword = '';
                        return $this->addToOrder($request, $user[0], $newPassword);
                    } else {
                        $newPassword = str_random(8);
                        $user = new User();
                        $user->cellphone = $request->userCellphone;
                        $user->password = Hash::make($newPassword);
                        $user->save();
                        if ($user) {


                            try{
                            $sender = "10005505055000";
                            $message = "با عرض سلام خدمت شما لطفا با رمز عبور زیر وارد پنل کاربری خود شوید و سپس پیگیر سفارشات خود باشید"."\n".$newPassword;
                            $receptor = $user->cellphone;
                            $result = Kavenegar::Send($sender,$receptor,$message);
                           // return $result;
                            if($result){
                                return $this->addToOrder($request, $user, $newPassword);
                                foreach($result as $r){
                                    echo "messageid = $r->messageid";
                                    echo "message = $r->message";
                                    echo "status = $r->status";
                                    echo "statustext = $r->statustext";
                                    echo "sender = $r->sender";
                                    echo "receptor = $r->receptor";
                                    echo "date = $r->date";
                                    echo "cost = $r->cost";
                                }       
                                
                            }else
                                {
                                    $delete = DB::table('users')->where([['cellphone', $user->userCellphone],['active',1]])->delete();
                                    if($delete)
                                    {
                                        return response()->json(['messaage' => 'خطا در ارسال رمز عبور لطفا ابتدا ثبت نام کنید سپس اقدام به ثبت سفارش نمایید' , 'code' => 'info' ]);
                                    }
                                }
                        }
                        catch(\Kavenegar\Exceptions\ApiException $e){
                            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
                            echo $e->errorMessage();
                        }
                        catch(\Kavenegar\Exceptions\HttpException $e){
                            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
                            echo $e->errorMessage();
                        }    


                            
                        }
                    }
                }else
                    {
                        $rollBack = new RollBackWarehouseCount();
                        $result2  = $rollBack->rollBackWarehouseCount($request);
                        if(is_bool($result2))
                        {
                            return response()->json(['message' => 'بدلیل عدم واریز وجه سفارش شما ثبت نگردید','code' => 'success']);
                        }else
                            {
                                return response()->json(['message' => $result2 , 'code' => 'error']);
                            }
                    }
            }else
                {
                    return response()->json(['message' => $result , 'code' => 'error1']);
                }

        } else {
            return response()->json(['message' => 'این سفارش قبلا ثبت گردیده است ، لطفا تقاضای مجدد نفرمائید']);
        }
    }

    //below function is related to add items in orders table
    public function addToOrder($request, $user, $newPassword)
    {
        $product = $this->addToSellCount($request);
        if ($product) {
            $now = Carbon::now(new\DateTimeZone('Asia/Tehran'));
            $order = new Order();
            $order->user_id = $user->id;
            $order->user_coordination = trim($request->userCoordination);
            $order->date = $now->toDateString();
            $order->time = $now->toTimeString();
            $order->total_price = $request->totalPrice;
            $order->discount_price = $request->discountPrice;
            $order->factor_price = $request->factorPrice;
            $order->pay_price    = $request->payPrice;
            $order->user_cellphone = $request->userCellphone;
            $order->basket_id = $request->basketId;
            $order->payment_type = $request->paymentType;
            $order->pay = 1;
            $order->transaction_code = 46456464;
            $order->comments = $request->comments;
            $order->save();
            if ($order) {
                $update = Basket::find($request->basketId);
                $update->payment = 1;
                $update->active = 0;
                $update->save();
                if ($update) {

                    if ($newPassword == '') {
                        return response()->json(['message' => 'سفارش  شما با موفقیت ثبت گردید ، لطفا در جهت پیگیری سفارش خود وارد پنل شوید','code' => 'success']);
                    } else {
                        return response()->json(['message' => 'سفارش  شما با موفقیت ثبت گردید ، لطفا در جهت پیگیری سفارش خود با رمز عبور ارسال شده به تلفن همراه وارد پنل شوید','code' => 'success']);
                    }

                } else {
                    return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
                }

            }
        } else {
            return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
        }

    }

    //below function is related to add sell count of product
    public function addToSellCount($request)
    {
        if (count($request) > 1) {
            for ($i = 0; $i <= count($request); $i++) {
                $product = DB::table('products')->where('id', $request->productId[$i])->increment('sell_count');
            }
            if ($product) {
                return true;
            } else {
                return false;
            }
        } else {
            $product = DB::table('products')->where('id', $request->productId)->increment('sell_count');
            if ($product) {
                return true;
            } else {
                return false;
            }
        }

    }

    //below function is related to show user orders
    public function userOrders($parameter)
    {
        $data = Order::where([['user_id', Auth::user()->id], ['pay', '<>', null], ['transaction_code', '<>', null]])->get();
        if(count($data) > 0)
        {
            $baskets = Basket::find($data[0]->basket_id);
            foreach ($data as $datum) {
                $datum->orderDate = $this->toPersian($datum->created_at->toDateString());
            }
            switch ($parameter) {
                case 'factor' :
                    $pageTitle = 'سفارشات و فاکتورها';
                    return view('user.ordersList', compact('data', 'pageTitle', 'baskets'));
                    break;
                case 'score' :
                    $pageTitle = 'سفارشات و امتیاز دهی';
                    return view('user.ordersScore', compact('data', 'pageTitle', 'baskets'));
                    break;

                default:
                    return view('errors.403');
            }
        }else
            {
                return Redirect::back();
            }
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

    //below function is related to show order detail
    public function orderDetails($id)
    {
        $comments = Basket::find($id)->orders->comments;
        $baskets = Basket::find($id);
        if (count($baskets) > 0) {
            $pageTitle = 'جزئیات سفارش';
            foreach ($baskets->products as $basket) {
                $basket->product_price = $basket->pivot->product_price;
                $basket->basket_id = $basket->pivot->basket_id;
                $basket->basketComment = $basket->pivot->comments;
                $basket->basketCount = $basket->pivot->count;
            }
            return view('user.orderDetails', compact('baskets', 'pageTitle', 'comments'));
        } else {
            return view('errors.403');
        }
    }


    //below function is related to get information of factor
    public function userShowFactor($id)
    {
        $pageTitle = 'فاکتور سفارش';
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
            return view('user.userFactor', compact('pageTitle', 'baskets', 'total', 'totalPostPrice', 'finalPrice', 'paymentTypes', 'comments','payPrice'));
        } else {
            return view('errors.403');
        }

    }

    //below function is related to return view of changing password
    public function changePassword()
    {
        $pageTitle = 'تغییر رمز عبور';
        if (Auth::check()) {
            $userInfo = User::where('id', Auth::user()->id)->get();
            return view('user.changePassword', compact('pageTitle', 'userInfo'));
        } else
            return redirect('/logout');

    }

    //below function is related to change old password and save new password
    public function saveNewPassword(NewPasswordValidation $request)
    {
        if (!$request->ajax()) {
            abort(403);
        } else {
            if (Auth::user()->id == $request->userId) {
                $oldPassword = User::where([['id', Auth::user()->id], ['active', 1]])->value('password');
                if (Hash::check($request->oldPassword, $oldPassword)) {
                    if ($request->password === $request->confirmPassword) {
                        $q = DB::table('users')->where('id', $request->userId)
                            ->update(['password' => Hash::make($request->password)]);
                        if ($q) {
                            //$n=1;
                            Auth::logout();
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
            } else {
                return redirect('/logout');
            }
        }
    }

    //below function is related to add to seen count
    public function addToSeenCount(Request $request)
    {
        if ($request->ajax()) {
            $product = Product::find($request->productId);
            $product->seen_count += 1;
            $product->save();
            if ($product) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['message' => 'error']);
            }
        } else {
            abort(403);
        }
    }

    //below function is related to add score for each product
    public function addScore(Request $request)
    {
        if ($request->ajax()) {
            if (ProductScore::where([['user_id', Auth::user()->id], ['product_id', $request->productId]])->count() > 0) {
                return response()->json(['message' => 'شما قبلا امتیاز خود را برای این محصول ثبت نموده اید ، لطفا درخواست مجدد  نفرمائید']);
            } else {
                $score = new ProductScore();
                $score->product_id = $request->productId;
                $score->user_id = Auth::user()->id;
                $score->score = $request->score;
                $score->save();
                if ($score) {
                    return response()->json(['message' => 'امتیاز برای محصول مورد نظر ثبت گردید', 'code' => 'success']);
                } else {
                    return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
                }
            }
        } else {
            abort('403');
        }

    }

    //below function is to check scores
//    public function checkScore()
//    {
//       $baskets  = Order::where('user_id',Auth::user()->id)->pluck('basket_id');
//       $products = DB::table('basket_product')->whereIn('basket_id',$baskets)->pluck('product_id');
//       $count = count($products);
//       if(ProductScore::where('user_id',Auth::user()->id)->count('product_id') == $count)
//       {
//            return response()->json(['data' => 0]);
//       }
//       else
//           {
//               return response()->json(['data' => 1]);
//           }
//    }

    //below function is to redirect score details
    public function scoreDetails($id)
    {
        $baskets = Basket::find($id);
      //  dd($baskets);
        $pageTitle = 'جزئیات سفارش';
        foreach ($baskets->products as $basket) {
            $basket->product_price = $basket->pivot->product_price;
        }
        $i = 0;
        while (count($baskets->products) > $i) {
            foreach ($baskets->products[$i]->scores as $score) {
                $baskets->products[$i]->totalScore += $score->score;
                $baskets->products[$i]->count += 1;
                $baskets->products[$i]->productScore = $baskets->products[$i]->totalScore / $baskets->products[$i]->count;
                if ($score->user_id == Auth::user()->id && $score->product_id == $baskets->products[$i]->id) {
                    $baskets->products[$i]->scoreFlag = 1;
                }
            }
            $i++;
        }
        //dd($baskets);
        return view('user.scoreDetails', compact('baskets', 'pageTitle'));
    }

    //below function is related to redirect comment details
    public function showJson(Request $request)
    {

        $array = json_decode($request->jsonStr);
        $i = 0;
        while($i < count($array))
        {
            $firstUpdate = DB::table('basket_product')->where([['product_id',$array[$i]->productId],['basket_id',$array[$i]->basketId]])->update(['comments' => ""]);
            $i++;
        }
//        if($firstUpdate == true)
//        {
            $i = 0;
            while($i < count($array))
            {
                $secondUpdate = DB::table('basket_product')->where([['product_id',$array[$i]->productId],['basket_id',$array[$i]->basketId]])->update(['comments' => DB::raw("CONCAT(comments , '".$array[$i]->value."','".','."')")]);
                $i++;
            }
            if($secondUpdate == true)
            {
                return response()->json(['message' => 'جزئیات سفارش با موفقیت ثبت گردید' , 'code' => 'success']);
            }else
                {
                    return response()->json(['message' => 'خطا در ثبت اطلاعات ، لطفا با بخش پشتیبانی تماس بگیرید' , 'code' => 'error1']);
                }
//        }
//        else
//        {
//            return response()->json(['message' => 'خطا در ثبت اطلاعات ، لطفا با بخش پشتیبانی تماس بگیرید' , 'code' => 'error2']);
//        }

    }


}

