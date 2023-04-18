@extends('mobile.default.wap')

@section("header")
    <div class="top" id="top" >
        <div class="kf">
            <p><a class="sb-back" href="javascript:history.back(-1)" title="返回"
                  style=" display: block; width: 40px;    height: 40px;
    margin: auto; background: url('{{asset("mobile/images/arrow_left.png")}}') no-repeat 15px center;float: left;
    background-size: auto 16px;font-weight:bold;">
                </a>
            </p>
            <div style="display: block;width:100%; position: absolute;top: 0;
     left: 0;text-align: center;  height: 40px; line-height: 40px; ">
                <a href="javascript:;" style="text-align: center;  font-size: 16px; ">{{\Cache::get('CompanyShort')}}</a>
            </div>

        </div>
    </div>




@endsection

@section("js")

    @parent
@endsection

@section("css")
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/user.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/index.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/public.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/style.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("wap/cp/css/index.css")}}"/>
    <style>
        .bd .conWrap .con{
            max-width:450px;
            min-width:320px!important;
            height:1430px!important;
            overflow:hidden;
            position:relative!important;

        }
        .bd .conWrap{
            height:auto!important;
            max-width:450px;
            min-width:320px;
        }
        .tzliebli {
            background: #fff;
            overflow: hidden;
            padding: 12px 0;
        }
        .tzliebli li {
            height: 50px;
            padding: 15px 0;
        }
        .tzliebli li a {
            display: block;
            height: 50px;
        }
        .tzliebli li a img {
            float: left;
            height: 50px;
            margin-left: 15px;
        }
        .tzliebli li a span {
            float: right;
            height: 50px;
            line-height: 50px;
            font-size: 20px;
            color: #666;
            font-weight: bold;
            font-family: "宋体";
            padding-right: 16px;
        }
        .tzliebli li font {
            float: left;
            font-size: 16px;
            padding-left: 10px;
            line-height: 24px;
        }
        .tzliebli li font b {
            display: block;
            font-weight: normal;
            font-size: 14px;
            color: #b8b8b8;
        }
    </style>

@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')

    <script type="text/javascript">

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

    </script>
    <script type="text/javascript">
        $(".header").remove();
    </script>
    <div class="shouyi"><img src="{{asset("mobile/img/shouyi.jpg")}}"></div>


    <div class="licaibox">
        <div class="bd">
            <div class="main">
                <div class="tzbox">
                    <div class="hd">
                        <div class="title">
                            <span>{{$category->name}}</span>

                        </div>
                    </div>


                    <div class="main_box">


                        @if($productsLists)



                                    <div class="max">
                                        <div class="platformData">

                                            @foreach($productsLists as $Pro)


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
                                                                <span class="project_item2"><span class="item2_type">项目进度:</span><span class="item2_detail">@if($Pro->tzzt==0) 进行中 @else 已投满 @endif</span></span>
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
                                                            &nbsp;&nbsp;起投金额：<span class="red">{{$Pro->qtje}}元</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@if($Pro->hkfs == 4)

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



                        @endif



                    </div>

                </div>


            </div>
        </div>

@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

