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
    <div class="main_top_1">
        <div class="mt" style="position:relative;">
    <div class="user_zx_right" >
        <div class="box" >
            <div class="tagMenu">
                <ul class="menu">
                    <li ><a href="{{route("user.shiming")}}">实名认证</a></li>
                    <li ><a href="{{route("user.edit")}}">资料修改</a></li>
                    <li><a href="{{route("user.password")}}">修改登录密码</a></li>
                    <li><a href="{{route("user.paypwd")}}">修改交易密码</a></li>
                    <li><a href="{{route("user.paypwd.retrieve")}}">找回交易密码</a></li>
                    <li class="current"><a href="{{route("user.bank")}}">银行卡绑定</a></li>


                </ul>
                <div class="hite"> <span id="account"></span> </div>
            </div>
        </div>


        <div class="myinfo" style="padding:5px  10px; margin-bottom: 15px;background:#fff;">
            <p style="margin:5px;">尊敬的{{Cache::get('CompanyShort')}}用户，提现操作涉及您的资金安全，敬请仔细操作。</p>
            <form action="" method="post" class="layui-form">



                <table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0" style="margin-top:10px;"
                       height="90">
                    <tbody>
                    <tr>
                        <td width="221"><img src="{{asset("mobile/public/Front/user/bank.jpg")}}"></td>
                        <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px;border-top:#e6e6e6 solid 1px; color:#458ed0; padding-left:10px;font-size: 12px;">
                            <?php
                            if($Member->realname==''){

                            ?>
                            <script>
                                layer.open({
                                    content: '请先进行实名认证',
                                    btn: '确定',
                                    shadeClose: false,
                                    yes: function(index){
                                        parent.location.href='{{route("user.shiming")}}';

                                        layer.close(index);
                                    }
                                });
                            </script>
                            <?php
                            }
                            if ($Member->isbank==1) {
                                echo "温馨提示：您好，你已经绑定了银行卡信息，如需修改请联系客服。";
                            } else {
                                echo '温馨提示：你尚未绑定银行卡信息，填写以下信息完成绑定。';
                            } ?></td>
                    </tr>
                    </tbody>
                </table>


            <table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0" style="margin-top:10px;"
                   height="90">

                    <tbody>
                    <tr height="60">
                        <td width="197" align="right"
                            style="background:#F9F9F9;border-top:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;">
                            您当前的银行名称：
                        </td>
                        <td width="250"
                            style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px;border-top:#e6e6e6 solid 1px; padding-left:5px;">
                            <input type="text" name="bankname" id="bankname"  value="<?php echo  $Member->bankname;?>"
                                   style="width:200px; height:40px; line-height:40px; border-radius: 15px; border:#CCCCCC solid 1px; padding:0px 8px;">
                            例：工商银行
                        </td>
                    </tr>
                    <tr height="60">
                        <td style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;"
                            align="right">您银行账户户主姓名：
                        </td>
                        <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;">
                            <input type="text" id="bankrealname" name="bankrealname" value="<?php echo  $Member->bankrealname;?>"
                                   style="width:200px; height:40px; line-height:40px; border-radius: 15px; border:#CCCCCC solid 1px; padding:0px 8px;">

                        </td>
                    </tr>
                    <tr height="60">
                        <td style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;"
                            align="right">输入您的银行账号：
                        </td>
                        <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;">
                            <input type="text" name="bankcode" id="bankcode"   value="<?php echo  $Member->bankcode;?>"
                                   style="width:200px; height:40px; line-height:40px; border-radius: 15px; border:#CCCCCC solid 1px; padding:0px 8px;">
                            例：6*** **** **** **** ***(不含空格)
                        </td>
                    </tr>
                    <tr height="60">
                        <td style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;"
                            align="right">输入开户行支行名称：
                        </td>
                        <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;">
                            <input type="text" name="bankaddress" id="bankaddress"  value="<?php echo  $Member->bankaddress;?>"
                                   style="width:200px; height:40px; line-height:40px; border-radius: 15px; border:#CCCCCC solid 1px; padding:0px 8px;">
                            例：**省**市**支行
                        </td>
                    </tr>

                    <tr height="50">
                        <td style="border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;"
                            align="right"></td>
                        <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; color:#458ed0; padding-left:3px;">
                            <input type="hidden" value="bank" name="sessionAction" id="sessionAction">
                            <input type="button" onclick="SubForm()" value="提交" class="btnsubupdate">
                            <input type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btncancel"
                                   onclick="location.href=location.href;" id="btn_cancel"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p style="margin:10px 0px 0px 0px;">请用户尽量填写较大的银行（如农行、工行、建行、中国银行等）；</p>
                            <p style="margin-:5px 0px 10px 0px;">避免填写那些比较少见的银行（如农村信用社、地方银行等），
                                否则提现资金很容易会被退票；</p>
                            <p style="margin-:5px 0px 10px 0px;">如果选择其它银行，请在选择其它银行后填写该银行的名称；</p>
                            <p style="margin-:5px 0px 10px 0px;">请您填写完整联系方式，以便遇到问题时，工作人员可以及时联系到您；</p>
                            <p style="margin-:5px 0px 10px 0px;">绑定填写的银行资料都要真实正确的,如填写错误请联系在线客服更改.</p></td>
                    </tr>
                    </tbody>

            </table>
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            </form>
        </div>


    </div>
    </div>
    </div>

    <script>


        function SubForm(id) {


            $.ajax({
                url: '{{route("user.bank")}}',
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

