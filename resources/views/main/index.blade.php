@extends('layouts.mainLayout')
@section('content')
    <!-- Home slideder-->
    <div id="home-slider">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 header-top-right">
                    <div class="homeslider">
                        <div class="content-slide">
                            <ul id="contenhomeslider">
                                <li><img alt="قصابی برادران" class="height-slider"
                                         src="{{url('public/main/assets/slider/1.jpg')}}" title="قصابی برادران"/>
                                </li>
                                <li><img alt="قصابی برادران" class="height-slider"
                                         src="{{url('public/main/assets/slider/3.jpg')}}" title="قصابی برادران"/>
                                </li>
                                <li><img alt="قصابی برادران" class="height-slider"
                                         src="{{url('public/main/assets/slider/4.jpg')}}" title="قصابی برادران"/>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-banner banner-opacity" style="display: none;">
                    <a href="#"><img alt="Funky roots" src="public/main/assets/data/ads1.jpg"/></a>
                    </div>
                </div>
                <div class="col-sm-3 slider-left"></div>
            </div>
        </div>
    </div>
    <!-- END Home slideder-->
    <!-- servives -->
    <div class="container service-parent-div-class">
        <div class="row">
            <div class="service text-right">
                <div class="col-xs-4 col-md-4 col-sm-4  service-item">
                    <div class="icon">
                        <i class="fa fa-clock-o fa-4x"></i>
                    </div>
                    <div class="info">
                        <a href="#"><h3>ساعات خدمت رسانی</h3></a>
                        <span>همه روزه از 9 صبح تا 9 شب به جز ایام تعطیل </span>
                    </div>
                </div>
                <div class="col-xs-4 col-md-4 col-sm-4 service-item">
                    <div class="icon">
                        <i class="fa fa-truck fa-4x"></i>
                    </div>
                    <div class="info">
                        <a href="#"><h3>تحویل درمحل مورد نظر شما</h3></a>
                        <span>سفارشات مورد نظر شما در اسرع وقت، در مکان مورد نظر شما تحویل داده می شود </span>
                    </div>
                </div>
                <div class="col-xs-4 col-md-4 col-sm-4 service-item">
                    <div class="icon">
                        <i class="fa fa-check-square fa-4x"></i>
                    </div>
                    <div class="info">
                        <a href="#"><h3>محصولات درجه یک</h3></a>
                        <span>محصولات مرغوب و تازه و با کیفیت را از ما بخواهید.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end services -->
    <div class="content-page">
        <div class="container">
            <!-- featured category fashion -->
            <?php $count = 1;$subCatCounts=1;?>
            @foreach($menu as $mnu)
                @if($mnu->hasProduct)
                    <div class="category-featured myCategories">
                        <nav class="navbar nav-menu nav-menu-red show-brand">
                            <div class="container">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-brand"><a href="#"><img alt="{{$mnu->title}}"
                                                                           src="public/main/assets/data/fashion.png"/>{{$mnu->title}}
                                    </a>
                                </div>
                                <span class="toggle-menu"></span>
                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse">
                                    <ul class="nav navbar-nav mySubcategoryList">
                                        {{--<li class="active"><a data-toggle="tab" href="#tab-1">همه ی محصولات</a></li>--}}
                                        <?php $j = $subCatCounts;?>
                                        @foreach($mnu->submenu as $submenu)
                                            @if($j==$subCatCounts)
                                                <li class="active"><a data-toggle="tab"
                                                                      href="#tab-{{$j++}}">{{$submenu->title}}</a></li>
                                            @else
                                                <li><a data-toggle="tab" href="#tab-{{$j++}}">{{$submenu->title}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div><!-- /.navbar-collapse -->
                            </div><!-- /.container-fluid -->
                            <div id="elevator-{{$count}}" class="floor-elevator">
                                <a href="#elevator-{{$count-1}}" class="btn-elevator up fa fa-angle-up"></a>
                                <a href="#elevator-{{++$count}}" class="btn-elevator down fa fa-angle-down"></a>
                            </div>
                        </nav>
                        <div class="category-banner">
                            {{--<div class="col-sm-6 banner">--}}
                            {{--<a href="#"><img alt="ads2" class="img-responsive" src="public/main/assets/data/ads2.jpg"/></a>--}}
                            {{--</div>--}}
                            {{--<div class="col-sm-6 banner">--}}
                            {{--<a href="#"><img alt="ads2" class="img-responsive" src="public/main/assets/data/ads3.jpg"/></a>--}}
                            {{--</div>--}}
                        </div>
                        <div class="product-featured clearfix">
                            <div class="banner-featured">
                                <div class="featured-text1"><span></span></div>
                                <div class="banner-img">
                                    <a href="#"><img alt="{{$mnu->title}}"
                                                     src="{{url('public/dashboard/image/'.$mnu->image_src)}}"/></a>
                                </div>
                            </div>
                            <div class="product-featured-content">
                                <div class="product-featured-list">
                                    <div class="tab-container">
                                        <?php $j = $subCatCounts;?>
                                        @foreach($mnu->submenu as $submenu)
                                            <div class="tab-panel @if($j==$subCatCounts) active @endif"
                                                 id="tab-{{$j++}}" >
                                                <ul class="product-list owl-carousel" data-dots="false" data-loop="true"
                                                    data-nav="true" data-margin="0" data-autoplayTimeout="1000"
                                                    data-autoplayHoverPause="true"
                                                    data-responsive='{"0":{"items":1},"600":{"items":3},"1000":{"items":4}}'>
                                                    @foreach($submenu->products as $product)
                                                        {{--                                            {{dd($product)}}--}}
                                                        <li>
                                                            <div class="left-block">
                                                                <a href="#">
                                                                    @if(!empty($product->productImages[0]))
                                                                        <img src="{{url('public/dashboard/productFiles/picture/'.$product->productImages[0]->image_src)}}"
                                                                             alt="عنوان محصول" width="200" height="250"
                                                                             style="text-decoration: underline;"/>
                                                                    @endif
                                                                </a>
                                                                <div class="quick-view">
                                                                    <a title="افزودن به علاقه مندی ها"
                                                                       class="heart"></a>
                                                                    <a title="مقایسه" class="compare"></a>
                                                                    <a title="نمایش جزئیات" class="search"
                                                                       id="goToDetail" content="{{$product->id}}"
                                                                       href="{{url('productDetail/'.$product->id)}}"></a>
                                                                </div>
                                                                <div class="add-to-cart">
                                                                    <a href="{{url('productDetail/'.$product->id)}}">نمایش
                                                                        جزئیات</a>
                                                                </div>
                                                            </div>
                                                            <div class="right-block">
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
                                                                        <div class="col-md-6 padding-r-l-0">
                                                                            @foreach($product->productFlags as $flag)
                                                                                @if($flag->active == 1)
                                                                                    <b><a class="price" id="productFlag"
                                                                                          data-toggle=""
                                                                                          name="{{$flag->price}}"
                                                                                          title="تومان">
                                                                                            &nbsp{{number_format($flag->price)}}
                                                                                            &nbsp</a>
                                                                                    </b>
                                                                                    <b style="float: left">تومان </b>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                        <div class=" col-md-6 padding-r-l-0">
                                                                            <span class="price product-price pull-right  text-right"> : قیمت اصلی </span>
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
                                                                            <span class="price product-price">  :امتیاز  </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{--<input type="hidden" class="score" value="{{$product->scores[0]->score}}">--}}
                                                                {{--<input type="hidden" id="count" value="{{$count}}">--}}
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                        <?php $j = 0; $subCatCounts+=count($mnu->submenu);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end featured category fashion -->
                @endif
            @endforeach
        </div>
    </div>

@endsection
