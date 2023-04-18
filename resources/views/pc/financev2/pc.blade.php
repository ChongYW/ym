<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" id="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>@if(isset($title)){{$title}}@else{{\Cache::get('CompanyLong')}}@endif</title>
    <meta name="keywords" content="{{\Cache::get('keywords')}}" />
    <meta name="description" content="{{\Cache::get('description')}}" />


    @section('css')

        <link rel="stylesheet" type="text/css" href="{{asset("layim/css/layui.css")}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/style.css")}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/v201712/css/style.css")}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset("pc/css/kefu.css")}}"/>
    @show
    @section('js')

        <script type="text/javascript" src="{{asset("pc/finance/js/jquery.min.js")}}"></script>
        <script type="text/javascript" src="{{asset("pc/finance/js/moment.min.js")}}"></script>

   {{--     <script type="text/javascript" src="{{asset("pc/finance/js/css.js")}}"></script>--}}
        <script type="text/javascript" src="{{asset("pc/finance/js/krpano.js")}}"></script>
        <script type="text/javascript" src="{{asset("pc/finance/js/jquery-1.4.2.flp.js")}}"></script>
        <script type="text/javascript" src="{{asset("layim/layui.js")}}"></script>
        {{--<script type="text/javascript" src="{{asset("mobile/public/layer_mobile/layer.js")}}"></script>--}}
        <script>
            var layer;
            layui.use('layer', function(){
                layer =layui.layer;

            });

            $(function () {
                $("#mysteve2").hover(
                    function () {
                        $("#add2").show();
                },
                    function () {
                        $("#add2").hide();
                }
                );
            });
        </script>


    @show

</head>

<body>
<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
@section('header')

    <div class="header">
        <div class="header_top">
            <div class="w1190 fn_cle">
                <div class="contact fn_left" style="position: relative;">
                    <div class="contact fn_left" style="position: relative;">

                        <span class="contact">
                 <a href="{{Cache::get('AppDownloadUrl')}}" id="mysteve2">下载APP</a>
                         <div id="add2" class="header-ewm-xf" style="display: none; width: 155px; height: 178px; text-align: center; border: 1px solid #cccccc; padding: 10px; position: absolute; z-index: 1111; left: 83px; top: 40px; background: rgb(255, 255, 255);">
                            <img src="{{route("Public.QrCode")}}" width="150">
                            <p style="color:#333; font-size:14px">下载手机客户端</p>
                        </div>
                 </span>

                        <span class="tel">服务热线：{{Cache::get("fuwurexian")}} </span>&nbsp;<span class="weixin"><a id="mysteve">官方QQ：{{Cache::get("kefuqq")}}  &nbsp;</a></span>			</div>
                </div>
                <div class="top_rig fn_rig">


                    <div class="login_reg" style="margin-top:0px;">
                        @if(isset($Member))
                            <a href="{{route('user.index')}}" class="link1"  style="color:#ffffff;">管理中心</a>
                            <a href="javascript:qiandao();" class="link2"  style="color:#fff">签到</a>
                            <a href="{{route('pc.loginout')}}" class="link2"  style="color:#fff">退出</a>
                        @else
                            <a href="{{route('pc.login')}}" class="link1"  style="color:#ffffff;">登录</a>
                            <a href="{{route('pc.register')}}" class="link2"  style="color:#fff">注册</a>
                        @endif

                    </div>



                    <script>

                        function qiandao() {
                            var _token = $("[name='_token']").val();
                            $.ajax({
                                url: '{{route('user.qiandao')}}',
                                type: 'post',
                                data: {_token:_token},
                                dataType: 'json',
                                error: function () {
                                },
                                success: function (data) {
                                    layer.msg(data.msg,{
                                        time:2000
                                    });
                                }
                            });
                        }

                    </script>


                </div>
            </div>
        </div>
        <div class="header_cont">
            <div class="w1190">
                <h1 class="fn_left"><a href="/"><img src="\uploads\{{\Cache::get('pclogo').'?t='.time()}}"></a></h1>
                <div class="nav_main">
                    <div class="navbar">
                        <ul class="nav ">
                            @if(isset($categorys))
                                @foreach($categorys as $nak=>$category)



                                    @if($category->model=='links')

                                        <li id="menu{{$nak}}" class="nav-content nav-myhome home @if("/".Request::path()==$category->links|| (Request::path()=='/' && $nak ==0) ) active @endif"><a href="{{$category->links}}">{{$category->name}}</a></li>
                                    @else

                                        <li id="menu{{$nak}}" class="nav-content nav-myhome home @if(Request::url()==route($category->model.".links",["links"=>$category->links])) active @endif"><a href="{{route($category->model.".links",["links"=>$category->links])}}">{{$category->name}}</a></li>


                                    @endif


                                @endforeach
                            @endif


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



@show

<!--主体-->
@yield('body')
<!--主体 end-->

@section('footbox')
@show



@section('footer')


    <div id="right_tool" style="right: 11.5px; display: block;">
        <ul>
            @if(Cache::get('WebIMKeFu')!='开启')
                <li><a href="{{$kefulinks}}"  class="kefu1" id="qqonlin"><span>在线<br>客服</span></a></li>
            @endif


            <!--<li><a href="javascript:;" class="weixin" id="kfwx"><span></span></a></li>-->
            <li><a href="javascript:;" class="app" id="kfapp"><span></span></a></li>
            <li><a href="{{route('calculation')}}" class="calc"><span></span></a></li>
            <li><a href="javascript:;" id="yb_top" class="backtotop" style="opacity: 1; top: 0px; display: block;"><span>TOP</span></a></li>
        </ul>
          <!--
          <div class="weixin-info info-border">
              <img src="/Public/0630/images/wx.jpg" alt="" width="60">
              <h3>关注公众号</h3>
          </div>
          -->
        <div class="app-info info-border" style="display: none; left: -80px; opacity: 0;">
            <img src="{{route("Public.QrCode")}}" alt="" width="60">
            <h3>APP下载</h3>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $("#yb_top").click(function() {
                $("html,body").animate({
                    'scrollTop': '0px'
                }, 300)
            })
            $(".consultation-code-container").hover(function(){
                $(".wx-img").show();
            },function(){
                $(".wx-img").hide();
            })
            $("#kfapp").hover(function(){
                $(".app-info").show();
                $(".app-info").css('left','-80px').animate({'left':'-136px'},500);
                $(".app-info").css('opacity','1');
            },function(){
                $(".app-info").hide();
                $(".app-info").css('left','-136px').animate({'left':'-80px'},500);
                $(".app-info").css('opacity','0');
            })
            $("#kfwx").hover(function(){
                $(".weixin-info").show();
                $(".weixin-info").css('left','-80px').animate({'left':'-136px'},500);
                $(".weixin-info").css('opacity','1');
            },function(){
                $(".weixin-info").hide();
                $(".weixin-info").css('left','-136px').animate({'left':'-80px'},500);
                $(".weixin-info").css('opacity','0');
            })
        });
        $(function(){
/*            $(window).scroll(function(){
                var scrollHeight = $(window).scrollTop();
                var top = $('.is_head_scroll').offset().top;
                var nav_fixed = $('.header-nav-wrap');
                var wh = $(window).height();
                if(scrollHeight > top) {
                    if( !nav_fixed.hasClass('hn-fixed')){
                        nav_fixed.addClass('hn-fixed').css('top','-80px').animate({'top':'0'},1000);
                    }
                }else{
                    nav_fixed.removeClass('hn-fixed');
                }
            });*/
        });
    </script>


    <div class="footer" style="min-width:1200px;">
        <div class="w1100">
            <ul>
                <li>
                    <a  href="{{route("singlepages.links",["links"=>"about"])}}" class="til">关于我们</a>
                    <a  href="{{route("singlepages.links",["links"=>"about"])}}">关于我们</a>
                    <a href="{{route("singlepages.links",["links"=>"about"])}}" >公司简介</a>
                    <a href="{{route("singlepages.links",["links"=>"gszz"])}}" >公司资质</a>
                    <a href="{{route("singlepages.links",["links"=>"zjwt"])}}" >常见问题</a>

                </li>
                <li>
                    <a  href="{{route("singlepages.links",["links"=>"about"])}}" class="til">帮助中心</a>
                    <a href="{{route("singlepages.links",["links"=>"zffs"])}}" >支付方式</a>
                    <a href="{{route("singlepages.links",["links"=>"aqbz"])}}" >安全保障</a>
                    <!--<a href="{{route("singlepages.links",["links"=>"hqhy"])}}" >邀请好友</a>-->
                    <a href="{{route("singlepages.links",["links"=>"hydj"])}}" >会员等级</a>

                </li>
                <li>
                    <a  href="{{route("singlepages.links",["links"=>"xinshou"])}}" class="til">新手指引</a>
                    <a  href="{{route("products.links",["links"=>"xinshou"])}}">新手指引</a>
                    <a href="{{route("products.links",["links"=>"vip"])}}" >VIP专区</a>
                    <a href="{{route("products")}}" >投资项目</a>
                    <a href="{{route("singlepages.links",["links"=>"wxzxkf"])}}" >在线客服</a>
                </li>
                <li class="last" style="padding-left:70px; width:265px;">

                    <span class="app"><br>
                <img src="{{route("Public.QrCode")}}" width="100">
                            <p>下载安卓客户端</p>
                </span>

                    <span class="app"><br>
                <img src="{{route("Public.QrCode")}}" width="100">
                            <p>下载苹果客户端</p>
                </span>
                </li>
                <li class="last">
                    <p class="bd">{{Cache::get("fuwurexian")}} &nbsp;</p>
                    <p>工作时间： {{Cache::get('gongzuoshijian')}}</p>
                    <p>客服邮箱：{{Cache::get('kefumail')}}</p>
                    <p>公司地址：{{Cache::get('gongsidizhi')}}</p>
                </li>
            </ul>
        </div>
        <div class="f" style="line-height:220%; background:#2F2F2F; width:100%; text-align:center; color:#FFF">
            <p>备案/许可证编号为：{{Cache::get("webbeian")}}</p>
            <p>Copyright© 2016 {{$_SERVER['HTTP_HOST']}} All Rights Reserved {{Cache::get('CompanyShort')}}</p>
           {{-- <br>
            <a target="cyxyv" href="https://v.yunaq.com/certificate?domain=www.echejf.com&from=label&code=90030"> <img src="https://aqyzmedia.yunaq.com/labels/label_sm_90030.png"></a>
            <a  href="/"><img alt="" src="/pc/finance/css/images/1.png" width="105" height="35"></a>
            <a  href="/"><img alt="" src="/pc/finance/css/images/2.png" width="105" height="35"></a>
            <a  href="/"><img alt="" src="/pc/finance/css/images/3.png" width="105" height="35"></a>
            <a  href="/"><img alt="" src="/pc/finance/css/images/4.png" width="105" height="35"></a>
            <a  href="/"><img alt="" src="/pc/finance/css/images/5.png" width="105" height="35"></a>
            <a  href="/"><img alt="" src="/pc/finance/css/images/6.png" width="105" height="35"></a>
            <a  href="/"><img alt="" src="/pc/finance/css/images/5.gif" width="105" height="35"></a>
            <a  href="/"><img alt="" src="/pc/finance/css/images/6.gif" width="105" height="35"></a>--}}

            <br>
        </div>
    </div>



    <style>
        .floating_ckcc {
            position: fixed;
            left: 1px;
            top: 30%;
            z-index: 999;
        }
    </style>

    <div class="floating_ckcc">
        <a href="{{route('user.lotterys')}}" ><img src="/pc/finance/jsonpublic/images/toolbar-partner.gif" width="80"></a>
    </div>

@show

@section('footcategory')


@show



@section('playSound')
    @if(isset($Member))
<script type="text/javascript">
    //播放提示音
    function playSound(name,str){
        $("#"+name+"").html('<embed width="0" height="0"  src="/mobile/public/Front/sound/'+str+'" autostart="true" loop="false">');

        if(document.getElementById("'"+name+"'")){
            document.getElementById("'"+name+"'").Play();
        }
    }

    function total() {
        $.get("{{route('user.msg')}}",function(data){

            //top_msg = parseInt($("#top_msg").text()); //统计未读短信

            //赋值到模板
            $("#top_msg").html(data.msgs); //统计未读短信

            @if(Cache::get('UserMsgSound')=='开启')
            //未读站内短信提示

            if (data.playSound > 0 && data.msgs > 0) {
                playSound('top_playSound','msg.mp3');
            }else if (data.layims > 0) {
                playSound('top_playSound','default.mp3');
            }

            @endif
        },'json');
    }
    total();
    setInterval("total()",15000);


</script>




    @endif
@show




@section('Memberamount')

@show



@show
<font id="top_playSound"></font>
@if(Cache::get('WebIMKeFu')=='开启')
    @if(isset($Member))
        @include('pc.finance.layim.kf')
    @else
        @include('pc.finance.layim.ykf')
    @endif
@endif
{!! Cache::get("pccode") !!}
</body>
</html>
