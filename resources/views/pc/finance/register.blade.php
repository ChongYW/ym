@extends('pc.finance.pc')

@section("header")
    @parent
@endsection

@section("js")
    @parent
@endsection

@section("css")
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/style.css")}}"/>

    <link rel="stylesheet" type="text/css" href="{{asset("pc/css/kefu.css")}}"/>

@endsection



@section('body')
    <div class="cle"></div>
<style>

    .reg_bg {
        width: 1100px;
        margin: auto;
        margin-top: 20px;
        background: #FFF;
        background: url(/pc/finance/css/images/login_r.png) #FFF no-repeat 500px 100px ;
    }

</style>
    <div class="w1100 mr_b20">
        <div class="reg_bg border1 oh">
            <h1>免费注册</h1>

            <div class="member_reg clear">
                <div class="reg_left fl">


                        <div class="clear"></div>

                    <div class="reg_item" style="display: none;">
                        <label class="basic_label"><span class="red">*</span>帐号</label>
                        <input name="username" id="username" label="帐号" placeholder="请输入有效帐号" maxlength="11" type="text" class="basic_input">
                        <div id="usernameTip" class="onShow">请输入有效帐号</div></div>

                        <div class="reg_item">
                            <label class="basic_label"><span class="red">*</span> 验证码</label>
                            <input type="text" id="code" name="code" size="14" placeholder="右边验证码" class="basic_input w100" maxlength="4">
                            <img src="{!! captcha_src('flat') !!}"
                                 alt="验证码"  style="cursor:pointer;"
                                 onclick="this.src='{!! captcha_src('flat') !!}'+Math.random()" id="code_img" />
                            <div id="codeTip" class="onShow">请输入验证码</div></div>
                        <div class="reg_item">
                            <label class="basic_label"><span class="red">*</span>手机号码</label>
                            <input name="mobile" id="mobile" label="手机号码" placeholder="请输入有效的手机号码" maxlength="11" type="text" class="basic_input">
                            <div id="mobileTip" class="onShow">请输入手机号码</div></div>

                    <?php
                    if(\Cache::get('smsverifi')=='开启'){?>

                    <div class="reg_item">
                        <label class="basic_label"><span class="red">*</span> 验证码</label>

                    <input type="text" name="mobile_verify" id="mobile_verify" value="" size="14" placeholder="输入短信验证码" class="basic_input w100" style="float:left">

                    <input type="submit" class="user_reg_sub" value="获取验证码" name="getcode" style="width: 150px;line-height: 44px;height: 44px;" onclick="send_verfiycodeRegister(this)">
                        <div id="mobile_verifyTip" class="onShow"></div>
                    </div>
                    <?php } ?>




                        <div class="clear"></div>

                        <div class="reg_item">
                            <label class="basic_label"><span class="red">*</span>登录密码</label>
                            <input type="password" id="password" name="password" placeholder="6~20位字符" class="basic_input" maxlength="18">
                            <div id="passwordTip" class="onShow">请输入密码</div></div>
                        <div class="reg_item">
                            <label class="basic_label"><span class="red">*</span>确认密码</label>
                            <input type="password" id="pwdconfirm" name="pwdconfirm" placeholder="两次密码输入必须一致" class="basic_input" maxlength="18">
                            <div id="pwdconfirmTip" class="onShow">请输入确认密码</div></div>
                        <div class="reg_item">
                            <label class="basic_label"><span class="red">*</span>Q Q：</label>
                            <input type="text" id="qq" name="qq" placeholder="请输入您的QQ号码" class="basic_input" maxlength="18">
                            <div id="qqTip" class="onShow">请输入您的真实QQ号码或微信</div></div>
                        <div class="reg_item">
                            <label class="basic_label">推荐人</label>

                            <input type="text" id="recommend" name="recommend" value="{{$yaoqingren}}" size="36" class="basic_input" placeholder="无推荐人请留空">


                        </div>

                        <div class="cle"></div>


                        <div class="reg_item">
                            <p>
                                <input type="submit" class="user_reg_sub" value="完成注册" name="dosubmit" id="registerBtn" onclick="register_new()">
                                <div id="registerTip" class="onShow"></div>
                            </p>
                        </div>
                        <div class="reg_item">
                            <p>已有账号？<a href="{{route('pc.login')}}" class="user_f_c2 pink">立即登录</a></p>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                </div>
            </div>
        </div>
    </div>

    <script>



        function send_verfiycodeRegister(obj) {

                var phone = $.trim($("#mobile").val()),
                    telReg = !!phone.match(/^(0|86|17951)?(13[0-9]|15[012356789]|16[0-9]|17[0-9]|18[0-9]|19[0-9]|14[57])[0-9]{8}$/),
                    _code = $.trim($("#code").val());
                    var _token = $("[name='_token']").val();


                if(telReg!=1){
                    $("#mobileTip").show().text("请输入有效的手机号码");
                    return false;
                }else{
                    $("#mobileTip").hide();
                }

                var url = "/sendsms?_token=" + _token + "&tel=" + phone + "&captcha=" + _code + "&t=" + Math.random();
                $.ajax({
                    type: "POST",
                    data: {},
                    url: url,
                    beforeSend: function () {
                        $(obj).attr({"disabled":true}).val("发送中...")
                    },
                    success: function (data) {

                        $("#mobile_verifyTip").show().text(data.msg);
                        if(data.status==0){
                            back_timeRegister(obj);
                        }else{
                            $("#code_img").click();
                            $(obj).attr({"disabled":false});
                        }

                    },
                    error: function () {
                        $(obj).attr({"disabled":false}).val("获取验证码")
                    },
                    dataType: "json"
                });


        }

       var wait = 60;
        function back_timeRegister(o) {

            if(wait>0){

                $(o).attr({"disabled":true}).val("重新发送("+wait+")");
                wait--;

                setTimeout(function () {
                    back_timeRegister(o)
                },1000);

            }else{
                $(o).attr({"disabled":false}).val("获取验证码");
                wait = 60;
            }


        }




        function register_new() {

            var phone = $.trim($("#mobile").val()),
                telReg = !!phone.match(/^(0|86|17951)?(13[0-9]|15[012356789]|16[0-9]|17[0-9]|18[0-9]|19[0-9]|14[57])[0-9]{8}$/),
                _code = $.trim($("#code").val());
            var _token = $("[name='_token']").val();
            var username = $("[name='username']").val();
            var password = $("[name='password']").val();
            var pwd_again = $("[name='pwdconfirm']").val();
            var qq = $("[name='pwdconfirm']").val();
            var yaoqingren = $("[name='recommend']").val();
            var captcha = $("[name='code']").val();
            var code = $("[name='mobile_verify']").val();


            if(telReg!=1){
                $("#mobileTip").show().text("请输入有效的手机号码");
                return false;
            }else{
                $("#mobileTip").hide();
            }


            var url = "/register.html";
            $.ajax({
                type: "POST",
                data: {
                    username: username,
                    phone: phone,
                    password: password,
                    confirmpassword: pwd_again,
                    qq: qq,
                    yaoqingren: yaoqingren,
                    captcha: captcha,
                    code: code,
                    _token:_token
                },
                url: url,
                beforeSend: function () {
                    $("#registerBtn").addClass("disable").val("正在注册")
                },
                success: function (data) {
                    $("#registerBtn").removeClass("disable").val("注册中...");
                    var status = data.status;
                    if (!status) {
                        $(".registerTip").show(), $("#registerTip").html(data.msg);
                        $("#registerBtn").removeClass("disable").val("立即注册")
                    } else {
                        //alert(data.info);

                        layui.use('layer', function(){
                            var layer =layui.layer;

                            layer.msg(data.msg, {time:2000}, function (index) {

                                if(status==0){
                                    window.location.href = "/login.html";
                                }else{
                                    $("#code_img").click();
                                }


                            });
                        });



                    }
                },
                error: function () {
                    $("#registerBtn").removeClass("disable").val("立即注册")
                },
                dataType: "json"
            })
        }


    </script>
    <script type="text/javascript">
        $("#mobile").keyup(function () {
            $("[name='username']").val($(this).val());
            $("#username").val($(this).val());

        });
    </script>
@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

