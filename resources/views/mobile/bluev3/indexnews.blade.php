@extends('mobile.bluev3.wap')

@section("header")

@endsection

@section("js")
    @parent
@endsection

@section("css")
    @parent

@endsection



@section('body')
    <iframe marginwidth="0" marginheight="0" src=" https://cpu.baidu.com/1022/a93bcb0f/i?pu=2" frameborder="0" width="100%" scrolling="noshade" height="1000px"></iframe>


    <div id="appdown" class="appdown" style="width:100%;height: 1rem;background-color: rgba(0, 0, 0, 0.5);position: fixed;bottom: 1rem;display: none;">
        <div style="width: 1rem;float:left;height: 1rem;margin: 0 0.2rem;">
            <img src="/uploads/{{Cache::get("appdownloge").'?t='.time()}}" width="100%"/>
        </div>
        <div style="width: 3rem;float: left;left: 1rem;color: #fff;line-height: 0.4rem;margin: 0.1rem 0;font-size: 0.28rem;">

            <p style="text-align: center;"> <pre>{!!  \Cache::get('IndexTaotiaoAppText')!!} </pre></p>
        </div>
        <div style="width: 1rem;float:right;height: 1rem;">
            <a href="javascript:;" onclick="$('.appdown').hide();" style="display: block;width:1rem;font-size:0.5rem;cursor: pointer;color:#fff;line-height: 1rem;text-align: center;">×</a>
        </div>
        <div style="width: 2rem;height: 1rem;float: right;">
            <a href="{{\Cache::get('AppDownloadUrl')}}" style="display:block;width:1.6rem;height: 0.6rem;margin: 0.22rem .35rem;line-height:0.6rem;text-align:center;border-radius:0.1rem;background-color: #fc0303;color:#fff;font-size: 0.28rem;">下载体验</a>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            isapp();
        });
        //判断是否在云打包的应用中
        function isapp() {
            var YundabaoUA = navigator.userAgent;//获取当前的useragent
            if (YundabaoUA.indexOf('CK 2.0') > -1){
                $("#appdown").hide();

            }else{
                $("#appdown").show();
            }
        }
    </script>
@endsection


@section("footbox")
    @parent
@endsection

@section("footcategory")


    <style>




        .f_geng {
            background: url(/mobile/bluev3/img/footer/about_blue.gif) no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        .f_touz {
            background: url(/mobile/bluev3/img/footer/invest.png) no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }

        .piaofang {
            background: url('{{asset("mobile/static/images/maoyan.png")}}') no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }


    </style>

    <!-- 底部样式 -->
    <div class="header-nbsp"></div>

    <div class="footer_nav">
        <?php
        $link=\App\Category::where('name','like','%客服%')->whereRaw("FIND_IN_SET(?,templates)",Cache::get("WapTemplate"))->value('links')
        ?>
        <a href="/index.html" title="资讯首页" >
            <img  src="/mobile/bluev3/img/footer/about_blue.gif"  style="width: 20px;height: 20px;">
            <span>资讯首页</span>
        </a>
        <a href="{{route('user.index')}}" title="邀请好友" >
            <img  src="/mobile/bluev3/img/footer/invest.png"  style="width: 20px;height: 20px;">
            <span>邀请好友</span>
        </a>
        <a href="{{route('user.index')}}" title="个人中心" >
            <img  src="/mobile/bluev3/img/footer/user.png"  style="width: 20px;height: 20px;">
            <span>个人中心</span>
        </a>
        <a href="{{route('user.index')}}" title="每日签到" >
            <img  src="/mobile/film/images/tab3_1_004_1.png"  style="width: 20px;height: 20px;">
            <span>每日签到</span>
        </a>
        <a href="{{$link}}" title="在线客服" >
            <img  src="/mobile/bluev3/img/footer/kefu_blue.png"  style="width: 20px;height: 20px;">
            <span>客服</span>
        </a>


    </div>

@endsection

@section("footer")

    @parent
    <p><br/></p>
    {!! Cache::get("waptongjicode") !!}
@endsection


@section('footcategoryactive')
    <script type="text/javascript">
        $("#menu0").addClass("active");
    </script>
@endsection

