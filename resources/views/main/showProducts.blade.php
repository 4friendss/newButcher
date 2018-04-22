@extends('layouts.mainLayout')
@section('content')
    <div class="columns-container">
        <div class="container" id="columns">
            <!-- breadcrumb -->
            <div class="breadcrumb clearfix">
                <a class="home" href="#" title="Return to Home">خانه</a>
                <span class="navigation-pipe">&nbsp;</span>
                <span class="navigation_page">{{$parentCat}}</span>
                <span class="navigation-pipe">&nbsp;</span>
                <span class="navigation_page">{{$categories->title}}</span>
            </div>
            <!-- ./breadcrumb -->
            <!-- row -->
            <div class="row">
                <!-- Center colunm-->
                <div class="center_column col-xs-12 col-sm-12" id="center_column">
                    <!-- category-slider -->
                    <div class="category-slider">
                        <ul class="owl-carousel owl-style2" data-dots="false" data-loop="true" data-nav = "true" data-autoplayTimeout="1000" data-autoplayHoverPause = "true" data-items="1">
                            <li>
                                <img height="400" src="{{url('public/dashboard/image') ."/" .$image}}" alt="category-slider">
                            </li>
                            <li>
                                <img height="400" src="{{url('public/dashboard/image') ."/" .$image}}" alt="category-slider">
                            </li>
                        </ul>
                    </div>
                    <!-- ./category-slider -->

                    <!-- category short-description -->
                    <div class="cat-short-desc">
                        <div class="desc-text text-right">
                            <h4>
                                . فروشگاه ما سعی دارد در خدمت رسانی به شما مشتریان گرامی در مسیری نو گام بردارد
                            </h4>
                        </div>
                    </div>
                    <!-- ./category short-description -->
                    <!-- view-product-list-->
                    <div id="view-product-list" class="view-product-list">
                        <h2 class="page-heading">
                            <span class="page-heading-title">محصولات دسته   :   {{$categories->title}}</span>
                        </h2>
                        <ul class="display-product-option">
                            {{--<li class="view-as-grid selected">--}}
                            {{--<span>grid</span>--}}
                            {{--</li>--}}
                            {{--<li class="view-as-list">--}}
                            {{--<span>list</span>--}}
                            {{--</li>--}}
                        </ul>

                            <!-- load product list in this category by ajax with pagination -->
                            @include('main.presult')
                        <!-- ./PRODUCT LIST -->
                        </div>
                    </div>
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
            scoreHandling();
        })
    </script>
    <script>
        //below function is related to get basket count
        function basketCountNotify()
        {
            var token = $('#token').val();
            $.ajax
            ({
                url         : "{{url('user/getBasketCountNotify')}}",
                type        : "get",
                dataType    : "json",
                data        : {'_token' : token},
                success     : function(response)

                {
                    console.log(response);
                    $('#basketCountNotify').text(response);
                },
                error       : function (error) {
                    console.log(error);
                }

            });
        }

        //below function is related to get total price
        function basketTotalPrice()
        {
            var token = $('#token').val();
            $.ajax
            ({
                url         : "{{url('user/getBasketTotalPrice')}}",
                type        : "get",
                dataType    : "json",
                data        : {'_token' : token},
                success     : function(response)

                {
                    console.log(response);
                    $('.total').text(formatNumber(response) + ' ' + 'تومان'  );
                },
                error       : function (error) {
                    console.log(error);
                }

            });
        }

        //below function is related to get basket content
        function basketContent()
        {
            var token = $('#token').val();
            $.ajax
            ({
                url         : "{{url('user/getBasketContent')}}",
                type        : "get",
                dataType    : "json",
                data        : {'_token' : token},
                success     : function(response)

                {
                    console.log(response.products.length);
                    $('#cartBlockList').empty();
                    var len = response.products.length;
                    var i   = 0;
                    while(i < len )
                    {
                        $('#cartBlockList').append
                        (
                            '<ul>'+
                            '<li class="product-info">'+
                            '<div class="p-left">'+
                            '<a href="#" name="'+response.products[i].product_id+'" content="'+response.products[i].basket_id+'" id="removeFromBasket" class="remove_link"></a>'+
                            '</div>'+
                            '<div class="p-right">'+
                            '<p class="p-name">'+response.products[i].title+'</p>'+
                            '<p class="p-rice">'+formatNumber(response.products[i].price)+'</p>'+
                            '<p>'+response.products[i].count+'</p>'+
                            '</div>'+
                            '</li>'+
                            '</ul>'
                        )
                        i++;
                    }

                },
                error       : function (error) {
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
        $(document).on('click','#removeFromBasket',function(){
            var productId = $(this).attr('name');
            var basketId  = $(this).attr('content');
            var token     = $('#token').val();
            $.ajax
            ({
                url      : "{{url('user/removeItemFromBasket')}}",
                type     : "post",
                data     : {'productId' : productId , 'basketId' : basketId , '_token' : token},
                dataType : "json",
                success   : function(response)
                {
                    if(response.code == 1)
                    {
                        swal({
                            title: "",
                            text: response.message,
                            type: "success",
                            confirmButtonText: "بستن"
                        });
                        basketCountNotify();
                        basketTotalPrice();
                        basketContent();
                    }else
                    {
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

    {{--pagination--}}
    <script>
        $(window).on('hashchange', function() {
            if (!window.location.hash) {
                var page = window.location.hash.replace('#', '');
console.log('fdf');
                if (page == Number.NaN || page <= 0) {
                    return false;
                }else{
                    getData(page);
                }
            }
        });
        $(document).ready(function()
        {
            $(document).on('click', '.pagination a',function(event)
            {
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                event.preventDefault();
                var myurl = $(this).attr('href');
                var page=$(this).attr('href').split('page=')[1];
                getData(page);
            });
        });
        function getData(page){
            $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    datatype: "html",
                    // beforeSend: function()
                    // {
                    //     you can show your loader
                    // }
                })
                .done(function(data)
                {
                    console.log(data);

                    $("#product-container").empty().html(data);
                    location.hash = page;
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                    alert('No response from server');
                });
        }
    </script>
    {{--<script>--}}
        {{--function scoreHandling()--}}
        {{--{--}}
            {{--$('.score').each(function () {--}}

                {{--var parent = $(this).parentsUntil('#parent').attr('content');--}}
                {{--alert(parent);--}}
                {{--return;--}}
                {{--var totalScore = $(this).val();--}}
                {{--//    var count = $('#count').val();--}}
                {{--//  var finalScore = totalScore / count;--}}
                {{--if(totalScore == 0)--}}
                {{--{--}}
                    {{--$('.product-star').append--}}
                    {{--(--}}
                        {{--'<i class="fa fa-star-o"></i>'+--}}
                        {{--'<i class="fa fa-star-o"></i>'+--}}
                        {{--'<i class="fa fa-star-o"></i>'+--}}
                        {{--'<i class="fa fa-star-o"></i>'+--}}
                        {{--'<i class="fa fa-star-o"></i>'--}}
                    {{--);--}}
                {{--}else--}}
                {{--{--}}

                    {{--if(totalScore % 1 === 0)--}}
                    {{--{--}}
                        {{--while(totalScore > 0)--}}
                        {{--{--}}
                            {{--$('.product-star').append--}}
                            {{--(--}}
                                {{--'<i class="fa fa-star"></i>'--}}
                            {{--);--}}
                            {{--totalScore--;--}}
                        {{--}--}}
                        {{--$('.product-star').append--}}
                        {{--(--}}
                            {{--'<i class="fa fa-star-o"></i>'--}}
                        {{--);--}}
                    {{--}--}}
                    {{--if(totalScore % 1 !== 0)--}}
                    {{--{--}}
                        {{--var str = totalScore.toString();--}}
                        {{--var finalScoreArray = str.split('');--}}
                        {{--var sub = 5 - finalScoreArray[0];--}}
                        {{--while(finalScoreArray[0] > 0)--}}
                        {{--{--}}
                            {{--$('.product-star').append--}}
                            {{--(--}}
                                {{--'<i class="fa fa-star"></i>'--}}
                            {{--);--}}
                            {{--finalScoreArray[0]--;--}}
                        {{--}--}}
                        {{--$('.product-star').append--}}
                        {{--(--}}
                            {{--'<i class="fa fa-star-half-o"></i>'--}}
                        {{--);--}}
                        {{--while(sub-1 > 0)--}}
                        {{--{--}}
                            {{--$('.product-star').append--}}
                            {{--(--}}
                                {{--'<i class="fa fa-star-o"></i>'--}}
                            {{--);--}}
                            {{--sub--;--}}
                        {{--}--}}

                    {{--}--}}
                {{--}--}}
            {{--})--}}
        {{--}--}}
    {{--</script>--}}
@endsection