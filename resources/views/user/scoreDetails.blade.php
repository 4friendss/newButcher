@extends('layouts.userLayout')
@section('content')

    <div class="clearfix"></div>
    <div class="x_panel">
        <div style="background-color: red" class="x_content">

            <h4><strong style="float: right; color: white;"> کاربر گرامی در نظر داشته باشید که عملیات امتیاز دهی برای هر
                    محصول فقط یکبار قابل انجام است ، امتیاز باید بین 1 تا 5 وارد شود </strong></h4>
        </div>
    </div>
    <div class="row" dir="rtl">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">

                    <div class="row">

                        <div class="clearfix"></div>

                        @foreach($baskets->products as $product)

                            <div style="float: right;" class="col-md-6 col-sm-6 col-xs-12 animated fadeInDown">
                                <div class="well profile_view">
                                    <div class="col-sm-12 my-score-box">

                                        <div class="left col-xs-7">
                                            <h2 class="brief"><strong>عنوان محصول :</strong> {{$product->title}}  </h2>
                                            <br/>
                                            <h2><strong>قیمت واحد (تومان)
                                                    : </strong> {{number_format($product->product_price)}} </h2>
                                            <br/>
                                            <h2><strong>واحد شمارش : </strong> {{$product->unit_count}} </h2>
                                            {{--<ul class="list-unstyled">--}}
                                            {{--<li><i class="fa fa-phone"></i> Address: </li>--}}
                                            {{--<li><i class="fa fa-phone"></i> Address: </li>--}}

                                            {{--</ul>--}}
                                        </div>
                                        <div class="right col-xs-5 text-center">
                                            @if(!empty($product->productImages[0]))
                                                <img src="{{url('public/dashboard/productFiles/picture/'.$product->productImages[0]->image_src)}}"
                                                     alt="عنوان محصول" class="img-circle img-responsive"/>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12 bottom text-center">
                                        <div class="col-md-4 col-xs-12 col-sm-4 emphasis">
                                            {{--<span style="font-size: 120%;">امتیاز</span>--}}
                                            <p style="margin-top: 3.5%;" title="امتیاز" data-toggle=""
                                               class="product-star">
                                                @if($product->productScore == null ||  $product->productScore == 0 )
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                @endif
                                                @if($product->productScore != null || $product->productScore != 0 )
                                                    @if(filter_var($product->productScore,FILTER_VALIDATE_INT))
                                                        <?php $sub = 5 - $product->productScore ?>
                                                        @while($sub > 0 )
                                                            <i class="fa fa-star-o"></i>
                                                            <?php $sub--; ?>
                                                        @endwhile
                                                        <?php $i = 0;   ?>
                                                        @while($product->productScore > $i)
                                                            <i class="fa fa-star"></i>
                                                            <?php $i++; ?>
                                                        @endwhile
                                                    @endif
                                                    @if(!filter_var($product->productScore,FILTER_VALIDATE_INT))

                                                        <?php $sub = 5 - $product->productScore ?>
                                                        @while($sub-1 > 0 )
                                                            <i class="fa fa-star-o"></i>
                                                            <?php $sub--; ?>
                                                        @endwhile
                                                        <i class="fa fa-star-half-o"></i>
                                                        <?php $array = explode('.', $product->productScore);?>
                                                        @while($array[0] > 0)
                                                            <i class="fa fa-star"></i>
                                                            <?php $array[0]--; ?>
                                                        @endwhile
                                                    @endif
                                                @endif
                                            </p>
                                        </div>
                                        @if($product->scoreFlag == 0 )
                                            <div id="parent" class="col-md-8">
                                                <div class="col-xs-12 col-sm-4 col-md-12">
                                                    <button type="button" content="{{$product->id}}"
                                                            class="btn btn-danger btn-sm addScore"
                                                            style="border-radius: 5px;width: 47%;"><i class="fa fa-star"></i>امتیاز دهی
                                                    </button>
                                                    <input class="input-sm" maxlength="1" style="border-radius: 5px;width: 47%;float: left;" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                    </input>
                                                </div>
                                            </div>
                                        @endif
                                        @if($product->scoreFlag == 1 )

                                            <div class=" col-md-4 col-xs-12 col-sm-6 emphasis">
                                                <button type="button" class="btn btn-default btn-sm col-md-12 "
                                                        style="border-radius: 5px;  "><i class="fa fa-star"></i> امتیاز
                                                    داد ه شده
                                                </button>
                                            </div>
                                        @endif
                                        {{--<input type="hidden" id="totalScore" value="{{$productScore}}">--}}
                                        {{--<input type="hidden" id="count" value="{{$count}}">--}}
                                        <input type="hidden" id="productId" value="{{$product->id}}">
                                        <input type="hidden" id="token" value="{{csrf_token()}}" name="_token">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<script>--}}
    {{--$(function () {--}}
    {{--scoreHandling();--}}
    {{--})--}}
    {{--</script>--}}
    {{--<script>--}}
    {{--function scoreHandling()--}}
    {{--{--}}
    {{--var totalScore = $('#totalScore').val();--}}
    {{--var count = $('#count').val();--}}
    {{--var finalScore = totalScore / count;--}}
    {{--console.log(totalScore);--}}
    {{--//console.log(count);--}}
    {{--if(totalScore == 0)--}}
    {{--{--}}
    {{--$('.product-star').append--}}
    {{--(--}}
    {{--'<a href="#"><span class="fa fa-star-o"></span></a>'+--}}
    {{--'<a href="#"><span class="fa fa-star-o"></span></a>'+--}}
    {{--'<a href="#"><span class="fa fa-star-o"></span></a>'+--}}
    {{--'<a href="#"><span class="fa fa-star-o"></span></a>'+--}}
    {{--'<a href="#"><span class="fa fa-star-o"></span></a>'--}}
    {{--);--}}
    {{--}else--}}
    {{--{--}}

    {{--console.log(finalScore);--}}
    {{--if(finalScore % 1 === 0)--}}
    {{--{--}}
    {{--while(finalScore > 0)--}}
    {{--{--}}
    {{--$('.product-star').append--}}
    {{--(--}}
    {{--'<i class="fa fa-star"></i>'--}}
    {{--);--}}
    {{--finalScore--;--}}
    {{--}--}}
    {{--$('.product-star').append--}}
    {{--(--}}
    {{--'<i class="fa fa-star-o"></i>'--}}
    {{--);--}}
    {{--}--}}
    {{--if(finalScore % 1 !== 0)--}}
    {{--{--}}
    {{--var str = finalScore.toString();--}}
    {{--var finalScoreArray = str.split('');--}}
    {{--var sub = 5 - finalScoreArray[0];--}}
    {{--while(sub-1 > 0)--}}
    {{--{--}}
    {{--$('.product-star').append--}}
    {{--(--}}
    {{--'<i class="fa fa-star-o"></i>'--}}
    {{--);--}}
    {{--sub--;--}}
    {{--}--}}

    {{--$('.product-star').append--}}
    {{--(--}}
    {{--'<i class="fa fa-star-half-o"></i>'--}}
    {{--);--}}
    {{--while(finalScoreArray[0] > 0)--}}
    {{--{--}}
    {{--$('.product-star').append--}}
    {{--(--}}
    {{--'<i class="fa fa-star"></i>'--}}
    {{--);--}}
    {{--finalScoreArray[0]--;--}}
    {{--}--}}

    {{--}--}}
    {{--}--}}
    {{--}--}}
    {{--</script>--}}
    <script>
        $(document).on('click', '.addScore', function () {
            var me = $(this);
            var score = $(this).closest('div').find('input.input-sm').val();
            var productId = $(this).attr('content');
            var token = $('#token').val();
            $.ajax
            ({
                url: "{{url('user/addScore')}}",
                type: "post",
                data: {'productId': productId, 'score': score, '_token': token},
                context: me,
                beforeSend: function () {
                    if (score == '' || score == 0) {
                        $(me).closest('div').find('input.input-sm').focus();
                        $(me).closest('div').find('input.input-sm').focus().css('border-color', 'red');
                        return false;
                    }
                    if(score < 1 || score > 5)
                    {
                        swal
                        ({
                            title: '',
                            text: 'عدد وارد شده برای امتیاز باید بین 1 تا 5 باشد',
                            type: 'warning',
                            confirmButtonText: "بستن"
                        });
                        return false;
                    }
                },
                success: function (response) {
                    if (response.code == 'success') {
                        swal
                        ({
                            title: '',
                            text: response.message,
                            type: 'success',
                            confirmButtonText: "بستن"
                        });
                        setTimeout(function () {
                            window.location.reload(true);
                        }, 3000);
                    } else {
                        swal
                        ({
                            title: '',
                            text: response.message,
                            type: 'warning',
                            confirmButtonText: "بستن"
                        });
                    }
                }, error: function (error) {
                    console.log(error);
                }
            })
        })
    </script>
@endsection
