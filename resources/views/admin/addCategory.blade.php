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
        .myAlertColor{
            background-color: #28a745!important
        }
    </style>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
            <div class="x_panel">
                <div class="x_title">
                    <h2> فرم ایجاد دسته</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                {{-- table --}}
                <div class="col-md-3 col-sm-3 col-xs-12"></div>
                <div class="col-md-12 col-sm-6 col-xs-12 ">
                    <div class="x_content">
                        <form enctype="multipart/form-data" class="form-horizontal form-label-left" id="categoryForm"  method="POST" style="direction: rtl !important;">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <a  class="btn btn-info" onclick="window.location.reload(true)">شروع دوباره</a>
                                <div class="col-md-1 col-sm-1 col-xs-1">
                                    <a id="addInput" class="glyphicon glyphicon-plus btn btn-success" data-toggle="" title=" افزودن زیر دسته" ></a>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-1">
                                    <a id="removeInput" class="glyphicon glyphicon-remove btn btn-danger" data-toggle="" title="حذف زیر دسته" ></a>
                                </div>
                                {{--<label class="control-label col-md-11 col-sm-11 col-xs-11 font-size-s" for="name">  <span--}}
                                            {{--class="required star" title="پر کردن این فیلد الزامی است">نکته:</span>شما حداکثر میتوانید تا سه سطح دسته بندی نمائید و سطح چهارم محصول شما خواهد بود.--}}
                                {{--</label>--}}
                            </div>
                            <div class="ln_solid"></div>
                            <div class="item form-group">
                                <div id="showCategories" style="display: none; !important;">
                                    <div class="col-md-9 col-sm-6 col-xs-9">

                                        <select id="disabledCategories"  class="form-control" name="brands" style="display: none; background-color: lightgray;">

                                        </select>
                                        <br/>
                                        <select id="categories"  class="form-control" name="categories">

                                        </select>
                                        <br/>
                                        <select id="subCategories"  class="form-control" name="subCategories" style="display: none;">

                                        </select>

                                        <br/>
                                        <select id="brands"  class="form-control" name="brands" style="display: none;">

                                        </select>

                                    </div>

                                    <label id="disableOfEachCategory" style="display: none; margin-top: 1%; color: #964b00;" class="control-label col-md-3 col-sm-4 col-xs-3" for="title">غیر فعال های دسته منتخب  :  <span
                                                class="star" title="پر کردن این فیلد الزامی است"></span>
                                    </label>
                                    <label id="totalDisabled" style="display: none; margin-top: 1%; color: #964b00;" class="control-label col-md-3 col-sm-4 col-xs-3" for="title">کل دسته های غیر فعال  :  <span
                                                class="star" title="پر کردن این فیلد الزامی است"></span>
                                    </label>
                                    <label class="control-label col-md-3 col-sm-4 col-xs-3" style="margin-top: 2%;" for="title"> دسته های اصلی  موجود : <span
                                                class="star" title="پر کردن این فیلد الزامی است"></span>
                                    </label>
                                    <label id="existedSub" style="display: none; margin-top: 3%;" class="control-label col-md-3 col-sm-4 col-xs-3" for="title"> زیر دسته های دسته اصلی : <span
                                                class="star" title="پر کردن این فیلد الزامی است"></span>
                                    </label>
                                    <label id="existedBrands" style="display: none; margin-top: 3%;" class="control-label col-md-3 col-sm-4 col-xs-3"  for="title"> زیر دسته های دسته فوق : <span
                                                class="star" title="پر کردن این فیلد الزامی است"></span>
                                    </label>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="item form-group" id="change" style="display:none;!important;">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="form-group">
                                <div class="col-md-12" style="margin-top: 2%;">
                                    <button id="reg" type="button" class="col-md-9 btn btn-primary">ثبت نهایی</button>
                                    <button id="addMainCategory" type="button" class="col-md-9 btn btn-success" style="display: none;">اضافه کردن دسته اصلی جدید</button>
                                    <button id="addSubCategory" type="button" class="col-md-9 btn btn-info" style="display: none;!important;">  اضافه کردن زیر دسته برای دسته اصلی انتخاب شده</button>
                                    <button id="addBrands" type="button" class="col-md-9 btn btn-primary" style="display: none;!important;"> اضافه کردن زیر دسته برای زیر دسته انتخاب شده</button>
                                </div>
                            </div>
                            <input type="hidden" id="mainId" name="mainId" value="">
                            <input type="hidden" id="subId" name="subId" value="">
                        </form>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12"></div>
            </div>
        </div>
        <!-- below script is to append html element to change tag -->
        <script>
            function appendToChange()
            {
                $('#change').append
                (
                    "<div id='child'>"+
                    "<br/><br/>"+
                        "<div class='col-md-4 col-sm-6 col-xs-9'>"+
                        '<input id="file" class="form-control col-md-7 col-xs-12" name="file[]"  type="file">'+
                        "</div>"+
                        "<div class='col-md-5 col-sm-6 col-xs-9'>"+
                        "<input id='category' class='form-control col-md-12 col-xs-12 required' name='category[]' placeholder='' required='required' type='text'>"+
                        "</div>"+
                        "<label class='control-label col-md-3 col-sm-4 col-xs-3' for='name'>عنوان  :"+
                        "<span class='star' title='پر کردن این فیلد الزامی است'>*</span>"+
                        "</label>"+
                    "</div>"
                );
            }

        </script>

        <!-- below script is to handle when we want to add main category or sub category -->
        <script>
            function untimelyAddCategory(title,id) {
                //alert(id);
                if(title == 'سایر')
                {
                    swal
                    ({
                        title: '',
                        text: 'امکان اضافه کردن زیر دسته برای ((سایر)) وجود ندارد',
                        type:'warning',
                        confirmButtonText: "بستن"
                    });
                    $('#subCategories').css('display','none');
                    $('#addSubCategory').css('display','none');
                    $('#addBrands').css('display','none');
                    $('#brands').css('display','none');
                    $('#existedSub').css('display','none');
                    $('#existedBrands').css('display','none');
                    $('#subId').val('');
                    $('#mainId').val('');
                    return;
                }
                swal({
                        title:   " آیا در نظر دارید برای دسته " +"(( "+ title +" ))"+  " زیر دسته انتخاب نمایید؟ ",
                        text: "",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonColor: "	#5cb85c",
                        cancelButtonText: "خیر",
                        confirmButtonText: "آری",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#change').css('display', 'block');
                            $('#showCategories').css('display', 'none');
                            $('#addInput').css('display', 'block');
                            $('#removeInput').css('display', 'block');
                            $('#reg').css('display', 'block');
                            $('#addMainCategory').css('display', 'none');
                            $('#addSubCategory').css('display', 'none');
                            $('#addBrands').css('display', 'none');
                            $('#subCategories').empty();
                            if(id)
                            {
                                //alert(id);
                                //return false;
                                $.ajax
                                ({
                                    url      : "{{url('api/v1/getExistedCategories')}}/"+id,
                                    dataType : 'json',
                                    type     : 'get',
                                    success  : function (result)
                                    {
                                        console.log(result);
                                        var option = '';
                                        if(result != 0)
                                        {
                                            $.each(result,function (key,value) {
                                                $('#existed').empty();
                                                $('#existed').append
                                                (
                                                    "<option style='font-size : 150%;'>زیر دسته های دستهء موجود</option>"
                                                )
                                                $('#existed').append
                                                (
                                                    option += "<option selected='true' disabled='disabled' id='"+value.id+"' name='"+value.depth+"'>"+value.title+"</option>"
                                                );
                                            });
                                        }else if(result == 0)
                                        {
                                            $('#existed').append
                                            (
                                                "<option style='font-size : 150%;'>زیر دسته ای برای این دسته انتخاب نشده است</option>"
                                            )
                                        }

                                    }
                                })
//                                $('#existedDiv').css('display','block');
//                                appendToChange();
                                $('#existedDiv').css('display','block');
                                $('#existed').css('display','block');
                            }


                            $('#change').append
                            (
                                '<div >'+
                                    '<div id="existedDiv" class="col-md-4 col-sm-6 col-xs-9" >' +
                                        '<select id="existed" class="form-control"></select>'+
                                    '</div>'+
                                    '<div id="main" class="col-md-5 col-sm-6 col-xs-9">'+
                                        '<input value="'+title+'" class="form-control col-md-6" disabled  style="text-align: center; font-size: 120%;">'+
                                         '<b>'
                                         +'<lable style="margin-right:-60%;" class="control-label" for="name">عنوان دسته منتخب:</lable>'+
                                          '</b>'+
                                    '</div>'+
                                '</div>'

                            );
                            $('#existedDiv').css('display','block');
                            $('#existed').css('display','block');
                            appendToChange();

                        }else
                        {
                            $('#subCategories').css('display','none');
                            $('#addSubCategory').css('display','none');
                            $('#addBrands').css('display','none');
                            $('#brands').css('display','none');
                            $('#existedSub').css('display','none');
                            $('#existedBrands').css('display','none');
                            $('#subId').val('');
                            $('#mainId').val('');
                        }
                    });
            }
        </script>
        <!-- below script is related to remove input from change  -->  
        <script>
            $(function () {
                $(document).on('click','#removeInput',function () {
                    removeFromChange();
                });
                function removeFromChange() {
                    if ($('#change > #child').length >= 2 )
                    {
                        $('#change > #child').last().remove();
                    };

                }
            });
        </script>
        <!-- below script is related to append input -->
        <script>
            var depth = 0;
            $(document).on('click','#addInput',function(){
                    appendToChange();
            })
            $(document).on('click','#reg',function(){
                var option = '';
                var formData = new FormData ($('#categoryForm')[0]);
                $.ajax
                ({
                    cache       : false,
                    url         : "{{url('admin/addNewCategory')}}",
                    type        : "post",
                    processData : false,
                    contentType : false,
                    dataType    : "json",
                    data        : formData,
                    beforeSend:function () {
                        var counter = 0;
                        $(".required").each(function() {
                            if ($(this).val() == "") {
                                $(this).css("border-color" , "red");
                                counter++;
                            }
                        });
                        if(counter > 0){
                            swal
                            ({
                                title: '',
                                text: 'تعدادی از فیلدهای فرم خالی است.لطفا فیلدها را پر نمایید سپس ثبت نهایی را بزنید',
                                type:'warning',
                                confirmButtonText: "بستن"
                            });
                            return false;
                        }
                    },
                    success     : function(res)
                    {
                        console.log(res);
                        if(res.code == 1)
                        {
                            swal({
                                title: "",
                                text: res.message,
                                type: "success",
                                confirmButtonText: "بستن"
                            });
                        }
                         if(res.code == 0)
                        {
                            swal({
                                title: "",
                                text: res.message,
                                type: "warning",
                                confirmButtonText: "بستن"
                            });
                        }

                        if(res.code == 1)
                        {
                            $.ajax({

                                cache:false,
                                url:"{{url('api/v1/getMainCategories')}}",
                                type:'get',
                                dataType:"json",
                                success:function (response) {
                                    console.log(response);
                                    if(response)
                                    {
                                        $('#showCategories').css('display','block');
                                        $('#reg').css('display','none');

                                        $.each(response,function (key,value) {
                                            var item = $('#categories');
                                            item.empty();
    //
                                                item.append
                                                (
                                                    "<option selected='true' disabled='disabled' style='font-size: 150%;'>برای اضافه کردن زیر دسته ها ، دسته ای را انتخاب کنید</option>"
                                                )

                                            item.append
                                            (
                                                option += "<option id='"+value.id+"' name='"+value.depth+"'>"+value.title+"</option>"
                                            );

                                        });
                                        //depth == 0;
                                        $('#change').css('display','none');
                                        $('#change').empty();
                                        $('#addMainCategory').css('display','block');
                                        $('#addInput').css('display','none');
                                        $('#removeInput').css('display','none');
                                        $('#subCategories').empty();
                                        $('#subCategories').css('display','none');
                                        $('#brands').empty();
                                        $('#brands').css('display','none');
                                        $('#existedSub').css('display','none');
                                        $('#existedBrands').css('display','none');
                                        $('#existedDiv').css('display','none');
                                        $('#existed').empty();
                                    }
                                }
                            })
                        }
                    },error:function(error)
                    {
                        if(error.status === 500)
                        {
                            console.log(error);
                            swal({
                                title: "",
                                text: 'خطایی رخ داده است، با بخش پشتیبانی تماس بگیرید',
                                type: "warning",
                                confirmButtonText: "بستن"
                            });
                        }else if(error.status === 422)
                        {
                            console.log(error);
                        }
                    }
                });
            })
        </script>
        {{--get main categories --}}
        <script>
            $(function () {
                var option = '';
                $.ajax({
                    cache    :false,
                    url      :"{{url('api/v1/getMainCategories')}}",
                    type     :'get',
                    dataType :'json',
                    success  :function (response) {
                        console.log(response);
                        if(response != 0)
                        {
                            $('#showCategories').css('display','block');
                            $('#reg').css('display','none');
                            $('#addMainCategory').css('display','block');
                            $('#addSubCategory').css('display','none');
                            $('#addInput').css('display','none');
                            $('#removeInput').css('display','none');
                            $.each(response,function (key,value) {
                                var item = $('#categories');
                                item.empty();
                                    item.append
                                    (
                                        "<option selected='true' disabled='disabled' style='font-size: 150%;'>برای اضافه کردن زیر دسته ها ، دسته ای را انتخاب کنید</option>"
                                    )
                                item.append
                                (
                                     option +="<option id='"+value.id+"' name='"+value.depth+"' >"+value.title+"</option>"
                                );
                            })
                        }else if(response == 0)
                            {
                                $('#change').append
                                (
                                    '<div class="col-md-9"> ' +
                                        '<input class="form-control" disabled value="شما در حال اضافه کردن دسته های اصلی هستید">'+
                                    '</div>'
                                );
                                appendToChange();
                                $('#change').css('display','block');
                            }
                    }
                })
            })
        </script>
        <!-- below script is related to add main category button  -->
        <script>
            $(function () {
                   $(document).on('click','#addMainCategory',function () {
                   $('#mainId').val('');
                   $('#subId').val('');
                       var option = '';
                       $.ajax
                       ({
                           cache    :false,
                           url      :"{{url('api/v1/getMainCategories')}}",
                           type     :'get',
                           dataType :'json',
                           success  :function (response)
                           {

                               $.each(response,function (key,value) {
                                   var item = $('#categories');
                                   item.empty();

                                   item.append
                                   (
                                       "<option selected='true' disabled='disabled' style='font-size: 150%;'>دسته های موجود</option>"
                                   )


                                   item.append
                                   (
                                       option +="<option selected='true' disabled='disabled' id='"+value.id+"' name='"+value.depth+"' >"+value.title+"</option>"
                                   );
                               })
                               $('#change').empty();
                               $('#change').css('display','block');
                               appendToChange();
                               $('#showCategories').css('display','block');
                               $('#addInput').css('display','block');
                               $('#removeInput').css('display','block');
                               $('#reg').css('display','block');
                               $('#addMainCategory').css('display','none');
                               $('#subCategories').css('display','none');
                               $('#brands').css('display','none');
                               $('#existedBrands').css('display','none');
                               $('#existedSub').css('display','none');
                               $('#addSubCategory').css('display','none');
                               $('#addBrands').css('display','none');
                               $('#existed').css('display','none');
                           }
                    });
                });
            })
        </script>
        <!-- below script is related to add sub category button  -->
        <script>
            $(function () {
                $(document).on('click','#addSubCategory',function () {
                    var mainTitle = '';
                    $('#subId').val('');
                    var id = 0;
                    $("[name = 'categories'] option:selected ").each(function(){
                         mainTitle += $(this).val();
                        id += $(this).attr('id');
                        $('#mainId').val(id);

                    });

                    if(mainTitle == '')
                    {
                        swal({
                            title: "",
                            text: 'لطفا دسته ای را انتخاب نمایید!',
                            type: "warning",
                            confirmButtonText: "بستن"
                        });
                    }else
                        {
                            //alert(mainTitle);

                            untimelyAddCategory(mainTitle,id);
                        }
                })
            })
        </script>
        <!-- below script is related to add brands button -->
        <script>
            $(function () {
                $(document).on('click','#addBrands',function () {
                    var mainTitle = '';
                    var subTitle  = '';
                    var subId     = 0;
                    $("[name = 'categories'] option:selected ").each(function(){
                        mainTitle += $(this).val();
                        $('#mainId').val($(this).attr('id'));
                    });
                    $("[name = 'subCategories'] option:selected ").each(function(){
                        subTitle += $(this).val();
                        $('#subId').val($(this).attr('id'));
                        subId += $(this).attr('id');
                    });
                    if(subTitle == '')
                    {
                        swal({
                            title: "",
                            text: 'لطفا زیر دسته ای را انتخاب کنید!',
                            type: "warning",
                            confirmButtonText: "بستن"
                        });
                    }else
                    {
                        //alert(mainTitle);

                        untimelyAddCategory(subTitle,subId);
                    }
                })
            })
        </script>
        <!-- below script to get sub category -->
        <script>
            $(function () {
                $(document).on('change','#categories',function () {
                    $('#subCategories').css('display','none');
                    $('#existedSub').css('display','none');
                    $('#existedBrands').css('display','none');
                    $('#brands').css('display','none');
                    $('#addBrands').css('display','none');
                    $("[name = 'categories'] option:selected").each(function(){

                        var id = $(this).attr('id');
                        //alert(id);
                        $('#mainId').val(id);
                        var title = $(this).val();
                        var depth = $(this).attr('name');
                        $('#subId').val('');
                        //alert(depth);
                        if(depth != 0)
                        {
                            getDisabledCategories(id);
                            getSubCategory(id);
                        }else
                            {
                                   untimelyAddCategory(title,id);
                            }
                    })
                })
            })
         </script>
         <!-- below script is related to get sub categories -->
         <script>
             function getSubCategory (id) {

                 //   return false;
                 var option="";
                 $.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                     }
                 })
                 $.ajax
                 ({
                     cache :false,
                     url: "{{Url('api/v1/getSubCategories')}}/" + id,
                     dataType: "json",
                     type: "get",
                     contentType : false,
                     success: function (response)
                     {

                         console.log(response);
                         var i = 0;
                         $.each(response, function (key, value) {
                             var item = $('#subCategories');
                             item.empty();
//                                            if(i == 0)
//                                            {
                             item.append
                             (
                                 "<option selected='true' disabled='disabled' style='font-size: 150%;'>لطفا زیر دسته مورد نظر را انتخاب نمایید</option>"
                             )
                             //                            }
                             item.append
                             (

                                 option +="<option id='"+value.id+"' name='"+value.depth+"'>"+value.title+"</option>"

                             );
                         });
                         i++;
                         $('#existedSub').css('display','block');
                         $('#subCategories').css('display','block');
                         $('#addSubCategory').css('display','block');
                     }
                 });
             }
         </script>
         <!-- below script ot get brands -->
         <script>
                $(document).on('change','#subCategories',function () {
                    $("[name = 'subCategories'] option:selected ").each(function () {

                        var id = $(this).attr('id');
                        var depth = $(this).attr('name');
                        var subTitle = $(this).val();
                        $('#subId').val(id);
                        if(depth != 0)
                        {
                            getDisabledCategories(id);
                            getBrands(id);
                            function getBrands (id) {
                                var option="";
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                })
                                $.ajax
                                ({
                                    cache :false,
                                    url: "{{Url('api/v1/getBrands')}}/" + id,
                                    dataType: "json",
                                    type: "get",
                                    success: function (response)
                                    {

                                        console.log(response);
                                        $.each(response, function (key, value) {
                                            var item = $('#brands');
                                            item.empty();
                                            item.append
                                            (
                                                option +="<option id='"+value.id+"' name='"+value.depth+"'>"+value.title+"</option>"

                                            );

                                        });
                                        $('#existedBrands').css('display','block');
                                        $('#brands').css('display','block');
                                        $('#addBrands').css('display','block');
                                    }
                                });
                            }
                        }else
                            {
                               // untimelyAddCategory(subTitle,id);
                                addProduct(subTitle);
                            }
                    })

                })
        </script>
        <script>
            $(document).ready(function () {
                getAllDisabledCategories();
            })
        </script>
        <!--below script is related to get  disabled categories of each category  -->
        <script>
                function getDisabledCategories(id)
                {
                    console.log(id);
                    var option = '';
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    })
                    $.ajax
                    ({
                        cache :false,
                        url: "{{Url('api/v1/getDisabledCategories')}}"+'/'+id,
                        dataType: "json",
                        type: "get",
                        success: function (response)
                        {
                                if(response != 0)
                                {
                                    $.each(response,function (key,value) {
                                        var item = $('#disabledCategories');
                                        item.empty();
                                        //
                                        item.append
                                        (
                                            "<option selected='true' disabled='disabled' style='font-size: 150%;'>قبل از ایجاد دسته ی جدید ، دسته های غیر فعال را بررسی نمائید</option>"
                                        )
                                        item.append
                                        (
                                            option += "<option id='" + value.id + "' name='" + value.depth + "' selected='true' disabled='disabled'>" + value.title + "</option>"
                                        );
                                    })
                                    $('#disabledCategories').css('display','block');
                                    $('#disableOfEachCategory').css('display','block');
                                    $('#totalDisabled').css('display','none');
                                }else
                                    {
                                        $('#disabledCategories').css('display','none');
                                        $('#disableOfEachCategory').css('display','none');
                                    }
                        },error : function(error){
                            console.log(error);
                        }
                    })
                }
        </script>
        <!-- below script is related to get all disabled categories-->
        <script>
            function getAllDisabledCategories()
            {
                var option = '';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax
                ({
                    cache :false,
                    url: "{{Url('api/v1/getAllDisabledCategories')}}",
                    dataType: "json",
                    type: "get",
                    success: function (response)
                    {

                        if(response != 0)
                        {
                            $.each(response,function (key,value) {
                                var item = $('#disabledCategories');
                                item.empty();
                                //
                                item.append
                                (
                                    "<option selected='true' disabled='disabled' style='font-size: 150%;'>قبل از ایجاد دسته ی جدید ، دسته های غیر فعال را بررسی نمائید</option>"
                                )

                                item.append
                                (
                                    option += "<option id='" + value.id + "' name='" + value.depth + "' selected='true' disabled='disabled'>" + value.title + "</option>"
                                );
                            })
                            $('#disabledCategories').css('display','block');
                            $('#totalDisabled').css('display','block');
                        }
                    },error : function(error){
                        console.log(error);
                    }
                })
            }
        </script>

        <script>
            function addProduct(title) {

                swal({
                        title:   " آیا در نظر دارید برای دسته " +"(( "+ title +" ))"+  " محصول درج کنید ؟",
                        text: "",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonColor: "	#5cb85c",
                        cancelButtonText: "خیر",
                        confirmButtonText: "آری",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.href = 'addProduct';
                        }else
                        {
                            $('#subCategories').css('display','none');
                            $('#addSubCategory').css('display','none');
                            $('#addBrands').css('display','none');
                            $('#brands').css('display','none');
                            $('#existedSub').css('display','none');
                            $('#existedBrands').css('display','none');
                            $('#subId').val('');
                            $('#mainId').val('');
                        }
                    });
            }
        </script>
@endsection
