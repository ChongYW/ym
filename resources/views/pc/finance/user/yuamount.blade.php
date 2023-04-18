@extends('pc.finance.pc')

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
                    $Dayyuemoneys=\App\Moneylog::whereDate("created_at", \Carbon\Carbon::now()->format("Y-m-d"))
                        ->where("moneylog_userid", $Member->id)
                        ->where("moneylog_type", "余额宝奖励")
                        ->sum("moneylog_money");

                    $Allyuemoneys=\App\Moneylog::where("moneylog_userid", $Member->id)
                        ->where("moneylog_type", "余额宝奖励")
                        ->sum("moneylog_money");
                    ?>

                    <div class="bfc">
                        <div class="user-top white-bg">
                            <h2>我的账户</h2>
                            <div class="user-info clearfix">
                                <div class="head-pic fl">
                                    <img src="{{$Member->picImg}}" alt="" width="100"></div>
                                <div class="user-btn fr clearfix">
                                    <a href="javascript:void(0);" class="btn btn2 orange-btn fl" onclick="yuebao()">余额宝介绍</a>

                                    <a href="javascript:void(0);" class="btn btn2 orange-btn fl" onclick="yuebaozuanru()">转 入</a>
                                    <a href="javascript:void(0);" class="btn btn2 green-btn fl" onclick="yuebaozuanchu()">转 出</a></div>
                                <div class="bfc">
                                    <div class="user-xx clearfix">
                                        <strong>{{\App\Member::GetPhoneTag($Member->id)}}</strong>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <font>您的理财等级为：
                                            <b style="color:#F00"><?php echo $memberlevelName[$Member->level]; ?></b>
                                             </font>
                                    </div>

                                    <dl class="user-ye clearfix">
                                        <dd class="clearfix">
                                            账户总额：<span class="red">￥<?php echo round($Member->amount+$Member->yuamount+$Member->is_dongjie,2); ?></span>

                                        </dd>
                                        <dd>余额宝金额：<span class="red">￥<?php echo sprintf("%.2f",$Member->yuamount); ?></span></dd>
                                        <dd><p>今日收益：<span class="red">￥<?php echo sprintf("%.2f",$Dayyuemoneys); ?></span></p></dd>
                                        <dd><p>累计收益：<span class="red">￥<?php echo sprintf("%.2f",$Allyuemoneys); ?></span></p></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="user-bottom white-bg">



                            <div class="u-financial">
                                <h3><b class="black">余额宝</b></h3>
                                <div class="table-box">


                                    <table width="100%">
                                        <thead>
                                        <tr>
                                            <th>日期</th>
                                            <th>标题</th>
                                            <th>内容</th>
                                            <th>金额</th>
                                        </tr>
                                        </thead>
                                        <tbody id="view">





                                        </tbody>
                                    </table>


                                    <div id="pages" class="text-c"> </div>


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

    </div>


    <script id="demo" type="text/html">


        <%#  layui.each(d.data, function(index, item){ %>

        <tr class="noInfo">

            <td><% item.date %></td>
            <td><font color="#666666"><% item.moneylog_type %></font></td>

            <td><% item.moneylog_notice %> </td>

            <%# if(item.moneylog_status=='+'){ %>
            <td class="center" ><font color="#00A11D"><% item.moneylog_status %><% item.moneylog_money %> </font></td>

            <%# } else if(item.moneylog_status=='-'){ %>
            <td class="center" ><font color="#ff0000"><% item.moneylog_status %><% item.moneylog_money %> </font></td>

            <%# } %>


        </tr>




        <%#  }); %>

        <%#  if(d.length === 0){ %>
        <tr>
            <td width="90%" colspan="5">暂无记录</td>
        </tr>
        <%#  } %>

    </script>

    <script>


        layui.use(['laypage', 'layer', 'form'], function () {
            var $ = layui.jquery;
            var layer = layui.layer;
            var form = layui.form;
            var laypage = layui.laypage;

            var obj={

            };
            lists(1, obj);

        });

        function pageshow(page_count, pagesize, page,op) {
            layui.use('laypage', function () {
                var laypage = layui.laypage;

                laypage.render({
                    elem: 'pages'
                    , count: page_count //数据总数，从服务端得到
                    , curr: page
                    , limit: pagesize
                    , theme: '#d11111'
                    , layout: [ 'count','prev', 'page', 'next']
                    , jump: function (obj, first) {

                        //首次不执行
                        if (!first) {
                            lists(obj.curr, op);
                        }
                    }
                });
            });

        }

        function lists(page = 1, op2 = {}) {

            var op1 = {
                page: page,
                moneylog_type: $("[name='moneylog_type']").val(),
                s_status: $("[name='s_status']").val(),
                starttime: $("[name='starttime']").val(),
                endtime: $("[name='endtime']").val(),
                "_token": "{{ csrf_token() }}"
            };

            var obj = Object.assign(op1, op2);



            var url = "{{ route('user.yuamount') }}";




            $.ajax({
                url: url,
                type: "post",     //请求类型
                data: obj,  //请求的数据
                dataType: "json",  //数据类型
                beforeSend: function () {
                    // 禁用按钮防止重复提交，发送前响应
                    // var index = layer.load();

                },
                success: function (data) {
                    //laravel返回的数据是不经过这里的
                    if (data.status == 0) {
                        var list = data.list;
                        pagelist(list);
                        pageshow(data.list.total, data.pagesize, page,op2);


                    } else {
                        layer.msg(data.msg, {icon: 5}, function () {

                        });
                    }
                },
                complete: function () {//完成响应
                    //layer.closeAll();
                },
                error: function (msg) {
                    var json = JSON.parse(msg.responseText);
                    var errormsg = '';
                    $.each(json, function (i, v) {
                        errormsg += ' <br/>' + v.toString();
                    });
                    layer.alert(errormsg);

                },

            });


        }


        function pagelist(list) {


            layui.use(['laytpl', 'form'], function () {
                var laytpl = layui.laytpl;
                var form = layui.form;
                laytpl.config({
                    open: '<%',
                    close: '%>'
                });

                var getTpl = demo.innerHTML
                    , view = document.getElementById('view');
                laytpl(getTpl).render(list, function (html) {
                    view.innerHTML = html;
                });


                form.render(); //更新全部

            });


        }


        /**
         * js截取字符串，中英文都能用
         * @param str：需要截取的字符串
         * @param len: 需要截取的长度
         */
        function cutstr(str, len) {
            var str_length = 0;
            var str_len = 0;
            str_cut = new String();
            str_len = str.length;
            for (var i = 0; i < str_len; i++) {
                a = str.charAt(i);
                str_length++;
                if (escape(a).length > 4) {
                    //中文字符的长度经编码之后大于4
                    str_length++;
                }
                str_cut = str_cut.concat(a);
                if (str_length >= len) {
                    str_cut = str_cut.concat("...");
                    return str_cut;
                }
            }
            //如果给定字符串小于指定长度，则返回源字符串；
            if (str_length < len) {
                return str;
            }
        }







    </script>

    <script>
        //余额宝收益功能是本平台最新推出的收益版块，为您的投资更省心更便捷，您只需要从账户余额中转入金额到余额宝中即可每日坐享收益，最低转入金额为100元，余额宝转入的金额必须要在满24小时后才会产生收益。每日余额宝中所得到的收益将直接返款到您的可提现余额中，转入转出方便快捷！
        var layer;
        layui.use('layer', function(){
            layer = layui.layer;
        });

        function yuebao() {


            layer.alert('余额宝收益功能是本平台最新推出的收益版块，为您的投资更省心更便捷，您只需要从账户余额中转入金额到余额宝中即可每日坐享收益，最低转入金额为{{Cache::get('YuBaoLvML')}}元，余额宝转入的金额必须要在满24小时后才会产生收益。每日余额宝中所得到的收益将直接返款到您的可提现余额中，转入转出方便快捷！',{title:'余额宝说明'}
            );

        }

        function yuebaozuanru() {
            layer.prompt({title:'可转入金额:<?php echo round($Member->amount,2); ?>元'},function(value, index, elem){
                //alert(value); //得到value



                var obj = {
                    amount: value,
                    act: '+',
                    "_token": "{{ csrf_token() }}"
                };



                var url = "{{ route('user.yuamountAct') }}";


                $.ajax({
                    url: url,
                    type: "post",     //请求类型
                    data: obj,  //请求的数据
                    dataType: "json",  //数据类型
                    beforeSend: function () {
                        // 禁用按钮防止重复提交，发送前响应
                        layer.close(index);

                    },
                    success: function (data) {
                        //laravel返回的数据是不经过这里的
                        if (data.status == 0) {

                            layer.msg(data.msg, {icon: 1}, function () {
                                window.location.reload(true);
                            });

                        } else {
                            layer.msg(data.msg, {icon: 5}, function () {

                            });
                        }
                    },
                    complete: function () {//完成响应
                        //layer.closeAll();
                    },
                    error: function (msg) {
                        var json = JSON.parse(msg.responseText);
                        var errormsg = '';
                        $.each(json, function (i, v) {
                            errormsg += ' <br/>' + v.toString();
                        });
                        layer.alert(errormsg);

                    },

                });

            });
        }

        function yuebaozuanchu() {
            layer.prompt({title:'可转出金额:<?php echo round($Member->yuamount,2); ?>元'},function(value, index, elem){
                var obj = {
                    amount: value,
                    act: '-',
                    "_token": "{{ csrf_token() }}"
                };



                var url = "{{ route('user.yuamountAct') }}";


                $.ajax({
                    url: url,
                    type: "post",     //请求类型
                    data: obj,  //请求的数据
                    dataType: "json",  //数据类型
                    beforeSend: function () {
                        // 禁用按钮防止重复提交，发送前响应
                        layer.close(index);

                    },
                    success: function (data) {
                        //laravel返回的数据是不经过这里的
                        if (data.status == 0) {

                            layer.msg(data.msg, {icon: 1}, function () {
                                window.location.reload(true);
                            });

                        } else {
                            layer.msg(data.msg, {icon: 5}, function () {

                            });
                        }
                    },
                    complete: function () {//完成响应
                        //layer.closeAll();
                    },
                    error: function (msg) {
                        var json = JSON.parse(msg.responseText);
                        var errormsg = '';
                        $.each(json, function (i, v) {
                            errormsg += ' <br/>' + v.toString();
                        });
                        layer.alert(errormsg);

                    },

                });
            });
        }
    </script>
@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

