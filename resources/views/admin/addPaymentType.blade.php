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
                    <h2> فرم ایجاد وضعیت پردخت</h2>
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
                                <div id="showPaymentTypes" style="display: none; !important;">
                                    <div class="col-md-9 col-sm-6 col-xs-9">
                                        <select id="paymentTypes"  class="form-control" name="colors">

                                        </select>




                                    </div>
                                    <label class="control-label col-md-3 col-sm-4 col-xs-3" for="title">وضعیتهای پرداخت  موجود : <span
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




                            </div>
                            <div class="form-group">
                                <div class="col-md-12" style="margin-top: 2%;">
                                    <button id="reg" type="button" class="col-md-9 btn btn-primary">ثبت نهایی</button>
                                </div>
                            </div>

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
                    url: "{{Url('api/v1/getPaymentTypes')}}",
                    dataType: "json",
                    type: "get",
                    success: function (response) {
                        console.log(response);
                        if (response != 0) {
                            $('#showPaymentTypes').css('display','block');
                            var item = $('#paymentTypes');
                            $.each(response, function (key, value) {
                                item.empty();
                                item.append
                                (
                                    "<option selected='true' disabled='disabled'>وضعیتهای پرداخت موجود</option>"
                                )
                                item.append
                                (
                                    option += "<option id='"+value.id+"' name='"+value.depth+"'>"+value.title+"</option>"
                                );
                            });
                            //$('#addMainUnit').css('display','block');
                            $('#addInput').css('display','block');
                            $('#reg').css('display','block');
                            $('#removeInput').css('display','block');
                            $('#change').css('display','block');
                            appendToChange();

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
                    "<input id='unit' class='form-control col-md-12 col-xs-12 required' name='paymentTypes[]' placeholder='' required='required' type='text'>"+
                    "</div>"+
                    "<label class='control-label col-md-3 col-sm-4 col-xs-3' for='name'>عنوان وضعیت پرداخت  :"+
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




        <!-- below script is to send data to server side -->
        <script>
            $(document).on('click','#reg',function(){
                var option = '';
                var formData = new FormData ($('#unitForm')[0]);
                $.ajax
                ({
                    cache       : false,
                    url         : "{{url('admin/addNewPaymentTypes')}}",
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
                    success  : function(res)
                    {
                        if(res.code == 1)
                        {
                            console.log(res.message);
                            swal({
                                title: "",
                                text: res.message,
                                type: "success",
                                confirmButtonText: "بستن"
                            });
                        }

                        $.ajax({

                            cache:false,
                            url:"{{url('api/v1/getPaymentTypes')}}",
                            type:'get',
                            dataType:"json",
                            success:function (response) {
                                console.log(response);
                                console.log(response);
                                if(response)
                                {
                                    $('#showPaymentTypes').css('display','block');
//                                    $('#subUnits').css('display','none');
//                                    $('#reg').css('display','none');

                                    $.each(response,function (key,value) {
                                        var item = $('#paymentTypes');
                                        item.empty();
                                        //
                                        item.append
                                        (
                                            "<option selected='true' disabled='disabled'>وضعیتهای پرداخت موجود</option>"
                                        )

                                        item.append
                                        (
                                            option += "<option id='"+value.id+"' name='"+value.depth+"'>"+value.title+"</option>"
                                        );

                                    })
                                    $('#change').empty();
                                    appendToChange();
                                    // $('#addMainUnit').css('display','block');

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
@endsection