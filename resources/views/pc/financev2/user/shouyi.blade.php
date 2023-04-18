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




                    <div class="r-user-border white-bg bfc">
                        <ul class="user-tabs-menu clearfix" current="2">
                            <li><a href="{{route('user.tender')}}">投资记录</a></li>
                            <li class="selected"><a href="{{route('user.shouyimx')}}">资金明细</a></li>
                        </ul>
                        <h2 class="r-user-title">资金明细</h2>
                        <div class="funds">
                            <div class="funds-inquire clearfix">


                                    <span>类型：</span>
                                    <select name="moneylog_type" style="width:100px">
                                        @if(\Cache::has('webmsgtype'))
                                            <option value="" >全部</option>
                                            @foreach(explode("|", \Cache::get('webmsgtype')) as $itme)
                                                <option value="{{$itme}}" @if(isset($_REQUEST['moneylog_type']) && $_REQUEST['moneylog_type']==$itme)selected="selected" @endif>{{$itme}}</option>
                                            @endforeach
                                        @endif
                                        </select>

                                    <select name="s_status"  lay-search lay-filter="s_status" style="width:100px">


                                        <option value="" >流水方向</option>

                                        <option value="+" @if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']=='+')selected="selected" @endif>收入</option>
                                        <option value="-" @if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']=='-')selected="selected" @endif>支出</option>



                                    </select>

                                    <span>时间：</span>



                                        <script>
                                        layui.use('laydate', function(){
                                            var laydate = layui.laydate;

                                            //执行一个laydate实例
                                            laydate.render({
                                                elem: '#starttime' //指定元素
                                            });

                                            //执行一个laydate实例
                                            laydate.render({
                                                elem: '#endtime' //指定元素
                                            });
                                        });


                                    </script>

                                    <input type="text" name="starttime" id="starttime"  value="" size="10" readonly="">&nbsp; <span>到&nbsp;&nbsp;</span>  <input type="text" name="endtime"  id="endtime" value="" size="10" readonly="">&nbsp;
                                <input type="submit" value="搜索" class="btn green-btn" name="dosubmit" onclick="lists()">

                            </div>
                            <div class="table-box">

                                <table width="100%">
                                    <tbody><tr>
                                        <th>时间</th>
                                        <th>类型</th>
                                        <th>收入</th>
                                        <th>支出</th>
                                        <th>备注</th>
                                    </tr></tbody>
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

        <script id="demo" type="text/html">


            <%#  layui.each(d.data, function(index, item){ %>

            <tr class="noInfo">

                <td><% item.date %></td>
                <td><font color="#666666"><% item.moneylog_type %></font></td>
                <%# if(item.moneylog_status=='+'){ %>
                <td class="center" ><font color="#00A11D"><% item.moneylog_status %><% item.moneylog_money %> </font></td>
                <%# }else{ %>
                <td> </td>
                <%# } %>
                <%# if(item.moneylog_status=='-'){ %>
                <td class="center" ><font color="#ff0000"><% item.moneylog_status %><% item.moneylog_money %> </font></td>
                <%# }else{ %>
                <td> </td>
                <%# } %>

                <td><% item.moneylog_notice %> </td>
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



                var url = "{{ route('user.shouyimx') }}";




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

