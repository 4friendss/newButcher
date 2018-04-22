<?php

namespace App\Http\SelfClasses;

use App\Http\Requests\CategoryFilesValidate;
use App\Models\Categories;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AddCategory
{
    //below function is related to add categories
    public function addNewCategory($category, $request)
    {
        //the below block of code is related to step one that shop manager wants to register main categories
        $count = count($category);
        if ($count > 0)
        {
            if ($request->mainId == '' && $request->subId == '')
            {
                $i = 0;
                while ($i < $count)
                {
                    $categories = new Category();
                    $categories->title = trim($category[$i]);
                    if (!empty($request->file[$i]))
                    {
                        $file = $request->file[$i];
                        $imageExtension = $file->getClientOriginalExtension();
                        $imageName=microtime(true);
                        $file->move('public/dashboard/image/', $imageName.'.'.$imageExtension);
                        $categories->image_src = $imageName.'.'.$imageExtension;
                    }
                    $categories->save();
                    $i++;
                }
                if ($categories)
                {
                    return ('اطلاعات با موفقیت ثبت گردید ، لطفا جهت ثبت دسته جدید ابتدا دسته های موجود را بررسی نمائید ، تا از بروز هرگونه مشکلی جلوگیری بعمل آید ');
                }else
                    {
                        return ('خطا در ثبت اطلاعات، لطفا با بخش پشتیبانی تماس بگیرید');
                    }
            }
            //the below block of code is related to step two that shop manager wants to register sub categories
            if ($request->mainId != '' && $request->subId == '')
            {
                $count = count($category);
                $i = 0;
                while ($i < $count)
                {
                     $categories = new Category();
                     $categories->title = trim($category[$i]);
                     if (!empty($request->file[$i]))
                     {
                         $file = $request->file[$i];
                         $imageExtension = $file->getClientOriginalExtension();
                         $imageName=microtime(true);
                         $file->move('public/dashboard/image/', $imageName.'.'.$imageExtension);
                         $categories->image_src = $imageName.'.'.$imageExtension;
                     }
                     $categories->parent_id = $request->mainId;
                     $categories->save();
                     $i++;
                }
                $update = DB::table('categories')->where('id', $request->mainId)->update(['depth' => 1]);
                    if ($update)
                    {
                       return ('اطلاعات با موفقیت ثبت گردید ، لطفا جهت ثبت دسته جدید ابتدا دسته های موجود را بررسی نمائید ، تا از بروز هرگونه مشکلی جلوگیری بعمل آید ');
                    }else
                            {
                                return ('خطا در ثبت اطلاعات، لطفا با بخش پشتیبانی تماس بگیرید');
                            }
            }

        }else
            {
                return ('ابتدا فیلدهای مربوطه را پر نمایید سپس ثبت نهایی را بزنید');
            }
    }

}




