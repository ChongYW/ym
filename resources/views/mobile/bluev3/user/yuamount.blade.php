@extends('mobile.bluev3.wap')

@section("header")
@endsection

@section("js")
    @parent
@endsection

@section("css")
    @parent
    <link rel="stylesheet"  href="/mobile/bluev3/newindex/css/div3.css"/>
    <link rel="stylesheet"  href="/mobile/bluev3/newindex/css/div4.css"/>
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



    <section class="aui-flexView">


        <div class="othertop">
            <a class="goback" href="{{route('user.index')}}"><img src="{{asset("mobile/bluev3/img/goback.png")}}" style="margin: 0px;"/></a>
            <div class="othertop-font">余额宝</div>
        </div>
        <div class="header-nbsp"></div>



        <section class="aui-scrollView">

            <div class="aui-finance-box-e">
                <div class="aui-finance-fun-e">
                    <div class="aui-finance-fun-hd-e">
                        <h3 style="font-size:16px; text-align: center;margin-top: 30px">
                            今日收益：<?php echo sprintf("%.2f", $Dayyuemoneys); ?> （元）
                        </h3>
                        <h3 style="font-size:18px; text-align: center;margin-top: 10px">
                            总金额  ：<?php echo sprintf("%.2f",$Member->yuamount); ?>（元）
                        </h3>
                    </div>
                </div>

                <div style="margin-top: 25px">
                    <a href="#" class="aui-palace-grid-e">
                        <div class="aui-palace-grid-icon-e" style="font-size: 16px;"><?php echo sprintf("%.2f",$Allyuemoneys); ?></div>
                        <div class="aui-palace-grid-text">
                            <h2 style="font-size: 14px;color: #ea900c;">累计收益（元）</h2>
                        </div>
                    </a>

                    <a href="#" class="aui-palace-grid-e">
                        <div class="aui-palace-grid-icon-e" style="font-size: 16px;">{{Cache::get('YuBaoLv')*1000}}</div>
                        <div class="aui-palace-grid-text">
                            <h2 style="font-size: 14px;color: #ea900c;">万份收益（元）</h2>
                        </div>
                    </a>

                    <a href="#" class="aui-palace-grid-e">
                        <div class="aui-palace-grid-icon-e" style="font-size: 16px;">{{Cache::get('YuBaoLv')}}</div>
                        <div class="aui-palace-grid-text">
                            <h2  style="font-size: 14px;color: #ea900c;">七日年化（%）</h2>
                        </div>
                    </a>
                </div>
            </div>
            <div class="b-line"></div>
            <div class="divHeight b-line"></div>
            <div class="user_btn" style="margin-top: 10px;">


                <a href="javascript:void(0);" onclick="yuebaozuanru()" style="color: #fff;background: #378af0;"><b>转入</b></a>
                <a href="javascript:void(0);" onclick="yuebaozuanchu()" style="color: #fff;background: #39a3fa;"><b>转出</b></a>

            </div>


            <div class="record_outer">
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
                    @foreach($list as $kn=>$item)

                        <tr class="odd gradeX" >
                            <td >{{isset($_GET['page'])?($kn+1)+($_GET['page']-1)*$pagesize:($kn+1)}}</td>
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

            <div style="margin:10px auto;width: 200px;">
                {{$list->appends([])->links('common.pagination')}}
            </div>

            </div>
            <style>


                .page-link {
                    position: relative;
                    display: block;
                    padding: .15rem .15rem;
                    margin-left: -1px;
                    line-height: 1.8;
                    color: #3490dc;
                    background-color: #fff;
                    border: 1px solid #dee2e6;
                }

            </style>
            <div class="rules">

            </div>

        </section>
    </section>







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

@endsection
@section("footbox")
    @parent
@endsection

@section("footer")
    @parent


    <font id="top_playSound"></font>
@endsection

