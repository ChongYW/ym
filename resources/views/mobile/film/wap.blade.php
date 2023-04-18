<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta content="width=device-width,initial-scale=1,mininum-scale=1.0, maximum-scale=1.0,user-scalable=no"
          name="viewport" id="viewport"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <title>@if(isset($title)){{$title}}@else{{\Cache::get('CompanyLong')}}@endif</title>
    <meta name="keywords" content="{{\Cache::get('title')}}" />
    <meta name="description" content="{{\Cache::get('keywords')}}" />


</head>
<body>

@section('css')
    <link href="{{asset("mobile/film/css/alert.css")}}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset("mobile/film/css/index.css")}}"/>

@show
@section('js')
    <script type="text/javascript" src="{{asset("js/jquery.js")}}"></script>
    <script src="{{asset("js/layer/layer.js")}}"></script>
    <script src="{{asset("js/layui/layui.js")}}"></script>

@show

@section('header')
@show
<!--主体-->
@yield('body')
<!--主体 end-->
@section('footer')
    <div style="text-align:center">

</div>
<script>
    $(function () {
        $(".appClose").click(function () {
            $(".appdown").hide();
        });

        $(".store_main_Brief").click(function () {
            $("#shareTo").css('display', 'block');

        });

        $(".shareTit").click(function () {
            $("#shareTo").css('display', 'none');
        });


    });
</script>
@show
@section('appdown')
{{--
  <div class="appdown">
        <span class="left">{{\Cache::get('CompanyShort')}}APP<br/>为投资者稳健财富增值</span>
        <span class="appClose right">×</span>
        <a href="{{\Cache::get('AppDownloadUrl')}}" class="right appBtn">立即下载</a>
    </div>
--}}
@show
@section('footcategory')
    <style>

        .f_geng {
            background: url(/mobile/static/images/shezhi.gif) no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        .f_touz {
            background: url(/mobile/static/images/chongzhi.gif) no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }

        .piaofang {
            background: url('{{asset("mobile/static/images/maoyan.png")}}') no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        @if(Cache::get('BoxOffice')=='开启')
        .borderTop a {

            width: 16.3%;

        }
        @endif
    </style>
    <footer class="borderTop">
        @if($footcategory)
            @foreach($footcategory as $keyi=>$category)
                @if(Cache::get('BoxOffice')=='开启' && $keyi==3)
                    <a href="/piaofang" title="票房" class="piaofang" id="menupf">票房</a>


                @endif

                @if($category->model=='links')
                    <a href="{{$category->links}}" title="{{$category->name}}" class="{{$category->classname}}" id="menu{{$keyi}}">{{$category->name}}</a>
                @else
                    <a href="{{route($category->model.".links",["links"=>$category->links])}}" title="{{$category->name}}" class="{{$category->classname}}" id="menu{{$keyi}}">{{$category->name}}</a>
                @endif
            @endforeach
        @endif
    </footer>
@show
@section('footcategoryactive')

@show

{!! Cache::get('wapcode') !!}
</body>
</html>




