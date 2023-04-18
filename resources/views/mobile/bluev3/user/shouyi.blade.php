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


    <?php

/*

    $Dlist=\App\Productbuy::where("userid",$Member->id)->where("status","1")->get();
    $Ylist=\App\Productbuy::where("userid",$Member->id)->whereIn("status",["0","1"])->get();


    $Dmoneys=0;
    $Ymoneys=0;

    $Products= \App\Product::get();
    foreach ($Products as $Product){
        $Products[$Product->id]=$Product;
    }


    foreach ($Dlist as $item){

        if(isset($Products[$item->productid])){
            if($Products[$item->productid]->hkfs == 0){
                $moneyCount = $Products[$item->productid]->jyrsy * $item->amount/100;

            }else{
                $moneyCount = $Products[$item->productid]->jyrsy * $item->amount/100*($item->sendday_count-$item->useritem_count);

            }
            $Dmoneys+=$moneyCount;

        }
    }

    foreach ($Ylist as $item){
        if(isset($Products[$item->productid])){
            if($Products[$item->productid]->hkfs == 0){
                $moneyCount = $Products[$item->productid]->jyrsy * $item->amount/100;

            }else{
                $moneyCount = $Products[$item->productid]->jyrsy * $item->amount/100*$item->useritem_count;

            }

            $Ymoneys+=$moneyCount;
        }



    }*/


    ?>


    <div class="othertop">
        <a class="goback" href="{{route('user.index')}}"><img src="{{asset("mobile/bluev3/img/goback.png")}}" style="margin: 0px;"/></a>
        <div class="othertop-font">
            @if($id==1)
                {{$htitle='收益记录'}}
            @endif

            @if($id==2)
                {{$htitle='加入项目本金'}}
            @endif

            @if($id==3)
                {{$htitle='项目本金返款'}}
            @endif

            @if($id=="all")
                {{$htitle='资金流水记录'}}
            @endif
        </div>
    </div>
    <div class="header-nbsp"></div>

    <div class="record_outer">

        <table class="inviteTab ">
            <thead>
            <tr>

                <th>说明</th>
                <th>金额</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody id="view">

            @if($list)
                @foreach($list as $item)

                    <tr class="odd gradeX" >


                        <td>
                            {{$item->moneylog_notice}}

                        </td>
                        @if($item->moneylog_status=='+')
                            <td class="center" ><font color="#00A11D">{{$item->moneylog_status}}{{$item->moneylog_money}}</font></td>
                        @else
                            <td class="center" ><font color="#ff0000">{{$item->moneylog_status}}{{$item->moneylog_money}} </font></td>
                        @endif

                        <td>{{$item->date}}</td>
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




    <script id="demo" type="text/html">


        <%#  layui.each(d.data, function(index, item){ %>

        <tr class="odd gradeX" >


            <td>
                <% item.moneylog_notice %>

            </td>
            <%# if(item.moneylog_status=='+'){ %>
            <td class="center" ><font color="#00A11D"><% item.moneylog_status %><% item.moneylog_money %> </font></td>
            <%# }else{ %>
            <td class="center" ><font color="#ff0000"><% item.moneylog_status %><% item.moneylog_money %> </font></td>
            <%# } %>

            <td><% item.date %></td>
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
          //  lists(1, obj);

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
                    , layout: [ 'count','prev','curr','next']
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



            var url = "{{ route('user.shouyi',["id"=>$id]) }}";




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

