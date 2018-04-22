<?php

namespace App\Http\Controllers;

use App\Models\SubUnitCount;
use App\Models\UnitCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    //below function  is related to add new unit counts and
    public function addNewUnit(Request $request)
    {
        if (!$request->ajax()) {
            abort(403);
        } else {
            if ($request->unitId == '') {
                $count = count($request->unit);
                $i = 0;
                while ($i < $count) {
                    $insert = DB::table('unit_counts')->insertGetId
                    ([
                        'title' => trim($request->unit[$i]),
                    ]);
                    $i++;
                }
                if ($insert) {
                    return response()->json('اطلاعات با موفقیت ثبت شد');
                }
            } else {
                $count = count($request->unit);
                $i = 0;
                while ($i < $count) {
                    $insert = DB::table('sub_unit_counts')->insertGetId
                    ([
                        'title' => trim($request->unit[$i]),
                        'unit_count_id' => $request->unitId,
                    ]);
                    $i++;
                }
                if ($insert) {
                    return response()->json('اطلاعات با موفقیت ثبت شد');
                }
            }

        }
    }

    //below function returns addUnit blade...
    public function addUnit()
    {
        $pageTitle = 'افزودن واحد های شمارش';
        return view('admin.addUnit',compact('pageTitle'));
    }

    //below function returns unitsManagement blade ...
    public function unitCountManagement()
    {
        $pageTitle = 'مدیریت واحد های شمارش';
        $data= UnitCount::all();
        return view('admin.unitCountManagement',compact('data','pageTitle'));
    }

    //below function is related to return view show sub unit count
    public function subUnitManagement($id)
    {
        $pageTitle = 'مدیریت زیر واحد های شمارش';
        $subUnits = SubUnitCount::where('unit_count_id',$id)->get();
        if(count($subUnits) > 0)
        {
            return view('admin.subUnitManagement',compact('subUnits','pageTitle'));
        }else
            {
                return view('errors.403');
            }
    }

    //below function is to return editUnitCount view
    public function editUnitCount($id)
    {
        $pageTitle = 'ویرایش واحد شمارش';
        $unitCount = UnitCount::where('id',$id)->get();
        if(count($unitCount) > 0)
        {
            return view('admin.editUnitCount',compact('unitCount','pageTitle'));
        }else
        {
            return view('errors.403');
        }
    }

    //below function is related to edit unit count title
    public function editUnitCountTitle(Request $request)
    {
        if(!$request->ajax())
        {
            abort(403);
        }else
            {
                switch ($request->parameter)
                {
                    case 'unitCount':
                        $unitCount = UnitCount::find($request->id);
                        $unitCount->title = trim($request->title);
                        $unitCount->save();
                        if($unitCount)
                        {
                        return response()->json(['message' => 'ویرایش با موفقیت انجام گردید' , 'code' => 1 ]);
                        }else
                        {
                            return response()->json(['message' => 'خطایی در عملیات ویرایش رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
                        }
                    break;

                    case 'subUnitCount':
                        $unitCount = SubUnitCount::find($request->id);
                        $unitCount->title = trim($request->title);
                        $unitCount->save();
                        if($unitCount)
                        {
                            return response()->json(['message' => 'ویرایش با موفقیت انجام گردید' , 'code' => 1 ]);
                        }else
                        {
                            return response()->json(['message' => 'خطایی در عملیات ویرایش رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
                        }
                    break;
                }

            }

    }

    //below function is related to make unit counts enable or disable
    public function enableOrDisableUnitCount(Request $request)
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
                    $update = DB::table('unit_counts')->where('id',$request->unitId)->update(['active' => 0 ]);
                    if($update)
                    {
                        return response()->json(['message' => 'واحد شمارش مورد نظر شما غیر فعال گردید' , 'code' => '1']);
                    }else
                    {
                        return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
                    }
                    break;
                case 0 :
                    $update = DB::table('unit_counts')->where('id',$request->unitId)->update(['active' => 1 ]);
                    if($update)
                    {
                        return response()->json(['message' => 'واحد شمارش مورد  نظر شما  فعال گردید' , 'code' => '1']);
                    }else
                    {
                        return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
                    }
                    break;
            }
        }
    }


    //below function is related to make sub unit counts enable or disable
    public function enableOrDisableSubUnitCount(Request $request)
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
                    $update = DB::table('sub_unit_counts')->where('id',$request->subUnitId)->update(['active' => 0 ]);
                    if($update)
                    {
                        return response()->json(['message' => 'واحد شمارش مورد نظر شما غیر فعال گردید' , 'code' => '1']);
                    }else
                    {
                        return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
                    }
                    break;

                case 0 :
                    $update = DB::table('sub_unit_counts')->where('id',$request->subUnitId)->update(['active' => 1 ]);
                    if($update)
                    {
                        return response()->json(['message' => 'واحد شمارش مورد نظر شما  فعال گردید' , 'code' => '1']);
                    }else
                    {
                        return response()->json(['message' => 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
                    }
                    break;

            }
        }
    }
}
