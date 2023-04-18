@extends('mobile.bluev3.wap')

@section("header")

@endsection

@section("js")
    @parent

@endsection

@section("css")
    @parent

@endsection



@section('body')

    @if(isset($_GET['login']))

        <div class="othertop">
            <a class="goback" href="javascript:history.back();" ><img src="/mobile/bluev3/img/goback.png" /></a>
        </div>

        <div class="header-nbsp"></div>

        <div  class="login_html">
            <!--<b>登 录</b>-->
            <b>登 录</b>
        </div>

        <div class="login_bg" style="top:200px;">
            <form  id="loginForm">
                <div class="input_text log loggin_div i ui-top-title" >
                    <i><img src="/mobile/bluev3/img/icon_tel.png"></i>
                    <input type="text" name="username" id="username" placeholder="请输入手机号码" maxlength="11">
                </div>
                <div class="input_text log loggin_div i ui-top-title">
                    <i><img src="/mobile/bluev3/img/icon_pwd.png"></i>
                    <input type="password" id="password" name="password" placeholder="请输入您的登录密码">
                    <i class="pwdshow"><img src="/mobile/bluev3/img/see.png" id="pwdshow"></i>
                </div>
                <div class="bnk"></div>
                <input type="submit" class="input_btn" id="login" value="登录" style="border-radius:15px; margin:0 auto;width:95%;"/>
                <div class="hr"></div>
                <div class="foot-lnk">
                    <b ><a href="{{route("wap.forgot")}}" style="color:#3d58f0;font-size:13px;">忘记密码?</a></b>

                </div>
            </form>
        </div>





        <style>
            .login_html{text-align: center;margin:0 auto;height: 90px;line-height:100px;font-size: 18px;color:#385fec;}
            .loggin_div{padding:2px 15px;border-radius:15px;margin:0 auto;width:85%;margin-bottom: 8px;}
            .loggin_div i{ left: 25px;top: .225rem;}
            .loggin_div input{width: 85%;border-left:1px solid #e0e0e0;}

            /* input::-ms-input-placeholder { text-align: center;}
            input::-webkit-input-placeholder {text-align: center;} */

            .bnk{height:2px;margin:15px 0 10px 0;background:#f1f1f1;}
            .hr{height:1px;margin:15px 0 15px 0;background:#fff;}
            .foot-lnk{	text-align:center;}
        </style>

        <script type="text/javascript">
            $(document).ready(
                function() {
                    $("body").keydown(function(e) {
                        var curKey = e.which;
                        if (curKey == 13) {
                            $("#login").click();
                            return false;
                        }
                    });
                    $("#login").click(
                        function(e) {
                            if ($("#username").val() == "" || $("#username").val() == "账号名称") {

                                layer.msg("请输入手机号码");
                                return false;
                            }
                            if ($("#password").val() == "" || $("#password").val() == "输入密码") {
                                layer.msg("请输入密码");
                                return false;
                            }

                            var josnObj = $("#loginForm").serialize();
                            var isCanLogin = false;
                            var returnVal = $.ajax({
                                url: "{{route("wap.login")}}",

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
                                        layer.msg(data.msg);
                                    }else {

                                        layer.open({
                                            title:'登录',
                                            content: data.msg,
                                            btn: '确定',
                                            shadeClose: false,
                                            yes: function (index) {
                                                if (data.status==0) {
                                                    if (data.url != '') {
                                                        window.location.href = data.url;
                                                    } else {
                                                        window.location.href = '{{route('user.index')}}';
                                                    }

                                                }

                                                layer.close(index);
                                            }
                                        });
                                    }

                                },
                                error: function(msg) {
                                    $("#errs").html('网络异常，请重新提交');
                                    $("#errs").show();
                                }
                            },'josn');
                            return false;
                        })
                });

            function fullScreen(url) {
                location.href = url;
            }


        </script>
        @else
    <div id="bg" class="bg">
        <div class="login-html login-form">
            <div class="group" style="margin-top: 100%;" >
                <a><input type="text" class="input" hidden></a>
            </div>
            <div class="group">
                <a href="{{route('wap.register')}}"><input type="submit" style="color: #fff;background-color: #e36717;" class="input_btn" value="注册"></a>
            </div>
            <div class="group">
                <a href="{{route('wap.login',['login'=>1])}}"><input type="submit" style="color: #0627e2;background-color: #fff;" class="input_btn" value="登陆"></a>
            </div>
        </div>
    </div>

    <div class="my_total"  style="background-image: linear-gradient(to right,#385fec,#39b9ff)">
        <div class="user">
            <span>账号：187*****888</span>
            <span>优惠券：9</span>
            <span>等级：高级会员</span>

        </div>
        <p class="bal">7,000.01</p>
        <p class="bal_tit" style="color:#ffffff;">总资产（元）</p>
        <div class="wait" >
            <div class="item">
                <span class="span_num">5,000.00</span>
                <span class="span_tit" style="color:#ffffff;font-size: .23rem">账户余额（元）</span>
            </div>

            <div class="item">
                <span class="span_num">2,000.01</span>
                <span class="span_tit" style="color:#ffffff;font-size: .23rem">余额宝（元）</span>
            </div>
        </div>
    </div>
    <div class="user_btn" >
        <a href="{:U('recharge')}" style="color: #333;background: #dcdcdc;"><b>充值</b></a>
        <a href="{:U('cash')}" style="color: #333;background: #dcdcdc;"><b>提现</b></a>
    </div>

    <a class="manageModule borderRight" href="{:U('User/ebao')}">
        <div class="manageBorder borderBottom" >
            <img src="/mobile/bluev3/img/person/ebao.png"/><br/>余额宝
        </div>
    </a>

    <a class="manageModule borderRight" href="{:U('tickets')}">
        <div class="manageBorder borderBottom" >
            <img src="/mobile/bluev3/img/person/juan.png"/><br/>优惠券
            <div id="ticketsNum" class="notice">9</div>
        </div>
    </a>
    <a class="manageModule borderRight" href="{:U('Prize/index')}">
        <div class="manageBorder borderBottom" >
            <img src="/mobile/bluev3/img/person/index-hlf-icon6.png"/><br/>0元抽奖
        </div>
    </a>
    <a class="manageModule borderRight" href="{:U('recommend')}">
        <div class="manageBorder borderBottom" >
            <img src="/mobile/bluev3/img/person/icon-in7.png"/><br/>邀请好友
        </div>
    </a>

    <a class="manageModule borderRight" href="/about/lists/id/8.html">
        <div class="manageBorder borderBottom" >
            <img src="/mobile/bluev3/img/person/gg.png" /><br/>重要公告
        </div>
    </a>

    <a class="manageModule borderRight" href="{:U('set_account')}">
        <div class="manageBorder borderBottom" >
            <img src="/mobile/bluev3/img/person/accSet.png"/><br/>账号设置
        </div>
    </a>

    <a class="manageModule borderRight" href="{:U('certification')}">
        <div class="manageBorder borderBottom" >
            <img src="/mobile/bluev3/img/person/userrealname.png"/><br/>实名认证
        </div>
    </a>

    <a class="manageModule borderRight" href="{:U('interest')}">
        <div class="manageBorder borderBottom" >
            <img src="/mobile/bluev3/img/person/accTotal.png"/><br/>点金记录
        </div>
    </a>

    <a class="manageModule borderRight" href="{:U('fund')}" >
        <div class="manageBorder borderBottom">
            <img src="/mobile/bluev3/img/person/accBank.png"/><br/>资金流水
        </div>
    </a>

    <div style="margin-top: 65%;background-color: #F5F5F5;"></div>
    <div class="clear"></div>


    <style>
        .clear { clear:both;}
        .manageModule { width:33.333333%; text-align:center; float:left; display:block; color:#333; font-size:13px;}
        .manageModule:focus { color:#333; text-decoration:none;}
        .manageModule:link { color:#333; text-decoration:none;}
        .manageModule:visited { color:#333; text-decoration:none;}
        .manageModule:hover { color:#333; text-decoration:none;}
        .manageModule:active { color:#333; text-decoration:none;}
        .manageBorder { height:100%; padding:10%;}
        .borderRight{ position: relative; }
        .borderRight:after{ content: ''; display:block; position: absolute; width: 1px; right: 0px; top: 0px;height: 100%; background-color: #ccc; -webkit-transform: scaleX(0.5); transform: scaleX(0.5);}
        .borderBottom{ position: relative; background:#FFF; }
        .borderBottom:after{ content: ''; display:block; position: absolute; width: 100%; left: 0px; bottom: 0px;height: 1px; background-color: #ccc; -webkit-transform: scaleY(0.5); transform: scaleY(0.5);}
        .borderTop:after{ content: ''; display:block; position: absolute; width: 100%; left: 0px; top: 0px;height: 1px; background-color: #ccc; -webkit-transform: scaleY(0.5); transform: scaleY(0.5);}
        .manageModule img { width:25%; max-width:35px; margin-bottom:10px;}
        .manageModule:hover { text-decoration:none;}
        .manageModule.noborder { border-bottom:none;}

        .bg{display: block; background-color: #F5F5F5; width:100%; position: absolute; opacity: 0.9;/*-webkit-filter: blur(2px); filter: blur(2px);*/z-index: 2;}
        .login-form .group .check{display:none;}
        .login-form .group .label,
        .login-form .group .button{text-transform:uppercase;}
        .login-form .group .label,
        .login-form .group .input,
        .login-form .group .button{color:#fff;display:block;}
        .login-form .group .input,
        .login-form .group .button{border:none;padding:15px 20px;border-radius:0px;background:rgba(255,255,255,.1);}
        .login-form .group.input{display:none;max-width:100%}
        .login-form .group .label{color:#aaa;font-size:14px;}
        .login-form .group .button{ display: block;margin-right:10%}
        .notice{ position: absolute;color: white;font-size: 6px;background-color: red; min-height: 12px;min-width: 18px;line-height: 12px;right: 30px;top: 6px;text-align: center;-webkit-border-radius: 14px;  padding: 2px;}
    </style>
    @endif





@endsection


@section("footcategory")
    @if(Cache::get('TaotiaoIndexOn')=='开启')
        <style>




            .f_geng {
                background: url(/mobile/bluev3/img/footer/about_blue.gif) no-repeat top center;
                background-size: 21px;
                text-align: center;
                color: #9f9f9f;
                font-size: 12px;
                box-sizing: border-box;
                padding-top: 20px;
            }
            .f_touz {
                background: url(/mobile/bluev3/img/footer/invest.png) no-repeat top center;
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

        <!-- 底部样式 -->
        <div class="header-nbsp"></div>

        <div class="footer_nav">
            <?php
            $link=\App\Category::where('name','like','%客服%')->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->value('links')
            ?>
            <a href="/index.html" title="资讯首页" >
                <img  src="/mobile/bluev3/img/footer/about_blue.gif"  style="width: 20px;height: 20px;">
                <span>资讯首页</span>
            </a>
            <a href="{{route('user.index')}}" title="邀请好友" >
                <img  src="/mobile/bluev3/img/footer/invest.png"  style="width: 20px;height: 20px;">
                <span>邀请好友</span>
            </a>
            <a href="{{route('user.index')}}" title="个人中心" >
                <img  src="/mobile/bluev3/img/footer/user.png"  style="width: 20px;height: 20px;">
                <span>个人中心</span>
            </a>
            <a href="{{route('user.index')}}" title="每日签到" >
                <img  src="/mobile/film/images/tab3_1_004_1.png"  style="width: 20px;height: 20px;">
                <span>每日签到</span>
            </a>
            <a href="{{$link}}" title="在线客服" >
                <img  src="/mobile/bluev3/img/footer/kefu_blue.png"  style="width: 20px;height: 20px;">
                <span>客服</span>
            </a>


        </div>
    @else
        @parent
    @endif
@endsection

@section("footer")
    @parent
@endsection
@section("playSound")

@endsection

