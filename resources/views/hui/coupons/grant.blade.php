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
            <form class="layui-form" action="{{ route($RouteController.".grant") }}" method="get">


                <div class="layui-form-item layui-form" pane>




                    <div class="layui-input-inline">

                        <input type="text" name="s_key"  placeholder="手机号码" autocomplete="off" class="layui-input" value="@if(isset($_REQUEST['s_key'])){{$_REQUEST['s_key']}}@endif">

                    </div>



                    <div class="layui-input-inline">

                        <button class="layui-btn" lay-submit lay-filter="go">查找会员</button>

                    </div>

                </div>


            </form>

            <form class="layui-form" action="{{ route($RouteController.".grantqf") }}" method="get">


                <div class="layui-form-item layui-form" pane>



                    <div class="layui-input-inline">

                        <select name="s_type" lay-filter="s_type">
                            <option value="">会员等级</option>
                            @if($memberlevel)
                                @foreach($memberlevel as $tk=>$v)
                                    <option value="{{$tk}}" @if(isset($_REQUEST['s_type']) && $_REQUEST['s_type']==$v)selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            @endif

                        </select>


                    </div>



                    <div class="layui-input-inline">

                        <select name="cid">
                            <option value="">选择优惠券</option>
                            @if($coupons)
                                @foreach($coupons as $co)
                                    <option value="{{$co->id}}">{{$co->name}}</option>
                                @endforeach
                            @endif
                        </select>


                    </div>





                    <div class="layui-input-inline">

                        <button class="layui-btn" lay-submit lay-filter="go">群发优惠券</button>

                    </div>

                </div>


            </form>
        </div>

            <table class="layui-table x-admin layui-form">
                <colgroup>
                    <col width="50">
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <col width="200">

                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th><div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div></th>
                    <th>姓名</th>
                    <th>手机号</th>
                    <th>礼品</th>
                    <th>赠送</th>

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
                <td class="title_<% item.id %>"><% item.realname?item.realname:'' %></td>
                <td class="title_<% item.id %>"><% item.username %></td>
                <td>
                    <select name="coupons" lay-filter="coupons" class="<% item.id %>">
                        <option value="">选择优惠券</option>
                        @if($coupons)
                            @foreach($coupons as $co)
                            <option value="{{$co->id}}">{{$co->name}}</option>
                            @endforeach
                        @endif
                    </select>

                </td>
                <td><button class="layui-btn BTN<% item.id %>" onclick="grant(0,0)">赠送优惠券</button></td>


            </tr>



            <%#  }); %>
            <%#  if(d.length === 0){ %>

            <%#  } %>

    </script>

    <script>
        layui.use(['form','layer'], function(){

            var form = layui.form;
            var layer = layui.layer;


            @if(isset($_GET['msg']))
                alert('{{$_GET['msg']}}');
            @endif


            form.on('select(coupons)', function(data){

               // console.log(data.elem); //得到checkbox原始DOM对象
                console.log(data.elem.className); //得到checkbox原始DOM对象
                console.log(data.value); //得到checkbox原始DOM对象

                $(".BTN"+data.elem.className).attr({"onclick":"grant("+data.value+","+data.elem.className+")"});

            });


        });

        function grant(cid,uid) {

            if(cid==0 || uid==0){
                layer.alert('请选择优惠券再操作');
                return false;
            }

            $.ajax({
                url: "{{ route($RouteController.".grantqf") }}",
                type:"post",     //请求类型
                data:{
                    cid:cid,
                    uid:uid,
                    _token:"{{ csrf_token() }}"
                },  //请求的数据
                dataType:"json",  //数据类型
                beforeSend: function () {
                    // 禁用按钮防止重复提交，发送前响应
                    index = layer.load();

                },
                success: function(data){
                    //laravel返回的数据是不经过这里的
                    if(data.status==0){
                        layer.msg(data.msg);
                    }else{
                        layer.msg(data.msg);
                    }
                },
                complete: function () {//完成响应
                    layer.close(index);
                },
                error: function(msg) {
                    var json=JSON.parse(msg.responseText);
                    var errormsg='';
                    $.each(json,function(i,v){
                        errormsg+=' <br/>'+ v.toString();
                    } );
                    layer.alert(errormsg);

                },

            });
        }
    </script>


@endsection

