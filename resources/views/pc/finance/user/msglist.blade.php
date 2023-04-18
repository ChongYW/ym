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
                            <li class="selected"><a href="{{route("user.msglist")}}}">收件箱</a></li>

                        </ul>
                        <div class="user-tabs-cont">
                            <div class="table-box">
                                <form name="myform" id="myform">
                                    <table width="100%" cellspacing="0" class="table-list">
                                        <thead>
                                        <tr>
                                            <th width="5%"><input type="checkbox" value="" id="check_box" onclick="selectall('messageid[]');"></th>
                                            <th width="35%">标 题</th>
                                            <th width="15%">发送时间</th>
                                        </tr>
                                        </thead>
                                        <tbody id="view">


                                        </tbody>




                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                                    </table>
                                    <div class="btn blue-btn" style="color:#FFF; margin-top:15px;width:100px;float:left"><a href="#" onclick="javascript:$('input[type=checkbox]').attr('checked', true)" style="color:#FFF">全选</a>/<a href="#" onclick="javascript:$('input[type=checkbox]').attr('checked', false)" style="color:#FFF">取消</a> </div>
                                    <input name="submit" type="button" class="btn green-btn" value="删除选中" onclick="SubForm()" style="color:#FFF; margin-top:15px;width:100px;float:left">&nbsp;&nbsp;
                                </form>
                                <div id="pages"></div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>






    </div>

    <script id="demo" type="text/html">


        <%#  layui.each(d.data, function(index, item){ %>


        <tr>
            <td width="5%">
                <input name="id[]" type="checkbox" value="<% item.id %>">
            </td>
            <td width="35%" align="left">
                <center align="left">
                    <a href="#" onclick="redmsg('<%item.id%>','<%item.content%>')" class="blue change_bank"><% item.title %></a>
                    <%# if(item.status==0){ %>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <font color="#FF0000">
                        <b>NEW</b>
                    </font>
                    <%# } %>
                </center>
            </td>
            <td width="15%">
                <% item.created_at %>
            </td>
        </tr>






        <%#  }); %>

        <%#  if(d.length === 0){ %>
        <tr>
            <td width="90%" colspan="5">暂无记录</td>
        </tr>
        <%#  } %>

    </script>

    <script>

        function redmsg(id,c) {

            layer.open({
                content: c,
                btn: '确定',
                shadeClose: false,
                yes: function (index) {


                    $.ajax({
                        url: '{{route("user.msgread")}}',
                        type: 'post',
                        data: {
                            "_token" :"{{ csrf_token() }}",
                            "id":id
                        },
                        dataType: 'json',
                        error: function () {
                        },
                        success: function (data) {

                        }
                    });


                    layer.close(index);
                }
            });

        }

        function SubForm(id) {


            if( confirm('确认要删除 『 选中 』 吗？')) {
                $.ajax({
                    url: '{{route("user.msgdel")}}',
                    type: 'post',
                    data: $("form").serialize(),
                    dataType: 'json',
                    error: function () {
                    },
                    success: function (data) {
                        layer.open({
                            content: data.msg,
                            btn: '确定',
                            shadeClose: false,
                            yes: function (index) {
                                if (data.status == 0) {
                                lists();
                                }

                                layer.close(index);
                            }
                        });
                    }
                });
            }
        }


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



            var url = "{{ route('user.msglist') }}";




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



@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

