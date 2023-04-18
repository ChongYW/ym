@extends('mobile.default.wap')

@section("header")
    @parent
    <div class="top" id="top" >
        <div class="kf">
            <p><a class="sb-back" href="javascript:history.back(-1)" title="返回"
                  style=" display: block; width: 40px;    height: 40px;
                          margin: auto; background: url('{{asset("mobile/images/arrow_left.png")}}') no-repeat 15px center;float: left;
                          background-size: auto 16px;font-weight:bold;">
                </a>
            </p>
            <div style="display: block;width:100%; position: absolute;top: 0;
     left: 0;text-align: center;  height: 40px; line-height: 40px; ">
                <a href="javascript:;" style="text-align: center;  font-size: 16px; ">{{Cache::get('CompanyLong')}}</a>
            </div>

        </div>
    </div>

    <link rel="stylesheet" href="{{asset("mobile/public/Front/css/common.css")}}" />

    <link rel="stylesheet" type="text/css" href="{{asset("mobile/public/style/css/style.css")}}"/>
    <link href="{{asset("mobile/public/Front/user/user.css")}}" type="text/css" rel="stylesheet">
    <script type="text/javascript" charset="utf-8" src="{{asset("mobile/public/Front/user/user.js").'?t='.time()}}"></script>

@endsection

@section("js")
    @parent

     <script type="text/javascript" src="{{ asset("admin/lib/layui/layui.js")}}" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset("admin/lib/layui/css/layui.css")}}"/>
@endsection

@section("css")

    @parent


@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')

    <div class="user_zx_right" >
        <div class="box" style="margin-top: 50px">
            <div class="tagMenu">
                <ul class="menu">
                    <li class="current"><a href="{{route("user.my")}}">我的首页</a></li>
                    <li><a href="{{route("user.shouyi",["id"=>"1"])}}">收益明细</a></li>
                    <li><a href="{{route("user.moneylog")}}">资金统计</a></li>
                </ul>
                <div class="hite"> <span id="account"></span> </div>
            </div>
        </div>
<?php

        $withdrawals= \App\Memberwithdrawal::where("userid",$Member->id)->where("status","0")->sum("amount");
        //总投资额
        $buyamounts=  \App\Productbuy::where("userid",$Member->id)->sum("amount");
        $recharges= \App\Memberrecharge::where("userid",$Member->id)->where("status","1")->sum("amount");
        $youhui= \App\Memberrecharge::where("userid",$Member->id)->where("status","1")->where("type","优惠活动")->sum("amount");

        $youhui

?>

        <div class="myinfo" style="padding: 0px 5px; margin-bottom: 15px;background:#fff;">
            <table border="0" style="background:#fff;height: 310px;" width="100%" id="table2" cellspacing="0" cellpadding="0" height="125">
                <tbody><tr>

                    <td height="160" colspan="2" width="100%" style="float: left;padding: 10px;">
                        <p>昵称：<?php echo $Member->username; ?></p>
                        <p>手机：<?php  echo \App\Member::half_replace(\App\Member::DecryptPassWord($Member->mobile));?></p>
                        <p><?php echo $Member->realname; ?>欢迎您！<?php echo $memberlevelName[$Member->level]; ?></p>
                        <p>账户余额：<span style="color:#f13131;font-size:14px; font-weight--:bold;"><?php echo $Member->amount; ?></span> 元
                            <?php if($withdrawals>0){  echo '(在提资金：'.$withdrawals.')';  }?> </p>

                        <p>投资金额：<span style="color:#f13131;font-size:14px; font-weight--:bold;"><?php echo $buyamounts?$buyamounts:0; ?></span> 元</p>
                        <p>注册时间：<?php echo $Member->created_at; ?> </p>
                        <p>最后登录时间：<?php echo \Session("Member")->logintime; ?></p></td>
                </tr>
                <div class="blank"></div>
                <tr>


                    <td width="250" colspan="2" align="center" style="float: left;margin:0px  10px;"><a href="{{route("user.recharge")}}">
                            <div class=" pic_chongzhi2">充值</div></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{route("user.withdraw")}}"><div class=" pic_tixianv2">提现</div></a>

                    </td>

                </tr>
                </tbody></table>

            <table border="0" width="725" id="table1" cellspacing="0" cellpadding="0">
                <tbody><tr>
                    <td height="34"><span class="pic pic_3"></span>账户概况</td>
                </tr>
                <td bgcolor="#dddddd" height="4" width="100%"></td>
                </tbody></table>
            <table border="1" width="100%" class="zhgk">
                <tr>
                    <td style="25%">账户余额：<?php echo round($Member->amount+$Member->is_dongjie,2); ?></td>
                    <td style="25%">可用余额：<?php echo $Member->amount; ?></td>
                    <td style="25%">充值总额：<?php echo round($recharges,2); ?></td>
                    <td style="25%">优惠余额：<?php echo round($youhui,2); ?></td>
                    <td style="25%">冻结资产：<?php echo $Member->is_dongjie; ?></td>
                </tr>

            </table>

            <?php

            //总投资额
            $buyamounts=  \App\Productbuy::where("userid",$Member->id)->sum("amount");

            //已投项目
            $buycounts=  \App\Productbuy::where("userid",$Member->id)->count();

            //投资收益
            $moneylog_moneys= \App\Moneylog::where("moneylog_userid",$Member->id)->where("moneylog_type","项目分红")->sum("moneylog_money");


            //结束项目
            $buyjscounts=  \App\Productbuy::where("userid",$Member->id)->where("status","0")->count();

            $xiaxians=  \App\Member::where("inviter",$Member->invicode)->count();

            //本金回收
            $buyjsamounts=  \App\Productbuy::where("userid",$Member->id)->where("status","0")->sum("amount");




            ?>
            <table border="0" width="725" id="table1" cellspacing="0" cellpadding="0">
                <tbody><tr>
                    <td height="34"><span class="pic pic_9"></span>收益详情</td>
                </tr>
                <td bgcolor="#dddddd" height="4" width="100%"></td>
                </tbody></table>
            <table border="1" width="100%" class="zhgk">
                <tr>
                    <td style="25%">总投资额：<?php  echo round($buyamounts,2);?>元</td>
                    <td style="25%">已投项目：<?php  echo $buycounts;?>个</td>
                    <td style="25%">结束项目：<?php  echo $buyjscounts;?>个</td>
                    <td style="25%">投资收益：<?php  echo round($moneylog_moneys,2);?>元</td>
                    <td style="25%">本金回收：<?php  echo round($buyjsamounts,2);?>元</td>
                </tr>

            </table>

            <table border="0" width="725" id="table1" cellspacing="0" cellpadding="0">
                <tbody><tr>
                    <td height="34"><span class="pic pic_22"></span>安全中心</td>
                </tr>
                <td bgcolor="#dddddd" height="4" width="100%"></td>
                </tbody></table>
            <table border="1" width="100%" class="aqzx">
                <tr>
                    <td style="25%">真实姓名:<?php  if($Member->realname){ echo $Member->realname; }else{	echo '未填写';} ?></td>
                    <td style="25%">交易密码:****** <span style="color:#f13131;font-size:13px;">[<a href="{{route("user.paypwd")}}">马上修改</a>]</span> 默认与登录密码相同</td>
                </tr>


                <tr>
                    <td style="25%">密保问题：<?php  if($Member->isquestion){ echo "已设置"; }else{	echo '未设置';} ?><span style="color:#f13131;font-size:13px;">[<a href="{{route("user.security")}}">马上修改</a>]</span></td>
                    <td width="250">银行账号：
                        <?php  if($Member->isbank){ echo "已绑定"; }else{	echo '未绑定<span style="color:#f13131;font-size:13px;">[<a href="'.route("user.bank").'">马上修改</a>]</span>';} ?></td>
                </tr>

                <tr>
                    <td style="25%">手机号码：<?php  echo \App\Member::half_replace(\App\Member::DecryptPassWord($Member->mobile));?> <span style="color:#f13131;font-size:13px;">[<a href="{{route("user.phone")}}">修改并验证</a>]</span></td>
                </tr>
                <tr>
                    <td style="25%">手机认证：<img src="{{asset("mobile/public/Front/user/sj_".$Member->ismobile.".gif")}}"></td>
                </tr>
            </table>
        </div>

    </div>

{{--

    <script id="demo" type="text/html">


        <%#  layui.each(d.data, function(index, item){ %>

        <tr class="odd gradeX" >
            <td ><% item.id %></td>
            <td>
                <img src="{{asset("mobile/public/Front/user/read.jpg")}}"> <% item.memo %>

            </td>
            <td><% item.date %></td>
            <%# if(item.status==1){ %>
            <td class="center" ><font color="#00A11D"><% item.status==1?'成功':'失败' %> </font></td>
            <%# }else{ %>
            <td class="center" ><font color="#ff0000"><% item.status==1?'成功':'失败' %> </font></td>
            <%# } %>

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
                    elem: 'layer_pages'
                    , count: page_count //数据总数，从服务端得到
                    , curr: page
                    , limit: pagesize
                    , theme: '#1E9FFF'
                    , layout: [ 'prev', 'page', 'next']
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



            var url = "{{ route('user.loginloglist') }}";




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
--}}


@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

