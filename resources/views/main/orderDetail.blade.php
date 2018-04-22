@extends('layouts.mainLayout')
@section('content')
    <style>
        .overflow_hidden_x{overflow-x: hidden;}
        .margin-top-1{
            margin-top: -1% !important;
        }
    </style>
    <div class="columns-container">
        <div class="container" id="columns" dir="rtl">
            <!-- breadcrumb -->
            <div class="breadcrumb clearfix">
                <a class="home" href="#" title="Return to Home">خانه</a>
                <span class="navigation-pipe">&nbsp;</span>
                <span class="navigation_page">پرداخت نهایی</span>
            </div>
            <!-- ./breadcrumb -->
            <!-- page heading-->
            <h2 class="page-heading">
                <span class="page-heading-title2">پرداخت نهایی</span>
            </h2>
            <!-- ../page heading-->
            <form id="orderDetailForm">
                {{csrf_field()}}
            <div class="page-content checkout-page">
                <h3 class="checkout-sep">اطلاعات مشتری</h3>
                <div class="box-border">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-6" >
                            <label>شماره تلفن</label>
                            <input type="text" maxlength="11" name="userCellphone" id="userCellphone" class="form-control input" >
                            <label>آدرس تحویل محصول</label>
                            <textarea name="userCoordination" id="userCoordination" class="form-control input overflow_hidden_x" ></textarea>
                        </div>
                    </div>
                </div>
                <h3 class="checkout-sep">توضیحات سفارش</h3>
                <div class="box-border" >
                    <div class="row">
                        <div class="col-md-10 col-md-offset-2" >
                            <label>توضیحات</label>
                            <textarea name="comments" id="comments" class="form-control input overflow_hidden_x col-md-12"></textarea>
                        </div>
                    </div>
                </div>
                <h3 class="checkout-sep">نوع پرداخت</h3>
                <div class="box-border" >
                    <ul>
                        @if(!empty($paymentTypes))
                            @foreach($paymentTypes as $paymentType)
                                <li>
                                    <label for="radio_button_5"><input type="radio" checked value="{{$paymentType->title}}" name="paymentType" id="radio">{{$paymentType->title}}</label>
                                </li>
                            @endforeach
                        @endif
                            <label for="radio_button_5" class="float-r margin-r-5 margin-top-1"><input type="radio" checked  class="float-r " value="پرداخت آنلاین" name="paymentType" id="radio" disabled>پرداخت آنلاین</label>
                    </ul>
                    {{--<button class="button">Continue</button>--}}
                </div>
                <h3 class="checkout-sep">بررسی جزئیات سفارشات</h3>
                <div class="box-border" >
                    @if(!empty($baskets))
                        <table id="orderTable" class="table table-bordered table-responsive cart_summary rtl">
                            <thead>
                            <tr>
                                <th class="text-center cart_product">عنوان محصول</th>
                                {{--<th class="text-center">توضیحات محصول</th>--}}
                                <th class="text-center">قیمت واحد</th>
                                <th class="text-center" align="center">تعداد/مقدار</th>
                                <th class="text-center">جمع کل (تومان)</th>
                                <th class="text-center">تخفیف محصول (درصد)</th>
                                <th class="text-center">هزینه پست (تومان)</th>
                                <th class="text-center">جزئیات سبد خرید</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($baskets->products as $basket)
                                <tr class="text-center">
                                    <td class="cart_product">{{$basket->title}}</td>
                                    {{--<td class="cart_description">--}}
                                        {{--<textarea class="form-control" disabled="">{{$basket->description}}</textarea>--}}
                                    {{--</td>--}}
                                    <td id="unitPrice" content="{{$basket->price}}">{{number_format($basket->price)}}</td>
                                    <td class="qty">
                                        <input disabled="disabled" class="form-control input-sm" id="count" name="count" type="text" value="{{$basket->count}}">
                                    </td>
                                    <td id="oldSum" content="{{$basket->sum}}">{{number_format($basket->sum)}}</td>
                                    <td class="col-md-2">@if($basket->discount_volume != null){{$basket->discount_volume}}@endif @if($basket->discount_volume == null) تخفیف ندارد @endif</td>
                                    <td class="col-md-2">{{number_format($basket->post_price)}}</td>
                                    @if(count($basket->comments) > 0)
                                        <?php $array = explode(',',$basket->comments); $len = count($array); $i = 0;  ?>
                                        <td class="col-md-3">
                                        @while($i < $len-1)
                                                <div class="col-md-12">
                                                <input type="checkbox" disabled checked class="float-r "/>

                                                <label class="float-r margin-r-5 margin-top-1">{{$array[$i]}}</label>
                                                </div>
                                            <?php $i++; ?>
                                        @endwhile
                                        </td>
                                    @endif
                                    <input type="hidden" name="basketId" value="{{$basket->basket_id}}">
                                    <input type="hidden" name="productId[]" value="{{$basket->product_id}}">
                                </tr>
                            @endforeach
                            </tbody>
                            <tr>
                                <td colspan="5"> جمع کل قیمت ها (تومان)</td>
                                <td colspan="5" >{{number_format($total)}}</td>
                                <input type="hidden" name="totalPrice" value="{{$total}}">
                            </tr>
                            <tr>
                                <td colspan="5">مجموع تخفیف ها (تومان)</td>
                                <td colspan="5" >{{number_format($basket->sumOfDiscount)}}</td>
                                <input type="hidden" name="discountPrice" value="{{$basket->sumOfDiscount}}">
                            </tr>
                            <tr>
                                <td colspan="5">مجموع هزینه های پست (تومان)</td>
                                <td colspan="5" >{{number_format($totalPostPrice)}}</td>
                                <input type="hidden" name="postPrice" value="{{$totalPostPrice}}">
                            </tr>
                            <tr>
                                <td colspan="5">قیمت نهایی (تومان)</td>
                                <td colspan="5" >{{number_format($finalPrice)}}</td>
                                <input type="hidden" name="factorPrice" value="{{$finalPrice}}">
                            </tr>
                            <tr>
                                <td colspan="5">قیمت پرداختی (تومان)</td>
                                <td colspan="5" >{{number_format($payPrice)}}</td>
                                <input type="hidden" name="payPrice" value="{{$payPrice}}">
                            </tr>

                        </table>
                    @endif
                    <button type="button" class="col-md-3 button"  onclick="window.location.replace('basketDetail');">بازگشت به سبد خرید</button>
                    <button type="button" class="col-md-6 button col-md-offset-3"  id="orderRegistration">ثبت سفارش</button>
                </div>
            </div>
            </form>
        </div>
    </div>

@endsection

