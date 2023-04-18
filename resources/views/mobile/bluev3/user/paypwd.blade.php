@extends('mobile.bluev3.wap')

@section("header")

@endsection

@section("js")
    @parent

@endsection

@section("css")

    @parent


@endsection

@section("onlinemsg")

@endsection

@section('body')



    <div class="othertop">
        <a class="goback" href="javascript:history.back();"><img src="{{asset("mobile/bluev3/img/goback.png")}}" style="margin: 0px;"/></a>
        <div class="othertop-font">修改交易密码</div>
    </div>
    <div class="header-nbsp"></div>
    <div class="login_bg">
        <form action="" method="post" id="ifr">
            <div class="input_text cert">
                <label>原交易密码</label>
                <input type="password" name="pass" id="pass" placeholder="请输入交易密码">
            </div>
            <div class="input_text cert">
                <label>新交易密码</label>
                <input type="password" name="newpass" id="newpass" placeholder="请输入新交易密码">
            </div>
            <div class="input_text cert">
                <label>确认密码</label>
                <input type="password" name="renewpass" id="renewpass" placeholder="请输入确认密码">
            </div>

            <!--div class="input_text cert">
                <label>手机验证码</label>
                <a style="background:#3579f7;padding:5px; color:#FFFFFF; font-size:14px;float:right;" id="hqcode" href="javascript:hqcode()">获取手机验证码</a>
                <input class="right" type="text" name="telcode" id="telcode" maxlength="6" placeholder="请输入手机验证码" style="width: 40%;">
            </div-->
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <input type="button" class="input_btn" value="完成修改" onclick="SubForm()"/>
        </form>
    </div>







    <script>

        function miaocode(str) {
            $("#hqcode").html((str - 1) + "秒后重新获取");
            if (str > 0) {
                setTimeout('miaocode(' + (str - 1) + ')', 1000);
            } else {
                $("#hqcode").attr("background", "FF9900");
                $('#hqcode').attr('href', 'javascript:hqcode();');
                $("#signtelCode").html("");
                $("#hqcode").html("重新获取手机验证码");
            }
        }

        function hqcode() {

            var _token = $("[name='_token']").val();
            var action = $("[name='action']").val();
            var dianhua = $("[name='dianhua']").val();
            var url = "/user/SendCode";
            $.post(url, {
                    "action": 'regcode',
                    "_token": _token
                },
                function(data) {
                    if (data.status == 0) {
                        $("#hqcode").attr("background", "cccccc");
                        $("#signtel").attr("readonly", "readonly");
                        $("#hqcode").html("60秒后重新获取");
                        $('#hqcode').attr('href', 'javascript:vide(0);');
                        setTimeout('miaocode(60)', 1000);
                    } else if (data.status == 1) {
                        $("#signtelCode").html("对不起！手机验证系统维护中，暂时不可用");
                        return false;
                    } else {
                        $("#signtelCode").html(data.msg);
                        return false;
                    }
                });

        }

        function SubForm(id) {


            $.ajax({
                url: '{{route("user.paypwd")}}',
                type: 'post',
                data: $("form").serialize(),
                dataType: 'json',
                error: function () {
                },
                success: function (data) {
                    layer.open({
                        content: data.msg,
                        btn: '确定',
                        shadeClose: false,
                        yes: function(index){
                            if(data.status==0){
                                history.go(-1);
                            }

                            layer.close(index);
                        }
                    });
                }
            });
        }

    </script>


@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

