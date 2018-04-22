<?php
/**
 * Created by PhpStorm.
 * User: Artan
 * Date: 2/21/2018
 * Time: 2:16 PM
 */

namespace App\Http\SelfClasses;


use Illuminate\Support\Facades\DB;

class RollBackWarehouseCount
{
   //roll back warehouse count
    public function rollBackWarehouseCount($request)
    {
        $products = DB::table('basket_product')->where('basket_id',$request->basketId)->get();
        foreach ($products as $product)
        {
            $increment = DB::table('products')->where('id',$product->product_id)->increment('warehouse_count',$product->count);
        }
        if($increment)
        {
            return true;
        }else
            {
                return 'خطایی رخ داده است ، لطفا با بخش پشتیبانی تماس بگیرید';
            }
    }
}