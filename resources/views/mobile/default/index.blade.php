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

    {{-- 手机首页幻灯片 --}}
    <div class="flexslider" style="top:50px;display: none;">
        <ul class="slides">
            @if($wapad['banner'])
                @foreach($wapad['banner'] as $ad)
                    <li><a href="{{$ad->url}}"><img src="{{$ad->thumb_url}}"></a></li>
                @endforeach
            @endif

        </ul>
    </div>
    {{-- 手机首页幻灯片end  --}}

    <script src="{{asset("mobile/static/js/jquery.flexslider-min.js")}}"></script>

    <script>
        /**倒计时方法**/


        function tow(n) {
            return n >= 0 && n < 10 ? '0' + n : '' + n;
        }


        function getDate(timer,Obj) {
            var oDate = new Date();//获取日期对象
            var oldTime = oDate.getTime();//现在距离1970年的毫秒数

            var newDate = new Date(timer);
            if(oldTime>newDate){
                location.reload(true);
            }
            var newTime = newDate.getTime();//2019年距离1970年的毫秒数
            var second = Math.floor((newTime - oldTime) / 1000);//未来时间距离现在的秒数
            var day = Math.floor(second / 86400);//整数部分代表的是天；一天有24*60*60=86400秒 ；
            second = second % 86400;//余数代表剩下的秒数；
            var hour = Math.floor(second / 3600);//整数部分代表小时；
            second %= 3600; //余数代表 剩下的秒数；
            var minute = Math.floor(second / 60);
            second %= 60;
            var str = '倒计时:'+tow(day) + '<span class="time">天</span>'
                + tow(hour) + '<span class="time">小时</span>'
                + tow(minute) + '<span class="time">分钟</span>'
                + tow(second) + '<span class="time">秒</span>';
            $("#djs"+Obj).html(str);

            setTimeout("getDate('"+timer+"','"+Obj+"')", 1000);
        }



        @if(isset($_GET["gg"]) && $_GET["gg"]=='1')


        //信息框
        layer.open({
            title: '系统公告',
            content: '{{\App\Formatting::Format(\Cache::get('boxgg'))}}'
            , btn: '关闭公告'
        });

        @endif

        $(window).on('load', function() {
            $('.flexslider').show().flexslider({
                directionNav: false,
                pauseOnAction: false
            });
        });
    </script>
    <div class="zs_navdh">
        <ul>
            <li><a href=""></a></li>
        </ul>
    </div>




    <div class="blank clear"></div>
    <style>
        .layui-m-layercont {
            padding: 15px 30px;
            line-height: 22px;
            text-align: center;
        }

        /* new nav */
        .index-nav-wrap {
            background-color: #fff;
        }

        .index-nav {
            width: 100%;
            background-color: #fff;
        }

        .index-nav ul {
            width: 100%;
            margin: 0 auto;
        }

        .index-nav li {
            width: 25%;
            float: left;
        }

        .index-nav a {
            display: block;
            padding: 15px 0 0;
            width: 60px;
            margin: 0 auto;
        }

        .index-nav em {
            width: 48px;
            height: 48px;
            display: block;
            margin: 0 auto;
        }

        .index-nav img {
            width: 100%;
            height: 100%;
        }

        .index-nav p {
            height: 40px;
            font: normal 14px/40px "Microsoft YaHei";
            text-align: center;
            color: #666;
        }

        .index-nav-wrap .active-fix {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .nav-icon {
            position: relative;
            width: 100%;
            margin: 0 auto;
            padding-bottom: 10px;
            background: #fff;
            top: 50px;
        }





    </style>

    <script>

        function qiandao() {

                    @if(isset($Member))
            var _token = $("[name='_token']").val();
            $.ajax({
                url: '{{route('user.qiandao')}}',
                type: 'post',
                data: {_token: _token},
                dataType: 'json',
                error: function () {
                },
                success: function (data) {
                    layer.open({
                        content: data.msg,
                        time: 2,
                        shadeClose: false,

                    });
                }
            });
            @else

            layer.open({
                content: "您还没有登录",
                time: 2,
                shadeClose: false,

            });


            @endif
        }

    </script>
    <div class="nav-icon">
        <div class="index-nav-wrap">
            <div class="index-nav">
                <ul class="clear">



                    @if($moreccategory)
                        @foreach($moreccategory as $mk=>$mnav)


                            @if($mnav->model=='links')
                                <li>
                                    <a href="{{$mnav->links}}">
                                        <em><img src="{{$mnav->thumb_url}}" alt="{{$mnav->name}}"></em>
                                        <p>{{$mnav->name}}</p>
                                    </a>
                                </li>

                            @else
                                <li>
                                    <a href="{{route($mnav->model.".links",["links"=>$mnav->links])}}">
                                        <em><img src="{{$mnav->thumb_url}}" alt="{{$mnav->name}}"></em>
                                        <p>{{$mnav->name}}</p>
                                    </a>
                                </li>


                            @endif

                        @endforeach
                    @endif



                </ul>
            </div>
        </div>

      {{--  <div class="index-nav-wrap">
            <div class="index-nav">
                <ul class="clear">
                    <li><a href="{{route("singlepage",["links"=>"about"])}}"> <em><img
                                        src="{{asset("mobile/static/images/index-hlf-icon7.png")}}" alt=""></em>
                            <p>关于我们</p>
                        </a></li>

                    <li><a href="{{route("user.recharge")}}"> <em><img
                                        src="{{asset("mobile/static/images/index-hlf-icon3.png")}}" alt=""></em>
                            <p>我要充值</p>
                        </a></li>
                    <li><a href="{{route("user.withdraw")}}"> <em><img
                                        src="{{asset("mobile/static/images/index-hlf-icon8.png")}}" alt=""></em>
                            <p>我要提现</p>
                        </a></li>
                    <li><a href="{{\Cache::get('AppDownloadUrl')}}"> <em><img
                                        src="{{asset("mobile/static/images/index-hlf-icon1.png")}}" alt=""></em>
                            <p>APP下载</p>
                        </a></li>
                </ul>
            </div>
        </div>--}}

    </div>

    <div class="noticewrapbg" style="position:relative;top:50px;">
        <div class="notice">
            <div class="title"></div>
            <div class="marquee" style="line-height:31px; font-size:14px">
                <ul style="margin-top: 0px;">
                    <marquee scrolldelay="200" onMouseOut="this.start()" onMouseOver="this.stop()">
                        <font color="red"> {{\App\Formatting::Format(\Cache::get('gg'))}}</font>
                    </marquee>
                </ul>
            </div>
        </div>
    </div>
    <div class="zs_lianjie" style="margin-top:50px;">
        @if($wapad['hongbao'])
            @foreach($wapad['hongbao'] as $ad)
                <a href="{{$ad->url}}"><img src="{{$ad->thumb_url}}"></a>
            @endforeach
        @endif

    </div>

    {{--视频播放--}}
    @if(\Cache::get('videoopen')=='开启')

        <script src="/mobile/public/html5media.min.js"></script>
        <div style="margin:0 auto;width:90%;">
            <video id="shakeVideo" autoplay="autoplay" controls="controls" webkit-playsinline="true" playsinline="true"
                   controlslist="nodownload" src="\uploads\{{\Cache::get('videourl')}}" width="100%"
                   hight="200px"></video>
        </div>
        <script>
            var video = document.getElementById("shakeVideo");
            video.play();
        </script>

    @endif
    {{--视频播放 end--}}


    {{--项目推荐列表--}}



                <div class="max">
                    <div class="platformData">

                        @foreach($ShowProducts as $Pro)


                            <div class="itemList xiang" @if($Pro->tzzt==1)style="background:url(/wap/cp/images/fullscale_ico.png) #ffffff center 220px  no-repeat;"@endif>
                                <a href="{{route("product",["id"=>$Pro->id])}}">
                                    <?php $Pro->tagcolor!=''?$tagcolor=$Pro->tagcolor:$tagcolor='background-color:#FF6A78;color:#F5F2F2;'?>
								   <?php if($Pro->wzone){
										echo '<div style="position:absolute;z-index:101;margin-top:5px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;'.$tagcolor.'">'.$Pro->wzone.'</div>';
									}?>
									
									<?php if($Pro->wztwo){
										echo '<div style="position:absolute;z-index:101;margin-top:30px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;'.$tagcolor.'">'.$Pro->wztwo.'</div>';
									}?>
									
									<?php if($Pro->wzthree){
										echo '<div style="position:absolute;z-index:101;margin-top:55px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;'.$tagcolor.'">'.$Pro->wzthree.'</div>';
									}?>


                                    <?php if($Pro->tzzt == -1){?>

                                    <?php if($Pro->countdownad!=''){
                                        echo '<div style="position:absolute;z-index:101;margin-top:125px;text-align:center; border-radius: 5px;width: 80%; margin-left:6%;'.$tagcolor.'">'.$Pro->countdownad.'</div>';
                                    }?>


                                    <?php if($Pro->countdown!=''){
                                        echo '<div style="position:absolute;z-index:101;margin-top:155px;text-align:center; border-radius: 5px;width: 80%; margin-left:6%;'.$tagcolor.'" id="djs'.$Pro->id.'"></div><script>getDate("'.$Pro->countdown.'","'.$Pro->id.'");</script>';
                                    }?>

                                    <?php } ?>

									
								   <img src="{{$Pro->pic}}" onerror="$(this).remove()">
                                    <h3>{{$Pro->title}}</h3>
                                    <ul class="items">
                                        <li class="right_item"><em class="project_item"><img src="{{asset("wap/cp/images/film_progress.png")}}"
                                                                                             alt=""></em>
                                            <span class="project_item2"><span class="item2_type">项目进度:</span><span class="item2_detail"><?php
                                                    if($Pro->tzzt == 1 ){
                                                        //已售罄
                                                        echo '已售罄';
                                                    }else if($Pro->tzzt == -1){
                                                        echo '待发布';
                                                    }else{
                                                        echo '进行中';
                                                    }?></span></span>
                                        </li>
                                        <li class="right_item"><em class="project_item">
                                                <img src="{{asset("wap/cp/images/film_level.png")}}"></em>
                                            <span class="project_item2">
 <span class="item2_type">推荐指数:</span>
 <img src="{{asset("wap/cp/images/film_level_5.png")}}" alt="">
 </span>
                                        </li>
                                    </ul>


                                    <div class="project-foot">&nbsp;&nbsp;项目分类：<span style="width:100%"><span class="red">
                                           {{$Pro->category_name}}
                                        </span>
                                    </span>
                                    </div>

                                    <div class="project-foot">&nbsp;&nbsp;还款方式：<span style="width:100%"><span class="red">
                                           <?php if ($Pro->hkfs == 0) { ?>
                                                    按天付收益，到期返本
                                                    <?php } elseif ($Pro->hkfs == 1) { ?>
                                                    到期还本,到期付息
                                                    <?php }elseif ($Pro->hkfs == 2) { ?>
                                                    按小时付收益，到期返本
                                                    <?php }elseif ($Pro->hkfs == 3) { ?>
                                                    按日付收益，到期返本 节假日照常收益
                                                    <?php }elseif ($Pro->hkfs == 4) { ?>
                                                    每日复利,保本保息
                                                    <?php } ?>
                                        </span>
                                    </span>
                                    </div>
                                    <div class="project-foot">
                                        &nbsp;&nbsp;起投金额：<span class="red">{{$Pro->qtje}}元</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        @if($Pro->hkfs == 4)

                                             总收益:<span
                                                        class="red">{{\App\Product::Benefit($Pro->id,$Pro->qtje)}} 元</span><br>

                                        @else

                                        @if(Cache::get('ShouYiRate')=='年')
                                            年化收益
                                        @else
                                            <?php if ($Pro->qxdw == '个小时') { ?> 时<?php } else { ?>日<?php } ?>化收益
                                        @endif:<span
                                                class="red">{{$Pro->jyrsy*$Pro->qtje/100}} 元</span><br>
                                        @endif

                                    </div>
                                    <div class="project-foot">
                                        &nbsp;&nbsp;项目规模：<span class="red">{{$Pro->xmgm}}万元</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;项目周期:<span
                                                class="red">{{$Pro->shijian}} {{$Pro->qxdw=='个小时'?'小时':'天'}}</span><br>
                                    </div>
                                    <div class="project-divProgress">
                                        <div class="label">项目进度：</div>
                                        <div class="divProgress">
                                            <div class="divProgressBar" data-progress="20"
                                                 style="background: linear-gradient(to right, rgb(255, 240, 0) 10%, rgb(255, 228, 0), rgb(255, 186, 0)); width: {{$Pro->xmjd}}%;"></div>
                                        </div>
                                        <div class="val">{{$Pro->xmjd}}%</div>
                                    </div>
                                    <div style="clear:both"></div>
                                </a>
                            </div>
                        @endforeach

                    </div>

                </div>




    {{--项目推荐列表 end--}}


    <style>


        .appdown {background: rgba(0,0,0,0.3) url(/uploads/{{\Cache::get('waplogo').'?t='.time()}}) no-repeat 10px center;
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

    </style>
    <script>
        window.onload = function(){
            var c = document.getElementById("close");
            c.onclick = function(){

                document.getElementById("appdown").style.display="none";

            }

        }

    </script>
    <div id="appdown" class="appdown" style="display: none;">
        <span class="left">{!!  \Cache::get('IndexTaotiaoAppText')!!}</span>
        <span class="appClose right" id="close">×</span>
        <a href="{{\Cache::get('AppDownloadUrl')}}" class="right appBtn">App客户端</a>

    </div>
    <script type="text/javascript">
        $(function() {
            isapp();
        });
        //判断是否在云打包的应用中
        function isapp() {
            var YundabaoUA = navigator.userAgent;//获取当前的useragent
            if (YundabaoUA.indexOf('CK 2.0') > -1){
                $("#appdown").hide();

            }else{
                $("#appdown").show();
            }
        }
    </script>
    {{--活动浮动广告--}}

    @if(Cache::get("IndexHoudong")=='开启')
        @if($wapad['houdong'])
            @foreach($wapad['houdong'] as $ad)
                <div class="huodongbg"
                     style="width:100%;height:2000px;position: fixed;top: 0;left:0;background-color: rgba(0,0,0,0.35);z-index: 9999999;">
                    <div style="width:300px;height:200px;position: fixed;top: 0;left:0;right:0;bottom:0;margin:auto;background-color: #666;">
                        <a href="javascript:;" onclick="$('.huodongbg').hide();"
                           style="width:110px;height:25px;line-height:25px;text-align: center;position:absolute;right: 5px;top: 10px;border: 1px solid #fff;color:#fff;border-radius:5px;">关闭活动广告
                            <!-- a-->
                        </a><a href="{{$ad->url}}" style="">
                            <img src="{{$ad->thumb_url}}" width="300px" height="200px">
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    @endif

    {{--活动浮动广告 END --}}
@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent

    {!! Cache::get("waptongjicode") !!}
@endsection

