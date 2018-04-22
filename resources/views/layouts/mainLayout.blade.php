<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css"
          href="{{URL::asset('public/main/assets/lib/bootstrap/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{URL::asset('public/main/assets/lib/font-awesome/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/main/assets/lib/select2/css/select2.min.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{URL::asset('public/main/assets/lib/jquery.bxslider/jquery.bxslider.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{URL::asset('public/main/assets/lib/owl.carousel/owl.carousel.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/main/assets/lib/jquery-ui/jquery-ui.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/main/assets/css/animate.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/main/assets/css/reset.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/main/assets/css/style.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/main/assets/css/responsive.css')}}"/>
    <link rel="stylesheet" href="{{URL::asset('public/css/persianDatepicker-default.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/css/sweetalert.css')}}">
    <link href="{{URL::asset('public/css/pnotify.custom.min.css')}}" media="all" rel="stylesheet" type="text/css"/>
    <title>@if(!empty($pageTitle)){{$pageTitle}}@endif</title>
</head>
<body class="home">
@include('layouts.header')

<!-- end header -->
@yield('content')
<!-- Footer -->
<footer id="footer" class="bg-red">
    <div class="container" dir="rtl">
        <!-- introduce-box -->
        <div id="introduce-box" class="row">
            <div class="col-md-4">
                <div id="address-box">
                    <a href="#"><img src="{{URL::asset('public/main/assets/images/logo.png')}}" alt="قصابی برادران"/></a>
                    <div id="address-list">
                        <div class="tit-name">آدرس :</div>
                        <div class="tit-contain">دروازه تهران خ رباط اول بعداز آبشار سنگی مابین کوچه 69 و 71 </div>
                        <div class="tit-name">تلفن 1 :</div>
                        <div class="tit-contain">09130913273</div>
                        <div class="tit-name">تلفن 2 :</div>
                        <div class="tit-contain">09130913293</div>
                        <div class="tit-name">تلفن 3 :</div>
                        <div class="tit-contain text-right">34427230</div>
                    </div>
                </div>
            </div>
            {{--<div class="col-md-3">--}}
            {{--<div class="row">--}}
            {{--<div class="col-sm-12">--}}
            {{--<div class="introduce-title">سوپرگوشت برادران</div>--}}
            {{--<ul id="introduce-company" class="introduce-list">--}}
            {{--<li><a href="{{url('login')}}">ورود</a></li>--}}
            {{--<li><a href="{{url('login')}}">ثبت نام</a></li>--}}
            {{--</ul>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class="col-md-8">
                <div id="contact-box">
                    <iframe height="300" class="col-md-12" src="https://www.google.com/maps/embed?pb=!1m17!1m11!1m3!1d990.0520472200151!2d51.657446639665544!3d32.69856365896699!2m2!1f0!2f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fbc3515eee6f1c1%3A0x99f3cc56135ccddf!2z2KfYqNi02KfYsSDYs9mG2q_bjA!5e1!3m2!1sfa!2s!4v1515906827456" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>

            </div>
        </div><!-- /#introduce-box -->
        <!-- #trademark-text-box -->
        <div id="trademark-text-box" class="row">
        </div><!-- /#trademark-text-box -->
        <div id="footer-menu-box">
            <p class="text-center">کلیه حقوق این سایت متعلق به <a class="text-danger"
                                                                  href="{{URL::asset('http://www.artansoftware.ir/')}}"> گروه
                    برنامه نویسی آرتان</a> می باشد.</p>
        </div><!-- /#footer-menu-box -->
    </div>
</footer>
{{--{{csrf_field()}}--}}
<a href="#" class="scroll_top" title="Scroll to Top" style="display: inline;">Scroll</a>
{{--<input type="hidden" id="token" value="{{csrf_token()}}" name="_token">--}}
<!-- Script-->
<script type="text/javascript" src="{{URL::asset('public/main/assets/lib/jquery/jquery-1.11.2.min.js')}}"></script>
<!-- below script get and load sub menu -->
<script>
    $(document).ready(function () {
        $(".mainMenu").each(function () {
            $(this).mouseover(function () {
                var id = $(this).attr('name');
                var token = $(this).data("token");
                $.ajax({
                    dataType: "json",
                    url: "{{URL::asset('getSubmenu')}}" + '/' + id,
                    cash: false,
                    type: "get",
                    data: {
                        "_method": 'get',
                        "_token": token
                    },
                    success: function (response) {
                        var item = $(".submenu");
                        item.empty();
                        var x = 1;
                        if (response.catImg != null && x == 1) {
                            item.append('<li class="block-container col-md-3 col-xs-12 float-xs-none" style="float: right">' +
                                '<ul class="block">' +
                                '<li class="img_container">' +
                                '<img src="{{URL::asset('public/dashboard/image')}}/' + response.catImg + '" alt="' + response.title + '" title="' + response.title + '" >' +
                                '</li>' +
                                '</ul></li>')
                        }
                        $.each(response.submenu, function (key, value) {
                            if (value.hasProduct == 1) {
                                x = 0;
                                var temp = '<li class="block-container col-md-3 col-xs-12 float-xs-none" style="float: right">' +
                                    '<ul class="block">' +
                                    '<li class="link_container group_header">' +
                                    '<a href="{{URL::asset('showProducts')}}' + "/" + value.id + ' ">' + value.title + '</a>' +
                                    '</li>';
                                {{--$.each(response.submenu, function (key, value) {--}}
                                        {{--temp += '<li class="link_container" id="' + value.id + '">' +--}}
                                        {{--'<a href="{{URL::asset('showProducts')}}' + "/" + value.id + ' ">' + value.title + '</a>' +--}}
                                        {{--'</li>';--}}
                                        {{--});--}}
                                    temp += '</ul>' + '</li>';
                                item.append(temp)
                            }
                        });
                    }
                });//end ajax
                $('.submenu').mouseover(function () {
                    return false;
                });
            });
            $(this).mouseleave(function () {
                var item = $(".mainMenu>ul");
                item.empty();
                //$(".submenu").hide(1);
            })
        })
    });
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    {{--$.ajax({--}}
    {{--dataType: "json",--}}
    {{--url: "{{URL::asset('getSubmenu')}}" + '/' + 15,--}}
    {{--cash: false,--}}
    {{--type: "get",--}}
    {{--data: {--}}
    {{--"_method": 'get',--}}
    {{--},--}}
    {{--success: function (response) {--}}
    {{--var item = $(".m3ySubcategoryList");--}}
    {{--item.empty();--}}
    {{--item.append('');--}}
    {{--$.each(response.submenu, function (key, value) {--}}
    {{--if (value.hasProduct == 1) {--}}
    {{--var temp = '<li><a data-toggle="tab" href="#tab-5">'+value.title+'</a></li>';--}}
    {{--item.append(temp)--}}
    {{--}--}}
    {{--});--}}
    {{--}--}}
    {{--});//end ajax--}}
</script>
<script type="text/javascript" src="{{URL::asset('public/main/assets/lib/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/main/assets/lib/select2/js/select2.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/main/assets/lib/jquery.bxslider/jquery.bxslider.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/main/assets/lib/owl.carousel/owl.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/main/assets/lib/jquery.countdown/jquery.countdown.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/main/assets/js/jquery.actual.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/main/assets/js/theme-script.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/main/assets/lib/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/main/assets/lib/jquery.elevatezoom.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/js/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/js/pnotify.custom.min.js')}}"></script>
<script>
    $(document).ready(function () {
        basketCountNotify();
        basketTotalPrice();
        basketContent();
        // handlePayButton();
    })
</script>
<!-- below script is related to add to basket -->
<script>
    $('.addToBasket').on('click', function () {
        var formOrderOption = new FormData($("#orderOptionForm")[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax
        ({
            url: "{{URL::asset('user/addToBasket')}}",
            type: "POST",
            data: formOrderOption,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if (response.code == 1) {
                    var myStack = {"dir1": "down", "dir2": "right", "push": "top"};
                    new PNotify({
                        title: response.message,
                        text: '',
                        addclass: "stack-custom",
                        type: "info",
                        stack: myStack
                    });
                    basketCountNotify();
                    basketTotalPrice();
                    basketContent();
                } else {
                    var myStack = {"dir1": "down", "dir2": "right", "push": "top"};
                    new PNotify({
//                        title: ' محصول شما به سبد خرید اضافه شد',
                        title: response.message,
                        text: '',
                        addclass: "stack-custom",
                        type: "info",
                        stack: myStack
                    });
                }
            }, error: function (error) {
                alert('خطایی رخ داده است')
            }
        })
    })
</script>
<!-- below script is related to add to basket -->
<script>
    //below function is related to make pay button shown or not shown
    //    function handlePayButton(response)
    //    {
    //        if(response == 0)
    //        {
    //            $('#pay').css('display','none');
    //        }
    //    }
    //below function is related to get basket count
    function basketCountNotify() {
        var token = $('#token').val();
        $.ajax
        ({
            url: "{{URL::asset('user/getBasketCountNotify')}}",
            type: "get",
            dataType: "json",
            data: {'_token': token},
            success: function (response) {
                console.log(response);
                $('#basketCountNotify').text(response.basketCount);
                handlePayButton(response);
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
            url: "{{URL::asset('user/getBasketTotalPrice')}}",
            type: "get",
            dataType: "json",
            data: {'_token': token},
            success: function (response) {
                console.log(response);
                $('.total').text(formatNumber(response) + ' ' + 'تومان');
                $('#orderTotal').text(formatNumber(response) + ' ' + 'تومان');
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
            url: "{{URL::asset('user/getBasketContent')}}",
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
                        '<a name="' + response.products[i].product_id + '" content="' + response.products[i].basket_id + '" id="removeFromBasket" class="fa fa-trash-o color-red"></a>' +
                        '</div>' +
                        '<div class="p-right">' +
                        '<p class="p-name"><span>عنوان : </span><span class="color-black">' + response.products[i].title + '</span></p>' +
                        '<p><span> قیمت واحد : </span><span class="p-rice color-black">' + formatNumber(response.products[i].price) + '</span></p>' +
                        '<p><span>تعداد : </span><span class="color-black">' + response.products[i].count + '</span></p>' +
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
<!--formatNumber -->
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
            url: "{{URL::asset('user/removeItemFromBasket')}}",
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
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 5000);
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
<!-- below script is related to remove basket items inj order page -->
<script>
    $(document).on('click', '#removeItem', function () {
        var price = $(this).attr('data-target');
        var orderTotal = $('#orderTotal').attr('content');
        var productId = $(this).attr('name');
        var basketId = $(this).attr('content');
        var token = $('#token').val();
        var DOM = $('#orderTable');
        var td = $(this);
        $.ajax
        ({
            url: "{{URL::asset('user/removeItemFromBasket')}}",
            type: "post",
            data: {'productId': productId, 'basketId': basketId, '_token': token},
            dataType: "json",
            context: {'DOM': DOM, 'td': td},
            success: function (response) {
                if (response.code == 1) {
                    swal({
                        title: "",
                        text: response.message,
                        type: "success",
                        confirmButtonText: "بستن"
                    });
                    $('#orderTotal').text(formatNumber(orderTotal - price) + 'تومان');
                    $(td).parentsUntil(DOM, 'tr').remove();
                    basketCountNotify();
                    basketTotalPrice();
                    basketContent();
                    if (response.count == 0)
                        window.history.back();
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
    });
</script>
<!-- below script is related to fix or register order -->
<script>
    $(document).on('click', '#orderFixed', function () {
        var token = $('#token').val();
        $.ajax
        ({
            url: "{{URL::asset('user/orderFixed')}}",
            type: "post",
            data: {'_token': token},
            dataType: "json",
            success: function (response) {
                if (response.code == 1) {
                    window.location.href = 'factor';
                }
            }, error: function (error) {
                console.log(error);
            }
        });
    });
</script>
<!-- below script is related to handle addToCount  -->
<script>
    $('.addToCount').each(function () {
        $(this).click(function () {
            var productId = $(this).attr('content');
            var basketId = $(this).attr('name');
            var token = $('#token').val();
            var count = $(this).closest('td').find('input.input-sm').val();
            var unitPrice = $(this).closest('td').prev('td').attr('content');
            var td = $(this);
            $(td).css('pointer-events', 'none');
            $(td).css('color', '#adaaaa');
            $.ajax
            ({
                url: "{{URL::asset('user/addOrSubCount')}}",
                type: "post",
                data: {'_token': token, 'productId': productId, 'basketId': basketId, 'parameter': 'addToCount'},
                dataType: "json",
                context: td,
                success: function (response) {
                    console.log(response);
                    if (response.code == 1) {
                        $(td).closest('td').find('input.input-sm').val(++count);
                        var newCount = $(td).closest('td').find('input.input-sm').val();
                        var sum = unitPrice * newCount;
                        $(td).closest('td').next('td').text(formatNumber(sum) + 'تومان');
                        basketTotalPrice();
                        setTimeout(function () {
                            $(td).css('pointer-events', '');
                            $(td).css('color', '#666');
                        }, 5000);
                    }
                }, error: function (error) {
                    console.log(error);
                }
            });
        })
    })
</script>
<!-- below script is related to handle subFromCount  -->
<script>
    $('.subFromCount').each(function () {
        $(this).click(function () {
            var productId = $(this).attr('content');
            var basketId = $(this).attr('name');
            var token = $('#token').val();
            var count = $(this).closest('td').find('input.input-sm').val();
            var unitPrice = $(this).closest('td').prev('td').attr('content');
            var td = $(this);
            $(td).css('pointer-events', 'none');
            $(td).css('color', '#adaaaa');
            if (count == 1) {
                swal({
                    title: "",
                    text: 'در صورتی که می خواهید کالایی را از سبد خرید حذف کنید می بایست دکمه حذف را بزنید',
                    type: "warning",
                    confirmButtonText: "بستن"
                });
                setTimeout(function () {
                    $(td).css('pointer-events', '');
                }, 5000);
                return false;
            } else {
                $.ajax
                ({
                    url: "{{URL::asset('user/addOrSubCount')}}",
                    type: "post",
                    data: {'_token': token, 'productId': productId, 'basketId': basketId, 'parameter': 'subFromCount'},
                    context: td,
                    dataType: "json",
                    success: function (response) {
                        if (response.code == 1) {
                            $(td).closest('td').find('input.input-sm').val(--count);
                            var newCount = $(td).closest('td').find('input.input-sm').val();
                            var sum = unitPrice * newCount;
                            $(td).closest('td').next('td').text(formatNumber(sum) + 'تومان');
                            basketTotalPrice();
                            setTimeout(function () {
                                $(td).css('pointer-events', '');
                                $(td).css('color', '#666');
                            }, 5000);
                        }
                    }, error: function (error) {
                        console.log(error);
                    }
                });
            }
        })
    })
</script>
<!-- below script is related to add order in data base -->
<script>
    $(document).on('click', '#orderRegistration', function () {
        var formData = $('#orderDetailForm').serialize();
        var userCellphone = $('#userCellphone').val();
        var userCoordination = $('#userCoordination').val();
        $.ajax
        ({
            url: "{{URL::asset('user/orderRegistration')}}",
            type: "post",
            data: formData,
            dataType: 'JSON',
            beforeSend: function () {
                if (userCellphone == '' || userCellphone == null) {
                    $('#userCellphone').focus();
                    $('#userCellphone').css('border-color', 'red');
                    return false;
                }
                if (userCoordination == '' || userCoordination == null) {
                    $('#userCoordination').focus();
                    $('#userCoordination').css('border-color', 'red');
                    return false;
                }
            },
            success: function (response) {
                console.log(response);
                if (response.code == 1) {
                    swal
                    ({
                        title: "",
                        text: response.message + '\n' + response.userPassword,
                        type: "success",
                        confirmButtonText: "بستن"
                    });
                   setTimeout(function () {
                       window.location.href = '../login';
                   }, 5000);
                } else if(response.code == 'error1') {
                    swal
                    ({
                        title: "",
                        text: response.message,
                        type: "info",
                        confirmButtonText: "بستن"
                    });
                }else if(response.code == 'success')
                {
                    swal
                    ({
                        title: "",
                        text: response.message,
                        type: "info",
                        confirmButtonText: "بستن"
                    });
                    setTimeout(function(){window.location.reload(true);},5000);
                }
                else
                    {
                        swal
                        ({
                            title: "",
                            text: response.message,
                            type: "warning",
                            confirmButtonText: "بستن"
                        });
                    }
            },
            error: function (error) {
                if (error.status === 500) {
                    console.log(error);
                    swal
                    ({
                        title: "",
                        text: "خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید",
                        type: "warning",
                        confirmButtonText: "بستن"
                    });
                }
                if (error.status === 422) {
                    var errors = error.responseJSON; //this will get the errors response data.
                    var errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml += value[0] + '\n'; //showing only the first error.
                    });
                    //errorsHtml += errorsHtml;
                    swal({
                        title: "",
                        text: errorsHtml,
                        type: "warning",
                        confirmButtonText: "بستن"
                    });
                }
            }
        });
        $("[name='search_select']").change(function () {
            console.log($(this).val())
            $("#form_search").attr('action', '{{URL::asset('search')}}/' + $(this).val())
        })
    })
</script>
<!-- below script is related to add seen count of product -->
<script>
    $(document).on('click', '#goToDetail', function () {
        var productId = $(this).attr('content');
        var token = $('#token').val();
        $.ajax
        ({
            url: "{{URL::asset('user/addToSeenCount')}}",
            type: "post",
            data: {'productId': productId, '_token': token},
            success: function (response) {
                console.log(response);
            }, error: function (error) {
                console.log(error);
            }
        })
    })
</script>
{{--<script>--}}
    {{--$(document).on('click','#comment',function(){--}}
        {{--var formData = $('#commentForm').serialize();--}}
        {{--$.ajax--}}
        {{--({--}}
            {{--url      : "{{url('user/addCommentForEachProduct')}}",--}}
            {{--type     : "post",--}}
            {{--//dataType : "json",--}}
            {{--data     : formData,--}}
            {{--success  : function()--}}
            {{--{--}}
                {{--console.log('success');--}}
            {{--},error  : function(error)--}}
            {{--{--}}
                {{--console.log(error);--}}
            {{--}--}}
        {{--});--}}
    {{--});--}}
{{--</script>--}}
<script>
    $(document).on('click','#showProductVideo',function(){
       $('#myModal').modal('show');
    });
</script>
<script>
    $(document).on('click','#playVideo',function(){

        var video = document.getElementById('video');
        if(video != null)
        {
            video.play();
            $(this).css('display','none');
            $('#pauseVideo').css('display','block');
        }

    })
    $(document).on('click','#pauseVideo',function(){
        $(this).css('display','none');
        $('#playVideo').css('display','block');
        var video = document.getElementById('video');
        video.pause();
    })
</script>
<script>
    $(document).on('click','#comment',function(){
        var myStack = {"dir1": "down", "dir2": "right", "push": "top"};
        var  jsonObject = [];
        $.each($("input[name='orderOption[]']:checked"),function(){
//            var productId = $(this).attr('content');
            jsonObject.push({"productId" : $(this).attr('content'),"basketId" : $(this).attr('id') , "value" : $(this).val()});
       });
        console.log(jsonObject);
        var jsonStr = JSON.stringify(jsonObject);
        console.log(jsonStr + 'here');
        $.ajax
       ({
           url : "{{url('user/showJson')}}",
           type : "post",
           data : {'jsonStr' : jsonStr},
           dataType : "json",
           beforeSend : function()
           {
               if(jsonStr.length == 2)
               {

                   console.log('خالی');
                   new PNotify({
                       title: 'لطفا جزئیات را انتخاب نمائید و سپس دکمه ثبت جزئیات سفارش را بزنید',
                       text: '',
                       addclass: "stack-custom",
                       type: "info",
                       stack: myStack
                   });
                   return false;
               }
           },
           success : function(response)
           {
               console.log(response);
               if(response.code == 'success')
               {
                   new PNotify({
                       title: response.message,
                       text: '',
                       addclass: "stack-custom",
                       type: "info",
                       stack: myStack
                   });
               }


           },error : function(error)
           {
               console.log(error);
           }
       })
    });
</script>
</body>
</html>