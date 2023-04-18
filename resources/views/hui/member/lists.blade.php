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
            <form class="layui-form layui-col-md12 x-so" action="{{ route($RouteController.".lists") }}" method="get">
               <input class="layui-input"  autocomplete="off" placeholder="开始日" name="date_s" id="date_s" value="@if(isset($_REQUEST['date_s'])){{$_REQUEST['date_s']}}@endif">
                <input class="layui-input"  autocomplete="off" placeholder="截止日" name="date_e" id="date_e" value="@if(isset($_REQUEST['date_e'])){{$_REQUEST['date_e']}}@endif">

                <input type="text" name="s_key"  placeholder="请输入用户名" autocomplete="off" class="layui-input s_key" value="@if(isset($_REQUEST['s_key'])){{$_REQUEST['s_key']}}@endif">
                <input type="text" name="s_inviter"  placeholder="请输入邀请人ID" autocomplete="off" class="layui-input s_inviter" value="@if(isset($_REQUEST['s_inviter'])){{$_REQUEST['s_inviter']}}@endif">

                <input type="hidden" name="s_status"  placeholder="" autocomplete="off" class="layui-input s_status" value="@if(isset($_REQUEST['s_status'])){{$_REQUEST['s_status']}}@endif">
                <input type="hidden" name="day"  placeholder="今日" autocomplete="off" class="layui-input day" value="@if(isset($_REQUEST['day'])){{$_REQUEST['day']}}@endif">

                <div class="layui-input-inline">

                    <select name="s_categoryid" lay-filter="s_categoryid">
                        <option value="">会员等级</option>
                        @if($memberlevel)
                            @foreach($memberlevel as $level)
                                <option value="{{$level->id}}" @if(isset($_REQUEST['s_categoryid']) && $_REQUEST['s_categoryid']==$level->id) selected="selected" @endif>{{$level->name}}</option>


                            @endforeach
                        @endif
                    </select>

                </div>

                <div class="layui-input-inline">

                    <select name="s_mtype" lay-filter="s_mtype">

                        <option value="" @if(isset($_REQUEST['s_mtype']) && $_REQUEST['s_mtype']=='') selected="selected" @endif>会员身份</option>
                        <option value="0" @if(isset($_REQUEST['s_mtype']) && $_REQUEST['s_mtype'] !='' && $_REQUEST['s_mtype']==0) selected="selected" @endif>普通会员</option>
                        <option value="1" @if(isset($_REQUEST['s_mtype']) && $_REQUEST['s_mtype']==1) selected="selected" @endif>业务员</option>



                    </select>

                </div>

                <div class="layui-input-inline">

                    <button class="layui-btn" lay-submit lay-filter="go">查询</button>

                </div>





            </form>
        </div>
        <xblock>
            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button>
            <button class="layui-btn" onclick="store()">
                <i class="layui-icon download">&#xe654;</i>
                添加</button>

        </xblock>


            <table class="layui-table x-admin layui-form">
                <colgroup>
                    <col width="150">
                    {{--<col width="200">
                    <col width="200">
                    <col width="200">--}}
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    {{--<col width="200">
                    <col width="200">--}}
                    {{--<col width="200">--}}
                    <col width="200">
                    <col width="200">
                    <col width="200">
                    <col width="300">
                    <col width="300">
                    <col width="200">
                    <col width="300">
                    <col width="200">


                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th><div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div></th>
                    {{--<th>在线状态</th>--}}
                    <th>推荐号</th>
                    {{--<th>账号</th>--}}
                    <th>用户级别</th>
                    <th>姓名</th>
                  {{--  <th>银行卡号</th>
                    <th>开户行</th>--}}
                    <th>手机</th>
                    <th>余额</th>
                    <th>积分</th>
                    {{--<th>冻结</th>--}}
                    <th>推荐人</th>
                    <th>注册域名</th>

                    <th>下线统计</th>
                    <th>会员统计</th>
                    <th>会员备注</th>
                    <th>注册时间/IP</th>
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
            <%# if(item.mtype==1){ %>
            <tr style="color: red;">
            <%# }else{%>
            <tr>
            <%# } %>
                <td>
                    <% item.id %>

                    <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='<% item.id %>'><i class="layui-icon">&#xe605;</i></div>
                </td>
               {{-- <td <% item.online=='在线'?'style="color: green;"':'' %>><% item.online?item.online:'' %></td>--}}
                <td ><% item.invicode?item.invicode:'' %></td>
                {{--<td class="title_<% item.id %>"><% item.username %></td>--}}
                <td><% item.levelName %></td>
                {{--<td><% item.realname?item.realname:'' %></td>
                <td><% item.bankcode?item.bankcode:'' %></td>--}}
                <td><% item.realname?item.realname:'' %></td>
                <td><% item.Showmobile?item.Showmobile:'' %></td>
                <td><% item.amount?item.amount:'0' %></td>
                <td><% item.integral?item.integral:'0' %></td>

                {{--<td><% item.is_dongjie %></td>--}}
                <td><a href="javascript:;" onclick="$('.s_inviter').val('<% item.inviter %>');lists(1,{s_inviter:'<% item.inviter %>'})"> <% item.inviter?item.inviter:'' %></a><a href="javascript:;" onclick="$('.s_key').val('<% item.inviterName %>');lists(1,{s_key:'<% item.inviterName %>'})"><% item.inviterName?' <br/>'+item.inviterName:'' %></a></td>
                <td><% item.sourcedomain?item.sourcedomain:'' %><% item.reg_from?'<br/>'+item.reg_from:'' %></td>
                <td>
                    <a href="javascript:x_admin_show('推广结构','{{route('admin.member.tree')}}?invicode=<% item.invicode %>');" style="color: #ff19ee"> 推广人数:<% item.tuiguangrens %></a> <br/>
                    充值总额:<span style="color: #00a91c"><% item.recharges %></span><br/>
                    提现总额:<span style="color: #ff19ee"><% item.withdrawals %></span><br/>
                    <%# if(item.moneys>0){ %>
                        收益总额:<span style="color: #09ff09"><% item.moneys %></span>
                    <%# }else{%>
                        收益总额:<span style="color: #ff0000"><% item.moneys %></span>
                    <%# } %>

                </td>
                <td>
                    充值:<span style="color: #00a91c"><% item.urecharges %></span><br/>
                    提现:<span style="color: #ff19ee"><% item.uwithdrawals %></span><br/>
                    <%# if(item.umoneys>0){ %>
                    收益:<span style="color: #09ff09"><% item.umoneys %></span>
                    <%# }else{%>
                    收益:<span style="color: #ff0000"><% item.umoneys %></span>
                    <%# } %>
                </td>
                <td>
                    <% item.remarks?item.remarks:'' %>
                </td>
                <td>
                    注册时间:<br/><% item.created_at %><br/>最近操作:<br/><% item.updated_at %>
                    <br/>
                    IP:<br/><% item.ip %><hr><% item.ipinfo?item.ipinfo:'' %>

                </td>

                <td class="td-manage" style="width:200px;">
                    <a onclick="member_stop(this,<% item.id %>,<% d.current_page %>)" href="javascript:;"  title="<% item.state==0?'启用':'禁用' %>">

                            <%# if(item.state==1){ %>
                        <i class="layui-icon" style="color:green;">&#xe62f;</i>
                            <%# }else{%>
                        <i class="layui-icon" style="color:red;">&#xe601;</i>
                            <%# } %>


                    </a>


                    <a onclick="member_locking(this,<% item.id %>,<% d.current_page %>)" href="javascript:;"  title="<% item.locking==1?'解锁':'锁定' %>">

                            <%# if(item.locking==1){ %>
                        <i class="layui-icon" style="color:red;">&#xe673;</i>
                            <%# }else{%>
                        <i class="layui-icon" style="color:green;">&#xe672;</i>
                            <%# } %>


                    </a>


                    <a title="查看密码"  onclick="showpassword('<% item.Showpassword %>','<% item.Showpaypwd %>')" href="javascript:;">
                        <i class="layui-icon" style="color:red;">&#xe615;</i>
                    </a>


                    <a title="资金操作"  onclick="moneys(<% item.id %>,<% d.current_page %>)" href="javascript:;">
                        <i class="layui-icon" style="color:green;">&#xe65e;</i>
                    </a>

                    <a title="冻结解冻"  onclick="frozen(<% item.id %>,<% d.current_page %>)" href="javascript:;">
                        <i class="layui-icon" style="color: red;">&#xe659;</i>
                    </a>


                    <a title="编辑"  onclick="update(<% item.id %>,<% d.current_page %>)" href="javascript:;">
                        <i class="layui-icon" >&#xe642;</i>
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


function showpassword(pwd,paypwd){
    var msg='登录密码:'+pwd+'\r\n'+'支付密码:'+paypwd;
    layer.alert(msg,{title:'密码信息'});
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

    });

    /*用户-停用*/
    function member_stop(obj,id,page){
        layer.confirm('确认要'+$(obj).attr('title')+'吗？',function(index){

            if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

            }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 1,time:1000});
            }

            switchings(id,obj,page);

        });
    }

    /*用户-停用*/
    function member_locking(obj,id,page){
        layer.confirm('确认要'+$(obj).attr('title')+'吗？',function(index){

            if($(obj).attr('title')=='已锁定'){

                //发异步把用户状态进行更改
                $(obj).attr('title','锁定')
                /$(obj).find('i').html('&#xe672;');

                //$(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已锁定');
                layer.msg('已锁定!',{icon: 5,time:1000});

            }else{
                $(obj).attr('title','解锁')
                //$(obj).find('i').html('&#xe673;');

                //$(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已解锁');
                layer.msg('已解锁!',{icon: 1,time:1000});
            }

            switchings(id,obj,page,'locking');

        });
    }


    function switchings(id,obj,page,atc='state'){

        var index;
        $.ajax({
            url: "{{ route($RouteController.".switch") }}",
            type:"post",     //请求类型
            data:{
                id:id,
                atc:atc,
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
                    layer.close(index);
                    lists(page);
                }
            },
            complete: function () {//完成响应

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


    function moneys(id,obj,page){


        var index=   layer.open({
            title:'{{$title}}',
            type: 2,
            fixed: false,
            maxmin: true,
            area: ['95%', '95%'],
            btn:['提交','取消'],
            yes:function(index,layero){
                var ifname="layui-layer-iframe"+index;
                var Ifame=window.frames[ifname];
                var FormBtn=eval(Ifame.document.getElementById("layui-btn"));
                FormBtn.click();
            },
            content: ['{{ route($RouteController.".moneys")}}?id='+id,'yes'],
            end: function () {
                lists(1);

            },
            error: function(msg) {
                var json=JSON.parse(msg.responseText);
                var errormsg='';
                $.each(json,function(i,v){
                    errormsg+=' <br/>'+ v.toString();
                } );
                layer.alert(errormsg);

            }
        });


    }
    function frozen(id,obj,page){


        var index=   layer.open({
            title:'{{$title}}',
            type: 2,
            fixed: false,
            maxmin: true,
            area: ['95%', '95%'],
            btn:['提交','取消'],
            yes:function(index,layero){
                var ifname="layui-layer-iframe"+index;
                var Ifame=window.frames[ifname];
                var FormBtn=eval(Ifame.document.getElementById("layui-btn"));
                FormBtn.click();
            },
            content: ['{{ route($RouteController.".frozen")}}?id='+id,'yes'],
            end: function () {
                lists(1);

            },
            error: function(msg) {
                var json=JSON.parse(msg.responseText);
                var errormsg='';
                $.each(json,function(i,v){
                    errormsg+=' <br/>'+ v.toString();
                } );
                layer.alert(errormsg);

            }
        });


    }


    </script>
@endsection

