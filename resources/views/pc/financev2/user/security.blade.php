@extends('pc.financev2.pc')

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
                        <h2 class="r-user-title">安全认证</h2>
                        <div class="safe-attast">
                            <div class="user-safe clearfix">
                                <div class="pic fl"><img src="{{asset("pc/finance/css/user/images/user_safe.png")}}" alt=""></div>
                                <div class="bar fl">
                                    <?php
                                    $useranquan=10;
                                    if($Member->mobile!=''){
                                        $useranquan+=50;
                                    }
                                    if($Member->card!=''){
                                        $useranquan+=20;
                                    }
                                    if($Member->bankcode!=''){
                                        $useranquan+=20;
                                    }
                                    ?>
                                    <p>资料完善度：<span class="blue">{{$useranquan}}%</span></p>
                                    <div class="clearfix">
                                        <div class="progress fl">
                                            <div class="progress-bar" style="width:{{$useranquan}}%;"></div>
                                        </div>
                                        <div class="progress-text fl">{{$useranquan}}%</div>
                                    </div>


                                </div>
                            </div>
                            <div class="safe-bottom" id="safe-bottom">
                                <dl class="safe-list">


                                    <dt class="modify-type clearfix" id="list-realname">
                                        <i class="safe-name-yes fl"></i>
                                        <div class="safe-btn fr">
                                            <a href="javascript:void(0);" class="btnModify blue" onclick="$('.sfz').toggle()">@if($Member->card=='')实名认证@else认证成功@endif</a>                                          </div>

                                        <p class="bfc"><span>实名认证</span>
                                            <br>您认证的实名必须与您绑定银行卡的开户名一致，否则将无法成功提现。</p>
                                    </dt>


                                    @if($Member->card=='')


                                        <div class="prompt sfzkai" style="display: none;">

                                            <dt>
                                                <font color="red" style="font-size:14px" class="sfzname"></font>
                                                <font color="red" class="onCorrect" style="font-size:16px">已提交</font>
                                            </dt>


                                        </div>

                                    <dd class="modify-cont random sfz" style="display: none;">



                                        <div class="user-form">
                                            <form action="" method="post" id="edit">
                                                <div class="mb clearfix">
                                                    <label><span class="red3">*</span>姓名</label>
                                                    <p class="fl">
                                                        <input name="realname" type="text" id="realname" value="{{$Member->realname}}" placeholder="输入姓名" class="n-invalid">
                                                    <div id="shimingTip" class="onShow">请输入姓名</div></p>
                                                </div>
                                                <div class="mb clearfix">
                                                    <label><span class="red3">*</span>身份证号码</label>
                                                    <p class="fl">
                                                        <input name="card" id="card" value="{{$Member->card}}" type="text" placeholder="输入有效身份证号">
                                                    <div id="sfzTip" class="onShow">请输入身份证</div></p>
                                                </div>
                                                <input type="button" value="直接认证" class="form-btn btn green-btn" onclick="SubForm('edit')">


                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                            </form>
                                        </div>

                                        <script>


                                            function SubForm(id) {


                                                $.ajax({
                                                    url: '{{route("user.edit")}}',
                                                    type: 'post',
                                                    data: $("#"+id).serialize(),
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

                                                                    $('.sfzname').html('姓名：'+$('#realname').val()+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;身份证号码 : '+$('#card').val()+'');
                                                                    $('.sfz').remove();
                                                                    $('.sfzkai').show();

                                                                }

                                                                layer.close(index);
                                                            }
                                                        });
                                                    }
                                                });
                                            }

                                        </script>

                                    </dd>

                                    @else
                                    <div class="prompt">

                                        <dt>
                                            <font color="red" style="font-size:14px">姓名：{{$Member->realname}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;身份证号码 : {{$Member->card}}</font><font color="red" class="onCorrect" style="font-size:16px">已提交</font></dt>


                                    </div>

                            @endif
                                </dl>
                                <dl class="safe-list">
                                    <dt class="modify-type clearfix" id="list-password">
                                        <i class="safe-pw-yes fl"></i>
                                        <div class="safe-btn fr">
                                            <a href="javascript:void(0);" class="btnModify blue" onclick="$('.password').toggle()">修 改</a>        </div>
                                        <p class="bfc"><span>登录密码</span><br>登录账户时需要输入的密码。</p>
                                    </dt>
                                    <dd class="modify-cont password" style="display: none;">
                                        <div class="user-form">
                                            <p class="ts">为了您的账户安全，请定期更换登录密码，并确保登录密码设置与交易密码不同。</p>
                                            <form action="" method="post" class="layui-form" id="setpassword">
                                                <div class="mb clearfix">
                                                    <label><span class="red3">*</span>原密码</label>
                                                    <p class="fl">
                                                        <input name="pass" type="password" id="password" placeholder="6~20位字符" maxlength="18" aria-required="true">
                                                    <div id="passwordTip" class="onShow">请输入原密码</div></p>
                                                </div>
                                                <div class="mb clearfix">
                                                    <label><span class="red3">*</span>新密码</label>
                                                    <p class="fl">
                                                        <input name="newpass" type="password" id="newpassword" placeholder="6~20位字符" maxlength="18" aria-required="true">
                                                    <div id="newpasswordTip" class="onShow">请输入新密码</div></p>
                                                </div>
                                                <div class="mb clearfix">
                                                    <label><span class="red3">*</span>确认新密码</label>
                                                    <p class="fl">
                                                        <input name="renewpass" type="password" id="renewpassword" placeholder="两次密码输入必须一致" maxlength="18" aria-required="true">
                                                    <div id="renewpasswordTip" class="onShow">请输入确认密码</div></p>
                                                </div>
                                                <input name="dosubmitcc" type="button" id="dosubmitcc" value="确认修改" class="form-btn btn green-btn" onclick="SubFormPass('setpassword')">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                            </form>
                                        </div>

                                        <script>


                                            function SubFormPass(id) {


                                                $.ajax({
                                                    url: '{{route("user.password")}}',
                                                    type: 'post',
                                                    data: $("#"+id).serialize(),
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
                                                                    $('input[type="password"]').val('');
                                                                    $('.password').toggle();
                                                                }

                                                                layer.close(index);
                                                            }
                                                        });
                                                    }
                                                });
                                            }

                                        </script>

                                    </dd>
                                </dl>
                                <dl class="safe-list">
                                    <dt class="modify-type clearfix" id="list-paypassword">
                                        <i class="safe-pay-pw-yes fl"></i>
                                        <div class="safe-btn fr">
                                            <a href="javascript:void(0);" class="btnModify blue" onclick="$('.paypass').toggle()">修 改</a>        </div>
                                        <p class="bfc"><span>支付密码</span><br>投资或者提现时需要输入的密码。</p>
                                    </dt>
                                    <dd class="modify-cont paypass" style="display: none;">
                                        <div class="user-form">
                                            <p class="ts">密码请不要太过于简单，<span class="blue">支付原始密码默认为初次注册密码</span></p>

                                            <form action="" method="post" class="layui-form" id="setpaypassword">
                                                <div class="mb clearfix">
                                                    <label><span class="red3">*</span>原交易密码</label>
                                                    <p class="fl">
                                                        <input name="pass" type="password" id="password" placeholder="6~20位字符" maxlength="18" aria-required="true">
                                                    <div id="passwordTip" class="onShow">请输入原交易密码</div></p>
                                                </div>
                                                <div class="mb clearfix">
                                                    <label><span class="red3">*</span>新交易密码</label>
                                                    <p class="fl">
                                                        <input name="newpass" type="password" id="newpassword" placeholder="6~20位字符" maxlength="18" aria-required="true">
                                                    <div id="newpasswordTip" class="onShow">请输入新交易密码</div></p>
                                                </div>
                                                <div class="mb clearfix">
                                                    <label><span class="red3">*</span>确认新交易密码</label>
                                                    <p class="fl">
                                                        <input name="renewpass" type="password" id="renewpassword" placeholder="两次密码输入必须一致" maxlength="18" aria-required="true">
                                                    <div id="renewpasswordTip" class="onShow">请输入确认交易密码</div></p>
                                                </div>
                                                <input name="dosubmitcc" type="button" id="dosubmitcc" value="确认修改" class="form-btn btn green-btn" onclick="SubFormPayPass('setpaypassword')">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                            </form>

                                        </div>


                                        <script>


                                            function SubFormPayPass(id) {


                                                $.ajax({
                                                    url: '{{route("user.paypwd")}}',
                                                    type: 'post',
                                                    data: $("#"+id).serialize(),
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
                                                                    $('input[type="password"]').val('');
                                                                    $('.paypass').toggle();
                                                                }

                                                                layer.close(index);
                                                            }
                                                        });
                                                    }
                                                });
                                            }

                                        </script>

                                    </dd>
                                </dl>
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

