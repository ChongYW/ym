<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{Cache::get('sitename')}}-LayIM PC版</title>

    <link rel="stylesheet" href="{{asset("layim/css/layui.css")}}">
    <style>
        html{background-color: #333;}
    </style>
</head>
<body style="background-image: url('\layim\bg\1.jpeg')">


<script src="{{asset("layim/layui.js")}}"></script>

@if(isset($Member))
    <?php

    $Kefus=  \App\Admin::where("kefu","1")->orderBy("updated_at","desc")->get();
    ?>
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


                //我的信息
                mine: {
                    "username": "{{$Member->username}}" //我的昵称 sign
                    ,"id": "{{$Member->id}}" //我的ID
                    ,"avatar": "{{$Member->picImg}}" //我的头像
                    ,"sign": "{{$Member->sign}}"

                }
                //我的好友列表
                ,friend: [{
                    "groupname": "{{Cache::get('imName')}}"
                    ,"id": 100
                    //,"online": 2
                    ,"list": [
                                @if($Kefus)
                                @foreach($Kefus as $kf)


                        {
                            "username": "{{$kf->name}}"
                            ,"id": "-{{$kf->id}}"
                            ,"avatar": "{{$kf->img}}"
                            ,"sign": "{{$kf->remarks}}"
                            ,"status": "{{strtotime($kf->updated_at)>time()-600?'online':'offline'}}"
                        },
                            @endforeach
                            @endif
                    ]
                }]

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

            ,title: 'WebIM' //自定义主面板最小化时的标题
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

            $.post("{{route('layim.getmsg')}}",{
                "_token":"{{ csrf_token() }}"
            },function (data) {

                if(data){
                    layim.getMessage(data);

                    //  layim.chat(data);

                }


            },'json');

            setTimeout(function () {
                Message();
            }, 2000);
        }

        Message();

    });
</script>
    @else

    <?php

    $Kefus=  \App\Admin::where("kefu","1")->orderBy("updated_at","desc")->get();
    ?>


    <script>



        //演示代码
        layui.use('layim', function(layim){
            var layim = layui.layim;
            layim.config({
                init: {
                    //配置客户信息
                    mine: {
                        "username": "访客" //我的昵称
                        ,"id": "{{$YKUserId}}" //我的ID
                        ,"status": "online" //在线状态 online：在线、hide：隐身
                        ,"remark": "{{Cache::get('imName')}}" //我的签名
                        ,"avatar": "{{asset("layim/images/avatar/".($YKUserId%10).".jpg")}}" //我的头像
                    }
                }
                //开启客服模式
                ,brief: true
                ,minRight: '1px'
            });
            //打开一个客服面板

            <?php
            if($Kefus){
                foreach($Kefus as $k=>$kf){
                    $kefulink='';
                    if($k==0){
                        $kefulink= "layim.chat({
                name: '".$kf->name."'
                ,type: 'kefu'
                ,avatar: '".$kf->img."'
                ,id: '-".$kf->id."'
            })";
                    }else{
                        $kefulink.= ".chat({
                name: '".$kf->name."'
                ,type: 'kefu'
                ,avatar: '".$kf->img."'
                ,id: '-".$kf->id."'
            })";
                    }
                    echo $kefulink;
                }
            }
            ?>

            layim.setChatMin(); //收缩聊天面板



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
                $.post("{{route('layim.send')}}",msgdata,function (datas) {

                    if(datas.username){
                        layim.getMessage(datas);
                    }

                });

            });


            //收到一条好友消息

            function Message(){
                //

                $.post("{{route('layim.ykgetmsg')}}",{
                    "_token":"{{ csrf_token() }}"
                },function (data) {

                    if(data){
                        layim.getMessage(data);


                        layim.chat(data);
                        //layim.setChatMax(); //收缩聊天面板

                    }


                },'json');

                setTimeout(function () {
                    Message();
                }, 2000);
            }

            Message();


        });



    </script>
    @endif
</body>
</html>
