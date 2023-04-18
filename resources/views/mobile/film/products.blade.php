@extends('mobile.film.wap')

@section("header")

    <header>
        <a href="javascript:history.go(-1);"><img src="{{asset("mobile/film/images/back.png")}}" class="left backImg"></a>
        <span class="headerTitle">我要投资</span>
        <a href="{{route("user.index")}}" class="headerRight"><img src="{{asset("mobile/film/images/touxiang.png")}}" height="33" style="float:right;vertical-align: middle; margin-top:5px; padding-left:5px;"></a>
    </header>

@endsection

@section("js")
    @parent
    <script src="{{asset("mobile/film/js/flexible.js")}}"></script>
    <script src="{{asset("mobile/film/js/iscroll.js")}}"></script>
    <script src="{{asset("mobile/film/js/navbarscroll.js")}}"></script>

@endsection

@section("css")

    @parent


@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')

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





    </script>

    <div class="max">
        <div class="wrapper wrapper02" id="wrapper02">
            <div class="scroller">
                <ul class="clearfix">
                    <li class="cur" style="margin-left: 0px; margin-right: 0px;"><a href="{{route("products")}}">全部项目</a></li>

                    @if($ProductsCategoryList)
                        @foreach($ProductsCategoryList as $CategoryList)


                            @if($CategoryList->model=='links')

                                <li style="margin-left: 0px; margin-right: 0px;"><a href="{{$CategoryList->links}}">{{$CategoryList->name}}</a></li>

                            @else

                                <li style="margin-left: 0px; margin-right: 0px;"><a href="{{route($CategoryList->model.".links",["links"=>$CategoryList->links])}}">{{$CategoryList->name}}</a></li>
                            @endif


                        @endforeach
                    @endif


                </ul>
            </div>
        </div>



        <div class="platformData">

            @foreach($AllProducts as $Pro)
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
                        <div class="project-list">
                            <ul>
                                <li>
                                    电影名称：<em>{{$Pro->title}}</em>
                                </li>
                                <li>
                                    项目状态：<em>@if($Pro->tzzt==-1)待开放@elseif($Pro->tzzt==0)投资中@elseif($Pro->tzzt==1)已投满@endif</em>
                                </li>
                                <li>
                                    项目规模：<em>
                                        {{$Pro->xmgm}}万元
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
    </div>
<style>


    .project-cont .project-img {
        width: 100%;
        float: left;
        padding: 5px;

    }
    .project-cont .project-list {
        width: 100%;

    }
</style>
    <script type="text/javascript">
        $(function(){
            //demo示例一到四 通过lass调取，一句可以搞定，用于页面中可能有多个导航的情况
            $('.wrapper').navbarscroll({
                defaultSelect:0
            });
        });
    </script>
@endsection
@section('footcategoryactive')
    <script type="text/javascript">
        $("#menu1").addClass("active");
    </script>
@endsection

@section('footcategory')
    @parent
@endsection

@section("footer")
    @parent
@endsection

