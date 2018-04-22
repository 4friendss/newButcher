<?php

namespace App\Http\Controllers;

use App\Http\SelfClasses\AddCategory;
use App\Http\SelfClasses\CheckFiles;
use App\Http\SelfClasses\NotToBeRepeated;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
{
    //below function is related to add new category
    public function addNewCategory(Request $request)
    {
        $notToBeRepeated = new NotToBeRepeated();
        $titleCheck      = $notToBeRepeated->notToBeRepeated($request,'category');
        if(is_bool($titleCheck))
        {
            $checkFiles = new CheckFiles();
            $result =$checkFiles->checkCategoryFiles($request);
            if(is_bool($result))
            {
                $addNewCategory = new AddCategory();
                $result1 = $addNewCategory->addNewCategory($request->category,$request);
                if($result1)
                {
                    return response()->json(['message' => $result1 , 'code' => 1]);
                }
            }else
            {
                return response()->json(['message' => $result , 'code' => 0]);
            }
        }
        else
        {
            return response()->json(['message' => $titleCheck , 'code' => 0]);
        }
    }

    //below function returns addCategory blade....
    public function addCategory()
    {
        $pageTitle = 'اضافه کردن دسته ها';
        return view('admin.addCategory',compact('pageTitle'));
    }


    //below function is to returns all categories to the categoriesManagement blade....
    public function categoriesManagement()
    {
        $pageTitle = 'مدیریت دسته ها';
        $categories = Category::where('parent_id',null)->get();
        return view('admin.categoriesManagement',compact('categories','pageTitle'));
    }

    //below function is related to edit main category
    public function editCategory($id)
    {
        $pageTitle = 'ویرایش دسته';
        $categoryInfo = Category::where('id',$id)->get();
        if(count($categoryInfo) > 0)
        {
            return view('admin.editCategory',compact('categoryInfo','pageTitle'));
        }else
            {
                return view('errors.403');
            }

    }
    //below function is related to edit main category
    public function showSubCategory($id)
    {
        $pageTitle = 'مدیریت دسته ها';
        $categoryInfo = Category::where([['parent_id',$id],['title','<>','سایر']])->get();
        if(count($categoryInfo) > 0)
        {
            return view('admin.showSubCategory',compact('categoryInfo','pageTitle'));
        }
        else
            {
                return view('errors.403');
            }
    }


    //below function is related to edit category picture
    public function editCategoryPicture(Request $request)
    {
        $checkFiles = new CheckFiles();
        $result = $checkFiles->checkCategoryFiles($request,'');
        if(is_bool($result))
        {
            $category = Category::find($request->categoryId);
            $file = $request->file[0];
            $imageExtension = $file->getClientOriginalExtension();
            $imageName=microtime(true);
            $file->move('public/dashboard/image/', $imageName.'.'.$imageExtension);
            $category->image_src = $imageName.'.'.$imageExtension;
            $category->save();
            if($category){
                return response()->json('ویرایش با موفقیت انجام گردید');
            }
        }else
            {
                return response()->json(['message' => $result , 'code' => '1']);
            }
    }

    //below function is related to edit category title
    public function editCategoryTitle(Request $request)
    {
        $category = Category::find($request->id);
        $category->title = trim($request->title);
        $category->save();
        if($category)
        {
            return response()->json(['message' => 'ویرایش با موفقیت انجام گردید' , 'code' => 1 ]);
        }else
            {
                return response()->json(['message' => 'خطایی در عملیات ویرایش رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
            }
    }

    //below function is related to make categories enable or disable
    public function enableOrDisableCategory(Request $request)
    {
        if(!$request->ajax())
        {
            abort(403);
        }
        else
            {
                switch ($request->active)
                {
                    case 1 :
                        $update = DB::table('categories')->where('id',$request->categoryId)->update(['active' => 0 ]);
                        if($update)
                        {
                            return response()->json(['message' => 'دسته مورد نظر شما غیر فعال گردید' , 'code' => '1']);
                        }else
                            {
                                return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
                            }
                    break;

                    case 0 :
                        $update = DB::table('categories')->where('id',$request->categoryId)->update(['active' => 1 ]);
                        if($update)
                        {
                            return response()->json(['message' => 'دسته مورد نظر شما  فعال گردید' , 'code' => '1']);
                        }else
                        {
                            return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
                        }
                    break;

                }
            }
    }

}
