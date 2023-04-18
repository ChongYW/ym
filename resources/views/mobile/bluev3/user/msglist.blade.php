@extends('mobile.bluev3.wap')

@section("header")

@endsection

@section("js")
    @parent


@endsection

@section("css")

    @parent

    <link rel="stylesheet" href="{{asset("css/app.css")}}"/>
@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')



    <div class="othertop">
        <a class="goback" href="{{route('user.index')}}"><img src="{{asset("mobile/bluev3/img/goback.png")}}" style="margin: 0px;"/></a>
        <div class="othertop-font">站内消息</div>
    </div>
    <div class="header-nbsp"></div>
    <div class="record_outer">
        <table>
            <thead>
            <tr>
                <th><img src="{{asset("mobile/public/Front/user/xf1.jpg")}}"></th>
                <th>标题</th>
                <th>时间</th>
                <th>状态</th>
                <th>删除</th>
            </tr>
            </thead>
            <tbody id="view">

            @if($list)
                @foreach($list as $item)

                    <tr >
                        <td onclick="$('#sms{{$item->id}},#msg{{$item->id}}').slideToggle(2);user_msg('{{$item->id}}');">{{$item->id}}</td>
                        <td onclick="$('#sms{{$item->id}},#msg{{$item->id}}').slideToggle(2);user_msg('{{$item->id}}');"><img src="{{asset("mobile/public/Front/user/read.jpg")}}"> {{$item->title}}

                            <div height="34" style="display:none; width: 98%; height: auto; font-size: 12px; border: 1px dashed rgb(217, 38, 15); padding: 10px;margin: 10px 0 10px 0;
    background-color:#fffcfa;"  id="sms{{$item->id}}">
                                <div style="width:100%; display:none;" id="msg{{$item->id}}" >{{$item->content}} </div>
                            </div>
                        </td>
                        <td onclick="$('#sms{{$item->id}},#msg{{$item->id}}').slideToggle(2);user_msg('{{$item->id}}');">{{$item->date}}</td>
                        <td class="center" id="zt{{$item->id}}" onclick="$('#sms{{$item->id}},#msg{{$item->id}}').slideToggle(2);user_msg('{{$item->id}}');"><font color="{{$item->status?'#00A11D':'#ff0000'}}">{{$item->status?'已读':'未读'}} </font></td>
                        <td class="center"  id="del<% item.id %>">
                            <a href="javascript:void();" style="color: #ff0000" onclick="user_msg_del('{{$item->id}}')">删除</a>
                        </td>
                    </tr>

                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    <div style="margin:10px auto;width: 200px;">
        {{$list->appends([])->links('common.pagination')}}
    </div>


<style>


    .page-link {
        position: relative;
        display: block;
        padding: .15rem .15rem;
        margin-left: -1px;
        line-height: 1.8;
        color: #3490dc;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }

</style>



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


        function user_msg(str) {

            var url = "{{route("user.msgread")}}";
            $.post(url, {
                    "id": str,
                    "_token": "{{ csrf_token() }}"
                },
                function(data) {
                    if (data.status == 0) {
                        $("#zt" + str + "").html("<font color='#00A11D'>已读</font>");
                    }else{
                        $("#zt" + str + "").html("<font color='#00A11D'>网络异常</font>");
                    }
                });
        }


        function user_msg_del(id) {



            layer.confirm('确认要删除吗', {icon: 3, title:'提示'}, function(index){
                $.ajax({
                    url: '{{route("user.msgdel")}}',
                    type: 'post',
                    data: {"id":id,"_token":"{{ csrf_token() }}"},
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
                                    location.reload(true);
                                }

                                layer.close(index);
                            }
                        });
                    }
                });

                layer.close(index);
            });


        }




    </script>


@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

