@extends('hui.layouts.applists')



@section('title', $title)

@section('here')

@endsection

@section('addcss')

    @parent



@endsection

@section('addjs')

    @parent



@endsection



@section('formbody')



    <div class="x-body">

        <div class="layui-row">
            <form class="layui-form layui-col-md12 x-so" action="{{ route($RouteController.".lists") }}" method="get">
                <div class="layui-input-inline">

                    <input type="text" name="s_key"  placeholder="请输入会员帐号" autocomplete="off" class="layui-input" value="@if(isset($_REQUEST['s_key'])){{$_REQUEST['s_key']}}@endif">
                    <input type="hidden" name="day"  placeholder="今日" autocomplete="off" class="layui-input day" value="@if(isset($_REQUEST['day'])){{$_REQUEST['day']}}@endif">
                </div>

                <div class="layui-form layui-input-inline">





                </div>

                <div class="layui-form layui-input-inline">
                    <select name="s_status" lay-search lay-filter="s_status" lay-search>
                        <option value="" >提款状态</option>
                        <option value="0" @if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']=='0')selected="selected" @endif>未处理</option>
                        <option value="1" @if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']=='1')selected="selected" @endif>已处理</option>
                        <option value="-1" @if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']=='-1')selected="selected" @endif>失败</option>

                    </select>



                </div>

                <div class="layui-input-inline">

                    <button class="layui-btn" lay-submit lay-filter="go">查询</button>

                </div>
            </form>
        </div>



       {{--

        <xblock>

            <button class="layui-btn" onclick="store()">
                <i class="layui-icon download">&#xe654;</i>
                充值</button>

        </xblock>

        --}}

             <table class="layui-table x-admin layui-form">



            <thead>

            <tr>
                <th>ID</th>

                <th>会员帐号</th>
                <th>银行账户</th>
                <th>金额</th>
                <th>状态</th>
                <th>申请日期</th>
                <th>备注</th>
                <th>操作</th>
            </tr>

            </thead>





            <tbody id="view">



            </tbody>
                 <tr>
                     <th colspan="3">当前总计</th>

                     <th id="pageamounts">0</th>
                     <th colspan="3">总计</th>
                     <th id="amounts">0</th>

                 </tr>

        </table>



        <div id="layer_pages"></div>



    </div>

@endsection

@section("layermsg")

    @parent

@endsection



@section('form')
    {{--//'pay_code','pay_name','pay_bank','pay_pic','pay_desc','enabled'--}}
    <script id="demo" type="text/html">



        <%#  layui.each(d.data, function(index, item){ %>

        <tr>
            <td>
                <% item.id %>
            </td>



            <%# if(item.mtype==1){ %>
            <td style="color: red;"><a href="javascript:x_admin_show('投资记录','{{route('admin.productbuy.lists')}}?s_key=<% item.username %>');" ><i class="layui-icon" style="color:red;">&#xe615;</i><% item.username %></a></td>
            <%# }else{%>
            <td><a href="javascript:x_admin_show('投资记录','{{route('admin.productbuy.lists')}}?s_key=<% item.username %>');" ><i class="layui-icon" style="color:red;">&#xe615;</i><% item.username %></a></td>
            <%# } %>



            <td>
                银行名称：<% item.bankName %> <br>
                卡/帐号：<% item.bankcode %><br>
                银行户名：<% item.bankrealname %><br>
                付款地址：<% item.bankaddress %>

            </td>

            <td><% item.amount %></td>

            <td>
                <%# if(item.status==0){ %>
                    未处理
                <%# }else if(item.status==1){ %>
                    已处理
                <%# }else if(item.status==-1){ %>
                    已取消
                <%# }%>
            </td>
            <td><% item.created_at?item.created_at:'' %></td>
            <td><% item.memo %></td>
            <td class="td-manage">
                <%# if(item.status==0 && item.sound_ignore==0){ %>
                <a title="忽略提醒" onclick="sound_ignore(<% item.id %>,<% d.current_page %>)" href="javascript:;">
                    <i class="layui-icon" style="font-size: 16px;color: red;">&#xe667;</i>
                </a>
                <%# }%>

                <%# if(item.status==0){ %>
                <a title="确认充值"  onclick="ConfirmRec(<% item.id %>,'1',<% d.current_page %>)" href="javascript:;">
                    <i class="layui-icon" style="color: green;font-size: 16px;">&#x1005;</i>
                </a>

                <a title="取消充值"  onclick="ConfirmRec(<% item.id %>,'-1',<% d.current_page %>)" href="javascript:;">
                    <i class="layui-icon" style="color: red;font-size: 16px;">&#x1007;</i>
                </a>
                <%# }%>
                <%# if(item.status==1){ %>
                <%# if(item.sendsms==0){ %>
                <a title="发送短信"  onclick="sendsms(<% item.id %>,<% d.current_page %>)" href="javascript:;">
                    <i class="layui-icon" style="color: green;font-size: 16px;">&#xe609;</i>
                </a>
                <%# }else if(item.sendsms==1){ %>
                <a title="重新发送短信"  onclick="sendsms(<% item.id %>,<% d.current_page %>)" href="javascript:;">
                    <i class="layui-icon" style="color: red;font-size: 16px;">&#xe609;</i>
                </a>
                <%# }%>
                <%# }else if(item.status==-1){%>

                <%# if(item.sendsms==0){ %>
                <a title="发送短信"  onclick="sendsms(<% item.id %>,<% d.current_page %>)" href="javascript:;">
                    <i class="layui-icon" style="color: green;font-size: 16px;">&#xe609;</i>
                </a>
                <%# }else if(item.sendsms==1){ %>
                <a title="重新发送短信"  onclick="sendsms(<% item.id %>,<% d.current_page %>)" href="javascript:;">
                    <i class="layui-icon" style="color: red;font-size: 16px;">&#xe609;</i>
                </a>
                <%# }%>

                <%# }%>
                <a title="删除" onclick="del(<% item.id %>,<% d.current_page %>)" href="javascript:;">
                    <i class="layui-icon" style="font-size: 16px;">&#xe640;</i>
                </a>
            </td>
        </tr>






        <%#  }); %>
        <%#  if(d.length === 0){ %>
        无数据
        <%#  } %>

    </script>




    <script>

        function sound_ignore(id,page){

                var msg='确认忽略提现提醒';
                layer.confirm('确定要'+msg+'?', {icon: 3, title:'提示'}, function(index){


                $.post("{{ route($RouteController.".soundignore") }}",{
                    _token:"{{ csrf_token() }}",
                    id:id,

                },function(data){



                    if(data.status==0){
                        layer.msg(data.msg,{},function(){

                            if(page>0){
                                lists(page);
                            }
                        });
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }



                });

                layer.close(index);
            });

        }

        function ConfirmRec(id,status,page){
            @if($update==1)
                var msg=status==1?'确认提现成功':'确认取消提现';
            layer.confirm('确定要'+msg+'?', {icon: 3, title:'提示'}, function(index){


                $.post("{{ route($RouteController.".update") }}",{
                    _token:"{{ csrf_token() }}",
                    id:id,
                    status:status,
                },function(data){


                    @if(Cache::has("msgshowtime"))
                    if(data.status==0){
                        layer.msg(data.msg,{time:"{{Cache::get("msgshowtime")}}" },function(){
                            $(".lists_"+id).remove();

                            if(page>0){
                                lists(page);
                            }

                        });
                    }else{
                        layer.msg(data.msg,{icon:5,time:"{{Cache::get("msgshowtime")}}"});
                    }
                    @else
                    if(data.status==0){
                        layer.msg(data.msg,{},function(){
                            $(".lists_"+id).remove();
                            if(page>0){
                                lists(page);
                            }
                        });
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }
                    @endif


                });

                layer.close(index);
            });
            @else
            layer.alert('您没有权限访问');

            @endif
        }

        function sendsms(id,page){



            layer.confirm('确定要发送短信通知?', {
                    title: '短信发送',
                    btn: ['提现模板短信', '自定义内容短信']
                },
                function(index, layero){
                    //按钮【按钮一】的回调
                    $.post("{{ route($RouteController.".sendsms") }}",{
                        _token:"{{ csrf_token() }}",
                        id:id,
                    },function(data){


                        @if(Cache::has("msgshowtime"))
                        if(data.status==0){
                            layer.msg(data.msg,{time:"{{Cache::get("msgshowtime")}}" },function(){
                                $(".lists_"+id).remove();

                                if(page>0){
                                    lists(page);
                                }

                            });
                        }else{
                            layer.msg(data.msg,{icon:5,time:"{{Cache::get("msgshowtime")}}"});
                        }
                        @else
                        if(data.status==0){
                            layer.msg(data.msg,{},function(){
                                $(".lists_"+id).remove();
                                if(page>0){
                                    lists(page);
                                }
                            });
                        }else{
                            layer.msg(data.msg,{icon:5});
                        }
                        @endif


                    });


                },
                function(index){
                    //按钮【按钮二】的回调
                    //多行文本
                    layer.prompt({
                        formType: 2,
                        value: '请输入短信内容',
                        title: '请输入短信内容',
                        area: ['400px', '200px'] //自定义文本域宽高
                    }, function(value, index, elem){
                        //alert(value); //得到value

                        $.post("{{ route($RouteController.".sendsms") }}",{
                            _token:"{{ csrf_token() }}",
                            id:id,
                            contents:value,
                        },function(data){


                            @if(Cache::has("msgshowtime"))
                            if(data.status==0){
                                layer.msg(data.msg,{time:"{{Cache::get("msgshowtime")}}" },function(){
                                    $(".lists_"+id).remove();

                                    if(page>0){
                                        lists(page);
                                    }

                                });
                            }else{
                                layer.msg(data.msg,{icon:5,time:"{{Cache::get("msgshowtime")}}"});
                            }
                            @else
                            if(data.status==0){
                                layer.msg(data.msg,{},function(){
                                    $(".lists_"+id).remove();
                                    if(page>0){
                                        lists(page);
                                    }
                                });
                            }else{
                                layer.msg(data.msg,{icon:5});
                            }
                            @endif


                        });


                        layer.close(index);
                    });
                });




        }




        /*

        function sendsms(id,page){


            layer.confirm('确定要发送短信通知?', {icon: 3, title:'提示'}, function(index){


                $.post("{{ route($RouteController.".sendsms") }}",{
                    _token:"{{ csrf_token() }}",
                    id:id,
                },function(data){


                    @if(Cache::has("msgshowtime"))
                    if(data.status==0){
                        layer.msg(data.msg,{time:"{{Cache::get("msgshowtime")}}" },function(){
                            $(".lists_"+id).remove();

                            if(page>0){
                                lists(page);
                            }

                        });
                    }else{
                        layer.msg(data.msg,{icon:5,time:"{{Cache::get("msgshowtime")}}"});
                    }
                    @else
                    if(data.status==0){
                        layer.msg(data.msg,{},function(){
                            $(".lists_"+id).remove();
                            if(page>0){
                                lists(page);
                            }
                        });
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }
                    @endif


                });

                layer.close(index);
            });

        }

*/

        layui.use(['form'], function(){

        var form = layui.form;
            form.on('select(category_id)', function(data){

                var obj={
                    s_categoryid:data.value,
                    s_status:$("[name='moneylog_status']").val(),
                    s_key:$("[name='s_key']").val(),
                };
                lists(1,obj);
            });

            form.on('select(s_status)', function(data){

                var obj={
                    s_status:data.value,
                    s_categoryid:$("[name='category_id']").val(),
                    s_key:$("[name='s_key']").val(),
                };
                lists(1,obj);
            });

        });



    </script>

@endsection



