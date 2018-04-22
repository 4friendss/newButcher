@extends('layouts.mainLayout')
@section('content')

    <style>
        .annoy
        {
          margin-top: -3.40% !important;
        }
    </style>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog" dir="rtl">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">نمایش ویدئوی محصول</h2>
                </div>
                <div class="modal-body">
                    <video   class="video" style="width: 200px; height: 200px;"
                             id="video" name="video_src">
                        <source id="playingVideo" src="{{url('public/dashboard/productFiles/video')}}/{{$product->video_src}}">
                    </video>
                </div>
                <div class="modal-footer" >

                    <a type="button"  id="playVideo"
                       class="glyphicon glyphicon-play btn btn-success pull-left col-md-offset-3"
                       title="پخش ویدئو "></a>
                    <a class="col-md-offset-3"></a>
                    <a type="button"  id="pauseVideo"
                       class="glyphicon glyphicon-pause btn btn-success edit pull-left col-md-offset-3"
                       title="توقف پخش ویدئو " style="display: none;"></a>

                    <button type="button" class="btn btn-warning col-md-6 annoy" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="columns">
        <!-- breadcrumb -->
        <div class="breadcrumb clearfix">
            <a class="home" href="#" title="Return to Home">خانه</a>
            <a href="#" title="">{{$cat}}</a>
            <span class="navigation-pipe">&nbsp;</span>
            <a href="#" title="">{{$subcat}}</a>
            <span class="navigation-pipe">&nbsp;</span>
            <a href="{{url('showProducts/'.$product->categories[0]->id)}}"
               title="">{{$product->categories[0]->title}}</a>
            <span class="navigation-pipe">&nbsp;</span>
            <a href="#" title="">{{$product->title}}</a>
        </div>
        <!-- ./breadcrumb -->
        <!-- row -->
        <div class="row">

            <!-- Center column -->
            <div class="center_column col-xs-12 col-sm-12" id="center_column">
                <!-- Product -->
                <div id="product">
                    <form id="orderOptionForm">
                        {{--<input type="hidden" id="token" value="{{csrf_token()}}" name="_token">--}}
                        <div class="primary-box row">
                            <div class="pb-right-column col-xs-12 col-sm-7">
                                <h1 class="product-name" dir="rtl">{{$product->title}}</h1>
                                <br>
                                <div class="product-comments " dir="rtl">
                                    <div class="comments-advices">
                                        <span href="#" class="margin-r-0">امتیاز:</span>
                                    </div>
                                    @if($product->productScore == null ||  $product->productScore == 0 )
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                        <i class="fa fa-star-o"></i>
                                    @endif
                                    @if($product->productScore != null ||  $product->productScore != 0 )
                                        @if(filter_var($product->productScore,FILTER_VALIDATE_INT))
                                            <?php $i = 0;   ?>
                                            @while($product->productScore > $i)
                                                <i class="fa fa-star"></i>
                                                <?php $i++; ?>
                                            @endwhile
                                            <?php $sub = 5 - $product->productScore ?>
                                            @while($sub > 0 )
                                                <i class="fa fa-star-o"></i>
                                                <?php $sub--; ?>
                                            @endwhile
                                        @endif
                                        @if(!filter_var($product->productScore,FILTER_VALIDATE_INT))
                                            <?php $array = explode('.', $product->productScore);?>
                                            @while($array[0] > 0)
                                                <i class="fa fa-star"></i>
                                                <?php $array[0]--; ?>
                                            @endwhile
                                            <i class="fa fa-star-half-o"></i>
                                            <?php $sub = 5 - $product->productScore ?>
                                            @while($sub-1 > 0 )
                                                <i class="fa fa-star-o"></i>
                                                <?php $sub--; ?>
                                            @endwhile
                                        @endif
                                    @endif
                                </div>
                                <div class="product-price-group" dir="rtl">
                                    <span class="price margin-r-0" dir="rtl">
                                        @foreach($product->productFlags as $flag)
                                            @if($flag->active == 1)
                                                @if($flag->title == "price")
                                                    <b>قیمت اصلی : </b>
                                                @endif
                                                @if($flag->title == "special_price")
                                                    <b>قیمت ویژه : </b>
                                                @endif
                                                @if($flag->title == "wholesale_price")
                                                    <b>قیمت عمده : </b>
                                                @endif
                                                @if($flag->title == "sales_price")
                                                    <b>قیمت حراج : </b>
                                                @endif
                                                @if($flag->title == "free_price")
                                                    <b>قیمت آزاد : </b>
                                                @endif
                                                <b> <a class="price margin-r-0" id="productFlag" data-toggle=""
                                                       name="{{$flag->price}}"
                                                       title="تومان">{{number_format($flag->price)}} </a>
                                                                </b>&nbsp;<b style="float: left"> تومان </b>
                                            @endif
                                        @endforeach</span>
                                    {{--<span class="old-price">$52.00</span>--}}
                                    {{--<span class="discount">-30%</span>--}}
                                </div>
                                <div class="product-desc text-justify" dir="rtl">
                                    {{$product->description}}
                                </div>
                                {{--@if(count($product->ProductOption)>0)--}}
                                    {{--<div class="form-option">--}}
                                        {{--<p class="float-r form-option-title">: گزینه های ارسال محصول</p>--}}
                                        {{--<div class="attributes">--}}
                                            {{--<div class="attribute-label" dir="rtl"></div>--}}
                                            {{--<div class="attribute-list float-r">--}}
                                                {{--@foreach ($product->productOption as $opt)--}}
                                                    {{--<div class="col-md-12 col-sm-12 ">--}}
                                                        {{--<input type="checkbox" name="orderOption[]" class="float-r"--}}
                                                               {{--value="{{$opt->title}}"/>--}}
                                                        {{--<label class="float-r margin-r-5">{{$opt->title}}</label>--}}
                                                    {{--</div>--}}
                                                {{--@endforeach--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                    {{--</div>--}}
                                {{--@endif--}}
                                <div class="form-action" dir="rtl">
                                    <div class="button-group">
                                        <div class="right-block display-inline" dir="rtl">
                                            <div class="add-to-cart">
                                                <input type="button" class="btn btn-warning addToBasket" id="addToBasket" value="افزودن به سبد خرید">
                                                @if($product->video_src != null)
                                                    <input type="button" class="btn btn-danger" id="showProductVideo" value="مشاهده ویدئو محصول">
                                                @endif
                                                <input type="hidden" name="productId" id="productId"
                                                       value="{{$product->id}}">
                                                <input type="hidden" name="productFlag" id="productFlag"
                                                @foreach($product->productFlags as $flag)
                                                    @if($flag->active == 1)
                                                        value="{{$flag->price}}"
                                                    @endif
                                                @endforeach>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    {{--<div class="button-group float-r">--}}
                                    {{--<a class="wishlist" href="#"><i class="fa fa-heart-o"></i>--}}
                                    {{--<br>افزودن به علاقه مندی ها</a>--}}
                                    {{--<a class="compare" href="#"><i class="fa fa-signal"></i><br>--}}
                                    {{--مقایسه</a>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                            <div class="pb-left-column col-xs-12 col-sm-5">
                                <div class="product-image">
                                    <div class="product-full product-image-size">
                                        <!-- product-image-->
                                        <!-- check product does have any picture or no for product gallery  -->
                                        @if(count($product->productImages))
                                            <img id="product-zoom"
                                                 src="{{url('public/dashboard/productFiles/picture/'.$product->productImages[0]->image_src)}}"
                                                 data-zoom-image="{{url('public/dashboard/productFiles/picture/'.$product->productImages[0]->image_src)}}"/>
                                        @else
                                            <img id="product-zoom" style="width: 100%"
                                                 src="{{url('public/dashboard/productFiles/picture/no-image.jpg')}}"
                                                 data-zoom-image="{{url('public/dashboard/productFiles/picture/no-image.jpg')}}"/>

                                        @endif
                                    </div>
                                    <div class="product-img-thumb" id="gallery_01">
                                        <ul class="owl-carousel" data-items="3" data-nav="true" data-dots="false"
                                            data-margin="21" data-loop="true">
                                            @foreach($product->productImages as $img)
                                                <li>
                                                    <a href="#"
                                                       data-image="{{url('public/dashboard/productFiles/picture/'.$img->image_src)}}"
                                                       data-zoom-image="{{url('public/dashboard/productFiles/picture/'.$img->image_src)}}">
                                                        <img id="product-zoom"
                                                             src="{{url('public/dashboard/productFiles/picture/'.$img->image_src)}}"/>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <!-- product-image-->
                            </div>
                        </div>
                    </form>
                    <!-- box product -->
                    <div class="page-product-box">
                        <h3 class="heading">محصولات مشابه</h3>
                        <ul class="product-list owl-carousel" data-dots="false" data-loop="true" data-nav="true"
                            data-margin="30" data-autoplayTimeout="1000" data-autoplayHoverPause="true"
                            data-responsive='{"0":{"items":1},"600":{"items":3},"1000":{"items":4}}'>
                            @foreach($similarProduct as $sm)
                                @foreach($sm as $val)
                                    <li>
                                        <div class="product-container">
                                            <div class="left-block">
                                                <a href="#">
                                                    <?php $x = 1; ?>
                                                    @foreach($val->productImages as $img)
                                                        @if($x)
                                                            <img class="img-responsive similar-product-image"
                                                                 alt="product"
                                                                 src="{{url('public/dashboard/productFiles/picture/'.$img->image_src)}}"/>
                                                            <?php $x = 0; ?>
                                                        @endif
                                                    @endforeach
                                                </a>
                                                <div class="quick-view">
                                                    <a title="Add to my wishlist" class="heart" href="#"></a>
                                                    <a title="Add to compare" class="compare" href="#"></a>
                                                    <a title="نمایش توضیحات" class="search"
                                                       href="{{url('productDetail/'.$val->id)}}"></a>
                                                </div>
                                                {{--<div class="add-to-cart">--}}
                                                {{--<a title="Add to Cart" href="#add">Add to Cart</a>--}}
                                                {{--</div>--}}
                                            </div>
                                            <div class="right-block">
                                                <h5 class="product-name"><a href="#">{{$val->title}}</a></h5>
                                                {{--<div class="product-star">--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star"></i>--}}
                                                {{--<i class="fa fa-star-half-o"></i>--}}
                                                {{--</div>--}}
                                                <div class="content_price">
                                                    {{--<div class="col-md-6">--}}
                                                    @foreach($val->productFlags as $flag)
                                                        @if($flag->active == 1)
                                                            <b><a class="price" id="productFlag" data-toggle=""
                                                                  name="{{$flag->price}}" title="تومان">
                                                                    &nbsp;{{number_format($flag->price)}}&nbsp; </a>
                                                            </b>&nbsp;<b style="float: left"> تومان </b> &nbsp;
                                                        @endif
                                                    @endforeach
                                                    {{--</div>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                    <!-- ./box product -->
                </div>
                <!-- Product -->
            </div>
            <!-- ./ Center colunm -->
        </div>
        <!-- ./row-->
    </div>
    </div>
@endsection