<!doctype html>
<html  class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>后台登录-X-admin2.1</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{ asset("admin/css/font.css")}}">
    <link rel="stylesheet" href="{{ asset("admin/css/xadmin.css")}}">

    <script type="text/javascript" src="{{ asset("admin/js/3.2.1/jquery.min.js")}}"></script>
    <script src="{{ asset("admin/lib/layui/layui.js")}}" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset("admin/js/xadmin.js")}}"></script>
    <script type="text/javascript" src="{{ asset("admin/js/cookie.js")}}"></script>

    <script src="{{asset("layim/layui.js")}}"></script>
</head>
<body>
<div class="x-body">
    <blockquote class="layui-elem-quote">欢迎管理员：
        <span class="x-red">{{$adminName}}</span>！上次登录时间:{{$Admin->lastlogin_at}}</blockquote>
    <fieldset class="layui-elem-field">



        <legend>今日数据统计</legend>
        <div class="layui-field-box">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body">
                        <div class="layui-carousel x-admin-carousel x-admin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 90px;">
                            <div carousel-item="">
                                <ul class="layui-row layui-col-space10 layui-this">
                                    <li class="layui-col-xs2">
                                        <a href="javascript:x_admin_show('今日签到','{{route('admin.membermsg.lists',["s_categoryid"=>"每日签到","s_status"=>1,"day"=>1])}}');" class="x-admin-backlog-body">
                                            <h3>今日签到</h3>
                                            <p>
                                                <cite>{{$MemberQd}}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:x_admin_show('注册会员','{{route('admin.member.lists',["s_status"=>2,"day"=>1])}}');" class="x-admin-backlog-body">
                                            <h3>注册会员</h3>
                                            <p>
                                                <cite>{{$NewMembers}}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:x_admin_show('在线会员','{{route('admin.member.lists',["s_status"=>1])}}');" class="x-admin-backlog-body">
                                            <h3>在线会员</h3>
                                            <p>
                                                <cite>{{$OnMembers}}</cite></p>
                                        </a>
                                    </li>

                                    <li class="layui-col-xs2">
                                        <a href="javascript:x_admin_show('已投项目','{{route('admin.productbuy.lists',["day"=>1])}}');" class="x-admin-backlog-body">
                                            <h3>已投项目</h3>
                                            <p>
                                                <cite>{{$Dayproductbuys}}</cite></p>
                                        </a>
                                    </li>

                                    <li class="layui-col-xs2">
                                        <a href="javascript:x_admin_show('充值订单','{{route('admin.memberrecharge.lists',["day"=>1])}}');" class="x-admin-backlog-body">
                                            <h3>充值订单数</h3>
                                            <p>
                                                <cite>{{$Daymemberrecharge}}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:x_admin_show('提现订单','{{route('admin.memberwithdrawal.lists',["day"=>1])}}');" class="x-admin-backlog-body">
                                            <h3>提现订单数</h3>
                                            <p>
                                                <cite>{{$Daymemberwithdrawal}}</cite></p>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>历史数据统计</legend>
        <div class="layui-field-box">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body">
                        <div class="layui-carousel x-admin-carousel x-admin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 90px;">
                            <div carousel-item="">
                                <ul class="layui-row layui-col-space10 layui-this">
                                    <li class="layui-col-xs2">
                                        <a href="javascript:x_admin_show('已投项目','{{route('admin.productbuy.lists')}}');" class="x-admin-backlog-body">
                                            <h3>加入项目数</h3>
                                            <p>
                                                <cite>{{$productbuys}}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:x_admin_show('注册会员','{{route('admin.member.lists',["s_status"=>0])}}');" class="x-admin-backlog-body">
                                            <h3>注册会员数</h3>
                                            <p>
                                                <cite>{{$members}}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:x_admin_show('项目','{{route('admin.product.lists')}}');" class="x-admin-backlog-body">
                                            <h3>在线项目数</h3>
                                            <p>
                                                <cite>{{$products}}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:x_admin_show('充值订单','{{route('admin.memberrecharge.lists')}}');" class="x-admin-backlog-body">
                                            <h3>充值订单数</h3>
                                            <p>
                                                <cite>{{$memberrecharge}}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:x_admin_show('提现订单','{{route('admin.memberwithdrawal.lists')}}');" class="x-admin-backlog-body">
                                            <h3>提现订单数</h3>
                                            <p>
                                                <cite>{{$memberwithdrawal}}</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs2">
                                        <a href="javascript:x_admin_show('已投项目','{{route('admin.productbuy.lists')}}');" class="x-admin-backlog-body">
                                            <h3>已投项目金额</h3>
                                            <p>
                                                <cite>{{$amounts}}</cite></p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>系统通知</legend>
        <div class="layui-field-box">
            <table class="layui-table" lay-skin="line">
                <tbody>
                <tr>
                    <td >
                        <a class="x-a" href="/" target="_blank">新版1.0.190311上线了</a>
                    </td>
                </tr>

                <tr>
                    <td >
                        <a class="x-a">内容标签:
                            <br/>公司长名称标签:{CompanyLong}
                            <br/>公司短名称标签:{CompanyShort}
                            <br/>会员帐号标签:{UserName}
                            <br/>对应标签显示会替换成设置好的内容展示
                        </a>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>系统信息</legend>
        <div class="layui-field-box">
            <table class="layui-table">
                <tbody>
                <tr>
                    <th>系统版本</th>
                    <td>1.0.190311</td></tr>
                <tr>
                    <th>服务器地址</th>
                    <td>{{$request->getHost()}}</td></tr>
                <tr>
                    <th>操作系统</th>
                    <td><?PHP echo PHP_OS; echo ' '.php_uname('r');?></td></tr>
                <tr>
                    <th>运行环境</th>
                    <td><?PHP echo $_SERVER ['SERVER_SOFTWARE']; ?></td></tr>
                <tr>
                    <th>PHP版本</th>
                    <td><?PHP echo PHP_VERSION; ?></td></tr>
                {{--<tr>
                    <th>PHP运行方式</th>
                    <td>cgi-fcgi</td></tr>
                <tr>--}}
                    <th>MYSQL版本</th>
                    <td>5.7.25</td></tr>
                <tr>
                    <th>Laravel</th>
                    <td><?PHP echo $laravel::VERSION ;?></td></tr>
                <tr>
                    <th>上传附件限制</th>
                    <td><?PHP echo get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件"; ?></td></tr>
                <tr>
                    <th>执行时间限制</th>
                    <td><?PHP echo get_cfg_var("max_execution_time")."秒 "; ?></td></tr>
                {{--<tr>
                    <th>剩余空间</th>
                    <td>86015.2M</td></tr>--}}
                </tbody>
            </table>
        </div>
    </fieldset>
    <fieldset class="layui-elem-field">
        <legend>开发团队</legend>
        <div class="layui-field-box">
            <table class="layui-table">
                <tbody>

                </tbody>
            </table>
        </div>
    </fieldset>
    <blockquote class="layui-elem-quote layui-quote-nm">感谢layui,百度Echarts,jquery,x-admin,本系统由DH企业管理系统提供技术支持。</blockquote>
</div>



<!--在线客服系统 Layim-->

<script>

    if(!/^http(s*):\/\//.test(location.href)){
        alert('请部署到localhost上查看该演示');
    }

    layui.use('layim', function(layim){
        var $ =layui.$;

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

        //基础配置
        layim.config({



            init: {
                //我的信息
                mine: {
                    "username": "{{$Admin->name}}" //我的昵称
                    ,"id": "-{{$Admin->id}}" //我的ID
                    ,"avatar": "{{$Admin->img}}" //我的头像
                    ,"sign": "{{$Admin->remarks}}"
                }
                //我的好友列表
                ,friend: [
                    @if($memberlevel)
                    @foreach($memberlevel as $members)
                    {
                    "groupname": "{{$members->name}}"
                    ,"id": "{{$members->id}}"
                    ,"online": 2
                    ,"list": [
                        @if($members->merbers)
                                @foreach($members->merbers as $mbs)
                        {
                        "username": "{{$mbs->username}}"
                        ,"id": "{{$mbs->id}}"
                        ,"avatar": "{{$mbs->picImg}}"
                        ,"sign": "{{$mbs->sign}}"
                        ,"status": "{{strtotime($mbs->updated_at)>time()-600?'online':'offline'}}"
                    },
                            @endforeach
                            @endif
                        ]
                },
                @endforeach
                    @endif
                ]

            }



            //上传图片接口
            ,uploadImage: {
                url: '{{route("admin.layim.uploadimgage")}}?_token={{ csrf_token() }}' //（返回的数据格式见下文）
                ,type: '' //默认post
            }

            // ,isAudio: true //开启聊天工具栏音频
            //,isVideo: true //开启聊天工具栏视频

            //扩展工具栏


            //,brief: true //是否简约模式（若开启则不显示主面板）
            ,copyright: false

            ,title: '{{Cache::get('imName')}}' //自定义主面板最小化时的标题
            //,right: '100px' //主面板相对浏览器右侧距离
            //,minRight: '90px' //聊天面板最小化时相对浏览器右侧距离
            ,initSkin: '5.jpg' //1-5 设置初始背景
            //,skin: ['aaa.jpg'] //新增皮肤
            //,isfriend: false //是否开启好友
            ,isgroup: false //是否开启群组
            //,min: true //是否始终最小化主面板，默认false
            ,notice: true //是否开启桌面消息提醒，默认false
            //,voice: false //声音提醒，默认开启，声音文件为：default.mp3

            // ,msgbox: layui.cache.dir + 'css/modules/layim/html/msgbox.html' //消息盒子页面地址，若不开启，剔除该项即可
            // ,find: layui.cache.dir + 'css/modules/layim/html/find.html' //发现页面地址，若不开启，剔除该项即可
            ,chatLog:  '{{route('admin.layim.chatlog')}}' //聊天记录页面地址，若不开启，剔除该项即可

        });


/*
        //监听在线状态的切换事件
        layim.on('online', function(data){
            //console.log(data);
        });

        //监听签名修改
        layim.on('sign', function(value){
            //console.log(value);
        });


        //监听layim建立就绪
        layim.on('ready', function(res){

            //console.log(res.mine);

        });*/

        //监听发送消息
        layim.on('sendMessage', function(data){
            var To = data.to;
            //console.log(data);

            /*if(To.type === 'friend'){
                layim.setChatStatus('<span style="color:#FF5722;">对方正在输入。。。</span>');
            }*/


            var content = data.mine.content;

          //  console.log(data);

            var msgdata= {
                "username": To.name
                ,"avatar": To.avatar
                ,"fid": data.mine.id
                ,"fusername": data.mine.username
                ,"id": To.id
                ,"type": To.type
                ,"content": content,
                "_token":"{{ csrf_token() }}"
            };
            //console.log(msgdata);
            $.post("{{route('admin.layim.send')}}",msgdata,function (datas) {

                if(datas.username){
                    layim.getMessage(datas);
                }

            });

        });

        //监听查看群员
        layim.on('members', function(data){
            //console.log(data);
        });



        //收到一条好友消息

        function Message(){
            //

            $.post("{{route('admin.layim.getmsg')}}",{
                "_token":"{{ csrf_token() }}"
            },function (data) {

                if(data.username){
                    layim.getMessage(data);
                    //layim.chat(data);
                }


            },'json');

            setTimeout(function () {
                Message();
            }, 2000);
        }

        Message();

    });
</script>

<!--END在线客服-->

</body>
</html>
