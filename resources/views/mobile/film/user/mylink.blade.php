@extends('mobile.film.wap')

@section("header")
    <header class="blackHeader"><a href="javascript:history.go(-1);"><img src="{{asset("mobile/film/images/whiteBack.png")}}" class="left backImg"></a><span class="headerTitle">我的推广</span></header>

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

@endsection

@section('body')


    <div class="myinfo" style=" margin-bottom: 15px;background:#fff;padding: 5px;margin-top: 50px;">
        <p align="center" ; style="font-size: 16px;color:#3579f7 ;margin:5px 0px;">您的推广ID</p>
        <p align="center" ; style="font-size: 14px;color:#3579f7;margin:5px 0px; "><?php echo $Member->invicode; ?></p>
        <p style="margin:15px 0px;">1、尊敬的<?php echo \Cache::get('CompanyShort'); ?>
            会员，以下是您在<?php echo \Cache::get('CompanyShort'); ?>的邀请链接。<br>
            <input size="48" value="{{route('wap.register.user',['user'=>$Member->invicode])}}" style="height: 31px;
color: black;" id="link">

        </p>
        <div class="layui-form-item">

            <button class="layui-btn layui-inline copyinvicode" style="width: 80%;margin: 0 auto;" >复制邀请链接</button>


        </div>


        <p >2、二维码复制给好友，扫一扫进行推荐</p>
        <p id="codebg" style="background-image: url('{{route("user.QrCode")}}');-moz-background-size:100% 100%; background-size:100% 100%;width:60%;margin-left: 20%;">


        </p>




        <div class="layui-form-item">

            <button class="layui-btn layui-inline copy" style="width: 80%;margin: 0 auto;" >复制推广ID</button>


        </div>

        <div class="layui-form-item">

            <a class="layui-btn layui-inline" style="width: 80%;margin: 0 auto;" href="{{route("user.QrCode")}}" >存为图片</a>

        </div>


        <p>邀请有好礼！</p>
        <p>
            您可以通过QQ、微信，微博，邮件等方式把推荐注册链接发送给您的好友，成功注册并充值投资，您将获得此好友投资项目金额1%-5%的奖金（根据不同的项目有不同的返佣金额），奖金详细和比例请您查看各项目的详细说明。用户不得自己推荐自己如发现将冻结用户非法获得的佣金。</p>
    </div>



{{--
    <div class="tuijianbg" style="">
        <p class="f14 ">
        </p><div align="center">

            <br><br>
            <br><br>
            <img src="{{route("user.QrCodeBg")}}" width="100%">
        </div><p></p>
    </div>
--}}


    <script>

        var copyBtn = document.querySelector('.copy');
        var copyinvicodeBtn = document.querySelector('.copyinvicode');

        // 点击的时候调用 copyTextToClipboard() 方法就好了.
        copyBtn.onclick = function() {
            copyTextToClipboard('<?php echo $Member->invicode; ?>')
        };
        // 点击的时候调用 copyTextToClipboard() 方法就好了.
        copyinvicodeBtn.onclick = function() {
            copyTextToClipboard('{{route('wap.register.user',['user'=>$Member->invicode])}}')
        };

        function copyTextToClipboard(text) {
            var textArea = document.createElement("textarea")

            textArea.style.position = 'fixed'
            textArea.style.top = 0
            textArea.style.left = 0
            textArea.style.width = '2em'
            textArea.style.height = '2em'
            textArea.style.padding = 0
            textArea.style.border = 'none'
            textArea.style.outline = 'none'
            textArea.style.boxShadow = 'none'
            textArea.style.background = 'transparent'
            textArea.value = text

            document.body.appendChild(textArea)

            textArea.select()

            try {
                var msg = document.execCommand('copy') ? '成功' : '失败'
                alert('复制内容 ' + msg);
            } catch (err) {
                alert('不能使用这种方法复制内容');
            }

            document.body.removeChild(textArea)
        }

    </script>
    <script>
        var width= window.screen.width;
        $("#codebg").height(width*0.6);

    </script>


    <div class="inviteInput"><span class="left">我推荐的会员：</span><div class="clear"></div></div>

    <table class="inviteTab" border="0" cellspacing="0" cellpadding="0">
        <tbody>
        <tr class="tabTitle"><th>我的推荐码：<?php echo $Member->invicode; ?></th></tr>

        </tbody>
    </table>




    <table class="inviteTab" border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th width="20%">下线会员账号</th>
            <th width="20%">下线层级</th>
            <th width="20%">注册时间</th>

        </tr>
        </thead>
        <tbody id="view">


        @if($list)
            @foreach($list as $item)

                <tr class="odd gradeX" >
                    <td>{{$item->username?$item->username:''}}</td>
                    <td>{{$item->cenji?$item->cenji:'' }}</td>
                    <td>{{$item->date?$item->date:''}}</td>

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

        <tr class="odd gradeX" >
            <td><% item.username?item.username:'' %></td>
            <td><% item.cenji?item.cenji:'' %></td>
            <td><% item.date?item.date:'' %></td>

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



            var url = "{{ route('user.record') }}";




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

