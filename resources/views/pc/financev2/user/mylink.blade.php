@extends('pc.financev2.pc')

@section("header")
    @parent

@endsection

@section("js")

    @parent

@endsection

@section("css")

    @parent
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/user/user.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/user/member.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/user/public.css")}}"/>

@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')




    <div class="w1200">
        <div class="cur_pos"><a href="/"> 首页</a> &gt; <a href="{{route('user.index')}}" target="_blank">会员中心</a></div>
        <div class="noticewrapbg" style=" background-color:#FFF">
            <div class="notice">
                <div class="title" style="margin-left:10px;"><a href="#">最新公告</a></div>
                <div class="marquee" style="line-height:24px; font-size:14px; width:1000px;padding-top: 10px;">
                    <ul style="margin-top: 0px;">
                        <marquee scrolldelay="200" onmouseout="this.start()" onmouseover="this.stop()"><strong
                                    style="color: rgb(0, 0, 255); font-family: 'Microsoft YaHei', tahoma, arial, sans-serif; font-size: 18px; line-height: 27px;"> {{Cache::get('gg')}} </strong>
                        </marquee>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="wrapper">


                <div class="clearfix">


                    @include('pc.finance.user.userleft')




                    <div class="user-r white-bg bfc">
                        <div class="r-user-border white-bg bfc">
                            <h2 class="r-user-title">邀请好友</h2>
                            <div class="invite-friend">

                                <div class="inviteInput"><span class="left yqspan">您的推广ID</span><span class="yqInput"><font color="#FF0000" style="font-size:14px"><b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Member->invicode; ?></b></font></span><div class="clear"></div></div>

                                <div class="copy-link">
                                    <font color="#FF0000" style="line-height: 18px; font-family: 'Microsoft YaHei', tahoma, arial, sans-serif; font-weight: 700;">推广提示:</font>
                                    <p class="txt-tips">
                                        打开手机拍照功能对下面二维码进行拍照保存，然后把你保存在手机的二维码图片发送给你的小伙伴注册即可得到丰厚的奖励，小伙伴投资还有佣金哦！<br>
                                    </p></div>
                                <p style="margin:15px 0px;">邀请链接<br>
                                    <input size="48" value="{{route('wap.register.user',['user'=>$Member->invicode])}}" style="height: 31px;
color: black;" id="link">

                                </p>
                                <div class="layui-form-item">

                                    <button class="layui-btn layui-inline copyinvicode" style="width: 30%;margin: 0 auto;" >复制邀请链接</button>


                                </div>


                                <div class="copy-link">
                                    <p>邀请码</p><img src="{{route("user.QrCode")}}" width="300">

                                </div>


                                <h2 class="r-user-titlecc">我推荐的会员</h2>
                                <div class="table-box">
                                    <table width="100%">
                                        <tbody><tr>
                                            <th>推广会员</th>
                                            <th >下线层级</th>
                                            <th>注册时间</th>
                                        </tr>
                                        </tbody>  <tbody id="view">

                                        <tr>
                                            <td colspan="2">还没有任何推荐会员
                                            </td></tr>     </tbody></table>     </div>

                                <div id="pages" class="text-c">

                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>






    </div>

    <script>


        var copyinvicodeBtn = document.querySelector('.copyinvicode');


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
            lists(1, obj);

        });

        function pageshow(page_count, pagesize, page,op) {
            layui.use('laypage', function () {
                var laypage = layui.laypage;



                laypage.render({
                    elem: 'pages'
                    , count: page_count //数据总数，从服务端得到
                    , curr: page
                    , limit: pagesize
                    , theme: '#d11111'
                    , layout: [ 'count','prev', 'page', 'next']
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

