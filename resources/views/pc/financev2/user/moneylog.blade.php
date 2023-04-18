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


                    <div class="r-user-border white-bg bfc">
                        <ul class="user-tabs-menu clearfix" current="2">
                            <li class="selected"><a href="{{route('user.moneylog')}}">资金统计</a></li>
                            <li><a href="{{route('user.shouyimx')}}">资金明细</a></li>
                        </ul>
                        <h2 class="r-user-title">资金统计</h2>
                        <div class="funds">

                            <div class="data-type margin-top-20">
                                <p class="font-14" style="padding-left: 5px;">
                                    <span class="font-14 fl_r" style="color:rgb(179, 177, 177);">总计=可用余额+待收本金+待收利息+提现资金</span>
                                    资产总计：<span style="color:#F00; font-size:14px;font-weight:600">￥{{sprintf("%.2f",$Member->amount+$daiShouyi+$buyjsamounts+$withdrawals0)}}</span>                    </p>
                            </div>
                            <div class="table-box">
                               <table width="100%">
                                    <tbody><tr>
                                        <td> <div id="container" style="min-width:400px;height:400px" data-highcharts-chart="0"></div></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    </tbody></table>
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

