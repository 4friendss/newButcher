<?php

namespace App\Http\Controllers;

use App\Http\SelfClasses\AddProduct;
use App\Http\SelfClasses\CheckFiles;
use App\Http\SelfClasses\CheckJalaliDate;
use App\Http\SelfClasses\CheckProduct;
use App\Http\SelfClasses\CheckUpdateProduct;
use App\Http\SelfClasses\NotToBeRepeated;
use App\Http\SelfClasses\UpdateProduct;
use App\Models\Product;
use App\Models\ProductImage;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use App\Models\ProductOption;

class ProductController extends Controller
{
    public function addProduct()
    {
        $pageTitle = 'درج محصول';
        return view('admin.addProduct', compact('pageTitle'));
    }

    public function productsManagement()
    {
        $pageTitle = 'مدیریت محصولات';
        $data = Product::all();
        foreach ($data as $datum) {
            $datum->date = $this->toPersian($datum->created_at->toDateString());
        }
        return view('admin.productManagement', compact('data', 'pageTitle'));
    }

    //add new product to database
    public function addNewProduct(Request $request)
    {
        $notToBeRepeated = new NotToBeRepeated();
        $checkTitles = $notToBeRepeated->notToBeRepeated($request,'product');
        if(is_bool($checkTitles))
        {
            $checkJalaliDate = new CheckJalaliDate();
            $dateResult = $checkJalaliDate->checkDate($request);
            if ($dateResult == "true") {
                $checkProduct = new CheckProduct();
                $result = $checkProduct->ProductValidate($request);
                if ($result == "true") {
                    $checkFiles = new CheckFiles();
                    $result = $checkFiles->checkCategoryFiles($request ,'');
                    if (is_bool($result)) {
                        $addNewProduct = new AddProduct();
                        $ans = $addNewProduct->addProduct($request);
                        if ($ans == "true")
                            return response()->json(['data' => 'محصول شما با مؤفقیت درج شد']);
                        else
                            return response()->json(['data' => 'خطایی رخ داده است، -لطفا با بخش پشتیبانی تماس بگیرید.']);
                    } else
                        return response()->json(['message' => $result, 'code' => '1']);
                } else {
                    return response()->json($result);
                }
            } else {
                return response()->json(['data' => 'تاریخ را بطور صحیح وارد نمائید : 1396/09/19']);
            }
        }else
            {
                return response()->json(['data' => $checkTitles]);
            }
    }

    //update product to database
    public function updateProduct(Request $request)
    {
        $checkJalaliDate = new CheckJalaliDate();
        $dateResult = $checkJalaliDate->checkDate($request);
        if ($dateResult == "true") {
            $checkProduct = new CheckUpdateProduct();
            $result = $checkProduct->ProductValidate($request);
            if ($result == "true") {
                $checkFiles = new CheckFiles();
                $result = $checkFiles->checkCategoryFiles($request , '');
                if (is_bool($result)) {
                    $UpdateProduct = new UpdateProduct();
                    $ans = $UpdateProduct->UpdateProduct($request);
                    if ($ans == "true")
                        return response()->json(['data' => 'ویرایش محصول شما با مؤفقیت انجام شد']);
                    else
                        return response()->json(['data' => 'خطایی رخ داده است، -لطفا با بخش پشتیبانی تماس بگیرید.', 'ans' => $ans]);
                } else
                    return response()->json(['message' => $result, 'code' => '1']);
            } else {
                return response()->json($result);
            }
        } else {
            return response()->json(['data' => 'تاریخ را بطور صحیح وارد نمائید : 1396/09/19']);
        }
    }

    public function productDetailsGet($id)
    {
        $pageTitle = 'ویرایش محصول';
        $products = Product::where([['id', $id], ['active', 1]])->get();
        if (count($products) > 0) {
            $products[0]->produceDate = $this->toPersian($products[0]->produce_date);
            $products[0]->expireDate = $this->toPersian($products[0]->expire_date);
            return view('admin.productDetails', compact('products', 'pageTitle'));
        } else {
            return view('errors.403');
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

    //delete product picture from '/dashboard/productFiles/picture/' and from product_images table
    // call this me by ajax from productDetails for updating and change products picture
    public function deleteProductPicture($id)
    {
        $ImageName = ProductImage::where('id', '=', $id)->value('image_src');
        $srcImage = '/dashboard/productFiles/picture/' . $ImageName;
        $res=unlink(public_path().$srcImage);
        $res1 = ProductImage::destroy($id);
        if ($res1 == 1 && $res == 1)
            return response()->json(true);
    }

    //below function is related to change product status
    public function changeProductStatus(Request $request,$parameter)
    {
        switch ($parameter)
        {
            case 'disable':
                $product = Product::find($request->productId);
                $product->active = 0;
                $product->save();
                if($product)
                {
                    return response()->json(['message' => 'محصول مورد نظر شما غیر فعال گردید' , 'code' => 'success']);
                }else
                    {
                        return response()->json(['message' => 'خطایی رخ داده است' , 'code' => 'error']);
                    }
            break;
            case 'enable':
                $product = Product::find($request->productId);
                $product->active = 1;
                $product->save();
                if($product)
                {
                    return response()->json(['message' => 'محصول مورد نظر شما  فعال گردید' , 'code' => 'success']);
                }else
                {
                    return response()->json(['message' => 'خطایی رخ داده است' , 'code' => 'error']);
                }
            break;
        }
    }

    //below function is to delete video of product
    public function deleteVideo(Request $request)
    {
        $videoName = Product::where('id',$request->productId)->value('video_src');
        if($videoName)
        {
            $product = Product::find($request->productId);
            $product->video_src = '';
            $product->save();
            if($product)
            {
                $videoSrc = '/dashboard/productFiles/video/' . $videoName;
                $result   = unlink(public_path().$videoSrc);
                if($result)
                {
                    return response()->json(['message' => 'success']);
                }
                else
                {
                    return response()->json(['message' => 'error']);
                }
            }
        }

    }
}