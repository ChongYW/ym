@extends('mobile.bluev3.wap')



@section("js")
    @parent
    <script src="{{asset("mobile/bluev3/newindex/js/slider.js")}}"></script>
@endsection

@section("css")
    @parent
    <link rel="stylesheet" href="{{asset("mobile/bluev3/css/div3.css")}}"/>
    <link rel="stylesheet" href="{{asset("mobile/bluev3/newindex/css/div4.css")}}"/>
@endsection

@section("header")

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


            @if(\Cache::get('gg1')=='开启')
        layui.use('layer', function () {
            var layer = layui.layer;


//var wz='<pre><img src="/uploads{{\App\Formatting::Format(\Cache::get('boxggimg'))}}">{{\App\Formatting::Format(\Cache::get('boxgg'))}}</pre>';


            //公告信息框
            layer.open({
                skin:'ggg',
             //     offset:['0px','auto'] ,
                title: '系统公告',
                content: '<img src="/uploads{{\App\Formatting::Format(\Cache::get('boxggimg'))}}">{{$gg}}'
                , btn: '关闭公告'
            });
        });
       @endif


    </script>

<style>
    .ggg {
        top:15% !important;
    }
    
    
</style>
    <div class="mobile">

        <section class="aui-flexView">
            <header class="aui-navBar aui-navBar-fixed">
                <div class="aui-money-user">
                    <a href="{{route('user.index')}}">
                        @if(!isset($Member))
                            <img  src="{{asset("mobile/bluev3/newindex/img/user.png")}}" />
                            @else
                            <img  src="{{asset("mobile/bluev3/newindex/img/user.png")}}" class="gray"/>
                        @endif
                    </a>
                </div>
                <a href="{{route('m.index')}}" class="aui-navBar-item" style="min-width:60%">
                    <b>欢迎来到{{Cache::get('CompanyShort')}}</b>
                </a>
               @if(!isset($Member))
                    <a href="{{route("wap.login")}}" class="headerRight">登录/注册</a>
                @endif

            </header>
<style>

    .aui-navBar-item22 {
    height: 44px;
    width: 15px;
    -webkit-box-flex: 0;
    -webkit-flex: 0 0 25%;
    -ms-flex: 0 0 25%;
    flex: 0 0 25%;
    padding: 0 0.1rem;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    font-size: 0.3rem;
    white-space: nowrap;
    overflow: hidden;
    color: #ffffff;
    position: relative;
    letter-spacing: 1px;
    }
</style>
            <section class="aui-scrollView">


                @if(!isset($Member))
                    <div class="aui-finance-box">
                        <div class="aui-finance-fun">
                            <div class="aui-finance-fun-hd">
                                <h2>昨日<span style="color:#f75406;font-size: 16px;font-weight: bold;">分红</span>总额(元)</h2>
                                <h3 style="color:#fff;">{{Cache::get('DividendsYesterday')}}</h3>
                                <h4>银行监管&nbsp&nbsp满额提现&nbsp&nbsp秒速到账</h4>
                            </div>
                            <div class="aui-finance-fun-bd">
                                <div class="dot">
                                    <div class="dot2">
                                        <div class="dot3">
                                            <a href="{{route('user.index')}}" style="color: #fe6830;">申请</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="aui-palace" id="showDiv" >

                    @if($moreccategory)
                        @foreach($moreccategory as $mk=>$mnav)


                            @if($mnav->model=='links')
                                    <a href="{{$mnav->links}}" class="aui-palace-grid">
                                        <div class="aui-palace-grid-icon"><img src="{{$mnav->thumb_url}}" alt="{{$mnav->name}}"></div>
                                        <div class="aui-palace-grid-text"><h2>{{$mnav->name}}</h2></div>
                                    </a>


                            @else
                                    <a href="{{route($mnav->model.".links",["links"=>$mnav->links])}}" class="aui-palace-grid">
                                        <div class="aui-palace-grid-icon"><img src="{{$mnav->thumb_url}}" alt="{{$mnav->name}}"></div>
                                        <div class="aui-palace-grid-text"><h2>{{$mnav->name}}</h2></div>
                                    </a>

                            @endif

                        @endforeach
                    @endif
                    </div>

                    <div class="divHeight"></div>
                    <div class="m-slider" data-ydui-slider>
                        <div class="slider-wrapper">
                            @if($wapad['banner'])
                                @foreach($wapad['banner'] as $ad)
                                    <div class="slider-item" style="width: 350px;"><a href="{{$ad->url}}"><img src="{{$ad->thumb_url}}" ></a></div>
                                @endforeach
                            @endif


                        </div>
                    </div>


            @else

                    <!--banner-->

                        <div class="m-slider" data-ydui-slider>
                            <div class="slider-wrapper">
                                @if($wapad['banner'])
                                    @foreach($wapad['banner'] as $ad)
                                        <div class="slider-item" style="width: 350px;"><a href="{{$ad->url}}"><img src="{{$ad->thumb_url}}" ></a></div>
                                    @endforeach
                                @endif


                            </div>
                        </div>

                    <!--end banner-->
                        <div class="aui-palace" id="showDiv" >

                            @if($moreccategory)
                                @foreach($moreccategory as $mk=>$mnav)


                                    @if($mnav->model=='links')
                                        <a href="{{$mnav->links}}" class="aui-palace-grid">
                                            <div class="aui-palace-grid-icon"><img src="{{$mnav->thumb_url}}" alt="{{$mnav->name}}"></div>
                                            <div class="aui-palace-grid-text"><h2>{{$mnav->name}}</h2></div>
                                        </a>


                                    @else
                                        <a href="{{route($mnav->model.".links",["links"=>$mnav->links])}}" class="aui-palace-grid">
                                            <div class="aui-palace-grid-icon"><img src="{{$mnav->thumb_url}}" alt="{{$mnav->name}}"></div>
                                            <div class="aui-palace-grid-text"><h2>{{$mnav->name}}</h2></div>
                                        </a>

                                    @endif

                                @endforeach
                            @endif
                        </div>
               @endif

                    <div class="aui-flex aui-flex-color">
                        <div class="aui-news-sml">
                            <img src="{{asset("mobile/bluev3/newindex/img/news.gif")}}">
                        </div>
                        <div class="notice2">
                            <ul id="jsfoot02" class="noticTipTxt">
                                {!!  \App\Formatting::Format(\Cache::get('NoticTipTxt2'))!!}

                            </ul>
                        </div>
                    </div>
                       {{--视频播放--}}
    @if(\Cache::get('videoopen')=='开启')

        <script src="/mobile/public/html5media.min.js"></script>
        <div style="margin:0 auto;width:90%;">
            <video id="shakeVideo" controls="controls" webkit-playsinline="true" playsinline="true"
                   controlslist="nodownload" src="\uploads\{{\Cache::get('videourl')}}" width="100%"
                   hight="200px"></video>
        </div>
        <script>
            var video = document.getElementById("shakeVideo");
            //video.play();
        </script>

    @endif
    {{--视频播放 end--}}


                    <script type="text/javascript" src="{{asset("mobile/bluev3/notice/js/scrolltext.js")}}"></script>
                    <script type="text/javascript">
                        if(document.getElementById("jsfoot02")){
                            var scrollup = new ScrollText("jsfoot02");
                            scrollup.LineHeight = 22;        //单排文字滚动的高度
                            scrollup.Amount = 1;             //注意:子模块(LineHeight)一定要能整除Amount.
                            scrollup.Delay = 60;             //延时
                            scrollup.Start();                //文字自动滚动
                            scrollup.Direction = "up";       //默认设置为文字向上滚动
                        }
                    </script>



                  <a href="{{route('products')}}">
                        <div class="aui-flex aui-flex-title b-line">
                            <div class="aui-flex-box">
                                <h2>投资项目</h2>
                            </div>
                        </div>
                    </a>
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
                        <a class="tier" href="{{route("product",["id"=>$Pro->id])}}">
                            <div class="img-box" @if($Pro->tzzt==1)style="background: url(/wap/image/js.png) no-repeat 130px bottom;background-size: 130px;"@endif >


                                


                                <?php if($Pro->tzzt == -1){?>

                                    <?php if($Pro->countdownad!=''){
                                    echo '<div style="position:absolute;z-index:101;margin-top:100px;text-align:center; border-radius: 5px;width: 75%; margin-left:10%;'.$tagcolor.'">'.$Pro->countdownad.'</div>';
                                }?>


                                    <?php if($Pro->countdown!=''){
                                    echo '<div style="position:absolute;z-index:101;margin-top:130px;text-align:center; border-radius: 5px;width: 75%; margin-left:10%;'.$tagcolor.'" id="djs'.$Pro->id.'"></div><script>getDate("'.$Pro->countdown.'","'.$Pro->id.'");</script>';
                                }?>

                                    <?php } ?>


                                    <img src="{{$Pro->pic}}" style="width:100%;height: 160px;">

                            </div>
                            <div class="info-box">
                                <div class="ib-head"  style="font-size: 4.2vw;">
                                    <span>{{$Pro->title}}</span>&nbsp;&nbsp;
                                    @if($Pro->issy==1)
                                        <span class="i_span bxb-color-icon bxb-color-red">热</span>
                                    @endif
                                </div>

                                <div class="ib-body">
                                    <div class="cl-3">
                                        <p>
                                        <span class="red" style="color: #f20;font-weight:bold;"><b>{{$Pro->shijian}}</b></span>{{$Pro->qxdw=='个小时'?'小时':'天'}}</p>
                                        <p>投资期限</p>
                                    </div>
                                    <div class="cl-3">

                                        @if($Pro->hkfs == 4)
                                            <p><span class="red" >
                                                    <b>{{\App\Product::Benefit($Pro->id,$Pro->qtje)}}</b>
                                                </span>
                                            </p>
                                        @else

                                            <p><span class="red" ><b>{{$Pro->jyrsy*$Pro->qtje/100}}</b></span></p>
                                        @endif
                                            @if($Pro->hkfs == 4)
                                                <p>总收益（元）</p>
                                            @else

                                                @if(Cache::get('ShouYiRate')=='年')
                                                    <p>年化收益（元）</p>
                                                @else
                                                    <?php if ($Pro->qxdw == '个小时') { ?>
                                                        <p>每时收益（元）</p>
                                                        <?php } else { ?>
                                                        <p>每日收益（元）</p>
                                                        <?php } ?>
                                                @endif

                                            @endif

                                    </div>
                                    <div class="cl-3">
                                        <p><span class="red" >{{$Pro->qtje}}</span></p>
                                        <p>起购金额（元）</p>
                                    </div>


                                </div>
                                <div class="ib-foot">
                                    <div class="text">
                                        <p>预期收益率：<span style="color: #f20;">{{$Pro->jyrsy}}%</span></p>
                                        <p>项目规模：<span style="color: #000000;">{{$Pro->xmgm}}万元</span></p>
                                        <p>
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
                                            @elseif($Pro->hkfs == 5)
                                               5天付收益，到期还本
                                             @elseif($Pro->hkfs == 10)
                                               10天付收益，到期还本
                                             @elseif($Pro->hkfs == 30)
                                              30天付收益，到期还本   @endif
                                        </p>
                                    </div>
                                    <div class="other">



                                        @if($Pro->xmjd>=100 || $Pro->tzzt==1)
                                            <button class="now-btn" style="background-color: #888;">项目已满</button>
                                        @elseif($Pro->tzzt==-1)
                                                <button class="now-btn" style="background-color: #888;">待开放</button>
                                        @else
                                            <button class="now-btn">立即投资</button>
                                       @endif
                                    </div>
                                </div>
                                <div class="plan">
                                    <span>项目进度：</span>
                                    <div class="plan-wrap">

                                            <div class="plan-con" style="width:{{$Pro->xmjd}}%;background-color: #ff0000;"></div>

                                    </div>
                                    <span class="plan-text">{{$Pro->xmjd}}%</span>
                                </div>
                                @if($Pro->xmjd>=100)
                                    <img class="over" src="{{asset("mobile/bluev3/img/over2.png")}}" style="display: block;position: absolute;right: 0;margin-top: -2rem;"/>
                                @endif
                            </div>
                        </a>

        @endforeach
      </div>

    @endif

    @endforeach
    @endif

  

            </section>

        </section>

    </div>

      <!--app下载-->
  <!--  <div id="appdown" class="appdown" style="width:100%;height: 1rem;background-color: rgba(0, 0, 0, 0.5);position: fixed;bottom: 1rem;display: none;z-index: 100000">
        <div style="width: 1rem;float:left;height: 1rem;margin: 0 0.2rem;">
            <img src="/uploads/{{Cache::get("appdownloge").'?t='.time()}}" width="100%"/>
        </div>
        <div style="width: 3rem;float: left;left: 1rem;color: #fff;line-height: 0.4rem;margin: 0.1rem 0;font-size: 0.28rem;">

            <p style="text-align: center;"> <pre>{!!  \Cache::get('IndexTaotiaoAppText')!!} </pre></p>
        </div>
        <div style="width: 1rem;float:right;height: 1rem;">
            <a href="javascript:;" onclick="$('.appdown').hide();" style="display: block;width:1rem;font-size:0.5rem;cursor: pointer;color:#fff;line-height: 1rem;text-align: center;">×</a>
        </div>
       <div style="width: 2rem;height: 1rem;float: right;">
            <a href="{{\Cache::get('AppDownloadUrl')}}" style="display:block;width:1.6rem;height: 0.6rem;margin: 0.22rem .35rem;line-height:0.6rem;text-align:center;border-radius:0.1rem;background-color: #fc0303;color:#fff;font-size: 0.28rem;">下载体验</a>
        </div>
    </div> -->
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


</style>
    @if(Cache::get("IndexHoudong")=='开启')
        @if($wapad['houdong'])
            @foreach($wapad['houdong'] as $ad)


                <!--活动弹窗 S -->
                <div class="huodongbg" style="width:100%;height:2000px;position: fixed;top: 0;left:0;background-color: rgba(0,0,0,0.35);z-index: 9999999;" >
                    <div style="width:270px;height:420px;position: fixed;top: 0;left:0;right:0;bottom:0;margin:auto;background-color: #666;">
                        <a href="javascript:;" onclick="$('.huodongbg').hide();" style="width:80px;height:25px;line-height:25px;text-align: center;position:absolute;left:100px;top: 420px;border: 1px solid #fff;color:#f20;border-radius:5px;font-size: 20px;">关闭</a>
                        <a href="{{$ad->url}}" >
                            <img src="{{$ad->thumb_url}}" idth="270px" height="420px"/>
                        </a>
                    </div>
                </div>
                <!--活动弹窗 E-->

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


@section('footcategoryactive')



@endsection
