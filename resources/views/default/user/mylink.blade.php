@extends('mobile.default.wap')

@section("header")

    <div class="top" id="top" >
        <div class="kf">
            <p><a class="sb-back" href="javascript:history.back(-1)" title="返回"
                  style=" display: block; width: 40px;    height: 40px;
                          margin: auto; background: url('{{asset("mobile/images/arrow_left.png")}}') no-repeat 15px center;float: left;
                          background-size: auto 16px;font-weight:bold;">
                </a>
            </p>
            <div style="display: block;width:100%; position: absolute;top: 0;
     left: 0;text-align: center;  height: 40px; line-height: 40px; ">
                <a href="javascript:;" style="text-align: center;  font-size: 16px; ">{{Cache::get('CompanyLong')}}</a>
            </div>

        </div>
    </div>

    <link rel="stylesheet" href="{{asset("mobile/public/Front/css/common.css")}}" />

    <link rel="stylesheet" type="text/css" href="{{asset("mobile/public/style/css/style.css")}}"/>
    <link href="{{asset("mobile/public/Front/user/user.css")}}" type="text/css" rel="stylesheet">
    <script type="text/javascript" charset="utf-8" src="{{asset("mobile/public/Front/user/user.js").'?t='.time()}}"></script>
@endsection
@section("js")
    @parent

     <script type="text/javascript" src="{{ asset("admin/lib/layui/layui.js")}}" charset="utf-8"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset("admin/lib/layui/css/layui.css")}}"/>
@endsection

@section("css")

    @parent


@endsection

@section("onlinemsg")

@endsection

@section('body')

    <div class="" style="height: 40px"></div>
    <div class="main_top_1" style="">
        <div class="mt" style="position:relative;">
    <div class="user_zx_right" >
        <div class="box" >
            <div class="tagMenu">
                <ul class="menu">

                    <li class="current"><a href="{{route("user.mylink")}}">推广链接</a></li>
                    <li ><a href="{{route("user.record")}}">推广记录</a></li>
                    <li><a href="{{route("user.offline")}}">下线分成</a></li>
                    <li ><a href="{{route("user.offline.budget")}}">下线收支</a></li>



                </ul>
                <div class="hite"> <span id="account"></span> </div>
            </div>
        </div>


        <div class="myinfo" style=" margin-bottom: 15px;background:#fff;padding: 5px;">
            <p align="center" ; style="font-size: 16px;color:#3579f7 ;margin:5px 0px;">您的推广ID</p>
            <p align="center" ; style="font-size: 14px;color:#3579f7;margin:5px 0px; "><?php echo $Member->invicode; ?></p>
            <p style="margin:15px 0px;">1、尊敬的<?php echo \Cache::get('CompanyShort'); ?>
                会员，以下是您在<?php echo \Cache::get('CompanyShort'); ?>的邀请链接。<br>
                <input size="48" value="{{route('wap.register.user',['user'=>$Member->invicode])}}" style="height: 31px;
color: black;" id="link">

            </p>
            <div class="layui-form-item">

                <button class="layui-btn layui-inline copyinvicode" style="width: 80%;margin: 0 auto;" >复制邀请链接</button>


            </div>

            <p style="margin:30px 0px; background:#CCCCCC; height:auto; line-height:30px; padding:5px; color:#FFFFFF; font-size:12px;display:none;">
                您的邀请链接：<input size="48" value="<?php echo \Cache::get('AppDownloadUrl'); ?>" style="height: 31px;
color: black;" id="link"><br> <span id="copyBtn">请手动选中链接网址并复制</span>
            </p>
            <p >2、二维码复制给好友，扫一扫进行推荐</p>
            <p id="codebg" style="background-image: url('{{route("user.QrCode")}}');-moz-background-size:100% 100%; background-size:100% 100%;width:60%;margin-left: 20%;">

               {{-- <a href="{{route("user.QrCode")}}">打开另存为图片</a>--}}


<!--
                <span align="center" ; style="font-size: 20px;
    color: #ff0000;
    margin: 68% 24%;
    width:50%;
    position: absolute; "><?php echo "推广ID:".$Member->invicode; ?></span>
    -->
            </p>




            <div class="layui-form-item">

                    <button class="layui-btn layui-inline copy" style="width: 80%;margin: 0 auto;" >复制推广ID</button>


            </div>

            <div class="layui-form-item">

                    <a class="layui-btn layui-inline" style="width: 80%;margin: 0 auto;" href="{{route("user.QrCode")}}" >存为图片</a>

            </div>


            <p>邀请有好礼！</p>
            <p>
                您可以通过QQ、微信，微博，邮件等方式把推荐注册链接发送给您的好友，成功注册并充值投资，您将获得此好友投资项目金额1%-5%的奖金（根据不同的项目有不同的返佣金额），奖金详细和比例请您查看各项目的详细说明。用户不得自己推荐自己如发现将冻结用户非法获得的佣金。</p>
        </div>


    </div>
    </div>
    </div>
    <script>

        var copyBtn = document.querySelector('.copy');
        var copyinvicodeBtn = document.querySelector('.copyinvicode');

        // 点击的时候调用 copyTextToClipboard() 方法就好了.
        copyBtn.onclick = function() {
            copyTextToClipboard('<?php echo $Member->invicode; ?>')
        };
        // 点击的时候调用 copyTextToClipboard() 方法就好了.
        copyinvicodeBtn.onclick = function() {
            copyTextToClipboard('{{route('wap.register.user',['user'=>$Member->invicode])}}')
        };

        function copyTextToClipboard(text) {
            var textArea = document.createElement("textarea")

            textArea.style.position = 'fixed'
            textArea.style.top = 0
            textArea.style.left = 0
            textArea.style.width = '2em'
            textArea.style.height = '2em'
            textArea.style.padding = 0
            textArea.style.border = 'none'
            textArea.style.outline = 'none'
            textArea.style.boxShadow = 'none'
            textArea.style.background = 'transparent'
            textArea.value = text

            document.body.appendChild(textArea)

            textArea.select()

            try {
                var msg = document.execCommand('copy') ? '成功' : '失败'
                alert('复制内容 ' + msg);
            } catch (err) {
                alert('不能使用这种方法复制内容');
            }

            document.body.removeChild(textArea)
        }

    </script>
    <script>
        var width= window.screen.width;
        $("#codebg").height(width*0.6);

    </script>

@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

