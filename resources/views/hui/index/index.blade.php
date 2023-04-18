<!doctype html>
<html  class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>{{  Cache::get('sitename') }}</title>
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



</head>
<body>






<!-- 顶部开始 -->
<div class="container">
    <div class="logo"><a href="{{route('admin.admin.index')}}">{{  Cache::get('sitename') }}</a></div>
    <div class="left_open">
        <i title="展开左侧栏" class="iconfont">&#xe699;</i>
    </div>


    <ul class="layui-nav right" lay-filter="">


        <li class="layui-nav-item to-index"> <a href="javascript:x_admin_show('今日充值','{{route('admin.memberrecharge.lists',['s_status'=>'1'])}}');" >今充(<span id="dayrechargeconuts">0</span>)</a></li>
        <li class="layui-nav-item to-index"> <a href="javascript:x_admin_show('今日提现','{{route('admin.memberwithdrawal.lists',['s_status'=>'1'])}}');" >今提(<span id="daywithdrawalconuts">0</span>)</a></li>


        <li class="layui-nav-item to-index"> <a href="javascript:x_admin_show('明日到期','{{route('admin.productbuy.lists',['s_status'=>'2'])}}');" >明到(<span id="tomorrows">{{$tomorrows}}</span>)</a></li>

        <li class="layui-nav-item to-index"> <a href="javascript:x_admin_show('会员总数','{{route('admin.member.lists')}}');" >总数(<span id="Members">{{$Members}}</span>)</a></li>
        <li class="layui-nav-item to-index"> <a href="javascript:x_admin_show('在线会员','{{route('admin.member.lists',["s_status"=>1])}}');" >在线(<span id="OnMembers">{{$OnMembers}}</span>)</a></li>
        <li class="layui-nav-item to-index"> <a href="javascript:x_admin_show('新增会员','{{route('admin.member.lists',["s_status"=>2])}}');" >新增(<span id="NewMembers">{{$NewMembers}}</span>)</a></li>
        {{--<li class="layui-nav-item to-index"> <a href="javascript:x_admin_show('介绍会员','{{route('admin.member.lists',["s_status"=>0])}}');" >介绍会员({{$INMembers}})</a></li>--}}
        <li class="layui-nav-item to-index"> <a href="javascript:x_admin_show('今日签到','{{route('admin.membermsg.lists',["s_categoryid"=>"每日签到","s_status"=>1,"day"=>1])}}');" >签到(<span id="MemberQd">{{$MemberQd}}</span>)</a></li>
        <li class="layui-nav-item to-index"> <a href="javascript:x_admin_box('增减余额','{{route('admin.memberrecharge.store')}}','add');" >增减余额</a></li>
        <li class="layui-nav-item to-index"> <a href="javascript:x_admin_show('已投项目','{{route('admin.productbuy.lists')}}');" >已投</a></li>

        <li class="layui-nav-item to-index"> <a href="javascript:x_admin_show('未处理充值','{{route('admin.memberrecharge.lists',["s_status"=>0])}}');" style="color: green;" id="rsconts"><i class="layui-icon layui-icon-notice"></i>未处理充值(0)</a></li>
        <li class="layui-nav-item to-index"> <a href="javascript:x_admin_show('未处理提款','{{route('admin.memberwithdrawal.lists',["s_status"=>0])}}');" style="color: green;" id="wsconts"><i class="layui-icon layui-icon-notice"></i>未处理提款(0)</a></li>

        <li class="layui-nav-item">
            

            <a href="javascript:;" style="color: green;">{{$adminName}}</a>
            <dl class="layui-nav-child">
                <dd><a onclick="x_admin_show('个人信息','{{route('admin.manage.update')}}')">个人信息</a></dd>

                <dd><a href="javascript:void(0);" onclick="cacheflush()">清空缓存</a></dd>
                <dd><a href="/" target="_blank">前台首页</a></dd>
                <dd><a href="{{route('loginout')}}">退出</a></dd>
            </dl>
        </li>


    </ul>

</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">

            @if($menus)
                @foreach($menus as $v)
            <li>
                <a  _href="{{$v['route']}}">
                    <i class="layui-icon" style="color:#009688">{!! $v['icon'] !!}</i>
                    <cite>{{$v['name']}}</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                @if(isset($v['list']))
                <ul class="sub-menu">
                    @foreach($v['list'] as $vv)
                    <li date-refresh="1">
                        <a _href="{{$vv['route']}}">
                            <i class="layui-icon " style="color:#5FB878">{!! $vv['icon'] !!}</i>
                            <cite>{{$vv['name']}}</cite>

                        </a>
                    </li >
                    @endforeach


                </ul>
                @endif
            </li>

                @endforeach
            @endif

        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
    <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
        </ul>
        <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
            <dl>
                <dd data-type="this">关闭当前</dd>
                <dd data-type="other">关闭其它</dd>
                <dd data-type="all">关闭全部</dd>
            </dl>
        </div>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='{{route('admin.index.main')}}' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
        </div>
        <div id="tab_show"></div>
    </div>
</div>
<div class="page-content-bg"></div>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<!-- 底部开始 -->
<div class="footer">
    <div class="copyright">Copyright ©2017-2019 {{  Cache::get('sitename') }} All Rights Reserved<font id="top_compay_playSound"></font></div>
</div>
<!-- 底部结束 -->
<script>

    function cacheflush(){

        $.ajax({
            url: "{{ route("admin.index.cacheflush") }}",
            type:"post",     //请求类型
            data:{_token:"{{ csrf_token() }}"},  //请求的数据
            dataType:"json",  //数据类型
            beforeSend: function () {
                // 禁用按钮防止重复提交，发送前响应
                var index = layer.load();

            },
            success: function(data){
                //laravel返回的数据是不经过这里的
                if(data.status==0){
                    layer.msg(data.msg,{icon: 1},function(){
                        layer.closeAll();
                    });



                }else{
                    layer.msg(data.msg,{icon: 5},function(){
                        layer.closeAll();
                    });
                }
            },
            complete: function () {//完成响应

            },
            error: function(msg) {
                var json=JSON.parse(msg.responseText);
                var errormsg='';
                $.each(json,function(i,v){
                    errormsg+=' <br/>'+ v.toString();
                } );
                layer.alert(errormsg);

            },

        });
    }


    msgconut();
    function msgconut(){

        setTimeout(function () {
            msgconut();
        },10000);
        $.ajax({
            url: "{{ route("admin.playSound.msgconut") }}",
            type:"post",     //请求类型
            data:{_token:"{{ csrf_token() }}"},  //请求的数据
            dataType:"json",  //数据类型
            beforeSend: function () {

            },
            success: function(data){

               // $('#msgconts').html("<i class=\"layui-icon layui-icon-notice\" ></i>"+data.msginfo+"");
                $('#rsconts').html("<i class=\"layui-icon layui-icon-rmb\"  ></i>"+data.rsinfo+"");
                $('#wsconts').html("<i class=\"layui-icon layui-icon-diamond\"></i>"+data.wsinfo+"");



                if(data.playSound=='开启') {
                    if(data.ws>0 && data.rs>0){
                        playSound('top_compay_playSound', 'sy.mp3');
                    }else if (data.ws>0) {
                        playSound('top_compay_playSound', 'tx.mp3');
                    } else if (data.rs>0) {
                        playSound('top_compay_playSound', 'cz.mp3');
                    } else if (data.conuts>0) {
                        playSound('top_compay_playSound', 'msg.mp3');
                    }
                }else if(data.playSound=='充值'){
                    if (data.rs>0) {
                        playSound('top_compay_playSound', 'cz.mp3');
                    }
                }else if(data.playSound=='提现'){
                    if (data.ws>0) {
                        playSound('top_compay_playSound', 'tx.mp3');
                    }
                }

                $('#Members').html(data.Members);
                $('#OnMembers').html(data.OnMembers);
                $('#NewMembers').html(data.NewMembers);
                $('#MemberQd').html(data.MemberQd);
                $('#daywithdrawalconuts').html(data.daywithdrawalconuts);
                $('#dayrechargeconuts').html(data.dayrechargeconuts);

 /*               "Members"=>$Members,
                    "OnMembers"=>$OnMembers,
                    "NewMembers"=>$NewMembers,
                    "MemberQd"=>$MemberQd,*/

                if(data.conuts>0){
                    //if(data.playSound=='开启') {
                       // playSound('top_compay_playSound', 'msg.mp3');
                   // }
                }

                if(data.rs>0){
                    $('#rsconts').attr({style:'color: red;font-size: 16px;'});

                }else{
                    $('#rsconts').attr({style:'color: green;'});
                }

                if(data.ws>0){
                    $('#wsconts').attr({style:'color: red;font-size: 16px;'});

                }else{
                    $('#wsconts').attr({style:'color: green;'});
                }



            },
            complete: function () {//完成响应

            },
            error: function(msg) {

            },

        });
    }


    function playSound(name,str){
        $("#"+name+"").html('<embed width="0" height="0"  src="/sound/'+str+'" autostart="true" loop="false">');
    }

</script>







</body>
</html>
