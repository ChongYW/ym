@extends('mobile.film.wap')

@section("header")
@endsection

@section("js")
    @parent
@endsection

@section("css")
    @parent
    <link rel="stylesheet" href="{{asset("mobile/film/css/user.css")}}"/>
    <style>
        body {
            padding-top: 0px;
            background: #F1F1F1;
        }
        .global-fenhong{
            padding:10px 20px;
            background: #fff;
            margin-bottom:10px;
        }
        .global-fenhong b{
            color:red;
        }
        .wenhao{
            width: 20px;
            height: 20px;
            border: 1px solid #000;
            display: inline-block;
            text-align: center;
            line-height: 16px;
            border-radius: 50%;
        }
    </style>
    <link rel="stylesheet" href="{{asset("css/app.css")}}"/>
@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')
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

    <div class="userinfo nx-userinfo2">
        <img src="{{asset("mobile/film/images/give_gold_gray.png")}}" style="width: 48px;left: 7px;position: absolute;top: 14px;">
        <div class="nx-suer-top">
            <div>
                <div class="trj-account-user-img">

                </div>
                <span style="padding-top: 0.8rem;padding-bottom: 0.5rem;color:#f7f7f7;font-weight:bold;font-size: 17px;" class="ng-binding">
				  <font style="font-family:'Bebas';"><?php  echo \App\Member::half_replace(\App\Member::DecryptPassWord($Member->mobile));?></font><font style="font-size:14px; color:#c7c7c7;"></font></span><font style="font-size:14px; color:#c7c7c7;">

                </font></div>
            <font style="font-size:14px; color:#c7c7c7;">
            </font></div>
        <font style="font-size:14px; color:#c7c7c7;">

        <span style="width:195px;   left: 60px;position: absolute;top: 38px;">
            <b class="grade-cont grade-1"><?php echo $memberlevelName[$Member->level]; ?></b>
                    </span>
            <a href="{{route("user.msglist")}}"><img src="{{asset("mobile/film/images/home_message_icon.png")}}" style="position: absolute;z-index: 9;right: 5px;top: 60px;width: 11%;"></a>

            <div class="f_r" style="height: 29px;right: 0.8rem;position: absolute;top: 13px;">
                <a href="javascript:void(0)" id="qiandao"><img src="{{asset("mobile/film/images/qiandao.png")}}" style="height:100%;" onclick="qiandao()">
                    <img src="{{asset("mobile/film/images/login_in.png")}}" style="height:100%;" onclick="qiandao()"></a>

            </div>

            <div class="trj-xilan" ng-if="accountInfo.source?true:false">
                <div>
                </div>
            </div>
            <h1 class="nx-balaner"><span ng-if="visible" ui-sref="app.accountNewDetails" class="ng-binding" href="#">
            <font style="font-family:'Bebas';"> <?php echo sprintf("%.2f",$Member->yuamount); ?></font></span>
                <p><font style="font-family:'Bebas';">余额宝资产元）</font></p>
            </h1>
            <h1 class="nx-balaner"><span ng-if="visible" ui-sref="app.accountNewDetails" class="ng-binding" href="#">
            <font style="font-family:'Bebas';"> <?php echo sprintf("%.2f",$Allyuemoneys); ?></font></span>
                <p><font style="font-family:'Bebas';">累计收益(元)</font></p>
            </h1>
            <div class="details nx-details">
                <ul class="details_l">
                    <li class="details-top">
                        <span class="trj-detais_l-num ng-binding"><font style="font-family:'Bebas';"><?php echo sprintf("%.2f", $Member->yuamount); ?></font></span>
                        <p>
                            <font style="font-family:'Bebas';"> 可转出金额(元)</font>
                        </p>
                    </li>
                </ul>
                <ul class="details_r">
                    <li class="details-top"><span class="trj-detais_l-num ng-binding">
                    <font style="font-family:'Bebas';">
                      <?php echo sprintf("%.2f", $Dayyuemoneys); ?>        </font>
                <p>
                    <font style="font-family:'Bebas';">今日收益(元)</font>
                </p>
            </span></li>
                </ul>
            </div>
        </font>
    </div>


    <div class="navdownb" style="padding: 10px;">
        <div class="clear" style="height:10px;"></div>
        <a href="javascript:void(0);" onclick="yuebaozuanru()">
            <div class="btn btn_hui" style="">转入
            </div>
        </a>
        <a href="javascript:void(0);" onclick="yuebaozuanchu()">
            <div class="btn btn_orange">
                转出
            </div>
        </a>

    </div>




    <script src="{{asset("admin/js/jquery.min.js")}}?t=v1"></script>
    <script src="{{asset("layim/layui.js")}}?t=v1"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset("admin/lib/layui/css/layui.css")}}"/>



    <div class="user_zx_right" >

        <div class="myinfo" style="padding: 20px; ">


            <div class="container-fluid">
                <div class="row-fluid">
                    <table class="inviteTab ">
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
            <div class="layui-form layui-layer-page " id="layer_pages" style="margin-left: 50px;margin-top:50px;width: auto;">
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
          //  lists(1, obj);

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


@endsection

@section('footcategoryactive')
    <script type="text/javascript">
        //$("#menu2").addClass("active");
    </script>
@endsection
@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
    <br/>
    <br/>

    <font id="top_playSound"></font>
@endsection

