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
    {{--<link href="/mobile/public/Front/user/user.css" type="text/css" rel="stylesheet">--}}
    <script type="text/javascript" charset="utf-8" src="{{asset("mobile/public/Front/user/user.js").'?t='.time()}}"></script>

@endsection

@section("js")


    <script src="{{asset("admin/js/jquery.min.js")}}?t=v1"></script>
     <script type="text/javascript" src="{{ asset("admin/lib/layui/layui.js")}}" charset="utf-8"></script>
    <script type="text/javascript">



        $(document).ready(function() {
                var layer;
                layui.use('layer', function () {
                    layer = layui.layer;
                });
            });
        </script>
@endsection

@section("css")

    @parent

    <style>
        .header {
            min-height--: 115px;
            max-width: 450px;
            min-width: 320px;
            margin: auto;
            padding-top: 0px;
            border-left: 0px solid #f3f3f3;
            border-right: 0px solid #f3f3f3;
            background: #D6382D;
        }

        .header .nav li a {
            display: inline-block;
            padding: 3px 8.1px;
            color: #fff;
            font-size: 15px;
        }

        .header .nav li a.on, .header .nav li a:hover {
            color: #FE943C;
            background--: #ff6600;
        }
        .header .nav li+li {
            border-left: 0px solid #f3f3f3;
        }
        .navdowna{height:97px;      text-align: center;
            padding: 20px 10px;text-align:center;    width: 99%!important;
            margin-bottom: 0px!important;
            background: #fff;
            margin: 10px auto; margin-top: 0px;
            border: 1px #ddd solid;
            clear: both;}
        .navdowna li{height:22px;line-height:22px;font-size:18px;color:#333;margin:0px auto;float:left;width:100%;}
        .navdowna .zong{color:#999;font-size:13px;}
        .navdowna .jine{color: #f13131;
            font-size: 30px;
            line-height: 30px;}

        .navdownb {
            text-align: center;
            height: 50px;
            padding: 0px 10px;
            background: #F5F5F5;
            overflow: hidden;
        }
        .navdownb .jineadd{    float: left;
            width: 50%;
            text-align: center;
            padding-bottom: 10px;
            font-size: 13px;}
        .navdownb .jineadd  .zong{color:#999;font-size:13px;}
        .navdownb .jineadd  .jine{    color: #f13131;
            font-size: 16px;}
        .navdownb .jineadd li{height:25px;line-height:25px;font-size:16px;color:#333;margin:0 auto;width:100%;padding--:10px;float:left;text-align:center}

        .btn_orange {
            background: #f60;
            /*color: #fff;*/
            float: left;
            height: 30px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: .8rem;
            width: 45%;
            text-align: center;
            line-height: 30px;
            margin-bottom: 10px;
            padding:0px;
        }
        .btn_hui {
            background: #fff;
            /*color: #0697da;*/
            border: .1rem solid #e1e1e1;
            float: right;
            height: 30px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: .8rem;
            width: 45%;
            text-align: center;
            line-height: 30px;
            margin-bottom: 10px;
            padding:0px;
        }
    </style>
@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')

    <style>
        .top{
            display:none !important;
        }
        .topadd {
            padding-top: 10px !important;
        }
    </style>
    <?php

    //总投资额
    $buyamounts=  \App\Productbuy::where("userid",$Member->id)->sum("amount");

    //已投项目
    $buycounts=  \App\Productbuy::where("userid",$Member->id)->count();






    //投资收益
    $moneylog_moneys=  \App\Moneylog::where("moneylog_userid",$Member->id)->where("moneylog_type","项目分红")->sum("moneylog_money");

    //结束项目
    $buyjscounts=  \App\Productbuy::where("userid",$Member->id)->where("status","0")->count();

    $xiaxians=  count(\App\Member::treeuid($Member->invicode));

    //本金回收
    $buyjsamounts=  \App\Productbuy::where("userid",$Member->id)->where("status","0")->sum("amount");

    $withdrawals= \App\Memberwithdrawal::where("userid",$Member->id)->where("status","0")->sum("amount");
    $recharges= \App\Memberrecharge::where("userid",$Member->id)->where("status","0")->sum("amount");

    ?>


    <div class="topadd" style="background: #3579f7;padding-top: 41px;">
        <div class="logoadd tupan">
            <span><a href="javascript:qiandao()">每日签到</a></span>
            <img style="width:50px;height:50px;" src="{{$Member->picImg}}"><font><?php echo $Member->username; ?><br />会员等级：<?php echo $memberlevelName[$Member->level]; ?></font>

        </div>

        <script>

            function qiandao() {
                var _token = $("[name='_token']").val();
                $.ajax({
                    url: '{{route('user.qiandao')}}',
                    type: 'post',
                    data: {_token:_token},
                    dataType: 'json',
                    error: function () {
                    },
                    success: function (data) {
                        layer.open({
                            content: data.msg,
                            time:2000,
                            shadeClose: false,

                        });
                    }
                });
            }

        </script>

        <div class="zichan">
            总资产(元)<font><?php echo round($Member->amount+$Member->yuamount+$Member->is_dongjie,2); ?></font>
        </div>
        <div class="yuene">
            <dl>
                <dd>
                    可用金额(元)<br /><?php echo round($Member->amount+$Member->yuamount,2); ?>
                </dd>
                <dd>
                    余额宝资产(元)<br /><?php echo $Member->yuamount; ?>
                </dd>
                <dd>
                    累计收益(元)<br /><?php echo round($moneylog_moneys,2); ?>
                </dd>
            </dl>
        </div>



    </div>


    <div class="navdownb">
        <div class="clear" style="height:10px;"></div>
        <a href="{{route("user.msglist")}}">
        <div class="btn btn_orange" style="background:#FFF">收件箱(<font id="top_msg"></font>)<font id="top_playSound"></font>
        </div>
        </a>
        <a href="{{route("user.yuamount")}}">
        <div class="btn btn_hui">
            我的余额宝
        </div>
        </a>

    </div>


    <style type="text/css">
        /*left*/
        .containers{max-width: 450px !important;min-width: 320px !important; float--: left;}
        .leftsidebar_box {
            min-width: 320px;
            max-width: 450px;
            height: auto !important;
            height: 100% !important;
            background-color: #fff;
            overflow: hidden;
        }
        .leftsidebar_box dl {
            width: 49.8%;
            height: 100px !important;
            border: 1px solid #F3F3F3;
            overflow: visible !important;
            background-color: #FFF;
            padding: 10px 0px;
            float: left;
        }

        .leftsidebar_box dt {
            text-align: center;
            color: #000;
            height: 50px;
            cursor: pointer;
            float: left;
            width: 20%;
        }

        .leftsidebar_box dd{background-color:#fff;text-align: center;width:auto;}
        .leftsidebar_box dd a{color:#666;line-height:20px;}
        .leftsidebar_box dt img {
            width: 80% !important;
            height: auto;
        }
        .system_log dt a {
            display: block;
        }
      /*
               .line--{height:2px;min-width:320px;max-width:450px;background-image--:url(/public/style/left/images/left/line_bg.png);background-repeat:repeat-x;}
       .system_log dt{background-image-:url(/public/style/left/images/left/system.png)}
        .custom dt{background-image-:url(/public/style/left/images/left/custom.png)}
        .channel dt{background-image-:url(/public/style/left/images/left/channel.png)}
        .app dt{background-image:url(/public/style/left/images/left/app.png)}
        .cloud dt{background-image-:url(/public/style/left/images/left/cloud.png)}
        .syetem_management dt{background-image-:url(/public/style/left/images/left/syetem_management.png)}
        .source dt{background-image:url(/public/style/left/images/left/source.png)}
        .statistics dt{background-image-:url(/public/style/left/images/left/statistics.png)}
        .leftsidebar_box dl dd:last-child{padding--:0px 0px;}*/

        .huiyuan {
            background: #fff;
            overflow: hidden;
            width: 100%;
        }
        .huiyuan li {
            float: left;
            width: 50%;
            height: 60px;
            line-height: 60px;
            font-size: 14px;
        }
        .huiyuan li a {
            display: block;
            border: 1px solid #efefef;
            overflow: hidden;
            height: 60px;
        }
        .huiyuan li img {
            float: left;
            width: 26px;
            margin-left: 10px;
            margin-right: 10px;
            height: 26px;
            margin-top: 18px;
        }
    </style>



    <div class="huiyuan">
        <ul>
            <li>
                <a href="{{route("user.my")}}">
                    <img src="{{asset("mobile/public/style/left/images/left/c1.png")}}">帐户详情
                </a>
            </li>

            <li>
                <a href="{{route("user.shiming")}}">
                    <img src="{{asset("mobile/public/style/left/images/left/yhk.gif")}}">@if($Member->card=='')实名认证@else认证成功@endif
                </a>
            </li>

            <li>
                <a href="{{route("user.edit")}}">
                    <img src="{{asset("mobile/public/style/left/images/left/c2.png")}}">资料修改
                </a>
            </li>
            <li>
                <a href="{{route("user.bank")}}">
                    <img src="{{asset("mobile/public/style/left/images/left/c3.png")}}">我的银行卡
                </a>
            </li>
            <li>
                <a href="{{route("user.tender")}}">
                    <img src="{{asset("mobile/public/style/left/images/left/c4.png")}}">我的投资
                </a>
            </li>




            <li>
                <a href="{{route("user.recharge")}}">
                    <img src="{{asset("mobile/public/style/left/images/left/c6.png")}}">马上充值
                </a>
            </li>
            <li>
                <a href="{{route("user.withdraw")}}">
                    <img src="{{asset("mobile/public/style/left/images/left/c7.png")}}">马上提现
                </a>
            </li>
            <li>
                <a href="{{route("user.shouyi",["id"=>"1"])}}">
                    <img src="{{asset("mobile/public/style/left/images/left/c5.png")}}">收益明细
                </a>
            </li>
            <li>
                <a href="{{route("user.mylink")}}">
                    <img src="{{asset("mobile/public/style/left/images/left/c8.png")}}">推荐好友
                </a>
            </li>
            <li>
                <a href="{{route("user.record")}}">
                    <img src="{{asset("mobile/public/style/left/images/left/c9.png")}}">
                    推广人数(<span style="color:#ff6600;font-weight:bold;">{{$xiaxians}}</span>)                  </a>
            </li>
            <li>
                <a href="{{route("wap.loginout")}}">
                    <img src="{{asset("mobile/public/style/left/images/left/c10.png")}}">退出登录
                </a>
            </li>
        </ul>
    </div>
    </div>




    <link rel="stylesheet" href="{{asset("layim/css/layui.mobile.css")}}">
    <script src="{{asset("admin/js/jquery.min.js")}}?t=v1"></script>
    <script src="{{asset("layim/layui.js")}}?t=v1"></script>
    @if(Cache::get('WebIMKeFu')=='开启')
    <script>

        var mobile
            ,layim
            ,layer ;



        layui.config({
            version: true
        }).use(['mobile'], function(){
            mobile = layui.mobile;
            layim = mobile.layim;
            layer = mobile.layer;


            //演示自动回复
            var autoReplay = [
                '您好，我现在有事不在，一会再和您联系。',
                '你没发错吧？face[微笑] ',
                '洗澡中，请勿打扰，偷窥请购票，个体四十，团体八折，订票电话：一般人我不告诉他！face[哈哈] ',
                '你好，我是主人的美女秘书，有什么事就跟我说吧，等他回来我会转告他的。face[心] face[心] face[心] ',
                'face[威武] face[威武] face[威武] face[威武] ',
                '<（@￣︶￣@）>',
                '你要和我说话？你真的要和我说话？你确定自己想说吗？你一定非说不可吗？那你说吧，这是自动回复。',
                'face[黑线]  你慢慢说，别急……',
                '(*^__^*) face[嘻嘻] ，是贤心吗？'
            ];

            layim.config({


                init: {
                    //我的信息
                    mine: {
                        "username": "{{$Member->username}}" //我的昵称
                        ,"id": "{{$Member->id}}" //我的ID
                        ,"avatar": "{{asset("layim/images/avatar/".($Member->id%10).".jpg")}}" //我的头像
                        ,"sign": ""
                    }
                    //我的好友列表
                    ,friend: [{
                        "groupname": "在线客服"
                        ,"id": 100
                        ,"online": 2
                        ,"list": [{
                            "username": "{{Cache::get('CompanyShort')}}客服"
                            ,"id": "-1"
                            ,"avatar": "{{asset("layim/images/avatar/kf.png")}}"
                            ,"sign": "官方在线客户"
                        }]
                    }]

                }

                //上传图片接口
                ,uploadImage: {
                    url: '{{route("layim.uploadimgage")}}?_token={{ csrf_token() }}' //（返回的数据格式见下文）
                    ,type: '' //默认post
                }


                ,moreList:false

                //扩展更多列表
                ,moreList: [{
                    alias: 'usercent'
                    ,title: '用户中心'
                    ,iconUnicode: '&#xe628;' //图标字体的unicode，可不填
                    ,iconClass: '' //图标字体的class类名

                }]

                //,tabIndex: 1 //用户设定初始打开的Tab项下标
                ,isNewFriend: false //是否开启“新的朋友”
                ,isgroup: false //是否开启“群聊”
                //,chatTitleColor: '#c00' //顶部Bar颜色
                ,copyright:false
                ,brief:true
                ,title: '{{Cache::get('CompanyShort')}}客服' //应用名，默认：我的IM
            });

            /*        //创建一个会话

                    layim.chat({
                        "name": "客服小丽"
                        ,"id": "10000"
                        ,"type": "friend"
                        ,"avatar": "http://tp1.sinaimg.cn/1571889140/180/40030060651/1"
                        ,"sign": "官方在线客户"
                    });*/


//监听点击更多列表
            layim.on('moreList', function(obj){
                switch(obj.alias){ //alias即为上述配置对应的alias
                    case 'usercent': //发现
                        window.location.href='/user/index.html';
                        break;

                }
            });

            //监听返回
            layim.on('back', function(){
                //如果你只是弹出一个会话界面（不显示主面板），那么可通过监听返回，跳转到上一页面，如：history.back();
            });



            //监听发送消息
            layim.on('sendMessage', function(senddata){
                var To = senddata.to;
                var content = senddata.mine.content;

                console.log(senddata);

                var msgdata= {
                    "username": To.name
                    ,"avatar": To.avatar
                    ,"fid": senddata.mine.id
                    ,"fusername": senddata.mine.username
                    ,"id": To.id
                    ,"type": To.type
                    ,"content": content,
                    "_token":"{{ csrf_token() }}"
                };
                //console.log(msgdata);
                $.post("{{route('layim.send')}}",msgdata,function (datas) {

                    if(datas){
                        layim.getMessage(datas);
                    }

                });


                // layim.getMessage(obj);


                /*            //演示自动回复
                            setTimeout(function(){
                                var obj = {};
                                if(To.type === 'group'){
                                    obj = {
                                        username: '模拟群员'+(Math.random()*100|0)
                                        ,avatar: layui.cache.dir + 'images/face/'+ (Math.random()*72|0) + '.gif'
                                        ,id: To.id
                                        ,type: 'group'
                                        ,content: autoReplay[Math.random()*9|0]
                                    }
                                } else {
                                    obj = {
                                        username: To.name
                                        ,avatar: To.avatar
                                        ,id: To.id
                                        ,type: To.type
                                        ,content: autoReplay[Math.random()*9|0]
                                    }
                                }
                                layim.getMessage(obj);
                            }, 3000);*/
            });



            //模拟收到一条好友消息

            function Message(){
                //

                $.post("{{route('layim.getmsg')}}",{
                    "_token":"{{ csrf_token() }}"
                },function (data) {

                    if(data){


                        layim.chat(data);
                        layim.getMessage(data);

                    }


                },'json');

                setTimeout(function () {
                    Message();
                }, 2000);
            }

            Message();


            //模拟"更多"有新动态
            //layim.showNew('More', true);
            //layim.showNew('find', true);

            //console.log(layim.cache())
        });




    </script>

@endif

@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

