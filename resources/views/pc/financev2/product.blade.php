@extends('pc.financev2.pc')

@section("header")
    @parent
@endsection

@section("js")
    @parent


@endsection

@section("css")



    <link href="{{asset("pc/finance/jsonpublic/css/base.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/layout.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/forms.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/font.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/xdk.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/common.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/web/module.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/web/base.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/web/font.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/web/shuangshiyi.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/web/blueimp-gallery.min.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/web/xw_reg.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/web/xw_bank.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("pc/finance/jsonpublic/css/progressbar.css")}}" rel="stylesheet" type="text/css"/>
    @parent
@endsection



@section('body')
    <script type="text/javascript">

        /**倒计时方法**/


        function tow(n) {
            return n >= 0 && n < 10 ? '0' + n : '' + n;
        }


        function getDate(timer,Obj) {
            var oDate = new Date();//获取日期对象
            var oldTime = oDate.getTime();//现在距离1970年的毫秒数

            var newDate = new Date(timer);
            if(oldTime>newDate){
                location.reload(true);
            }
            var newTime = newDate.getTime();//2019年距离1970年的毫秒数
            var second = Math.floor((newTime - oldTime) / 1000);//未来时间距离现在的秒数
            var day = Math.floor(second / 86400);//整数部分代表的是天；一天有24*60*60=86400秒 ；
            second = second % 86400;//余数代表剩下的秒数；
            var hour = Math.floor(second / 3600);//整数部分代表小时；
            second %= 3600; //余数代表 剩下的秒数；
            var minute = Math.floor(second / 60);
            second %= 60;
            var str = '倒计时:'+tow(day) + '天'
                + tow(hour) + '小时'
                + tow(minute) + '分钟'
                + tow(second) + '秒';
            $("#djs"+Obj).html(str);

            setTimeout("getDate('"+timer+"','"+Obj+"')", 1000);
        }

    </script>
    <style>


        .itag, .gydb {
            border: 1px solid #86d0b5;
            border-radius: 3px;
            color: #86d0b5;
            display: block;
            float: left;
            font-family: "宋体";
            font-size: 12px;
            height: 14px;
            line-height: 14px;
            margin-right: 5px;
            margin-top: 4px;
            padding: 0 2px;
        }

        .tbinbox input {
            float: left;
            width: 148px;
            outline: none;
            height: 24px;
            line-height: 24px;
            margin-top: 8px;
            border: 0px;
            font-size: 16px;
            color: #000;
        }

        .tbinbox input.ft {
            color: #a8a8a8;border: 0px;
        }

        #tou {
            background: url(/pc/finance/jsonpublic/images/p2p_d_01.png)  -240px 0px no-repeat;

        }
        .cru_mid span{
            color:#ffffff;
        }


        .pm_tit .itag, .pm_tit .gydb {
            margin-top: 16px;
            position: absolute;
            margin-left: 110px;
            margin-top: -5px;
        }

    </style>

    <div class="crumbs">
        <div class="cru_mid" style="color: #ffffff;">
            <a href="/">首页</a><span>&gt;</span><a
                    href="{{route('products')}}">投资产品列表</a><span>&gt;</span><span>{{\App\Formatting::Format($productview->title)}}</span>
        </div>
    </div>




    <div class="pde_mid jy">


        <div class="p_top"></div>
        <div class="p_mid clearfix">


            <div class="pm_tit" id="showHb" style="height: auto;">


                <div class="dtab_a d_fyc dn">100% 保本保息</div>
                <div class="dtab_a d_scb dn">100% 保本保息</div>
                <div class="dtab_a d_yc dn">100% 保本保息</div>
                <div class="dtab_a d_byc ">100% 保本保息</div>
                <div class="dtab_a d_jyc dn">100% 保本保息</div>


                <h3 style="font-size:16px">{{\App\Formatting::Format($productview->title)}}</h3>


                <span class="itag">担保机构:{{\App\Formatting::Format($productview->bljg)}}</span>


            </div>
            <div class="pm_rt">
                <div class="pr_txt">可投资余额</div>
                <div class="pr_je">{{($productview->xmgm-$productview->xmgm*$productview->xmjd/100)*10000}}<span>元</span></div>

                <?php if(isset($Member)){ ?>
                <div class="tbinbox" style="background: url(/pc/finance/jsonpublic/images/p2p_d_01.png) no-repeat;">
                    <input class="ft" type="password" name="passwordPay" id="passwordPay" value="" placeholder="交易密码">


                </div>
                <div class="tbinbox" style="background: url(/pc/finance/jsonpublic/images/p2p_d_01.png) no-repeat;">

                    <input class="ft" type="text" name="investAmount" id="myinvest" value="" placeholder="请输入金额">
                    <a href="javascript:void(0)" onClick='javascript:nowToMoney();' id="tou">投资</a>
                    <span id="untou" style="display:none">投资</span>

                </div>

                <p style="color:red" id="tou_errmsg" class=""></p>

                <script>



                    function nowToMoney(){

                        var _token = "{{ csrf_token() }}";
                        var idPay = "{{$productview->id}}";
                        var amountPay = $("#myinvest").val();
                        var pwdPay    = $("#passwordPay").val();

                        if(amountPay == ""){
                            $("#tou_errmsg").html("请填写投资金额");
                            return;
                        }else if(pwdPay == ""){
                            $("#tou_errmsg").html("请填写交易密码");
                            return;

                        }else{
                            //$("#tou").attr({'onClick':'javascript:','style':'background:#cccccc'}).text("提交");
                            $.ajax({
                                type : "POST",
                                url : "/user/nowToMoney",
                                dataType : "json",
                                data:{
                                    amountPay:amountPay,
                                    idPay:idPay,
                                    pwdPay:pwdPay,
                                    _token:_token,
                                },
                                //data : 'amountPay=' + amountPay + '&idPay=' + idPay+ '&pwdPay=' + pwdPay+'&_token='+_token,
                                success : function (data) {
                                    if(data.status){


                                        layer.open({
                                            content: data.msg,
                                            btn: '确定',
                                            shadeClose: false,
                                            yes: function(index){
                                                if(data.status){
                                                    window.location.reload();
                                                }

                                                layer.close(index);
                                            }
                                        });


                                    }else{
                                        // $("#terr").html(data.msg);
                                        // alert(data.msg);

                                        layer.open({
                                            content: data.msg,
                                            btn: '确定',
                                            shadeClose: false,
                                            yes: function(index){
                                                if(data.status){
                                                     window.location.reload();
                                                }

                                                layer.close(index);

                                                //$("#tou").attr({'onClick':'javascript:nowToMoney();','style':'background:#3579f7'}).text("投资");
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    }

                </script>
                <?php }else{ ?>
                <a class="p2pbtn" style="
    background: url(/pc/finance/jsonpublic/images/p2p_d_01.png) no-repeat;width:198px; height:43px; background-position:left -111px; display:block;
" href="{{route('pc.login')}}" lt="lgn"></a>
                <?php } ?>





                <div class="sy iu_jyc"
                     style="background:#FFFF33; font-size:14px; margin-top:5px; padding:0px 5px; border:1px #FFFFFF solid; border-radius:5px; height:28px; line-height:28px;margin-bottom:10px; width:80%;">
                    起投金额：<span class="nred">￥<span><?php echo $productview->qtje; ?></span></span> 元
                </div>

                <div class="plintxt ptp20">

                        <?php if(isset($Member)){ ?>
                            <p style="color:red" id="tou_errmsg" class="dn"></p>
                            <p id="puamount">可用额度：<span class="white_b f14"><?php echo $Memberamount;?>元</span>
                                <a href="{{route('user.recharge')}}" id="gorecharge">【去充值】</a>
                            </p>
                        <?php }else{ ?>
                            <p>
                            <a href="{{route('pc.login')}}"
                               lt="lgn">登录</a>后，显示您的账户余额</p>
                    <p>新用户，<a href="{{route('pc.register')}}">免费注册</a></p>
                    <?php } ?>


                </div>
            </div>

            <div class="pm_lf">

                <div class="obinfo">
                    <div class="je">

                        <span class="ft14">项目规模</span>
                        <span class="ft28"><?php echo $productview->xmgm; ?>万元</span>

                    </div>

                    <div class="qx">
                        <div class="ft14"><span>投资期限</span><i id="tips">
                                <div class="jtxt" style="width:301px;left:-23px;top:25px;hight:160px">
                                    期限说明：1个月=30天,分交易日和自然日
                                </div>
                            </i></div>
                        <div class="ft28"><?php echo $productview->shijian; ?>个自然<?php if ($productview->hkfs == 2) { ?>时<?php } else { ?>日<?php } ?></div>
                    </div>

                    <div class="lv  lvjl"><span class="ft14">

           <?php if ($productview->hkfs == 2) { ?>时<?php } else { ?>日<?php } ?>化收益

          </span><span class="ft28">
          <div class="annu">{{ $productview->jyrsy*$productview->qtje/100 }}元</div>



           </span>
                    </div>

                    <div class="tz "><span class="ft14">每万元收益</span><span class="wysy ft28">{{ $productview->jyrsy*$productview->qtje }}元</span></div>

                </div>


                <ul class="listlv " style="height: 52px;">

                    <li class="wid170 posre">
                        <div t="nounContent" class="tltxt dn"><strong>安全评级：</strong>即项目安全等级，五星表示项目安全性极高；</div>
                        <a t="noun" class="titline" href="javascript:void(0)">安全评级</a>：<span>
                            <img src="/pc/finance/jsonpublic/images/lv_star_line.png" alt="">
                            <img src="/pc/finance/jsonpublic/images/lv_star_line.png" alt="">
                            <img src="/pc/finance/jsonpublic/images/lv_star_line.png" alt="">
                            <img src="/pc/finance/jsonpublic/images/lv_star_line.png" alt="">
                            <img src="/pc/finance/jsonpublic/images/lv_star_line.png" alt="">
                        </span></li>

                    <li class="wid170 posre">
                        <div t="nounContent" class="tltxt dn">
                            <strong>是否限投：</strong>项目是否限制投资一次；<br><strong>等级限制：</strong>理财等级高低推出的高收益项目。
                        </div>
                        <a t="noun" class="titline" href="javascript:void(0)">是否限投</a>：<span><?php if ($productview->isft == 0) {
                                if($productview->futoucishu>1){
                                    //echo  '可复投'.$productview->futoucishu.'次';
                                    echo  '可以复投';
                                }else{
                                    echo  '不能复投';
                                }

                            } elseif ($productview->isft == 1) {
                                echo  '可以复投';
                            } ?></span>
                    </li>

                    <li class="wid170 posre ">
                        <div t="nounContent" class="tltxt dn">给予投资人投资额度的机构。该授信额度仅用于投资人未能及时或不能偿还时，偿还该项目投资本息使用。</div>
                        <a t="noun" class="titline" href="javascript:void(0)">担保机构</a>：
                        <a title="{{\App\Formatting::Format($productview->bljg)}}">
                            <span style="color:#333">{{\App\Formatting::Format($productview->bljg)}}</span>
                        </a>
                    </li>

                    <li class="wid170 posre">
                        <div t="nounContent" class="tltxt dn"><strong>保障方式：</strong>担保机构给予投资人的投资额进行担保保障，100%兑付</div>
                        <a t="noun" class="titline" href="javascript:void(0)">保障方式</a>：<span>100% 本息保障</span>
                    </li>

                </ul>

                <div class="ed_lf">
                    <div class="txtlf"><span>还款方式：</span>
                        <span>

       <?php if ($productview->hkfs == 0) { ?>
                    按天付收益，到期还本
                    <?php } elseif ($productview->hkfs == 1) { ?>
                    到期还本,到期付息
                    <?php }elseif ($productview->hkfs == 2) { ?>
                    按小时付收益，到期还本
                    <?php }elseif ($productview->hkfs == 3) { ?>
                    按日付收益，按日平均还本(等额本息)
                    <?php }elseif ($productview->hkfs == 4) { ?>
                    每日复利,保本保息
                    <?php } ?>

        </span>
                        <a href="javascript:void(0);" style="display:none;"></a></div>
                </div>
                <style>.injl, .inzy {
                        float: left;
                        height: 16px;
                        margin-left: 5px;
                        border-radius: 5px;
                        line-height: 16px;
                        padding: 0px 5px;
                        color: #fff;
                        background: #ff906e;
                        z-index: 1;
                        position: relative;
                    }

                    .ijtxt {
                        z-index: 1;
                        width: 275px;
                        display: none;
                        border-radius: 5px;
                        border: 1px #fad9b9 solid;
                        color: #dc7657;
                        background: #fff7ea;
                        padding: 5px;
                        position: absolute;
                        right: -60px;
                        top: 20px;
                        line-height: 22px;
                    }

                    .in_re_m .jd {
                        padding: 15px 0px 10px 5px;
                    }

                    .inre_jd, .inre_js {
                        display: block;
                        float: left;
                        font-size: 0;
                        height: 8px;
                        line-height: 0;
                        border-radius: 8px;
                    }

                    .inre_jd {
                        background: #ebebeb;
                        width: 470px;
                        margin: 8px 0px 0px 6px
                    }

                    .inre_js {
                        background: #FF8983;
                    }

                    .ire_mb .CL02 {
                        color: #888;
                    }

                    .ire_mb .injl {
                        background: #ddd;
                        color: #666;
                    }

                    .ire_mb .itag {
                        border: 1px solid #c5c5c5;
                        color: #a7a7a7;
                    }

                    .ire_mb .ijtxt {
                        color: #666;
                        background: #f5f5f5;
                        border: 1px #ebebeb solid;
                    }
                </style>
                <br>
                <div class="usetxt">
                    <div class="lfus">投资进度：</div>
                    <div class="inre_jd wt40 mg_t10"><span class="inre_js" style="width:{{$productview->xmjd}}%"></span></div>
                    <span class="FL CL05">&nbsp;{{$productview->xmjd}}%</span>

                </div>
                <br>
				<div class="usetxt" >
					<div class="lfus">项目标签：</div>
                    <?php $productview->tagcolor!=''?$tagcolor=$productview->tagcolor:$tagcolor='background-color:#FF6A78;color:#F5F2F2;'?>

					@if($productview->wzone)<span style="margin-top:5px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;font-size: 13px;{{$tagcolor}}">{{$productview->wzone}}</span>&nbsp;&nbsp;&nbsp; @endif
					@if($productview->wztwo)<span style="margin-top:5px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;font-size: 13px;{{$tagcolor}}">{{$productview->wztwo}}</span>&nbsp;&nbsp;&nbsp;@endif
					@if($productview->wzthree)<span style="margin-top:5px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;font-size: 13px;{{$tagcolor}}">{{$productview->wzthree}}</span>@endif
                </div>


                <?php if($productview->tzzt == -1){?>

                <br>

                <div class="usetxt" >

                    <?php $productview->tagcolor!=''?$tagcolor=$productview->tagcolor:$tagcolor='background-color:#FF6A78;color:#F5F2F2;'?>

                    <?php if($productview->countdownad!=''){
                        echo '<span style="margin-top:5px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;font-size: 13px;'.$tagcolor.'">'.$productview->countdownad.'</span>';
                    }?>

                </div>



                <br>
                <div class="usetxt" >

                    <?php $productview->tagcolor!=''?$tagcolor=$productview->tagcolor:$tagcolor='background-color:#FF6A78;color:#F5F2F2;'?>

                    <?php if($productview->countdown!=''){
                        echo '<span style="margin-top:5px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;font-size: 13px;'.$tagcolor.'" id="djs'.$productview->id.'"></span><script>getDate("'.$productview->countdown.'","'.$productview->id.'");</script>';
                    }?>

                </div>



            <?php } ?>


            </div>
        </div>
        <div class="p_bom"></div>
    </div>




    <div id="folatempty" style="height: 0px; font-size: 0px; line-height: 0px;"></div>


    <div class="pptab" style="z-index: 9999; position: static; top: 0px; left: 0px;" id="fltab">
        <ul>
            <li class="hov" v="10"><a href="#1F" name="1F">项目说明</a></li>
            <li v="1"><a href="#2F" name="2F">安全保障</a></li>
            <li v="3" class=""><a href="#3F" name="3F">投资记录</a></li>
            @if($productview->hkfs == 4)
            <li v="4" class=""><a href="#4F" name="3F">收益明细</a></li>
            @endif
            <li id="bkli" class="rt" v="-1"><a href="javascript:void(0)" target="_blank">立即投资</a></li>


        </ul>
    </div>



    <div class="mimid martop ptm20" id="F1">
        <div class="ppmid01" v="10">
            <br>


            <div class="introdiv topbak">
                <h3 class="titintro">投资项目:</h3>
                <dl class="indl01 clearfix">
                    <dd>{{\App\Formatting::Format($productview->title)}}</dd>
                </dl>
            </div>


            <div class="introdiv">
                <h3 class="titintro">项目金额:</h3>
                <dl class="indl01 clearfix">
                    <dd><font color="#ff0000">{{$productview->xmgm}}</font>万元人民币；</dd>
                </dl>
            </div>

            <div class="introdiv">
                <h3 class="titintro"><?php if ($productview->hkfs == 2) { ?>时<?php } else { ?>日<?php } ?>收益率:</h3>
                <dl class="indl01 clearfix">
                    <dd><font color="#ff0000">{{ $productview->jyrsy*$productview->qtje/100 }}
                            元</font><?php if ($productview->hkfs == 2) { ?>时<?php } else { ?>日<?php } ?>化收益；
                    </dd>
                </dl>
            </div>
            <div class="introdiv">
                <h3 class="titintro">起投金额:</h3>
                <dl class="indl01 clearfix">
                    <dd><font color="#FF0000"><?php echo $productview->qtje; ?>元</font>起投；</dd>
                </dl>
            </div>
            <div class="introdiv">
                <h3 class="titintro">项目期限:</h3>
                <dl class="indl01 clearfix">
                    <dd>
                        <font color="#ff0000"><?php echo $productview->shijian; ?></font><?php if ($productview->hkfs == 2) { ?>
                        时<?php } else { ?>日<?php } ?>；
                    </dd>
                </dl>
            </div>
            <div class="introdiv">
                <h3 class="titintro">收益计算:</h3>
                <dl class="indl01 clearfix">
                    <dd><font color="#ff0000"><?php echo $productview->qtje; ?>元</font>+<font
                                color="#ff0000"><?php echo $productview->qtje; ?>元</font>*<font
                                color="#ff0000">{{$productview->jyrsy}}%</font>*<font
                                color="#ff0000"><?php echo $productview->shijian; ?><?php if ($productview->hkfs == 2) { ?>
                            小时<?php } else { ?>天<?php } ?></font>=总收益<font
                                color="#ff0000">
                            @if($productview->hkfs == 4)
                                {{\App\Product::Benefit($productview->id,$productview->qtje)}}
                            @else
                                {{ $productview->shijian*$productview->jyrsy*$productview->qtje/100 }}
                            @endif


                            元</font>+本金<font color="#ff0000"><?php echo $productview->qtje; ?>元</font>=总计本息<font
                                color="#ff0000">
                            @if($productview->hkfs == 4)
                                {{\App\Product::Benefit($productview->id,$productview->qtje)+$productview->qtje}}
                            @else
                                {{ $productview->shijian*$productview->jyrsy*$productview->qtje/100+$productview->qtje }}
                            @endif


                            元</font>；
                    </dd>
                </dl>
            </div>
            <div class="introdiv">
                <h3 class="titintro">还款方式:</h3>
                <dl class="indl01 clearfix">
                    <dd><?php if ($productview->hkfs == 0) { ?>
                        按天付收益，到期还本
                        <?php } elseif ($productview->hkfs == 1) { ?>
                        到期还本,到期付息
                        <?php }elseif ($productview->hkfs == 2) { ?>
                        按小时付收益，到期还本
                        <?php }elseif ($productview->hkfs == 3) { ?>
                        按日付收益，按日平均还本(等额本息)
                        <?php }elseif ($productview->hkfs == 4) { ?>
                        每日复利,保本保息
                        <?php } ?>；
                    </dd>
                </dl>
            </div>
            <div class="introdiv">
                <dl class="indl01 clearfix">
                    <h3 class="titintro">结算时间:</h3>

                    <h4 class=" f16">【结算方式】</h4>
                    <dl class="indl01 indl03 nobod clearfix">
                        <dd>当天投资，当天计息，满<font color="#ff0000">24小时自动结算</font>收益（例如在11:08成功投资，则在下个自然日11:08收到收益），系统将当日收益和产品本金一起返还到您的会员账号中；
                        </dd>
                    </dl>


                </dl>
            </div>

            <div class="introdiv">
                <h3 class="titintro">可投金额:</h3>
                <dl class="indl01 clearfix">


                    <dd>{{$productview->ketouinfo}}</dd>


                </dl>

            </div>

            <div class="introdiv">
                <h3 class="titintro">资金用途:</h3>
                <dl class="indl01 clearfix">


                    <dd>每位投资者的投资资金，由公司进行统一操盘运作买卖{{\App\Formatting::Format($productview->title)}}项目</dd>


                </dl>

            </div>

            <div class="introdiv">
                <h3 class="titintro">安全保障:</h3>
                <dl class="indl01 clearfix">


                    <dd>担保机构对平台上的每一笔投资提供<font color="#ff0000">100%</font>本息保障，平台设立风险备用金，对本息承诺全额垫付；</dd>


                </dl>

            </div>
            <div class="introdiv">
                <h3 class="titintro">项目概述:</h3>
                <dl class="indl01 clearfix">


                    <dd>本项目筹集资金{{$productview->xmgm}}<span style="COLOR:"
                                                           rgb(255,0,0)="">万元</span>人民币，投资本项目（按<?php if ($productview->hkfs == 2) { ?>
                        时<?php } else { ?>日<?php } ?>付息收益为<font color="#ff0000">{{ $productview->jyrsy}}
                            %/<?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?></font>）项目周期为<font
                                color="#ff0000"><?php echo $productview->shijian ;?></font>个自然<?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>
                        日<?php } ?>，所筹集资金用于该项目直投运作，作为投资者收益固定且无任何风险，所操作一切风险都由公司与担保公司一律承担，投资者不需要承担任何风险。
                    </dd>


                </dl>

            </div>


            <div class="introdiv">
                <h3 class="titintro">项目说明:</h3>
                <dl class="clearfix">


                    <dd class="pageinfo"><p>{!! \App\Formatting::Format($productview->content) !!}</p>
                    </dd>


                </dl>

            </div>

        </div>

        <script>

            $(function(){
                var $cunt = $(".pageinfo img").each(function(i){
                    $(this).css("width", '100%');

                });
            });

        </script>

        <style type="text/css">

            .safediv h2 {
                font-size: 20px;
            }

            div.safe1 {
                background: url(/pc/finance/jsonpublic/images/iconcc.png) 640px 10px no-repeat;
                padding-right: 240px;
                height: 220px;
            }

            div.safe2 {
                background: url(/pc/finance/jsonpublic/images/iconcc.png) -257px 10px no-repeat;
                padding-left: 220px;
                height: 220px;
            }

            div.safe3 {
                background: url(/pc/finance/jsonpublic/images/iconcc.png) 640px -291px no-repeat;
                padding-right: 220px;
                height: 220px;
            }

            div.safe4 {
                background: url(/pc/finance/jsonpublic/images/iconcc.png) -273px -290px no-repeat;
                padding-left: 220px;
                height: 220px;
            }

            div.safe5 {
                background: url(/pc/finance/jsonpublic/images/iconcc.png) 640px -608px no-repeat;
                padding-right: 220px;
                height: 220px;
            }

            div.safe6 {
                background: url(/pc/finance/jsonpublic/images/iconcc.png) -277px -608px no-repeat;
                padding-left: 220px;
                height: 220px;
            }

            .news_list .helpcontent {
                padding: 20px 30px 20px 30px;
                font-size: 14px;
                line-height: 200%;
            }</style>
        <div class="ppmid01 martp15" v="1" id="2F">
            <h1>安全保障</h1>
            <div align="center">
                <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td>
                            <div class="article_content">
                                <div class="safediv">
                                    <div class="safe1">
                                        <h2>
                                            <span style="color:#ff6600;">A、第三方担保</span>
                                        </h2>
                                        <p>
                                            {{\Cache::get("CompanyShort")}}每个金融产品投资均有<?php echo $productview->bljg; ?>提供担保，确保投资者本息安全和资金按时回笼。
                                        </p>
                                    </div>
                                    <div class="safe2">
                                        <h2>
                                            <span style="color:#ff6600;">B、专业监管的保证金账户</span>
                                        </h2>
                                        <p>
                                            {{\Cache::get("CompanyShort")}}要求所有担保机构提前向本集团缴存担保总额10%的保证金，同时平台按融资余额专户存储10%的保证金，上述保证金由{{\Cache::get("supervise")}}，保证逾期款的足额偿还。担保机构为其保理的每一个产品提供100%连带责任担保，进行全额赔付。
                                        </p>
                                    </div>
                                    <div class="safe3">
                                        <h2>
                                            <span style="color:#ff6600;">C、24小时投资跟踪管理</span>
                                        </h2>
                                        <p>
                                            {{\Cache::get("CompanyShort")}}设专业人员对投资产品进行管理，通过开市巡查、网络监管、操盘监管等各种方式对操盘进行跟踪，实时报告操盘异常情况和产品交易变化情况。
                                        </p>
                                    </div>
                                    <div class="safe4">
                                        <h2>
                                            <span style="color:#ff6600;">D、第三方支付，不设资金池</span>
                                        </h2>
                                        <p>
                                            投资者的资金往来、沉淀资金均有第三方支付在线管理，实现用户资金与平台自有资金完全隔离，充分保障投资人的资金安全。
                                        </p>
                                    </div>
                                    <div class="safe5">
                                        <h2>
                                            <span style="color:#ff6600;">E、专款专用</span>
                                        </h2>
                                        <p>
                                            {{\Cache::get("CompanyShort")}}对风控保证金账户和投资者资金做到账目清楚，手续完备可核查，专款专用。
                                        </p>
                                    </div>
                                    <div class="safe6">
                                        <h2>
                                            <span style="color:#ff6600;">F、专业的风控团队</span>
                                        </h2>
                                        <p>
                                            {{\Cache::get("CompanyShort")}}联合四大国际会计师事务所之一的{{\Cache::get("accountingfirm")}}签订专业服务协议，由专业人员开展服务保障，以专业的谨慎性对投资者提供权益和法律保障。
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>


        <div class="ppmid02" v="3" id="3F">
            <h3>投资记录</h3>
            <div class="marlr50">


                <iframe id="zgboke" style="padding: 0px; width: 100%;height: 490px;"
                 src="{{route('pc.buylist',["id"=>$productview->id])}}" frameborder="no" border="0" marginwidth="0"
                marginheight="0" scrolling="no"></iframe>


            </div>
        </div>

        @if($productview->hkfs == 4)
        <div class="ppmid02" v="4" id="4F">
            <h3>收益明细</h3>
            <div class="marlr50">



                <table class="layui-table" id="tenderListTable" border="1">
                    <tbody>
                    <tr>
                        <th>收款日期</th>
                        <th>收款金额</th>
                        <th>收回本金</th>
                        <th>收回利息</th>
                        <th>剩余本金</th>
                    </tr>

                    <?php
                    $BenefitData=\App\Product::BenefitData($productview->id);
                    ?>

                    @foreach($BenefitData['data'] as $buyk=>$buy)
                        <tr>
                            <td class="c_table_addcolor">第{{$buyk+1}}天</td>
                            <td class="c_table_addcolor">
                                {{$buy['Benefit']}}</td>
                            <td class="c_table_addcolor">{{$buy['HMoneys']}}</td>
                            <td class="c_table_addcolor">
                                {{$buy['Benefit']}} </td>
                            <td class="c_table_addcolor">{{$buy['Moneys']}}</td>
                        </tr>
                    @endforeach


                    <tr>
                        <td class="c_table_addcolor">总结</td>
                        <td class="c_table_addcolor">
                            {{$BenefitData['HMoneys']}}</td>
                        <td class="c_table_addcolor">{{$BenefitData['Moneys']}}</td>
                        <td class="c_table_addcolor">
                            {{$BenefitData['Benefits']}} </td>
                        <td class="c_table_addcolor"></td>
                    </tr>

                    <tr>
                        <td colspan="5">
                            实际总收益：￥{{$BenefitData['HMoneys']}}元
                        </td>
                    </tr>
                    </tbody>
                </table>



            </div>
        </div>

        @endif
        <div class="ppmid02 dn" v="5">
            <h3>还款计划</h3>
            <div class="marlr50">

                您没有投资此标的，投资后可查看还款计划<a class="btn-dl investLoan" href="javascript:void(0)">立即投资</a>

            </div>
        </div>


        <input type="hidden" id="loanId" name="loanId" value="10">

        <input type="hidden" name="userId" id="userId" value="153468">


        <input type="hidden" name="yue" id="yue" value="149750000">
    </div>


    <div class="investSuccess" style="display:none" id="2F">
        <div class="affirm clearfix">
            <div class="affirm_tit f20"><span class="affirm_close fr" style="padding-right: 10px;cursor:pointer"><span
                            id="confirmClose">×</span></span>投资提交
            </div>
            <div class="affirm_mess martp20 padbm20 clearfix">
                <div class="tj_tit" id="hbNotice">投资已成功！<span id="first"></span></div>

                <table border="0" cellspacing="0" cellpadding="0" class="affirm_tab ht70">
                    <tbody>
                    <tr>
                        <td colspan="2"><span class="f20 tit"><span class="sernum">西安机器人产业化项目</span></span></td>
                    </tr>
                    <tr>
                        <td class="orange f18 pdtb10" width="45%">投资金额：<span id="toubiao2">0</span>元</td>
                        <td class="orange f18 pdtb10">投资收益：<span id="kezhuan2"></span>元<span style="padding-left:10px;"
                                                                                             class="f14">当日起计息</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="orange f18 pdtb10">奖励金元宝：<span id="rapeseed"></span>个 <span
                                    class="black f14"> 投资成功后自动获得金元宝，<font class="jlinNew htlh21 mrtp_f">金元宝可在APP中换购投资券及iphoneX等实物</font></span>
                        </td>
                    </tr>

                    <!-- <tr>
                              <td>首期回款：2018-05-09</td>
                              <td>末期回款：2018-07-08</td>
                           </tr>
                           <tr>
                             <td class="htauto"><div class="fllf">日化利率：</div><div class="annu">1.3%</div>

                             </td>
                             <td >投资期限：7个自然日 </td>
                           </tr>
                           <tr>
                             <td colspan="2">还款方式：按日付收益，到期还本</td>
                           </tr> -->
                    </tbody>
                </table>

                <!-- <div class="tb_waptq" id="share">
                        <a class="tqsm_a" href=""></a>
                        <div class="bj" style="font-size: 26px;">0.1%</div>
                        <div class="jx" style="font-size: 26px;">10~15<span style="font-size: 14px;">元</span></div>
                     <div class="ewm"><img width="100px" height="100" src="http://pan.baidu.com/share/qrcode?w=100&h=100&url=http://tlycftz888.com//MemberCenter//user-register.asp?tjr="/></div>
                     </div>-->


                <div class="red_fx" id="shareHongbao" style="display:none;">
                    <div class="redcont"><h3>恭喜您获得<span id="totalCount"></span>个现金红包</h3>
                        <p>微信扫一扫，跟好友一起抢红包！</p></div>
                    <div class="redewm"><img src="pic.jpg" id="sendImg"></div>
                </div>
                <div class="" id="moonshare">
                    <a href="/foundationDay"><img style="position:relative;"
                                                  src="/jsonpublic/source/images/appnew/zt/sy/cj_rk.png">
                        <img style="position:absolute;margin-left: 402px;margin-top: -128px;"
                             src="/jsonpublic/source/images/appnew/zt/zq/tz_pc_03.png"></a>
                </div>
                <div class="tcclo bodtop">
                    <p><span class="fllf">投资成功，您可以选择</span><a class="ftbl06 atxt"
                                                              href="/MTIyYTU2YTU2YTU2YTQ2YTk5YTExMWExMDlhNDZhMTA5YTQ2YTExNmExMDhhMTIxYTk5YTEwMmExMTZhMTIyYTU2YTU2YTU2YTQ2YTk5YTExMWExMDlhNDdhMTEyYTExNGExMTFhMTAwYTExN2E5OWExMTZhNDc=/list-19-1.html">继续投资</a>
                        <a class="ftbl06 atxt" href="/MemberCenter/user-fundlist.asp">查看交易记录</a><a class="ftbl06 atxt"
                                                                                                   href="/MemberCenter/user-init.asp">返回我的账户</a>
                    </p>
                    <p class="gray f12">如因操作超时或其他原因导致投资失败，请联系客服解决。</p>
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

