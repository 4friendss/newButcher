<?php

namespace App\Http\Controllers\Auth;

use App\Models\City;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
//        return Validator::make($data, [
//            'name' => 'required|max:255',
//            'email' => 'required|email|max:255|unique:users',
//            'password' => 'required|min:6|confirmed',
//        ]);

        if ($data['frmtype'] == "user") {
            return Validator::make($data, [
                    'name' => 'sometimes|nullable|max:255',
                    'family' => 'sometimes|nullable|max:255',
                    'email' => 'sometimes|nullable|max:255|unique:users',
                    'password' => 'sometimes|nullable|min:6|confirmed',
                    'address' => 'sometimes|nullable|max:1000',
                    'telephone' => 'sometimes|nullable|numeric|size:11',
                    'cellphone' => 'required|numeric|min:11',
                    'birth_date' => 'sometimes|nullable|min:8|max:10',
                    'capital' => 'required',
                    'town' => 'required',
                    'zipCode' => 'sometimes|nullable|numeric|min:10',
                    'captcha' => 'required|in:' . session()->get('captcha')
                ]
                ,
                [
                    'name.required' => ' فیلد نام الزامی است',
                    'name.max' => 'حداکثر 255 کاراکتر مجاز است',
                    'family.required' => ' فیلد نام خانوادگی الزامی است ',
                    'family.max' => 'حداکثر 255 کاراکتر مجاز است',
                    'email.email' => ' فرمت ایمیل نادرست است ',
                    'password.required' => ' فیلد رمز عبور الزامی است ',
                    'password.min' => ' رمز عبور حداقل باید 6 کاراکتر باشد ',
                    'password.confirmed' => ' رمز عبور و تکرار آن با هم مطابقت ندارند ',
                    'captcha.required' => ' فیلد کد امنیتی الزامی است ',
                    'captcha.in' => ' کد امنیتی وارد شده صحیح نیست ',
                    'cellphone.required' => ' فیلد تلفن همراه الزامی است ',
                    'cellphone.numeric' => 'فیلد موبایل باید عددی باشد',
                    'telephone.required' => ' فیلد تلفن الزامی است ',
                    'telephone.numeric' => ' فیلد تلفن عددی است',
                    'zipCode.numeric' => ' فیلد کدپستی عددی است',
                    'telephone.size' => ' فیلد تلفن باید 11 رقمی باشد',
                    'cellphone.size' => ' فیلد موبایل باید 11 رقمی باشد',
                    'town.required' => ' فیلد شهرستان ضروری است',
                    'capital.required' => ' فیلد استان ضروری است',
                ]);
        }//end of if

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    public function create(array $data)
    {
        if ($data['frmtype'] == "user")
        {
            $role_id=1;
        }
        $capital=City::where('id','=',$data['capital'])->value('title');
        return User::create([
            'name' => $data['name'],
            'family' => $data['family'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'cellphone' => $data['cellphone'],
            'birth_date' => $data['birth_date'],
            'address' => $data['address'],
            'capital_city_id' => $capital,
            'town_city_id' => $data['town'],
            'telephone' => $data['telephone'],
            'role_id' => $role_id,
            'zipCode' => $data['zipCode'],
//            'register_date' => date_create(),
        ]);
        return response()->json(['success' => true]);
    }
}
