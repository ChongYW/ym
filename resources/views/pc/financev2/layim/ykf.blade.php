

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

