<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Color;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubUnitCount;
use App\Models\UnitCount;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;

class CommonController extends Controller
{
    //below function is to get main categories from database
    public function getMainCategories()
    {
        $mainCategories = Category::where([['parent_id', null], ['active', 1]])->get();
        if (count($mainCategories) > 0) {
            return response()->json($mainCategories);
        } else {
            return response()->json(0);
        }
    }

    //below function is to get sub categories from database
    public function getSubCategories($id)
    {
        $subCategories = Category::where([['parent_id', $id], ['active', 1], ['title', '<>', 'سایر']])->get();
        if (count($subCategories) > 0) {
            return response()->json($subCategories);
        } else {
            return response()->json(0);
        }

    }

    //below function is to get brands from database
    public function getBrands($id)
    {
        $brands = Category::where([['parent_id', $id], ['active', 1], ['title', '<>', 'سایر']])->get();
        if (count($brands) > 0) {
            return response()->json($brands);
        } else {
            return response()->json(0);
        }
    }

    //below function is to get brands from database
    //if has product = 0 this category dose not show in menu
    public function getSubmenu($id)
    {
        $submenu = Category::where([['parent_id', $id], ['active', 1]])->orderBy('depth', 'DESC')->get();
        $catImg = Category::where('id','=',$id)->value('image_src');
        foreach ($submenu as $sm) {
            $x= CategoryProduct::where([['category_id', $sm->id], ['active', 1]])->value('id');
            if ($x>0)
                $sm->hasProduct = 1;
            else
                $sm->hasProduct = 0;
        }
        if (count($submenu) > 0) {
            return response()->json(['submenu' => $submenu,'catImg'=>$catImg]);
        } else {
            return response()->json(0);
        }
    }

    //below function is to get main units from database
    public function getMainUnits()
    {
        $mainUnits = UnitCount::all();
        if (count($mainUnits) > 0) {
            return response()->json($mainUnits);
        } else {
            return response()->json(0);
        }

    }

    //below function is to get sub units from database
    public function getSubunits($id)
    {
        $subUnits = SubUnitCount::where('unit_count_id', $id)->orderBy('title')->get();
        if (count($subUnits) > 0) {
            return response()->json($subUnits);
        } else {
            return response()->json(0);
        }

    }

    //below function is to get sub units from sub_unit table by sub unit's title
    public function getSubunitsBySubUnitTitle(Request $request)
    {
        $title = $request->title;
        $unitId = SubUnitCount::where([['title', $title], ['active', 1]])->value('id');
        $subUnits = SubUnitCount::where([['unit_count_id', $unitId], ['active', 1]])->get();
        if (count($subUnits) > 0) {
            return response()->json($subUnits);
        } else {
            return response()->json(0);
        }
    }

    public function getExistedCategories($id)
    {
        $existedCategories = DB::table('categories')->where([['parent_id', $id], ['active', 1], ['title', '<>', 'سایر']])->get();
        if (count($existedCategories) > 0) {
            return response()->json($existedCategories);
        } else {
            return response()->json(0);
        }
    }

    public function findCategoryProduct(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);
        $title = Array();
        $i = 0;
        foreach ($category->products as $pr) {
            $title[$i] = Product::where([['id', $pr->pivot->product_id], ['active', 1]])->value('title');
            $i++;
        }
        return response()->json($title);
    }

    //below function is related to existed colors
    public function getColors()
    {
        $colors = Color::all();
        if (count($colors) > 0) {
            return response()->json($colors);
        } else {
            return response()->json(0);
        }
    }

    //below function is related to existed sizes
    public function getSizes()
    {
        $sizes = Size::where('active', '=', '1')->get();
        if (count($sizes) > 0) {
            return response()->json($sizes);
        } else {
            return response()->json(0);
        }
    }

    //below function is related to existed payment types
    public function getPaymentTypes()
    {
        $paymentTypes = PaymentType::all();
        if (count($paymentTypes) > 0) {
            return response()->json($paymentTypes);
        } else {
            return response()->json(0);
        }
    }

    //below function is related to show disabled categories of each category
    public function getDisabledCategories($id)
    {
        $disabledCategories = Category::where([['parent_id', $id], ['active', 0]])->get();
        if (count($disabledCategories) > 0) {
            return response()->json($disabledCategories);
        } else {
            return response()->json(0);
        }
    }

    // below function is related to get all disabled categories
    public function getAllDisabledCategories()
    {
        $disabledCategories = Category::where('active', 0)->get();
        if (count($disabledCategories) > 0) {
            return response()->json($disabledCategories);
        } else {
            return response()->json(0);
        }
    }
}
