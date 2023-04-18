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

            <button class="layui-btn" onclick="store()">
                <i class="layui-icon download">&#xe654;</i>
                添加</button>
            </div>
            </xblock>
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
                <th>名称</th>
                <th>受权码</th>
                <th>有效期</th>
                <th>类型</th>
                <th>受权域名</th>
                <th title="最后请求UUID的域名地址">运行域名</th>
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
            <td class="title_<% item.id %>"><% item.name %></td>


            <td><% item.uuid %></td>

            <td><% item.expiretime %></td>
            <td><% item.type %></td>
            <td><% item.domains %></td>
            <td><% item.runhost %></td>

            <td class="td-manage">

                <a title="重置"  onclick="resetuuid(<% item.id %>,<% d.current_page %>)" href="javascript:;">
                    <i class="layui-icon">&#xe9aa;</i>
                </a>

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

        function resetuuid(id){


            layer.confirm('确定要重置 '+$(".title_"+id).text()+' 的UUID 受权码?', {icon: 3, title:'提示'}, function(index){


                $.post("{{ route($RouteController.".resetuuid") }}",{
                    _token:"{{ csrf_token() }}",
                    id:id
                },function(data){
                    if(data.status==0){
                        layer.msg(data.msg,{},function(){

                        });
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }
                });

                layer.close(index);
            });

        }

        layui.use(['form'], function(){

            var form = layui.form;

        });



    </script>

@endsection







