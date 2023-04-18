
<!DOCTYPE HTML>
<html>
<head>
    <META http-equiv=Content-Type content="text/html; charset=gb2312">
    <title>幸运大转盘</title>


    <link rel="stylesheet" type="text/css" href="/pc/finance/lottery/images/css.css" />
    <script type="text/javascript" src="/pc/finance/lottery/js/jquery.js"></script>
    <script type="text/javascript" src="/pc/finance/lottery/js/jQueryRotate.2.2.js"></script>
    <script type="text/javascript" src="/pc/finance/lottery/js/jquery.easing.min.js"></script>
   <!-- <script type="text/javascript" src="/pc/finance/lottery/js/cj.js"></script>-->
    <script type="text/javascript" src="{{asset("layim/layui.js")}}"></script>


    <style>
        #disk{width:1000px; height:527px;background:url(/uploads/{{Cache::get('lotterysbg').'?t='.time()}}) no-repeat}
    </style>
</head>
<body>




<div style="background:url(/pc/finance/lottery/images/top.jpg) no-repeat center center; height:675px;"> </div>
<div>
    <!--抽奖区域[-->
    <div class="gl">
        <div class="box_11">
            <!--抽奖转盘[-->
            <div class="demo">

                <div id="disk">
                </div>
                <div id="start">
                    <img src="/pc/finance/lottery/images/start.png" alt="抽奖" id="startbtn" />
                </div>
                <!--中奖名单[-->
                <div id="rightDemos">
                    <ul id="rightBoxs">


                    </ul>
                </div>
                <!--]end 中奖名单-->
                <!--中奖名单[-->
                <div id="rightDemo">
                    <ul id="rightBox">

                    </ul>
                </div>
                <!--]end 中奖名单-->
            </div>
            <!--]end 抽奖转盘-->
        </div>
    </div>


    <div id="guize">

        <table border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td colspan="4"><font color="#FF0000"><b>奖品设置：</b></font><br />
                    1.每周6部iPhoneXS 容量256G（深空灰色,银色各三部）摇完为止，第二周恢复6部；<br>
                    &nbsp; （iPhoneXS苹果手机中奖者请直接联系在线客服留下详细的收货地址和联系方式）注：实物奖品可折现（8折折算）<br />
                    2.现金奖励：奖金为1元，5元，10元，100元，500元，999元;现金天天送，拿也拿不完；（中奖金额会自<br>
                    &nbsp; 动添加到您的用户，可作为投资资金，投资返还后可提现！其他实物奖励，将在中奖的15个工作日内寄出！）</td>
            </tr>
            <tr>
                <td rowspan="5" width="14%">　</td>
                <td colspan="3" width="64%"><font color="#FF0000"><b>会员按照等级每天可免费摇奖次数：</b></font></td>
            </tr>

            <tr>
                <td colspan="3" width="64%">
                    <div>
                        <ul>
                            @if($memberlevel)
                                @foreach($memberlevel as $level)
                                    @if($level->wheels>0)
                                        <li style="float:left;width:33%;display: block;column-count:auto;">
                                            {{$level->name}}每日可摇奖{{$level->wheels}}次
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="3" width="64%"><font color="#800000">摇奖潜规则提示：会员投资越多、等级越高，每天摇奖次数越多，中大奖机会更大，奖品更丰富；<br />
                        活动最终解释权归公司所有</font></td>
            </tr>
            </tbody>
        </table>





    </div>
</div>
<script type="text/javascript" src="/pc/finance/lottery/js/cjs.js"></script>
<script type="text/javascript">
    $(function() {
        $("#yb_top").click(function() {
            $("html,body").animate({
                'scrollTop': '0px'
            }, 300)
        })
        $(".consultation-code-container").hover(function(){
            $(".wx-img").show();
        },function(){
            $(".wx-img").hide();
        })
    });
    $(function(){

    });


    $(function() {
        $("#startbtn").click(function() {
            lottery();
        });
    });


    function cjgo(a,p) {

        layui.use('layer', function(){ //独立版的layer无需执行这一句
            var layer = layui.layer; //独立版的layer无需执行这一句

        $("#startbtn").unbind('click').css("cursor", "default");


        $("#startbtn").rotate({
            duration: 3000,
            //转动时间
            angle: 0, //默认角度
            animateTo:1800+a, //转动角度
            easing: $.easing.easeOutSine, callback: function(){



                layer.msg(p, {
                    icon: 1,
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                }, function(){
                    $("#startbtn").rotate({angle:0});
                    $("#startbtn").click(function(){
                        lottery();
                    }).css("cursor","pointer");
                });






            }
        });

        });
    }

    function lottery() {


        var url="{{route("user.lotterys.click")}}";
        $.ajax({ type : "post",data:{"_token":"{{ csrf_token() }}"}, async:true,  url : url, dataType : "jsonp"});







    }


    function getzjlist(){

        $.post("{{route("user.lotterys.winlist")}}",{"_token":"{{ csrf_token() }}"},function(e){
            $('#rightBox').html(unescape(e));
            $('#rightBoxs').html(unescape(e));
        },'html');
    }
    getzjlist();

</script>




</body>
</html>