<div id="header" class="header">
    <div class="top-header">
        <div class="container">
            <div class="nav-top-links">
                <a href="#">آدرس:</a>
                <a href="#"> دروازه تهران خ رباط اول بعداز آبشار سنگی مابین کوچه 69 و 71</a>
                <a href="#">تلفن های تماس :</a>
                <a class="first-item" href="#"><img alt="phone" src="{{url('public/main/assets/images/phone.png')}}"/>09130913293 <img alt="phone" src="{{url('public/main/assets/images/phone.png')}}"/> 09130913273 <img alt="phone" src="{{url('public/main/assets/images/phone.png')}}"/> 34427230</a>

            </div>
            <div class="support-link">
                @if(Auth::guest())
                    <a href="{{url('login')}}">ورود / ثبت نام</a>
                @else
                    <a href="{{url('/panel')}}">پنل مدیریت</a>
                    <a href="{{url('logout')}}"> خروج از حساب کاربری </a>
                @endif
            </div>
            {{--<div id="user-info-top" class="user-info pull-right">--}}
                {{--<div class="dropdown">--}}
                    {{--<a class="current-open" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"--}}
                       {{--href="#"><span>حساب من</span></a>--}}
                    {{--<ul class="dropdown-menu mega_dropdown text-right" role="menu">--}}
                        {{--@if(Auth::guest())--}}
                            {{--<li><a href="{{url('login')}}">ورود/ثبت نام</a></li>--}}
                        {{--@else--}}
                            {{--<li><a href="{{url('logout')}}"> خروج </a></li>--}}
                            {{--<li><a href="{{url('/panel')}}">مدیریت</a></li>--}}
                        {{--@endif--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
    <!-- MAIN HEADER -->
    <div class="container main-header">
        <div class="row">
            <div class="col-xs-12 col-sm-3 logo">
                <a href="{{url('/')}}"><img alt="قصابی برادران"
                                            src="{{url('public/main/assets/images/logo.png')}}"/></a>
            </div>
            <div class="col-xs-7 col-sm-7 header-search-box">
                <form class="form-inline" id="search_form" action="{{url('search')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group form-category">
                        {{--<select class="select-category1" name="search_type">--}}
                        {{--<option value="1">جستجو نام محصول</option>--}}
                        {{--<option value="2">جستجو در دسته بندیها</option>--}}
                        {{--</select>--}}
                    </div>
                    <div class="form-group input-serach ">
                        <input type="text" class="text-right" name="search_key"
                               placeholder="...جستجو در عنوان و توضیحات محصول">
                    </div>
                    <button type="submit" id="send_search" class="pull-right btn-search"></button>
                </form>
            </div>
            <div id="cart-block" class="col-xs-5 col-sm-2 shopping-cart-box">
                <a class="cart-link">
                    {{--<span class="title" id="basketCount">سبدخرید شما<span class="">0</span></span>--}}
                    <span id="totalPrice" class="total">0</span>
                    <span id="basketCountNotify" class="notify notify-left">0</span>
                </a>
                <div class="cart-block">
                    <div class="cart-block-content">
                        <h2 align="center" dir="rtl">محتویات سبد خرید</h2>
                        <br/>
                        <div id="cartBlockList" class="cart-block-list">

                        </div>
                        <div class="toal-cart" style="text-align: right;direction: rtl">
                            <span class="pull-right">جمع کل</span>
                            <span class="total"></span>
                        </div>
                        <div class="cart-buttons">
                            <a href="{{url('order/basketDetail')}}" id="pay" class="btn-check-out"
                               style="width: 100%; font-size: 120%;">مشاهده جزئیات سبد خرید</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- END MANIN HEADER -->
    <!--  my main menu -->
    <div class="container">
        <div class="row">
            <div id="nav-top-menu" class="nav-top-menu">
                <div class="container">
                    <div class="row">
                        <div id="main-menu" class="col-sm-12 main-menu">
                            <nav class="navbar navbar-default">
                                <div class="container-fluid">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                                data-target="#navbar"
                                                aria-expanded="false" aria-controls="navbar">
                                            <i class="fa fa-bars"></i>
                                        </button>
                                        <a class="navbar-brand" href="#">منوی اصلی</a>
                                    </div>
                                    <div id="navbar" class="navbar-collapse collapse">
                                        <ul class="nav navbar-nav">
                                            <li class="active"><a href="{{url('/')}}">صفحه ی اصلی</a></li>
                                            @foreach($menu as $mnu)
                                                @if($mnu->hasProduct)
                                                    <li class="dropdown mainMenu" name="{{$mnu->id}}">
                                                        <a class="dropdown-toggle"
                                                           data-toggle="dropdown">{{$mnu->title}}</a>
                                                        <ul class="dropdown-menu mega_dropdown submenu" role="menu"
                                                            style="width: 830px;">

                                                        </ul>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div><!--/.nav-collapse -->
                                </div>
                            </nav>
                        </div>
                        {{--<!-- دسته بندی ها--->--}}
                        {{--<div class="col-sm-3" id="box-vertical-megamenus">--}}
                        {{--<div class="box-vertical-megamenus">--}}
                        {{--<h4 class="title">--}}
                        {{--<span class="btn-open-mobile pull-left home-page"><i class="fa fa-bars"></i></span>--}}
                        {{--<span class="title-menu pull-right">دسته بندی ها</span>--}}
                        {{--</h4>--}}
                        {{--<div class="vertical-menu-content is-home">--}}
                        {{--<ul class="vertical-menu-list">--}}
                        {{--<li><a href="#">Electronics<img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/1.png"></a></li>--}}
                        {{--<li>--}}
                        {{--<a class="parent" href="#">Sports &amp; Outdoors<img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/2.png"></a>--}}
                        {{--<div class="vertical-dropdown-menu">--}}
                        {{--<div class="vertical-groups col-sm-12">--}}
                        {{--<div class="mega-group col-sm-4">--}}
                        {{--<h4 class="mega-group-header"><span>Tennis</span></h4>--}}
                        {{--<ul class="group-link-default">--}}
                        {{--<li><a href="#">Tennis</a></li>--}}
                        {{--<li><a href="#">Coats &amp; Jackets</a></li>--}}
                        {{--<li><a href="#">Blouses &amp; Shirts</a></li>--}}
                        {{--<li><a href="#">Tops &amp; Tees</a></li>--}}
                        {{--<li><a href="#">Hoodies &amp; Sweatshirts</a></li>--}}
                        {{--<li><a href="#">Intimates</a></li>--}}
                        {{--</ul>--}}
                        {{--</div>--}}
                        {{--<div class="mega-group col-sm-4">--}}
                        {{--<h4 class="mega-group-header"><span>Swimming</span></h4>--}}
                        {{--<ul class="group-link-default">--}}
                        {{--<li><a href="#">Dresses</a></li>--}}
                        {{--<li><a href="#">Coats &amp; Jackets</a></li>--}}
                        {{--<li><a href="#">Blouses &amp; Shirts</a></li>--}}
                        {{--<li><a href="#">Tops &amp; Tees</a></li>--}}
                        {{--<li><a href="#">Hoodies &amp; Sweatshirts</a></li>--}}
                        {{--<li><a href="#">Intimates</a></li>--}}
                        {{--</ul>--}}
                        {{--</div>--}}
                        {{--<div class="mega-group col-sm-4">--}}
                        {{--<h4 class="mega-group-header"><span>Shoes</span></h4>--}}
                        {{--<ul class="group-link-default">--}}
                        {{--<li><a href="#">Dresses</a></li>--}}
                        {{--<li><a href="#">Coats &amp; Jackets</a></li>--}}
                        {{--<li><a href="#">Blouses &amp; Shirts</a></li>--}}
                        {{--<li><a href="#">Tops &amp; Tees</a></li>--}}
                        {{--<li><a href="#">Hoodies &amp; Sweatshirts</a></li>--}}
                        {{--<li><a href="#">Intimates</a></li>--}}
                        {{--</ul>--}}
                        {{--</div>--}}
                        {{--<div class="mega-custom-html col-sm-12">--}}
                        {{--<a href="#"><img  src="public/main/assets/data/banner-megamenu.jpg" alt="Banner"></a>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</li>--}}
                        {{--<li><a href="#"><img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/3.png">Smartphone &amp; Tablets</a></li>--}}
                        {{--<li><a href="#"><img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/4.png">Health &amp; Beauty Bags</a></li>--}}
                        {{--<li>--}}
                        {{--<a class="parent" href="#">--}}
                        {{--<img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/5.png">Shoes &amp; Accessories</a>--}}
                        {{--<div class="vertical-dropdown-menu">--}}
                        {{--<div class="vertical-groups col-sm-12">--}}
                        {{--<div class="mega-group col-sm-12">--}}
                        {{--<h4 class="mega-group-header"><span>Special products</span></h4>--}}
                        {{--<div class="row mega-products">--}}
                        {{--<div class="col-sm-3 mega-product">--}}
                        {{--<div class="product-avatar">--}}
                        {{--<a href="#"><img  src="public/main/assets/data/p10.jpg" alt="product1"></a>--}}
                        {{--</div>--}}
                        {{--<div class="product-name">--}}
                        {{--<a href="#">Fashion hand bag</a>--}}
                        {{--</div>--}}
                        {{--<div class="product-price">--}}
                        {{--<div class="new-price">$38</div>--}}
                        {{--<div class="old-price">$45</div>--}}
                        {{--</div>--}}
                        {{--<div class="product-star">--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star-half-o"></i>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-3 mega-product">--}}
                        {{--<div class="product-avatar">--}}
                        {{--<a href="#"><img  src="public/main/assets/data/p11.jpg" alt="product1"></a>--}}
                        {{--</div>--}}
                        {{--<div class="product-name">--}}
                        {{--<a href="#">Fashion hand bag</a>--}}
                        {{--</div>--}}
                        {{--<div class="product-price">--}}
                        {{--<div class="new-price">$38</div>--}}
                        {{--<div class="old-price">$45</div>--}}
                        {{--</div>--}}
                        {{--<div class="product-star">--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star-half-o"></i>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-3 mega-product">--}}
                        {{--<div class="product-avatar">--}}
                        {{--<a href="#"><img  src="public/main/assets/data/p12.jpg" alt="product1"></a>--}}
                        {{--</div>--}}
                        {{--<div class="product-name">--}}
                        {{--<a href="#">Fashion hand bag</a>--}}
                        {{--</div>--}}
                        {{--<div class="product-price">--}}
                        {{--<div class="new-price">$38</div>--}}
                        {{--<div class="old-price">$45</div>--}}
                        {{--</div>--}}
                        {{--<div class="product-star">--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star-half-o"></i>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-3 mega-product">--}}
                        {{--<div class="product-avatar">--}}
                        {{--<a href="#"><img  src="public/main/assets/data/p13.jpg" alt="product1"></a>--}}
                        {{--</div>--}}
                        {{--<div class="product-name">--}}
                        {{--<a href="#">Fashion hand bag</a>--}}
                        {{--</div>--}}
                        {{--<div class="product-price">--}}
                        {{--<div class="new-price">$38</div>--}}
                        {{--<div class="old-price">$45</div>--}}
                        {{--</div>--}}
                        {{--<div class="product-star">--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star"></i>--}}
                        {{--<i class="fa fa-star-half-o"></i>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</li>--}}
                        {{--<li><a href="#"><img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/6.png">Toys &amp; Hobbies</a></li>--}}
                        {{--<li><a href="#"><img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/7.png">Computers &amp; Networking</a></li>--}}
                        {{--<li><a href="#"><img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/8.png">Laptops &amp; Accessories</a></li>--}}
                        {{--<li><a href="#"><img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/9.png">Jewelry &amp; Watches</a></li>--}}
                        {{--<li><a href="#"><img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/10.png">Flashlights &amp; Lamps</a></li>--}}
                        {{--<li>--}}
                        {{--<a href="#">--}}
                        {{--<img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/11.png">--}}
                        {{--Cameras &amp; Photo--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="cat-link-orther">--}}
                        {{--<a href="#">--}}
                        {{--<img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/5.png">--}}
                        {{--Television--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="cat-link-orther">--}}
                        {{--<a href="#">--}}
                        {{--<img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/7.png">Computers &amp; Networking--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="cat-link-orther">--}}
                        {{--<a href="#">--}}
                        {{--<img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/6.png">--}}
                        {{--Toys &amp; Hobbies--}}
                        {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="cat-link-orther">--}}
                        {{--<a href="#"><img class="icon-menu" alt="Funky roots"  src="public/main/assets/data/9.png">Jewelry &amp; Watches</a></li>--}}
                        {{--</ul>--}}
                        {{--<div class="all-category"><span class="open-cate">All Categories</span></div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    <!-- userinfo on top-->
                    <div id="form-search-opntop">
                    </div>
                    <!-- userinfo on top-->
                    <div id="user-info-opntop">
                    </div>
                    <!-- CART ICON ON MMENU -->
                    <div id="shopping-cart-box-ontop">
                        <i class="fa fa-shopping-cart"></i>
                        <div class="shopping-cart-box-ontop-content"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
