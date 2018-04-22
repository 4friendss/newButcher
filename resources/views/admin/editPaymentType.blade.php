@extends('layouts.adminLayout')
@section('content')

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>ویرایش وضعیت پرداخت</h2>
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
                            <th style="text-align: center">عنوان وضعیت پرداخت</th>
                            <th style="text-align: center">ویرایش</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $i = 0 ?>
                        <form id="editForm">
                            {{csrf_field()}}
                            {{--@foreach($categoryInfo as $category)--}}
                            <tr class="unit">
                                <td style="font-size: 120%;">{{++$i}}</td>
                                <td class="col-md-6 "><input  class="form-control" style="width: 100%;" id="title" name="title" value="{{$data[0]->title}}"></td>
                                <td><button id="edit" type="button" class="btn btn-warning col-md-9 col-md-offset-1">ویرایش</button></td>
                                <input type="hidden" value="{{$data[0]->id}}" id="id" name="id">
                                <input type="hidden" id="token" value="{{csrf_token()}}" name="_token">
                            </tr>
                            {{--@endforeach--}}
                        </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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
                                url: "{{url('admin/editPaymentTypeTitle')}}",
                                data: {'title': title, 'id': id, '_token': token},
                                type: "post",
                                dataType: "JSON",
                                beforeSend: function () {
                                    if ($('#title').val() == null || $('#title').val() == '') {
                                        $('#title').css('border-color', 'red');
                                        $('#title').focus();
                                        swal({
                                            title: "",
                                            text: 'پر کردن عنوان وضعیت پرداخت الزامی است',
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
                                    }
                                    else {
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
@endsection