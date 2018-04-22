@extends('layouts.mainLayout')
@section('content')
    <style>
        .font-16 {
            font-size: 16px !important;
        }
    </style>
    <div class="columns-container">
        <div class="container" id="columns">
            <!-- row -->
            <div class="row">
                <!-- Center column-->
                <div class="center_column col-md-12 col-xs-12 col-sm-12" id="center_column">
                    <!-- category short-description -->
                    <div class="cat-short-desc">
                        <!-- view-product-list-->
                        <div id="view-product-list" class="view-product-list">
                            <!-- PRODUCT LIST -->
                            <ul class="row product-list grid">
                                @if(count($results)>0)
                                    @foreach($results as $product)
                                        <li class="col-sx-12 col-sm-4 col-md-3">
                                            <div class="product-container">
                                                <div class="left-block">
                                                    <a>
                                                        @if(!empty($product->productImages[0]))
                                                            <img src="{{url('public/dashboard/productFiles/picture/'.$product->productImages[0]->image_src)}}"
                                                                 alt="عنوان محصول" height="250"/>
                                                        @endif
                                                    </a>
                                                    <div class="quick-view">
                                                        <a title="افزودن به علاقه مندی ها" class="heart"></a>
                                                        <a title="مقایسه" class="compare"></a>
                                                        <a title="نمایش جزئیات" class="search"
                                                           href="{{url('productDetail/'.$product->id)}}"></a>
                                                    </div>
                                                    <div class="add-to-cart">
                                                        <a href="{{url('productDetail/'.$product->id)}}">نمایش جزئیات</a>
                                                    </div>
                                                    @foreach($product->productFlags as $flag)
                                                        <div class="group-price">
                                                            @if($flag->active == 1)
                                                                <span class="product-sale">
                                        @if($flag->title == "price")
                                                                        <b>قیمت اصلی </b>
                                                                    @endif
                                                                    @if($flag->title == "special_price")
                                                                        <b>قیمت ویژه </b>
                                                                    @endif
                                                                    @if($flag->title == "wholesale_price")
                                                                        <b>قیمت عمده </b>
                                                                    @endif
                                                                    @if($flag->title == "sales_price")
                                                                        <b>قیمت حراج </b>
                                                                    @endif
                                                                    @if($flag->title == "free_price")
                                                                        <b>قیمت آزاد </b>
                                                                    @endif
                                        </span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="right-block margin-top-20">
                                                    <h3 class="product-name text-right col-md-12">
                                                        @if(strlen($product->title) != mb_strlen($product->title, 'utf-8'))
                                                            <a class="text-right">{{$product->title}}</a>
                                                        @endif
                                                        @if(strlen($product->title) == mb_strlen($product->title, 'utf-8'))
                                                            <a class="text-left">{{$product->title}}</a>
                                                        @endif
                                                    </h3>
                                                    <div class="text-left">
                                                        <div class="">
                                                            <div class="col-md-6">
                                                                @foreach($product->productFlags as $flag)
                                                                    @if($flag->active == 1)
                                                                        <b><a class="price" id="productFlag"
                                                                              data-toggle="" name="{{$flag->price}}"
                                                                              title="تومان">
                                                                                &nbsp;{{number_format($flag->price)}}
                                                                                &nbsp; </a>
                                                                        </b>&nbsp;<b style="float: left"> تومان </b>
                                                                        &nbsp;
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                            <div class=" col-md-6">
                                                                <span class="price product-price pull-right" dir="rtl">
                                                                        قیمت({{$product->unit_count }})
                                                                </span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class=" text-right">
                                                        <div class="col-md-12">
                                                            <div class="col-md-6">
                                    <span class="product-star">
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
                                    </span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <span class="price product-price">   امتیاز  </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </li>
                                    @endforeach
                                @else
                                    <p dir="rtl" data-dismiss=""
                                       class="text-center font-16 alert alert-warning alert-dismissable">متاسفانه موردی
                                        یافت نشد!</p>
                                @endif
                            </ul>
                            <!-- ./PRODUCT LIST -->
                        </div>
                        {{--@if(count($results))--}}
                        {{--<div class="sortPagiBar">--}}
                        {{--<div class="bottom-pagination">--}}
                        {{--<nav>--}}
                        {{--<ul class="pagination">--}}
                        {{--<li class="active"><a href="#">1</a></li>--}}
                        {{--<li><a href="#">2</a></li>--}}
                        {{--<li><a href="#">3</a></li>--}}
                        {{--<li><a href="#">4</a></li>--}}
                        {{--<li><a href="#">5</a></li>--}}
                        {{--<li>--}}
                        {{--<a href="#" aria-label="Next">--}}
                        {{--<span aria-hidden="true">Next &raquo;</span>--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        {{--</ul>--}}
                        {{--</nav>--}}
                        {{--</div>--}}
                        {{--<div class="show-product-item">--}}
                        {{--<select name="">--}}
                        {{--<option value="">Show 18</option>--}}
                        {{--<option value="">Show 20</option>--}}
                        {{--<option value="">Show 50</option>--}}
                        {{--<option value="">Show 100</option>--}}
                        {{--</select>--}}
                        {{--</div>--}}
                        {{--<div class="sort-product">--}}
                        {{--<select>--}}
                        {{--<option value="">Product Name</option>--}}
                        {{--<option value="">Price</option>--}}
                        {{--</select>--}}
                        {{--<div class="sort-product-icon">--}}
                        {{--<i class="fa fa-sort-alpha-asc"></i>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--@endif--}}
                    </div>
                    <!-- ./ Center colunm -->
                </div>
                <!-- ./row-->
            </div>
        </div>
        <script type="text/javascript" src="{{url('public/main/assets/lib/jquery/jquery-1.11.2.min.js')}}"></script>
        {{--<script type="text/javascript" src="{{url('public/main/assets/lib/jquery.countdown/jquery.countdown.min.js')}}"></script>--}}

        <script>
            $(document).ready(function () {
                basketCountNotify();
                basketTotalPrice();
                basketContent();
            })
        </script>
        <script>
            //below function is related to get basket count
            function basketCountNotify() {
                var token = $('#token').val();
                $.ajax
                ({
                    url: "{{url('user/getBasketCountNotify')}}",
                    type: "get",
                    dataType: "json",
                    data: {'_token': token},
                    success: function (response) {
                        console.log(response);
                        $('#basketCountNotify').text(response);
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });
            }

            //below function is related to get total price
            function basketTotalPrice() {
                var token = $('#token').val();
                $.ajax
                ({
                    url: "{{url('user/getBasketTotalPrice')}}",
                    type: "get",
                    dataType: "json",
                    data: {'_token': token},
                    success: function (response) {
                        console.log(response);
                        $('.total').text(formatNumber(response) + ' ' + 'تومان');
                    },
                    error: function (error) {
                        console.log(error);
                    }

                });
            }

            //below function is related to get basket content
            function basketContent() {
                var token = $('#token').val();
                $.ajax
                ({
                    url: "{{url('user/getBasketContent')}}",
                    type: "get",
                    dataType: "json",
                    data: {'_token': token},
                    success: function (response) {
                        console.log(response.products.length);
                        $('#cartBlockList').empty();
                        var len = response.products.length;
                        var i = 0;
                        while (i < len) {
                            $('#cartBlockList').append
                            (
                                '<ul>' +
                                '<li class="product-info">' +
                                '<div class="p-left">' +
                                '<a href="#" name="' + response.products[i].product_id + '" content="' + response.products[i].basket_id + '" id="removeFromBasket" class="remove_link"></a>' +
                                '</div>' +
                                '<div class="p-right">' +
                                '<p class="p-name">' + response.products[i].title + '</p>' +
                                '<p class="p-rice">' + formatNumber(response.products[i].price) + '</p>' +
                                '<p>' + response.products[i].count + '</p>' +
                                '</div>' +
                                '</li>' +
                                '</ul>'
                            )
                            i++;
                        }

                    },
                    error: function (error) {
                        console.log(error);
                    }

                });
            }
        </script>
        <script>
            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
            }
        </script>

        <!-- below script is related to remove item from basket -->
        <script>
            $(document).on('click', '#removeFromBasket', function () {
                var productId = $(this).attr('name');
                var basketId = $(this).attr('content');
                var token = $('#token').val();
                $.ajax
                ({
                    url: "{{url('user/removeItemFromBasket')}}",
                    type: "post",
                    data: {'productId': productId, 'basketId': basketId, '_token': token},
                    dataType: "json",
                    success: function (response) {
                        if (response.code == 1) {
                            swal({
                                title: "",
                                text: response.message,
                                type: "success",
                                confirmButtonText: "بستن"
                            });
                            basketCountNotify();
                            basketTotalPrice();
                            basketContent();
                        } else {
                            swal({
                                title: "",
                                text: response.message,
                                type: "warning",
                                confirmButtonText: "بستن"
                            });
                        }
                    }

                })
            })
        </script>
@endsection