<?php

namespace App\Http\Controllers\webService;

use App\Http\Requests\OrderRegistrationValidation;
use App\Http\SelfClasses\BankModule;
use App\Http\SelfClasses\CheckProductExistence;
use App\Http\SelfClasses\RollBackWarehouseCount;
use App\Models\Basket;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Kavenegar;
class UserController extends Controller
{
    /* below function is related to add product in basket
       as you see this function used in web service
       the client should send 3 parameters :
       1-cookie 2-productId  3-productFlag
     */
//below function is related to add products into basket with cookie
  public function addToBasket(Request $request)
    {
        //order option of a product send in input array format
        //below function concatenate array value in a one variable for save in database
        $orderOptionArr = '';
        $countOption = count($request->orderOption);
        if ($countOption > 0) {
            for ($i = 0; $i < $countOption; $i++) {
                if ($i+1 < $countOption )
                    $orderOptionArr .= $request->orderOption[$i] . "،";
                else
                    $orderOptionArr .= $request->orderOption[$i];
            }
        }
        $now = Carbon::now(new \DateTimeZone('Asia/Tehran'));
        if ($request->basketId != '') {
            //$basketId = DB::table('baskets')->where([['id', $request->basketId], ['payment', 0]])->value('id');
            $count = DB::table('basket_product')->where([['basket_id', $request->basketId], ['product_id', $request->productId]])->count();

            if ($oldBasket = DB::table('baskets')->where([['id', $request->basketId], ['payment', 0]])->count() > 0 && $count > 0) {

                $update = DB::table('basket_product')->where([['basket_id', $request->basketId], ['product_id', $request->productId]])->increment('count');
                if ($update) {
                    return response()->json(['message' => 'محصول مورد نظر شما به سبد خرید اضافه گردید', 'code' => 1]);
                } else {
                    return response()->json(['message' => 'خطایی رخ داده است']);
                }

            } else if ($oldBasket = DB::table('baskets')->where([['id', $request->basketId], ['payment', 1]])->count() > 0) {
                return $this->newCookie($now, $request,$orderOptionArr);
            } else {
                $pivotInsert = DB::table('basket_product')->insert
                ([
                    'basket_id' => $request->basketId,
                    'product_id' => $request->productId,
                    'product_price' => $request->productFlag,
                    'time' => $now->toTimeString(),
                    'date' => $now->toDateString(),
                    'comments' => $orderOptionArr,
                    'extra_comment' => $request->extraComment,
                    'count' => 1
                ]);
                if ($pivotInsert) {
                    return response()->json(['message' => 'محصول مورد نظر شما به سبد خرید اضافه گردید', 'code' => 1]);
                } else {
                    return response()->json(['message' => 'خطایی رخ داده است']);
                }
            }
        } else {
            return $this->newCookie($now, $request,$orderOptionArr);
        }
    }

//below function is related to make new cookie
    public function newCookie($now, $request,$orderOptionArr)
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
                   'comments' => $orderOptionArr,
                   'extra_comment' => $request->extraComment,
                    'count' => 1
                ]);
                if ($pivotInsert) {
                    return response()->json(['message' => 'محصول مورد نظر شما به سبد خرید اضافه گردید', 'basketId' => $basket->id]);
                } else {
                    return response()->json(['message' => 'خطایی رخ داده است']);
                }

            } else {
                return response()->json(['message' => 'خطایی رخ داده است']);
            }
        }
    }
    /* below function is related to get basket count
       this function is in web service and client should
       send it cookie that can get basket count or notify
    */
    public function getBasketCountNotify(Request $request)
    {
        $count     = DB::table('basket_product')->where('basket_id',$request->basketId)->count();
        return response()->json(['basketCount' =>  $count]);
    }

    /*
     * below function is related to show products of
     * each category
     *  */
    public function showProducts($id)
    {
        $products = Category::find($id);
        foreach ($products->products as $product) {
            $product->productFlags = $product->productFlags;
            //$product->productScore = $product->scores;
            foreach ($product->productImages as $image )
            {
                $image->picture      = 'http://gushtomorghebaradaran.ir/'.'public/dashboard/productFiles/picture/'.$image->image_src;
            }

        }
        $count = count($products->products);
        $i = 0;
        while($i < $count)
        {
            foreach ($products->products[$i]->scores as $product) {
                $product->productScore = $this->productScore($products->products);
            }
            $i++;
        }
        return response()->json(['products' => $products->products]);
    }

    //below function is related to get basket content for web service
    public function getBasketTotalPrice(Request $request)
    {
        $baskets   = DB::table('basket_product')->where('basket_id',$request->basketId)->get();
        $totalPrice = '';
        foreach ($baskets as $basket)
        {
            $totalPrice  += $basket->count * $basket->product_price;
        }
        return response()->json(['basketTotalPrice' => $totalPrice]);
    }

    //below function is related to get basket content
    public function getBasketContent(Request $request)
    {
        $baskets  = Basket::find($request->basketId);
        foreach ($baskets->products as $product)
        {
            $product->count       = $product->pivot->count;
            $product->price       = $product->pivot->product_price;
            $product->basket_id   = $product->pivot->basket_id;
            $product->product_id  = $product->pivot->product_id;

        }
        return response()->json(['basketContent' => $baskets]);
    }

    //below function is related to remove item from basket
    public function removeItemFromBasket(Request $request)
    {
        $delete = DB::table('basket_product')->where([['basket_id',$request->basketId],['product_id',$request->productId]])->delete();
        $count  = DB::table('basket_product')->where('basket_id',$request->basketId)->count();
        if($delete)
        {
            return response()->json(['message' => 'محصول مورد نظر از سبد خرید حذف گردید' , 'code' => 1 , 'count' => $count]);
        }else
        {
            return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
        }
    }


    //below function is related to add or sub count of basket
    public function addOrSubCount(Request $request)
    {
        switch ($request->parameter)
        {
            case 'addToCount' :
                $update = DB::table('basket_product')->where([['basket_id',$request->basketId],['product_id',$request->productId]])->increment('count');
                if($update)
                {
                    return response()->json(['message' => 'یک واحد به محصول مورد اضافه گردید','code' => 1]);
                }else
                {
                    return response()->json(['message' => 'خطایی رخ داده است ، لطفا با بخش پشتیبانی تماس بگیرید','code' => 0]);
                }
                break;
            case 'subFromCount' :
                $update = DB::table('basket_product')->where([['basket_id',$request->basketId],['product_id',$request->productId]])->decrement('count');
                if($update)
                {
                    return response()->json(['یک واحد از محصول مورد نظر کسر گردید','code' => 1]);
                }else
                {
                    return response()->json(['message' => 'خطایی رخ داده است ، لطفا با بخش پشتیبانی تماس بگیرید','code' => 0]);
                }
                break;
        }
    }

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
                            $sender = "10004346";
                            $message = "با عرض سلام خدمت شما لطفا با رمز عبور زیر وارد پنل کاربری خود شوید و سپس پیگیر سفارشات خود باشید"."\n".$newPassword;
                            $receptor = $user->cellphone;
                            $result = Kavenegar::Send($sender,$receptor,$message);
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
                                
                            }

                                else
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
    public function addToOrder($request,$user,$newPassword)
    {
        $now = Carbon::now(new\DateTimeZone('Asia/Tehran'));
        $order = new Order();
        $order->user_id = $user->id;
        $order->user_coordination = trim($request->userCoordination);
        $order->date = $now->toDateString();
        $order->time = $now->toTimeString();
        $order->total_price = $request->totalPrice;
        $order->discount_price = $request->discountPrice;
        $order->factor_price = $request->factorPrice;
        $order->pay_price    = $request->totalPrice / 2;
        $order->user_cellphone = $request->userCellphone;
        $order->basket_id = $request->basketId;
        $order->payment_type = $request->paymentType;
        $order->comments     = $request->comments;
        $order->pay = 1;
        $order->transaction_code = 46456464;
        $order->save();
        if ($order) {
            $update = Basket::find($request->basketId);
            $update->payment = 1;
            $update->active = 0;
            $update->save();
            if ($update)
            {
                if ($newPassword == '') {
                        return response()->json(['message' => 'سفارش  شما با موفقیت ثبت گردید ، لطفا در جهت پیگیری سفارش خود وارد پنل شوید','code' => 'success']);
                    } else {
                        return response()->json(['message' => 'سفارش  شما با موفقیت ثبت گردید ، لطفا در جهت پیگیری سفارش خود با رمز عبور ارسال شده به تلفن همراه وارد پنل شوید','code' => 'success']);
                    }

            } else {
                return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
            }

        }
    }

    public function addCommentForEachProduct(Request $request)
    {
        $string = json_encode($request->jsonStr);
        $array = json_decode($string);
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
//        if($secondUpdate == true)
//        {
            return response()->json(['message' => 'جزئیات سفارش با موفقیت ثبت گردید' , 'code' => 'success']);
//        }else
//        {
//            return response()->json(['message' => 'خطا در ثبت اطلاعات ، لطفا با بخش پشتیبانی تماس بگیرید' , 'code' => 'error1']);
//        }
//        }
//        else
//        {
//            return response()->json(['message' => 'خطا در ثبت اطلاعات ، لطفا با بخش پشتیبانی تماس بگیرید' , 'code' => 'error2']);
//        }

    }

    public function productScore($products)
    {
        $i = 0;
        while (count($products) > $i) {
            foreach ($products[$i]->scores as $score) {
                $products[$i]->totalScore += $score->score;
                $products[$i]->count += 1;
                $products[$i]->productScore = $products[$i]->totalScore / $products[$i]->count;
            }
            $i++;
        }
    }


    public function productDetails($id)
    {
        $products = Product::where([['id', $id], ['active', 1]])->get();
        if (count($products) > 0) {
            $products[0]->produceDate = $this->toPersian($products[0]->produce_date);
            $products[0]->expireDate = $this->toPersian($products[0]->expire_date);
            foreach ($products[0]->productFlags as $flag)
            {
                $flag->price  = $flag->price;
            }
            foreach ($products[0]->productImages as $image)
            {
                $image->picture = 'http://gushtomorghebaradaran.ir/'.'public/dashboard/productFiles/picture/'.$image->image_src;
            }
            foreach ($products[0]->productOption as $option)
            {
                $option->title = $option->title;
            }
return response()->json(['productDetails' => $products[0]]);
        } else {
            return response()->json(['message' => 'محصول مورد نظر غیر فعال گردیده است']);
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

    }
}
