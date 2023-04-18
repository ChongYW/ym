@extends('pc.financev2.pc')

@section("header")
    @parent
@endsection

@section("js")
    @parent
@endsection

@section("css")
    @parent

@endsection



@section('body')

    <script type="text/javascript" src="{{asset("layim/layui.js")}}"></script>

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







        $(document).ready(function(){
            var layer;
            layui.use('layer', function(){
                layer =layui.layer;
            });

            @if(isset($_GET["gg"]) && $_GET["gg"]=='1')

            layui.use('layer', function(){
                layer =layui.layer;


                //信息框
                layer.open({
                    title:'系统公告',
                    content: '{!!  \App\Formatting::Format(\Cache::get('boxgg')) !!}'
                    ,btn: '关闭公告'
                });

            });

                    @endif

            var j=1;
            var MyTime=false;
            var fot=500;
            var fin=400;
            var amt=350;
            var speed=5000;
            var maxpic=$("#guang_ban ul li").length;
            var autostar=true;
            $("#guang_ban").find("li").each(function(i){
                $("#guang_ban").find("li").eq(i).mouseover(function(){
                    var cur=$("#fcimg").find("div:visible").prevAll().length;
                    var m=$("#guang_ban").find("li").eq(i).find("img").attr("src");
                    if(i!==cur){
                        j=i;
                        $("#fcimg").find("div:visible").fadeOut(fot,function(){
                            $("#fcimg").find("div").eq(i).fadeIn(fin);});
                        current(this,"li");
                    }
                    autostar=false;
                });
                $("#guang_ban").find("li").eq(i).mouseout(function(){autostar=true;});
            });
            function current(ele,tag){
                $(ele).addClass("crn").siblings(tag).removeClass("crn");
            }
            var MyTime=setInterval(function(){
                if(autostar){
                    $("#guang_ban").find("li").eq(j).mouseover();
                    autostar=true;
                    $("#fcimg div:visible").mouseover(function(){autostar=false;}).mouseout(function(){autostar=true;});
                    j++;
                    if(j==maxpic){
                        j=0;
                    }
                }} , speed);
            $(".header_top>ul>li").hover(function(){
                $(this).find(".two_sun").show();
                $(this).find(".two_sun1").show();
            },function(){
                $(this).find(".two_sun").hide();
                $(this).find(".two_sun1 ").hide();
            });
            $(".footer_l2>ul>li").hover(function(){
                $(this).find(".two_sun_foot").show();
                $(this).find(".two_sun_foot1").show();
            },function(){
                $(this).find(".two_sun_foot").hide();
                $(this).find(".two_sun_foot1").hide();
            });
            $(".nav>ul>li").hover(function(){
                $(this).find(".two_sun_invest").show();
            },function(){
                $(this).find(".two_sun_invest").hide();
            });
        });
    </script>


    <style>
        .banner{width: 100%; height: 350px; overflow:hidden;position: relative;}
        .banner #fcnum {bottom: 10px;left: 42%;position:absolute;margin:auto;width:1200px;}
        .banner #fcnum li{background:none repeat 0 0 #ffffff;border-radius:5px;float:left;height:11px;margin:0 4px;overflow:hidden;width:11px;}
        .banner #fcnum li.crn{background: none repeat 0 0 #e01418;}
        .wrap{margin:auto;position:relative;width:1200px;z-index:1000;}
        .main {height:auto;margin:0 auto;width: 1200px;}
        .banner-bar{position:absolute;right:0;top:40px;width:320px;height:270px;border-radius:10px;z-index:9999;
            background: url(/pc/finance/css/images/login_bg.png) no-repeat;
            text-align:left;
            left: 50%;
            top: 56px;
            margin-left: 260px;
        }
        .banner-bar .login{}
        .banner-bar .login .hd{padding:25px 30px 0;position:relative}
        .banner-bar .login .hd span{font-size:18px}
        .banner-bar .login .hd a{position:absolute;right:30px;top:28px;padding-right:15px;line-height:18px;background:url(/pc/finance/css/images/index_bg.png) right -11px no-repeat}
        .banner-bar .login .bd{padding-left:30px;padding-right:30px}
        .banner-bar .login .bd div{color:#FFF;font-family:"微软雅黑"}
        .banner-bar .login .bd .bd_title{margin-top:20px;text-align:left;font-size:18px;font-weight:400;color:#FFF}
        .banner-bar .login .bd .average{line-height:60px;font-size:14px;text-align:center}
        .banner-bar .login .bd .average span{color:#ff6600;font-size:40px}
        .banner-bar .login .bd .bd_content{font-size:13px;padding-bottom:5px;padding-top:5px;margin-bottom:20px;margin-top:10px;text-align:left;color:#FFF;border-bottom:1px solid #e1e1e1;border-top:1px solid #e1e1e1}
        .banner-bar .login .bd .bd_content em{color:#ff6600;font-size:20px;font-family:Tahoma,Geneva,sans-serif}
        .banner-bar .login .bd .bd_content span{font-size:18px;color:#ff6600;padding-bottom:30px}
        .banner-bar .login .bd .mod_input{height:65px;position:relative}
        .banner-bar .login .input_group .input_control.prepend input{width:200px}
        .banner-bar .login .bd .mod_input label{float:left;width:29px;height:40px;background:url(/pc/finance/css/images/index_bg.png) no-repeat}
        .banner-bar .login .bd .mod_input .tips{position:absolute;left:30px;top:12px;font-size:14px;color:#999}
        .banner-bar .login .bd .mod_input input{float:left;width:208px;height:38px;line-height:38px;font-size:14px;border:0;border-top:#ccc 1px solid;border-bottom:#ccc 1px solid}
        .banner-bar .login .bd .mod_input .rbg{float:left;width:4px;height:40px;background:url(/pc/finance/css/images/index_bg.png) -60px 0 no-repeat}
        .banner-bar .login .bd .mod_password label{background-position:-29px 0}
        .banner-bar .login .bd .fun{height:33px;padding-right:30px}
        .banner-bar .login .bd .fun label{width:70px;line-height:17px;float:left;color:#777;padding-left:18px;background:url(/pc/finance/css/images/index_bg.png) -386px -166px no-repeat;cursor:pointer}
        .banner-bar .login .bd .fun label.checked{background:url(/pc/finance/css/images/index_bg.png) -386px -120px no-repeat}
        .banner-bar .login .bd .fun span{position:relative;float:left;padding-left:120px}
        .banner-bar .login .bd .fun a{position:relative;float:right;color:#777}
        .banner-bar .login .bd .login_but{display:block;width:240px;height:40px;background:url(/pc/finance/css/images/index_bg.png) -82px 0 no-repeat;font-size:18px;font-family:"微软雅黑";color:#FFF;border:0;cursor:pointer;line-height:40px;text-align:center}
        .banner-bar .login .bd .login_but:hover{background-position:-82px -40px}
        .banner-bar .login .bd .share{padding-top:23px}
        .banner-bar .login .bd .share a{float:left;height:16px;line-height:16px;padding-left:18px;margin-right:22px}
        .sub01{width:100%;height:39px;line-height:39px;background:#ff6600;display:inline-block;text-align:center;color:#fff;font-size:18px;border-top:2px solid #ff6600;vertical-align:middle;border-radius:10px}
        .sub02{width:100%;height:37px;line-height:37px;background:#FFF;border:3px solid #ff6600;display:inline-block;text-align:center;color:#ff6600;font-size:18px;vertical-align:middle;border-radius:10px}
        .sub01:hover{color:#FFF}
        .login .bd ul li{width:155px;padding-right:3px;float:left}
        .login .bd ul li.loginfont{width:100px;padding:0}
        .login .bd ul li.liaccount{width:150px;padding-left:50px}
    </style>




    <div class="banner">
        <div class="banner-bar">
<span id="iframeindexlogin">
<div class="login">
      <div class="bd">
        <div class="bd_title">综合日化收益高达</div>
        <div class="average"><span>3%-18%</span></div>
        <div class="bd_content"><em>100%</em>本息保障,聪明人的选择</div>


         @if(isset($Member))
              <ul>
             <li><a href="{{route('user.index')}}" class="sub01">管理中心</a></li>
        <li class="loginfont"><a href="{{route('pc.loginout')}}" class="sub02">退出</a></li>
         </ul>

          @else
              <ul>
             <li><a href="{{route('pc.register')}}" class="sub01">免费注册</a></li>
        <li class="loginfont"><a href="{{route('pc.login')}}" class="sub02">立即登录</a></li>
         </ul>
          @endif


      </div>
    </div>

</span>
        </div>
        <div>
            <div class="guang_ban" id="guang_ban">
                <div id="fcimg">
                    @if($pcad['banner'])
                        @foreach($pcad['banner'] as $ad)
                            <div style="height: 350px;background-position: 50% 0px; background-repeat: no-repeat; background-image: url({{$ad->thumb_url}});"><a></a></div>
                        @endforeach
                    @endif


                </div>
                <ul id="fcnum">
                    @if($pcad['banner'])
                        @foreach($pcad['banner'] as $k=> $ad)
                            <li @if($k==0)class="crn"@endif></li>
                        @endforeach
                    @endif

                </ul>
            </div>
        </div>
    </div>



    <div class="noticewrapbg">
        <div class="notice">
            <div class="title"><a href="#">最新公告</a></div>
            <div class="marquee" style="line-height:39px; font-size:14px">
                <ul style="margin-top: 0px;"><marquee scrolldelay="200" onmouseout="this.start()" onmouseover="this.stop()">{{Cache::get('gg')}}</marquee></ul>
            </div>
        </div>
    </div>



    <div class="cle"></div>


    <div class="pageStructP4 mt-20">

        <div class="siteData-struct ">
            <div class="w1190 g-mlr-a g-fz-14">

                <li class="g-f-l item longTime" style="width:22%;">
                    <div class="borderR">

                        <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/css/style2.css")}}"/>
                              <div id="clock" class="light">
                            <div class="display">
                                <div class="date"></div>
                                <div class="digits"></div>
                            </div>
                        </div><script>
                            $(function(){
                                var clock = $('#clock');
                                //定义数字数组0-9
                                var digit_to_name = ['zero','one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
                                //定义星期
                                var weekday = ['周日','周一','周二','周三','周四','周五','周六'];
                                var digits = {};
                                //定义时分秒位置
                                var positions = [
                                    'h1', 'h2', ':', 'm1', 'm2', ':', 's1', 's2'
                                ];
                                //构建数字时钟的时分秒
                                var digit_holder = clock.find('.digits');
                                $.each(positions, function(){
                                    if(this == ':'){
                                        digit_holder.append('<div class="dots">');
                                    }
                                    else{
                                        var pos = $('<div>');
                                        for(var i=1; i<8; i++){
                                            pos.append('<span class="d' + i + '">');
                                        }
                                        digits[this] = pos;
                                        digit_holder.append(pos);
                                    }
                                });

                                // 让时钟跑起来
                                (function update_time(){
                                    //调用moment.js来格式化时间
                                    var now = moment().format("HHmmss");
                                    digits.h1.attr('class', digit_to_name[now[0]]);
                                    digits.h2.attr('class', digit_to_name[now[1]]);
                                    digits.m1.attr('class', digit_to_name[now[2]]);
                                    digits.m2.attr('class', digit_to_name[now[3]]);
                                    digits.s1.attr('class', digit_to_name[now[4]]);
                                    digits.s2.attr('class', digit_to_name[now[5]]);
                                    var date = moment().format("YYYY年MM月DD日");
                                    var week = weekday[moment().format('d')];
                                    $(".date").html(date + ' ' + week);
                                    // 每秒钟运行一次
                                    setTimeout(update_time, 1000);
                                })();
                            });
                        </script>
                    </div>
                </li>

                <div class="borderSty" id="usertzze">
                    <ul class="g-cf g-ptb-5">
                        <li class="g-f-l item">
                            <div class="borderR">
                                <p class="">累计投资金额</p>
                                <span class="num">420</span>亿<span class="num">
                       9944                       </span>万<span class="num">
                       6247                       </span>元
                            </div>
                        </li>
                        <li class="g-f-l item">
                            <div class="borderR">
                                <p class="">正在进行中投资金额</p>
                                <span class="num">275</span>亿<span class="num">
                       3947                       </span>万<span class="num">
                       4285                       </span>元
                            </div>
                        </li>
                        <li class="g-f-l item">
                            <div class="borderR">
                                <p class="">累计预期赚取收益</p>
                                <span class="num">128</span>亿<span class="num">
                       0559                       </span>万<span class="num">
                       3902                       </span>元
                            </div>
                        </li>
                        <li class="g-f-l item" style="width:18%;">
                            <p class="">累计注册智慧投资人</p>
                            <span class="num">342</span>万<span class="num">
                   5130                    </span>人
                        </li>
                    </ul>
                </div>
            </div>
        </div>






    </div>



    <style>
        .ind_tit {height: 40px;line-height: 40px;padding: 0 20px;border-bottom: 1px solid #f1f1f1;font-size: 16px;}
    </style>
    <div class="cle"></div>

    <div class="g-cf pageStructP5 w1190">
        <div class="g-f-r pageStructP5-R" style="width:300px;">
            <div class="vedio">

                @if(isset($Member))
                    <a href="{{route('user.index')}}" class="link1"  style="color:#ffffff;">管理中心</a>
                    <a href="javascript:qiandao();" class="link2"  style="color:#fff">签到</a>
                    <a href="{{route('pc.loginout')}}" class="link2"  style="color:#fff">退出</a>

                    <div class="module mb_10 new_box holiday_r_no2" style="height:225px; overflow:hidden;">
                        <h3 class="fs_16 ind_tit fl">会员信息</h3>
                        <div class="cle"></div>
                        <div class="clearfix tab_content index_login">

                            <div class="clearfix nr login_left" style="padding: 5px 50px 40px 31px;">
                                <div class="login_center ">

                                    <?php

                                    $buys=  \App\Productbuy::where("userid",$Member->id)->where("status","1")->orderBy("id","desc")->get();

                                    $daiShouyi=0;
                                    foreach ($buys as $By){
                                        $daiShouyi+=($By->amount)*(\App\Product::GetShouYi($By->productid)/100)*($By->sendday_count-$By->useritem_count);
                                    }
                                    ?>


                                    <div class="log_li">
                                        您好,<b style="color:#F00">{{$Member->username}}</b><br/>
                                        账户总额：
                                        <b style="color:#F00"><?php echo round($Member->amount+$Member->is_dongjie,2); ?></b>
                                        <br/>
                                        可用金额：<b class="red">￥<?php echo sprintf("%.2f",$Member->amount); ?></b>
                                        <br/>
                                        待收利息：<b class="red">￥{{sprintf("%.2f",$daiShouyi)}}</b>
                                    </div>

                                    <div class="log_li">
                                        <p>
                                            <input id="loginBt" name="管理中心" value="管理中心" onclick="location.href='{{route('user.index')}}'" type="button" class="index_login_btn">
                                        </p>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                @else

                <div class="module mb_10 new_box holiday_r_no2" style="height:245px; overflow:hidden;">
                    <h3 class="fs_16 ind_tit fl">会员登录</h3>
                    <div class="cle"></div>
                    <div class="clearfix tab_content index_login">

                        <div class="clearfix nr login_left" style="padding: 5px 50px 40px 31px;">
                            <div class="login_center ">



                                <div class="log_li">
                                    <input type="text" id="username" name="username" autocomplete="off" value="" placeholder="用户名/手机号" class="basic_input">
                                </div>
                                <div class="log_li">
                                    <input type="password" id="password" name="password" class="basic_input" placeholder="密码">
                                </div>
                                <div class="log_li" style="font-size:14px">
                                    <input type="checkbox" name="cookietime" value="2592000" id="cookietime"> 记住用户名
                                    <span class="fr"> <a href="{{route('pc.register')}}" class="forget_pwd">注册新账户</a></span>
                                </div>
                                <div class="login_warning" style="height:20px; line-height:20px;"><span id="tip"></span> </div>
                                <div class="log_li">
                                    <p>
                                        <input id="loginBt" name="登录" value="登 录" onclick="loginSubmit();" type="button" class="index_login_btn">
                                    </p>
                                </div>
                                <div class="log_li reg">
                                    <p>

                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                @endif
            </div>

            <script>

                function loginSubmit() {


                    var returnVal = $.ajax({
                        url: "{{route("pc.login")}}",

                        data:{
                            _token:"{{ csrf_token() }}",
                            username:$("#username").val(),
                            password:$("#password").val()
                        },
                        type: "POST",
                        async: false,
                        cache: 'false',
                        success: function(data) {

                            if (data.status) {
                                $("#errs").html(data.msg);
                                $("#errs").show();
                            }

                            layui.use('layer', function(){
                                var layer =layui.layer;
                            layer.open({
                                content: data.msg,
                                btn: '确定',
                                shadeClose: false,
                                yes: function(index){
                                    if(!data.status){
                                        if(data.url!=''){
                                            window.location.href=data.url;
                                        }else{
                                            window.location.href='{{route('user.index')}}';
                                        }

                                    }

                                    layer.close(index);
                                }
                            });
                            });

                        },
                        error: function(msg) {
                            $("#errs").html('网络异常，请重新提交');
                            $("#errs").show();
                        }
                    },'josn');

                }
            </script>

        </div>
        <div class="g-f-l pageStructP5-L">

            <ul class="siteProperty g-cf c_333">
                <li class="g-f-l item ">
                    <div class="warp borderSty clk">
                        <p class="g-ta-c icon"><span class="iconA1"></span></p>
                        <p class="g-ta-c f_s20 g-mb-10">收益高</p>
                    </div>
                </li>
                <li class="g-f-l item ">
                    <div class="warp borderSty">
                        <p class="g-ta-c icon"><span class="iconA2"></span></p>
                        <p class="g-ta-c f_s20 g-mb-10">门槛低</p>
                    </div>
                </li>
                <li class="g-f-l item ">
                    <div class="warp borderSty clk">
                        <p class="g-ta-c icon"><span class="iconA3"></span></p>
                        <p class="g-ta-c f_s20 g-mb-10">期限短</p>
                    </div>
                </li>
                <li class="g-f-l item ">
                    <div class="warp borderSty">
                        <p class="g-ta-c icon"><span class="iconA4"></span></p>
                        <p class="g-ta-c f_s20 g-mb-10">实力强</p>
                    </div>
                </li>
            </ul>

        </div>
    </div>


    <div class="cle"></div>

    <div class="cle p10"></div>


    {{--项目推荐列表--}}

    @if($ProductsCategory)
        @foreach($ProductsCategory as $PCategory)
            @if(count($PCategory->Products)>0)

                <div class="w1190 xian1"></div>

                <div class="tit_tab w1190">
                    <span class="sp" style="font-size:30px">{{$PCategory->name}}<span class="pc">:</span></span>
                    <span class="pc sp" style="float: right;color: #f60;">

                        @if($PCategory->model=='links')

                            <a href="{{$PCategory->links}}" class="hei" style="color: #f60;">点击更多</a>

                        @else

                            <a href="{{route($PCategory->model.".links",["links"=>$PCategory->links])}}" class="hei" style="color: #f60;">点击更多</a>

                        @endif
                    </span>
                </div>



                <div class="work w1190">
                    <ul>





                    @foreach($PCategory->Products as $Pro)
                            <li @if($Pro->tzzt==1)style="background:url(/pc/images/fullscale_ico.png) #ffffff center 255px  no-repeat;"@endif>

                                <a href="{{route("product",["id"=>$Pro->id])}}"  class="img_a">

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
                                        echo '<div style="position:absolute;z-index:101;margin-top:125px;text-align:center; border-radius: 5px;width: 300px; margin-left:40px;'.$tagcolor.'">'.$Pro->countdownad.'</div>';
                                    }?>


                                    <?php if($Pro->countdown!=''){
                                        echo '<div style="position:absolute;z-index:101;margin-top:155px;text-align:center; border-radius: 5px;width: 300px; margin-left:40px;'.$tagcolor.'" id="djs'.$Pro->id.'"></div><script>getDate("'.$Pro->countdown.'","'.$Pro->id.'");</script>';
                                    }?>

                                    <?php } ?>



									<img src="{{$Pro->pic}}" width="380" height="200">
                                </a>


                                <div class="info">
                                    <a href="{{route("product",["id"=>$Pro->id])}}" >
                                        <h3>{{\App\Formatting::Format($Pro->title)}}</h3>
                                        <ul class="right_list">
                                            <li class="right_item"> <em class="project_item"><img src="/pc/finance/css/images/film_progress.png" alt=""></em>
                                                <p class="project_item2"><span class="item2_type">项目进展:</span><span class="item2_detail"><?php
                                                        if($Pro->tzzt == 1 ){
                                                            //已售罄
                                                            echo '已售罄';
                                                        }else if($Pro->tzzt == -1){
                                                            echo '待发布';
                                                        }else{
                                                            echo '进行中';
                                                        }?></span></p>
                                            </li>
                                            <li class="right_item"> <em class="project_item"><img src="/pc/finance/css/images/film_level.png" alt=""></em>
                                                <p class="project_item2">
                                                    <span class="item2_type">推荐指数:</span>

                                                    <img src="/pc/finance/css/images/film_level_5.png" alt="">
                                                </p>
                                            </li>
                                        </ul>
                                        <p style="width:370px">保理机构：<?php echo $Pro->bljg; ?></p>
                                        <p style="width:370px">还款方式：<font color="#FF0000"><?php if ($Pro->hkfs == 0) { ?>
                                            按天付收益，到期返本
                                            <?php } elseif ($Pro->hkfs == 1) { ?>
                                            到期还本,到期付息
                                            <?php }elseif ($Pro->hkfs == 2) { ?>
                                            按小时付收益，到期返本
                                            <?php }elseif ($Pro->hkfs == 3) { ?>
                                            按日付收益，到期返本 节假日照常收益
                                            <?php }elseif ($Pro->hkfs == 4) { ?>
                                            每日复利,保本保息
                                            <?php } ?></font></p>

                                        @if($Pro->hkfs == 4)

                                            <p> 总收益:
                                                <font color="#FF0000">
                                                    {{\App\Product::Benefit($Pro->id,$Pro->qtje)}}
                                                </font>元</p>
                                        @else
                                            <p>

                                                @if(Cache::get('ShouYiRate')=='年')
                                                    年化收益
                                                @else
                                                    <?php if ($Pro->qxdw=='个小时') { ?> 时<?php } else { ?>日<?php } ?>化收益
                                                @endif:<font color="#FF0000">


                                                    {{$Pro->jyrsy*$Pro->qtje/100}}
                                                </font>元</p>
                                        @endif


                                        <p>项目进展：<?php
                                            if($Pro->tzzt == 1 ){
                                                //已售罄
                                                echo '已售罄';
                                            }else if($Pro->tzzt == -1){
                                                echo '待发布';
                                            }else{
                                                echo '进行中';
                                            }?></p>
                                        <p>项目规模：￥<big><i>{{$Pro->xmgm}}</i></big> 万元</p>
                                        <p>计划期限：<big><i>{{$Pro->shijian}}</i></big> {{$Pro->qxdw=='个小时'?'小时':'天'}}</p>
                                        <p>起投金额：￥<big><i>{{$Pro->qtje}}</i></big> 元</p>
                                        <p>剩余可投：<i>{{$Pro->xmgm-$Pro->xmgm*$Pro->xmjd/100}}</i> 万元</p>

                                    </a>
                                    <div class="item-progress">
                                        <div class="item-progress-bg">
                                            <div class="item-progress-bar" style="width:<?php echo $Pro->xmjd; ?>%"></div>
                                        </div>
                                        <i class="item-progress-num"><?php echo $Pro->xmjd; ?>%</i>
                                    </div>
                                </div>
                            </li>



                    @endforeach

                    </ul>
                </div>

            @endif

        @endforeach
    @endif

    {{--项目推荐列表 end--}}
    <div class="cle"></div>
    <!--三板资讯开始-->


    <div class="news">
        <div class="title1">
            <h2 class="h-h8">
                <a  href="{{route("articles.links",["links"=>"movienews"])}}">最新 · 影视资讯</a>
                <a class="ptype"  href="{{route("articles.links",["links"=>"movienews"])}}" style="margin-right: 50px;">更多资讯</a>
            </h2>
        </div>
        <br>
        <div class="news-list">
            <div>
                <div class="news-item">
                    <div class="newsr">
                        <img src="{{$CategoryThumb[2]}}" alt="影视资讯">
                    </div>
                    <div class="news-right">
                        <ul class="news-rlist">
                            @if($ArticleList[2])
                                @foreach($ArticleList[2] as $Article)


                                    <li class="news-ritem" style="float: left; width: 627px;line-height: 40px;margin:0px;">
                                        <em>
                                        </em>
                                        <a class="article" href="{{route("article",["id"=>$Article->id])}}"  >{{\App\Formatting::Format($Article->title)}}</a>
                                        <span>{{$Article->created_at}}</span>
                                    </li>

                                @endforeach

                            @endif




                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <style>


        /*资讯开始*/

        .news{ width: 1200px;   margin: 0 auto;/*margin-top:20px;*/}
        .news-plkd{ width: 1200px; height:382px; float: left;margin-top:30px;}

        .liucheng{ width: 1200px; height:355px; float: left;/*margin-top:20px;*/}

        .youshi{ width: 1200px; height:440px; float: left;/*margin-top:20px;*/}

        .title1 .ptype{ text-align: center;
            font-size: 14px;
            padding: 4px 30px 2px 30px;
            color: #ed5e58;
            border: 1px solid #ed5e58;
            display: inline-block;

            font-weight: bolder;
            float: right;}

        .title1 .ptype:hover{background-color: #f60;color: #fff;}

        .newsmes2-ts {
            text-align: center;
            padding: 45px 0px 20px 0px;
            font-size: 20px;
            color: #999;
        }

        .plkd-tit2{line-height: 40px;  width: 100%;  /*border-bottom: 1px solid #ccc;  color: #0B1F3C; */ float: left;  text-indent: 1em;  font-weight: bold;  font-size: 18px;  background-color: white;}

        .news-list{ width: 1198px; height: 360px; float: left; border:1px solid #ccc;}

        .news-list2{ width: 1198px; height: 340px; float: left; border:1px solid #ccc;background-color:white;}

        .news-nav{ width:1198px; height: 45px; line-height: 45px; text-align: center; border-bottom:1px solid #ccc;float: left; font-size: 14px;}

        .nav-item{ width: 98px; float: left; cursor:pointer;}

        .nav-item2{ width: 98px; float: left; cursor:pointer;border-left: 1px solid #ccc;  border-right: 1px solid #ccc;  border-top-right-radius: 5px;}

        .select{ border-top: 2px solid #f89901; border-left: 1px solid #ccc; border-right: 1px solid #ccc; background-color: #fff; height: 45px;}

        .news-item{ width: 1200px; height: 362px; float: left;}

        .news-item2{ width: 100%; height: 290px; float: left;}

        .news-item1{ width:570px; height: 270px;margin-top: 20px; float: left;border-right: 1px solid #ccc;}

        .news-item2{ width:100%; height: 270px;margin-top: 20px; float: left;}
        .news1{ margin-left: 20px; float: left; margin-top:10px;}

        .newsp{width:180px; height:110px; float: left; margin-right: 10px;}

        .plkd-news2{width:95%;height:95%;margin-left:10px;}

        .plkd-newsp{width:250px; height:250px; float: left;}

        .newsp img{width:180px; height:110px;}

        .plkd-newsp img{width:250px; height:250px;margin-left:10px;}

        .newsmes{ width: 330px; height:120px; float: left;}
        .newsmes2{ width: 73%; height:250px; float: left;margin-left:50px;}

        .newsmes h1{ font-weight: normal; font-size: 16px;}

        .newsmes p{ font-size: 14px; margin-top: 5px; color: #999;}

        .newsmes p a{ color: #f89901;}

        .news-right{ float: right;        width: 627px;}

        .news-rlist{
            width: 627px;
            height: 340px;
            padding-top: 20px;
            display: block;
            float:left;
        }

        .news-ritem li {
            float: left;
            width: 627px;
            line-height: 24px;

        }

        .newsr{
            width: 550px;
            height: 320px;
            float: left;
            padding-left: 20px;
            padding-top: 20px;
        }

        .news-ritem{width: 627px; height: 40px; line-height: 40px; float:left; font-size: 14px;}

        .news-ritem em{ width:20px; height:40px; display: block; background: url(/pc/images/icon_4.png) center no-repeat; float: left; margin-left: 25px;}

        .news-ritem span{ float: right; margin-right:15px; color: #999;}

        /*资讯结束*/

    </style>
    <!--三板资讯开始end-->



    <div class="media_list_bg" style="margin-top:40px;">
        <div class="media_list_content">
            <div class="media_list_left">
                <h3><span style="float:right;"><a href="{{route("articles.links",["links"=>"licainews"])}}" style="font-size:12px; margin-right:15px;" >&gt;&gt;更多</a></span>理财要闻</h3>
                <div class="tList_mdu2 twit_list">
                    <ul class="d0213-list">

                        @if($ArticleList[0])
                            @foreach($ArticleList[0] as $Article)
                        <a class="list" href="{{route("article",["id"=>$Article->id])}}">
                            <i></i>
                            <span class="l">{{\App\Formatting::Format($Article->title)}}</span>
                            <span class="r" f12="" mr20="" cgraya=""></span>
                        </a>
                            @endforeach

                        @endif




                    </ul>
                </div>
            </div>
            <div class="media_list_middle">
                <h3><span style="float:right;"><a href="{{route("articles.links",["links"=>"news"])}}" style="font-size:12px; margin-right:15px;" >&gt;&gt;更多</a></span>新闻动态</h3>
                <div class="tList_mdu2 twit_list">
                    <ul class="d0213-list">

                        @if($ArticleList[1])
                            @foreach($ArticleList[1] as $Article)
                                <a class="list" href="{{route("article",["id"=>$Article->id])}}">
                                    <i></i>
                                    <span class="l">{{\App\Formatting::Format($Article->title)}}</span>
                                    <span class="r" f12="" mr20="" cgraya=""></span>
                                </a>
                            @endforeach

                        @endif


                    </ul>
                </div>
            </div>
            <div class="meida_list_right">
                <h3><span style="float:right;"></span>投资排行榜</h3>
                <div class="tList_mdu2 twit_list">
                    <div class="d0213-list">
                        <ul class="order_list" id="tdd2">
                            <li style="text-indent:0px;">排名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户名                       <span>投资金额</span></li>

                            @if($top)
                                @foreach($top as $k=> $d)
                            <li class="list_fist_{{$k+1}}">

                               {{$d['mobile']}}<span> ￥{{sprintf("%.2f",$d['amounts'])}}</span>
                            </li>
                                @endforeach
                            @endif

                            </ul></div></div>
            </div>
        </div>
    </div>

@if(Cache::get('BoxOffice')=='开启')

    <div class="contain1" style="height:auto;margin: 0 auto;width: 1200px;">
        <div class="gua1">
            <div class="title1">
                <h2 class="h-h8">
                    <a href="javascript:void(0)" rel="nofollow">
                        实时 · 票房数据
                    </a>
                </h2>
            </div><br>
            <iframe src="https://piaofang.maoyan.com/dashboard" width="1200" height="600" frameborder="0" scrolling="no"></iframe>
        </div>

    </div>


    @if($pcad['bottombanner'])
        @foreach($pcad['bottombanner'] as $ad)
            <div class="xbanner" style="width: 1200px;margin: 10px auto;">
                <a href="{{$ad->url}}" rel="nofollow" >
                    <img src="{{$ad->thumb_url}}">
                </a>
            </div>
        @endforeach
    @endif



@endif

    <div class="cle"></div>

    <center><img src="/pc/finance/css/images/lc.png"></center>

    <div class="cle p10"></div>


    <div class="clearfix fluid" style="width:1200px; margin:auto">
        <div class="module ind_media s_holidy_main_no6">

            <div class="titlecc" style="border-bottom:none"> <div class="title"><em>合作媒体</em></div></div>
            <div class="module ind_media s_holidy_main_no6">
                <ul class="clearfix ind_media_box">

                    @if(isset($pcad['hzmt']))
                    @foreach($pcad['hzmt'] as $hzmt)
                    <a href="{{$hzmt->url}}" >
                        <li>
                            <img src="{{$hzmt->thumb_url}}" width="142" height="45" style="border:1px solid #ececec;">
                        </li>
                    </a>

                        @endforeach
                    @endif





                </ul>
            </div> </div>
    </div>


    <div class="cle"></div>

    <script>


        $("a.article").each(function () {
            $(this).text( cutstr($(this).text(),50));
        });

        $("span.l").each(function () {
            $(this).text( cutstr($(this).text(),50));
        });
    /**
    * js截取字符串，中英文都能用
    * @param str：需要截取的字符串
    * @param len: 需要截取的长度
    */
    function cutstr(str, len) {
    var str_length = 0;
    var str_len = 0;
    str_cut = new String();
    str_len = str.length;
    for (var i = 0; i < str_len; i++) {
    a = str.charAt(i);
    str_length++;
    if (escape(a).length > 4) {
    //中文字符的长度经编码之后大于4
    str_length++;
    }
    str_cut = str_cut.concat(a);
    if (str_length >= len) {
    str_cut = str_cut.concat("...");
    return str_cut;
    }
    }
    //如果给定字符串小于指定长度，则返回源字符串；
    if (str_length < len) {
    return str;
    }
    }

    /**倒计时方法**/


/*
    function tow(n) {
        return n >= 0 && n < 10 ? '0' + n : '' + n;
    }


    function getDate(timer,Obj) {
            var oDate = new Date();//获取日期对象
            var oldTime = oDate.getTime();//现在距离1970年的毫秒数
            var newDate = new Date(timer);
            var newTime = newDate.getTime();//2019年距离1970年的毫秒数
            var second = Math.floor((newTime - oldTime) / 1000);//未来时间距离现在的秒数
            var day = Math.floor(second / 86400);//整数部分代表的是天；一天有24*60*60=86400秒 ；
            second = second % 86400;//余数代表剩下的秒数；
            var hour = Math.floor(second / 3600);//整数部分代表小时；
            second %= 3600; //余数代表 剩下的秒数；
            var minute = Math.floor(second / 60);
            second %= 60;
            var str = tow(day) + '<span class="time">天</span>'
                + tow(hour) + '<span class="time">小时</span>'
                + tow(minute) + '<span class="time">分钟</span>'
                + tow(second) + '<span class="time">秒</span>';
        $("#"+Obj).html(str);

        setInterval(getDate(timer,Obj), 1000);
    }

*/




    </script>

    {{--活动浮动广告--}}

    @if(Cache::get("IndexHoudong")=='开启')
        @if($pcad['houdong'])
            @foreach($pcad['houdong'] as $ad)
                <div class="huodongbg"
                     style="width:100%;height:4000px;position: fixed;top: 0;left:0;background-color: rgba(0,0,0,0.35);z-index: 9999999;">
                    <div style="width:600px;height:400px;position: fixed;top: 0;left:0;right:0;bottom:0;margin:auto;background-color: #666;">
                        <a href="javascript:;" onclick="$('.huodongbg').hide();"
                           style="width:110px;height:25px;line-height:25px;text-align: center;position:absolute;right: 5px;top: 10px;border: 1px solid #fff;color:#fff;border-radius:5px;">关闭活动广告
                            <!-- a-->
                        </a><a href="{{$ad->url}}" style="">
                            <img src="{{$ad->thumb_url}}" width="600px" height="400px">
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
@endsection

