<?php
/**
 * Created by PhpStorm.
 * User: Artan
 * Date: 2/21/2018
 * Time: 9:43 AM
 */

namespace App\Http\SelfClasses;


use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckProductExistence
{
    //zero checks
    public function checkProductExistence($request)
    {
        $products    = DB::table('basket_product')->where('basket_id',$request->basketId)->get();
        $notExistenceProducts = '';
        foreach ($products as $product)
        {
            if(DB::table('products')->where([['id',$product->product_id],['warehouse_count','<>',0]])->count() == 0)
            {
               $notExistenceProducts .= DB::table('products')->where('id',$product->product_id)->value('title')."\n";
            }
        }
//        if($notExistenceProducts)
//        {
            return $this->lessThanOrder($notExistenceProducts , $products);
        //}
    }

    //less than order checks
    public function lessThanOrder($notExistenceProducts , $products)
    {
        $lessThanProducts = '';
        foreach ($products as $product)
        {
            if(DB::table('products')->where([['id',$product->product_id],['warehouse_count','<',$product->count]])->count() > 0)
            {
                $lessThanProducts .= DB::table('products')->where('id',$product->product_id)->value('title')
                                     .' '. ' تعداد موجود در انبار :'.
                                     DB::table('products')->where('id',$product->product_id)->value('warehouse_count')."\n";
            }
        }
        if($lessThanProducts != '' && $notExistenceProducts != '')
        {
            return ' کاربر گرامی' ."\n" .': محصول یا محصولات زیر موجود نیستند ، لطفا آنها را از سبد خرید حذف نمائید  '."\n".$notExistenceProducts
                      ."\n".': تعداد محصول یا محصولات زیر را مطابق با تعداد موجود در انبار کاهش دهید'."\n".$lessThanProducts ;
        }elseif ($lessThanProducts != '' && $notExistenceProducts == '')
        {
            return ': کاربر گرامی '."\n ".': تعداد محصول یا محصولات زیر را مطابق با تعداد موجود در انبار کاهش دهید'. "\n".$lessThanProducts;
        }elseif ($lessThanProducts == '' && $notExistenceProducts != '')
        {
            return ': کاربر گرامی محصول یا محصولات زیر موجود نیستند ، لطفا آنها را از سبد خرید حذف نمائید'."\n".$notExistenceProducts;
        }else if($lessThanProducts == '' && $lessThanProducts == '')
            {
                return $this->decrementWarehouseCount($products);
            }
    }

    //decrement warehouseCount
    public function decrementWarehouseCount($products)
    {
        foreach ($products as $product)
        {
            $decrement = DB::table('products')->where('id',$product->product_id)->decrement('warehouse_count',$product->count);
        }
        if($decrement)
        {
            return true;
        }else
            {
                return 'خطایی رخ داده است ، لطفا با بخش پشتیبانی تماس بگیرید';
            }
    }
}