@extends('layouts.mainLayout')
@section('content')
    <div class="columns-container">
        <div class="container" id="columns">
            <!-- breadcrumb -->
            <div class="breadcrumb clearfix">
                <a class="home" href="#" title="Return to Home">خانه</a>
                <span class="navigation-pipe">&nbsp;</span>
                <span class="navigation_page">ورود / ثبت نام</span>
            </div>
            <!-- ./breadcrumb -->
            <!-- page heading-->
            <h2 class="page-heading">
                <span class="page-heading-title2">ورود / ثبت نام</span>
            </h2>
            <!-- ../page heading-->
            <div class="page-content" dir="rtl">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="box-authentication">
                            <h3 class="col-md-6">ورود</h3><br>
                            <form id="loginForm">
                                {{csrf_field()}}
                                <div class="form-group col-md-12">
                                    <div class="col-md-9">
                                        <input type="text" pattern="^\d{11}$" required=" " tabindex="7"
                                               value="{{ old('cellphone') }}" maxlength="11" name="cellphone"
                                               class="form-control">
                                    </div>
                                    <label for="grade" class="col-md-3 control-label">تلفن همراه</label>
                                </div>
                                <div class="form-group col-md-12{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="col-md-9">
                                        <input id="password" type="password" class="form-control" name="password"
                                               required maxlength="20">
                                    </div>
                                    <label for="password" class="col-md-3 control-label">پسورد</label>
                                </div>
                                <div class="form-group col-md-12{{ $errors->has('captcha') ? ' has-error' : '' }}">
                                    <div class="col-md-9">
                                        {{--<img src="{{url('reload.jpg')}}" class="captcha-reload "--}}
                                        {{-->--}}
                                        <i class="fa fa-refresh fa-lg captcha-reload col-md-1" height="25"
                                           width="25"></i>
                                        <img class="captcha col-md-4" alt="captcha.png" id="captcha-image"/>
                                        <input id="captcha" class="form-control col-md-4" type="text"
                                               name="captcha" value="" required tabindex="11">
                                    </div>
                                    <label for="captcha" class="col-md-3 control-label"> کد امنیتی</label>
                                </div>
                                <p class="forgot-pass"><a href="#">آیا رمز عبور خود را فراموش کرده اید؟</a></p>
                                <button class="button" id="loginUser"><i class="fa fa-lock"></i> ورود</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <div class="box-authentication register-form">
                            <h3 class="col-md-6">ثبت نام</h3><br>
                            {{--<p>لطفا تلفن خود را برای ثبت نام وارد نمائید</p>--}}
                            {{--<label for="cellphone">نام</label>--}}
                            {{--<input id="cellphone" type="text" class="form-control">--}}
                            {{--<label for="cellphone">نام خانوادگی</label>--}}
                            {{--<input id="cellphone" type="text" class="form-control">--}}
                            {{--<label for="cellphone">موبایل</label>--}}
                            {{--<input id="cellphone" type="text" class="form-control">--}}
                            {{--<label for="cellphone">شماره تلفن</label>--}}
                            {{--<input id="cellphone" type="text" class="form-control">--}}
                            {{--<label for="cellphone">آدرس</label>--}}
                            {{--<input id="cellphone" type="text" class="form-control">--}}
                            {{--<label for="cellphone">کدپستی</label>--}}
                            {{--<input id="cellphone" type="text" class="form-control">--}}
                            {{--<button class="button"><i class="fa fa-user"></i> ثبت نام </button>--}}

                            <form class="form-horizontal" id="registerForm" role="form"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" value="user" name="frmtype">
                                {{--<div class="form-group col-md-12{{ $errors->has('name') ? ' has-error' : '' }}">--}}
                                    {{--<div class="col-md-9">--}}
                                        {{--<input id="name" type="text" class="form-control" name="name"--}}
                                               {{--value="{{ old('name') }}" required autofocus>--}}
                                    {{--</div>--}}
                                    {{--<label for="name" class="col-md-3 control-label">نام</label>--}}
                                {{--</div>--}}

                                {{--<div class="form-group col-md-12{{ $errors->has('family') ? ' has-error' : '' }}">--}}
                                    {{--<div class="col-md-9">--}}
                                        {{--<input id="family" type="text" class="form-control" name="family"--}}
                                               {{--value="{{ old('family') }}" required autofocus>--}}
                                    {{--</div>--}}
                                    {{--<label for="family" class="col-md-3 control-label"> نام خانوادگی</label>--}}
                                {{--</div>--}}
                                <div class="form-group col-md-12">
                                    <div class="col-md-9">
                                        <input type="text" pattern="^\d{11}$" required=" " tabindex="7"
                                               value="{{ old('cellphone') }}" maxlength="11" name="cellphone"
                                               id="cellphone"
                                               class="form-control">
                                    </div>
                                    <label for="grade" class="col-md-3 control-label">تلفن همراه</label>
                                </div>
                                <div class="form-group col-md-12{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="password"
                                               required maxlength="20">
                                    </div>
                                    <label for="password" class="col-md-3 control-label">پسورد</label>
                                </div>

                                <div class="form-group col-md-12">
                                    <div class="col-md-9">
                                        <input id="password-confirm" type="password" class="form-control col-md-9"
                                               name="password_confirmation" placeholder="6 تا 20 کاراکتر"
                                               maxlength="20">
                                    </div>
                                    <label for="password-confirm" class="col-md-3 control-label">تکرار پسورد</label>
                                </div>

                                {{--<div class="form-group col-md-12">--}}
                                    {{--<div class="col-md-9">--}}
                                        {{--<select tabindex="" class="form-control align-right selectpicker required"--}}
                                                {{--name="capital"--}}
                                                {{--id="capital" data-style="g-select" data-width="100%">--}}
                                            {{--<option class="align-right" value="-1">لطفا استان مورد نظر خود را انتخاب--}}
                                                {{--نمایید.--}}
                                            {{--</option>--}}
                                            {{--@foreach($capital as $cap)--}}
                                                {{--<option class="align-right"--}}
                                                        {{--value="{{$cap->id}}">{{$cap->title}}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                    {{--<label for="capital" class="col-md-3 control-label">استان</label>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-12">--}}
                                    {{--<div class="col-md-9">--}}
                                        {{--<select tabindex="" class="form-control align-right selectpicker required"--}}
                                                {{--name="town" id="town" data-style="g-select" data-width="100%">--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                    {{--<label for="town" class="col-md-3 control-label">شهــر</label>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-12">--}}
                                    {{--<div class="col-md-9">--}}
                                        {{--<input type="text" pattern="^\d{11}$" required="" tabindex="6" autofocus--}}
                                               {{--value="{{ old('telephone') }}" maxlength="11" name="telephone"--}}
                                               {{--id="telephone"--}}
                                               {{--class="form-control">--}}
                                    {{--</div>--}}
                                    {{--<label for="grade" class="col-md-3 control-label">تلفن ثابت</label>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-12{{ $errors->has('email') ? ' has-error' : '' }}">--}}
                                    {{--<div class="col-md-9">--}}
                                        {{--<input id="email" class="form-control" name="email" value="{{ old('email') }}"--}}
                                               {{--required>--}}
                                    {{--</div>--}}
                                    {{--<label for="email" class="col-md-3 control-label">ایمیل</label>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-12">--}}
                                    {{--<div class="col-md-9">--}}
                                        {{--<input type="text" pattern="^\d{10}$" required=" " tabindex="8"--}}
                                               {{--value="{{ old('zipCode') }}" maxlength="11" name="zipCode" id="zipCode"--}}
                                               {{--class="form-control">--}}
                                    {{--</div>--}}
                                    {{--<label for="grade" class="col-md-3 control-label">کد پستی</label>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-12">--}}
                                    {{--<div class="col-md-9">--}}
                                        {{--<input type="text" required="" tabindex="9"--}}
                                               {{--value="{{ old('birth_date') }}" maxlength="11" name="birth_date"--}}
                                               {{--id="birth_date"--}}
                                               {{--class="form-control">--}}
                                    {{--</div>--}}
                                    {{--<label for="grade" class="col-md-3 control-label">تاریخ تولد</label>--}}
                                {{--</div>--}}
                                {{--<div class="form-group col-md-12">--}}
                                    {{--<div class="col-md-9">--}}
                                        {{--<textarea type="text" required=" " tabindex="10"--}}
                                                  {{--value="{{ old('address') }}" maxlength="2000" name="address"--}}
                                                  {{--id="address"--}}
                                                  {{--class="form-control address col-md-12"></textarea>--}}
                                    {{--</div>--}}
                                    {{--<label for="grade" class="col-md-3 control-label">آدرس</label>--}}
                                {{--</div>--}}
                                <div class="form-group col-md-12{{ $errors->has('captcha') ? ' has-error' : '' }}">
                                    <div class="col-md-9">
                                        {{--<img src="{{url('reload.jpg')}}" class="captcha-reload "--}}
                                        {{-->--}}
                                        <i class="fa fa-refresh fa-lg captcha-reload col-md-1" height="25"
                                           width="25"></i>
                                        <img class="captcha col-md-4" alt="captcha.png" id="captcha-image"/>
                                        <input id="captcha" class="form-control col-md-4"
                                               name="captcha" required tabindex="11">
                                    </div>
                                    <label for="captcha" class="col-md-3 control-label"> کد امنیتی</label>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="col-md-12">
                                        {{--<button type="submit" class="btn btn-primary col-md-4"><i--}}
                                        {{--class="fa fa-user-plus"></i></button>--}}
                                        <button id="registerUser" class="button" tabindex="12"><i
                                                    class="fa fa-user"></i> ثبت نام
                                        </button>

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{url('public/main/assets/lib/jquery/jquery-1.11.2.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            //load cities of capital in selectbox
            var capital = $("#capital");
            $("#capital").on("change", function () {
                var cid = $(this).val();
                var token = $(this).data("token");
                $.ajax({
                    url: '{{url('town')}}' + '/' + cid,
                    type: 'get',
                    dataType: "JSON",
                    data: {
                        "id": cid,
                        "_method": 'get',
                        "_token": token
                    },
                    success: function (data) {
                        var item = $('#town');
                        item.empty();
                        $.each(data, function (index, value) {
                            item.append('<option value="' + value.title + '">' + value.title + '</option>');
                        });

                    },
                    error: function (response) {
                        console.log(response.valueOf(2));
                    }
                });
            });
            captcha();
            function captcha() {
                var token = $(this).data("token");
                $.ajax({
                    url: '{{url('captcha')}}',
                    type: 'get',
                    dataType: "JSON",
                    data: {
                        "_method": 'get',
                        "_token": token
                    },
                    success: function (data) {
                        $(".captcha").attr("src", data)
                    },
                    error: function (response) {
                        console.log(response.valueOf(2));
                    }
                });
            }

            $(".captcha").click(function () {
                captcha();
            });
            $(".captcha-reload").click(function () {
                captcha();
            });
            $("#registerUser").on('click', function () {
                $("#registerForm").submit(function (e) {
                    e.preventDefault();
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var formData = new FormData($("#registerForm")[0])
                $.ajax({
                    url: '{{url('/register')}}',
                    type: 'post',
                    cache: false,
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var y = '';
                        if (response.data == '1') {
                            y = 'شما با مؤفقیت ثبت نام نمودید، از بخش ورود برای استفاده از پنل خود اقدام نمائید.';
                        }
                        else if (response.data == '0') {
                            y = 'متأسفانه شما ثبت نام نشدید،با بخش پشتیبانی تماس حاصل فرمائید.';
                        }
                        else {
                            $.each(response, function (key, val) {
                                y += val[0] + '\n'
                            });
                        }
                        swal({
                            title: '',
                            text: y,
                            type: "info",
                            confirmButtonText: "بستن"
                        })

                    },
                    error: function (response) {
                        if (response.status == 422) {
                            var x = response.responseJSON;
                            var y = '';
                            $.each(x, function (key, val) {
                                y += val[0] + '\n';//showing only the first error.
                            });
                            swal({
                                title: '',
                                text: y,
                                type: "warning",
                            })
                        }
                        else if (response.status === 421) {
                            swal({
                                title: "",
                                text: "اطلاعات شما با مؤفقیت ثبت شد، پس از تأیید شدن توسط مدیر سایت برای شما ایمیل فعال سازی ارسال خواهد شد.منتظر پیامک اطلاعیه از طرف سایت باشید.",
                                type: "warning",
                                confirmButtonText: "بستن"
                            });
                        }
                        else {
                            swal({
                                title: "",
//                                text: 'خطایی رخ داده است، لطفا با پشتیبانی تماس حاصل فرمائید',
                                text: "اطلاعات شما با مؤفقیت ثبت شد، پس از تأیید شدن توسط مدیر سایت برای شما ایمیل فعال سازی ارسال خواهد شد.منتظر پیامک اطلاعیه از طرف سایت باشید.",
                                type: "warning",
                                confirmButtonText: "بستن"
                            });
                        }
                    }//error

                })//ajax
            });//onclick

            //send login form
            $("#loginUser").on('click', function () {
                $("#loginForm").submit(function (e) {
                    e.preventDefault();
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var formData = new FormData($("#loginForm")[0])
                $.ajax({
                    url: '{{url('/login')}}',
                    type: 'post',
                    cache: false,
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        var x = '';
                        $.each(data, function (key, val) {
                            x += val[0] + '\n'
                        });
                        console.log(data.responseText)
                        swal({
                            title: '',
                            text: x,
                            type: "info",
                            confirmButtonText: "بستن"
                        })
                        console.log(data);

                    },
                    error: function (response) {
                        if (response.status == 422) {
                            var x = response.responseJSON;
                            var y = '';
                            $.each(x, function (key, val) {
                                y += val[0] + '\n';//showing only the first error.
                            });
                            console.log(x)
                            if (x.cellphone == "اطلاعات ورودی با اطلاعات ذخیره شده مطابقت ندارد") {
                                swal({
                                    title: '',
                                    text: x.cellphone,
                                    type: "warning",
                                });
                            }
                            else {
                                swal({
                                    title: '',
                                    text: y,
                                    type: "warning",
                                });
                            }
                        }
                        else if (response.status === 421) {
                            swal({
                                title: "",
                                text: "اطلاعات شما با مؤفقیت ثبت شد، پس از تأیید شدن توسط مدیر سایت برای شما ایمیل فعال سازی ارسال خواهد شد.منتظر پیامک اطلاعیه از طرف سایت باشید.",
                                type: "warning",
                                confirmButtonText: "بستن"
                            });
                        }
                        else if(response.status!=500 && response.status!=422){
                            location.href = '{{url('/panel')}}'
                        }
                    }//error

                })//ajax
            });//onclick

        })//document.ready

    </script>
    <script src="{{ URL::asset('public/js/persianDatepicker.js')}}"></script>
    {{--persianDatepicker--}}
    <script>
        $('#birth_date').persianDatepicker();
    </script>
@endsection
