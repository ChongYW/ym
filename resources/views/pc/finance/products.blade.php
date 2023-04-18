@extends('pc.finance.pc')

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
    <div style="background:url('/pc/finance/css/images/b2.png') center center no-repeat; height:100px; padding:0px;margin:auto; width:1190px; text-align:center; line-height:100px; font-size:32px; color:#FFF">理财产品</div>



    <div class="page-pd-tit">
        <ul class="clear">

            <li>
                <a href="{{route("products")}}" @if(Request::url()==route("products")) class="active" @endif>全部</a>
            </li>

            @if($ProCategory)
                @foreach($ProCategory as $proCat)
            <li>
                <a href="{{route("products.links",["links"=>$proCat->links])}}" @if(Request::url()==route($proCat->model.".links",["links"=>$proCat->links])) class="active" @endif>{{$proCat->name}}</a>
            </li>
                @endforeach
            @endif




        </ul>
    </div>



    <div class="cle p10"></div>

    <div class="titlecc"> <div class="title"><em>专属您的理财产品</em></div></div>


    <div style="min-width:1200px;">
        <div style="width:1200px; margin:auto;">
            <div class="work w1190">
                <ul>

                    @if($productsLists)
                        @foreach($productsLists as $Pro)


                        <li @if($Pro->tzzt==1)style="background:url(/pc/images/fullscale_ico.png) #ffffff center 255px  no-repeat;"@endif>

                            <a href="{{route("product",["id"=>$Pro->id])}}" target="_blank" class="img_a">
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
                                <a href="{{route("product",["id"=>$Pro->id])}}" target="_blank">
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
                    @endif





                </ul>
            </div>




        </div> </div>


    <div class="cle p10"></div>





@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

