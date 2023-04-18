@extends('mobile.film.wap')

@section("header")
    <header>
        <a href="javascript:history.go(-1);">
            <img src="{{asset("mobile/film/images/back.png")}}" class="left backImg">
        </a>
        <span class="headerTitle">用户登录</span>
    </header>
@endsection

@section("js")
    @parent

@endsection

@section("css")
    @parent

@endsection



@section('body')
    <div class="register">
        <form id="loginForm">
        <div class="formItemBorder userLogin" style="background:#FFF">
            <img src="{{asset("mobile/film/images/userName.png")}}" class="userImg"/>
            <input type="text" id="username" name="username" autocomplete="off" value="" placeholder="请输入手机号码" class="username inputText left">
        </div>
        <div class="formItemBorder userLogin" style="background:#FFF">
            <img src="{{asset("mobile/film/images/userPwd.png")}}" class="userImg"/>
            <input type="password" id="password" name="password" autocomplete="off" value="" placeholder="请输入密码"
                   class="username inputText left">
        </div>

        <div class="formItemBorder">
            <button type="button" id="login" class="finishReg">立即登录</button>
        </div>
        </form>

        <div class="formItemBorder">
            <a href="{{route("wap.forgot")}}" class="finishReg borderBtn"
               style="background:#ff0c00; border:1px #f8b62c solid; color:#FFF">忘记密码</a>
        </div>


        <div class="formItemBorder">
            <a href="{{route("wap.register")}}" class="finishReg borderBtn"
               style="background:#f8b62c; border:1px #f8b62c solid; color:#FFF">立即注册即送现金礼包</a>
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



@endsection


@section("footcategory")
    @if(Cache::get('TaotiaoIndexOn')=='开启')
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


    </style>

    <footer class="borderTop">

        <a href="/index.html" title="资讯首页" class="f_home active" id="menu0">资讯首页</a>

        <a href="{{route('user.index')}}" title="邀请好友" class="f_geng" id="menu1">邀请好友</a>



        <a href="{{route('user.index')}}" title="个人中心" class="navAccount f_account" id="menu3">个人中心</a>

        <a href="{{route('user.index')}}" title="每日签到" class="f_touz" id="menu4">每日签到</a>
        <?php
        $link=\App\Category::where('name','在线客服')->value('links')
        ?>

        <a href="{{$link}}" title="在线客服" class="f_borrow" id="menu2">在线客服</a>

    </footer>
    @else
        @parent
    @endif
@endsection

@section("footer")
    @parent
@endsection
@section("playSound")

@endsection

