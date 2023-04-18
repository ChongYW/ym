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



        <xblock>

            <div class="layui-row">
                <form class="layui-form layui-col-md12 x-so" action="{{ route($RouteController.".lists") }}" method="get">


                    <input type="text" name="s_key"  placeholder="请输入受权码" autocomplete="off" class="layui-input" value="@if(isset($_REQUEST['s_key'])){{$_REQUEST['s_key']}}@endif">


                    <div class="layui-input-inline">

                        <button class="layui-btn" lay-submit lay-filter="go">查询</button>

                    </div>
                </form>
            </div>

        </xblock>

        <table class="layui-table x-admin layui-form">
            <thead>
            <tr>
                <th>ID</th>
                <th>访问域名</th>
                <th>受权码</th>
                <th>有效期</th>
                <th>日志类型</th>
                <th>推送/请求 时间</th>
                <th width="100">消息</th>
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
                <% item.id %>
            </td>
            <td class="title_<% item.id %>"><% item.host %></td>


            <td><% item.uuid %></td>

            <td><% item.expiretime %></td>
            <td><% item.logtype %></td>
            <td><% item.gettime?'请求'+item.gettime:'' %><% item.puttime?'推送'+item.puttime:'' %></td>
            <td width="100"><% item.msg %></td>

            <td class="td-manage">

                <a title="编辑"  onclick="update(<% item.id %>,<% d.current_page %>)" href="javascript:;">
                    <i class="layui-icon">&#xe642;</i>
                </a>

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

        });



    </script>

@endsection







