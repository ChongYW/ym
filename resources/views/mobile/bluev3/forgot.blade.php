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



    <div class="othertop">
        <a class="goback" href="javascript:history.back();"><img src="/mobile/bluev3/img/goback.png" /></a>
        <!-- <div class="othertop-font">修改密码</div> -->
    </div>
    <div class="header-nbsp"></div>

    <div  class="login_html">
        <b>找回密码</b>
    </div>

    <div class="login_remark">
        <span>请输入注册手机号以接收重置密码</span>
    </div>

    <div class="login_bg">
        <form id="loginForm">
            <div class="input_text log loggin_div i ui-top-title" >
                <i><img src="{{asset("mobile/film/images/userName.png")}}"></i>
                <input type="text" id="username" name="username" placeholder="请输入用户名" maxlength="11">
            </div>

            <div class="input_text log loggin_div i ui-top-title" >
                <i><img src="/mobile/bluev3/img/icon_tel.png"></i>
                <input type="text" id="mobile" name="mobile" placeholder="请输入手机号" maxlength="11">
            </div>

            <div class="input_text log loggin_div i ui-top-title" >
                <i><img src="{{asset("mobile/film/images/userPwd.png")}}"></i>
                <input type="text" id="code" name="code" placeholder="请输入验证码" maxlength="4">
                <img src="{!! captcha_src('flat') !!}"
                     alt="验证码"  style="cursor:pointer;height: 40px;margin-top:-45px;float:right;"
                     onclick="this.src='{!! captcha_src('flat') !!}'+Math.random()" id="codeImg" />
            </div>



            <input type="button" name="btn" id="login" class="input_btn finishReg" value="找回密码" style="border-radius:15px; margin:0 auto;width:92%;"/>
        </form>
    </div>


    <style>
        .login_html{text-align: center;margin:0 auto;height: 90px;line-height:100px;font-size: 18px;color:#385fec;}
        .login_remark{text-align: center;margin-bottom: 15px;}
        .loggin_div{padding:2px 15px;border-radius:15px;margin:0 auto;width:85%;margin-bottom: 10px;}
        .loggin_div i{ left: 25px;top: .225rem;}
        .loggin_div input{width:85%;border-left:1px solid #e0e0e0;}

    </style>






    <script type="text/javascript">
        $('.finishReg').click(function(){
            var username = $("#username").val();
            var mobile   = $("#mobile").val();
            var code     = $("#code").val();
            if(!username){
                layer.msg("请填写用户名");
                return ;
            }
            if(!mobile){
                layer.msg("请填写手机号码");
                return ;
            }
            if(!code){
                layer.msg("请填写验证码");
                return ;
            }

            $.ajax({
                type : "POST",
                url : "{{route("wap.forgot")}}",
                dataType : "json",
                data : 'username=' + username + '&mobile=' + mobile  + '&captcha=' + code+'&_token={{ csrf_token() }}',
                success : function (data) {
                    if(data.status == "0"){

                        layer.msg(data.msg,function(){

                                if(data.url){
                                    window.location.href=data.url;
                                }else{
                                    window.location.href='{{route('user.index')}}';
                                }



                        });


                    }else{
                        retCode();
                        layer.msg(data.msg);
                    }
                }
            });

        });
        function retCode() {

            $("#codeImg").attr("src", '{!! captcha_src('flat') !!}'+Math.random());
        }
    </script>

@endsection


@section("footcategory")
    @parent
@endsection

@section("footer")
    @parent
@endsection
@section("playSound")

@endsection

