@extends('mobile.default.wap')

@section("header")

   {{-- @parent
    <div class="top" id="top">
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
    </div>--}}

@endsection

@section("js")
    <script type="text/javascript" src="{{asset("mobile/public/Front/js/jquery-1.7.2.min.js")}}"></script>
{{--    @parent
    <script type="text/javascript" src="{{asset("mobile/public/Front/js/json-eps.js")}}"></script>
    <script type="text/javascript" charset="utf-8"
            src="{{asset("mobile/public/Front/user/user.js").'?t='.time()}}"></script>
    <script type="text/javascript" src="{{asset("mobile/public/Front/js/jquery-1.7.2.min.js")}}"></script>
    <script src="{{asset("mobile/public/layer_mobile/layer.js")}}"></script>--}}
@endsection

@section("css")

   {{-- @parent--}}





@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')

    <link rel="stylesheet" href="{{asset("wap/cp/css/common.css")}}" type="text/css">
    <link rel="stylesheet" href="{{asset("wap/cp/css/detail_novice.css")}}" type="text/css">
    <link rel="stylesheet" href="{{asset("wap/cp/css/jquery.mCustomScrollbar.css")}}" type="text/css">
    <link rel="stylesheet" href="{{asset("wap/cp/css/c_main.min.css")}}" type="text/css">
    <link rel="stylesheet" href="{{asset("wap/cp/css/comm.min.css")}}" type="text/css">
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
            var str = '倒计时:'+tow(day) + '<span class="time">天</span>'
                + tow(hour) + '<span class="time">小时</span>'
                + tow(minute) + '<span class="time">分钟</span>'
                + tow(second) + '<span class="time">秒</span>';
            $("#djs"+Obj).html(str);

            setTimeout("getDate('"+timer+"','"+Obj+"')", 1000);
        }

    </script>


    <div class="wapy">
        <div class="wrap novice_box">

             <div class="header">
                 <h1>项目详情</h1>
                 <div>
                     <div class="sign_in">
                         <div>

                             <div>
                                 <a href="javascript:history.go(-1);" class="goback"></a>
                             </div>
                         </div>
                     </div>

                     <a class="list_btn" id="list_btn1"></a>
                 </div>

                 </div>
             <div>
                 <div class="list_item" id="menu">
                     <div class="item_btn">
                         <a id="list_btn2"></a>   </div>
                     <ul>
                         <li class="li1"><a href="/">首页</a></li>
                         <li class="li2"><a href="{{route("user.index")}}">会员中心</a></li>

                         <li class="li4"><a href="{{route("singlepage.links",["links"=>"about"])}}">关于我们</a></li>
                         <li class="li3"><a href="{{route("products")}}">我要投资</a></li>

                          </ul>
                 </div>
             </div>



            <div class="bg hide" id="bg2"></div>
           <div class="placeholder"></div>



            <div class="product_banner " style="{!! Cache::get('ProductBackgroundA') !!}">

                <p class="title_text"><img src="{{asset("wap/cp/images/baox3.png")}}">&nbsp;{{\App\Formatting::Format($productview->title)}}</p>

                <strong class="cash" ><i style="font-size: 60px;">{{$productview->jyrsy*$productview->qtje/100}}</i><span>元</span></strong>
                <p class="tip_text"></p><i class="tip">
                    @if(Cache::get('ShouYiRate')=='年')
                        年化收益
                    @else
                        <?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?>化收益
                    @endif
                </i>

                <div class="progress_bar">
         <span class="progressBar">
             <em class="bar" style="width: <?php echo $productview->xmjd; ?>%;"></em>
            </span>
                    <h5><font color="#FFFFFF">项目进度<i class="percent"><?php echo $productview->xmjd; ?>%</i></font></h5>
                    <h5><font color="#FFFFFF">最高可投金额 {{($productview->xmgm-$productview->xmgm*$productview->xmjd/100)*10000}}元</font></h5>
                </div>
                <br>
                <ul class="list" style="{!! Cache::get('ProductBackgroundB') !!}">
                    <li class="li1">
                        <strong><?php echo $productview->shijian; ?><?php if ($productview->hkfs == 2) { ?> 小时<?php } else { ?>天<?php } ?></strong>
                        <p>期限</p>
                    </li>
                    <li class="li2">
                        <strong><?php echo $productview->qtje; ?>元</strong>
                        <p>起购金额</p>
                    </li>
                    <li class="li3">
                        <strong><?php echo $productview->xmgm; ?>万元</strong>
                        <p>项目规模</p>
                    </li>
                </ul>
            </div>

            <div class="line"></div>


            <div class="details">
                <div>
                    <table>


                        <tbody>



                        <?php if($productview->tzzt == -1){?>

                        <?php if($productview->countdownad!=''){?>


                        <tr >
                            <td class="detail_name" >倒计时标签</td>
                            <td><p>
                                    <font color="#FF6600">
                                        <?php echo  $productview->countdownad;?>
                                    </font>
                                </p>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>

                        <?php if($productview->countdown!=''){?>


                        <tr class="gray">
                            <td class="detail_name" >倒计时</td>
                            <td><p>
                                    <font color="#FF6600" id="djs{{$productview->id}}">
                                        <?php echo  $productview->countdown;?>
                                    </font>
                                    <script>getDate("{{$productview->countdown}}","{{$productview->id}}");</script>
                                </p>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>




                        <?php } ?>




                        <tr>
                            <td class="detail_name" >还款方式</td>
                            <td><p><font color="#FF6600"><?php if ($productview->hkfs == 0) { ?>
                                        按天付收益，到期返本
                                        <?php } elseif ($productview->hkfs == 1) { ?>
                                        到期还本,到期付息
                                        <?php }elseif ($productview->hkfs == 2) { ?>
                                        按小时付收益，到期返本
                                        <?php }elseif ($productview->hkfs == 3) { ?>
                                        按日付收益，按日平均还本(等额本息)
                                        <?php }elseif ($productview->hkfs == 4) { ?>
                                        每日复利,保本保息
                                        <?php } ?></font></p></td>
                        </tr>
						
						<tr  class="gray">
							<td class="detail_name">项目标签</td>
							<td>
								<p><font color="#FF6600">
								@if($productview->wzone){{$productview->wzone}}<br/>@endif
								@if($productview->wztwo){{$productview->wztwo}}<br/>@endif
								@if($productview->wzthree){{$productview->wzthree}}@endif
							
								</font></p>
							</td>
						</tr>
						
                        <tr>
                            <td class="detail_name">担保机构</td>
                            <td><p><font color="#FF6600"><?php echo $productview->bljg; ?></font></p></td>
                        </tr>
                        <tr class="gray">
                            <td class="detail_name">安全保障</td>
                            <td>
                                <p>
                                    <img src="{{asset("wap/cp/images/baox.png")}}" width="35">&nbsp;
                                    <img src="{{asset("wap/cp/images/baox1.png")}}" width="35">&nbsp;
                                    <img src="{{asset("wap/cp/images/baox2.png")}}" width="35">&nbsp;
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <ul class="introduce_list flex">
                <li class="flex-1">
                    <img src="{{asset("wap/cp/images/int_ico01.png")}}">
                    <p class="p01">安全保障</p>
                    <p class="p02">100% 本息保障</p>
                </li>
                <li class="flex-1">
                    <img src="{{asset("wap/cp/images/int_ico02.png")}}">
                    <p class="p01">第三方担保</p>
                    <p class="p02">专业的风控团队</p>
                </li>
                <li class="flex-1">
                    <img src="{{asset("wap/cp/images/int_ico03.png")}}">
                    <p class="p01">收益更高</p>
                    <p class="p02">0.5%-5.6%</p>
                </li>
            </ul>
            <div class="line"></div>
            <div class="tab" id="tab">
                <div class="hd">
                    <ul class="tab_btn flex">
                        <li class="btns on flex-1">产品详情<i></i></li>
                        <li class="btns flex-1">购买记录<span></span><i></i></li>
                        <li class="btns flex-1">收益明细<span></span><i></i></li>
                    </ul>
                </div>
                <div class="bd">
                    <div class="tab_box">
                        <div class="detail_box boxs">
                            <div class="details">
                                <div class="detail_con" id="detail_con">
                                    <table style="width: 100%">
                                        <tbody>
                                        <tr>
                                            <td class="detail_name" width="100">投资项目</td>
                                            <td ><p>{{\App\Formatting::Format($productview->title)}}</p></td>
                                        </tr>
                                        <tr class="gray">
                                            <td class="detail_name">项目金额</td>
                                            <td><p><font color="#ff0000"><?php echo $productview->xmgm; ?></font>万元人民币；</p></td>
                                        </tr>
                                        <tr>
                                            <td class="detail_name">日收益率</td>
                                            <td><p><font color="#ff0000">{{ $productview->jyrsy }}%</font>@if(Cache::get('ShouYiRate')=='年')
                                                        年化收益
                                                    @else
                                                        <?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?>化收益
                                                    @endif；</p></td>
                                        </tr>
                                        <tr class="gray">
                                            <td class="detail_name">起投金额</td>
                                            <td><p><font color="#FF0000"><?php echo $productview->qtje; ?>元</font>起投；
                                                </p></td>
                                        </tr>
                                        <tr>
                                            <td class="detail_name">项目期限</td>
                                            <td><p><font color="#ff0000"><?php echo $productview->shijian; ?></font><?php if ($productview->hkfs == 2) { ?> 小时<?php } else { ?>天<?php } ?>；</p></td>
                                        </tr>
                                        <tr class="gray">
                                            <td class="detail_name">收益计算</td>
                                            <td><p><font color="#ff0000"><?php echo $productview->qtje; ?>元</font>*<font
                                                            color="#ff0000">{{ $productview->jyrsy }}%</font>*<font
                                                            color="#ff0000"><?php echo $productview->shijian; ?><?php if ($productview->hkfs == 2) { ?> 小时<?php } else { ?>天<?php } ?></font>=总收益<font
                                                            color="#ff0000"> @if($productview->hkfs == 4)
                                                            {{\App\Product::Benefit($productview->id,$productview->qtje)}}
                                                        @else
                                                            {{ $productview->shijian*$productview->jyrsy*$productview->qtje/100 }}
                                                        @endif 元</font>+本金<font
                                                            color="#ff0000"><?php echo $productview->qtje; ?>元</font>=总计本息<font color="#ff0000">
                                                        @if($productview->hkfs == 4)
                                                            {{\App\Product::Benefit($productview->id,$productview->qtje)+$productview->qtje}}
                                                        @else
                                                            {{ $productview->shijian*$productview->jyrsy*$productview->qtje/100+$productview->qtje }}
                                                        @endif

                                                        元</font>；
                                                </p></td>
                                        </tr>
                                        <tr>
                                            <td class="detail_name">还款方式</td>
                                            <td><p><?php if ($productview->hkfs == 0) { ?>
                                                    按天付收益，到期还本
                                                    <?php } elseif ($productview->hkfs == 1) { ?>
                                                    到期还本,到期付息
                                                    <?php }elseif ($productview->hkfs == 2) { ?>
                                                    按小时付收益，到期还本
                                                    <?php }elseif ($productview->hkfs == 3) { ?>
                                                    按日付收益，到期还本 节假日照常收益
                                                    <?php }elseif ($productview->hkfs == 4) { ?>
                                                    每日复利,保本保息
                                                    <?php } ?>；</p></td>
                                        </tr>
                                        <tr class="gray">
                                            <td class="detail_name">结算时间</td>
                                            <td><p>当天投资，当天计息，隔日17:30自动结算收益《例如在今天任意时间段成功投资，则在明天下午17:30收到收益》系统将当日收益和产品本金一起返还到您的会员账号中；
                                                </p></td>
                                        </tr>
                                        <tr>
                                            <td class="detail_name">可投金额</td>
                                            <td><p>{{$productview->ketouinfo}}</p></td>
                                        </tr>
                                        <tr class="gray">
                                            <td class="detail_name">资金用途</td>
                                            <td><p>每位投资者的投资资金，由公司进行统一操盘运作买卖{{\App\Formatting::Format($productview->title)}}项目</p></td>
                                        </tr>
                                        <tr>
                                            <td class="detail_name">安全保障</td>
                                            <td><p>担保机构对平台上的每一笔投资提供<font color="#ff0000">100%</font>本息保障，平台设立风险备用金，对本息承诺全额垫付；
                                                </p></td>
                                        </tr>
                                        <tr class="gray">
                                            <td class="detail_name">项目概述</td>
                                            <td><p>本项目筹集资金<?php echo $productview->xmgm; ?><span style="COLOR:" rgb(255,0,0)="">万元</span>人民币，投资本项目（按日付息收益为<font
                                                            color="#ff0000">{{ $productview->jyrsy }}%/<?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?></font>）项目周期为<font
                                                            color="#ff0000"><?php echo $productview->shijian; ?></font><?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?>，所筹集资金用于该项目直投运作，作为投资者收益固定且无任何风险，所操作一切风险都由公司与担保公司一律承担，投资者不需要承担任何风险。
                                                </p></td>
                                        </tr>
                                        
                                        <tr class="gray">
                                            <td class="detail_name" >项目说明</td>
                                            <td class="" ></td>

                                        </tr>

                                        <tr class="gray">

                                            <td colspan="2" class="pageinfo">

                                                    {!! \App\Formatting::Format($productview->content) !!}

                                            </td>
                                        </tr>
                                        
                                        </tbody>
                                    </table>

                                </div>
                                <script>

                                    $(function(){
                                        var $cunt = $(".pageinfo img").each(function(i){
                                            $(this).css("width", '100%');

                                        });
                                    });

                                </script>
                                <style>

                                    .pageinfo {
                                        width: 100%;
                                        font-size:12px;
                                        font-size:5vw;
                                    }
                                    .pageinfo p{

                                        font-size:5vw;
                                    }
                                    .pageinfo img {width: 100%;margin: 0 auto;}
                                    .pageinfo ul {width: 100%;margin: 0 auto;}
                                    .pageinfo h1 {width: 100%;margin: 0 auto;font-size:5vw;}
                                    .pageinfo h3 {width: 100%;margin: 0 auto;font-size:4vw;}
                                </style>
                                <div class="more" id="moreBtn1"></div>
                            </div>
                            <div class="line"></div>

                            <div class="profit_box">
                                <img src="{{asset("wap/cp/images/profit.png")}}">
                            </div>
                            <div class="line"></div>


                        </div>
                        <div class="record_box boxs hide">
                            <div style="float: left; width: 205px; line-height: 20px; font-size: 13px !important; display: none;"
                                 id="loading"></div>



                            <table class="datatable table table-striped table-bordered table-hover " style="text-align: center;">
                                <thead>
                                <tr>
                                    <th width="35%">理财人</th>
                                    <th width="25%">有效金额（元）</th>
                                    <th width="15%">来源</th>
                                    <th width="25%">投标时间</th>
                                </tr>
                                </thead>
                                <tbody >


                                @foreach(\App\Productbuy::GetBuyList($productview->id) as $buyk=>$buy)
                                    <tr class="odd gradeX">

                                        <td class="c_table_addcolor">
                                            {{$buy['mobile']}}</td>
                                        <td class="c_table_addcolor">{{$buy['amount']}}</td>
                                        <td class="c_table_addcolor">
                                            <img title="{{$buy['title']}}" src="{{$buy['RegFrom']}}"> </td>
                                        <td class="c_table_addcolor">{{$buy['DateTimeM']}}</td>
                                    </tr>
                                @endforeach





                                </tbody>
                            </table>






                        </div>




                        @if($productview->hkfs == 4)
                            <div class="record_box boxs hide">
                                <div style="float: left; width: 205px; line-height: 20px; font-size: 13px !important; "
                                     id="loading"></div>



                                <table style="width: 100%;padding: 5px; border: 1px #C8C8C8 solid;text-align: center;" border="1">
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
                                        <tr class="gray">
                                            <td class="detail_name">第{{$buyk+1}}天</td>
                                            <td class="detail_name">
                                                {{$buy['Benefit']}}</td>
                                            <td class="detail_name">{{$buy['HMoneys']}}</td>
                                            <td class="detail_name">
                                                {{$buy['Benefit']}} </td>
                                            <td class="detail_name">{{$buy['Moneys']}}</td>
                                        </tr>
                                    @endforeach


                                    <tr class="gray">
                                        <td class="c_table_addcolor">总结</td>
                                        <td class="c_table_addcolor">
                                            {{$BenefitData['HMoneys']}}</td>
                                        <td class="c_table_addcolor">{{$BenefitData['Moneys']}}</td>
                                        <td class="c_table_addcolor">
                                            {{$BenefitData['Benefits']}} </td>
                                        <td class="c_table_addcolor"></td>
                                    </tr>

                                    <tr class="gray" style="text-align: left;">
                                        <td colspan="5">
                                            &nbsp;&nbsp;&nbsp;&nbsp;实际总收益：￥{{$BenefitData['HMoneys']}}元
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>




                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="top_bar"></div>


        </div>
    </div>

    <?php if(isset($Member)){ ?>



    @if($productview->tzzt==1)

        <a href="javascript:void(0) " class="btn novice_btn">投资已满额</a>
    @elseif($productview->tzzt==-1)


        <a href="javascript:void(0)" class="btn novice_btn">投资待开放</a>

    @else
        <a href="{{route("product.buy",["id"=>$productview->id])}}" class="btn novice_btn">立即购买</a>
    @endif





    <?php }else{ ?>

    <a href="{{route("wap.register")}}" class="gift_tip"><span>新手注册即送 {{\Cache::get('XiaXianReg')}} 现金</span></a>

    <a href="{{route("wap.login")}}" class="btn novice_btn">登录后再投资</a>

    <?php } ?>




    <script type="text/javascript" src="{{asset("wap/cp/js/index_wap_comment.js")}}"></script>
    <script type="text/javascript" src="{{asset("wap/cp/js/jquery-1.8.3.min.js")}}"></script>
  <script type="text/javascript" src="{{asset("wap/cp/js/public_function.js")}}"></script>
    <script type="text/javascript" src="{{asset("wap/cp/js/public_class.js")}}"></script>
       <script type="text/javascript" src="{{asset("wap/cp/js/top.js")}}"></script>
     <script type="text/javascript" src="{{asset("wap/cp/js/jquery.mCustomScrollbar.concat.min.js")}}"></script>
  {{--  <script type="text/javascript" src="{{asset("wap/cp/js/common.js")}}"></script>--}}
    <script type="text/javascript" src="{{asset("wap/cp/js/detail_insured.js")}}"></script>




@endsection


@section("footcategory")
    {{--@parent--}}


@endsection

@section("footbox")
    {{--@parent--}}


@endsection

@section("footer")
   {{-- @parent--}}
@endsection

