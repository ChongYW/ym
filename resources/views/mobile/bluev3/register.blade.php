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
    <style>
        .login_html{text-align: center;margin:0 auto;height: 90px;line-height:100px;font-size: 18px;color:#385fec;}
        .login_remark{text-align: center;margin-bottom: 15px;}
        .loggin_div{padding:2px 15px;border-radius:15px;margin:0 auto;width:85%;margin-bottom: 10px;}
        .loggin_div i{ left: 25px;top: .225rem;}
        .loggin_div input{width:85%;border-left:1px solid #e0e0e0;}

    </style>


    <div class="othertop">
        <a class="goback" href="javascript:history.back();"><img src="/mobile/bluev3/img/goback.png" /></a>

    </div>
    <div class="header-nbsp"></div>

    <div  class="login_html">
        <b>注册帐号</b>
    </div>



    <div class="login_bg">
        <form id="loginForm" class="layui-form">


            <div class="input_text log loggin_div i ui-top-title" >
                <i><img src="/mobile/bluev3/img/icon_tel.png"></i>
                <input type="text" id="mobile" name="phone" placeholder="请输入手机号" maxlength="11">
            </div>
            


            <div class="input_text log loggin_div i ui-top-title" >
                <i><img src="/mobile/bluev3/img/icon_pwd.png"></i>

                <input type="password" id="password" name="password" placeholder="登录密码6~18位字符" class="left ipt_textcc input"
                       maxlength="18" lay-reqText="请输入登录密码" lay-verify="required|password">

            </div>

            <div class="input_text log loggin_div i ui-top-title" >
                <i><img src="/mobile/bluev3/img/icon_pwd.png"></i>

                <input type="password" id="pwdconfirm" name="pwdconfirm" placeholder="确认密码,两次密码输入必须一致"
                       class="left ipt_textcc input" maxlength="18" lay-reqText="请输入确认密码" lay-verify="required|pwdconfirm">

            </div>


            <div class="input_text log loggin_div i ui-top-title" >
                <i><img src="/mobile/bluev3/img/icon_tel.png"></i>
                <input type="text" id="recommend" name="yaoqingren" value="{{$yaoqingren}}" size="36" class="left ipt_textcc input"
                       placeholder="推荐人不能为空" lay-reqText="请输入推荐人ID" maxlength="10">
            </div>

            <div class="input_text log loggin_div i ui-top-title" >
                <i><img src="{{asset("mobile/film/images/userPwd.png")}}"></i>
                <input type="text" id="code" name="captcha" placeholder="请输入验证码" maxlength="4">
                <img src="{!! captcha_src('flat') !!}"
                     alt="验证码"  style="cursor:pointer;height: 40px;margin-top:-45px;float:right;"
                     onclick="this.src='{!! captcha_src('flat') !!}'+Math.random()" id="code_img" />
            </div>
            @if(\Cache::get('smsverifi')=='开启')
            <div class="input_text log loggin_div i ui-top-title" >
                <i><img src="/mobile/bluev3/img/icon_tel.png"></i>
                <input type="text" name="code" id="mobile_verify" placeholder="输入短信验证码" maxlength="6">
                <input onclick="sendsms()" id="yuanzheng" class="catchCode left" type="button" value="获取手机验证码" style="cursor:pointer;height: 40px;margin-top:-45px;float:right;width:140px;">

                <input type="button" id="GetVerify" onclick="sendsms()" class="catchCode left" style="cursor:pointer;height: 40px;margin-top:-45px;float:right;width:140px;display: none;" value="重获短信验证码">

            </div>



            @endif


            <button class="finishReg input_btn" lay-submit lay-filter="*">立即注册</button>
            <button type="button" class="finishReg doing input_btn" style="display: none;">正在处理</button>

            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

        </form>
    </div>


    <script>

        function sendsms() {
           var mobile=$("#mobile").val();
           var captcha=$("[name='captcha']").val();

           if(mobile==''){
               layer.alert('请输入手机号码');
               return false;
           }

           if(captcha==''){
               layer.alert('请输入图形验证码');
               return false;
           }
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
                        $("#yuanzheng").hide();
                        $("#GetVerify").show();
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
                console.log(data.field) //当前容器的全部表单字段，名值对形式：{name: value}



                $.ajax({
                    type: "POST",
                    data:data.field,
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
    {!! Cache::get("waptongjicode") !!}
@endsection
@section("playSound")

@endsection

