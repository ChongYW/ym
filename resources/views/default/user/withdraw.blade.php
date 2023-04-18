@extends('mobile.default.wap')

@section("header")
    @parent
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
    @parent
@endsection

@section('body')
    <?php


    ?>

    <div class="user_zx_right" >
        <div class="box" style="margin-top: 50px">
            <div class="tagMenu">
                <ul class="menu">
                    <li ><a href="{{route("user.moneylog")}}">资金统计</a></li>
                    <li ><a href="{{route("user.recharge")}}">马上充值</a></li>
                    <li ><a href="{{route("user.recharges")}}">充值记录</a></li>
                    <li class="current"><a href="{{route("user.withdraw")}}">马上提现</a></li>
                    <li><a href="{{route("user.withdraws")}}">提现记录</a></li>
                    <li><a href="{{route("user.offline")}}">下线分成记录</a></li>

                </ul>
                <div class="hite"> <span id="account"></span> </div>
            </div>
        </div>




        <div class="myinfo" style="padding: 6px; margin-bottom: 15px;background:#fff;">
            <p style="margin:15px 0px;">温馨提示：提现金额最低为<?php echo Cache::get("withdrawalmin");?>元。</p>
            <form action="" method="post" id="withdraw">
            <table border="0" width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;table-layout-:fixed;" height="90" id="alipay">

                <tbody><tr>
                    <td bgcolor="#f5f5f5" height="34" style="background:#F9F9F9;border-top:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px; font-size:16px; text-align:center;" colspan="2">马上提现</td>
                </tr>
                <tr height="40">
                    <td width="60" align="right" style="background:#F9F9F9;border-top:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;">会员账号：</td>
                    <td width="200" style="border-right:#e6e6e6 solid 1px;border-top:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;"><?php  echo $Member->username;?></td>
                </tr>
                <tr height="40">
                    <td width="60" align="right" style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;">目前可用额度：</td>
                    <td width="200" style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;"><?php echo $Member->amount; ?></td>
                </tr>
                <tr height="60">
                    <td style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;" align="right">提现额度：</td>
                    <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;">

                        <input type="number" name="amount"   min="0.00" step="0.01" style="width:130px; height:40px; line-height:40px; border-radius: 15px; border:#CCCCCC solid 1px; padding:0px 8px;">

                    </td>
                </tr>
                <tr height="60">
                    <td style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;" align="right">交易密码：</td>
                    <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;"><input type="password" name="paypwd" id="paypwd" style="width:130px; height:40px; line-height:40px; border-radius: 15px; border:#CCCCCC solid 1px; padding:0px 8px;"> </td>
                </tr>

                <tr height="50">
                    <td style="border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;" align="right"></td>
                    <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; color:#ff9600; padding-left:3px;">

                        <input style="background:#3579f7; height:30px; line-height:30px; width:110px; border:0px; color:#FFFFFF; font-size:14px;" type="button" onclick="SubForm()" value="马上提现"> <input type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btncancel" onClick="location.href=location.href;" id="btn_cancel"></td>
                </tr>
                </tbody></table>



                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>








            </form>
        </div>



    </div>

<script>


    function SubForm() {

       var datas= $("#withdraw").serialize();

        $.ajax({
            url: '{{route("user.withdraw")}}',
            type: 'post',
            data: datas,
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
                             window.location.reload();
                        }else if(data.url){
                            window.location.href=data.url;
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

