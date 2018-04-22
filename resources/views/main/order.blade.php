@extends('layouts.mainLayout')
@section('content')

    <div id="header" class="header">

    <!--/.top-header -->
    <!-- MAIN HEADER -->
    <div class="container main-header">

    </div>
    <!-- END MANIN HEADER -->
    <style>
        .red
        {
            color: darkred;
        }
    </style>
</div>
<!-- end header -->
<!-- page wapper-->
<div class="columns-container">
    <div class="container" id="columns">
        <!-- breadcrumb -->
        {{--<div class="breadcrumb clearfix">--}}
            {{--<a class="home" href="#" title="Return to Home">Home</a>--}}
            {{--<span class="navigation-pipe">&nbsp;</span>--}}
            {{--<span class="navigation_page">Your shopping cart</span>--}}
        {{--</div>--}}
        {{--<!-- ./breadcrumb -->--}}
        {{--<!-- page heading-->--}}
        {{--<h2 class="page-heading no-line">--}}
            {{--<span class="page-heading-title2">Shopping Cart Summary</span>--}}
        {{--</h2>--}}
        <!-- ../page heading-->
        <div class="page-content page-order">
            {{--<ul class="step">--}}
                {{--<li class="current-step"><span>01. Summary</span></li>--}}
                {{--<li><span>02. Sign in</span></li>--}}
                {{--<li><span>03. Address</span></li>--}}
                {{--<li><span>04. Shipping</span></li>--}}
                {{--<li><span>05. Payment</span></li>--}}
            {{--</ul>--}}
            {{--<div align="center" class="heading-counter warning">--}}
                {{--<h2>سبد خرید شما حاوی  {{$count}} نوع محصول است </h2>--}}
            {{--</div>--}}
            <div class="order-detail-content " align="center">

                @if(!empty($baskets))
                <table id="orderTable" class="table table-bordered table-responsive cart_summary rtl">
                    <thead>
                    <tr>
                        <th class="cart_product text-center">عنوان محصول</th>
                        <th class="text-center"> توضیحات</th>
                        <th class="text-center">واحد شمارش</th>
                        <th class="text-center">قیمت واحد</th>
                        <th class="text-center">تعداد/مقدار</th>
                        <th class="text-center">مجموع</th>
                        <th  class="action">عملیات</th>
                        <th  class="action red" >جزئیات سفارش</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($baskets->products as $basket)
                        <form id="commentForm">
                        <tr class="text-center">
                            <td class="cart_product">{{$basket->title}}</td>
                            <td class="cart_description">
                               {{$basket->description}}
                            </td>
                            <td>
                                {{$basket->unit_count}}
                            </td>
                            <td id="unitPrice" content="{{$basket->price}}" class=" text-center">{{number_format($basket->price)}} تومان</td>
                            <td class="qty">
                                <input class="form-control input-sm" id="count" name="count" onkeydown="return false" type="text" value="{{$basket->count}}">
                                <a class="addToCount" content="{{$basket->id}}" name="{{$basket->basket_id}}"><i class="fa fa-caret-up"></i></a>
                                <a class="subFromCount" content="{{$basket->id}}" name="{{$basket->basket_id}}"><i class="fa fa-caret-down"></i></a>
                            </td>
                            <td id="oldSum" content="{{$basket->sum}}" class=" text-center">
                                {{number_format($basket->sum)}} تومان
                            </td>
                            <td class="col-md-1">
                                <a class="fa fa-trash-o" id="removeItem" name="{{$basket->id}}" data-target="{{$basket->price}}" content="{{$basket->basket_id}}" title="پاک کردن" data-toggle=""  ></a>
                            </td>

                                <td class="col-md-3">
                                    @if(count($basket->ProductOption)>0)
                                        <div class="form-option">
                                            {{--<p class="float-r form-option-title">: گزینه های ارسال محصول</p>--}}
                                            <div class="attributes">
                                                <div class="attribute-label" dir="rtl"></div>
                                                <div class="attribute-list float-r">
                                                    @foreach ($basket->productOption as $opt)
                                                        <div class="col-md-12 col-sm-12 ">
                                                            <input type="checkbox" name="orderOption[]" content="{{$basket->id}}" id="{{$basket->basket_id}}" class="float-r"
                                                                   value="{{$opt->title}}"/>
                                                            <label class="float-r margin-r-5">{{$opt->title}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                </td>
                        </tr>
                    @endforeach
                        </form>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2" rowspan="2"></td>
                        <td colspan="4">مجموع هزینه ها</td>
                        <td colspan="2" id="orderTotal" content="{{$total}}">{{number_format($total)}} تومان</td>
                    </tr>
                    </tfoot>
                </table>

                @endif
                <div class="cart_navigation">
                    <a class="prev-btn"  onclick="window.history.back();">ادامه خرید</a>
                    <a id="comment" class="btn btn-warning col-md-3 col-md-offset-3">ثبت جزئیات سفارش</a>
                    <a class="next-btn" href="{{url('order/orderDetail')}}">مشاهده جزئیات سفارش</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

