<?php
/**
 * Created by PhpStorm.
 * User: Artan
 * Date: 11/29/2017
 * Time: 8:26 AM
 */

namespace App\Http\SelfClasses;


use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductFlag;
use App\Models\ProductImage;
use App\Models\ProductOption;
use App\Models\ProductSize;
use App\Models\SubUnitCount;
use App\Models\UnitCount;
use Hekmatinasser\Verta\Verta;

class AddProduct
{
    public function addProduct($product)
    {
        function addCategoryProduct($pId, $cateId)
        {
            $productCategory = new CategoryProduct();
            $productCategory->product_id = $pId;
            $productCategory->category_id = $cateId;
            $productCategory->active = 1;
            $productCategory->save();
        }

        //add a flags with flag's price in product flags
        function addProductFlag($active, $title, $price, $lastProductId)
        {
            $prices = new ProductFlag();
            $prices->title = $title;
            $prices->product_id = $lastProductId;
            //set active price for product
            if ($active == $title)
                $prices->active = 1;
            else
                $prices->active = 0;
            $prices->price = str_replace(',', '', $price);//remove separator number from price before save
            $prices->save();
        }

        //upload product's video
        $videoSrc = '';
        if (!empty($product->video_src)) {
            $file = $product->video_src;
            $videoSrc = $file->getClientOriginalName();
            $file->move('public/dashboard/productFiles/video/', $videoSrc);
        }

        $unit_count = UnitCount::where('id', '=', $product->unit_count)->value('title');
        $sub_unit_count = SubUnitCount::where('id', '=', $product->sub_unit_count)->value('title');
        //add a new product in product table
        $pr = new Product();
        $pr->title = $product->title;
        $pr->description = $product->description;
        $pr->discount = $product->discount;
        $pr->produce_date = $this->dateConvert($product->produce_date);
        $pr->expire_date = $this->dateConvert($product->expire_date);
        $pr->produce_place = $product->produce_place;
        $pr->unit_count = $unit_count;
        $pr->sub_unit_count = $sub_unit_count;
        $pr->ready_time = $product->ready_time;
        $pr->video_src = $videoSrc;
        $pr->delivery_volume = $product->delivery_volume;
        $pr->warehouse_count = $product->warehouse_count;
//        $pr->warehouse_place = $product->warehouse_place;
        $pr->barcode = $product->barcode;
        if (!empty($product->post_price))
            $pr->post_price = str_replace(',', '', $product->post_price);
        else
            $pr->post_price = 0;
        $pr->save();
        $lastProductId = $pr->id;
        //above line find product_id that now saved for use in pivot table
        // $lastProductId = Product::orderBy('created_at', 'desc')->offset(0)->limit(1)->value('id');
        //this block code save color array of product in color_product table
//        $countColor = count($product->color);
//        if ($countColor) {
//            for ($i = 0; $i < $countColor; $i++) {
//                $productColor = new ProductColor();
//                $productColor->product_id = $lastProductId;
//                $productColor->color_id = $product->color[$i];
//                $productColor->active = 1;
//                $productColor->save();
//            }
//        }
//        //this block code save size array of product in product_size table
//        $countSize = count($product->size);
//        if ($countSize) {
//            for ($i = 0; $i < $countSize; $i++) {
//                $productColor = new ProductSize();
//                $productColor->product_id = $lastProductId;
//                $productColor->size_id = $product->size[$i];
//                $productColor->active = 1;
//                $productColor->save();
//
//            }
//
//        }
        //this block code save and upload picture array of product in product_Images table
        $countPic = count($product->file);
        if ($countPic) {
            for ($i = 0; $i < $countPic; $i++) {
                $productPicture = new ProductImage();
                $productPicture->product_id = $lastProductId;
                $imageExtension = $product->file[$i]->getClientOriginalExtension();
                $imageName = microtime(true);
                $productPicture->image_src = $imageName . '.' . $imageExtension;
                $product->file[$i]->move('public/dashboard/productFiles/picture/', $imageName . '.' . $imageExtension);
                $productPicture->active = 1;
                $productPicture->save();
            }
        }
        /**this block code save flags and prices of product in product_flags table
         * by calling addProductFlag(title of flag, price of flag, product_id) **/

        addProductFlag($product->activePrice, 'price', $product->price, $lastProductId);

        if (!empty($product->special_price)) {
            addProductFlag($product->activePrice, 'special_price', $product->special_price, $lastProductId);
        } else {
            addProductFlag($product->activePrice, 'special_price', 0, $lastProductId);
        }
        if (!empty($product->wholesale_price)) {
            addProductFlag($product->activePrice, 'wholesale_price', $product->wholesale_price, $lastProductId);
        } else {
            addProductFlag($product->activePrice, 'wholesale_price', 0, $lastProductId);
        }
        if (!empty($product->sales_price)) {
            addProductFlag($product->activePrice, 'sales_price', $product->sales_price, $lastProductId);
        } else {
            addProductFlag($product->activePrice, 'sales_price', 0, $lastProductId);
        }
        if (!empty($product->free_price)) {
            addProductFlag($product->activePrice, $product, 'free_price', $product->free_price, $lastProductId);
        } else {
            addProductFlag($product->activePrice, 'free_price', 0, $lastProductId);
        }
        /**this section check user select which level of categories
         *and insert row to category_product table with latest product_id and category_id
         **/
        addCategoryProduct($lastProductId, $product->subCategories);

        //add product options
        $countOption = count($product->option);
        //if any option send and not empty
        if ($countOption && $product->option[0] != "") {
            for ($i = 0; $i < $countOption; $i++) {
                if ($product->option[$i] != "") {
                    $productOption = new ProductOption();
                    $productOption->product_id = $lastProductId;
                    $productOption->title = $product->option[$i];
                    $productOption->active = 1;
                    $productOption->save();
                }
            }
        }
        return (true);
    }

    //below function is related to convert jalali date to Milady date
    function dateConvert($jalaliDate)
    {
        if (count($jalaliDate) > 0) {
            if ($date = explode('/', $jalaliDate)) {
                $year = $date[0];
                $month = $date[1];
                $day = $date[2];
            }
            $gDate = $this->jalaliToGregorian($year, $month, $day);
            $gDate = $gDate[0] . '-' . $gDate[1] . '-' . $gDate[2];
            return $gDate;
        }
        return;
    }

    public
    function jalaliToGregorian($year, $month, $day)
    {
        return Verta::getGregorian($year, $month, $day);
    }
}
