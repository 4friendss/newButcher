<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentTypeController extends Controller
{
    //below function is related to return add payment view
    public function addPaymentType()
    {
        $pageTitle = 'افزودن وضعیت پرداخت';
        return view('admin.addPaymentType',compact('pageTitle'));
    }


    //below function is related to add new payment types in data base
    public function addNewPaymentTypes(Request $request)
    {
        $count = count($request->paymentTypes);
        $i = 0;
        while($i < $count)
        {
            $newPaymentTypes = new PaymentType();
            $newPaymentTypes->title = trim($request->paymentTypes[$i]);
            $newPaymentTypes->save();
            $i++;
        }

        if($newPaymentTypes)
        {
            return response()->json(['message' => 'اطلاعات با موفقیت ثبت شد', 'code' => '1']);
        }else
        {
            return response()->json(['message' => 'خطایی در ثبت اطلاعات رخ داده است ، با بخش پشتیبانی تماس بگیرید']);
        }
    }


    //
    public function paymentTypesManagement()
    {
        $pageTitle = 'مدیریت و نمایش وضعیتهای پرداخت';
        $data = PaymentType::all();
        return view('admin.paymentTypesManagement',compact('data','pageTitle'));
    }

    //
    public function editPaymentType($id)
    {
        $pageTitle = 'ویرایش وضعیت پرداخت';
        $data = PaymentType::where('id',$id)->get();
        if(count($data) > 0)
        {
            return view('admin.editPaymentType',compact('data','pageTitle'));
        }else
        {
            return view('errors.403');
        }
    }

    //below function is related toi edit size title
    public function editPaymentTypeTitle(Request $request)
    {
        if(!$request->ajax())
        {
            abort(403);
        }else
        {
            $update = PaymentType::find($request->id);
            $update->title = trim($request->title);
            $update->save;
            if($update)
            {
                return response()->json(['message' => 'ویرایش با موفقیت انجام شد' , 'code' => '1']);
            }
            else
            {
                return response()->json(['message' => '  خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید ']);
            }
        }
    }
}
