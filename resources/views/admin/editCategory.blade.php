@extends('layouts.adminLayout')
@section('content')



    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog" dir="rtl">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ویرایش/اضافه کردن تصویر</h4>
                </div>
                <div class="modal-body">
                    <form id="pictureForm" enctype="multipart/form-data">
                        {{csrf_field()}}
                    @if($categoryInfo[0]->image_src != null)
                        <img class="image" id="editable"
                             style="height: 100px; width: 100px; margin-left: 80%;"
                             src="{{url('public/dashboard/image')}}/{{$categoryInfo[0]->image_src}}">
                    @endif
                    @if($categoryInfo[0]->image_src == null)
                        <div align="center"><h1>این دسته تصویر ندارد</h1></div>
                    @endif
                    <br/><br/>
                    <input type="file" name="file[]" id="file" class="form-control">
                    <input type="hidden" name="categoryId" value="{{$categoryInfo[0]->id}}">
                    </form>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-dark col-md-5 col-md-offset-1" data-dismiss="modal">بستن</button>
                    <button type="button" content="{{$categoryInfo[0]->id}}" id="editCategoryPicture" class="btn btn-warning col-md-5" >ویرایش</button>
                </div>
            </div>

        </div>
    </div>


    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title"> 
                    <h2> مدیریت دسته بندی ها</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link" data-toggle="tooltip" title="جمع کردن"><i
                                        class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link" data-toggle="tooltip" title="بستن"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>


                {{--<a href="{{url('admin/addProduct')}}" id="user-send" type="button" class="col-md-2 btn btn-primary" style="font-weight: bold;">--}}
                    {{--<i class="fa fa-th-list"></i>                    افزودن دسته ی جدید                </a>--}}
                {{--<div class="pull-right" style="direction: rtl"><i class="fa fa-square" style="font-size: 35px;color:#ffff80;"></i> مدیران واحد</div>--}}
                <div class="x_content">
                    <table style="direction:rtl;text-align: center" id="example"
                           class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <input type="hidden" id="token" value="{{ csrf_token() }}">
                        <thead>
                        <tr>
                            <th style="text-align: center">ردیف</th>
                            <th style="text-align: center">عنوان دسته</th>
                            <th style="text-align: center;">سطح دسته</th>
                            <th style="text-align: center">عملیات مربوط به تصویر</th>
                            <th style="text-align: center">ویرایش</th>
                            <th style="text-align: center">تغییر وضعیت</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $i = 0 ?>
                        <form id="editForm">
                            {{csrf_field()}}
                        {{--@foreach($categoryInfo as $category)--}}
                                <tr class="unit">
                                    <td style="font-size: 120%">{{++$i}}</td>
                                    <td class="col-md-4 "><input  class="form-control" style="width: 100%;" id="title" name="title" value="{{$categoryInfo[0]->title}}"></td>
                                    <td style="font-size: 120%">{{$categoryInfo[0]->depth}}</td>
                                    <td><strong><a class="btn btn-default" id="openModal" >مشاهده و ویرایش تصویر</a></strong></td>
                                    <td><button id="edit" type="button" class="btn btn-warning">ویرایش</button></td>
                                    @if($categoryInfo[0]->active == 1)
                                        <td><a id="active" content="{{$categoryInfo[0]->active}}" name="{{$categoryInfo[0]->id}}" type="button"  data-content="غیر فعال" class="btn btn-danger" >غیر فعال</a></td>
                                    @endif
                                    @if($categoryInfo[0]->active == 0)
                                        <td><a id="active" content="{{$categoryInfo[0]->active}}" name="{{$categoryInfo[0]->id}}" type="button"  data-content="فعال" class="btn btn-success"> فعال</a></td>
                                    @endif
                                    <input type="hidden" value="{{$categoryInfo[0]->id}}" id="id" name="id">
                                    <input type="hidden" id="token" value="{{csrf_token()}}" name="_token">
                                </tr>
                        {{--@endforeach--}}
                        </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>




        {{--below script is to edit title of category --}}
        <script>
            $(document).on('click','#edit',function () {
                var title = $('#title').val();
                var id   = $('#id').val();
                var token = $('#token').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                swal({
                        title:   " آیا می خواهید ویرایش انجام دهید؟  ",
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
                            $.ajax
                            ({
                                cache: false,
                                url: "{{url('admin/editCategoryTitle')}}",
                                data: {'title': title, 'id': id, '_token': token},
                                type: "post",
                                dataType: "JSON",
                                beforeSend: function () {
                                    if ($('#title').val() == null || $('#title').val() == '') {
                                        $('#title').css('border-color', 'red');
                                        swal({
                                            title: "",
                                            text: 'پر کردن عنوان دسته الزامی است',
                                            type: "warning",
                                            confirmButtonText: "بستن"
                                        });
                                        return false;
                                    }
                                },
                                success: function (response) {
                                    if (response.code == 1) {
                                        swal({
                                            title: "",
                                            text: response.message,
                                            type: "success",
                                            confirmButtonText: "بستن"
                                        });
                                        setTimeout(function () {
                                            window.location.href = document.referrer;
                                        },3000);
                                    } else {
                                        swal({
                                            title: "",
                                            text: response.message,
                                            type: "warning",
                                            confirmButtonText: "بستن"
                                        });
                                    }

                                }, error: function (error) {
                                    console.log(error);
                                    if (error.status === 500) {
                                        swal({
                                            title: "",
                                            text: 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید',
                                            type: "warning",
                                            confirmButtonText: "بستن"
                                        });
                                    }
                                }
                            })

                        }
                   })
            })
        </script>

        <!-- below script is to handle bootstrap  modal and show modal-->
        <script>
            $(document).on('click','#openModal',function () {
                $('#myModal').modal('show');
            })
        </script>

        <!-- below script is to edit category picture -->
        <script>
            $(document).on('click','#editCategoryPicture',function(){
                var formData = new FormData($('#pictureForm')[0]);
                $.ajax
                ({
                    cache        : false,
                    url          : "{{url('admin/editCategoryPicture')}}",
                    type         : "post",
                    data         : formData,
                    dataType     : "JSON",
                    processData  : false,
                    contentType  : false,
                    beforeSend   : function () {
                        if($('#file').val() == null || $('#file').val() == '' )
                        {
                            $('#file').css('border-color','red');
                            swal({
                                title: "",
                                text: 'لطفا ابتدا فایلی را انتخاب نمایید، سپس  ویرایش را بزنید',
                                type: "warning",
                                confirmButtonText: "بستن"
                            });
                            return false;
                        }
                    },
                    success : function(response)
                    {
                        if(response.code == 1)
                        {
                            swal({
                                title: "",
                                text: response.message,
                                type: "info",
                                confirmButtonText: "بستن"
                            });
                        }else
                            {
                                swal({
                                    title: "",
                                    text: response,
                                    type: "success",
                                    confirmButtonText: "بستن"
                                });
                                setTimeout(function(){
                                    window.location.reload(true);
                                },3000);
                            }
                    },error:function(error)
                    {
                        console.log(error);
                    }
                })
            })
        </script>

        <!-- below script is to make it active or deactive -->
        <script>
            $(document).on('click','#active',function () {
                var active     = $(this).attr('content');
                var token      = $("#token").val();
                var categoryId = $(this).attr('name');
                var title      = $(this).attr('data-content');
                //alert(title);
                swal({
                        title:   " آیا در نظر دارید وضعیت دسته را " +"(( "+ title +" ))"+  "  نمایید؟ ",
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
                            $.ajax
                            ({
                                cache: false,
                                url: "{{url('admin/enableOrDisableCategory')}}",
                                type: "post",
                                data: {'_token': token, 'active': active, 'categoryId': categoryId},
                                dataType: "JSON",
                                success: function (response) {
                                    if (response.code == 1) {
                                        swal({
                                            title: "",
                                            text: response.message,
                                            type: "success",
                                            confirmButtonText: "بستن"
                                        });
                                        setTimeout(function () {
                                            window.location.href = document.referrer;
                                        }, 3000);
                                    } else {
                                        swal({
                                            title: "",
                                            text: response.message,
                                            type: "warning",
                                            confirmButtonText: "بستن"
                                        });
                                    }

                                }, error: function (error) {
                                    console.log(error);
                                    swal({
                                        title: "",
                                        text: 'خطایی رخ داده است ، با بخش پشتیبانی تماس بگیرید',
                                        type: "warning",
                                        confirmButtonText: "بستن"
                                    });
                                }
                            })
                        }
                    })
            })

        </script>


@endsection
