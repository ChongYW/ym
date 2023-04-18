 <!DOCTYPE html>
<html class="mq-xs mq-sm mq-md mq-lg mq-gfb">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<meta charset="UTF-8" /> 
<title><?php echo configW('webname'); ?></title> 
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
<meta name="description" content="<?php echo configW('webname'); ?>" /> 
<meta name="keywords" content="<?php echo configW('webname'); ?>" />
<link rel="stylesheet" type="text/css" href="/public/Front2/css/base.css">
<link rel="stylesheet" type="text/css" href="/public/Front2/css/style.css">



<script type="text/javascript" src="/public/Front2/js/jquery.min.js"></script>
<script type="text/javascript" src="/public/Front2/js/jquery.SuperSlide.2.1.1.js"></script>

<script type="text/javascript">
// JavaScript Document
function urlredirect() {
    var sUserAgent = navigator.userAgent.toLowerCase(); 
    if ((sUserAgent.match(/(ipod|iphone os|midp|ucweb|android|windows ce|windows mobile)/i))) {
        // PC跳转移动端
        var thisUrl = window.location.href;
        window.location.href = thisUrl.substr(0,thisUrl.lastIndexOf('/')+1)+'mobile/';
         
    }
}
urlredirect();
</script>
<link rel="stylesheet" type="text/css" href="/public/Front/css/default.css">
<link rel="stylesheet" href="/public/Front/css/liMarquee.css">
<link rel="stylesheet" href="/public/Front2/css/jqcool.css">
<script type="text/javascript" src="/public/Front2/js/sl.js"></script>
<link rel="stylesheet" href="/public/style/css/indexcss.css"/>
<link rel="stylesheet" href="/public/style/css/indexstyle.css"/>
<script type="text/javascript" src="/public/Front/js/json-eps.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/Front/user/user.js"></script>
<style>
    .bd .conWrap .con {
        /*width: 895px !important;*/
        height: auto;
        overflow: hidden;
        position: relative !important;

    }

    .bd .conWrap {
        height: auto;
        overflow: hidden;
    }
</style>
<style type="text/css">
    .str_wrap {
        padding-left: 3em;
        padding-right: 3em;
        margin-top-: -10px;
        height: 3em;
        line-height: 3em;
        font-size: 1.3em;
        color: white;
    }
    .htitle{
        margin:15px 0 15px 0;
        text-align: left;
        padding-left: 10px;
        font-weight: bold;
        overflow: hidden;
        height: 25px;
    }
    span.tb {
        border-left: 2px solid #C00;
        padding-left: 10px;
        font-weight: bold;
        float: left;
        font-size: 16px;
    }
</style>

</head>
<body>

<div class="top" id="top" style="    width: 100%;    margin: 0 auto;">
    <div class="kf">
        <p style="float:left;"><i></i><span>服务热线:00852-53739434</span></p>
                    <p style="float:right;">欢迎您来到<?php echo configW('webname'); ?><a href="/login.php">登录</a><a href="/register.php">注册</a></p>

                  
    </div>
</div>
<div class="menu-wrap">
    <div class="menu">
        <img src="/public/Front2/images/logo.png" />
        <img src="/public/Front2/images/top400.jpg" />
    </div>
</div>
<div class="clear"></div>
<div id="page_menu">
    <ul>
                <li><a href="/">首页</a></li>
        <li ><a href="/projectlist.php?type=rt">投资项目</a></li>
        <li ><a href="/trial.php">收益试算</a></li>
        <li ><a href="/aboutus/menu.php?id=13">会员等级</a></li>
        <li ><a href="/aboutus/menu.php?id=14">邀请好友</a></li>
        <li ><a href="/aboutus/menu.php?id=11">安全保障</a></li>
        <li ><a href="/aboutus/menu.php?id=16">常见问题</a></li>
        <li ><a href="/aboutus/menu.php?id=17">关于我们</a></li>
    </ul>
</div>
<script type="text/javascript">
    //播放提示音
    function playSound(name,str){
        $("#"+name+"").html('<embed width="0" height="0"  src="/public/Front/sound/'+str+'" autostart="true" loop="false">');
        document.getElementById(""+name+"").Play();
    }

    function total() {
        $.get("/action/user.php?action=msg_Unread",function(data){
            top_msg = parseInt($("#top_msg").text()); //统计未读短信

            //   //赋值到模板
            $("#top_msg").html(data); //统计未读短信

            //   //未读站内短信提示
            if (data > 0) {
                playSound('top_playSound','msg.mp3');
            }
        });
    }
    total();
    setInterval("total()",3000000);
</script>
<div class="banner">
    <div class="trigger">
        <div class="bd">
            <ul>
                <li><a href="/register.php" target="_blank"><img src="/public/Front2/images/banner1.jpg"></a></li>
                <li><a href="/register.php" target="_blank"><img src="/public/Front2/images/banner2.jpg"></a></li>
                <li><a href="/register.php" target="_blank"><img src="/public/Front2/images/banner3.jpg"></a></li>
                <li><a href="/register.php" target="_blank"><img src="/public/Front2/images/banner4.jpg"></a></li>
                <li><a href="/register.php" target="_blank"><img src="/public/Front2/images/banner5.jpg"></a></li>
            </ul>
        </div>
        <div class="hd">
            <ul>
                <li class="on"></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>

    </div>

    <div class="picshow-main">
        <div class="picshow-box">
            <!--<h3 ><span>78,249,572,945</span>投资者</h3>-->

            <div class="bd">
                <div class="bd_title">最高日化收益率</div>
                <div class="average"><span>2.00%</span></div>
                <div class="bd_content">本息保障</div>
                <ul>

                    <li class="loginfont"><a href="/login.php" target="_blank" class="sub02">立即登录</a></li>
                    <li><a href="/register.php" class="sub01" target="_blank">注册送红包</a></li>
                </ul>
            </div>


        </div>
    </div>




  <div class="focus" style="">
      <div class="focus-news">
          <span>最新公告:</span>
          <div class="str3 str_wrap">
             <div style="color: #333;">提现时间：每日8:00-22:00提现2个小时内可到账。夜间22：00-次日7：59提现当天上班时间处理</div>
          </div>
      </div>
  </div>

</div>






 <div class="comt1 din" style=" margin-top:10px">
  <div class="comt1l">
    <div class="comt1lt"><a href="/aboutus/menu.php?id=17">什么是<?php echo configW('webname'); ?>？</a></div>
    <div class="comt1lb"><?php echo configW('webname'); ?>是一家独立的投资管理公司，在全球多个金融中心设有办事处，致力通过主动管理的策略，为机构、分销商、私人客户和慈善组织提供完备的投资方案。他们的目标是为客户带来长期卓越的投资回报。 …<a href="/aboutus/menu.php?id=17">了解更多</a></div>
  </div>
  <div class="comt1r">
    <div class="touzt"></div>
    <div class="touzb">
      <div class="touzbl">
        <div class="touzblb">聪明的投资人已投资总额</div>
        <div class="touzblt" id="usertzze" style="font-size:22px; ">78249572945<span>元</span></div>
      </div>
      <div class="touzbr">
        <div class="touzblb">聪明的投资人已赚取收益</div>
        <div class="touzblt" style="font-size:22px;">￥78249572945<span>元</span></div>
      </div>
    </div>
  </div>
  <div class="nofl"></div>
</div>





<div class="linebg">
  <div class="warp center clearfix">
    <div class="dright default_left">
      
      
            <div class="index_links " style="padding-left:10px">
                
                <a href="/aboutus/menu.php?id=11">
                <dl class="l2">
                    <dt></dt>
                    <dd>
                        <h1>安全保障</h1>
                        <p>严格的资金审核，全程监控，专业管理
                       隐私保护，最安全的网上理财</p>
                    </dd>
                </dl>
                </a>
                
                <a href="/aboutus/menu.php?id=14">
                <dl class="l3">
                    <dt></dt>
                    <dd>
                        <h1>推荐好友</h1>
                        <p>您身边触手可及的理财管家
帮助他人，获得稳定高收益
      100%本息保障</p>
                    </dd>
                </dl>
                </a>


                <a href="/aboutus/menu.php?id=16">
                <dl class="l4">
                    <dt></dt>
                    <dd>
                        <h1>常见问题</h1>
                        <p>30倍银行存款利息，100元起投，0手续费
                        投入资金、每天坐享其成</p>
                    </dd>
                </dl>
                
                </a>
            </div>      
      
      
    </div>
    <script src="js/jq_scroll.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#scrollDiv").Scroll({ line: 1, speed: 20000, timer: 100, up: "but_up", down: "but_down" });
        });
    </script>
    <div class="default_right Notices">
      <div style="margin-left:20px;margin-right:20px;">
        <div class="htitle"></div>
        <div class="htcontent">
          <div class="scrollbox">
            <div class="scroltit"><small id="but_up" style="cursor: pointer;">↑向上</small><small id="but_down" style="cursor: pointer;">↓向下</small></div>
            <div id="scrollDiv">
              <ul style="margin-top: -3.69034px;">
                
              <li>



                       <p> <span><a href="/aboutus/newsinfo.php?id=342">注册即可获赠礼券</a></span> </p>
                                    <p> <span><a href="/aboutus/newsinfo.php?id=341">实名认证</a></span> </p>
                                
                </li></ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>






<!-- <div class="w1180">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td height="250">
                <div class="w1180  fn_cle ">
                    <div class="mainLeadList">
                        <ul>
                            <li><strong><i class="i-pb1"></i></strong><b>360°安全保证</b><span>【本息保障】<br>
                                线下实体风控<br>
                                 资金托管体系</span></li>
                            <li><strong><i class="i-pb2"></i></strong><b>高收益低门槛</b><span>100元起投<br>
                                45倍银行活期存款收益<br>
                                10秒开户闪电投资</span></li>
                            <li><strong><i class="i-pb3"></i></strong><b>分红提现</b><span>5分钟到账<br>
                                操作简单，方便快捷</span></li>
                            <li><strong><i class="i-pb4"></i></strong><b>新手指引</b><span>从这里开始，加入工业投资<br>
                                轻松体验互联网金融<br>
                                理财新方式</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div> -->
<div class="clearfix w1180 pt_20 index_main" style="background-color: #f1f1f1;">


    <div class="data">

        <div class="data-right">

            <div class="licaibox">
                <div class="bd">
                    <div class="conWrap">
                        <div class="con">
                            <div class="htitle"><span class="tb">新手项目</span><span class="more"></span></div>
                            
                                <div class="fina-list">
                                    <div class="finaimg">
                                        <a href="/project.php?id=142">
                                            <img width="130" height="140"
                                                 src="/public/Project/599299b95db32.jpg"></a>
                                    </div>
                                    <div class="fina-content">
                                        <h4>
                                            <a class="blue fs_18" href="/project.php?id=142"
                                               title="香港恒生国企指数期权合约产品"><img
                                                        src="/img/credit.gif">香港恒生国企指数期权合约产品</a> <span
                                                    class="pai">项目规模：<em
                                                        class="fs_14"><b>￥80000                                                        万</b></em>元</span></h4>

                                        <div class="row">
                                            <span>日化利率：</span>
                                            <span class="yellow fs">1.0%</span></div>
                                        <div class="row">
                                            <span>投资期限：</span>
                                            <span class="fs">
                    <span class="yellow fs"
                          style="color:#666;">1</span>个自然日</span>
                                        </div>
                                        <div class="row">
                                            <span>起投金额：</span>
                                            <span class="fs">
                    <span class="yellow fs">100</span>元</span></div>


                                        <div class="row fina_plan">


                                                <span class="b_jingdu b_jd28.4">28.4                                                    %</span>


                                        </div>
                                        <div class="row fina_plansy" style="width:200px; float:right">
                  <span style="width:auto;height: 20px;
    line-height: 20px;">还款方式：</span>
                                            <span class="fs" style="width:auto;height: 20px;
    line-height: 20px;">
                                        按周期付收益，到期还本
                                    </span></div>
                                        <p class="rowbtn">
                                                                                        <a class="finabtn bluebtn"
                                               href="/project.php?id=142"
                                               title="立即投资">立即投资</a></p>
                                                                            </div>
                                </div>
                                                        <div class="htitle"><span class="tb">最新推荐产品</span><span class="more"></span></div>
                            
                                <div class="fina-list">
                                    <div class="finaimg">
                                        <a href="/project.php?id=144">
                                            <img width="130" height="140"
                                                 src="/public/Project/59929bd649088.jpg"></a>
                                    </div>
                                    <div class="fina-content">
                                        <h4>
                                            <a class="blue fs_18" href="/project.php?id=144"
                                               title="<?php echo configW('webname'); ?>"><img
                                                        src="/img/credit.gif"><?php echo configW('webname'); ?></a> <span
                                                    class="pai">项目规模：<em
                                                        class="fs_14"><b>￥12                                                        万</b></em>元</span></h4>

                                        <div class="row">
                                            <span>日化利率：</span>
                                            <span class="yellow fs">1%</span></div>
                                        <div class="row">
                                            <span>投资期限：</span>
                                            <span class="fs">
                    <span class="yellow fs"
                          style="color:#666;">1</span>个自然日</span>
                                        </div>
                                        <div class="row">
                                            <span>起投金额：</span>
                                            <span class="fs">
                    <span class="yellow fs">12</span>元</span></div>


                                        <div class="row fina_plan">


                                                <span class="b_jingdu b_jd12">12                                                    %</span>


                                        </div>
                                        <div class="row fina_plansy" style="width:200px; float:right">
                  <span style="width:auto;height: 20px;
    line-height: 20px;">还款方式：</span>
                                            <span class="fs" style="width:auto;height: 20px;
    line-height: 20px;">
                                        按周期付收益，到期还本
                                    </span></div>
                                        <p class="rowbtn">
                                                                                        <a class="finabtn bluebtn"
                                               href="/project.php?id=144"
                                               title="立即投资">立即投资</a></p>
                                                                            </div>
                                </div>
                            
                                <div class="fina-list">
                                    <div class="finaimg">
                                        <a href="/project.php?id=146">
                                            <img width="130" height="140"
                                                 src="/public/Project/599a860233b50.jpg"></a>
                                    </div>
                                    <div class="fina-content">
                                        <h4>
                                            <a class="blue fs_18" href="/project.php?id=146"
                                               title="美国深海石油NJ-973开发项目"><img
                                                        src="/img/credit.gif">美国深海石油NJ-973开发项目</a> <span
                                                    class="pai">项目规模：<em
                                                        class="fs_14"><b>￥65536                                                        万</b></em>元</span></h4>

                                        <div class="row">
                                            <span>日化利率：</span>
                                            <span class="yellow fs">21%</span></div>
                                        <div class="row">
                                            <span>投资期限：</span>
                                            <span class="fs">
                    <span class="yellow fs"
                          style="color:#666;">1</span>个自然日</span>
                                        </div>
                                        <div class="row">
                                            <span>起投金额：</span>
                                            <span class="fs">
                    <span class="yellow fs">563</span>元</span></div>


                                        <div class="row fina_plan">


                                                <span class="b_jingdu b_jd563">563                                                    %</span>


                                        </div>
                                        <div class="row fina_plansy" style="width:200px; float:right">
                  <span style="width:auto;height: 20px;
    line-height: 20px;">还款方式：</span>
                                            <span class="fs" style="width:auto;height: 20px;
    line-height: 20px;">
                                        按周期付收益，到期还本
                                    </span></div>
                                        <p class="rowbtn">
                                                                                        <a class="finabtn bluebtn"
                                               href="/project.php?id=146"
                                               title="立即投资">立即投资</a></p>
                                                                            </div>
                                </div>
                            
                                <div class="fina-list">
                                    <div class="finaimg">
                                        <a href="/project.php?id=143">
                                            <img width="130" height="140"
                                                 src="/public/Project/59929ab9b09f4.jpg"></a>
                                    </div>
                                    <div class="fina-content">
                                        <h4>
                                            <a class="blue fs_18" href="/project.php?id=143"
                                               title="荷兰AEX指数期权合约产品"><img
                                                        src="/img/credit.gif">荷兰AEX指数期权合约产品</a> <span
                                                    class="pai">项目规模：<em
                                                        class="fs_14"><b>￥70000                                                        万</b></em>元</span></h4>

                                        <div class="row">
                                            <span>日化利率：</span>
                                            <span class="yellow fs">1.19%</span></div>
                                        <div class="row">
                                            <span>投资期限：</span>
                                            <span class="fs">
                    <span class="yellow fs"
                          style="color:#666;">3</span>个自然日</span>
                                        </div>
                                        <div class="row">
                                            <span>起投金额：</span>
                                            <span class="fs">
                    <span class="yellow fs">1000</span>元</span></div>


                                        <div class="row fina_plan">


                                                <span class="b_jingdu b_jd37.1">37.1                                                    %</span>


                                        </div>
                                        <div class="row fina_plansy" style="width:200px; float:right">
                  <span style="width:auto;height: 20px;
    line-height: 20px;">还款方式：</span>
                                            <span class="fs" style="width:auto;height: 20px;
    line-height: 20px;">
                                        按周期付收益，到期还本
                                    </span></div>
                                        <p class="rowbtn">
                                                                                        <a class="finabtn bluebtn"
                                               href="/project.php?id=143"
                                               title="立即投资">立即投资</a></p>
                                                                            </div>
                                </div>
                            
                                <div class="fina-list">
                                    <div class="finaimg">
                                        <a href="/project.php?id=145">
                                            <img width="130" height="140"
                                                 src="/public/Project/59929c6c80c30.jpg"></a>
                                    </div>
                                    <div class="fina-content">
                                        <h4>
                                            <a class="blue fs_18" href="/project.php?id=145"
                                               title="德科产品"><img
                                                        src="/img/credit.gif">德科产品</a> <span
                                                    class="pai">项目规模：<em
                                                        class="fs_14"><b>￥213                                                        万</b></em>元</span></h4>

                                        <div class="row">
                                            <span>日化利率：</span>
                                            <span class="yellow fs">4%</span></div>
                                        <div class="row">
                                            <span>投资期限：</span>
                                            <span class="fs">
                    <span class="yellow fs"
                          style="color:#666;">3</span>个自然日</span>
                                        </div>
                                        <div class="row">
                                            <span>起投金额：</span>
                                            <span class="fs">
                    <span class="yellow fs">500</span>元</span></div>


                                        <div class="row fina_plan">


                                                <span class="b_jingdu b_jd21">21                                                    %</span>


                                        </div>
                                        <div class="row fina_plansy" style="width:200px; float:right">
                  <span style="width:auto;height: 20px;
    line-height: 20px;">还款方式：</span>
                                            <span class="fs" style="width:auto;height: 20px;
    line-height: 20px;">
                                        按周期付收益，到期还本
                                    </span></div>
                                        <p class="rowbtn">
                                                                                        <a class="finabtn bluebtn"
                                               href="/project.php?id=145" title="已投满"
                                               style='background:#ff9000;'>已投满</a></p>
                                                                            </div>
                                </div>
                                                    </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">jQuery(".licaibox").slide({
                    mainCell: ".conWrap",
                    effect: "fold"
                });</script>


        </div>
    </div>

</div>



<style>
	#page_footer_menu{background-color:#CACACA;border-top:1px solid #d8d8d8;font-size:12px;height:315px; overflow:hidden;}
    #page_footer_menu ul li.title a{color:#ff6600;font-size:14px; font-weight:bold;}
    #page_footer_menu ul{float:left;width:190px;color:#ffffff;border-left:1px solid #B3B1B1;text-align:left;padding-left:30px;color:#ffffff;}
    #page_footer_menu ul li{height:35px;line-height:35px;}
    #page_footer_menu ul li a{display:block;width:200px;height:35px;color:#ffffff;font-size:12px;line-height:25px;}
    #page_footer_menu ul li a:hover{color:#ffffff;}
    
    #page_footer_menu .bottom_content{float:left;width:283px;color:#999;border-left:1px solid #484747;text-align:left;padding-left:50px;color:#818181;min-height:315px;background:url("/upfiles/bottom_content.jpg") top left no-repeat;}
    #page_footer_menu .bottom_content img{
    	display: inline;
    }
    .warp{width:1000px; display:block;}
.center{margin-left:auto;margin-right:auto;}

    
</style>
<div id="page_footer_menu">
  <div class="warp center">
    <ul>
      <li></li>
      <li class="title"><a href="/aboutus/menu.php?id=17">关于我们</a></li>
      <li><a href="/aboutus/menu.php?id=21" target="_blank">联系我们</a></li>
      <li><a href="/aboutus/menu.php?id=18" target="_parent">运营资质</a></li>
      <li><a href="/aboutus/menu.php?id=17">关于我们</a></li>








     
      <li></li>
    </ul>
    <ul>
      <li></li>
      <li class="title"><a href="Products.asp">投资产品</a></li>
<li>
	<a href="/aboutus/menu.php?id=16" target="_parent">常见问题</a>
</li>
<li>
	<a href="/aboutus/menu.php?id=11" target="_parent">安全保障</a>
</li>
<li>
	<a href="/trial.html" target="_parent">收益试算</a>
</li>

<li>
	<a href="/projectlist.php?type=rt" target="_parent">我要投资</a>
</li>
<li>
	<a href="/aboutus/news.php" target="_parent">最新公告</a>
</li>
      <li>&nbsp;</li>
      <li>&nbsp;</li>
    </ul>
    <ul>
      <li></li>
      <li class="title"><a href="">安全保障</a></li>
      <li>A、第三方担保</li>
      <li>B、专业监管的保证金账户</li>
      <li>C、24小时投资跟踪管理</li>
      <li>D、第三方支付，不设资金池</li>
      <li>E、专款专用</li>
      <li>F、专业的风控团队</li>
      <li>&nbsp;</li>
    </ul>
    <div class="bottom_content" style="text-align:center">
    
    <div style=" margin-top:30px">
    
    <img src="/josephvip/Public/kindeditor/attached/image/20170814/20170814082142_17874.png" border="0" width="150" height="150">
    </div>
    <div style="line-height:30px">
    扫描下载手机客户端
    </div>
    <div class="tel">00852-53739434</div>
    
    </div>
  </div>
</div>

<style>
  .tel{
    font-size: 26px;
    margin-top: 16px;
    font-weight: bold;
  }
</style>

 <div class="footer">
	<!-- <div class="w1190">
		<ul>
			<li>
				<a class="til">关于我们</a>
				<a href="/aboutus/jianjie.php" target="_parent">关于我们</a>
				<a href="/aboutus/quali.php" target="_parent">公司资质</a>
				<a href="/aboutus/contactus.php" target="_parent">联系我们</a>
			</li>
			<li>
				<a class="til">帮助中心</a>
				<a href="service/jr.php?type=about" target="_parent">常见问题</a>
				<a href="/safety.php" target="_parent">安全保障</a>
				<a href="/trial.html" target="_parent">收益试算</a>
			</li>
			<li>
				<a class="til">新手指引</a>
				<a href="/service/jr.php?type=hosting" target="_parent">新手指南</a>
				<a href="/projectlist.php?type=rt" target="_parent">投资项目</a>
				<a href="/aboutus/news.php" target="_parent">网站公告</a>
			</li>
			<li><a class="til">安全保障</a> <a>第三方担保</a> <a>帐户专业监管</a> <a>24小时投资跟踪管理</a></li>
			<li style="text-align:center;"><a class="til">APP下载</a> <img style="  width:100px;  margin-top:-10px;margin-left: -15px;" src="/img/qr.png"></li>
			<li class="last">
				<p class="til-ic">全国理财热线：</p>
				<p class="bd">00852-53739434</p>
				<p>工作日:09:00-23:00 节假日:9:00-21:00</p>
			</li>
		</ul>
	</div> -->
	<div class="f" style=" background:#555555; width:100%; text-align:center;">  桂ICP备17007429号 © 2016 <?php echo configW('webname'); ?> All rights reserved


<style>
  .iconc{
    display:inline-block;
  }
</style>
<br>
<span class="iconc">
<a id="_pinganTrust" target="_blank" href="http://c.trustutn.org/show?type=1&sn=201708111001814481"><img src="http://c.trustutn.org/images/cert/cert_0_1.png" /></a>

</span>

<span class="iconc">

<a id="jsl_speed_stat0" href="http://www.dekegs.com /" target="_blank">知道创宇云安全</a><script src="//static.yunaq.com/static/js/stat/picture_stat.js" charset="utf-8" type="text/javascript"></script>


</span>

<span class="iconc">

<a id='___szfw_logo___' href='https://credit.szfw.org/CX20170811035580590187.html' target='_blank'><img src='http://icon.szfw.org/cert.png' border='0' /></a>
<script type='text/javascript'>(function(){document.getElementById('___szfw_logo___').oncontextmenu = function(){return false;}})();</script>
</span>

<span class="iconc">

<span id="kx_verify"></span><script type="text/javascript">(function (){var _kxs = document.createElement('script');_kxs.id = 'kx_script';_kxs.async = true;_kxs.setAttribute('cid', 'kx_verify');_kxs.src = ('https:' == document.location.protocol ? 'https://ss.knet.cn' : 'http://rr.knet.cn')+'/static/js/icon3.js?sn=e17081145010068575j7sk000000&tp=icon3';_kxs.setAttribute('size', 0);var _kx = document.getElementById('kx_verify');_kx.parentNode.insertBefore(_kxs, _kx);})();</script>
</span>





	

		
	</div>
</div> 

<div style="display:none;">
<script language="javascript" type="text/javascript" src="///19260711.js"></script>
<noscript><a href="///?19260711" target="_blank"><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="//img.users.51.la/19260711.asp" style="border:none" /></a></noscript>
</div>

<!--<script language="javascript" src="http://api.pop800.com/800.js?n=269577&s=01&p=l&l=cn"></script><div style="display:none;"><a href="http://www.pop800.com">在线客服</a></div>-->
<script>
	$(function(){
		fixeds();//导航固定定位 2016-3-26
		
		//S 计算器弹窗
		$(window).resize(function() {
  			$(".c_calculatorCpmBox").css({left:($(window).width()-852)/2+"px",top:($(window).height()-444)/2+"px"});
  			$(".c_calculatorCpmBottom").css({height:$(window).height()+"px"});
		});
		$(window).resize();
		$(".c_calculatorCpmBox h1 img").click(function(){
			$(".c_calculatorCpmBox").hide();
			$(".c_calculatorCpmBottom").hide();
		})
		$(".c_calculatorbutton").click(function(){
			$(".c_calculatorCpmBox").show();
			$(".c_calculatorCpmBottom").show();
		});
		
		//S 导航固定定位 2016-3-26
	    function fixeds(){
	    	$(window).scroll(function(){
	           try{
	            if($(window).scrollTop()>$(".headerOut").offset().top){
	              $(".header").css({position:"fixed",top:0,left:0,zIndex:"999"}).addClass("headerIn");
	             }
	             else{
	              $(".header").css({position:"relative"}).removeClass("headerIn");
	             }
	            }
	          catch(e){}
	    	});
	    }
	    //E 导航固定定位 2016-3-26
		
	})
</script>

<style>

.g-toolbar{position:fixed;top:15%;right: 0px;margin-left:550px;padding-bottom:50px;z-index: 100;}
.g-toolbar .toolbar-item{position:relative;margin:0 0 10px 12px;width:70px;height:75px;background:#fb661e;border-radius:4px;cursor:pointer}
.g-toolbar .toolbar-item .item-tip-c{position:absolute;right:75px;text-align:center;color:#fff;overflow:hidden}
.g-toolbar .toolbar-item .item-tip-c .item-box{position:absolute;right:-112px;padding:17px;background:#E95625;border-radius:4px;-ms-transition:right .3s cubic-bezier(0.17,.67,.88,1);-moz-transition:right .3s cubic-bezier(0.17,.67,.88,1);-webkit-transition:right .3s cubic-bezier(0.17,.67,.88,1);transition:right .3s cubic-bezier(0.17,.67,.88,1)}
.g-toolbar .toolbar-item .item-tip-c.item-tip-kefu .item-box{padding:16px 0 16px 11px;line-height:14px; font-size:16px}
.g-toolbar .toolbar-item .item-tip-c.item-tip-back .item-box{padding:20px 0 16px 11px; font-size:16px}
.g-toolbar .toolbar-item:hover{background:#E95625;border-left:12px solid #d33737;margin:0 0 10px}
.g-toolbar .toolbar-item:hover .item-tip-c{width:145px;height:150px}
.g-toolbar .toolbar-item:hover .item-tip-c .item-box{right:0}
.g-toolbar a{display:block;width:60px;height:60px;}
/*.g-toolbar #back{display:none}*/
.u-spi{background:url(/images/bg.png) no-repeat;display:inline-block;width:32px;height:32px;margin:20px 0 0 20px}
.u-spi.u-025{background-position:-334px -360px}.u-spi.u-041{background-position:-366px -360px}
.u-spi.u-042{background-position:-401px -360px}.u-spi.u-043{background-position:-433px -360px}
.u-spi.u-045{background-position:-467px -358px}

</style>

<div class="g-toolbar">
    <ul class="g-toolbar-nav">
        <li class="toolbar-item">
       <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=800065147&amp;site=qq&amp;menu=yes" target="_blank">
           <div class="item-tip-c item-tip-kefu">
                <div class="item-box">
                   <div class="item-tip" style="height:28px; line-height:28px;font-size:16px">QQ客服</div>
                </div>
           </div>
        <u class="u-spi u-042"></u>
		  <p style="color:#fff;text-align:center">QQ客服</p>
        </a>
       </li>
	   
       <li class="toolbar-item">
	   <a href="http://p.qiao.baidu.com/cps/chat?siteId=11119464&userId=24422495" target="_blank">
          <div class="item-tip-c item-tip-app">
             <div class="item-box"><!--<p><img  alt="" src="/images/90.png" width="100" height="100"></p>--><div class="item-tip">在线客服</div></div>
          </div>
           <u class="u-spi u-043"></u>
		   <p style="color:#fff;text-align:center;padding-left: 8px;">在线客服</p>
		    </a>
			
       </li>

 <li class="toolbar-item">
          <div class="item-tip-c item-tip-app">
             <div class="item-box"><p><img alt="" src="/img/qr.png" width="100" height="100"></p><div class="item-tip">APP下载</div></div>
          </div>
          <u class="u-spi u-041"></u>
		  <p style="color:#fff;text-align:center">APP下载</p>
       </li>
	   
      
       
       <li id="back" class="toolbar-item" style="visibility: visible;">
             <div class="item-tip-c item-tip-back">
                 <div class="item-box"><div class="item-tip">返回顶部</div></div>
             </div>
             <u class="u-spi u-025"></u>
       </li>
    </ul>
</div>

<script type="text/javascript">
    $("#closebtn").click(function () {
        document.cookie = "isshow=";
        $("#xinhuancontent_scroll").hide();
    });
    $("#closebtn_").click(function () {
        document.cookie = "isshow=true";
        $("#xinhuancontent_scroll").hide();
        location.href = location.href;
    });
</script>


<script type="text/javascript">document.getElementById("menu1").className = " active";</script>

</body>
<script src="http://down.admin5.com/demo/code_pop/19/802/js/jquery.liMarquee.js"></script>
<script>
    $(window).on('load', function() {
        $('.str1').liMarquee();
        $('.str2').liMarquee({
            direction: 'right'
        });
        var stringEl = $('.str3').liMarquee();
        $('.speedChange').on('click', function () {
            var speedChange = $(this);
            var dataSpeed = speedChange.data('scrollamount');

            stringEl.trigger('mouseenter');
            stringEl.data({scrollamount: dataSpeed});
            stringEl.trigger('mouseleave');

            return false;
        });
        $('.str4').liMarquee({
            drag: false
        });
        $('.str5').liMarquee({
            hoverstop: false
        });
        $('.str6').liMarquee();
        $('.btnPause').on('click', function () {
            $('.str6').liMarquee('pause');
        });
        $('.btnPlay').on('click', function () {
            $('.str6').liMarquee('play');
        })
    });

</script>
<script type="text/javascript">
    $(function () {
        $(".hd").css('width', $(".hd li").length * ($(".hd li:first").width() + 10) + 'px');
        $(".f-slides ul").css('width', $(".slide-news ul li").length * $(".slide-news ul li:first").width() + 'px');
        jQuery(".trigger").slide({mainCell: ".bd ul", effect: "left", autoPlay: true});

        $(".data-right ul li").click(function (event) {
            $(this).addClass('on').siblings('li').removeClass('on');
            var ix = $(".data-right ul li").index(this);
            $(".d-r-bottom>div").eq(ix).show().siblings('div').hide();
            $(".d-r-top span").text($(this).attr("data-name"));
        });
        $(".step-f").mouseover(function (event) {
            $(this).addClass('overs');
        });
        $(".step-f").mouseout(function (event) {
            $(this).removeClass('overs');
        });
        $(".slide-top table").css('height', $(".slide-top table tr").length * $(".slide-top table tr:first").height() + 'px');
        var slideTop = function () {
            $(".data-left table").animate({
                    "top": -$(".slide-top table tr:first").height() + "px"
                },
                500, function () {
                    $(".slide-top table").css('top', '0');
                    $(".slide-top table").append($(".slide-top table tr:first").remove());
                });
        }
        var idtop = setInterval(slideTop, 2000);
        $(".slide-top table tr").on('mouseover', function (event) {
            event.preventDefault();
            clearInterval(idtop);
        });
        $(".slide-top table tr").on('mouseout', function (event) {
            event.preventDefault();
            clearInterval(idtop);
            idtop = setInterval(slideTop, 2000);
        });
        var slideLeft = function () {
            $(".f-slides ul").animate({
                    'left': -$(".slide-news ul li:first").width() + 'px'
                },
                500, function () {
                    $(".f-slides ul").css('left', '0');
                    $(".f-slides ul").append($(".f-slides ul li:first").remove());
                });
        }
        var id = setInterval(slideLeft, 4500);
        $(".f-slides ul li").on('mouseover', function (event) {
            clearInterval(id);
        });
        $(".f-slides ul li").on('mouseout', function (event) {
            clearInterval(id);
            id = setInterval(slideLeft, 4500);
        });
        $(".prev").click(function (event) {
            clearInterval(id);
            slideLeft();
            id = setInterval(slideLeft, 4500);
        });
        $(".next").click(function (event) {
            clearInterval(id);
            slideLeft();
            id = setInterval(slideLeft, 4500);
        });
    })
</script>
</html>