<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <title>@if(isset($title)){{$title}}@else{{\Cache::get('CompanyLong')}}@endif</title>
    <meta name="keywords" content="{{\Cache::get('title')}}" />
    <meta name="description" content="{{\Cache::get('keywords')}}" />

    @section('css')
        <link rel="stylesheet" href="{{asset("mobile/bluev3/css/base.css")}}"/>
        <link rel="stylesheet" href="{{asset("mobile/bluev3/css/style.css")}}"/>
        <link rel="stylesheet" href="{{asset("js/layui/css/layui.css")}}"/>

    @show
    @section('js')

        <script type="text/javascript" src="{{asset("mobile/bluev3/js/adaptive.js")}}"></script>
        <script type="text/javascript" src="{{asset("mobile/bluev3/js/config.js")}}"></script>
        <script type="text/javascript" src="{{asset("mobile/bluev3/js/jquery-1.9.1.min.js")}}"></script>
        <script type="text/javascript" src="{{asset("mobile/bluev3/js/public.js")}}"></script>
        <script src="{{asset("js/layui/layui.js")}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var layer;
                layui.use('layer', function () {
                    layer = layui.layer;
                });
            });
        </script>
    @show
</head>
<body id="google_translate_element">
<div class="mobile">


@section('header')
@show
<!--主体-->
@yield('body')
<!--主体 end-->
@section('footer')

@show
@section('appdown')

@show
@section('footcategory')


    <!-- 底部样式 -->
    <div class="header-nbsp"></div>
    <div class="footer_nav">

        @if($footcategory)
            @foreach($footcategory as $keyi=>$category)
                @if(Cache::get('BoxOffice')=='开启' && $keyi==3)
                    <a href="/piaofang" title="票房" class="piaofang" id="menupf">
                        <img  src="/mobile/static/images/maoyan.png"  style="width: 20px;height: 20px;">
                        <span>票房</span>
                    </a>


                @endif

                @if($category->model=='links')
                    <a href="{{$category->links}}" title="{{$category->name}}" class="{{$category->classname}}" id="menu{{$keyi}}">

                        <img  src="{{$category->thumb_url}}" style="width: 20px;height: 20px;">
                        <span>{{$category->name}}</span>
                    </a>
                @else
                    <a href="{{route($category->model.".links",["links"=>$category->links])}}" title="{{$category->name}}" class="{{$category->classname}}" id="menu{{$keyi}}">
                        <img  src="{{$category->thumb_url}}" style="width: 20px;height: 20px;">
                        <span>{{$category->name}}</span>
                    </a>
                @endif
            @endforeach
        @endif


    </div>

    <!-- 底部样式 end -->
    <!-- 回到顶部 -->
    <div class="go_top" id="go_top"><img src="{{asset("mobile/bluev3/img/top.png")}}"></div>
    <style>
        .myc-red-point{
            position: relative;
        }
        .myc-red-point::before{
            content: " ";
            border: 3px solid red;/*设置红色*/
            border-radius:3px;/*设置圆角*/
            position: absolute;
            right:25px;
            top: -22px;
            margin-right: -1px;
        }
    </style>




@show
@section('footcategoryactive')

@show

{!! Cache::get('wapcode') !!}
</div>
</body>
</html>




