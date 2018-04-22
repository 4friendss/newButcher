@extends('layouts.adminLayout')
@section('content')

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2> مدیریت محصولات</h2>

                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link" data-toggle="tooltip" title="جمع کردن"><i
                                        class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link" data-toggle="tooltip" title="بستن"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>

                    <div class="clearfix"></div>
                </div>


                <div style="">
                    <a href="{{url('admin/addProduct')}}" id="user-send" type="button" class="col-md-2 btn btn-info" style=" font-weight: bold; margin-left: 39%;">افزودن محصول جدید</a>
                </div>
                {{--<div class="pull-right" style="direction: rtl"><i class="fa fa-square" style="font-size: 35px;color:#ffff80;"></i> مدیران واحد</div>--}}
                <div class="x_content">
                    <table style="direction:rtl;text-align: center" id="example"
                           class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                        <thead>
                        <tr>
                            <th style="text-align: center">شناسه محصول</th>
                            <th style="text-align: center">عنوان محصول</th>
                            <th style="text-align: center">تعدا بازدید</th>
                            <th style="text-align: center">تعداد خرید</th>
                            <th style="text-align: center">تاریخ ثبت محصول</th>
                            <th style="text-align: center">مشاهده جزییات</th>
                            <th style="text-align: center">وضعیت / تغییر وضعیت</th>

                        </tr>
                        </thead>

                        <tbody>

                        @foreach($data as $datum)
                            <tr class="unit">
                                <td style="font-size: 120%">{{$datum->id}}</td>
                                <td style="font-size: 120%">{{$datum->title}}</td>
                                <td style="font-size: 120%">{{$datum->seen_count}}</td>
                                <td style="font-size: 120%">{{$datum->sell_count}}</td>
                                <td style="font-size: 120%">{{$datum->date}}</td>
                                <td ><strong><a style="font-size: 120%" class="btn btn-dark" href="{{url('admin/productDetails/'.$datum->id)}}">مشاهده جزئیات</a></strong></td>
                                @if($datum->active == 1)
                                    <td ><strong><a style="font-size: 120%" class="btn btn-success col-md-10 col-md-offset-1" id="{{$datum->id}}">فعال</a></strong></td>
                                @endif
                                @if($datum->active == 0)
                                    <td ><strong><a style="font-size: 120%" class="btn btn-danger col-md-10 col-md-offset-1">غیرفعال</a></strong></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- below script is make related product disable -->
        <script>
            $(document).on('click','.btn-success',function () {
                var productId = $(this).attr('id');
                var token  = $('#token').val();
                var button = $(this);
                swal({
                        title: "",
                        text: "محصول مورد نظر شما هم اکنون فعال است ، آیا در نظر دارید آن را غیر فعال کنید؟",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "	#5cb85c",
                        cancelButtonText: "خیر ، منصرف شدم",
                        confirmButtonText: "بله غیرفعال شود",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function () {
                        $.ajax
                        ({
                            url     : "{{Url('admin/changeProductStatus')}}/{{'disable'}}",
                            type    : 'post',
                            data    : {'productId':productId,'_token':token},
                            context :  button,
                            dataType:'json',
                            success : function (response)
                            {
                                $(button).text('غیر فعال');
                                $(button).toggleClass('btn-success btn-danger');
                                if(response.code == 'success')
                                {
                                    swal({
                                        title: "",
                                        text: response.message,
                                        type: "success",
                                        confirmButtonText: "بستن"
                                    });
                                }else
                                    {
                                        swal({
                                            title: "",
                                            text: "خطایی رخ داده است ، تماس با بخش پشتیبانی",
                                            type: "warning",
                                            confirmButtonText: "بستن"
                                        });
                                    }

                            },
                            error : function(error)
                            {
                                console.log(error);
                                swal({
                                    title: "",
                                    text: "خطایی رخ داده است ، تماس با بخش پشتیبانی",
                                    type: "warning",
                                    confirmButtonText: "بستن"
                                });
                            }
                        });
                    });
            })
        </script>
        <!--below script is related to make related product enable -->
        <script>
            $(document).on('click','.btn-danger',function () {
                var productId = $(this).attr('id');
                var token = $('#token').val();
                var button = $(this);
                swal({
                        title: "",
                        text: "محصول مورد نظر شما هم اکنون غیر فعال است ، آیا در نظر دارید آن را فعال کنید؟",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "	#5cb85c",
                        cancelButtonText: "خیر ، منصرف شدم",
                        confirmButtonText: "بله فعال شود",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function () {
                        $.ajax
                        ({
                            url: "{{Url('admin/changeProductStatus')}}/{{'enable'}}",
                            type: 'post',
                            data: {'productId': productId, '_token': token},
                            context: button,
                            dataType:'json',
                            success: function (response) {
                                $(button).text('فعال');
                                $(button).toggleClass('btn-success btn-danger');
                                if(response.code == 'success')
                                {
                                    swal({
                                        title: "",
                                        text: response.message,
                                        type: "success",
                                        confirmButtonText: "بستن"
                                    });
                                }else
                                {
                                    swal({
                                        title: "",
                                        text: "خطایی رخ داده است ، تماس با بخش پشتیبانی",
                                        type: "warning",
                                        confirmButtonText: "بستن"
                                    });
                                }
                            },
                            error: function (error) {
                                console.log(error);
                                swal({
                                    title: "",
                                    text: "خطایی رخ داده است ، تماس با بخش پشتیبانی",
                                    type: "warning",
                                    confirmButtonText: "بستن"
                                });
                            }
                        });
                    }
                );//end swal
            });
        </script>

        @endsection
