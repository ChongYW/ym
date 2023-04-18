@extends(env('Template').'.layouts.applists')

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
            <form class="layui-form" action="{{ route($RouteController.".lists") }}" method="get">


                <div class="layui-form-item layui-form" pane>




                    <div class="layui-input-inline">

                        <input type="text" name="s_key"  placeholder="请输入手机号" autocomplete="off" class="layui-input" value="@if(isset($_REQUEST['s_key'])){{$_REQUEST['s_key']}}@endif">

                    </div>



                    <div class="layui-input-inline">

                        <select name="s_categoryid" lay-filter="s_categoryid">
                            <option value="">选择渠道</option>
                            @if(config("coupons.channel"))
                                @foreach(config("coupons.channel") as $tk=>$v)
                                    <option value="{{$tk}}" @if(isset($_REQUEST['s_categoryid']) && $_REQUEST['s_categoryid']==$tk)selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            @endif

                        </select>


                    </div>


                    <div class="layui-input-inline">

                        <select name="s_type" lay-filter="s_type">
                            <option value="">选择类型</option>
                            @if(config("coupons.type"))
                                @foreach(config("coupons.type") as $tk=>$v)
                                    <option value="{{$tk}}" @if(isset($_REQUEST['s_type']) && $_REQUEST['s_type']==$tk)selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            @endif

                        </select>


                    </div>

                    <div class="layui-input-inline">

                        <select name="s_status" lay-filter="s_status">
                            <option value="">选择状态</option>
                            @if(config("coupons.grantstatus"))
                                @foreach(config("coupons.grantstatus") as $tk=>$v)
                                    <option value="{{$tk}}" @if(isset($_REQUEST['s_status']) && $_REQUEST['s_status']==$tk)selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            @endif

                        </select>


                    </div>



                    <div class="layui-input-inline">

                        <button class="layui-btn" lay-submit lay-filter="go">查询</button>

                    </div>

                </div>


            </form>
        </div>
        <xblock>
            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button>


        </xblock>


            <table class="layui-table x-admin layui-form">
                <colgroup>
                    <col width="50">
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <col width="200">

                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th><div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div></th>
                    <th>会员手机</th>
                    <th>商品类型</th>
                    <th>商品名称</th>
                    <th>领取渠道</th>
                    <th>领取时间</th>
                    <th>失效时间</th>
                    <th>使用状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody id="view">

                </tbody>
            </table>



        <div id="layer_pages"></div>




    </div>
@endsection
@section("layermsg")
    @parent
@endsection

@section('form')

    <script id="demo" type="text/html">


            <%#  layui.each(d.data, function(index, item){ %>

            <tr>
                <td>


                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='<% item.id %>'><i class="layui-icon">&#xe605;</i></div>
                </td>
                <td class="title_<% item.id %>"><% item.uname %></td>
                <td><% item.type==1?'现金券':'加息券' %></td>
                <td><% item.name %></td>

                <td><% item.channelName %></td>
                <td><% item.created_at %></td>
                <td><% item.exptime %></td>
                <td><% item.statusName %></td>

                <td class="td-manage">


                    <a title="删除" onclick="del(<% item.id %>,<% d.current_page %>)" href="javascript:;">
                        <i class="layui-icon">&#xe640;</i>
                    </a>
                </td>
            </tr>



            <%#  }); %>
            <%#  if(d.length === 0){ %>
            无数据
            <%#  } %>

    </script>

    <script>
        layui.use(['form'], function(){

            var form = layui.form;

            form.on('select(s_categoryid)', function(data){
                var op={
                    s_categoryid :data.value,
                    s_type :$("[name='s_type']").val(),
                    s_status :$("[name='s_status']").val(),
                    s_key :$("[name='s_key']").val(),
                }

                lists(1,op);

            });

            form.on('select(s_type)', function(data){
                var op={
                    s_type :data.value,
                    s_status :$("[name='s_status']").val(),
                    s_key :$("[name='s_key']").val(),
                    s_categoryid :$("[name='s_categoryid']").val(),
                }

                lists(1,op);

            });

            form.on('select(s_status)', function(data){
                var op={
                    s_status :data.value,
                    s_key :$("[name='s_key']").val(),
                    s_type :$("[name='s_type']").val(),
                    s_categoryid :$("[name='s_categoryid']").val(),
                }

                lists(1,op);

            });





        });
    </script>


@endsection

