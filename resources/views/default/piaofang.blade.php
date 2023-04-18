@extends('mobile.default.wap')

@section("header")
    @parent
@endsection

@section("js")
    @parent
@endsection

@section("css")
    @parent

    <link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/user.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/index.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/public.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("wap/cp/css/index.css")}}"/>
    <style>
        .notice .marquee font {
            color: #666;
        }
    </style>

@endsection



@section('body')


    <div class="top" id="top"
         style="background-color: #0E90D2;height: 50px;position: fixed;width:100%;max-width: 450px;">
        <div class="kf">

            <div style="display: block;width:100%; background-color: cornsilk;position: absolute;top: 0;
     left: 0;text-align: center;  height: 50px; line-height: 50px; ">

                <img src="\uploads\{{\Cache::get('waplogo').'?t='.time()}}" style="height: 80%;line-height: 50px;"/>

                <a href="javascript:;"
                   style="text-align: center;  font-size: 16px; ">{{\Cache::get('CompanyShort')}}</a>

                @if(!isset($Member))
                    <a href="{{route("wap.login")}}" class="headerRight">登录/注册</a>

                @else
                    <a href="{{route("user.index")}}" class="headerRight">会员中心</a>
                @endif


            </div>

        </div>
    </div>

    <section class="client video-bg text-center" style="height: 100%;">

        <div style="overflow:hidden;width: 100%;margin:0 auto;border-radius:5px;" class="mnone">
            <iframe id="tickIframe" name="tickIframe" style="width: 99%;height:100%;margin: -60px auto;min-height: 780px;" src="https://m.dianying.baidu.com/rank/index?sfrom=wise_film_box" scrolling="no" frameborder="0"></iframe>
        </div>

    </section>


@endsection


@section("footbox")
    @parent
@endsection

@section("footer")

@endsection

