@extends('mobile.default.wap')

@section("header")



@endsection

@section("js")
    <script type="text/javascript" src="{{asset("wap/cp/js/jquery-1.10.1.min.js")}}"></script>
    <script src="{{asset("layim/layui.js")}}"></script>

@endsection

@section("css")


    {{--

        <link rel="stylesheet" href="{{asset("wap/cp/css/common.css")}}" type="text/css">
        <link rel="stylesheet" href="{{asset("wap/cp/css/detail_novice.css")}}" type="text/css">
        <link rel="stylesheet" href="{{asset("wap/cp/css/jquery.mCustomScrollbar.css")}}" type="text/css">
        <link rel="stylesheet" href="{{asset("wap/cp/css/c_main.min.css")}}" type="text/css">
        <link rel="stylesheet" href="{{asset("wap/cp/css/comm.min.css")}}" type="text/css">

        --}}


    <link rel="stylesheet" media="screen" href="{{asset("wap/cp/css/hongbao.css")}}"/>
    <link rel="stylesheet" media="screen" href="{{asset("wap/cp/css/detail.css")}}"/>
    <link href="{{asset("wap/cp/css/common.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("wap/cp/css/base.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("wap/cp/css/font.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("wap/cp/css/mend.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("wap/cp/css/screen.css")}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" media="screen" href="{{asset("wap/cp/css/detailnew.css")}}"/>
    <link rel="stylesheet" media="screen" href="{{asset("wap/cp/css/moon.css")}}"/>
    <!-- 账户存管弹层 -->
    <link rel="stylesheet" media="screen" href="{{asset("wap/cp/css/xw_reg.css")}}"/>
    <link rel="stylesheet" href="{{asset("wap/cp/css/shuangshiyi_wap.css")}}" type="text/css"/>



@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')


    <style type="text/css">
        .placeholderf { width:100%; height:100px; }
        .placeholder { width:100%; height:50px; }
        .mintop_title{position:fixed;top:0px;width:100%;z-index:50;text-align:center;font-size:17px;color:#000;background:#fff;line-height:50px;}
        .mintop_title .backs .returns{position:absolute;left:0;top:0;padding:15px 15px}
        .mintop_title .backs .returns img{height:17px;width:auto}
        .mintop_title .go_back a { width:15px; height:15px; background:url(/wap/cp/images/back.png) no-repeat left center; background-size:100% auto; display:block; margin-left:.15rem; }
    </style>


    <div class="mintop_title">
        <span class="backs"><a class="returns" href="javascript:history.go(-1);"><img class="returns" src="{{asset("wap/cp/images/back.png")}}" width="13" alt=""></a></span>
        <span class="name">在线投资</span>
    </div>
    <div class="placeholder"></div>




    <div>

        <!--出借-->
        <div class="ovet" id="indiv">

            <div class="tbok_xx bgg colf ovet pr">
                <!-- <div class="no_zz dn">不支持债转</div>-->
                <div class="no_zz  " style="width: 90px">

                    保本保息  </div>
                <h4 class="fama" id="detail_title"><span class="tt"><?php echo $productview->title; ?></span><!--<span class="qs">JY-MAR216</span><span class="tt">期</span><span class="qs">-184299</span>--></h4>
                <p class="fama" id="detail_content">可投<?php echo $productview->zgje; ?>元<span>|</span>期限<?php echo $productview->shijian; ?><?php if ($productview->hkfs == 2) { ?> 小时<?php } else { ?>天<?php } ?><span>|</span>@if(Cache::get('ShouYiRate')=='年')
                        年化收益
                    @else
                        <?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?>化收益
                    @endif
                    <?php echo $productview->jyrsy; ?>%</p>
            </div>
            <div class="rec_txt dn" t="lackMoneyId2" style="top:204px;">金额不足，选择充值？</div>

            <div class="tb_okbox">

                <div class="tbok_sy col6 bgf" style="    border-top: 1px solid #eee;padding-bottom:20px;    padding-top: 16px;">
                    <p style="font-size:16px;">账户余额：<span class="col3 fama"><font color="#009933" style="font-family:Georgia, " times="" new="" roman",="" times,="" serif"="">{{$Memberamount}}</font>元</span></p><br>
                    <p style="font-size:16px;">起投金额 <font color="#FF6600" style="font-family:Georgia, " times="" new="" roman",="" times,="" serif"="">{{$productview->qtje}}</font> 元<span></p>
                    <p style="font-size:16px;">最高投资 <font color="#FF6600" style="font-family:Georgia, " times="" new="" roman",="" times,="" serif"="">{{($productview->xmgm-$productview->xmgm*$productview->xmjd/100)*10000}}</font> 元<span></p>
                    <p style="font-size:16px;">能否复投：
                        <font color="#FF6600" style="font-family:Georgia" >
                        <?php if ($productview->isft == 0) {
                            echo  '不能复投';
                        } elseif ($productview->isft == 1) {
                            echo  '可以复投';
                        } ?>
                        </font>
                    </p>

                    {{--<p style="font-size:16px;">复投次数 <font color="#FF6600" style="font-family:Georgia, " times="" new="" roman",="" times,="" serif"="">{{$productview->futoucishu}}</font> 次<span></p>--}}

                </div>
            </div>
            <form id="buy" class="layui-form">
                <input type="hidden" name="idPay" id="idPay" value="{{$productview->id}}"/>

            <div class="" style="width:100%;background:#fff;margin-top:10px;">
                <div class="tbok_sy col6 bgf" style="border:none;">
                    <ul>
                        <li class="tbsyje">

                            <a href="javascript:void(0)" class="fr colf dn" id="allInvest">全投</a>

                            <div class="tbsy_dw" style="font-size: 40px;">￥</div> <input id="money" name="amountPay" type="number" pattern="[0-9]*" class="tbsyinput fama" placeholder="输入投资金额为1的整数倍" value="{{$productview->qtje}}">
                        </li>
                        <li class="tbyqsy cl02">预期总收益(元):<span class="cl08" id="itAmount">0元</span></li>
                    </ul>
                </div>
            </div>


            <div class="" style="width:100%;background:#86D0B5;margin-top:10px;">
                <div class="tbok_sy col6 bgf" style="border:none;">
                    <ul>
                        <li class="tbsyje1"><!--<div class="tbsy_dws">支付密码：</div>-->
                            <input id="password" name="pwdPay" type="password" class="tbsyinput1 fama" placeholder="支付密码,默认为登录密码" >
                        </li></ul>
                </div>
            </div>

                <?php if(isset($Member)){ ?>

                    @if($productview->tzzt==1)

                        <div class="tbok_but ovet mt30" id="invest" style="padding-bottom:20px;">
                            <a href="javascript:void(0)" class="tbbut bgy cbtn_h colf" id="investBtn">投资已满额</a>
                        </div>
                    @else
                        <div class="tbok_but ovet mt30" id="invest" style="padding-bottom:20px;">

                            <input type="button" class="tbbut bgy cbtn_h colf"  lay-submit lay-filter="*" value="支付订单">

                        </div>
                    @endif


                <?php }else{ ?>

                <div class="tbok_but ovet mt30" id="invest" style="padding-bottom:20px;">
                    <a href="{{route("wap.login")}}" class="tbbut bgy cbtn_h colf" id="investBtn">登录后再投资</a>
                </div>



                <?php } ?>



                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>



            </form>
        </div>



        <div id="toXwReqData" class="dn"></div>







        <!---->
        <script>
            layui.use('form', function(){
                var form = layui.form;
                var layer = layui.layer;



                form.on('submit(*)', function(data){


                    if(data.field.pwdPay==''){
                        layer.msg('请填写支付密码');
                        return false;
                    }

                    $.ajax({
                        type: "POST",
                        data: data.field,
                        url: "{{route("user.nowToMoney")}}",
                        beforeSend: function () {

                        },
                        success: function (data) {

                            var status = data.status;
                            if (status) {
                                layer.msg(data.msg,function () {
                                    if(data.url){
                                        window.location.href=data.url;
                                    }else{
                                        window.location.href = "{{route("product.buy",["id"=>$productview->id])}}";
                                    }

                                });

                            } else {
                                layer.msg(data.msg);
                            }
                        },
                        error: function () {

                        },
                        dataType: "json"
                    })

                    return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
                });

                $(function() {



                    @if($productview->hkfs==4)
                    $("#itAmount").text("{{\App\Product::Benefit($productview->id,$productview->qtje)+$productview->qtje}}元");
                    @else
                    $("#itAmount").text("<?php echo $productview->qtje+$productview->qtje*$productview->shijian*($productview->jyrsy/100); ?>元");
                    @endif

                    $("#money").keyup(function () {

                        var moneys=  parseInt($(this).val());

                       @if($productview->hkfs==4)
                        var shouyi= Benefit({{$productview->jyrsy}},{{$productview->shijian}},moneys);
                       @else



                       var qtje={{$productview->qtje}};

                       var bili=<?php echo $productview->shijian*($productview->jyrsy/100); ?>;
                       var shouyi= moneys+moneys*bili;

                       @endif
                        var amountPay=moneys;
                        $("#itAmount").text(shouyi+"元");
                    });


                    $("#allInvest").click(function () {
                        var moneys= parseInt({{$Memberamount}});


                        @if($productview->hkfs==4)
                       var shouyi= Benefit({{$productview->jyrsy}},{{$productview->shijian}},moneys);
                        @else

                        var qtje={{$productview->qtje}};

                        var bili=<?php echo $productview->shijian*($productview->jyrsy/100); ?>;
                        var shouyi= moneys+moneys*bili;


                        @endif

                        var amountPay=moneys;
                        $("#money").val(moneys);

                        $("#itAmount").text(shouyi+"元");
                    });
                });

            });



            function Benefit(sy,sj,tz) {//收益,时间,金额
                tz= parseInt(tz);
                if(tz<1){
                    tz=0;
                }
                var zshyi=tz;
                var bl= parseFloat(sy/100);
                var sys=parseFloat(bl*tz);
                sys= parseFloat(sys.toFixed(2));
                zshyi=zshyi+sys;
                for(var i=1;i<sj;i++){
                    var sys1=parseFloat(bl*sys);
                    sys1= parseFloat(sys1.toFixed(2));
                    sys=parseFloat(sys+sys1);
                    zshyi=parseFloat(sys+zshyi);
                    zshyi=parseFloat(zshyi.toFixed(2));

                }

                if(!zshyi){
                    return 0;
                }
                return zshyi;
            }
        </script>

        <script type="text/javascript">


        </script>


    </div>



@endsection

@section('footcategoryactive')

@endsection

@section('footcategory')

@endsection

@section("footer")

@endsection

