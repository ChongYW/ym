@extends('mobile.default.wap')

@section("header")
    @parent
    <div class="top" id="top" >
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
    </div>

    <link rel="stylesheet" href="{{asset("mobile/public/Front/css/common.css")}}" />

    <link rel="stylesheet" type="text/css" href="{{asset("mobile/public/style/css/style.css")}}"/>
    {{--<link href="/mobile/public/Front/user/user.css" type="text/css" rel="stylesheet">--}}
    <script type="text/javascript" charset="utf-8" src="{{asset("mobile/public/Front/user/user.js").'?t='.time()}}"></script>

@endsection

@section("js")


    <script src="{{asset("admin/js/jquery.min.js")}}?t=v1"></script>
     <script type="text/javascript" src="{{ asset("admin/lib/layui/layui.js")}}" charset="utf-8"></script>
@endsection

@section("css")

    @parent

    <style>
        .header {
            min-height--: 115px;
            max-width: 450px;
            min-width: 320px;
            margin: auto;
            padding-top: 0px;
            border-left: 0px solid #f3f3f3;
            border-right: 0px solid #f3f3f3;
            background: #D6382D;
        }

        .header .nav li a {
            display: inline-block;
            padding: 3px 8.1px;
            color: #fff;
            font-size: 15px;
        }

        .header .nav li a.on, .header .nav li a:hover {
            color: #FE943C;
            background--: #ff6600;
        }
        .header .nav li+li {
            border-left: 0px solid #f3f3f3;
        }
        .navdowna{height:97px;      text-align: center;
            padding: 20px 10px;text-align:center;    width: 99%!important;
            margin-bottom: 0px!important;
            background: #fff;
            margin: 10px auto; margin-top: 0px;
            border: 1px #ddd solid;
            clear: both;}
        .navdowna li{height:22px;line-height:22px;font-size:18px;color:#333;margin:0px auto;float:left;width:100%;}
        .navdowna .zong{color:#999;font-size:13px;}
        .navdowna .jine{color: #f13131;
            font-size: 30px;
            line-height: 30px;}

        .navdownb {
            text-align: center;
            height: 50px;
            padding: 0px 10px;
            background: #F5F5F5;
            overflow: hidden;
        }
        .navdownb .jineadd{    float: left;
            width: 50%;
            text-align: center;
            padding-bottom: 10px;
            font-size: 13px;}
        .navdownb .jineadd  .zong{color:#999;font-size:13px;}
        .navdownb .jineadd  .jine{    color: #f13131;
            font-size: 16px;}
        .navdownb .jineadd li{height:25px;line-height:25px;font-size:16px;color:#333;margin:0 auto;width:100%;padding--:10px;float:left;text-align:center}

        .btn_orange {
            background: #f60;
            /*color: #fff;*/
            float: left;
            height: 30px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: .8rem;
            width: 45%;
            text-align: center;
            line-height: 30px;
            margin-bottom: 10px;
            padding:0px;
        }
        .btn_hui {
            background: #fff;
            /*color: #0697da;*/
            border: .1rem solid #e1e1e1;
            float: right;
            height: 30px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: .8rem;
            width: 45%;
            text-align: center;
            line-height: 30px;
            margin-bottom: 10px;
            padding:0px;
        }
    </style>


    <link rel="stylesheet" href="{{asset("css/app.css")}}"/>

@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')

    <style>
        .top{
            display:none !important;
        }
        .topadd {
            padding-top: 10px !important;
        }
    </style>
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
    $buyjsamounts=  \App\Productbuy::where("userid",$Member->id)->where("status","0")->sum("amount");

    $withdrawals= \App\Memberwithdrawal::where("userid",$Member->id)->where("status","0")->sum("amount");
    $recharges= \App\Memberrecharge::where("userid",$Member->id)->where("status","0")->sum("amount");
    $Dayyuemoneys=\App\Moneylog::whereDate("created_at", \Carbon\Carbon::now()->format("Y-m-d"))
        ->where("moneylog_userid", $Member->id)
        ->where("moneylog_type", "余额宝奖励")
        ->sum("moneylog_money");

    $Allyuemoneys=\App\Moneylog::where("moneylog_userid", $Member->id)
        ->where("moneylog_type", "余额宝奖励")
        ->sum("moneylog_money");

    ?>


    <div class="topadd" style="background: #3579f7;padding-top: 41px;">
        <div class="logoadd tupan">
            <span><a href="javascript:yuebao()">余额宝介绍</a></span>
            <img style="width:50px;height:50px;" src="{{$Member->picImg}}"><font><?php echo $Member->username; ?><br />会员等级：<?php echo $memberlevelName[$Member->level]; ?></font>

        </div>

        <script>

            function qiandao() {
                var _token = $("[name='_token']").val();
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
                            time:2,
                            shadeClose: false,

                        });
                    }
                });
            }

        </script>

        <div class="zichan">
            余额宝(元)<font><?php echo round($Member->yuamount,2); ?></font>
        </div>
        <div class="yuene">
            <dl>
                <dd>
                    可转出金额(元)<br /><?php echo $Member->yuamount; ?>
                </dd>
                <dd>
                    今日收益(元)<br /><?php echo round($Dayyuemoneys,2); ?>
                </dd>
                <dd>
                    累计收益(元)<br /><?php echo round($Allyuemoneys,2); ?>
                </dd>
            </dl>
        </div>



    </div>


    <div class="navdownb">
        <div class="clear" style="height:10px;"></div>
        <a href="javascript:void(0);" onclick="yuebaozuanru()">
        <div class="btn btn_orange" style="background:#FFF">转入
        </div>
        </a>
        <a href="javascript:void(0);" onclick="yuebaozuanchu()">
        <div class="btn btn_hui">
            转出
        </div>
        </a>

    </div>










    <script src="{{asset("admin/js/jquery.min.js")}}?t=v1"></script>
    <script src="{{asset("layim/layui.js")}}?t=v1"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset("admin/lib/layui/css/layui.css")}}"/>



    <div class="user_zx_right" >

        <div class="myinfo" style="padding: 20px; margin-bottom: 15px;background:#fff;">


            <div class="container-fluid">
                <div class="row-fluid">
                    <table class="datatable table table-striped table-bordered table-hover ">
                        <thead>
                        <tr>
                            <th><img src="{{asset("mobile/public/Front/user/xf1.jpg")}}"></th>
                            <th>标题</th>

                            <th>金额</th>
                            <th>时间</th>
                        </tr>
                        </thead>
                        <tbody id="view">


                        @if($list)
                            @foreach($list as $item)

                                <tr class="odd gradeX" >
                                    <td >{{$item->id}}</td>
                                    <td >{{$item->moneylog_type}}</td>
                                    @if($item->moneylog_status=='+')
                                        <td class="center" ><font color="#00A11D">+{{$item->moneylog_money}} </font></td>
                                    @else
                                        <td class="center" ><font color="#ff0000">-{{$item->moneylog_money}} </font></td>
                                    @endif
                                    <td>{{$item->date}}</td>


                                </tr>

                            @endforeach
                        @endif


                        </tbody>
                    </table>



                </div>
            </div>
            <div class="layui-form layui-layer-page " id="layer_pages" style="margin-left: 50px;width: auto;">
                {{$list->appends([])->links('common.pagination')}}
            </div>
        </div>

    </div>


    <script id="demo" type="text/html">


        <%#  layui.each(d.data, function(index, item){ %>

        <tr class="odd gradeX" >
            <td ><% item.id %></td>
            <td ><% item.moneylog_type %></td>
            <%# if(item.moneylog_status=='+'){ %>
            <td class="center" ><font color="#00A11D">+<% item.moneylog_money %> </font></td>
            <%# }else{ %>
            <td class="center" ><font color="#ff0000">-<% item.moneylog_money %> </font></td>
            <%# } %>
            <td><% item.date %></td>


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
           // lists(1, obj);

        });

        function pageshow(page_count, pagesize, page,op) {
            layui.use('laypage', function () {
                var laypage = layui.laypage;



                laypage.render({
                    elem: 'layer_pages'
                    , count: page_count //数据总数，从服务端得到
                    , curr: page
                    , limit: pagesize
                    //, groups: 3
                    , theme: '#1E9FFF'
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


                        //pageshow(data.list.last_page,page);
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
                    layer.closeAll();
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
                    layer.closeAll();
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

