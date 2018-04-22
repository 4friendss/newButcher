@extends('layouts.userLayout')
@section('content')
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>جزئیات  سفارش</h2>
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
                    <div style="direction: rtl;"><label style="font-size: 120%;">توضیحات سفارش:</label></div>
                    <div>
                        @if($comments != null)
                            <textarea class="form-control" disabled="">{{$comments}}</textarea>
                        @endif
                        @if($comments == null)
                            <textarea class="form-control" disabled="">توضیحاتی برای این سفارش ثبت نشده است</textarea>
                        @endif
                    </div>
                    <br/>
                    <table style="direction:rtl;text-align: center" id="example"
                           class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                        <thead>
                        <tr>
                            <th style="text-align: center;">R</th>
                            <th style="text-align: center">عنوان محصول</th>
                            <th style="text-align: center">توضیحات  سبد خرید</th>
                            <th style="text-align: center">تعداد/مقدار</th>
                            <th style="text-align: center">واحد شمارش</th>
                            <th style="text-align: center">قیمت واحد(تومان)</th>
                            <th style="text-align: center">هزینه پست(تومان)</th>
                            <th style="text-align: center">حجم تخفیف کلی(درصد)</th>
                            <th style="text-align: center">حجم تخفیف تحویل</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0 ?>
                        @foreach($baskets->products as $basket)
                            <tr class="unit">
                                <td style="font-size: 120%"> {{++$i}}</td>
                                <td style="font-size: 120%">{{$basket->title}}</td>
                                @if($basket->basketComment == null)
                                    <td style="font-size: 120%"> توضیحات ندارد</td>
                                @endif
                                @if($basket->basketComment != null)
                                    <td style="font-size: 120%"><textarea class="form-control" disabled>{{$basket->basketComment}}</textarea></td>
                                @endif
                                <td style="font-size: 120%">{{number_format($basket->basketCount)}}</td>
                                <td style="font-size: 120%">{{($basket->unit_count)}}</td>
                                <td style="font-size: 120%">{{number_format($basket->product_price)}}</td>
                                @if($basket->post_price == null)
                                    <td style="font-size: 120%">ندارد</td>
                                @endif
                                @if($basket->post_price != null)
                                    <td style="font-size: 120%">{{number_format($basket->post_price)}}</td>
                                @endif
                                @if($basket->discount_volume == null)
                                    <td style="font-size: 120%"> ندارد</td>
                                @endif
                                @if($basket->discount_volume != null)
                                    <td style="font-size: 120%">{{$basket->discount_volume}}</td>
                                @endif
                                @if($basket->delivery_volume == null)
                                    <td style="font-size: 120%">ندارد</td>
                                @endif
                                @if($basket->delivery_volume != null)
                                    <td style="font-size: 120%">{{$basket->delivery_volume}}</td>
                                @endif
                                <tr>
                            </tr>
                        @endforeach
                            <tr>
                                <td></td>
                                <td  colspan="12"><strong><a style=" font-size: 350%; text-decoration: none; " class="fa fa-print col-md-6  col-md-offset-3"  title="چاپ فاکتور" data-toggle="" href="{{url('user/userShowFactor/'.$basket->basket_id)}}"></a></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
