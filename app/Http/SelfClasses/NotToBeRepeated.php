<?php
/**
 * Created by PhpStorm.
 * User: Artan
 * Date: 12/2/2017
 * Time: 1:25 PM
 */

namespace App\Http\SelfClasses;


use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class NotToBeRepeated
{
    public function notToBeRepeated($request,$parameter)
    {
        switch ($parameter)
        {
            //below block of code is to check title of products not to be repeated
            case 'product' :
                  $categoryId = 0;
                  if($request->categories != null && $request->subCategories == null)
                  {
                        $categoryId += $request->categories;
                        $otherId     = DB::table('categories')->where([['parent_id',$categoryId],['title','سایر']])->value('id');
                        return $this->checkProductTitle($otherId,$request);
                  }
                  elseif($request->subCategories !=null && $request->brands == null)
                  {
                        $categoryId += $request->subCategories;
                        $otherId     = DB::table('categories')->where([['parent_id',$categoryId],['title','سایر']])->value('id');
                        return $this->checkProductTitle($otherId,$request);
                  }
                  elseif($request->brnads != null)
                  {
                        $categoryId += $request->brands;
                        return $this->checkProductTitle($categoryId,$request);
                  }
                  else
                      {
                          return 'لطفا دسته ای را انتخاب نمائید سپس درخواست ثبت محصول را بزنید';
                      }
            break;
            //below block of code is to check title of categories not to be repeated
            case 'category':
                $titles = '';
                $categories = Category::all();
                $count      = count($request->category);
                $i = 0;
                while($i < $count)
                {
                    foreach ($categories as $category)
                    {
                       if($category->title == trim($request->category[$i]))
                       {
                          $titles .="\n". $request->category[$i];
                       }
                    }
                    $i++;
                }
                if($titles != '')
                {
                    return 'دسته یا دسته های زیر قبلا ذخیره شده اند'. "\n".$titles;
                }else
                    {
                        return true;
                    }
            break;
        }
    }

    //below function is to check titles of products
    public function checkProductTitle($id,$request)
    {
        $productId = DB::table('category_product')->where('category_id',$id)->pluck('product_id');
        if(DB::table('products')->whereIn('id',$productId)->where('title',trim($request->title))->count() > 0)
        {
            return 'محصولی با این عنوان قبلا ذخیره گردیده است';
        }
        else
        {
            return true;
        }

    }
}