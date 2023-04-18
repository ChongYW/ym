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
    <link href="{{asset("mobile/public/Front/user/user.css")}}" type="text/css" rel="stylesheet">
    <script type="text/javascript" charset="utf-8" src="{{asset("mobile/public/Front/user/user.js").'?t='.time()}}"></script>

@endsection

@section("js")
    @parent

     <script type="text/javascript" src="{{ asset("admin/lib/layui/layui.js")}}" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset("admin/lib/layui/css/layui.css")}}"/>
@endsection

@section("css")

    @parent
    <link rel="stylesheet" href="{{asset("css/app.css")}}"/>

@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')

    <div class="user_zx_right" >
        <div class="box" style="margin-top: 50px">
            <div class="tagMenu">
                <ul class="menu">
                    <li  ><a href="{{route("user.products")}}">投资产品</a></li>
                    <li class="current"><a href="{{route("user.tender")}}">已投产品</a></li>
                    <li @if(isset($id) && $id==1)class="current"@endif><a href="{{route("user.shouyi",["id"=>1])}}">收益明细</a></li>
                    <li @if(isset($id) && $id==2)class="current"@endif><a href="{{route("user.shouyi",["id"=>2])}}">投资明细</a></li>
                    <li @if(isset($id) && $id==3)class="current"@endif><a href="{{route("user.shouyi",["id"=>3])}}">收回本金明细</a></li>

                </ul>
                <div class="hite"> <span id="account"></span> </div>
            </div>
        </div>
        <div class="myinfo" style="padding: 10px; margin-bottom: 15px;background:#fff;">
            <p style="margin:5px 0px;width:100%">尊敬的<?php echo \Cache::get('CompanyShort'); ?>会员，以下是您在<?php echo \Cache::get('CompanyShort'); ?>的站内短信，敬请审阅！</p>

            <div class="container-fluid" style="padding-right: 0px;">
                <div class="row-fluid">
                    <table class="datatable table table-striped table-bordered table-hover ">
                        <thead>
                        <tr>

                            <th width="50%">投资产品</th>
                            {{--<th width="8%">收益率</th>
                            <th width="15%">投资期限</th>--}}
                            <th width="20%">投资状态</th>
                            {{--<th width="10%">投资金额</th>
                            <th width="10%">投资收益</th>--}}
                            <th width="20%">投资时间</th>
                            <th width="10%">协议</th>
                        </tr>
                        </thead>
                        <tbody id="view">

                        @if($list)
                            @foreach($list as $item)




                                <tr class="odd gradeX" onclick="$('#sms{{$item->id}},#msg{{$item->id}}').slideToggle(2);">
                                    <td>{{$item->title}}
                                        <div height="34" style="display:none; width: 98%; height: auto; font-size: 12px; border: 1px dashed rgb(217, 38, 15); padding: 10px;margin: 10px 0 10px 0;
    background-color:#fffcfa;"  id="sms{{$item->id}}">
                                            <div style="width:100%; display:none;" id="msg{{$item->id}}" >

                                                收益率:{{$item->jyrsy}}%<br/>
                                                投资期限:{{$item->shijian}}{{$item->qxdw}}<br/>
                                                投资金额:{{$item->amount}}<br/>
                                                @if($item->benefit > 0 )
                                                复利已收:{{$item->benefit }}<br/>
                                                @endif
                                                投资收益:{{$item->shouyis }}<br/>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @if($item->sendday_count !=$item->useritem_count)
                                            <font color="#0000FF">投资中</font>
                                        @else
                                            已结束
                                        @endif
                                    </td>

                                    <td>{{$item->date}}</td>


                                    <td>


                                        <a ng-href="{{$item->url}}"  ng-bind="loan.statusText" style = "background: #3579f7;font-size:12px;padding: 3px;" class="btn invest btn-gray"  href="{{$item->url}}">查看</a>

                                    </td>
                                </tr>




                            @endforeach
                        @endif

                        </tbody>
                    </table>



                </div>
            </div>
            <div class="layui-form layui-layer-page " id="layer_pages" style="margin-left: 50px;">
                {{$list->appends([])->links('common.pagination')}}
            </div>
        </div>

    </div>


    <script id="demo" type="text/html">


        <%#  layui.each(d.data, function(index, item){ %>





        <tr class="odd gradeX" onclick="$('#sms<% item.id %>,#msg<% item.id %>').slideToggle(2);">
            <td><% item.title %>
                <div height="34" style="display:none; width: 98%; height: auto; font-size: 12px; border: 1px dashed rgb(217, 38, 15); padding: 10px;margin: 10px 0 10px 0;
    background-color:#fffcfa;"  id="sms<% item.id %>">
                    <div style="width:100%; display:none;" id="msg<% item.id %>" >

                        收益率:<% item.jyrsy %>%<br/>
                        投资期限:<% item.shijian %><% item.qxdw %><br/>
                        投资金额:<% item.amount %><br/>
                        <%#  if(item.benefit > 0 ){ %>
                        复利已收:<% item.benefit %><br/>
                        <%# } %>
                        投资收益:<% item.shouyis %><br/>
                    </div>
                </div>
            </td>
            {{--<td><% item.jyrsy %>%</td>
            <td><% item.shijian %><% item.qxdw %></td>--}}
            <td>
          <%#  if(item.sendday_count!= item.useritem_count){ %>
            <font color="#0000FF">投资中</font>
            <%# }else{%>
            已结束
            <%# } %>
            </td>
            {{--<td><% item.amount %></td>
            <td><% item.shouyis %></td>--}}
            <td><% item.date %></td>


            <td>
                <%# if(item.tzzt==1){ %>
                <a ng-href="<% item.url %>"  ng-bind="loan.statusText" style = "background: #3579f7;font-size:12px;padding: 3px;" class="btn invest btn-orange" href="<% item.url %>">查看</a>

                <%# }else{%>
                <a ng-href="<% item.url %>"  ng-bind="loan.statusText" style = "background: #3579f7;font-size:12px;padding: 3px;" class="btn invest btn-gray" href="<% item.url %>">查看</a>
                    <%# } %>
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



            var url = "{{ route('user.tender') }}";




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


            /*
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
            */

            var _html='';
           var item= list.data;
            console.log(item)
                for(var i = 0; i < item.length; i++) {

                _html+='<tr class="odd gradeX" onclick="$(\'#sms'+ item[i].id +',#msg'+ item[i].id +'\').slideToggle(2);">';
                _html+='<td>'+item[i].title ;
                _html+='<div height="34" style="display:none; width: 98%; height: auto; font-size: 12px; border: 1px dashed rgb(217, 38, 15); padding: 10px;margin: 10px 0 10px 0;background-color:#fffcfa;"  id="sms'+item[i].id +'">';
                _html+='<div style="width:100%; display:none;" id="msg'+item[i].id +'" >';
                _html+='收益率:'+ item[i].jyrsy +'%<br/>';
                _html+='投资期限:'+ item[i].shijian + item[i].qxdw +'<br/>';
                _html+='投资金额:'+ item[i].amount +'<br/>';
                if(item[i].benefit>0) {
                    _html += '复利已收:' + item[i].benefit + '<br/>';
                }
                _html+='投资收益:'+ item[i].shouyis +'<br/>';
                _html+='</div>';
                _html+='</div>';
                _html+='</td>';

                _html+='<td>';
                 if(item[i].sendday_count!= item[i].useritem_count){
                _html+='<font color="#0000FF">投资中</font>';
                     }else{
                _html+='已结束';
                 }
            _html+='</td>';

            _html+=' <td>'+ item[i].date +'</td>';


            _html+=' <td>';
             if(item[i].tzzt==1){
                 _html+='<a ng-href="'+ item[i].url +'"  ng-bind="loan.statusText" style = "background: #3579f7;font-size:12px;padding: 3px;" class="btn invest btn-orange" href="'+item[i].url +'">查看</a>';

                   }else{
                 _html+='<a ng-href="'+ item[i].url +'"  ng-bind="loan.statusText" style = "background: #3579f7;font-size:12px;padding: 3px;" class="btn invest btn-gray" href="'+ item[i].url +'">查看</a>';
                     }
            _html+='</td>';
            _html+=' </tr>';
            }
                $("#view").html(_html);

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

