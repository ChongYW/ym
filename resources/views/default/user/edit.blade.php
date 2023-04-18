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
                    <li class="current"><a href="{{route("user.edit")}}">资料修改</a></li>
                    <li><a href="{{route("user.password")}}">修改登录密码</a></li>
                    <li><a href="{{route("user.paypwd")}}">修改交易密码</a></li>
                    <li><a href="{{route("user.paypwd.retrieve")}}">找回交易密码</a></li>
                    <li><a href="{{route("user.bank")}}">银行卡绑定</a></li>


                </ul>
                <div class="hite"> <span id="account"></span> </div>
            </div>
        </div>


        <div class="myinfo" style="padding:5px  10px; margin-bottom: 15px;background:#fff;">
            <p style="margin:5px;">尊敬的{{Cache::get('CompanyShort')}}用户，所有资料{{Cache::get('CompanyShort')}}实行严格保密。填写后均不可修改，请认真填写。</p>

            <form action="" method="post" id="edit">
                <table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0" style="margin-top:10px;" height="90">
                    <tbody>
                    <tr height="40">
                        <td width="197" align="right" style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-top:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;">会员账号：</td>
                        <td width="528" style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px;border-top:#e6e6e6 solid 1px; padding-left:5px;">{{$Member->username}}</td>
                    </tr>
                    <tr height="40">
                        <td style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;" align="right">当前级别：</td>
                        <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;">{{$memberlevelName[$Member->level]}}</td>
                    </tr>
                    <!--
                    <tr height="40">
                        <td style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;" align="right">姓名：</td>
                        <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;">

                            <input type="text" name="realname" id="realname" style="width:200px; height:30px; line-height:30px; border-radius: 8px; border:#CCCCCC solid 1px; padding:0px 8px;" value="{{$Member->realname}}"> 例：李奎
                        </td>
                    </tr>
                    <tr height="40">
                        <td style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;" align="right">身份证号码：</td>
                        <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;">

                            <input type="text" name="card" id="card" style="width:200px; height:30px; line-height:30px; border-radius: 8px; border:#CCCCCC solid 1px; padding:0px 8px;" value="{{$Member->card}}"><br /><span>身份证号码上传之后无法修改，请谨慎填写</span>

                        </td>
                    </tr>
                    -->
                    <tr height="40">
                        <td style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;" align="right">手机号码：</td>
                        <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;"><?php echo \App\Member::half_replace(\App\Member::DecryptPassWord($Member->mobile),'****',3,4); ?></td>
                    </tr>

                    <tr height="60">
                        <td style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;" align="right">联系QQ：</td>
                        <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;">

                            <input type="text" name="qq" id="qq" style="width:200px; height:30px; line-height:30px; border-radius: 8px; border:#CCCCCC solid 1px; padding:0px 8px;" value="{{$Member->qq}}"> 例：8088008
                        </td>
                    </tr>

                    <tr height="30">
                        <td width="197" align="right" style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;">介绍人：</td>
                        <td width="528" style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;"><?php echo $Member->inviter!=''?$Member->inviter:'无'; ?></td>
                    </tr>
                    <tr height="30">
                        <td width="197" align="right" style="background:#F9F9F9;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;">下线分成：</td>
                        <td width="528" style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;">根据产品给予的佣金分成比例</td>
                    </tr>
                    <tr height="50">
                        <td style="border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;" align="right"></td>
                        <td style="border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; color:#ff9600; padding-left:3px;">  <input type="button" value="提交" class="btnsubupdate" onclick="SubForm('edit')"> <input type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btncancel" onClick="location.href=location.href;" id="btn_cancel"></td>
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

