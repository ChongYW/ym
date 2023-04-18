@extends('mobile.film.wap')

@section("header")
    <header>
        <a href="javascript:history.go(-1);"><img src="{{asset("mobile/film/images/back.png")}}" class="left backImg"></a>
        <span class="headerTitle">我要投资</span>
        <a href="{{route("user.index")}}" class="headerRight"><img src="{{asset("mobile/film/images/touxiang.png")}}" height="33" style="float:right;vertical-align: middle; margin-top:5px; padding-left:5px;"></a>
    </header>
@endsection

@section("js")
    @parent

@endsection

@section("css")

    @parent


@endsection

@section("onlinemsg")
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
            var str = '倒计时:'+tow(day) + '<span class="time">天</span>'
                + tow(hour) + '<span class="time">小时</span>'
                + tow(minute) + '<span class="time">分钟</span>'
                + tow(second) + '<span class="time">秒</span>';
            $("#djs"+Obj).html(str);

            setTimeout("getDate('"+timer+"','"+Obj+"')", 1000);
        }

    </script>

    <div class="investTop">
        <div class="investImg">

            <?php $productview->tagcolor!=''?$tagcolor=$productview->tagcolor:$tagcolor='background-color:#FF6A78;color:#F5F2F2;'?>
            <?php if($productview->wzone){
                echo '<div style="position:absolute;z-index:101;margin-top:5px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;'.$tagcolor.'">'.$productview->wzone.'</div>';
            }?>

            <?php if($productview->wztwo){
                echo '<div style="position:absolute;z-index:101;margin-top:30px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;'.$tagcolor.'">'.$productview->wztwo.'</div>';
            }?>

            <?php if($productview->wzthree){
                echo '<div style="position:absolute;z-index:101;margin-top:55px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;'.$tagcolor.'">'.$productview->wzthree.'</div>';
            }?>


            <?php if($productview->tzzt == -1){?>

                                    <?php if($productview->countdownad!=''){
                echo '<div style="position:absolute;z-index:101;margin-top:125px;text-align:center; border-radius: 5px;width: 75%; margin-left:10%;'.$tagcolor.'">'.$productview->countdownad.'</div>';
            }?>


                                    <?php if($productview->countdown!=''){
                echo '<div style="position:absolute;z-index:101;margin-top:155px;text-align:center; border-radius: 5px;width: 75%; margin-left:10%;'.$tagcolor.'" id="djs'.$productview->id.'"></div><script>getDate("'.$productview->countdown.'","'.$productview->id.'");</script>';
            }?>

                                    <?php } ?>

            <img src="{{$productview->pic}}" style="width:100%">
        </div>
        <div class="investName">{{\App\Formatting::Format($productview->title)}}</div>
        <div class="line">

<!--            <div class="cooperate">
                还款方式：<?php if ($productview->hkfs == 0) { ?>
                按天付收益，到期还本
                <?php } elseif ($productview->hkfs == 1) { ?>
                按周期付收益，到期还本
                <?php }elseif ($productview->hkfs == 2) { ?>
                按小时付收益，到期还本
                <?php }elseif ($productview->hkfs == 3) { ?>
                按日付收益，按日平均还本(等额本息)
                <?php }elseif ($productview->hkfs == 4) { ?>
                每日复利,保本保息
                <?php } ?></div>
            <div class="cooperate">
                担保机构：<?php echo $productview->bljg; ?></div>
-->

            <div class="clear"></div>投资进度:&nbsp;&nbsp;<span class="color"><?php echo $productview->xmjd; ?>%</span><div class="progress"><span class="progressBar" style="width:<?php echo $productview->xmjd; ?>%;"></span></div><div class="clear"></div>
<style>

    .investTop .detailBlock .detailLeft{
        width: 50%;
        border: 1px #CCA66A solid;

        padding: 5px;


    }





</style>

            <ul class="detailBlock">

                <li class="detailList detailLeft">
                    <ul>
                        <li class="textlab">项目状态</li>
                        <li class="num"><em>
                                @if($productview->tzzt==1)
                                    已满额
                                @elseif($productview->tzzt==-1)
                                    待开放
                                @else
                                    进行中
                                @endif
                            </em></li>
                    </ul>
                </li>

                <li class="detailList detailLeft">
                    <ul>
                        <li class="textlab">能否复投</li>
                        <li class="num"><em><?php if ($productview->isft == 0) {
                                echo  '不能复投';
                            } elseif ($productview->isft == 1) {
                                echo  '可以复投';
                            } ?></em>
                               </li>
                    </ul>
                </li>

                <li class="detailList detailLeft">
                    <ul>
                        <li class="textlab">项目规模</li>
                        <li class="num"><em>¥</em>{{$productview->xmgm}}<em>万元</em></li>
                    </ul>
                </li>
                <li class="detailList detailLeft">
                    <ul>
                        <li class="textlab">起投金额</li>
                        <li class="num"><em>¥</em>{{$productview->qtje}}<em>元</em></li>
                    </ul>
                </li>

                <li class="detailList detailLeft">
                    <ul>
                        <li class="textlab">项目期限 </li>
                        <li class="num"><?php echo $productview->shijian; ?><em><?php if ($productview->hkfs == 2) { ?> 小时<?php } else { ?>个自然日<?php } ?></em></li>
                    </ul>
                </li>

                <li class="detailList detailLeft">
                    <ul>
                        <li class="textlab">
                            @if($productview->hkfs == 4)
                                总收益
                            @else
                                <?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?>化收益
                            @endif
                        </li>
                        <li class="num">

                            @if($productview->hkfs == 4)
                                {{\App\Product::Benefit($productview->id,$productview->qtje)}}
                            @else
                                {{ $productview->shijian*$productview->jyrsy*$productview->qtje/100 }}
                            @endif
                            <em>元</em></li>
                    </ul>
                </li>


            </ul>

        </div>
    </div>


    <div class="investTop">
        <div class="instru">投资记录</div>
        <div class="line">
            <div class="baseInfo ">
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
                                <img title="{{$buy['title']}}" src="{{$buy['RegFrom']}}" style="width: 20px;"> </td>
                            <td class="c_table_addcolor">{{$buy['DateTimeM']}}</td>
                        </tr>
                    @endforeach





                    </tbody>
                </table>


            </div>
        </div>
    </div>




    <div class="investTop">
        <div class="instru">项目规则</div>
        <div class="line">
            <div class="baseInfo baseInfo2">

    <table style="width: 100%;padding: 5px; border: 1px #C8C8C8 solid;">
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
            <td><p>本项目筹集资金<?php echo $productview->xmgm; ?><span style="COLOR:" rgb(255,0,0)="">万元</span>人民币，投资本项目（按<?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?>付息收益为<font
                            color="#ff0000">{{ $productview->jyrsy }}%/<?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?></font>）项目周期为<font
                            color="#ff0000"><?php echo $productview->shijian; ?></font><?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?>，所筹集资金用于该项目直投运作，作为投资者收益固定且无任何风险，所操作一切风险都由公司与担保公司一律承担，投资者不需要承担任何风险。
                </p></td>
        </tr>




        </tbody>
    </table>

            </div>
        </div>
    </div>

    <div class="investTop">
        <div class="instru">项目详情</div>
        <div class="line">
            <div class="baseInfo pageinfo" style="margin-bottom: 50px;display:block;">
                <p>
                {!! \App\Formatting::Format($productview->content) !!}
                </p>


            </div>
        </div>
    </div>



    @if($productview->hkfs == 4)

        <div class="investTop" style="margin-bottom: 50px;display: block;">
            <div class="instru">收益明细</div>
            <div class="line">
                <div class="baseInfo ">



                    <table style="width: 100%;padding: 5px; border: 1px #C8C8C8 solid;text-align: center;">
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
            </div>
        </div>


    @endif

    <!--

    <div class="investTop">
        <div class="instru">项目规则</div>
        <div class="line">
            <div class="baseInfo">




                <li>项目金额：<em>¥</em><?php echo $productview->xmgm; ?><em>万元</em>人民币</li>
                <li>还款方式：<em> <?php if ($productview->hkfs == 0) { ?>
                        按天付收益，到期还本
                        <?php } elseif ($productview->hkfs == 1) { ?>
                        按周期付收益，到期还本
                        <?php }elseif ($productview->hkfs == 2) { ?>
                        按小时付收益，到期还本
                        <?php }elseif ($productview->hkfs == 3) { ?>
                        按日付收益，按日平均还本(等额本息)
                        <?php }elseif ($productview->hkfs == 4) { ?>
                        每日复利,保本保息
                        <?php } ?></em>（节假日照常收益）</li>
                <li>起投金额：<em><?php echo $productview->qtje; ?></em>元</li>
                <li>每<?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?>释放：<em>
                    @if($productview->hkfs == 4)
                    {{\App\Product::Benefit($productview->id,$productview->qtje)+$productview->qtje}}
                    @else
                    {{ $productview->shijian*$productview->jyrsy*$productview->qtje/100+$productview->qtje }}
                    @endif
                    </em>元</li>
                <li>释放周期：<em><?php echo $productview->shijian; ?>&nbsp;<?php if ($productview->hkfs == 2) { ?> 个小时<?php } else { ?>个自然日<?php } ?></em>，满<b class="blue"><?php if ($productview->hkfs == 2) { ?> <?php echo $productview->shijian; ?>个小时<?php } else { ?>24小时<?php } ?>  </b>自动结息</li>
                {{--<li>会员加息：<em>+0%</em></li>--}}
                <li>预计收益：
                    <p><font color="#ff0000"><?php echo $productview->qtje; ?>元</font>*<font
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
                        </p>
                </li>

                <li>能否复投：<?php if ($productview->isft == 0) {
                        echo  '不能复投';
                    } elseif ($productview->isft == 1) {
                        echo  '可以复投';
                    } ?></li>



            </div>

        </div>
    </div>


-->

    <script>

        $(function(){
            var $cunt = $(".pageinfo img").each(function(i){
                $(this).css("width", '100%');

            });
        });

    </script>
    <style>

        .baseInfo2 table{
            border: 1px #C8C8C8 solid;

        }

        .baseInfo2 table tr{
            border: 1px #C8C8C8 solid;
            line-height: 20px;
        }

        .baseInfo2 table td{
            border: 1px #C8C8C8 solid;
            line-height: 20px;
            padding: 5px;
        }
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


@endsection


@section('footcategory')

@endsection

@section("footer")
    @if(isset($Member))

        @if($productview->tzzt==1)
            <div class="max detailBtn"><a href="javascript:void(0)" class="finishReg invBtn startTb">投资已满额</a></div>
        @elseif($productview->tzzt==-1)
            <div class="max detailBtn"><a href="javascript:void(0)" class="finishReg invBtn startTb">投资待开放</a></div>

        @else
            <div class="max detailBtn"><a href="{{route("product.buy",["id"=>$productview->id])}}" class="finishReg invBtn startTb">马上投资</a></div>
        @endif


    @else
        <div class="max detailBtn"><a href="{{route("wap.login")}}" class="finishReg invBtn startTb">请先登录</a></div>
    @endif
@endsection

