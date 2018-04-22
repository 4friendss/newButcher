@extends('layouts.adminLayout')
@section('content')
    <style>
        .star {
            color: #ff0000;
            float: right;
            padding-right: 4px;
            padding-left: 4px;
        }

        input, label {
            font-size: 15px;
        }

        .margin-1 {
            margin-top: 1%;
        }

        .margin-bot-1 {
            margin-bottom: 1%;
        }

        .overflow-x {
            overflow-x: hidden;
        }

        .myColor {
            width: 13px;
            height: 13px;
            padding: 0 !important;
            margin: 0 !important;
            vertical-align: bottom;
            position: relative;
            top: 6px;
            float: right;
            left: 21px;
            *overflow: hidden;
        }

        .myLabel {
            display: block;
            padding-left: 15px;
            text-indent: -15px;
            float: right;
        }

        .float-right {
            float: right;
        }

        .padding-right-2 {
            padding-right: 2%;
        }
    </style>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog" dir="rtl">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">ویرایش دسته بندی محصول</h2>
                </div>
                <div id="change">
                </div>
                <div class="col-md-12 margin-1 margin-bot-1">
                    <div class="col-md-9 col-sm-6 col-xs-9 margin-1">
                        <select id="categories" class="form-control col-md-12 margin-1"
                                name="categories">
                        </select>
                    </div>
                    <label class="control-label col-md-3 col-sm-4 col-xs-3 margin-1" for="title"> دسته ی اصلی :
                        <span class="required star" title=" فیلد دسته بندی الزامی است"></span>
                    </label>
                </div>
                <div class="col-md-12 margin-1" id="subCategoriesDiv"
                     style="display: none;">
                    <div class="col-md-9 col-sm-6 col-xs-9">
                        <select id="subCategories" class="form-control col-md-12 margin-1" name="subCategories">
                        </select>
                    </div>
                    <label class="control-label col-md-3 col-sm-4 col-xs-3 margin-1" for="title"> زیردسته های
                        دسته
                        فوق :
                        <span class="required star" title=" فیلد دسته بندی الزامی است"></span>
                    </label>
                </div>
                <div class="col-md-12 margin-1" id="BrandsDiv" style="display: none;">
                    <div class="col-md-9 col-sm-6 col-xs-9">
                        <select id="brands" class="form-control col-md-12 margin-1" name="brands">
                        </select>
                    </div>
                    <label class="control-label col-md-3 col-sm-4 col-xs-3 margin-1" for="title"> زیردسته های
                        دسته
                        فوق :
                        <span class="required star" title=" فیلد دسته بندی الزامی است"></span>
                    </label>
                </div>
                <div class="modal-footer margin-1">
                    <button type="button" id="submitCategory" class="btn btn-dark col-md-6 col-md-offset-3"
                            data-dismiss="modal">بستن
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Include SmartWizard CSS -->
    <link href="{{url('public/dashboard/stepWizard/css/smart_wizard.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Optional SmartWizard theme -->
    <link href="{{url('public/dashboard/stepWizard/css/smart_wizard_theme_arrows.css')}}" rel="stylesheet"
          type="text/css"/>
    <div class="clearfix"></div>
    <div class="row">
        <div class="container">
            <form class="form-horizontal form-label-left" id="productForm" enctype="multipart/form-data"
                  style="direction: rtl !important;">
            {{csrf_field()}}
            <!-- SmartWizard 1 html -->
                <div id="smartwizard">
                    <ul>
                        <li><a href="#step-1">اطلاعات اصلی محصول<br/>
                                <small><!-- This is step description --></small>
                            </a></li>
                        <li><a href="#step-2">اطلاعات تکمیلی محصول<br/>
                                <small></small>
                            </a></li>
                        <li><a href="#step-3">قیمت / تخفیف / پیک<br/>
                                <small></small>
                            </a></li>
                        <li><a href="#step-4">تصاویر / ویدئوی محصول<br/>
                                <small></small>
                            </a></li>
                    </ul>
                    @if(!empty($products))
                        <input type="hidden" value="{{$products[0]->id}}" name="id"/>
                        <div>
                            <div id="step-1" class="">
                                <br>
                                <div class="container">
                                    <br>
                                    <div class="col-md-10 col-md-offset-1 margin-1">
                                        <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                            <div class="col-md-2">
                                                <a type="button" name="editCategory" id="editCategory"
                                                   content="{{$products[0]->categories[0]->id}}"
                                                   class="glyphicon glyphicon-edit btn btn-success"
                                                   title="ویرایش "></a>
                                            </div>
                                            <div class="col-md-10">
                                                <input disabled id="lastCategoryName" class="form-control col-md-12"
                                                       value="{{$products[0]->categories[0]->title}}">
                                                <input type="hidden" disabled id="lastCategory" name="lastCategory"
                                                       value="">
                                            </div>
                                        </div>
                                        <label class="control-label col-md-2 col-sm-4 col-xs-3" for="title"> آخرین دسته
                                            مربوطه :
                                        </label>
                                    </div>

                                    <div class="col-md-10 col-md-offset-1 margin-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       products-toggle=""
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                    <input disabled id="editable"
                                                           class="form-control col-md-10 col-xs-12 editable"
                                                           name="title"
                                                           type="text" value="{{$products[0]->title}}">
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3" for="title"> عنوان
                                                محصول :
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1 margin-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                <textarea style="text-align: right; direction: ltr;" disabled
                                                          id="editable"
                                                          class="form-control col-md-12 col-xs-12 overflow-x editable"
                                                          name="description" required="required">
                                                @if($products[0]->description != null)
                                                        {{$products[0]->description}}
                                                    @endif
                                                    @if($products[0]->description == null)
                                                        توضیحی وجود ندارد
                                                    @endif
                                            </textarea>
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3" for="description">
                                                توضیح
                                                محصول :
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1 margin-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10" id="unit_count_parent">
                                                    @if($products[0]->unit_count != null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable my_units"
                                                               name="unit_count" value="{{$products[0]->unit_count}}"/>
                                                    @endif
                                                    @if($products[0]->unit_count == null)
                                                        <select disabled id="editable"
                                                                class="form-control col-md-7 col-xs-12 editable my_units"
                                                                name="unit_count"></select>
                                                    @endif
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3" for="unit"> واحد
                                                شمارش :
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1 margin-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10" id="sub_unit_count_parent">
                                                    @if($products[0]->sub_unit_count != null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="sub_unit_count"
                                                               value="{{$products[0]->sub_unit_count}}"/>

                                                    @endif
                                                    @if($products[0]->sub_unit_count == null)
                                                        <select disabled id="editable"
                                                                class="form-control col-md-7 col-xs-12 editable"
                                                                name="sub_unit_count"></select>
                                                    @endif
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3" for="subunit"> زیر
                                                واحد شمارش :
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1 margin-1 margin-bot-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       products-toggle=""
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                    @if($products[0]->productFlags[0]->title  == 'price')
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable pr"
                                                               name="price"
                                                               value="{{number_format($products[0]->productFlags[0]->price)}}">
                                                    @endif
                                                    @if($products[0]->productFlags[0]->title != 'price')
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable pr"
                                                               name="price">
                                                    @endif
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3" for="price"> قیمت
                                                اصلی
                                                (تومان) :
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-2" class="">
                                <div class="container">
                                    <div class="col-md-10 col-md-offset-1 margin-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                    @if($products[0]->produceDate != null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="produce_date"
                                                               value="{{$products[0]->produceDate}}">
                                                    @endif
                                                    @if($products[0]->produceDate == null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="produce_date">
                                                    @endif
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3" for=""> تاریخ
                                                تولید :

                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1 margin-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       products-toggle=""
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                    @if($products[0]->expireDate != null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="expire_date" value="{{$products[0]->expireDate}}">
                                                    @endif
                                                    @if($products[0]->expireDate == null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="expire_date">
                                                    @endif
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3" for="expire_date">
                                                تاریخ
                                                انقضا :
                                                <span class="required star" title="پر کردن این فیلد الزامی است"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1 margin-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                    @if($products[0]->produce_place != null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="produce_place"
                                                               value="{{$products[0]->produce_place}}">
                                                    @endif
                                                    @if($products[0]->produce_place == null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="produce_place">
                                                    @endif
                                                </div>
                                            </div>

                                            <label class="control-label col-md-2 col-sm-4 col-xs-3" for="produce_place">
                                                محل
                                                تولید :
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1 margin-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                    @if($products[0]->warehouse_count != null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="warehouse_count"
                                                               value="{{$products[0]->warehouse_count}}">
                                                    @endif
                                                    @if($products[0]->warehouse_count == null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="warehouse_count">
                                                    @endif
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3"
                                                   for="warehouse_count"> تعداد
                                                موجود در
                                                انبار :
                                                <span class="required star" title="پر کردن این فیلد الزامی است"></span>
                                            </label>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-10 col-md-offset-1 margin-1 ">--}}
                                    {{--<div id="grandparent">--}}
                                    {{--<div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">--}}
                                    {{--<div class="col-md-2">--}}
                                    {{--<a type="button" name="edit" id="edit"--}}
                                    {{--class="glyphicon glyphicon-edit btn btn-success edit"--}}
                                    {{--title="ویرایش "></a>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-10">--}}
                                    {{--@if($products[0]->warehouse_place != null)--}}
                                    {{--<input disabled id="editable"--}}
                                    {{--class="form-control col-md-7 col-xs-12 editable"--}}
                                    {{--name="warehouse_place"--}}
                                    {{--value="{{$products[0]->warehouse_place}}">--}}
                                    {{--@endif--}}
                                    {{--@if($products[0]->warehouse_place == null)--}}
                                    {{--<input disabled id="editable"--}}
                                    {{--class="form-control col-md-7 col-xs-12 editable"--}}
                                    {{--name="warehouse_place">--}}
                                    {{--@endif--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<label class="control-label col-md-2 col-sm-4 col-xs-3"--}}
                                    {{--for="warehouse_place"> محل--}}
                                    {{--فیزیکی در--}}
                                    {{--انبار :--}}
                                    {{--<span class="required star" title="پر کردن این فیلد الزامی است"></span>--}}
                                    {{--</label>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    <div class="col-md-10 col-md-offset-1 margin-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                    @if($products[0]->ready_time != null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="ready_time"
                                                               value="{{$products[0]->ready_time}}">
                                                    @endif
                                                    @if($products[0]->ready_time == null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="ready_time">
                                                    @endif
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3" for="ready_time">
                                                زمان آماده شدن بر حسب ساعت:
                                                <span class="required star" title="پر کردن این فیلد الزامی است"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1 margin-1 margin-bot-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                    @if($products[0]->barcode != null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="barcode" value="{{$products[0]->barcode}}">
                                                    @endif
                                                    @if($products[0]->barcode == null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="barcode">
                                                    @endif
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3" for="barcode"> بارکد
                                                :
                                                <span class="required star" title="پر کردن این فیلد الزامی است"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-3" class="">
                                <div class="container">
                                    @php $count = 4;//count($products[0]->productFlags); @endphp
                                    @for($i = 0 ; $i < $count ; $i++)
                                        @if($products[0]->productFlags[$i]->title != 'price')
                                            <div class="col-md-10 col-md-offset-1 margin-1">
                                                <div id="grandparent">
                                                    <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                        <div class="col-md-2">
                                                            <a type="button" name="edit" id="edit"
                                                               class="glyphicon glyphicon-edit btn btn-success edit"
                                                               title="ویرایش "></a>
                                                        </div>
                                                        <div class="col-md-10">
                                                            @if(!empty($products[0]->productFlags[$i]))
                                                                <input disabled id="editable"
                                                                       class="form-control col-md-7 col-xs-12 editable pr"
                                                                       name="{{$products[0]->productFlags[$i]->title}}"
                                                                       value="{{$products[0]->productFlags[$i]->price}}">
                                                            @else
                                                                <input disabled id="editable"
                                                                       class="form-control col-md-7 col-xs-12 editable pr"
                                                                       name="{{$products[0]->productFlags[$i]->title}}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <label class="control-label col-md-2 col-sm-4 col-xs-3"
                                                           for="{{$products[0]->productFlags[$i]->title}}">
                                                        @if($products[0]->productFlags[$i]->title == 'special_price')
                                                            {{'قیمت ویژه (تومان):'}}
                                                        @endif
                                                        @if($products[0]->productFlags[$i]->title =='sales_price')
                                                            {{ 'قیمت حراج (تومان):'}}
                                                        @endif
                                                        @if($products[0]->productFlags[$i]->title == 'wholesale_price')
                                                            {{ 'قیمت عمده (تومان):'}}
                                                        @endif
                                                    </label>
                                                    {{--@endif--}}
                                                </div>
                                            </div>
                                        @endif
                                    @endfor
                                    <div class="col-md-10 col-md-offset-1 margin-1 margin-bot-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                    @if($products[0]->discount_volume != null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="discount_volume"
                                                               value="{{$products[0]->discount_volume}}">
                                                    @endif
                                                    @if($products[0]->discount_volume == null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="discount_volume">
                                                    @endif
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3"
                                                   for="discount_volume">
                                                حجم/تعداد مشمول
                                                تخفیف :
                                                <span class="required star" title="پر کردن این فیلد الزامی است"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1 margin-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                    @foreach($products[0]->productFlags as $flag)
                                                        @if($flag->active == 1)
                                                            @php
                                                                if($flag->title=="price")
                                                                    $title="قیمت اصلی";
                                                                elseif($flag->title=="sales_price")
                                                                    $title="قیمت حراج";
                                                                elseif($flag->title=="special_price")
                                                                    $title="قیمت ویژه";
                                                                elseif($flag->title=="wholesale_price")
                                                                    $title="قیمت عمده";
                                                                elseif($flag->title=="free_price")
                                                                    $title="قیمت زاپاس";
                                                            @endphp
                                                            <input class=" form-control currentPrice1" disabled
                                                                   value="{{$title}}"/>
                                                        @endif
                                                    @endforeach
                                                    <select class="editable form-control currentPrice2" disabled
                                                            id="editable"
                                                            name="activePrice" style="display: none">
                                                        <option value="price">قیمت اصلی</option>
                                                        <option value="sales_price">قیمت حراج</option>
                                                        <option value="special_price">قیمت ویژه</option>
                                                        <option value="wholesale_price">قیمت عمده</option>
                                                        <option value="free_price">قیمت زاپاس</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="control-label col-md-2 col-sm-4 col-xs-3" for="color">انتخاب قیمت
                                            فعلی محصول :
                                        </label>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1 margin-1 margin-bot-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2 ">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                    @if($products[0]->discount != null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="discount" value="{{$products[0]->discount}}">
                                                    @endif
                                                    @if($products[0]->discount == null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-12 editable"
                                                               name="discount">
                                                    @endif
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3" for="discount"> درصد
                                                تخفیف :
                                                <span class="required star" title="پر کردن این فیلد الزامی است"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-md-offset-1 margin-1 margin-bot-1">
                                        <div id="grandparent">
                                            <div class="col-md-7 col-sm-6 col-xs-9 col-md-offset-2">
                                                <div class="col-md-2">
                                                    <a type="button" name="edit" id="edit"
                                                       class="glyphicon glyphicon-edit btn btn-success edit"
                                                       title="ویرایش "></a>
                                                </div>
                                                <div class="col-md-10">
                                                    @if($products[0]->delivery_volume != null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-10 editable"
                                                               name="delivery_volume"
                                                               value="{{$products[0]->delivery_volume}}">
                                                    @endif
                                                    @if($products[0]->delivery_volume == null)
                                                        <input disabled id="editable"
                                                               class="form-control col-md-7 col-xs-10 editable"
                                                               name="delivery_volume">
                                                    @endif
                                                </div>
                                            </div>
                                            <label class="control-label col-md-2 col-sm-4 col-xs-3"
                                                   for="delivery_volume">
                                                حجم/تعداد مشمول
                                                پیک رایگان :
                                                <span class="required star" title="پر کردن این فیلد الزامی است"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-4" class="">
                                <div class="container">
                                    <div id="addPic" class="grandparent">
                                        @php $picCount = count($products[0]->productImages); @endphp
                                        @if($picCount)
                                            @foreach($products[0]->productImages as $image)
                                                <div class="parent" name="parent">
                                                    <div class="col-md-10 margin-1">
                                                        <div class="col-md-2 col-md-offset-3">
                                                            <a class="glyphicon glyphicon-edit btn btn-success editPic"
                                                               title="ویرایش "></a>
                                                        </div>
                                                        <div class="col-md-5 col-sm-6 col-xs-9 newFile" id="newFile"
                                                             style="display: none;">
                                                            <input class="form-control col-md-7 col-xs-12 editable"
                                                                   id="editable" name="file[]" type="file" disabled>
                                                        </div>
                                                        <div class="col-md-5 col-sm-6 col-xs-9 showPic" id="showPic"
                                                             style="display: block;">
                                                            <img class="image" id="editable" imageId="{{$image->id}}"
                                                                 style="height: 100px; width: 100px; margin-left: 80%;"
                                                                 src="{{url('public/dashboard/productFiles/picture')}}/{{$image->image_src}}">
                                                        </div>
                                                        <label class="control-label col-md-2 col-sm-4 col-xs-3"
                                                               for="pic">
                                                            <span class="required star"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        @if($picCount<4)
                                            <div id="addPicture" counter="{{$picCount}}">
                                                <div class="col-md-10 margin-1">
                                                    <div class="col-md-2 col-sm-1 col-xs-1 col-md-offset-3">
                                                        <a id="addInput"
                                                           class="glyphicon glyphicon-plus btn btn-success"
                                                           data-toggle=""
                                                           title="افزودن تصویر"></a>
                                                    </div>
                                                    <div class="col-md-5 col-sm-6 col-xs-9 ">
                                                        <input class="form-control col-md-12 col-xs-12"
                                                               type="file" name="file[]" id="pic"/>
                                                    </div>
                                                    <label class="control-label col-md-2 col-sm-4 col-xs-3" for="file">
                                                        تصویر محصول :
                                                        <span class="required star"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-10 ">
                                        <hr>
                                    </div>
                                    <div class="grandparent" id="grandparent">
                                        <div class="col-md-10 margin-bot-1 parent">
                                            <div class="col-md-2 col-md-offset-3">
                                                <a type="button" name="editVideo" id="editVideo"
                                                   class="glyphicon glyphicon-edit btn btn-success edit"
                                                   content="{{$products[0]->id}}"
                                                   title="ویرایش "></a>
                                                <a type="button" id="playVideo"
                                                   class="glyphicon glyphicon-play btn btn-success"
                                                   content="{{$products[0]->id}}"
                                                   title="پخش ویدئو "></a>
                                                <a type="button" id="pauseVideo"
                                                   class="glyphicon glyphicon-pause btn btn-success edit"
                                                   content="{{$products[0]->id}}"
                                                   title="توقف پخش ویدئو " style="display: none;"></a>

                                            </div>
                                            <div class="col-md-5 col-sm-6 col-xs-9 " id="videoContent">
                                                @if($products[0]->video_src != null)
                                                    <video class="video" style="width: 200px; height: 200px;"
                                                           id="video" name="video_src">
                                                        <source id="playingVideo"
                                                                src="{{url('public/dashboard/productFiles/video')}}/{{$products[0]->video_src}}">
                                                    </video>
                                                    <input
                                                            class="form-control col-md-7 col-xs-12 editable"
                                                            id="newVideo" src="" name="video_src" type="file"
                                                            style="display: none;">
                                                @endif
                                                @if($products[0]->video_src == null)
                                                    <input disabled="disabled"
                                                           class="form-control col-md-7 col-xs-12 editable"
                                                           id="editable" src="" name="video_src" type="file">
                                                @endif
                                            </div>

                                            <label class="control-label col-md-2 col-sm-4 col-xs-3" for="video_src">
                                                ویدئوی
                                                محصول :
                                                <span class="required star"></span>
                                            </label>
                                        </div>
                                    </div>
                                    @php $OptionCount = count($products[0]->productOption); @endphp
                                    @if($OptionCount)
                                        @foreach($products[0]->productOption as $option)
                                            <div id="grandparent" class="grandparent">
                                                <div class="parent" name="parent">
                                                    <div class="col-md-10 margin-1">
                                                        <div class="col-md-2 col-md-offset-3" id="edit">
                                                            <a class="glyphicon glyphicon-edit btn btn-success edit"
                                                               title="ویرایش "></a>
                                                        </div>
                                                        <div class="col-md-5 col-sm-6 col-xs-9 showPic" id="option"
                                                             style="display: block;">
                                                            <input id="editable" name="option[]" class="form-control col-md-7 col-xs-12 editable"
                                                                    disabled value="{{$option->title}} ">
                                                            <input class="editable" id="editable" type="hidden" name="optionId[]" disabled value="{{$option->id}}">
                                                        </div>
                                                        <label class="control-label col-md-2 col-sm-4 col-xs-3"
                                                               for="option">
                                                            <span class="required star"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    {{--<div class="grandparent" id="grandparent">--}}
                                    {{--<div class="col-md-10 margin-bot-1 parent">--}}
                                    {{--<div class="col-md-2 col-md-offset-3">--}}
                                    {{--<a type="button" name="edit" id="edit"--}}
                                    {{--class="glyphicon glyphicon-edit btn btn-success edit"--}}
                                    {{--title="ویرایش "></a>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-5 col-sm-6 col-xs-9 editable" name="colors"--}}
                                    {{--id="editable">--}}
                                    {{--@foreach($products[0]->colors as $color)--}}
                                    {{--<div class="col-md-4 col-sm-6 col-xs-3 float-right">--}}
                                    {{--<label class="myLabel">--}}
                                    {{--<input class="form-control myColor" disabled="disabled"--}}
                                    {{--checked type="checkbox"--}}
                                    {{--name="color[]" value="{{$color->title}}"/>--}}
                                    {{--{{$color->title}}--}}
                                    {{--</label></div>--}}
                                    {{--@endforeach--}}
                                    {{--</div>--}}
                                    {{--<label class="control-label col-md-2 col-sm-4 col-xs-3" for="color">انتخاب--}}
                                    {{--رنگهای محصول :--}}
                                    {{--</label>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="grandparent" id="grandparent">--}}
                                    {{--<div class="col-md-10 margin-bot-1 parent">--}}
                                    {{--<div class="col-md-2 col-md-offset-3">--}}
                                    {{--<a type="button" name="edit" id="edit"--}}
                                    {{--class="glyphicon glyphicon-edit btn btn-success edit"--}}
                                    {{--title="ویرایش "></a>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-md-5 col-sm-6 col-xs-9 editable" name="sizes" id="editable">--}}
                                    {{--@foreach($products[0]->sizes as $size)--}}
                                    {{--<div class="col-md-4 col-sm-6 col-xs-3 float-right">--}}
                                    {{--<label class="myLabel">--}}
                                    {{--<input class="form-control myColor" disabled="disabled"--}}
                                    {{--checked type="checkbox"--}}
                                    {{--name="size[]" value="{{$size->title}}"/>--}}
                                    {{--{{$size->title}}--}}
                                    {{--</label></div>--}}
                                    {{--@endforeach--}}
                                    {{--</div>--}}
                                    {{--<label class="control-label col-md-2 col-sm-4 col-xs-3" for="size">انتخاب--}}
                                    {{--اندازه--}}
                                    {{--های محصول :--}}
                                    {{--</label>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div>--}}
                                    {{--<div class="col-md-12 margin-2 margin-bot-1">--}}
                                    {{--<div class="col-md-5 col-sm-6 col-xs-9 col-md-offset-3 margin-1 padding-right-2"--}}
                                    {{--id="size">--}}
                                    {{--</div>--}}

                                    {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <br/>
            </form>
        </div>
        <!-- 1-Include SmartWizard JavaScript source -->
        <script type="text/javascript"
                src="{{url('public/dashboard/stepWizard/js/jquery.smartWizard.min.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#productForm").submit(function (e) {
                    e.preventDefault();
                });

                // Toolbar extra buttons
                var btnFinish = $('<button></button>').text('ویرایش')
                    .addClass('btn btn-info')
                    .on('click', function () {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        var formData = new FormData($("#productForm")[0]);
                        $.ajax({
                            url: '{{url('admin/updateProduct')}}',
                            type: 'post',
                            cashe: false,
                            data: formData,
                            dataType: 'json',
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                var x = '';
                                $.each(data, function (key, val) {
                                    x += val + '\n'
                                });
                                swal({
                                    title: '',
                                    text: x,
                                    type: "info",
                                })
                                  setTimeout(function(){window.location.reload(true);},3000);
                            },
                            error: function (xhr) {
                                console.log(xhr)
                                swal({
                                    title: '',
                                    text: xhr,
                                    type: "info",
                                })
                            }
                        })
                    });
                var btnCancel = $('<button></button>').text('شروع مجدد')
                    .addClass('btn btn-danger').css("display", "none")
                    .on('click', function () {
                        $('#smartwizard').smartWizard("reset");
                        $('#productForm')[0].reset();
                    });
                $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'arrows',
                    transitionEffect: 'fade',
                    showStepURLhash: false,
                    toolbarSettings: {
                        toolbarPosition: 'bottom',
                        toolbarExtraButtons: [btnFinish, btnCancel]
                    }
                });
                // External Button Events
                $("#reset-btn").on("click", function () {
                    // Reset wizard
                    $('#smartwizard').smartWizard("reset");
                    return true;
                });
                $("#prev-btn").on("click", function () {
                    // Navigate previous
                    $('#smartwizard').smartWizard("قبلی");
                    return true;
                });
                $("#next-btn").on("click", function () {
                    // Navigate next
                    $('#smartwizard').smartWizard("بعدی");
                    return true;
                });
                $(".sw-btn-next").text('بعدی');
                $(".sw-btn-prev").text('قبلی');
//
            });
        </script>
        <!-- 2-send product form -->
        <script>
            $(document).ready(function () {
                //add input type file for add pic for product
                var counter = 0;
                var c = $("#addPicture").attr('counter');
                counter += c;
                $('#addInput').on('click', function () {
                    if (counter < 3) {
                        $('#addPicture').append
                        (
                            '<div class="col-md-10 margin-1">' +
                            '<div class="col-md-5 col-sm-6 col-xs-9 col-md-offset-5">' +
                            '<input class="form-control col-md-12 col-xs-12" type="file" name="file[]" id="file"/>' +
                            '</div>' +
                            '<label class="control-label col-md-2 col-sm-4 col-xs-3" for="pic"> تصویر محصول :' +
                            '<span class="required star"></span>' +
                            '</label></div>'
                        );
                        counter++;
                    }
                    else {
                    }
                })
            });
        </script>
        <!-- 3-below script is to zoom in/out picture  -->
        <script>
            $(document).ready(function () {
                $('.image').hover(
                    function () {
                        $(this).animate({'zoom': 1.4}, 400);
                    },
                    function () {
                        $(this).animate({'zoom': 1}, 400);
                    });
            });
        </script>
        <!-- 4-below script is to make inputs editable -->
        <script>
            function appendItem(divId, inputName, myUrl) {
                $.ajax({
                    url: myUrl,
                    dataType: "json",
                    cache: false,
                    type: "get",
                    success: function (response) {
                        var item = $(divId);
                        item.empty();
                        $.each(response, function (key, value) {
                            item.append(
                                '<div class="col-md-4 col-sm-6 col-xs-3 float-right">' +
                                '<label class="myLabel">' +
                                '<input class="form-control myColor" type="checkbox" name="' + inputName + '[]" value="' + value.id + '"/>'
                                + value.title + '</label></div>')
                        });
                    }
                })
            }

            $(function () {
                $('.edit').each(function () {
                    $(this).click(function () {
                        var DOM = $(this).parentsUntil('#grandparent');
                        var editable = $(DOM).find('#editable');
                        $(editable).prop('disabled', false);
                        if (editable.attr('name') == 'unit_count') {
                            $("#unit_count_parent").empty();
                            $("#unit_count_parent").append(
                                '<select id="editable"' +
                                'class="form-control col-md-7 col-xs-12 editable my_units" name="unit_count" value="{{$products[0]->unit_count}}">' +
                                '<option value="{{$products[0]->unit_count}}">{{$products[0]->unit_count}}</option></select>');
                            loadUnits();
                        }
                        else if (editable.attr('name') == 'sub_unit_count') {
                            $("#sub_unit_count_parent").empty();
                            $("#sub_unit_count_parent").append(
                                '<select id="editable"' +
                                'class="form-control col-md-7 col-xs-12 editable" name="sub_unit_count" value="{{$products[0]->sub_unit_count}}">' +
                                '<option selected value="{{$products[0]->sub_unit_count}}">{{$products[0]->sub_unit_count}}</option></select>');
                            $.ajax
                            ({
                                cache: false,
                                url: "{{Url('api/v1/getSubunitsBySubUnitTitle')}}",
                                dataType: "json",
                                type: "post",
                                data: {'title': "{{$products[0]->sub_unit_count}}"},
                                success: function (response) {
                                    var responses = response;
                                    var selectBoxId = "[name='sub_unit_count']";
                                    var msgOpt1 = "لطفا زیر واحد شمارش مورد نظر خود را انتخاب نمایید";
                                    var msgOpt2 = "اگر زیر واحد شمارش مورد نظر در این لیست وجود ندارد این گزینه انتخاب نمایید";
                                    var valueOption2 = 0;
                                    loadItems(responses, selectBoxId, msgOpt1, msgOpt2, valueOption2)
                                }
                            });
                        }
                        else if (editable.attr('name') == 'activePrice') {
                            $(".currentPrice1").remove();
                            $(".currentPrice2").show();
                        }
                        else if (editable.attr('name') == 'colors') {
                            appendItem("[name='colors']", "color", "{{url('api/v1/getColors')}}");
                        }
                        else if (editable.attr('name') == 'sizes') {
                            appendItem("[name='sizes']", "size", "{{url('api/v1/getSizes')}}");
                        }
                    })
                })
            })
        </script>
        <!-- 5-below script is to make picture hidden and display7 an another input type file -->
        <script>
            $(function () {
                $('.editPic').each(function () {

                    $(this).click(function () {
                        var DOM = $(this).parentsUntil('.grandparent');
                        var showPic = $(DOM).find('.showPic');
                        var imageId = $(showPic).find("img").attr("imageId");
                        swal({
                                title: '',
                                text: 'قبل از ویرایش تصویر باید تصویر فعلی حذف شود، آیا از حذف تصویر اطمینان دارید؟',
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "  #5cb85c",
                                cancelButtonText: "خیر",
                                confirmButtonText: "آری",
                                closeOnConfirm: true,
                                closeOnCancel: true
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    //load all subCategory in select box in addProductForm
                                    $.ajax({
                                        url: "{{url('admin/deleteProductPicture')}}/" + imageId,
                                        type: 'get',
                                        dataType: "json",
                                        success: function (response) {
                                            console.log(response)
                                            if (response == true) {
                                                $(showPic).css('display', 'none');
                                                var newFile = $(DOM).find('.newFile');
                                                $(newFile).find('input').attr('disabled', false);
                                                $(newFile).css('display', 'block');
                                            }
                                        }
                                    });
                                }
                                else {
                                }
                            });
                    })
                })
            })
        </script>
        <!-- 6-below script is to handle category management -->
        <script>
            $(document).on('click', '#editCategory', function () {
                //var categoryId = $(this).attr('content');
                //alert(categoryId);
                $('#myModal').modal('show');
            })
        </script>
        <script src="{{ URL::asset('public/js/persianDatepicker.js')}}"></script>
        {{--7-persianDatepicker--}}
        <script>
            $(function () {
                $("[name = 'produce_date']").each(function () {
                    $(this).persianDatepicker();
                })
                $("[name = 'expire_date']").each(function () {
                    $(this).persianDatepicker();
                })
            })
        </script>
        {{--8-formatNumber for price value--}}
        <script>
            $(function () {
                function formatNumber(num) {
                    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
                }

                $(".pr").on('keyup', function () {
                    var price = $(this);
                    var v0 = price.val();
                    var v1 = v0.split(',').join('');
                    var v2 = formatNumber(v1);
                    price.val(v2)
                })
            })
        </script>
        <script>
            //9-load item in select box
            function loadItems(responses, selectBoxId, msgOption1, msgOption2, valueOption2) {
                var item = $(selectBoxId);
                item.empty();
                item.append("<option selected='true' disabled='disabled'>" + msgOption1 + "</option>")
                item.append("<option value='" + valueOption2 + "'>" + msgOption2 + "</option>")
                $.each(responses, function (key, value) {
                    item.append
                    ("<option value='" + value.id + "' depth='" + value.depth + "'>" + value.title + "</option>");
                });
            }
            //10-load all main category in select box in addProductForm
            $.ajax({
                cache: false,
                url: "{{url('api/v1/getMainCategories')}}",
                type: 'get',
                dataType: "json",
                success: function (response) {
                    if (response != 0) {
                        var responses = response;
                        var selectBoxId = "#categories";
                        var msgOpt1 = "لطفا دسته مورد نظر خود را انتخاب نمایید";
                        var msgOpt2 = "اگر دسته مورد نظر در این لیست وجود ندارد این گزینه را انتخاب نمایید";
                        var valueOption2 = "000";
                        loadItems(responses, selectBoxId, msgOpt1, msgOpt2, valueOption2)
                    }
                    else {
                        location.href = '{{url("admin/addCategory")}}';
                    }
                }
            })
            //11-load subCategories after ask do you want load it's sub Categories or no then load product title related selected category
            $('#categories').on("change", function () {
                var id = $(this).val();
                var depth = $(this).find("option:selected ").attr('depth');
                var selectedText = $(this).find("option:selected").text();
                if (id == 000) {
                    location.href = '{{url("admin/addCategory")}}';
                }
                else if (depth != 0) {
                    swal({
                            title: '',
                            text: 'آیا میخواهید زیردسته های دسته ی منتخب را ببینید و محصول را در یکی از زیر دسته ها ذخیره کنید؟',
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "  #5cb85c",
                            cancelButtonText: "خیر",
                            confirmButtonText: "آری",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                //load all subCategory in select box in addProductForm
                                $.ajax
                                ({
                                    cache: false,
                                    url: "{{Url('api/v1/getSubCategories')}}/" + id,
                                    dataType: "json",
                                    type: "get",
                                    success: function (response) {
                                        var responses = response;
                                        var selectBoxId = '#subCategories';
                                        var msgOpt1 = "لطفا زیر دسته مورد نظر را انتخاب نمایید";
                                        var msgOpt2 = "اگر زیر دسته مورد نظر در این لیست وجود ندارد این گزینه انتخاب نمایید";
                                        var valueOption2 = "000";
                                        loadItems(responses, selectBoxId, msgOpt1, msgOpt2, valueOption2)
                                        $('#subCategoriesDiv').css('display', 'block');
                                        //hide brands selector parent div after change categories and empty it's selector
                                        $('#BrandsDiv').css('display', 'none');
                                        $('#brands').empty();
                                    }
                                });
                            }
                            else {//if user select 'خیر'
                                $('#subCategoriesDiv').css('display', 'none');
                                $('#subCategories').empty();
                                //hide brands selector parent div after change categories and empty it's selector
                                $('#BrandsDiv').css('display', 'none');
                                $('#brands').empty();
                            }
                        });
                }
                else {
                    $('#subCategoriesDiv').css('display', 'none');
                    $('#BrandsDiv').css('display', 'none');
                    $('#subCategories').empty();
                    $('#brands').empty();
                }
                $("#lastCategory").val(id);
                $("#lastCategoryName").attr('name', selectedText)
            })
            //12-load brands after ask do you want load it's brands or no then load product title related selected subCategory
            $('#subCategories').on("change", function () {
                var id = $(this).val();
                var depth1 = $(this).find("option:selected ").attr('depth');
                var selectedText = $(this).find("option:selected").text();
                if (id == 000) {
                    location.href = '{{url("admin/addCategory")}}';
                }
                else if (depth1 != 0) {
                    swal({
                            title: '',
                            text: 'آیا میخواهید زیردسته های دسته ی منتخب را ببینید و محصول را در یکی از برندها ذخیره کنید؟',
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "  #5cb85c",
                            cancelButtonText: "خیر",
                            confirmButtonText: "آری",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                //load all subCategory in select box in addProductForm
                                $.ajax
                                ({
                                    cache: false,
                                    url: "{{Url('api/v1/getBrands')}}/" + id,
                                    dataType: "json",
                                    type: "get",
                                    success: function (response) {
                                        var responses = response;
                                        var selectBoxId = '#brands';
                                        var msgOpt1 = "لطفا زیر دسته مورد نظر را انتخاب نمایید";
                                        var msgOpt2 = "اگر زیر دسته مورد نظر در این لیست وجود ندارد این گزینه انتخاب نمایید";
                                        var valueOption2 = "000";
                                        loadItems(responses, selectBoxId, msgOpt1, msgOpt2, valueOption2)
                                        $('#BrandsDiv').css('display', 'block');
                                    }
                                });
                            }
                            else {//if user select 'خیر'
                                //hide brands selector parent div after change categories and empty it's selector
                                $('#BrandsDiv').css('display', 'none');
                                $('#brands').empty();
                            }
                        });
                }
                else {
                    $('#BrandsDiv').css('display', 'none');
                    $('#brands').empty();
                }
                $("#lastCategory").val(id);
                $("#lastCategoryName").attr('name', selectedText)
            })
            //13-check option 2 selected or not, if yes redirect to addCategory view
            $('#brands').on("change", function () {
                var id = $(this).val();
                var selectedText = $(this).find("option:selected").text();
                if (id == 000) {
                    location.href = '{{url("admin/addCategory")}}';
                }
                $("#lastCategory").val(id);
                $("#lastCategoryName").attr('name', selectedText)
            });
            $("#submitCategory").click(function () {
                $("#lastCategory").attr('disabled', false);
                selectedText = $("#lastCategoryName").attr('name')
                $("#lastCategoryName").val(selectedText);
            });
            $("#unit_count_parent").on("change", function () {
                var id = ($(this).find("select").val());
                if (id == 0) {
                    location.href = '{{url("admin/addUnit")}}';
                }
                else {
                    $.ajax
                    ({
                        cache: false,
                        url: "{{Url('api/v1/getSubunits')}}/" + id,
                        dataType: "json",
                        type: "get",
                        success: function (response) {
                            var responses = response;
                            var selectBoxId = "[name='sub_unit_count']";
                            var msgOpt1 = "لطفا زیر واحد شمارش مورد نظر خود را انتخاب نمایید";
                            var msgOpt2 = "اگر زیر واحد شمارش مورد نظر در این لیست وجود ندارد این گزینه انتخاب نمایید";
                            var valueOption2 = 0;
                            loadItems(responses, selectBoxId, msgOpt1, msgOpt2, valueOption2)
                        }
                    });
                }
            });
            function loadUnits() {
                //load MainUnitsCount if there is no category in table redirect addCategory
                $.ajax({
                    cache: false,
                    url: "{{Url('api/v1/getMainUnits')}}",
                    dataType: "json",
                    type: "get",
                    success: function (response) {
                        if (response != 0) {
                            var responses = response;
                            var selectBoxId = "[name='unit_count']";
                            var msgOpt1 = "لطفا واحد شمارش مورد نظر خود را انتخاب نمایید";
                            var msgOpt2 = "اگر واحد شمارش مورد نظر در این لیست وجود ندارد این گزینه انتخاب نمایید";
                            var valueOption2 = 0000;
                            loadItems(responses, selectBoxId, msgOpt1, msgOpt2, valueOption2)
                        }
                        else {
                            location.href = '{{url("admin/addCategory")}}';
                        }
                    }
                });//end ajax
            }
            loadUnits();
        </script>
        <script>
            $(document).on('click', '#playVideo', function () {

                var video = document.getElementById('video');
                if (video != null) {
                    video.play();
                    $(this).hide();
                    $('#pauseVideo').show();
                }

            })
            $(document).on('click', '#pauseVideo', function () {
                $(this).hide();
                $('#playVideo').show();
                var video = document.getElementById('video');
                video.pause();
            })
        </script>
        <script>
            $(document).on('click', '#editVideo', function () {
                // var DOM       = $(this).parentsUntil('#grandparent');
                var productId = $(this).attr('content');
                var editable = $('#videoContent');
                var me = $(this);
                if (editable.children().length > 0) {
                    swal({
                            title: '',
                            text: 'قبل از ویرایش فیلم محصول ابتدا باید آن را حذف نمائید  ، آیا مایل به انجام این کار هستید؟',
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "  #5cb85c",
                            cancelButtonText: "خیر",
                            confirmButtonText: "آری",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax
                                ({
                                    url: "{{url('admin/deleteVideo')}}",
                                    type: "get",
                                    dataType: "json",
                                    data: {'productId': productId},
                                    context: {'me': me},
                                    success: function (response) {
                                        if (response.message == 'success') {
                                            $('#video').css('display', 'none');
                                            $('#newVideo').css('display', 'block');
                                            $(me).attr('id', 'edit');
                                            $(me).attr('name', 'edit');
                                        } else {
                                            swal({
                                                title: '',
                                                text: 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید',
                                                type: "warning",
                                            })
                                        }
                                    }, error: function (error) {
                                        console.log(error);
                                    }
                                })
                            }
                        }
                    );
                } else {

                }
            })
        </script>
@endsection