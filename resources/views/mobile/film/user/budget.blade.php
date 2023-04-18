@extends('mobile.film.wap')

@section("header")
    @parent
    <header class="blackHeader"><a href="javascript:history.go(-1);"><img src="{{asset("mobile/film/images/whiteBack.png")}}" class="left backImg"></a><span class="headerTitle">下线收支</span></header>

@endsection

@section("js")
    @parent

    <script type="text/javascript" src="{{ asset("admin/lib/layui/layui.js")}}" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset("admin/lib/layui/css/layui.css")}}"/>
@endsection

@section("css")

    @parent

    <link rel="stylesheet" href="{{asset("js/layui/css/layui.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/app.css")}}"/>
@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')


        <div class="myinfo" style="margin-top:50px;padding: 20px; margin-bottom: 15px;background:#fff;">
            <p style="margin:15px 0px;">尊敬的<?php echo \Cache::get('CompanyShort'); ?>
                会员，以下是您在<?php echo \Cache::get('CompanyShort'); ?>的推广记录，敬请审阅！</p>
            <p>截止 <?php echo \Carbon\Carbon::now()->format("y-m-d H:i"); ?> </p>
            <p>下线总计充值: <?php echo $recharge; ?> </p>
            <p>下线总计提款: <?php echo $withdrawal; ?> </p>

            <div class="container-fluid">
                <div class="row-fluid">
                    <table class="inviteTab ">
                        <thead>
                        <tr>
                            <th width="20%">下线会员账号</th>
                            <th width="20%">下线层级</th>
                            <th width="20%">注册时间</th>
                            <th width="20%">充值总额</th>
                            <th width="20%">提款总额</th>
                        </tr>
                        </thead>
                        <tbody id="view">


                        @if($list)
                            @foreach($list as $item)

                                <tr class="odd gradeX" >
                                    <td>{{$item->username?$item->username:''}}</td>
                                    <td>{{$item->cenji?$item->cenji:'' }}</td>
                                    <td>{{$item->date?$item->date:''}}</td>


                                    <td class="center" ><font color="#00A11D">{{$item->recharge}}</font></td>

                                    <td class="center" ><font color="#ff9900">{{$item->withdrawal}}</font></td>


                                </tr>



                            @endforeach
                        @endif


                        </tbody>
                    </table>



                </div>
            </div>
            <div class="layui-form layui-layer-page " id="layer_pages" style="margin-left: 50px;margin-top:50px;width: auto;margin-bottom:50px;">
                {{$list->appends([])->links('common.pagination')}}
            </div>

        </div>

    </div>

        <script id="demo" type="text/html">


            <%#  layui.each(d.data, function(index, item){ %>

            <tr class="odd gradeX" >
                <td><% item.username?item.username:'' %></td>
                <td><% item.cenji?item.cenji:'' %></td>
                <td><% item.date?item.date:'' %></td>


                <td class="center" ><font color="#00A11D"><% item.recharge %></font></td>

                <td class="center" ><font color="#ff9900"><% item.withdrawal %> </font></td>


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
                //lists(1, obj);

            });

            function pageshow(page_count, pagesize, page,op) {
                layui.use('laypage', function () {
                    var laypage = layui.laypage;



                    laypage.render({
                        elem: 'layer_pages'
                        , count: page_count //数据总数，从服务端得到
                        , curr: page
                        , limit: pagesize
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



                var url = "{{ route('user.offline.budget') }}";




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







@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

