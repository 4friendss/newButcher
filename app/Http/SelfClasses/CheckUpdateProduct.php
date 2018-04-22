<?php
/**
 * Created by PhpStorm.
 * User: Artan
 * Date: 11/30/2017
 * Time: 9:33 AM
 */

namespace App\Http\SelfClasses;

use Illuminate\Support\Facades\Validator;

class CheckUpdateProduct
{
    public function ProductValidate($request)
    {
        $validation=Validator::make($request->all(),[

            'categories' => 'sometimes|nullable|numeric',
            'subCategories' => 'sometimes|nullable|numeric',
            'brands' => 'sometimes|nullable|numeric',
            'title' => 'sometimes|nullable||max:255',
            'description' => 'sometimes|nullable|',
            'unit_count' => 'sometimes|nullable|',
            'sub_unit_count' => 'sometimes|nullable',
            'produce_date' => 'sometimes|nullable|max:10|min:8',
            'expire_date' => 'sometimes|nullable|max:10|min:8',
            'produce_place' => '',
            'warehouse_count' => 'sometimes|nullable|numeric',
            'warehouse_place' => '',
            'ready_time' => 'sometimes|nullable|numeric',
            'barcode' => 'sometimes|nullable|numeric',
            'price' => 'sometimes|nullable|',
            'sales_price' => 'sometimes|nullable',
            'special_price' => 'sometimes|nullable',
            'wholesale_price' => 'sometimes|nullable',
            'free_price' => 'sometimes|nullable',
            'discount' => 'sometimes|nullable|numeric|',
            'discount_volume' => 'sometimes|nullable|numeric',
            'delivery_volume' => 'sometimes|nullable|numeric',
            'video_src' => 'sometimes|nullable|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:4096',
            'pic[]' => 'sometimes|nullable|image|max:2',
        ],
            [
                'categories.numeric'=>'فیلد دسته بندی را دستکاری نفرمائید',
                'categories.required'=>'فیلد دسته بندی الزامی است',
                'title.required'=>'فیلد عنوان الزامی است',
                'description.required'=>'فیلد توضیحات الزامی است',
                'unit_count_id.required'=>'فیلد واحد شمارش الزامی است',
                'sub_unit_count_id.required'=>'فیلد زیرواحد شمارش الزامی است',
                'price.required'=>'فیلد قیمت الزامی است',
                'video_src.mimetypes'=>'فرمت ویدئوی انتخاب شده اشتباه است ',
                'pic[].image'=>'فرمت تصویر یا تصاویر انتخاب شده اشتباه است ',
            ]);
        $errors = $validation->errors();
        if(!$errors->isEmpty())
            return $errors;
        else
            return "true";
    }
}