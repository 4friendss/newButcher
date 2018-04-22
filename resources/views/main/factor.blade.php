<!DOCTYPE html>
<html>
<head>
    <link href="{{ URL::asset('public/dashboard/css/custom-forms.css')}}" rel="stylesheet">
    <title>نمایش و چاپ فاکتور</title>
</head>
<body>
<div style="padding:1% 2.5%">
    <h4 class="text-center">
        بسمه تعالی </h4>
    <h5 class="text-right" style="float: right;direction: rtl;"> فروشگاه :
    </h5>
    <h5 class="text-right" style="float: right;direction: rtl;">نام فروشگاه ما
    </h5>

    <h5 class="text-right" style="float: left;text-align: right;direction: rtl">  تاریخ و ساعت
    </h5>
    <h5 class="text-right" style="float: left;text-align: right;direction: rtl">زمان :
    </h5>
    <h5 class="text-right"></h5>
    <br>
    <br>
    <table class="formTable col-md-12 width100 border-right" dir="rtl">
        <thead>
        <tr class=" padding-formTable">
            <th class="col-md-1">ردیف</th>
            <th class="col-md-1" colspan="3">عنوان محصول</th>
            <th class="col-md-1" colspan="3">توضیحات</th>
            <th class="col-md-1"> قیمت واحد (تومان)</th>
            <th class="col-md-1"> تعداد/مقدار </th>
            <th class="col-md-1">جمع کل (تومان)</th>
            <th class="col-md-1">تخفیف محصول (درصد)</th>
            <th class="col-md-1">هزینه ی پست (تومان)</th>
        </tr>
        </thead>
        <?php $i = 1 ?>
        <tbody>
        @foreach($baskets->products as $basket)
        <tr>
            <td class="col-md-1">{{$i++}}</td>
            <td class="col-md-1" colspan="3">{{$basket->title}}</td>
            <td class="col-md-1" >{{$basket->comments}}</td>
            <td class="col-md-1">{{number_format($basket->price)}}</td>
            <td class="col-md-1">{{$basket->count}}</td>
            <td class="col-md-1">{{number_format($basket->sum)}}</td>
            <td class="col-md-1">@if($basket->discount_volume != null){{$basket->discount_volume}}@endif @if($basket->discount_volume == null) تخفیف ندارد @endif</td>
            <td class="col-md-1">{{number_format($basket->post_price)}}</td>
        </tr>
        @endforeach
        <tr>
            <td class="col-md-2" colspan="8" style="text-align: left"><b> جمع کل قیمت ها (تومان)</b></td>
            <th class="col-md-3" colspan="2">{{number_format($total)}}</th>
        </tr>
        <tr>
            <td class="col-md-2" colspan="8" style="text-align: left"><b> مجموع تخفیف ها (تومان)</b></td>
            <th class="col-md-3" colspan="2">{{number_format($basket->sumOfDiscount)}}</th>
        </tr>
        <tr>
            <td class="col-md-2" colspan="8" style="text-align: left"><b>مجموع هزینه های پست (تومان)</b></td>
            <th class="col-md-3" colspan="2">{{number_format($totalPostPrice)}}</th>
        </tr>
        <tr>
            <td class="col-md-2" colspan="8" style="text-align: left"><b>قیمت نهایی (تومان)</b></td>
            <th class="col-md-3" colspan="2">{{number_format($finalPrice)}}</th>
        </tr>
        </tbody>
    </table>
    <br/>
    <br/>
    <br/>
    <div align="center" class="col-md-8">
        <button id="print" class="selfBtn" >چاپ فاکتور</button>
    </div>
</div>
<script type="text/javascript" src="{{url('public/main/assets/lib/jquery/jquery-1.11.2.min.js')}}"></script>
<script>
    $(document).on('click','#print',function(){

    })
</script>
</body>
</html>