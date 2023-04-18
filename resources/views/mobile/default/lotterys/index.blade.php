<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>大转盘抽奖</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta content="telephone=no" name="format-detection" />
    <meta content="email=no" name="format-detection" />
    <meta name="apple-touch-fullscreen" content="NO">
    <link href="{{asset("mobile/public/lottery/wap_Lottery2.css")}}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{asset("mobile/static/js/jquery.js")}}"></script>
    <script type="text/javascript" src="{{asset("mobile/public/layer_mobile/layer.js")}}"></script>

</head>
<body>

<link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/user.css")}}"/>
<link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/index.css")}}"/>
<link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/public.css")}}"/>
<link rel="stylesheet" type="text/css" href="{{asset("wap/cp/css/index.css")}}"/>

    <div class="top" id="top"
         style="background-color: #0E90D2;height: 50px;position: fixed;width:100%;max-width: 450px;z-index: 10000;">
        <div class="kf">

            <div style="display: block;width:100%; background-color: cornsilk;position: absolute;top: 0;
     left: 0;text-align: center;  height: 50px; line-height: 50px; ">
                <p><a class="sb-back" href="javascript:history.back(-1)" title="返回"
                      style=" display: block; width: 40px;    height: 40px;
                              margin: auto; background: url('{{asset("mobile/images/arrow_left.png")}}') no-repeat 15px center;float: left;
                              background-size: auto 16px;font-weight:bold;">
                    </a>
                </p>
                <img src="\uploads\{{\Cache::get('waplogo').'?t='.time()}}" style="height: 80%;line-height: 50px;"/>

                <a href="javascript:;"
                   style="text-align: center;  font-size: 16px; ">{{\Cache::get('CompanyShort')}}</a>
            </div>

        </div>
    </div>
<div id="wrapper">
    <div id="container">
        <div id="main">
            <div class="lotteryTitle">抽奖活动</div>
            <div class="lotteryTitle2">玩家:{{$Member->username}} 余额:<span id="jinb">{{$Member->amount}}</span></div>

            <div id="lottery">
                <div class="lotBg">
                    <div class="lotLight lotLight-animation2">
                        <li class="lotLight1"><i></i></li>
                        <li class="lotLight2"><i></i></li>
                        <li class="lotLight3"><i></i></li>
                        <li class="lotLight4"><i></i></li>
                        <li class="lotLight5"><i></i></li>
                        <li class="lotLight6"><i></i></li>
                        <li class="lotLight7"><i></i></li>
                        <li class="lotLight8"><i></i></li>
                        <li class="lotLight9"><i></i></li>
                        <li class="lotLight10"><i></i></li>
                        <li class="lotLight11"><i></i></li>
                        <li class="lotLight12"><i></i></li>
                        <li class="lotLight13"><i></i></li>
                        <li class="lotLight14"><i></i></li>
                        <li class="lotLight15"><i></i></li>
                        <li class="lotLight16"><i></i></li>
                        <li class="lotLight17"><i></i></li>
                        <li class="lotLight18"><i></i></li>
                        <li class="lotLight19"><i></i></li>
                        <li class="lotLight20"><i></i></li>
                        <li class="lotLight21"><i></i></li>
                        <li class="lotLight22"><i></i></li>
                        <li class="lotLight23"><i></i></li>
                        <li class="lotLight24"><i></i></li>
                        <li class="lotLight25"><i></i></li>
                        <li class="lotLight26"><i></i></li>
                        <li class="lotLight27"><i></i></li>
                        <li class="lotLight28"><i></i></li>
                        <li class="lotLight29"><i></i></li>
                        <li class="lotLight30"><i></i></li>
                        <li class="lotLight31"><i></i></li>
                        <li class="lotLight32"><i></i></li>
                        <li class="lotLight33"><i></i></li>
                        <li class="lotLight34"><i></i></li>
                        <li class="lotLight35"><i></i></li>
                        <li class="lotLight36"><i></i></li>
                    </div>
                    <div class="lotCon">
                        <div class="prize prize1"><div class="prizebg"></div></div>
                        <div class="prize prize2"><div class="prizebg"></div></div>
                        <div class="prize prize3"><div class="prizebg"></div></div>
                        <div class="prize prize4"><div class="prizebg"></div></div>
                        <div class="prize prize5"><div class="prizebg"></div></div>
                        <div class="prize prize6"><div class="prizebg"></div></div>
                    </div>
                    <div class="lotTxt">
                        <p class="txt1"><span>苹果X</span></p>
                        <p class="txt2"><span>999元</span></p>
                        <p class="txt3"><span>500元</span></p>
                        <p class="txt4"><span>100元</span></p>
                        <p class="txt5"><span>10元</span></p>
                        <p class="txt6"><span>谢谢参与</span></p>
                    </div>
                    <div class="lotImg">
                        <p class="img1"><img src="/mobile/public/lottery/1.png" /></p>
                        <p class="img2"><img src="/mobile/public/lottery/2.png" /></p>
                        <p class="img3"><img src="/mobile/public/lottery/3.png" /></p>
                        <p class="img4"><img src="/mobile/public/lottery/4.png" /></p>
                        <p class="img5"><img src="/mobile/public/lottery/5.png" /></p>
                        <p class="img6"><img src="/mobile/public/lottery/8.png" /></p>
                    </div>
                    <div class="lotCenter">
                        <i></i>
                        <a href="javascript:void(0)"><span>开始<br />抽奖</span></a>
                    </div>
                </div>
            </div>
            <!--这里填写说明-->
            <div class="shuomingb" style="display:none;">
                <p class="txtb0"><span>今天抽奖次数已用完.</span></p>
                <p class="txtb1"><span>恭喜您抽中一等奖 苹果X 手机一部,我们将在一个工作日内联系您,请保持手机畅通.</span></p>
                <p class="txtb2"><span>恭喜您抽中二等奖 999元,系统已经存入您的余额中</span></p>
                <p class="txtb3"><span>恭喜您抽中三等奖 500元,系统已经存入您的余额中</span></p>
                <p class="txtb4"><span>恭喜您抽中四等奖 100元,系统已经存入您的余额中</span></p>
                <p class="txtb5"><span>恭喜您抽中五等奖 10元,系统已经存入您的余额中</span></p>
                <p class="txtb6"><span>再接再厉,大奖等着你</span></p>
            </div>
            <div class="lotterynum" style="line-height:20px;" id="chongjianglist">

            </div>
            <div class="lotterynum" style="line-height:20px;">
                活动说明：<br>
                （1）每次抽奖扣{{Cache::get('lotterypoint')}}元<br>
                （2）抽中奖金的,系统会自动把奖金存入您的余额<br>
                （3）抽中实物的,系统会自动下单,请在抽奖前在个人资料里完善您的物流信息!<br>
                （4）爱心公益广告，关心每个人的内心，无声胜有声。收益将捐赠于贫困儿童!<br>
                （5）本活动解释权归公司所有<br></div>

        </div>
    </div>
</div>
<section style="display: none;" class="fullHtml loadingBox" id="loadingBox"><i></i><span>加载中...</span></section>

<script>


    var cj=true;

    function getmemberamount(){

        $.post("{{route("user.lotterys.amount")}}",{"_token":"{{ csrf_token() }}"},function(e){
            $('#jinb').html(e)
        },'html')
    }

    function getzjlist(){

        $.post("{{route("user.lotterys.winlist")}}",{"_token":"{{ csrf_token() }}"},function(e){
            $('#chongjianglist').html(unescape(e))
        },'html');
    }

    function zhuanpan(cid){
        var Pnum=$(".prize").length;
        var classid=cid;
        if(Pnum<classid){alert("奖品不存在")}
        $(".lotCenter").addClass("lotCenter-animation"+Pnum+"-"+classid);
        $(".lotLight").removeClass("lotLight-animation2").addClass("lotLight-animation1");
        setTimeout(function(){


            layer.open({
                content: $(".shuomingb .txtb"+cid).html()
                ,btn: '确定'
                ,time:0
                ,end:function(){
                    $(".lotCenter").removeClass("lotCenter-animation"+Pnum+"-"+classid);
                    $(".lotLight").removeClass("lotLight-animation1").addClass("lotLight-animation2");
                    cj=true;
                }
            });

        },6000);
    }

    function cjgo(a,b){
        //if(b==0 && a==0){
        if(a<=0){
            $('#jinb').html(a);
            //layer.open("您的余额不足");

            layer.open({
                content: "您的余额不足"
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
            });

            return false;
        }

        $('#jinb').html(a.toFixed(2));
        zhuanpan(b);
    }

    $(document).ready(function(e){
        getzjlist();
        setInterval('getzjlist()',10000);
        setInterval('getmemberamount()',10000);
        $(".lotCenter").click(function(){
            if(cj){
                cj=false;
                var url="{{route("user.lotterys.click")}}";
                $.ajax({ type : "post",data:{"_token":"{{ csrf_token() }}"}, async:true,  url : url, dataType : "jsonp"});
            }
        });

        var Pnum=$(".prize").length;
        var deg=360/Pnum;
        for(var i=1;i<=Pnum;i++){
            var numdeg=deg*i-deg;
            if(Pnum==6){var pdeg1=i*deg+deg;};
            if(Pnum==5){
                var pdeg1=i*deg+54;
                $(".prize1 .prizebg").css("background","#fcb600");
                $(".prize2 .prizebg").css("background","#f28501");
                $(".prize3 .prizebg").css("background","#f9a700");
                $(".prize4 .prizebg").css("background","#f69601");
                $(".prize5 .prizebg").css("background","#fec000");
            };
            if(Pnum==4){var pdeg1=i*deg+45;};
            if(Pnum==3){
                var pdeg1=i*deg+deg+30;
                $(".prize1 .prizebg").css("background","#fcb600");
                $(".prize2 .prizebg").css("background","#f28501");
                $(".prize3 .prizebg").css("background","#f9a700");
            };
            if(Pnum==2){var pdeg1=i*deg+deg;};
            var pdeg2=90-deg;
            $(".img"+i).css("transform","rotate("+numdeg+"deg)");
            $(".txt"+i).css("transform","rotate("+numdeg+"deg)");
            $(".prize"+i).css("transform","rotate("+pdeg1+"deg)");
            $(".prizebg").css("transform","rotate("+pdeg2+"deg)");
        }
        //页面大小
        initialise();
    });

    $(window).resize(function(e) {
        initialise();
    });

    function initialise(){
        var windowwidth=$(window).width();
        if(windowwidth>640){windowwidth=640;}
        var scale=windowwidth/320;
        $("#main").css("padding-top",scale*40);
        $(".lotterynum").css({"margin-left":scale*30,"margin-right":scale*30});
    }

</script>


</body>

</html>