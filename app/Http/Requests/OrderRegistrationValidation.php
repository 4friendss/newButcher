<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRegistrationValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return
            [
                'userCellphone'    => 'required|min:11|regex:/(09)[0-9]{9}/',
                'userCoordination' => 'required'
            ];
    }

    public function messages()
    {
        return
            [
               'userCellphone.required'     => 'وارد کردن شماره موبایل الزامی است',
               'userCellphone.regex'        => 'شماره موبایل را بطور صحیح وارد نمائید، مثلا : 09370491215',
               'userCellphone.min'          => 'تعداد ارقام وارد شده برای تلفن همراه نباید کمتر از 11 رقم باشند',
               'userCoordination.required'  => 'لطفا آدرس تحویل را وارد کنید'
            ];
    }
}
