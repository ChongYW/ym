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

    <div class="w1100 mr_b20">
        <div class="forgetpwd border1 oh">
            <h1>忘记密码</h1>


            {{--<div class="forgetpwd1 mr">
                <ul>
                    <li class="active">输入账号信息</li>
                    <li class="w140">手机号码确认</li>
                    <li class="w130">手机收到新密码</li>
                </ul>
            </div>--}}
            <div class="forgetpwd_box1 mr">
                <div class="clear"></div>
                <div class="HomeCon1_1">


                        <div id="pwd_0">
                            <div class="gb_pwd_item j_pwd pwd_item" id="o_by_email">
                                <label for="username"><span class="red">*</span>登录帐号</label>
                                <input type="text" id="username" name="username" placeholder="请输入登录帐号" class="basic_input email" maxlength="11" >
                                <div id="error" class="onError"></div></div>

                            <div class="gb_pwd_item j_pwd pwd_item" id="o_by_email">
                                <label for="username"><span class="red">*</span>手机号</label>
                                <input type="text" id="mobile" name="mobile" placeholder="请输入有效的手机号码" class="basic_input email" maxlength="11" data-rule="手机号: required; mobile">
                                <div id="error" class="onError"></div></div>
                            <div class="gb_pwd_item verify_code pwd_item">
                                <label for="valicode"><span class="red">*</span>验证码</label>
                                <input type="text" id="code" name="code" size="10" class="basic_input w80 yzm" style="width:100px;">
                                <img src="{!! captcha_src('flat') !!}"
                                     alt="验证码"  style="cursor:pointer;"
                                     onclick="this.src='{!! captcha_src('flat') !!}'+Math.random()" id="codeImg"/>

                                <div id="codeTip" class="onShow">请输入验证码</div></div>
                            <div class="gb_pwd_item p15 pwd_item">

                                <input type="submit" name="dosubmit" value="重置密码" class="get_pwd_sub  pwd_btn">
                            </div>
                        </div>

                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $('.get_pwd_sub').click(function(){
            var username = $("#username").val();
            var mobile   = $("#mobile").val();
            var code     = $("#code").val();
            if(!username){
                $("#error").html("请填写用户名");
                return ;
            }
            if(!mobile){
                $("#error").html("请填写手机号码");
                return ;
            }
            if(!code){
                $("#error").html("请填写验证码");
                return ;
            }

            $.ajax({
                type : "POST",
                url : "{{route("pc.forgot")}}",
                dataType : "json",
                data : 'username=' + username + '&mobile=' + mobile  + '&captcha=' + code+'&_token={{ csrf_token() }}',
                success : function (data) {


                    layer.open({
                        content: data.msg,
                        btn: '确定',
                        shadeClose: false,
                        yes: function (index) {
                            if (data.status==0) {
                                if (data.url) {
                                    window.location.href = data.url;
                                } else {
                                    window.location.href = '{{route('pc.login')}}';
                                }

                            }

                            layer.close(index);
                        }
                    });


                }
            });

        });
        function retCode() {
            //this.src='{!! captcha_src('flat') !!}'+Math.random()
            $("#codeImg").attr("src", '{!! captcha_src('flat') !!}'+Math.random());
        }
    </script>

@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

