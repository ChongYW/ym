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
@endsection

@section("js")
    @parent
    <script type="text/javascript" src="{{asset("mobile/public/Front/reg/js/yz.js")}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset("mobile/public/layer_mobile/layer.js")}}"></script>
@endsection

@section("css")

    @parent
 {{--   <link rel="stylesheet" type="text/css" href="{{asset("mobile/public/style/css/reg.css")}}"/>
    <link href="{{asset("mobile/public/Front/reg/css/style.css")}}" type="text./css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset("mobile/public/Front/css/css.css")}}">--}}


    <link rel="stylesheet" href="{{asset("mobile/public/Front/css/common.css")}}" />
    <link rel="stylesheet" href="{{asset("mobile/public/Front/css/react.css")}}" />


@endsection



@section('body')


    <div class="wrap">

        <div class="full-line"></div>
        <div class="container-wrap">
            <div class="wrapwidth">
                <div class="safeindex">
                    <div id="forgot-password-react-wrapper"><div >
                            <div class="forgot-password">
                                <div class="forgot-password-body" id="isnplay">
                                    <div><h2 class="orange">找回密码</h2>
                                        <ul>
                                            <li><label>用户名：</label><input type="text" class="borderchange" placeholder="" id="username" style="width:50%;"></li>
                                            <li><label >手机号码：</label><input type="text" class="borderchange" placeholder="" id="mobile" style="margin-left:5px;width:50%;"><span class="error-tip"></span></li>
                                            <li><label style="">验&nbsp;证&nbsp;码：</label>
                                                <input type="text" id="code" class="borderchange" placeholder="" style="width:50%;">
                                            </li>
                                            <li><label style=""></label>
                                                <span class="captcha">
                      <a href="javascript:;"><img src="{!! captcha_src('flat') !!}"
                                                  alt="验证码"  style="cursor:pointer;"
                                                  onclick="this.src='{!! captcha_src('flat') !!}'+Math.random()" id="codeImg"/>

                          <span  onClick="retCode();"> 换一张</span></a></span></li>
                                            <span id="error"></span>
                                            <li class="submit-btn"><input type="submit" class="btn btn-primary forgetPassWordBtn" value="重置密码" style="border:none;"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php  //include("/template/foot.php");?>
    <script type="text/javascript">
        $('.forgetPassWordBtn').click(function(){
            var username = $("#username").val();
            var mobile   = $("#mobile").val();
            var code     = $("#code").val();
            if(!username){
                $("#error").html("请填写用户名");
                return ;
            }
            if(!mobile){
                $("#error").html("请填写手机号码");
                return ;
            }
            if(!code){
                $("#error").html("请填写验证码");
                return ;
            }

            $.ajax({
                type : "POST",
                url : "{{route("wap.forgot")}}",
                dataType : "json",
                data : 'username=' + username + '&mobile=' + mobile  + '&captcha=' + code+'&_token={{ csrf_token() }}',
                success : function (data) {
                    if(data.status == "0"){
                        $html = "";
                        $html+= "<div><h2 class=\"resetpass orange\">恭喜您，已经成功重置您的密码！</h2>";
                        $html+= "<p>新密码已通过短信发送到您的手机，请使用新密码登录！</p><br>";
                        $html+= "<a class=\"btn btn-orange\" href=\"{{route("wap.login")}}\">立即登录</a></div>";
                        $("#isnplay").html($html);
                    }else{
                        retCode();
                        $("#error").html(data.msg);
                    }
                }
            });

        });
        function retCode() {
            //this.src='{!! captcha_src('flat') !!}'+Math.random()
            $("#codeImg").attr("src", '{!! captcha_src('flat') !!}'+Math.random());
        }
    </script>

@endsection


@section("footcategory")
    @parent
@endsection

@section("footer")
    @parent
@endsection
@section("playSound")

@endsection

