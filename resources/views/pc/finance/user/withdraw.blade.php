@extends('pc.finance.pc')

@section("header")
    @parent

@endsection

@section("js")

    @parent

@endsection

@section("css")

    @parent
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/user/user.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/user/member.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/user/public.css")}}"/>

@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')




    <div class="w1200">
        <div class="cur_pos"><a href="/"> 首页</a> &gt; <a href="{{route('user.index')}}" target="_blank">会员中心</a></div>
        <div class="noticewrapbg" style=" background-color:#FFF">
            <div class="notice">
                <div class="title" style="margin-left:10px;"><a href="#">最新公告</a></div>
                <div class="marquee" style="line-height:24px; font-size:14px; width:1000px;padding-top: 10px;">
                    <ul style="margin-top: 0px;">
                        <marquee scrolldelay="200" onmouseout="this.start()" onmouseover="this.stop()"><strong
                                    style="color: rgb(0, 0, 255); font-family: 'Microsoft YaHei', tahoma, arial, sans-serif; font-size: 18px; line-height: 27px;"> {{Cache::get('gg')}} </strong>
                        </marquee>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="wrapper">


                <div class="clearfix">

                    @include('pc.finance.user.userleft')

                    <div class="r-user-border white-bg bfc">
                        <ul class="user-tabs-menu clearfix">
                            <li class="selected"><a href="{{route('user.withdraw')}}">账户提现</a></li>
                            <li><a href="{{route('user.withdraws')}}">提现记录</a></li>
                        </ul>
                        <div class="user-tabs-cont">
                            <div class="u-recharge">

                                <div class="prompt">
                                    <dl>
                                        <dt>
                                            温馨提示：
                                        </dt>
                                        <dd>
                                            1. 在您申请提现前，请先绑定银行卡；
                                        </dd>
                                        <dd>
                                            2. 为保障您的账户资金安全，申请提现时，您选择的银行卡开户名必须与您本站账户实名认证一致，否则提现申请将不予受理；
                                        </dd>
                                        <dd>
                                            3. 提现时，您不能选择将资金提现至信用卡账户，请您选择银行储蓄卡账户提交提现申请。
                                        </dd>
                                        <dd>
                                            4. 为防止恶意提现，会员每十分钟只能提现一次。
                                        </dd>
                                        <dd style="color: red;">
                                            5. 在您做出提现申请后提现到账时间是15分钟到，具体时间以银行到账为准。
                                        </dd>
                                    </dl>
                                </div>

                                <div class="accout-tx">

                                    <script language="javascript">

                                        function SubForm() {


                                            var ymoney =<?php echo sprintf("%.2f", $Member->amount); ?>;
                                            var tmoney = document.getElementById("amount").value;


                                            if (tmoney < 100) {
                                                layer.alert("最小提现为100元！");
                                                document.getElementById("amount").focus();
                                                return false;

                                            }
                                            if (isNaN(tmoney)) {
                                                layer.alert("请输入数字");
                                                document.getElementById("amount").focus();
                                                return false;

                                            }
                                            if (tmoney > ymoney) {
                                                layer.alert("您的可提现金额为￥" + ymoney + "元，不能提现！");
                                                document.getElementById("amount").focus();
                                                return false;

                                            }
                                            if (tmoney <= 0) {
                                                layer.alert("您的输入有误");
                                                document.getElementById("amount").focus();
                                                return false;

                                            }


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


                                    <div class="mb clearfix">
                                        <label>可提现额度：</label>
                                        <p>
                                            <span>￥<font
                                                        style="color:#F00; font-size:22px;font-weight:700"><?php echo sprintf("%.2f", $Member->amount); ?></font>元</span>
                                        </p>
                                    </div>
                                    <form action="" method="post" id="withdraw">
                                    <div class="mb clearfix">
                                        <label><span class="red3">*</span>提现金额：</label>
                                        <input type="text" name="amount" id="amount" maxlength="8" placeholder="输入提现金额"
                                               value="">
                                        <span class="dw">元</span>
                                        <div id="zijinTip" class="onShow">请输入提现金额</div>
                                    </div>
                                    <div class="mb clearfix">
                                        <label><span class="red3">*</span>支付密码：</label>
                                        <input type="password" name="paypwd" id="paypwd" placeholder="输入支付密码"
                                               maxlength="18">
                                        <div id="zfpasswordTip" class="onShow">请输入支付密码</div>
                                    </div>

                                    <div class="form-btn">
                                        <input type="button" name="dosubmit" id="dosubmit" class="green-btn btn"
                                               value="申请提现" onclick="SubForm()">
                                    </div>


                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>





@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

