@extends('mobile.bluev3.wap')

@section("header")

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



    <div class="othertop">
        <a class="goback" href="javascript:history.back();"><img src="{{asset("mobile/bluev3/img/goback.png")}}" style="margin: 0px;"/></a>
        <div class="othertop-font">投资详情</div>
    </div>
    <div class="header-nbsp"></div>



    <div class="details_top">

            <img src="{{$productview->pic}}">

        <h1>{{\App\Formatting::Format($productview->title)}}</h1>
        <ul>
            <li>
                <div class="inner">
                    <p>
                        <span class="span2">项目规模</span>
                        <span class="span1">￥<i >{{$productview->xmgm}}</i>万元</span>
                    </p>
                    <p>
                        <span class="span2">每份分红</span>

                            <span class="span1"><i>@if($productview->hkfs == 4)
                                        {{\App\Product::Benefit($productview->id,$productview->qtje)}}
                                    @else
                                        {{ $productview->shijian*$productview->jyrsy*$productview->qtje/100 }}
                                    @endif</i>元起</span>

                    </p>
                    <p>
                        <span class="span2">投资周期</span>
                        <span class="span1"><i><?php echo $productview->shijian; ?></i><?php if ($productview->hkfs == 2) { ?> 小时<?php } else { ?>天<?php } ?></span>
                    </p>
                </div>
            </li>
            <li>分红方式：<?php if ($productview->hkfs == 0) { ?>
                按天付收益，到期还本
                <?php } elseif ($productview->hkfs == 1) { ?>
                到期还本,到期付息
                <?php }elseif ($productview->hkfs == 2) { ?>
                按小时付收益，到期还本
                <?php }elseif ($productview->hkfs == 3) { ?>
                按日付收益，到期还本 节假日照常收益
                <?php }elseif ($productview->hkfs == 4) { ?>
                每日复利,保本保息 
                
                <?php } elseif ($productview->hkfs == 5) { ?>
                每5天付一次收益，到期还本
                 <?php } elseif ($productview->hkfs == 10) { ?>
                每10天付一次收益，到期还本
                 <?php } elseif ($productview->hkfs == 30) { ?>
               每30天付一次收益，到期还本
                <?php } ?></li>
            <li>起投金额：<span style="color:red;">{{$productview->qtje}}</span>元</li>
            <li>担保机构：{{\App\Formatting::Format($productview->bljg)}}</li>
            <li>投资零风险：本息保障
                <div class="progressBox1" >
                    <div class="progress1" style="width:{{$productview->xmjd}}%;"></div>
                    <span class="progressNum1">{{$productview->xmjd}}%</span>
                </div>
            </li>
        </ul>
    </div>


    <div class="details_foot">
                <div class="tabs">
                    @if($productview->hkfs == 4)
                        <span class="on" style="width: 25%">投资详情</span>
                        <span class="" style="width: 25%">项目说明</span>
                        <span style="width: 25%">投资记录</span>
                        <span style="width: 25%">收益明细</span>
                    @else
                        <span class="on" style="width: 50%">投资详情</span>
                        <span class="" style="width: 50%">项目说明</span>
                        <!--<span style="width: 33%">投资记录</span>-->

                    @endif
                </div>
        <div class="explain_outer">
            <div class="data" style="display: block">
            <table class="table">
                <tr>
                    <td ><span>项目名称</span></td>
                    <td>{{\App\Formatting::Format($productview->title)}}</td>
                </tr>
                <tr>
                    <td>项目金额：</td>
                    <td><i>{{$productview->xmgm}}万</i>元人民币；</td>
                </tr>
                <tr>
                    <td>每天分红：</td>
                    <td><i>按每<?php if ($productview->hkfs == 2) { ?>时<?php } else { ?>日<?php } ?>{{ $productview->jyrsy }}%的收益（保本保息）</i></td>
                </tr>
                <tr>
                    <td>投资金额：</td>
                    <td><i>最低起投<?php echo $productview->qtje; ?>元</i>（限买{{$productview->futoucishu}}份）</td>
                </tr>
                <tr>
                    <td>项目期限：</td>
                    <td><i><?php echo $productview->shijian; ?>个</i>自然<?php if ($productview->hkfs == 2) { ?>时<?php } else { ?>日<?php } ?>；</td>
                </tr>
                <tr>
                    <td>收益计算：</td>
                    <td>
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
                    </td>
                </tr>
                <tr>
                    <td>还款方式：</td>
                    <td><?php if ($productview->hkfs == 0) { ?>
                        按天付收益，到期还本
                        <?php } elseif ($productview->hkfs == 1) { ?>
                        到期还本,到期付息
                        <?php }elseif ($productview->hkfs == 2) { ?>
                        按小时付收益，到期还本
                        <?php }elseif ($productview->hkfs == 3) { ?>
                        按日付收益，到期还本 节假日照常收益
                        <?php }elseif ($productview->hkfs == 4) { ?>
                        每日复利,保本保息
                        <?php } ?> 节假日照常收益；</td>
                </tr>
                <tr>
                    <td>结算时间：</td>
                    <td>当天15点前投资，当天15点系统自动计息结算收益（例如在15:00成功投资，则在下个自然日15:00收到分红），到期系统将当日分红和产品本金一起返还到您的会员账号中；</td>
                </tr>
                <tr>
                    <td>可投金额：</td>
                    <td>{{$productview->ketouinfo}}；</td>
                </tr>

                <tr>
                    <td>资金安全：</td>
                    <td>{{\Cache::get("supervise")}}对平台上的每一笔投资提供<i>100%本息保障</i>，平台设立风险备用金，对本金承诺全额垫付；</td>
                </tr>
                <tr>
                    <td>项目概述：</td>

                        <td><p>本项目筹集资金<?php echo $productview->xmgm; ?><span style="COLOR:" rgb(255,0,0)="">万元</span>人民币，投资本项目（按<?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?>付息收益为<font
                                        color="#ff0000">{{ $productview->jyrsy }}%/<?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?></font>）项目周期为<font
                                        color="#ff0000"><?php echo $productview->shijian; ?></font><?php if ($productview->hkfs == 2) { ?> 时<?php } else { ?>日<?php } ?>，所筹集资金用于该项目直投运作，作为投资者收益固定且无任何风险，所操作一切风险都由公司与担保公司一律承担，投资者不需要承担任何风险。
                            </p>
                        </td>

                </tr>

            </table>
            </div>
            <div class="data pageinfo">
                {!! \App\Formatting::Format($productview->content) !!}
            </div>
            <div class="data">
                <table class="table" style="text-align: center;">
                    <thead>
                    <tr>
                        <td width="35%">理财人</td>
                        <td width="25%">有效金额（元）</td>
                        <td width="15%">来源</td>

                        <td width="25%">投标时间</td>

                    </tr>
                    </thead>
                    <tbody >


                    @foreach(\App\Productbuy::GetBuyList($productview->id) as $buyk=>$buy)
                        <tr class="odd gradeX">

                            <td class="c_table_addcolor">
                                {{$buy['mobile']}}</td>
                            <td class="c_table_addcolor">{{$buy['amount']}}</td>
                            <td class="c_table_addcolor">
                                <img title="{{$buy['title']}}" src="{{$buy['RegFrom']}}" style="width: 20px;height: 20px;"> </td>
                            <td class="c_table_addcolor">{{$buy['DateTimeM']}}</td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
            @if($productview->hkfs == 4)
            <div class="data">




                                <table  style="text-align: center;width: 100%">
                                    <tbody>
                                    <tr>
                                        <td>收款日期</td>
                                        <td>收款金额</td>
                                        <td>收回本金</td>
                                        <td>收回利息</td>
                                        <td>剩余本金</td>
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

    <script>
        $().ready(function(){

            $(".tabs span").click(function(){
                $(".tabs span").removeClass("on");
                $(this).addClass("on");
                var index=$(this).index();
                $(".explain_outer .data").hide();
                $(".explain_outer .data").eq(index).show();
            });

/*            $(".tabs span:eq(0)").click(function(){
                $(this).addClass("on");
                $(".tabs span:eq(1)").removeClass("on");
                $(".explain_outer .table").show();
                $(".explain_outer .data").hide();
            });

            $(".tabs span:eq(1)").click(function(){
                $(this).addClass("on");
                $(".tabs span:eq(0)").removeClass("on");
                $(".explain_outer .table").hide();
                $(".explain_outer .data").show();
            });*/


        });
    </script>
    <div class="header-nbsp"></div>

    <div class="invest_btn">


        @if(isset($Member))

            @if($productview->tzzt==1)
                <a href="javascript:void(0)" class="finishReg invBtn startTb" style="background-color: #888;">投资已满额</a>
            @elseif($productview->tzzt==-1)
                <a href="javascript:void(0)" class="finishReg invBtn startTb" style="background-color: #888;">投资待开放</a>

            @else
                <a href="{{route("product.buy",["id"=>$productview->id])}}" class="finishReg invBtn startTb">马上投资</a>
            @endif


        @else
            <div class="max detailBtn"><a href="{{route("wap.login")}}" class="finishReg invBtn startTb">请先登录</a></div>
        @endif


    </div>

    <!----旧模板--->




















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

@endsection

