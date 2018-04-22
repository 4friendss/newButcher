<div id="view-product-list" class="view-product-list">
<ul class="row product-list  grid">
    @foreach($products as $product)
        @if($product->active == 1)
            <li class="col-sx-12 col-md-3">
                <div class="product-container">
                    <div class="left-block">
                        {{--<a>--}}
                            @if(!empty($product->productImages[0]))
                                <img src="{{url('public/dashboard/productFiles/picture/'.$product->productImages[0]->image_src)}}"
                                     alt="عنوان محصول" height="250" style="text-decoration: underline;"/>
                            @endif
                        {{--</a>--}}
                        <div class="quick-view">
                            <a title="افزودن به علاقه مندی ها" class="heart"></a>
                            <a title="مقایسه" class="compare"></a>
                            <a title="نمایش جزئیات" class="search" id="goToDetail" content="{{$product->id}}"
                               href="{{url('productDetail/'.$product->id)}}"></a>
                        </div>
                        <div class="add-to-cart">
                            <a href="{{url('productDetail/'.$product->id)}}">نمایش جزئیات</a>
                        </div>
                        @foreach($product->productFlags as $flag)
                                @if($flag->active == 1)
                                <div class="group-price">
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
                                </div>
                            @endif
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
                                @foreach($product->productFlags as $flag)
                                    <div class="col-md-6">
                                        @if($flag->active == 1)
                                            <b><a class="price" id="productFlag" data-toggle="" name="{{$flag->price}}"
                                                  title="تومان"> &nbsp;{{number_format($flag->price)}}&nbsp; </a>
                                            </b>&nbsp;<b style="float: left"> تومان </b> &nbsp;
                                        @endif

                                    </div>
                                    <div class=" col-md-6">
                                    <span class="price product-price pull-right" dir="rtl">
                                        @if($flag->active == 1)
                                            @if($flag->title == "price")قیمت({{$product->unit_count }})
                                            @endif
                                    </span>
                                        @endif
                                    </div>
                                @endforeach
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
                                    <span class="price product-price">  امتیاز  </span>
                                </div>
                            </div>
                        </div>
                        {{--<input type="hidden" class="score" value="{{$product->scores[0]->score}}">--}}
                        {{--<input type="hidden" id="count" value="{{$count}}">--}}
                    </div>
                </div>
            </li>
        @endif
    @endforeach

</ul>
</div>
{!! $products->render() !!}
