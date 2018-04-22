@extends('layouts.userLayout')
@section('content')

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>مشاهده و بررسی سفارشات</h2>

                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link" data-toggle="tooltip" title="جمع کردن"><i
                                        class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link" data-toggle="tooltip" title="بستن"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>

                    <div class="clearfix"></div>
                </div>


                {{--<div style="">--}}
                    {{--<a href="{{url('admin/addProduct')}}" id="user-send" type="button" class="col-md-2 btn btn-info" style=" font-weight: bold; margin-left: 39%;">افزودن محصول جدید</a>--}}
                {{--</div>--}}
                {{--<div class="pull-right" style="direction: rtl"><i class="fa fa-square" style="font-size: 35px;color:#ffff80;"></i> مدیران واحد</div>--}}
                <div class="x_content">
                    {{--<div align="right">--}}
                        {{--<ul style="direction: rtl; font-size: 140%;"> عنوان محصولات خرید شده :--}}
                            {{--@foreach($baskets->products as $product)--}}
                                {{--<li class="text-right" style="direction: rtl; margin-right: 3%; font-size: 80%;">{{$product->title}}</li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<br/>--}}
                    <table style="direction:rtl;text-align: center" id="example"
                           class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                        <thead>
                        <tr>
                            <th style="text-align: center">ردیف</th>
                            <th style="text-align: center">تاریخ ثبت سفارش</th>
                            <th style="text-align: center"> هزینه اولیه (تومان)</th>
                            <th style="text-align: center">مجموع تخفیفات (تومان)</th>
                            <th style="text-align: center">هزینه نهایی (تومان)</th>
                            <th style="text-align: center">هزینه پرداختی (تومان)</th>
                            <th style="text-align: center">وضعیت تحویل</th>
                            <th style="text-align: center">مشاهده جزییات</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $i=0 ?>
                        @foreach($data as $datum)
                            <tr class="unit">
                                <td style="font-size: 120%"> {{++$i}}</td>
                                <td style="font-size: 120%">{{$datum->orderDate}}</td>
                                <td style="font-size: 120%">{{number_format($datum->total_price)}}</td>
                                <td style="font-size: 120%">{{number_format($datum->discount_price)}}</td>
                                <td style="font-size: 120%">{{number_format($datum->factor_price)}}</td>
                                <td style="font-size: 120%">{{number_format($datum->pay_price)}}</td>
                                @if($datum->order_status == null)
                                    <td><button class="btn btn-default" style="font-size: 120%;">نا مشخص</button></td>
                                @endif
                                @if($datum->order_status != null)
                                    <td style="font-size: 120%">{{$datum->order_status}}</td>
                                @endif
                                <td ><strong><a style="font-size: 120%" class="btn btn-dark" href="{{url('user/orderDetails/'.$datum->basket_id)}}">مشاهده جزئیات</a></strong></td>
                        @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>

@endsection
