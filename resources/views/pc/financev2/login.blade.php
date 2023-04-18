@extends('pc.financev2.pc')

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
    <style>.login-img-bg {
            display: block;
            height: 500px;
            background: url("/pc/finance/css/images/login-bg.jpg") no-repeat center center
        }
    </style>

    <div style="width:100%;height:500px;" class="login-img-bg">
        <div class="w1100 mr_b20">
            <div class="login_bg border1 oh" style="padding-bottom:0px;">

                <div class="member_login">
                    <div class="login_left m_ptc login_shadow">
                        <div class="log_tit"> <img src="/pc/finance/css/images/login_photo.jpg"> </div>
                        <div class="login_center">
                            <input type="hidden" name="forward" id="forward" value="">
                            <div class="log_li">
                                <label for="username" class="basic_label">帐号</label>
                                <input type="text" id="username" name="username" autocomplete="off" value="" placeholder="用户名" class="basic_input">
                            </div>
                            <div class="log_li">
                                <label for="password" style="display:inline; float:left;" class="basic_label">密&nbsp;&nbsp;码</label>
                                <input type="password" id="password" name="password" class="basic_input" placeholder="密码">
                            </div>

                            <div class="login_warning"><span id="tip"></span> </div>
                            <div class="log_li">
                                <p>
                                    <input id="loginBt" name="登录" value="登 录" onclick="loginSubmit();" type="button" class="user_login_btn">
                                </p>
                            </div>
                            <div class="log_li reg">
                                <p>
                                    <a href="{{route('pc.register')}}" class="forget_pwd">注册新账户</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="{{route('pc.forgot')}}" class="forget_pwd">忘记密码?</a>
                                </p>
                            </div>
                        </div>
                        <div class="login_border"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">


        function loginSubmit() {


            var returnVal = $.ajax({
                url: "{{route("pc.login")}}",

                data: {
                    _token: "{{ csrf_token() }}",
                    username: $("#username").val(),
                    password: $("#password").val()
                },
                type: "POST",
                async: false,
                cache: 'false',
                success: function (data) {

                    if (data.status) {
                        $("#errs").html(data.msg);
                        $("#errs").show();
                    }


                    layui.use('layer', function(){
                            var layer =layui.layer;

                    layer.msg(data.msg, {time:2000}, function (index) {
                            if (!data.status) {
                                if (data.url != '') {
                                    window.location.href = data.url;
                                } else {
                                    window.location.href = '{{route('user.index')}}';
                                }

                            }

                            layer.close(index);

                    });
                    });

                },
                error: function (msg) {
                    layer.alert('网络异常，请重新提交');

                }
            }, 'josn');
        }




    </script>

@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

