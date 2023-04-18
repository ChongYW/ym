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
        <div class="othertop-font">修改登录密码</div>
    </div>
    <div class="header-nbsp"></div>
    <div class="login_bg">
        <form action="" method="post" id="ifr">
            <div class="input_text cert">
                <label>原登录密码</label>
                <input type="text" name="pass" id="pass" placeholder="请输入登录密码">
            </div>
            <div class="input_text cert">
                <label>新登录密码</label>
                <input type="password" name="newpass" id="newpass" placeholder="请输入新登录密码">
            </div>
            <div class="input_text cert">
                <label>确认密码</label>
                <input type="password" type="password" name="renewpass" id="renewpass" placeholder="请输入确认密码">
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <input type="button" class="input_btn" onclick="SubForm()" value="完成修改" />
        </form>
    </div>





    <script>


        function SubForm(id) {


            $.ajax({
                url: '{{route("user.password")}}',
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

