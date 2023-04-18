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




                    <div class="r-user-border white-bg bfc">
                        <ul class="user-tabs-menu clearfix" current="2">

                            <li><a href="{{route("user.recharge")}}">账户充值</a></li>
                            <li class="selected"><a href="{{route("user.recharges")}}">充值记录</a></li>
                        </ul>
                        <div class="user-tabs-cont">
                            <div class="table-box">
                                <table width="100%">
                                    <thead>
                                    <tr>
                                        <th width="20%">充值流水号</th>
                                        <th width="20%">充值时间</th>
                                        <th width="15%">充值方式</th>
                                        <th width="8%">充值金额</th>
                                        <th width="15%">充值状态</th>
                                    </tr>
                                    </thead>
                                   <tbody id="view">
                                    <tr class="noInfo">
                                        <td colspan="6">您还没有任何记录</td>
                                    </tr>

                                    </tbody> </table>


                                <div id="pages" class="text-c"></div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>




        <script id="demo" type="text/html">


            <%#  layui.each(d.data, function(index, item){ %>

            <tr class="noInfo">


                <td><% item.ordernumber %></td>


                <td><% item.created_at %></td>
                <td><% item.paymentid %></td>
                <td><% item.amount %></td>
                <td><% item.status==0?'处理中':'' %><% item.status==1?'成功':'' %><% item.status==-1?'失败':'' %></td>

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



                var url = "{{ route('user.recharges') }}";




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

    </div>





@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

