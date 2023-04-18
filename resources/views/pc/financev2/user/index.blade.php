@extends('pc.financev2.pc')

@section("header")
    @parent

@endsection

@section("js")

    @parent

@endsection

@section("css")

    @parent
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/user/user.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/user/member.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/user/public.css")}}"/>

@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')




    <div class="w1200">
        <div class="cur_pos"><a href="/"> 首页</a> &gt; <a href="{{route('user.index')}}" target="_blank">会员中心</a></div>
        <div class="noticewrapbg" style=" background-color:#FFF">
            <div class="notice">
                <div class="title" style="margin-left:10px;"><a href="#">最新公告</a></div>
                <div class="marquee" style="line-height:24px; font-size:14px; width:1000px;padding-top: 10px;">
                    <ul style="margin-top: 0px;">
                        <marquee scrolldelay="200" onmouseout="this.start()" onmouseover="this.stop()"><strong
                                    style="color: rgb(0, 0, 255); font-family: 'Microsoft YaHei', tahoma, arial, sans-serif; font-size: 18px; line-height: 27px;"> {{Cache::get('gg')}} </strong>
                        </marquee>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="wrapper">


                <div class="clearfix">


                    @include('pc.finance.user.userleft')





                    <?php

                    //总投资额
                    $buyamounts=  \App\Productbuy::where("userid",$Member->id)->sum("amount");

                    //已投项目
                    $buycounts=  \App\Productbuy::where("userid",$Member->id)->count();






                    //投资收益
                    $moneylog_moneys=  \App\Moneylog::where("moneylog_userid",$Member->id)->where("moneylog_type","项目分红")->sum("moneylog_money");

                    //结束项目
                    $buyjscounts=  \App\Productbuy::where("userid",$Member->id)->where("status","0")->count();

                    $xiaxians=  count(\App\Member::treeuid($Member->invicode));

                    //本金回收
                    $buyjsamounts=  \App\Productbuy::where("userid",$Member->id)->where("status","1")->sum("amount");

                    $withdrawals= \App\Memberwithdrawal::where("userid",$Member->id)->sum("amount");
                    $withdrawals0= \App\Memberwithdrawal::where("userid",$Member->id)->where("status","0")->sum("amount");
                    $withdrawals1= \App\Memberwithdrawal::where("userid",$Member->id)->where("status","1")->sum("amount");
                    $recharges= \App\Memberrecharge::where("userid",$Member->id)->where("status","0")->sum("amount");

                    ?>

                    <div class="bfc">
                        <div class="user-top white-bg">
                            <h2>我的账户</h2>
                            <div class="user-info clearfix">
                                <div class="head-pic fl imgshow">
                                    <img src="{{$Member->picImg}}" alt="" id="thumb_url" width="100">

                                </div>
                                <div class="user-btn fr clearfix">
                                    <a href="{{route('user.recharge')}}" class="btn btn2 orange-btn fl">充 值</a>
                                    <a href="{{route('user.withdraw')}}" class="btn btn2 green-btn fl">提 现</a></div>
                                <div class="bfc">
                                    <div class="user-xx clearfix">
                                        <strong>{{\App\Member::GetPhoneTag($Member->id)}}</strong>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <font>您的理财等级为：
                                            <b style="color:#F00"><?php echo $memberlevelName[$Member->level]; ?></b>
                                             </font>
                                    </div>

                                    <dl class="user-ye clearfix">
                                        <dd class="clearfix">
                                            <span class="fl">安全等级：</span>
                                            <div class="bar fl clearfix">
                                                <div class="progress fl">
                                                    <?php
                                                    $useranquan=10;
                                                    if($Member->mobile!=''){
                                                        $useranquan+=50;
                                                    }
                                                    if($Member->card!=''){
                                                        $useranquan+=20;
                                                    }
                                                    if($Member->bankcode!=''){
                                                        $useranquan+=20;
                                                    }
                                                    ?>
                                                    <div class="progress-bar" style="width:{{$useranquan}}%;"></div>
                                                </div>
                                            </div>
                                        </dd>
                                        <dd>账户总额：<span class="red">￥<?php echo round($Member->amount+$Member->yuamount+$Member->is_dongjie,2); ?></span></dd>
                                        <dd><p>提现金额：<span class="red">￥<?php echo sprintf("%.2f",$withdrawals); ?></span></p></dd>
                                        <dd><p>可用金额：<span class="red">￥<?php echo sprintf("%.2f",$Member->amount); ?></span></p></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="user-bottom white-bg">
                            <dl class="u-property clearfix">
                                <dd style="cursor:pointer">待收利息<br>￥<b>{{sprintf("%.2f",$daiShouyi)}}</b></dd>

                                <dd style="cursor:pointer">累积收取利息<br>￥<b>{{sprintf("%.2f",$moneylog_moneys)}}</b></dd>

                                <dd style="cursor:pointer">待收本金<br>￥<b>{{sprintf("%.2f",$buyjsamounts)}}</b></dd>

                                <dd style="cursor:pointer">提现金额<br>
                                    ￥<b>{{sprintf("%.2f",$withdrawals)}}</b></dd>

                                <dd style="cursor:pointer">累计成功提现<br>￥<b>{{sprintf("%.2f",$withdrawals1)}}</b></dd>
                            </dl>

                            <div id="container" style="min-width:400px;height:400px">
                            </div>
                            <div class="u-financial">
                                <h3><b class="black">最近投资</b></h3>
                                <div class="table-box">


                                    <table width="100%">
                                        <thead>
                                        <tr>
                                            <th>收益所属日期</th>
                                            <th>投资金额（元）</th>
                                            <th>累计收益金额（元）</th>
                                            <th>项目名称</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                            @if($Productbuys)
                                                @foreach($Productbuys as $buy)
                                                    <tr>
                                                        <td>{{$buy->useritem_time2}}</td>
                                                        <td>{{$buy->amount}}</td>

                                                        <td>{{sprintf("%.2f",\App\Product::GetShouYi($buy->productid)*$buy->amount/100*$buy->useritem_count)}}</td>
                                                        <td>{{\App\Product::GetTitle($buy->productid)}}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="noInfo">s
                                            <td colspan="4">您还没有任何记录</td>
                                            </tr>
                                            @endif


                                        </tbody>
                                    </table>





                                </div>
                            </div>
                            <div class="u-loan">
                                <h3><b class="black">最近收益</b></h3>
                                <div class="table-box">
                                    <table width="100%">
                                        <thead>
                                        <tr>
                                            <th>收益所属日期</th>
                                            <th>金额（元）</th>
                                            <th>项目名称</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($ShouYis)
                                            @foreach($ShouYis as $sy)
                                                <tr>
                                                    <td>{{$sy->created_at}}</td>
                                                    <td>{{$sy->moneylog_money}}</td>
                                                    <td>{{$sy->moneylog_notice}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="noInfo">s
                                                <td colspan="3">您还没有任何记录</td>
                                            </tr>
                                        @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="{{asset("pc/finance/css/user/js/jquery-1.8.3.min.js")}}"></script>
        <script type="text/javascript" src="{{asset("pc/finance/css/user/js/highcharts.js")}}"></script>
        <script type="text/javascript" src="{{asset("pc/finance/css/user/js/exporting.js")}}"></script>
        <script type="text/javascript" src="{{asset("pc/finance/css/user/js/highcharts-3d.js")}}"></script>


        <script>

            layui.use('upload', function(){


                var upload = layui.upload;

                //执行实例
                var uploadInst = upload.render({
                    elem: '#thumb_url' //绑定元素
                    ,url: '{{route("uploads.uploadimg")}}?_token={{ csrf_token() }}' //上传接口
                    , field:'thumb'
                    ,done: function(src){
                        //上传完毕回调

                        console.log(src);
                        if(src.status==0){
                            layer.msg(src.msg,{time:500},function(){

                                $(".imgshow").html('<img src="'+src.src+'?t='+new Date()+'" width="100" style="float:left;"/>');



                            });
                        }

                    }
                    ,error: function(){
                        //请求异常回调
                    }
                });

            });



        </script>

        <script type="text/javascript">
            $(function () {
                $('#container').highcharts({
                    title: {
                        text: '账户总览',
                        x: 0 //center
                    },
                    chart: {
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
                        }
                    },
                    credits: {
                        enabled: false // 禁用版权信息
                    },
                    navigation: {
                        buttonOptions: {
                            enabled: false
                        }
                    },
                    colors: ['#7CB5EC', '#FEB45D', '#47BFBD', '#F64649'],
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            innerSize: 120,
                            depth: 45,
                            slicedOffset: 20,
                            dataLabels: {
                                enabled: true,
                                softConnector: false,
                                verticalAlign: 'bottom',
                                distance: 50
                            }
                        }
                    },
                    series: [{
                        name: '金额（人民币）',
                        data: [
                            ['可用余额{{sprintf("%.2f",$Member->amount)}}', {{sprintf("%.2f",$Member->amount)}}],
                            ['待收利息{{sprintf("%.2f",$daiShouyi)}}', {{sprintf("%.2f",$daiShouyi)}}],
                            ['待收本金{{sprintf("%.2f",$buyjsamounts)}}', {{sprintf("%.2f",$buyjsamounts)}}],
                            ['提现冻结金额{{sprintf("%.2f",$Member->is_dongjie)}}', {{sprintf("%.2f",$Member->is_dongjie)}}]
                        ]
                    }]
                });
            });
        </script>
    </div>





@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

