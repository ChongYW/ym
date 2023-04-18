@extends('mobile.default.wap')

@section("header")
    @parent
@endsection

@section("js")
    @parent
    <script type="text/javascript" src="{{asset("mobile/public/Front/js/json-eps.js")}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset("mobile/public/Front/user/user.js")}}"></script>
@endsection

@section("css")
    <link rel="stylesheet" href="{{asset("mobile/public/Front/css/common.css")}}" />
    <link rel="stylesheet" href="{{asset("mobile/public/Front/css/login.css")}}" />
    <link rel="stylesheet" href="{{asset("mobile/public/Front/css/service.css")}}" />
    <link rel="stylesheet" href="{{asset("mobile/public/Front/css/react.css")}}" />

    <style>
        .header{display:none;}

    </style>

@endsection



@section('body')



    <div class="wrap">
        <div class="zs_topbg"><img src="{{asset("mobile/images/logo_bj.png")}}"></div>
        <div class="zs_dl">登录</div>
        <div class="main container page-login">
            <div class="row">
                <div class="login">
                    <div class="hint">
                        <div class="alert alert-danger alert-dismissable" id="errs" style="display:none;"></div>
                    </div>
                    <div class="password">
                        <form id="loginForm">
                            <div class="input-group zsdlk">
                                <span class="input-group-addon2"><i class="fa fa-user"><img src="{{asset("mobile/images/dl.png")}}"></i></span>
                                <input type="text" name="username" id="username" autocomplete="off" placeholder="请输入手机号码" class="zskuang" />
                            </div>
                            <div class="input-group zsdlk">
                                <span class="input-group-addon2"><i class="fa fa-lock"><img src="{{asset("mobile/images/sj.png")}}"></i></span>
                                <input type="password" name="password" id="password" placeholder="请输入密码" autocomplete="off" class="zskuang" />
                            </div>
                            <div class="input-group buttons">
                                <button type="button" id="login" class="btn btn-orange">立即登录</button>
                                <span><a href="{{route("wap.forgot")}}">忘记密码</a> <a href="{{route("wap.register")}}" class="register">立即注册</a></span>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
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

                            $("#errs").html("请输入手机号码");
                            $("#errs").show();
                            return false;
                        }
                        if ($("#password").val() == "" || $("#password").val() == "输入密码") {
                            $("#errs").html("请输入密码");
                            $("#errs").show();
                            return false;
                        }

                        var josnObj = formToJsonObject($("#loginForm")[0]);
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
                                    $("#errs").html(data.msg);
                                    $("#errs").show();
                                }

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



@endsection


@section("footcategory")
    @if(Cache::get('TaotiaoIndexOn')=='开启')
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
                    $link=\App\Category::where('name','在线客服')->value('links')
                    ?>

                    <li><a href="{{$link}}" title="在线客服" class="f_borrow" id="menu2">在线客服</a></li>
                </ul>
            </div>
        </div>

    @else
        @parent
    @endif
@endsection

@section("footer")

@endsection
@section("playSound")

@endsection

