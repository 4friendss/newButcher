@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{--var x='<li class="block-container col-sm-3">' + '<ul class="block">'--}}
        {{--if (i) {--}}
        {{--x += '<li class="block-container col-sm-3">' + '<ul class="block">'--}}
                {{--x += '<ul class="block">' +--}}
                    {{--'<li class="img_container">' +--}}
                        {{--'<img src="public/main/assets/data/banner-topmenu.jpg" alt="' + value.catImg + '" title="' + value.catImg + '" >' +--}}
                        {{--'</li>' +--}}
                    {{--'</ul></li>'--}}
                {{--}--}}
                {{--i = 0;--}}
                {{--x += '<li class="block-container col-sm-3">' + '<ul class="block">'--}}
                        {{--//                                if(value.image_src != null)--}}
                        {{--//                                {--}}
                        {{--//                                    x+='<li class="img_container">' +--}}
                            {{--//                                    '<a href="#">' +--}}
                                {{--//                                    '<img class="img-responsive" src="public/main/assets/data/men.png" alt="sport">' +--}}
                                {{--//                                    '</a>' + '</li>';--}}
                        {{--//                                }--}}
                        {{--x += '<li class="link_container group_header" id="brand">' +--}}
                            {{--'<a href="#" ' + value.id + '>' + value.title + '</a>' +--}}
                            {{--'</li>';--}}
                        {{--$.each(value.brands, function (key, value) {--}}
                        {{--x += '<li class="link_container" id="' + value.id + '"><a href="#">' + value.title + '</a></li>';--}}
                        {{--});--}}
                        {{--x += '</ul>' + '</li>';--}}