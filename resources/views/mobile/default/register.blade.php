@extends('mobile.default.wap')

@section("header")
    @parent
@endsection

@section("js")
    @parent
    <script type="text/javascript" src="{{asset("mobile/public/Front/reg/js/yz.js")}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset("mobile/public/layer_mobile/layer.js")}}"></script>
@endsection

@section("css")

    @parent
    <link rel="stylesheet" type="text/css" href="{{asset("mobile/public/style/css/reg.css")}}"/>
    <link href="{{asset("mobile/public/Front/reg/css/style.css")}}" type="text./css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset("mobile/public/Front/css/css.css")}}">





@endsection



@section('body')



    <div class="formBox reg_slides">
        <div class="wrap clearfix registerWrap">
            <div class="sreg_box">
                <div class="zs_topbg"><img src="{{asset("mobile/images/logo_bj.png")}}"></div>
                <div class="zs_dl">注册</div>
                <div class="form_inline">
                    <div class="error_tip none"><p id="error_detail_message"><!-- 请输入正确的用户名和密码 --></p></div>
                    <div class="form_group clearfix" style="display: none;">
                        <label for="username"><i class="ico_name"></i></label>

                        <input type="text" name="username" onKeyUp="value=value.replace(/[^\w\.\/]/ig,'')" style="display:none;">
                        <input type="text" class="inp" id="username" onKeyUp="value=value.replace(/[^\w\.\/]/ig,'')" size="10" maxlength="10" placeholder="用户名（4-10位字母或数字）">


                        <div class="error"></div>
                        <div class="errorTip" id="tip_name">
                            <i class="ico_tip" id="ico_tip_verfiycode"></i><span id="usernameTip"><!-- 用户名输入格式错误 --></span>
                        </div>


                    </div>
                    <!-- 图片验证码开始 -->
                    <div class="clearfix">
                        <div class="form_group form_exa">
                            <label for="exa"><i class="ico_exa"></i></label>
                            <input type="text" class="inp" id="exaCode"  size="6" maxlength="5" placeholder="验证码">
                            <div class="error"></div>
                            <div class="errorTip" id="tip_codeImg">
                                <i class="ico_tip"></i><span id="codeTip">验证码输入格式错误</span>
                            </div>
                        </div>
                        <div class="l"><div class="yzm">

                                <img src="{!! captcha_src('flat') !!}"
                                     alt="验证码"  style="cursor:pointer;"
                                     onclick="this.src='{!! captcha_src('flat') !!}'+Math.random()" id="code_img" />
                            </div></div>
                    </div>
                    <!-- 图片验证码结束 -->
                    <div class="form_group clearfix">
                        <label for="phone"><i class="ico_mobile"></i></label>
                        <input type="text" class="inp" id="phone" size="28" placeholder="请勿使用已注册手机号">
                        <div class="error"></div>
                        <div class="errorTip" id="tip_phone">
                            <i class="ico_tip"></i><span id="phoneTip">手机输入格式错误</span>
                        </div>
                    </div>
                    <?php
                    if(\Cache::get('smsverifi')=='开启'){?>

                    <div class="clearfix">
                        <div class="form_group form_exa">
                            <label for="exa"><i class="ico_exa"></i></label>
                            <input type="text" class="inp iphoneCode" id="exa" size="6" maxlength="6" placeholder="短信验证码">
                            <input type="text" name="username" style="display:none;">
                            <div class="errorTip" id="tip_code">
                                <i class="ico_tip"></i><span id="codeTip"></span>

                            </div>
                            <div class="errorTip" id="send_call_verify"></div>

                        </div>

                        <div class="l">
                            <span id="getRegisterCode" class="btn_block stext">获取验证码</span>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form_group clearfix">
                        <div class="pwd_tip" id="pwd_tip"><em></em></div>
                        <label for="pwd"><i class="ico_pwd"></i></label>
                        <input type="password" style="display:none;">
                        <input type="password" class="inp" id="pwd" size="28" placeholder="密码">

                        <div class="error"></div>
                        <div class="errorTip" id="tip_pwd">
                            <i class="ico_tip"></i><span id="pwdTip">密码输入格式错误</span>
                        </div>
                    </div>
                    <div class="form_group clearfix">
                        <label for="pwd"><i class="ico_pwd"></i></label>
                        <input type="password" class="inp" id="pwd_again" size="28" placeholder="确认密码">
                        <div class="error"></div>
                        <div class="errorTip" id="tip_pwd_again">
                            <i class="ico_tip"></i><span id="pwd_againTip">2次密码不一致</span>
                        </div>
                    </div>

                    <div class="form_group clearfix">
                        <label for="qq"><i class="ico_qq"></i></label>
                        <input type="text" class="inp" id="qq" size="28" placeholder="微信或者QQ(选填)">
                        <div class="error"></div>
                        <div class="errorTip" id="tip_qq">
                            <i class="ico_tip"></i><span id="qqTip">微信或者QQ输入格式错误</span>
                        </div>
                    </div>
                    <div class="form_group clearfix">
                        <label for="yaoqingren"><i class="ico_yaoqingren"></i></label>
                        <input type="text"  value="{{$yaoqingren}}"  class="inp" id="yaoqingren" size="12" placeholder="无推荐人请留空">
                        <div class="error"></div>
                        <div class="errorTip" id="tip_yaoqingren">
                            <i class="ico_tip"></i><span id="yaoqingrenTip">邀请人推荐ID输入错误</span>
                        </div>
                    </div>
                    <div class="form_checkbox clearfix">
                        <input id="tiaokuan" name="" type="checkbox" value="" checked> 我同意<a href="{{route('wap.zcxy')}}" target="_blank"><span>《{{\Cache::get('CompanyLong')}}注册协议》</span></a>
                        <div class="errorTip" id="tip_tiaokuan">
                            <i class="ico_tip"></i><span id="tiaokuanTip">您还没同意{{\Cache::get('CompanyLong')}}咨询与管理服务协议</span>
                        </div>
                    </div>
                    <input type="hidden" id="source" name="source" value="web">
                    <div class="form_btn_box clearfix">
                        <input type="button" id="registerBtn" value="立即注册" class="btn_block"/>
                    </div>
                    <p class="tr"><a href="{{route("wap.login")}}">立即登录</a></p>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{asset("mobile/public/style/js/common.js")}}"></script>
    <script type="text/javascript" src="{{asset("mobile/public/style/js/register.js").'?t='.time()}}"></script>

    <script type="text/javascript">
            $("#phone").keyup(function () {
                $("[name='username']").val($(this).val());
                $("#username").val($(this).val());

            });
    </script>

@endsection


@section("footcategory")
    @if(Cache::get('TaotiaoIndexOn')=='开启')
        <link href="{{asset("mobile/static/css/zzsc.css")}}" rel="stylesheet" type="text/css"/>
        <script>
            $(function() {
                $(".yb_top").click(function() {
                    $("html,body").animate({
                        'scrollTop': '0px'
                    }, 300)
                });
            });
        </script>

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
            .f_home {
                background: url('{{asset("mobile/static/images/navhomeh.png")}}') no-repeat top center;
                background-size: 21px;
                color: #D8232C;
                text-align: center;
                color: #9f9f9f;
                font-size: 12px;
                box-sizing: border-box;
                padding-top: 20px;
            }
            .f_account {
                background: url('{{asset("mobile/static/images/navacc.png")}}') no-repeat top center;
                background-size: 19px;
                text-align: center;
                color: #9f9f9f;
                font-size: 12px;
                box-sizing: border-box;
                padding-top: 20px;
            }
            .f_borrow {
                background: url('{{asset("mobile/static/images/navborrow.png")}}') no-repeat top center;
                background-size: 21px;
                text-align: center;
                color: #9f9f9f;
                font-size: 12px;
                box-sizing: border-box;
                padding-top: 20px;
            }
            .f_invest {
                background: url('{{asset("mobile/static/images/navinvest.png")}}') no-repeat top center;
                background-size: 21px;
                text-align: center;
                color: #9f9f9f;
                font-size: 12px;
                box-sizing: border-box;
                padding-top: 20px;
            }
            .f_touz {
                background: url('{{asset("mobile/static/images/chongzhi.gif")}}') no-repeat top center;
                background-size: 21px;
                text-align: center;
                color: #9f9f9f;
                font-size: 12px;
                box-sizing: border-box;
                padding-top: 20px;
            }
            .f_geng {
                background: url('{{asset("mobile/static/images/shezhi.gif")}}') no-repeat top center;
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


        <div class="yb_conct">
            <div class="yb_bar">
                <ul>




                    <li><a href="/index.html" title="资讯首页" class="f_home active" id="menu0">资讯首页</a></li>

                    <li><a href="{{route('user.index')}}" title="邀请好友" class="f_geng" id="menu1">邀请好友</a></li>



                    <li><a href="{{route('user.index')}}" title="个人中心" class="navAccount f_account" id="menu3">个人中心</a></li>

                    <li><a href="{{route('user.index')}}" title="每日签到" class="f_touz" id="menu4">每日签到</a></li>
                    <?php
                    $link=\App\Category::where('name','在线客服')->value('links')
                    ?>

                    <li><a href="{{$link}}" title="在线客服" class="f_borrow" id="menu2">在线客服</a></li>
                </ul>
            </div>
        </div>

    @else
        @parent
    @endif
@endsection

@section("footer")
    @parent
    {!! Cache::get("waptongjicode") !!}
@endsection
@section("playSound")

@endsection

