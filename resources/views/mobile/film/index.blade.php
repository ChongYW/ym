@extends('mobile.film.wap')

@section("header")
    <header>
        <img src="\uploads\{{\Cache::get('waplogo').'?t='.time()}}" height="95%">
        @if(!isset($Member))
            <a href="{{route("wap.login")}}" class="headerRight">登录/注册</a>
        @endif
    </header>
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

    <script type="text/javascript">



        $(document).ready(function() {
            var layer;
            layui.use('layer', function () {
                layer = layui.layer;
            });
        });
    </script>

    {{-- 手机首页幻灯片 --}}

    <div id="banner" class="swiper-container-horizontal" style="margin-top: 50px;">
        <div class="swiper-wrapper">

            @if($wapad['banner'])
                @foreach($wapad['banner'] as $ad)
                    <div class="swiper-slide"><img src="{{$ad->thumb_url}}"></div>
                @endforeach
            @endif

        </div>

    </div>

    <a href="/" class="divider notice" style="border-bottom: 1px #CCCCCC solid;">
        <div id="fabiaoContent">
            <marquee scrolldelay="200" onmouseout="this.start()" onmouseover="this.stop()">
                <span style="font-size:18px;">
                    <div><span style="font-size:12px;"><span style="color:#daa520;">
                                <strong>
                                    {{\App\Formatting::Format(\Cache::get('gg'))}}
                                </strong></span></span></div></span>
            </marquee>
        </div>
    </a>


    <script type="text/javascript">
        window.onload = function () {
            var mySwiper1 = new Swiper('#banner', {
                autoplay: 5000,
                visibilityFullFit: true,
                autoplayDisableOnInteraction: false,
                loop: true,
                pagination: '.pagination',
            });
        }
    </script>

    {{-- 手机首页幻灯片end  --}}



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
        layui.use('layer', function () {
            var layer = layui.layer;

            //公告信息框
            layer.open({
                title: '系统公告',
                content: '{{\App\Formatting::Format(\Cache::get('boxgg'))}}'
                , btn: '关闭公告'
            });
        });
        @endif


    </script>




    <div class="index-nav-wrap" style="padding-top:10px;">
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
    <div class="index-nav-wrap"></div>






{{--

    <div class="zs_lianjie" style="margin-top:50px;">
        @if($wapad['hongbao'])
            @foreach($wapad['hongbao'] as $ad)
                <a href="{{$ad->url}}"><img src="{{$ad->thumb_url}}"></a>
            @endforeach
        @endif

    </div>
--}}

    {{--视频播放--}}
    @if(\Cache::get('videoopen')=='开启')

        <script src="/mobile/public/html5media.min.js"></script>
        <video id="shakeVideo" autoplay="autoplay" controls="controls" webkit-playsinline="true" playsinline="true"
               controlslist="nodownload" src="\uploads\{{\Cache::get('videourl')}}" width="100%" hight="200px"></video>

        <script>
            var video = document.getElementById("shakeVideo");
            video.play();
        </script>

    @endif
    {{--视频播放 end--}}




    {{--项目推荐列表--}}



        <div class="max">



            <div class="newtit">
                <div class="x_gg_l  color " onclick="nav('all',$(this))">
                    <b>全部</b>
                </div>

                @if($ProductsCategory)
                    @foreach($ProductsCategory as $Ckey=>$CategoryList)



                        <div class="x_gg_l" onclick="nav('{{$CategoryList->links}}',$(this))">
                           <b>{{$CategoryList->name}}</b>
                        </div>



                    @endforeach
                @endif

            </div>

            <div class="platformData PCategoryall"   >



            </div>

        @if($ProductsCategory)
            @foreach($ProductsCategory as $Ckey2=> $PCategory)
                @if(count($PCategory->Products)>0)




                        <div class="platformData PCategory{{$PCategory->links}}"  style="display: none;" >




                        @foreach($PCategory->Products as $Pro)



                        <a href="{{route("product",["id"=>$Pro->id])}}">
                            <div class="itemList">
                                <div class="project-cont" @if($Pro->tzzt==1)style="background: url(/wap/image/js.png) no-repeat 130px bottom;background-size: 130px;"@endif>
                                    <div class="project-img">
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
                                            echo '<div style="position:absolute;z-index:101;margin-top:125px;text-align:center; border-radius: 5px;width: 75%; margin-left:10%;'.$tagcolor.'">'.$Pro->countdownad.'</div>';
                                        }?>


                                    <?php if($Pro->countdown!=''){
                                            echo '<div style="position:absolute;z-index:101;margin-top:155px;text-align:center; border-radius: 5px;width: 75%; margin-left:10%;'.$tagcolor.'" id="djs'.$Pro->id.'"></div><script>getDate("'.$Pro->countdown.'","'.$Pro->id.'");</script>';
                                        }?>

                                    <?php } ?>

                                        <img src="{{$Pro->pic}}">
                                    </div>
                                    <div class="project-list" >
                                        <ul>
                                            <li>
                                                项目名称：<em>{{$Pro->title}}</em>
                                            </li>

                                            <li>
                                                项目状态：<em>@if($Pro->tzzt==-1)待开放@elseif($Pro->tzzt==0)投资中@elseif($Pro->tzzt==1)已投满@endif</em>
                                            </li>
                                            <li>
                                                项目规模：<em>
                                                    {{$Pro->xmgm}}万元&nbsp;
                                                    @if($Pro->hkfs==0)
                                                    按天付收益，到期还本
                                                    @elseif($Pro->hkfs==1)
                                                    按周期付收益，到期还本
                                                    @elseif($Pro->hkfs==2)
                                                    按时付收益，到期还本
                                                    @elseif($Pro->hkfs==3)
                                                    按天付收益，等额本息返还
                                                    @elseif($Pro->hkfs == 4)
                                                     每日复利,保本保息
                                                    @endif
                                                </em>
                                            </li>
                                            <li>
                                                起投金额：<em>{{$Pro->qtje}}元</em>
                                            </li>
                                            <li>
                                                @if($Pro->hkfs == 4)

                                                    总收益：<em class="red">
                                                        {{\App\Product::Benefit($Pro->id,$Pro->qtje)}} 元
                                                    </em>

                                                @else

                                                    @if(Cache::get('ShouYiRate')=='年')
                                                    年化收益
                                                    @else
                                                    <?php if ($Pro->qxdw == '个小时') { ?> 时<?php } else { ?>日<?php } ?>化收益
                                                    @endif
                                                        ：<em
                                                            class="red">{{$Pro->jyrsy*$Pro->qtje/100}} 元</em>
                                                @endif

                                            </li>
                                            <li>
                                                释放周期：<em>{{$Pro->shijian}}&nbsp;{{$Pro->qxdw=='个小时'?'小时':'天'}}</em>
                                            </li>
                                            <li>
                                                <em>
                                                    <span class="li-title">项目进度：</span>
                                                    <span class="jdt1">&nbsp;&nbsp;</span>
                                                    <span class="jdt"><i style="width:{{$Pro->xmjd}}%"></i></span>
                                                    <span class="jdt3">{{$Pro->xmjd}}%</span>
                                                </em>
                                            </li>
                                            <div class="clear"></div>
                                        </ul>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </a>





                        @endforeach

                        </div>
                @endif

            @endforeach
        @endif

        </div>

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

    <p><br/></p>
    <p><br/></p>
    {{--项目推荐列表 end--}}
    <script>

        function qiandao() {
            @if(isset($Member))
            var _token = "{{ csrf_token() }}";
            $.ajax({
                url: '{{route('user.qiandao')}}',
                type: 'post',
                data: {_token:_token},
                dataType: 'json',
                error: function () {
                },
                success: function (data) {
                    layer.open({
                        content: data.msg,
                        time:2000,
                        shadeClose: false,

                    });
                }
            });
            @else
            layer.open({
                content: '请先登录再签到',
                time:2000,
                shadeClose: false,

            });
            @endif
        }

    </script>

<script>
    var _AllHtml='';
    $(".platformData").each(function () {


        if($(this).index()>1){
            _AllHtml+=$(this).html();
        }




    });
    $(".platformData").eq(0).html(_AllHtml);

    function nav(obj,nav) {
        $(".platformData").hide();
        $(".PCategory"+obj).show();
        $(".x_gg_l").removeClass('color');
        $(nav).addClass('color');
    }
</script>
<style>
    .newtit div.color b{
        color: red;
    }


    .project-cont .project-img {
        width: 100%;
        float: left;
        padding: 5px;

    }
    .project-cont .project-list {
        width: 100%;

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
@endsection


@section("footbox")
    @parent
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

