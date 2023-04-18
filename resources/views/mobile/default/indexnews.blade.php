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


    <iframe marginwidth="0" marginheight="0" src=" https://cpu.baidu.com/1022/a93bcb0f/i?pu=2" frameborder="0" width="100%" scrolling="noshade" height="1000px"></iframe>

    <div id="appdown" class="appdown">
        <span class="left">{!!  \Cache::get('IndexTaotiaoAppText')!!}</span>
        <span class="appClose right" id="close">×</span>
        <a href="{{\Cache::get('AppDownloadUrl')}}" class="right appBtn">App客户端</a>

    </div>
@endsection

@section("footcategory")

    <link href="{{asset("mobile/static/css/zzsc.css")}}" rel="stylesheet" type="text/css"/>
    <script>
        $(function() {
            $(".yb_top").click(function() {
                $("html,body").animate({
                    'scrollTop': '0px'
                }, 300)
            });
        });
    </script>

    <style>

        .appdown {background: rgba(0,0,0,0.3) url(/uploads/{{\Cache::get('appdownloge').'?t='.time()}}) no-repeat 10px center;
            background-size: 40px;
            width: 100%;
            height: 46px;
            position: fixed;
            bottom: 55px;
            left: 0px;
            z-index: 8888888;
            color: #fff;
            padding-left: 60px;
            font-size: 14px;}
        .appBtn { background:#e32c42; padding:2px 5px; color:#ffde00; border-radius:5px; margin-top:10px; margin-right:15px;}
        .appClose { font-size:35px; font-weight:bold; line-height:46px; padding-right:10px; padding-left:10px; cursor:pointer;margin-right:65px;}
        .wxtip {
            background: rgba(0, 0, 0, 0.8);
            text-align: center;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 998;
            display: none;
        }
        .right{
            float:right;
        }
        .left{
            float:left;
        }


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
        .f_home {
            background: url('{{asset("mobile/static/images/navhomeh.png")}}') no-repeat top center;
            background-size: 21px;
            color: #D8232C;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        .f_account {
            background: url('{{asset("mobile/static/images/navacc.png")}}') no-repeat top center;
            background-size: 19px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        .f_borrow {
            background: url('{{asset("mobile/static/images/navborrow.png")}}') no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        .f_invest {
            background: url('{{asset("mobile/static/images/navinvest.png")}}') no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        .f_touz {
            background: url('{{asset("mobile/static/images/chongzhi.gif")}}') no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        .f_geng {
            background: url('{{asset("mobile/static/images/shezhi.gif")}}') no-repeat top center;
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


    <div class="yb_conct">
        <div class="yb_bar">
            <ul>




        <li><a href="/index.html" title="资讯首页" class="f_home active" id="menu0">资讯首页</a></li>

        <li><a href="{{route('user.index')}}" title="邀请好友" class="f_geng" id="menu1">邀请好友</a></li>



        <li><a href="{{route('user.index')}}" title="个人中心" class="navAccount f_account" id="menu3">个人中心</a></li>

        <li><a href="{{route('user.index')}}" title="每日签到" class="f_touz" id="menu4">每日签到</a></li>
                <?php
                $link=\App\Category::where('name','like','%客服%')->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->value('links')
                ?>

        <li><a href="{{$link}}" title="在线客服" class="f_borrow" id="menu2">在线客服</a></li>
            </ul>
        </div>
    </div>


@endsection

@section("footbox")
    @parent
@endsection

@section("footer")
    @parent

    {!! Cache::get("waptongjicode") !!}
@endsection

