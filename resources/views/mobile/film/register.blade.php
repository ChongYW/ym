@extends('mobile.film.wap')

@section("header")
    <header>
        <a href="javascript:history.go(-1);">
            <img src="{{asset("mobile/film/images/back.png")}}" class="left backImg">
        </a>
        <span class="headerTitle">用户注册</span>
    </header>
@endsection

@section("js")
    @parent

@endsection

@section("css")

    @parent


@endsection



@section('body')

    <form class="layui-form">
    <div class="register">


        <div class="ipt formItemBorder" style="border:none;">

            <div class="left">

                <input type="text" class="inputText"
                       style="border:1px solid #eeeeee;width:140px;height:40px; line-height:40px;font-size:14px;background-color:#FFF; border-radius:6px;"
                       id="code" name="captcha" size="10" placeholder="右边验证码" lay-reqText="输入验证码" lay-verify="required" maxlength="5">

                <img src="{!! captcha_src('flat') !!}"
                     alt="验证码"  style="cursor:pointer;"
                     onclick="this.src='{!! captcha_src('flat') !!}'+Math.random()" id="code_img"/>

            </div>

        </div>

        <div class="iptCase">

            <input name="phone" id="mobile" label="手机号码" placeholder="请输入有效的手机号码" maxlength="11" type="text"
                   class="left ipt_textcc input" lay-reqText="请输入有效的手机号码" lay-verify="required|phone|number">

        </div>

        @if(\Cache::get('smsverifi')=='开启')
        <div class="ipt formItemBorder" style="border:none;">

            <div class="left">

                <input type="text" name="code" id="mobile_verify" value="" maxlength="6" size="14" placeholder="输入短信验证码"
                       class="inputText"
                       style="border:1px solid #eeeeee;width:45%;height:40px; line-height:40px;font-size:14px;background-color:#FFF; border-radius:6px; float:left;margin-right: 5px;" lay-reqText="输入短信验证码" lay-verify="required">
                <div id="mobile_div" style="vertical-align:middle;height:30px; line-height:30px; float:left;width:45%;">

                    <input onclick="sendsms()" id="yuanzheng" class="catchCode left" type="button" value="获取手机验证码">

                </div>

                <div id="mobile_send_div"
                     style="display:none;vertical-align:middle;height:30px; line-height:30px; float:left;width:45%;">

                    <button type="button" id="GetVerify" onclick="sendsms()" class="catchCode left">重获短信验证码</button>
                </div>

            </div>
        </div>
        @endif



{{--        <div class="iptCase">

            <input type="text" id="username" name="username" size="36" class="left ipt_textcc input"
                   placeholder="请输入用户名" maxlength="12" lay-reqText="请输入用户名" lay-verify="required|username">

        </div>--}}
        <div class="iptCase">

            <input type="password" id="password" name="password" placeholder="登录密码6~18位字符" class="left ipt_textcc input"
                   maxlength="18" lay-reqText="请输入登录密码" lay-verify="required|password">

        </div>

        <div class="iptCase">

            <input type="password" id="pwdconfirm" name="pwdconfirm" placeholder="确认密码,两次密码输入必须一致"
                   class="left ipt_textcc input" maxlength="18" lay-reqText="请输入确认密码" lay-verify="required|pwdconfirm">

        </div>


        <div class="iptCase">

            <input type="text" id="shiming" name="qq" size="36" class="left ipt_textcc input"
                   placeholder="微信或者QQ(选填)" >

        </div>

        <div class="iptCase">

            <input type="text" id="recommend" name="yaoqingren" value="{{$yaoqingren}}" size="36" class="left ipt_textcc input"
                   placeholder="无推荐人请留空" lay-reqText="请输入推荐人ID" maxlength="10">

        </div>

        <div class="formItemBorder textCenter">
            <button class="finishReg" lay-submit lay-filter="*">立即注册</button>
            <button type="button" class="finishReg doing" style="display: none;">正在处理</button>

        </div><input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <div class="formItemBorder textRight" style="margin: 0 auto;width: 94%">
            <p>已有账号？<a href="{{route("wap.login")}}" class="color">立即登录</a></p>
        </div>
    </div>
    </form>
    <script>

        function sendsms() {
           var mobile=$("#mobile").val();
           var captcha=$("[name='captcha']").val();

            $.ajax({
                type: "POST",
                data: {
                    tel:mobile,
                    captcha:captcha,
                    _token:"{{ csrf_token() }}",
                },
                url: "{{route("wap.sendsms")}}",
                beforeSend: function () {

                },
                success: function (data) {

                    layer.msg(data.msg);
                    if(data.status==1){
                        $("#code_img").attr({src:'{!! captcha_src('flat') !!}'+Math.random()});
                    }else{
                        $("#mobile_div").hide();
                        $("#mobile_send_div").show();
                    }


                    },
                error: function () {

                },
                dataType: "json"
            })

        }
    </script>
    <script>
        layui.use('form', function(){
            var form = layui.form;



            form.verify({
                username: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
                        return '用户名不能有特殊字符';
                    }
                    if(/(^\_)|(\__)|(\_+$)/.test(value)){
                        return '用户名首尾不能出现下划线\'_\'';
                    }
                    if(/^\d+\d+\d$/.test(value)){
                        return '用户名不能全为数字';
                    }

                    if (value.length > 12) {
                        return '用户名3-12位';
                    }
                    if (value.length < 3) {
                        return '用户名3-12位';
                    }

                }


                //我们既支持上述函数式的方式，也支持下述数组的形式 password
                //数组的两个值分别代表：[正则匹配、匹配不符时的提示文字]
                ,password: [
                    /^[\S]{6,18}$/
                    ,'密码必须6到18位，且不能出现空格'
                ]
                ,pwdconfirm: function(value, item) {
                    var password = $("input[name='password']").val();
                    if(password!=value){
                        return '两次密码不一致';
                    }
                }
            });

            form.on('submit(*)', function(data){
                //console.log(data.elem) //被执行事件的元素DOM对象，一般为button对象
                //console.log(data.form) //被执行提交的form对象，一般在存在form标签时才会返回
               // console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}



                $.ajax({
                    type: "POST",
                    data: data.field,
                    url: "{{route("wap.register")}}",
                    beforeSend: function () {
                       // $(".finishReg").attr({disable:true}).text("正在注册")

                        $(".finishReg").hide();
                        $(".doing").show();
                    },
                    success: function (datas) {
                        //$(".finishReg").attr({disable:true}).text("注册中...");

                        $(".finishReg").hide();
                        $(".doing").show();
                        var status = datas.status;
                        //console.log(datas.status);
                        if (status=='1') {
                            $(".error_tip").show(), $("#error_detail_message").html(data.msg);
                            layer.alert(datas.msg);
                            //$(".finishReg").attr({disable:false}).text("立即注册");

                            $(".finishReg").show();
                            $(".doing").hide();
                            $("#code_img").attr({src:'{!! captcha_src('flat') !!}'+Math.random()});
                        } else {


                            layer.open({
                                content: datas.msg,
                                btn: '确定',
                                shadeClose: false,
                                yes: function (index) {
                                    layer.close(index);
                                    //console.log(datas.status);


                                     window.location.href = "{{route("wap.login")}}";



                                }
                            });


                        }
                    },
                    error: function () {

                    },
                    dataType: "json"
                })

                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });



        });
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
    {!! Cache::get("waptongjicode") !!}
@endsection
@section("playSound")

@endsection

