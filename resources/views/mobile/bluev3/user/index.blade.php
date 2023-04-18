@extends('mobile.bluev3.wap')

@section("header")
@endsection

@section("js")
    @parent
@endsection

@section("css")
    @parent

    <link rel="stylesheet" href="{{asset("mobile/bluev3/newindex/css/div4.css")}}"/>
@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')
    <?php

    $cachetime=300;
    $MemberId=$Member->id;
    //总投资额

    if(Cache::has('wap.user.buyamounts.'.$MemberId)){
        $buyamounts=Cache::get('wap.user.buyamounts.'.$MemberId);
    }else{
        $buyamounts=  \App\Productbuy::where("userid",$Member->id)->sum("amount");
        Cache::put('wap.user.buyamounts.'.$MemberId,$buyamounts,$cachetime);
    }


    //已投项目

    if(Cache::has('wap.user.buycounts.'.$MemberId)){
        $buycounts=Cache::get('wap.user.buycounts.'.$MemberId);
    }else{
        $buycounts=  \App\Productbuy::where("userid",$Member->id)->count();
        Cache::put('wap.user.buycounts.'.$MemberId,$buycounts,$cachetime);
    }


    //投资收益

    if(Cache::has('wap.user.moneylog_moneys.'.$MemberId)){
        $moneylog_moneys=Cache::get('wap.user.moneylog_moneys.'.$MemberId);
    }else{

        $moneylog_moneys=  \App\Moneylog::where("moneylog_userid",$Member->id)->where("moneylog_type","项目分红")->sum("moneylog_money");
        Cache::put('wap.user.moneylog_moneys.'.$MemberId,$moneylog_moneys,$cachetime);
    }


    //结束项目

    if(Cache::has('wap.user.buyjscounts.'.$MemberId)){
        $buyjscounts=Cache::get('wap.user.buyjscounts.'.$MemberId);
    }else{

        $buyjscounts=  \App\Productbuy::where("userid",$Member->id)->count();
        Cache::put('wap.user.buyjscounts.'.$MemberId,$buyjscounts,$cachetime);
    }


 $xiaxians=  count(\App\Member::treeuid($Member->invicode));
//print_r($xiaxians);
//exit;
    if(Cache::has('wap.user.xiaxians.'.$MemberId)){
        $xiaxians=Cache::get('wap.user.xiaxians.'.$MemberId);
    }else{

        $xiaxians=  count(\App\Member::treeuid($Member->invicode));
        
        
        
        Cache::put('wap.user.xiaxians.'.$MemberId,$xiaxians,$cachetime);
    }


    //本金回收





    if(Cache::has('wap.user.buyjsamounts.'.$MemberId)){
        $buyjsamounts=Cache::get('wap.user.buyjsamounts.'.$MemberId);
    }else{

        $buyjsamounts=  \App\Productbuy::where("userid",$Member->id)->where("status","0")->sum("amount");
        Cache::put('wap.user.buyjsamounts.'.$MemberId,$buyjsamounts,$cachetime);
    }





    if(Cache::has('wap.user.buydsamounts.'.$MemberId)){
        $buydsamounts=Cache::get('wap.user.buydsamounts.'.$MemberId);
    }else{

        $buydsamounts=  \App\Productbuy::where("userid",$Member->id)->where("status","1")->sum("amount");
        Cache::put('wap.user.buydsamounts.'.$MemberId,$buydsamounts,$cachetime);
    }




    if(Cache::has('wap.user.withdrawals.'.$MemberId)){
        $withdrawals=Cache::get('wap.user.withdrawals.'.$MemberId);
    }else{

        $withdrawals= \App\Memberwithdrawal::where("userid",$Member->id)->where("status","0")->sum("amount");
        Cache::put('wap.user.withdrawals.'.$MemberId,$withdrawals,$cachetime);
    }



    if(Cache::has('wap.user.recharges.'.$MemberId)){
        $recharges=Cache::get('wap.user.recharges.'.$MemberId);
    }else{

        $recharges= \App\Memberrecharge::where("userid",$Member->id)->where("status","0")->sum("amount");
        Cache::put('wap.user.recharges.'.$MemberId,$recharges,$cachetime);
    }



    if(Cache::has('wap.user.fenhongs.'.$MemberId)){
        $fenhongs=Cache::get('wap.user.fenhongs.'.$MemberId);
    }else{

        $fenhongs= \App\Moneylog::where("moneylog_userid",$Member->id)->where("moneylog_status","+")->where("moneylog_type","项目分红")->sum("moneylog_money");
        Cache::put('wap.user.fenhongs.'.$MemberId,$fenhongs,$cachetime);
    }

    $MyCoupons= \App\Couponsgrant::where("uid",$MemberId)->count();

    $buys=  \App\Productbuy::where("userid",$MemberId)->where("status","1")->orderBy("id","desc")->get();

    $daiShouyi=0;
/*
   foreach ($buys as $By){
        $daiShouyi+=($By->amount)*(\App\Product::GetShouYi($By->productid)/100)*($By->sendday_count-$By->useritem_count);
    }
*/

    $Products= \App\Product::get();
    foreach ($Products as $Product){
        $Products[$Product->id]=$Product;
    }


    foreach ($buys as $item){

        if(isset($Products[$item->productid])){
            if($Products[$item->productid]->hkfs == 0){
                $moneyCount = $Products[$item->productid]->jyrsy * $item->amount/100;

            }else{
                $moneyCount = $Products[$item->productid]->jyrsy * $item->amount/100*($item->sendday_count-$item->useritem_count);

            }
            $daiShouyi+=$moneyCount;

        }
    }


/**
//总投资额
$buyamounts=  \App\Productbuy::where("userid",$Member->id)->sum("amount");
//已投项目
$buycounts=  \App\Productbuy::where("userid",$Member->id)->count();
//投资收益
$moneylog_moneys=  \App\Moneylog::where("moneylog_userid",$Member->id)->where("moneylog_type","项目分红")->sum("moneylog_money");
//结束项目
$buyjscounts=  \App\Productbuy::where("userid",$Member->id)->count();
$xiaxians=  count(\App\Member::treeuid($Member->invicode));
//本金回收
$buyjsamounts=  \App\Productbuy::where("userid",$Member->id)->where("status","0")->sum("amount");
$withdrawals= \App\Memberwithdrawal::where("userid",$Member->id)->where("status","0")->sum("amount");
$recharges= \App\Memberrecharge::where("userid",$Member->id)->where("status","0")->sum("amount");

$fenhongs= \App\Moneylog::where("moneylog_userid",$Member->id)->where("moneylog_status","+")->where("moneylog_type","项目分红")->sum("moneylog_money");

 **/

    ?>




    <section class="aui-flexView">
        <header class="aui-navBar aui-navBar-fixed" >
            <div class="aui-money-user" style="height:42px">
                <a href="{{route('user.index')}}">
                    <img  src="\uploads\{{\Cache::get('waplogo').'?t='.time()}}" />
                </a>
            </div>
            <div class="aui-navBar-item" style="text-align:center;min-width:83%;">
                <span>当前会员等级：<?php echo $memberlevelName[$Member->level]; ?></span>
               <a href="javascript:void(0);" style="color: white;position: relative;right: -10px;" onclick="qiandao()">签到</a>

            </div>

        </header>

        <section class="aui-scrollView">
            <div class="my_total"  style="background-image: linear-gradient(to right,#ec9c38,#ff3939)">
                <div class="user">
                    <span>账号：<?php  echo \App\Member::half_replace(\App\Member::DecryptPassWord($Member->mobile));?></span>
                    <span>余额：<?php echo sprintf("%.2f",$Member->amount); ?></span>

                     <span>现金券：{{$MyCoupons}}</span>
                </div>

                <p class="bal"><?php echo sprintf("%.2f",$Member->amount+$Member->is_dongjie); ?></p>
                <p class="bal_tit" style="color:#ffffff;">总资产（元）</p>
                <div class="wait" >
                    <div class="item">
                        <span class="span_num"><?php echo sprintf("%.2f",$Member->amount); ?></span>
                        <span class="span_tit" style="color:#ffffff;font-size: .23rem">账户余额（元）</span>
                    </div>

                        <div class="item">
                            <span class="span_num">{{$buydsamounts}}</span>
                            <span class="span_tit" style="color:#fcfeff;font-size: .23rem">待收本金（元）</span>
                        </div>
                        <div class="item">
                            <span class="span_num">{{$daiShouyi}}</span>
                            <span class="span_tit" style="color:#ffffff;font-size: .23rem">待收利息（元）</span>
                        </div>


                </div>
            </div>
            
            
            


            <div class="user_btn" >
                <a href="{{route("user.recharge")}}" style="color: #333;background: #dcdcdc;"><b>充值</b></a>
                <a href="{{route("user.withdraw")}}" 	style="color: #333;background: #dcdcdc;"><b>提现</b></a>
            </div>

 
 
 
 
 

            <a class="manageModule borderRight" href="{{route("user.coupon")}}">
                <div class="manageBorder borderBottom" >
                    <img src="{{asset("mobile/bluev3/img/person/juan.png")}}"/><br/>优惠券
                    <div  id="ticketsNum" class="notice">{{$MyCoupons}}</div>
                </div>
            </a>

            <a class="manageModule borderRight" href="{{route("user.edit")}}">
                <div class="manageBorder borderBottom" >
                    <img src="{{asset("mobile/bluev3/img/person/accSet.png")}}"/><br/>账号设置
                </div>
            </a>
            <a class="manageModule borderRight" href="{{route("user.bank")}}">
                <div class="manageBorder borderBottom" >
                    <img src="{{asset("mobile/bluev3/img/person/icon-in-001.png")}}"/><br/>银行卡绑定
                </div>
            </a>
            <a class="manageModule borderRight" href="{{route("user.certification")}}">
                <div class="manageBorder borderBottom" >
                    <img src="{{asset("mobile/bluev3/img/person/userrealname.png")}}"/><br/>实名认证
                </div>
            </a>

            <a class="manageModule borderRight" href="{{route("user.mylink")}}">
                <div class="manageBorder borderBottom" >
                    <img src="{{asset("mobile/bluev3/img/person/icon-in7.png")}}"/><br/>邀请好友
                </div>
            </a>

            <a class="manageModule borderRight" href="{{route("user.msglist")}}">
                <div class="manageBorder borderBottom" >
                    <img src="{{asset("mobile/bluev3/img/person/index-hlf-icon6.png")}}"/><br/>站内短信
                    <div  class="notice" id="top_msg">0</div>
                </div>
            </a>

            <a class="manageModule borderRight" href="{{route("user.shouyi",["id"=>1])}}">
                <div class="manageBorder borderBottom" >
                    <img src="{{asset("mobile/bluev3/img/person/accTotal.png")}}"/><br/>收益记录
                </div>
            </a>

            <a class="manageModule borderRight" href="{{route("user.tender")}}">
                <div class="manageBorder borderBottom" >
                    <img src="{{asset("mobile/bluev3/img/person/icon-in4.png")}}"/><br/>投资记录
                </div>
            </a>
            <a class="manageModule borderRight" href="{{route("user.shouyi",["id"=>"all"])}}" >
                <div class="manageBorder borderBottom">
                    <img src="{{asset("mobile/bluev3/img/person/accBank.png")}}"/><br/>资金流水
                </div>
            </a>

            <a class="manageModule borderRight" href="{{route("user.recharges")}}">
                <div class="manageBorder borderBottom" >
                    <img src="{{asset("mobile/bluev3/img/person/accBusiness.png")}}"/><br/>充值记录
                </div>
            </a>

            <a class="manageModule borderRight" href="{{route("user.withdraws")}}">
                <div class="manageBorder borderBottom" >
                    <img src="{{asset("mobile/bluev3/img/person/redom.png")}}"/><br/>提现记录
                </div>
            </a>



                   <a class="manageModule borderRight" href="{{route("user.record")}}">
                   <div class="manageBorder borderBottom" >
                         <img src="{{asset("mobile/public/style/left/images/left/c9.png")}}"><br/>
                    推广人数(<span style="color:#ff6600;font-weight:bold;">{{$xiaxians}}</span>)            </div>      </a>
         


            <a class="manageModule borderRight" href="http://www.farasis38.com/singlepage/qunliao88.html">
                <div class="manageBorder borderBottom" >
                    <img src="{{asset("mobile/bluev3/img/person/icon-in7.png")}}"/><br/>加入群聊
                </div>
            </a>



            <div class="clear"></div>
            <a href="{{route("wap.loginout")}}" class="input_btn">安全退出</a>


            <!--
                <div class="huodongbg"  id="huodongbg" style="width:100%;height:2000px;position: fixed;top: 0;left:0;background-color: rgba(0,0,0,0.35);z-index: 9999999;">
                    <div style="width:300px;height:500px;position: fixed;top: 0;left:0;right:0;bottom:0;margin:auto;background-color: #6660;">
                        <a  href="{:U('About/details','id=23')}" class="regNotice_span"><span id="count5s">9</span>秒后自动关闭</a>
                        <a href="{:U('About/details','id=23')}" style="">
                            <img src="__PUBLIC__/mobile/img/person/regRed1.png" width="300px" height="460px"/>
                        </a>
                        <a href="{:U('About/details','id=23')}" onclick="hidebg()" style="width:100px;height:25px;line-height:25px;text-align: center;position:absolute;left: 110px;top: 420px;border: 1px solid #c5304a;background: #c5304a;color: #fff;">赚钱攻略</a>
                    </div>
                </div>
           -->

        </section>
    </section>
    <style>
        .clear { clear:both;}
        .manageModule { width:33.333333%; text-align:center; float:left; display:block; color:#333; font-size:13px;}
        .manageModule:focus { color:#333; text-decoration:none;}
        .manageModule:link { color:#333; text-decoration:none;}
        .manageModule:visited { color:#333; text-decoration:none;}
        .manageModule:hover { color:#333; text-decoration:none;}
        .manageModule:active { color:#333; text-decoration:none;}
        .manageBorder {height:100%; padding:10%;}
        .borderRight{ position: relative; }
        .borderRight:after{ content: ''; display:block; position: absolute; width: 1px; right: 0px; top: 0px;height: 100%; background-color: #ccc; -webkit-transform: scaleX(0.5); transform: scaleX(0.5);}
        .borderBottom{ position: relative; background:#FFF; }
        .borderBottom:after{ content: ''; display:block; position: absolute; left: 0px; bottom: 0px;height: 1px; background-color: #ccc; -webkit-transform: scaleY(0.5); transform: scaleY(0.5);}
        .borderTop:after{ content: ''; display:block; position: absolute; left: 0px; top: 0px;height: 1px; background-color: #ccc; -webkit-transform: scaleY(0.5); transform: scaleY(0.5);}
        .manageModule img { width:28%; max-width:35px; margin-bottom:10px;}
        .manageModule:hover { text-decoration:none;}
        .manageModule.noborder { border-bottom:none;}
        .regNotice_span{width:110px;height:25px;line-height:25px;text-align:center;position:absolute;right: 18px;top: 5px;color:#fff;}
    </style>

    <!--旧模板-->










    <script>

        function qiandao() {
            var _token = "{{ csrf_token() }}";
            $.ajax({
                url: '{{route('user.qiandao')}}',
                type: 'post',
                data: {_token:_token},
                dataType: 'json',
                error: function () {
                },
                success: function (data) {
                    layer.open({
                        content: data.msg,
                        time:2000,
                        shadeClose: false,

                    });
                }
            });
        }

    </script>
    <script type="text/javascript">

        $(document).ready(function (e) {

            $(".wenhao").click(function () {
                var msg = '全球分红奖励：全球分红奖励为每天直推5个有效会员可以领取全球分红一次，10个为2次，以此类推（有效会员为：当天注册并且当天充值投资的用户，投资的金额不限，但一定是要成功投资购买项目了的会员）';
                layer.alert(msg, {
                    skin: 'layui-layer-molv'
                    ,closeBtn: 0
                });
            })
        });
    </script>




    @if(isset($Member))
        <script type="text/javascript">
            //播放提示音
            function playSound(name,str){
                $("#"+name+"").html('<embed width="0" height="0"  src="/mobile/public/Front/sound/'+str+'" autostart="true" loop="false">');

                if(document.getElementById("'"+name+"'")){
                    document.getElementById("'"+name+"'").Play();
                }
            }

            function total() {
                $.get("{{route('user.msg')}}",function(data){

                    //top_msg = parseInt($("#top_msg").text()); //统计未读短信

                    //赋值到模板
                    $("#top_msg").html(data.msgs); //统计未读短信

                    /*layer.tips(data.msgs, '#top_msg', {
                        tips: 2,
                        time:15000
                    });*/

                    @if(Cache::get('UserMsgSound')=='开启')
                    //未读站内短信提示
                    if (data.playSound > 0 && data.msgs > 0) {
                        playSound('top_playSound','msg.mp3');
                    }else if (data.layims > 0) {
                        playSound('top_playSound','default.mp3');
                    }

                    @endif
                },'json');
            }
            total();
            setInterval("total()",15000);


        </script>
    @endif

@endsection

@section('footcategoryactive')

@endsection
@section("footbox")
    @parent
@endsection

@section("footer")
    @parent


    <font id="top_playSound"></font>
@endsection

