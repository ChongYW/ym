@extends('mobile.film.wap')

@section("header")

@endsection

@section("js")
    <script type="text/javascript" src="{{asset("js/jquery.js")}}"></script>
    <script src="{{asset("js/layui/layui.js")}}"></script>
    <script src="{{asset("mobile/film/js/swiper.min.js")}}"></script>
@endsection

@section("css")
    @parent
    <link rel="stylesheet" href="{{asset("js/layui/css/layui.css")}}"/>
    <link rel="stylesheet" href="{{asset("mobile/film/css/swiper.min.css")}}"/>
@endsection



@section('body')
    <iframe marginwidth="0" marginheight="0" src=" https://cpu.baidu.com/1022/a93bcb0f/i?pu=2" frameborder="0" width="100%" scrolling="noshade" height="1000px"></iframe>

    <div id="appdown" class="appdown">
        <span class="left">{!!  \Cache::get('IndexTaotiaoAppText')!!}</span>
        <span class="appClose right" id="close">×</span>
        <a href="{{\Cache::get('AppDownloadUrl')}}" class="right appBtn">App客户端</a>

    </div>
@endsection


@section("footbox")
    @parent
@endsection

@section("footcategory")


    <style>

        .appdown {
            background: rgba(0,0,0,0.3) url(/uploads/{{Cache::get("appdownloge").'?t='.time()}}) no-repeat 10px center;
            background-size: 40px;
            width: 100%;
            height: 46px;
            position: fixed;
            bottom: 55px;
            left: 0px;
            z-index: 8888888;
            color: #fff;
            padding-left: 60px;
            font-size: 14px;
        }


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
            background: url(/mobile/film/images/tab3_1_004_1.png) no-repeat top center;
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


    </style>

    <footer class="borderTop">

        <a href="/index.html" title="资讯首页" class="f_home active" id="menu0">资讯首页</a>

        <a href="{{route('user.index')}}" title="邀请好友" class="f_geng" id="menu1">邀请好友</a>



        <a href="{{route('user.index')}}" title="个人中心" class="navAccount f_account" id="menu3">个人中心</a>

        <a href="{{route('user.index')}}" title="每日签到" class="f_touz" id="menu4">每日签到</a>
        <?php
        $link=\App\Category::where('name','like','%客服%')->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->value('links')
        ?>

        <a href="{{$link}}" title="在线客服" class="f_borrow" id="menu2">在线客服</a>

    </footer>

@endsection

@section("footer")

    @parent
    <p><br/></p>
    {!! Cache::get("waptongjicode") !!}
@endsection


@section('footcategoryactive')
    <script type="text/javascript">
        $("#menu0").addClass("active");
    </script>
@endsection

