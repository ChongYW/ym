@extends('mobile.film.wap')

@section("header")
    <header class="blackHeader"><a href="javascript:history.go(-1);"><img src="{{asset("mobile/film/images/whiteBack.png")}}" class="left backImg"></a><span class="headerTitle">我的投资</span></header>

@endsection

@section("js")
    @parent


@endsection

@section("css")

    @parent
    <link rel="stylesheet" href="{{asset("js/layui/css/layui.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/app.css")}}"/>

@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')
    <?php



    $Dlist=\App\Productbuy::where("userid",$Member->id)->where("status","1")->get();
    $Ylist=\App\Productbuy::where("userid",$Member->id)->whereIn("status",["0"])->get();


    $Dmoneys=0;
    $Ymoneys=0;

    $Products= \App\Product::get();
    foreach ($Products as $Product){
        $Products[$Product->id]=$Product;
    }


    foreach ($Dlist as $item){
        //$item->rate=isset($this->Memberlevels[$item->level])?$this->Memberlevels[$item->level]->rate:'';
        if(isset($Products[$item->productid])){
            if($Products[$item->productid]->hkfs == 0){
                $moneyCount = $Products[$item->productid]->jyrsy * $item->amount/100;
                //$item->moneyCount= round($moneyCount,2);
            }else{
                $moneyCount = $Products[$item->productid]->jyrsy * $item->amount/100*($item->sendday_count-$item->useritem_count);
                //$moneyCount = $Products[$item->productid]->jyrsy * $item->amount/100*$Products[$item->productid]->shijian;
                //$item->moneyCount= round($moneyCount,2);
            }
            $Dmoneys+=$moneyCount;



        }



    }

    foreach ($Ylist as $item){
        if(isset($Products[$item->productid])){
            if($Products[$item->productid]->hkfs == 0){
                $moneyCount = $Products[$item->productid]->jyrsy * $item->amount/100;
                //$item->moneyCount= round($moneyCount,2);
            }else{
                $moneyCount = $Products[$item->productid]->jyrsy * $item->amount/100*$item->useritem_count;
                //$item->moneyCount= round($moneyCount,2);
            }

            $Ymoneys+=$moneyCount;
        }



    }


    ?>

    <div class="formGroup marginBot" style="margin-top: 50px;">
        <p class="widthBox">已收利息(元)<br>
            <span class="color" style="font-size:22px">¥<?php echo sprintf("%.2f",$Ymoneys); ?></span>
        </p>
        <p class="widthBox">待收利息(元)<br>
            <span class="color" style="font-size:22px">¥<?php echo sprintf("%.2f",$Dmoneys); ?></span>
        </p>
    </div>



    <table class="inviteTab " >
        <thead>
        <tr>

            <th width="18%">投资产品名称</th>
            <th width="8%">收益率</th>
            <th width="15%">投资期限</th>
            <th width="15%">投资状态</th>
            <th width="10%">投资金额</th>
            <th width="10%">复利已收</th>
            <th width="10%">投资收益</th>
            <th width="12%">投注时间</th>
            <th width="10%">协议</th>
        </tr>
        </thead>
        <tbody id="view">

        @if($list)
            @foreach($list as $data)
            <tr class="odd gradeX">
                <td>{{$data->title}}</td>
                <td>{{$data->jyrsy}}%</td>
                <td>{{$data->shijian}}{{$data->qxdw}}</td>
                <td>
                    @if($data->sendday_count !=$data->useritem_count)
                        <font color="#0000FF">投资中</font>
                    @else
                        已结束
                    @endif

                </td>
                <td>{{$data->amount}}</td>
                <td>{{$data->benefit}}</td>
                <td>
                    {{$data->shouyis}}

                </td>
                <td>{{$data->date}}</td>


                <td>

                        <a ng-href="{{$data->url}}"   href="{{$data->url}}">下载合同</a>



                </td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    <div class="layui-form layui-layer-page " id="layer_pages" style="margin-left: 50px;margin-top:50px;width: auto;margin-bottom:50px;">
        {{$list->appends([])->links('common.pagination')}}
    </div>

    <script id="demo" type="text/html">
        <%#  layui.each(d.data, function(index, item){ %>

        <tr class="odd gradeX">
            <td><% item.title %></td>
            <td><% item.jyrsy %>%</td>
            <td><% item.shijian %><% item.qxdw %></td>
            <td>
          <%#  if(item.sendday_count!= item.useritem_count){ %>
            <font color="#0000FF">投资中</font>
            <%# }else{%>
            已结束
            <%# } %>
            </td>
            <td><% item.amount %></td>
            <td><% item.benefit %></td>
            <td>

                <% item.shouyis %>
            </td>
            <td><% item.date %></td>


            <td>
                <%# if(item.tzzt==1){ %>
                <a ng-href="<% item.url %>"   href="<% item.url %>">下载合同</a>

                <%# }else{%>
                <a ng-href="<% item.url %>" href="<% item.url %>">下载合同</a>
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

/*

        layui.use(['laypage', 'layer', 'form'], function () {
            //var $ = layui.jquery;
            var layer = layui.layer;
            var form = layui.form;
            var laypage = layui.laypage;

            var obj={

            };
            lists(1, obj);

        });

        function pageshow(page_count, pagesize, page,op) {
            layui.use('laypage', function () {
                var laypage = layui.laypage;



                laypage.render({
                    elem: 'layer_pages'
                    , count: page_count //数据总数，从服务端得到
                    , curr: page
                    , limit: pagesize
                    ,groups:2
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


            layui.use(['laytpl', 'form'], function () {
                var laytpl = layui.laytpl;
                var form = layui.form;
                laytpl.config({
                    open: '<%',
                    close: '%>'
                });

                var getTpl = $("#demo").html();
                var view = document.getElementById('view');
                laytpl(getTpl).render(list, function (html) {
                    view.innerHTML = html;
                });


                form.render(); //更新全部

            });


        }


        /!**
         * js截取字符串，中英文都能用
         * @param str：需要截取的字符串
         * @param len: 需要截取的长度
         *!/
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



*/




    </script>


@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
    <p>
        <br/>
        <br/>
    </p>
@endsection

