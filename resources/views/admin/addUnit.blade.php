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
                    <h2> فرم ایجاد واحدها</h2>
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
                        <form  class="form-horizontal form-label-left" id="unitForm"  method="POST" style="direction: rtl !important;">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <a  class="btn btn-info" onclick="window.location.reload(true)">شروع دوباره</a>
                                <div class="col-md-1 col-sm-1 col-xs-1">
                                    <a id="addInput" class="glyphicon glyphicon-plus btn btn-success" data-toggle="" title=" افزودن فیلد" ></a>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-1">
                                    <a id="removeInput" class="glyphicon glyphicon-remove btn btn-danger" data-toggle="" title="حذف فیلد" ></a>
                                </div>
                                {{--<label class="control-label col-md-11 col-sm-11 col-xs-11 font-size-s" for="name">  <span--}}
                                {{--class="required star" title="پر کردن این فیلد الزامی است">نکته:</span>شما حداکثر میتوانید تا سه سطح دسته بندی نمائید و سطح چهارم محصول شما خواهد بود.--}}
                                {{--</label>--}}
                            </div>
                            <div class="ln_solid"></div>
                            <div class="item form-group">
                                <div id="showUnits" style="display: none; !important;">
                                    <div class="col-md-9 col-sm-6 col-xs-9">
                                        <select id="units"  class="form-control" name="units">

                                        </select>
                                        <br/>
                                        <select id="subUnits"  class="form-control" name="subUnits" style="display: none;">

                                        </select>



                                    </div>
                                    <label class="control-label col-md-3 col-sm-4 col-xs-3" for="title"> واحدهای موجود : <span
                                                class="star" title="پر کردن این فیلد الزامی است"></span>
                                    </label>
                                    <label id="existedSub" style="display: none; margin-top: 3%;" class="control-label col-md-3 col-sm-4 col-xs-3" for="title"> زیر واحدهای موجود : <span
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


                                <div  id="existedDiv" style="display: none;">
                                    <select id="existed" class="form-control" style="margin-right: 67%; margin-top: 0%; width: 30.75%; position: absolute;">'+
                                        <option>زیر دسته ای برای دسته منتخب در نظر گرفته نشده است</option>
                                    </select>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="form-group">
                                <div class="col-md-12" style="margin-top: 2%;">
                                    <button id="reg" type="button" class="col-md-9 btn btn-primary">ثبت نهایی</button>
                                    <button id="addMainUnit" type="button" class="col-md-9 btn btn-success" style="display: none;">اضافه کردن واحد اصلی جدید</button>
                                    <button id="addSubUnit" type="button" class="col-md-9 btn btn-info" style="display: none;">  اضافه کردن زیر واحد برای واحد انتخاب شده</button>
                                    {{--<button id="addBrands" type="button" class="col-md-9 btn btn-primary" style="display: none;!important;"> اضافه کردن زیر دسته برای زیر دسته انتخاب شده</button>--}}
                                </div>
                            </div>
                            <input type="hidden" id="unitId" name="unitId" value="">
                            {{--<input type="hidden" id="subId" name="subId" value="">--}}
                        </form>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12"></div>
            </div>
        </div>



    <!-- below script is to get main units -->
    <script>
        $(function () {
            //load MainUnitsCount
            var option = '';
            $.ajax
            ({
                cache: false,
                url: "{{Url('api/v1/getMainUnits')}}",
                dataType: "json",
                type: "get",
                success: function (response) {
                    console.log(response);
                    if (response != 0) {
                        $('#showUnits').css('display','block');
                        var item = $('#units');
                        $.each(response, function (key, value) {
                        item.empty();
                        item.append
                            (
                                "<option selected='true' disabled='disabled'>برای اضافه کردن زیر واحد ، واحد اصلی را انتخاب کنید</option>"
                            )
                            if(value.active == 1)
                            {
                                item.append
                                (
                                    option += "<option id='"+value.id+"' name='"+value.depth+"'>"+value.title+"</option>"
                                );
                            }
                            if(value.active == 0)
                            {
                                item.append
                                (
                                    option += "<option id='"+value.id+"' name='"+value.depth+"' style='background-color: lightgray;' disabled >"+value.title+"</option>"
                                );
                            }

                        });
                        $('#addMainUnit').css('display','block');
                        $('#addInput').css('display','none');
                        $('#reg').css('display','none');
                        $('#removeInput').css('display','none');

                    }
                    else {
                            $('#change').css('display','block');

                            appendToChange();
                    }
                }
            });
            })

    </script>

    <!-- below script is to append html element to change tag -->
    <script>
        function appendToChange()
        {
            $('#change').append
            (
                "<div id='child'>"+
                "<br/><br/>"+

                    "<div class='col-md-9 col-sm-9 col-xs-9'>"+
                        "<input id='unit' class='form-control col-md-12 col-xs-12 required' name='unit[]' placeholder='' required='required' type='text'>"+
                    "</div>"+
                    "<label class='control-label col-md-3 col-sm-4 col-xs-3' for='name'>عنوان  :"+
                        "<span class='star' title='پر کردن این فیلد الزامی است'>*</span>"+
                    "</label>"+
                "</div>"
            );
        }

    </script>

    <!-- below script is to append input type -->
    <script>
        $(document).on('click','#addInput',function () {
            appendToChange();
        })
    </script>
    
    <!-- below script is to remove input type -->
    <script>
            $(function () {
                $(document).on('click','#removeInput',function () {
                    removeFromChange();
                });
                function removeFromChange() {
                    if ($('#change > #child').length > 1) {
                        $('#change > #child').last().remove();
                    };
                }
            });

    </script>

    <!-- below script is to handle addMainUnit  -->
    <script>
        $(document).on('click','#addMainUnit',function () {
            $('#unitId').val('');
            var option = '';
            $.ajax
            ({
                cache: false,
                url: "{{Url('api/v1/getMainUnits')}}",
                dataType: "json",
                type: "get",
                success: function (response)
                {
                    $('#showUnits').css('display','block');
                    $('#change').empty();
                    var item = $('#units');
                    $.each(response, function (key, value) {
                        item.empty();
                        item.append
                        (
                            "<option selected='true' disabled='disabled'>واحد های شمارش موجود</option>"
                        )
                        if(value.active == 1)
                        {
                            item.append
                            (

                                option += "<option selected='true' disabled='disabled' id='"+value.id+"' name='"+value.depth+"'>"+value.title+"</option>"
                            );
                        }
                        if(value.active == 0)
                        {
                            item.append
                            (

                                option += "<option selected='true' disabled='disabled' style='background-color: lightgray;' id='"+value.id+"' name='"+value.depth+"'>"+value.title+"</option>"
                            );
                        }


                    });
                    $('#addMainUnit').css('display','none');
                    $('#addInput').css('display','block');
                    $('#removeInput').css('display','block');
                    $('#reg').css('display','block');
                    //$('#showUnits').css('display','none');
                    $('#change').css('display','block');
                    $('#addSubUnit').css('display','none');
                    $('#subUnits').css('display','none');
                    appendToChange();
                }
            });

        })
    </script>


    <!-- below script is to send data to server side -->
    <script>
        $(document).on('click','#reg',function(){
            var option = '';
            var formData = new FormData ($('#unitForm')[0]);
            $.ajax
            ({
                cache       : false,
                url         : "{{url('admin/addNewUnit')}}",
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
                    swal({
                        title: "",
                        text: res,
                        type: "success",
                        confirmButtonText: "بستن"
                    });

                        $.ajax({

                            cache:false,
                            url:"{{url('api/v1/getMainUnits')}}",
                            type:'get',
                            dataType:"json",
                            success:function (response) {
                                console.log(response);
                                console.log(response);
                                if(response)
                                {
                                    $('#showUnits').css('display','block');
                                    $('#subUnits').css('display','none');
                                    $('#reg').css('display','none');

                                    $.each(response,function (key,value) {
                                        var item = $('#units');
                                        item.empty();
                                        //
                                        item.append
                                        (
                                            "<option selected='true' disabled='disabled'>برای اضافه کردن زیر واحد ، واحد اصلی را انتخاب کنید</option>"
                                        )
                                        if(value.active == 1)
                                        {
                                            item.append
                                            (
                                                option += "<option id='"+value.id+"' name='"+value.depth+"'>"+value.title+"</option>"
                                            );
                                        }
                                        if(value.active == 0)
                                        {
                                            item.append
                                            (
                                                option += "<option id='"+value.id+"' name='"+value.depth+"' style='background-color: lightgray;' disabled>"+value.title+"</option>"
                                            );
                                        }


                                    })
                                    $('#change').empty();
                                    $('#addMainUnit').css('display','block');
                                }
                            }

                        })

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


    <!-- below script is to get sub unit count  if exist and if not guide it to make sub unit-->
    <script>
        $(function () {
            $(document).on('change','#units',function () {

                $("[name = 'units'] option:selected").each(function(){

                    var id = $(this).attr('id');
                    //alert(id);
                    $('#unitId').val(id);
                    var title = $(this).val();
                    if(id != 0)
                    {
                        $.ajax
                        ({
                            cache: false,
                            url: "{{Url('api/v1/getSubunits')}}/" + id,
                            dataType: "json",
                            type: "get",
                            success: function (response)
                            {
                                console.log(response);
                                var option = '';
                                if(response != 0)
                                {
                                    $.each(response,function (key,value) {
                                        var item = $('#subUnits');
                                        item.empty();
                                        //
                                        item.append
                                        (
                                            "<option selected='true' disabled='disabled'>زیر واحد های موجود</option>"
                                        );
                                        if(value.active == 1)
                                        {
                                            item.append
                                            (
                                                option += "<option id='"+value.id+"' name='"+value.depth+"'>"+value.title+"</option>"
                                            );
                                        }
                                        if(value.active == 0)
                                        {
                                            item.append
                                            (
                                                option += "<option id='"+value.id+"' name='"+value.depth+"' style='background-color: lightgray;' disabled>"+value.title+"</option>"
                                            );
                                        }

                                    })
                                    $('#subUnits').css('display','block');
                                    $('#addSubUnit').css('display','block');
                                }else
                                    {
                                        untimelyAddCategory(title,id);
                                    }
                            }
                        });
                    }
                })
            })
        })
    </script>


    <script>
        function untimelyAddCategory(title,id)
        {

            swal
            ({
                    title:   " آیا در نظر دارید برای واحد " +"(( "+ title +" ))"+  " زیر واحد انتخاب نمائید؟ ",
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

                        if (id) {

                            $.ajax
                            ({
                                url: "{{url('api/v1/getSubunits')}}/" + id,
                                dataType: 'json',
                                type: 'get',
                                success: function (result) {

                                    console.log(result);
                                    console.log('I am result');
                                    if (result != 0) {

                                        var option = '';
                                        $.each(result, function (key, value) {

                                            $('#existed').empty();
                                            $('#existed').append
                                            (
                                                "<option>زیر واحد های درج شده</option>"
                                            )
                                            $('#existed').append
                                            (
                                                option += "<option selected='true' disabled='disabled' id='" + value.id + "' name='" + value.depth + "'>" + value.title + "</option>"
                                            );

                                        });
                                        $('#subUnits').css('display', 'block');
                                        $('#showUnits').css('display', 'none');
                                        $('#existed').css('display', 'block');
                                        $('#change').css('display', 'block');
                                        $('#addSubUnit').css('display', 'none');
                                        $('#addMainUnit').css('display', 'none');
                                        $('#addInput').css('display', 'block');
                                        $('#removeInput').css('display', 'block');
                                        $('#reg').css('display', 'block');
                                    } else {
                                        $('#existed').empty();
                                        $('#existed').append
                                        (
                                            "<option>هنوز زیر واحدی برای این واحد در نظر گرفته نشده است!</option>"
                                        )
                                        //   $('#change').empty();
                                        $('#showUnits').css('display', 'none');
                                        $('#change').css('display', 'block');
                                        $('#addMainUnit').css('display', 'none');
                                        $('#reg').css('display', 'block');
                                        $('#addInput').css('display', 'block');
                                        $('#removeInput').css('display', 'block');
                                        $('#addSubUnit').css('display', 'none');
                                    }

                                }
                            })
                        }

                     else
                         {
                     //        $('#subUnits').css('display','none');
                         }

                        $('#change').append
                        (
                            '<div id="main" class="col-md-5 col-md-offset-4">' +
                            '<input value="' + title + '" class="form-control col-md-6" disabled  style="text-align: center; font-size: 120%;">' +
                            '<b>'
                            + '<lable style="margin-right:-60%;" class="control-label" for="name">عنوان دسته منتخب:</lable>' +
                            '</b>' +
                            '</div>'
                        );

                        $('#existedDiv').css('display', 'block');

                        appendToChange();
                    }
                    else
                    {
                        $('#subUnits').css('display','none');
                        $('#addSubUnit').css('display','none');
                    }
                });
        }
    </script>

    <!-- below script is to handle addSubUnit button -->
    <script>
        $(document).on('click','#addSubUnit',function(){
            $("[name = 'units'] option:selected").each(function(){

                var id = $(this).attr('id');
                //alert(id);
                $('#unitId').val(id);
                var title = $(this).val();
                untimelyAddCategory(title,id);
        })
     })
    </script>

@endsection