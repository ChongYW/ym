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


                    <li class="current"><a href="{{route("user.certification")}}">认证中心</a></li>
                    <li><a href="{{route("user.phone")}}">手机验证</a></li>
                    <li><a href="{{route("user.security")}}">安全问题</a></li>

                </ul>
                <div class="hite"> <span id="account"></span> </div>
            </div>
        </div>


        <div class="myinfo" style="padding: 20px; margin-bottom: 15px;background:#fff;">
            <table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0" style="margin-top:10px;" height="314">
                <tbody><tr>
                    <td bgcolor="#f5f5f5" height="34" style="padding-left:5px;font-size:13px; line-height:34px;border:#e6e6e6 solid 1px;"><span style="width: 5px;height: 20px;background-color: #0697DA;float: left;margin:7px;display: block;"></span>信息汇总</td>
                </tr>
                <tr>
                    <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px; padding:15px;">
                        <table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0" height="171">
                            <tbody><tr><td align="center" colspan="2"><div style="background:#e6e6e6; width:98%; height:1px;"></div></td></tr>
                            <tr height="50">
                                <td width="200" style="padding-left:30px; font-size:14px;">手机验证</td>
                                <td width="232" align="center">
                                    <a href="{{route("user.phone")}}">
                                        <?php  if($Member->ismobile==1){ echo '<div class="xxrz_yrz"></div>'; }else{	echo '<div class="xxrz_wrz"></div>';} ?>
                                    </a>
                                    <a href="{{route("user.phone")}}">
                                        <?php  if($Member->ismobile==1){ echo '<div class="xxrz_ck"></div>'; }else{	echo '<div class="xxrz_msrz"></div>';} ?>
                                    </a>
                                </td>
                            </tr>
                            <tr><td align="center" colspan="2"><div style="background:#e6e6e6; width:98%; height:1px;"></div></td></tr>
                            <tr><td align="center" colspan="2"><div style="background:#e6e6e6; width:98%; height:1px;"></div></td></tr>
                            <tr><td align="center" colspan="2"><div style="background:#e6e6e6; width:98%; height:1px;"></div></td></tr>
                            <tr height="50">
                                <td width="200" style="padding-left:30px; font-size:14px;">安全问题</td>
                                <td width="232" align="center">
                                    <a href="{{route("user.security")}}">
                                        <?php  if($Member->isquestion==1){ echo '<div class="xxrz_yrz"></div>'; }else{	echo '<div class="xxrz_wrz"></div>';} ?>
                                    </a>
                                    <a href="{{route("user.security")}}">
                                        <?php  if($Member->isquestion==1){ echo '<div class="xxrz_ck"></div>'; }else{	echo '<div class="xxrz_msrz"></div>';} ?>
                                    </a>
                                </td>
                            </tr>
                            <tr><td align="center" colspan="2"><div style="background:#e6e6e6; width:98%; height:1px;"></div></td></tr>
                            <tr height="50">
                                <td width="200" style="padding-left:30px; font-size:14px;">银行卡</td>
                                <td width="232" align="center">
                                    <a href="{{route("user.bank")}}">
                                        <?php  if($Member->isbank==1){ echo '<div class="xxrz_yrz"></div>'; }else{	echo '<div class="xxrz_wrz"></div>';} ?>
                                    </a>
                                    <a href="{{route("user.bank")}}">
                                        <?php  if($Member->isbank==1){ echo '<div class="xxrz_ck"></div>'; }else{	echo '<div class="xxrz_msrz"></div>';} ?>
                                    </a>
                                </td>
                            </tr>
                            <tr><td align="center" colspan="2"><div style="background:#e6e6e6; width:98%; height:1px;"></div></td></tr>
                            <tr height="50">
                                <td width="461" style="padding-left:30px; font-size:14px;" colspan="2">重要通知：由于近期接到投诉有个别会员冒用他人身份证信用卡进行套现；为了您的帐户安全需要进行手机认证；由此给您带来的不便之处敬请谅解。(您的信息将受到公司加密保存并严格保密 {{Cache::get('CompanyShort')}})</td>
                            </tr>
                            <tr><td align="center" colspan="2"><div style="background:#e6e6e6; width:98%; height:1px;"></div></td></tr>
                            </tbody></table></td>
                </tr>
                </tbody></table>
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

