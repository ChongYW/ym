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
                    <input class="layui-input"  autocomplete="off" placeholder="开始日" name="date_s" id="date_s" value="@if(isset($_REQUEST['date_s'])){{$_REQUEST['date_s']}}@endif">
                    <input class="layui-input"  autocomplete="off" placeholder="截止日" name="date_e" id="date_e" value="@if(isset($_REQUEST['date_e'])){{$_REQUEST['date_e']}}@endif">

                    <input type="text" name="s_key"  placeholder="请输入会员帐号" autocomplete="off" class="layui-input s_key" value="@if(isset($_REQUEST['s_key'])){{$_REQUEST['s_key']}}@endif">
                    <input type="hidden" name="day"  placeholder="今日" autocomplete="off" class="layui-input day" value="@if(isset($_REQUEST['day'])){{$_REQUEST['day']}}@endif">
                </div>

                <div class="layui-form layui-input-inline">





                </div>

                <div class="layui-form layui-input-inline">
                    <select name="s_status" lay-search lay-filter="s_status" lay-search>
                        <option value="" >投资状态</option>
                        <option value="0" @if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']=='0')selected="selected" @endif>已结束</option>
                        <option value="1" @if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']=='1')selected="selected" @endif>进行中</option>
                        <option value="2" @if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']=='2')selected="selected" @endif>明日到期</option>


                    </select>



                </div>

                <div class="layui-input-inline">

                    <button class="layui-btn" lay-submit lay-filter="go">查询</button>

                </div>

                <div class="layui-input-inline">

                    <a class="layui-btn" onclick="ConfirmFenHongAll()">一键反佣</a>

                </div>
            </form>
        </div>




             <table class="layui-table x-admin layui-form">



            <thead>

            <tr>
                <th>ID</th>

                <th>会员帐号</th>
                <th>姓名</th>
                <th>项目名称</th>
                <th>投资金额</th>
                <th>加入时间</th>
                <th>下一次返款时间</th>
                <th>已经领取次数</th>
                <th>可领取次数</th>
                <th>返款金额</th>
                <th>复利金额</th>
                <th>会员奖励</th>
                <th>系统时间</th>
                <th>操作</th>
            </tr>

            </thead>





            <tbody id="view">



            </tbody>

        </table>



        <div id="layer_pages"></div>



    </div>
<input name="s_categoryid" type="hidden" class="s_categoryid">
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





            <td onclick=""><a href="javascript:void(0);" onclick="$('.s_key').val('<% item.username %>');lists(1,{s_key:'<% item.username %>'})"> <% item.username %></a></td>
            <td ><a href="javascript:void(0);" > <% item.realname %></a></td>

            <td>

                <a href="javascript:void(0);" onclick="$('.s_categoryid').val('<% item.productid %>');lists(1,{s_categoryid:'<% item.productid %>'})"> <% item.product %></a>
            </td>

            <td><% item.amount %></td>
            <td><% item.useritem_time %></td>
            <td><% item.useritem_time2?item.useritem_time2:'' %></td>
            <td><% item.useritem_count %></td>
            <td><% item.sendday_count %></td>
            <td><% item.moneyCount %></td>
            <td><% item.benefit %>/<% item.Benefits %></td>
            <td><% item.elseMoney %></td>

            <td>
                <%# if(item.useritem_count>=item.sendday_count){ %>
                    已经结束
                <%# }else if(item.status==1){ %>


                <% item.timenow %>

                <%# }%>
            </td>

            <td class="td-manage">
                <%# if(item.fh==1){ %>
                <a title="一键分红"  onclick="ConfirmFenHong(<% item.id %>,'1',<% d.current_page %>)" href="javascript:;">
                    <i class="layui-icon" style="color: green;font-size: 16px;">&#x1005;</i>
                </a>

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

        function ConfirmFenHong(id,status,page){

                $.post("{{ route("bonus") }}",{
                    _token:"{{ csrf_token() }}",
                    id:id,
                },function(data){
                        layer.msg(data.msg,{},function(){
                            if(data.status==0) {
                                lists(page);
                            }
                        });
                });
        }


        function ConfirmFenHongAll(){

                $.post("{{ route("bonus") }}",{
                    _token:"{{ csrf_token() }}",
                },function(data){
                        layer.msg(data.msg,{},function(){
                            if(data.status==0) {
                                lists(1);
                            }
                        });
                });
        }






        layui.use(['form','laydate'], function(){
            var form = layui.form;
            form.on('select(s_categoryid)', function(data){
                lists(1,{s_categoryid:data.value});
            });

            form.on('select(s_mtype)', function(data){
                lists(1,{s_mtype:data.value});
            });



            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#date_s' //指定元素
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#date_e' //指定元素
            });

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



