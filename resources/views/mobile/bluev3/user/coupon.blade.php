@extends('mobile.bluev3.wap')

@section("header")

@endsection

@section("js")


    <script type="text/javascript" src="/mobile/bluev3/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/mobile/bluev3/choujiang/js/tab.js"></script>
@endsection

@section("css")


    <link rel="stylesheet" href="/mobile/bluev3/choujiang/css/coupon.css"/>


@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')
    <div id="msgBox" style="width: 100%;background-color: rgba(0,0,0,0.25);height: 1000px;position: fixed;top: 0;left: 0;z-index: 9999;font-size:16px;display: none;">
        <div style="width: 80%;margin-top: 40%;margin-left: 10%;background-color: #fff;border-radius:8px;overflow: hidden;">
            <div id="msgTitle" style="padding:10px 20px;background-color: #385fec;color:#fff;text-align: center;">
                温馨提示
            </div>
            <div  style="padding: 25px 10px;line-height: 30px;">
                <p id="msgContent" style="background: url('/Public/pc/img/success.png') no-repeat 0 -2px;height: 32px;padding-left: 40px;">内容
                </p>
            </div>
            <div id="msgBtn" style="padding: 10px 20px;text-align: right;border-top: 1px solid #eee;">
                <input type="button" value="确定" style="background-color: #385fec;color:#fff;border: none;padding:5px 10px;"/>
                <input type="button" value="取消" style="background-color: #385fec;color:#fff;border: none;padding:5px 10px;"/>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function msg(title,content,type,url){
            $("#msgTitle").html(title);
            $("#msgContent").html(content);
            if(type==1){
                var btn = '<input type="button" value="确定" onclick="$(\'#msgBox\').hide();" style="background-color: #385fec;color:#fff;border: none;padding:5px 10px;"/>';
            }
            else{
                var btn = '<input type="button" value="确定" onclick="window.location.href=\''+url+'\'" style="background-color: #385fec;color:#fff;border: none;padding:5px 10px;"/>';
            }
            $("#msgBtn").html(btn);
            $("#msgBox").show();
        }
    </script>


    <section class="aui-flexView">
        <header class="aui-navBar aui-navBar-fixed b-line" style="/* background:#385fec; */background-image: linear-gradient(to right,#ec9c38,#ff3939);">
            <a href="{{route('user.index')}}" class="aui-navBar-item">
                <i class="icon icon-return" ></i>
            </a>
            <div class="aui-center" >
                <span class="aui-center-title">我的优惠券</span>
            </div>
        </header>
        <section class="aui-scrollView">
            <div class="aui-tab" data-ydui-tab>
                <ul class="tab-nav b-line">
                    <li class="tab-nav-item tab-active">
                        <a href="javascript:;">
                            <span>未使用</span>
                        </a>
                    </li>
                    <li class="tab-nav-item">
                        <a href="javascript:;">
                            <span>已使用</span>
                        </a>
                    </li>
                    <li class="tab-nav-item">
                        <a href="javascript:;">
                            <span>已过期</span>
                        </a>
                    </li>
                </ul>
                <?php
               $coupons= config('coupons');
                ?>
                <div class="tab-panel" >
                    <!-- 可使用 -->
                    <div class="tab-panel-item tab-active">
                        @foreach($list[1] as $coupon)

                                <a href="javascript:;" class="aui-flex">
                                    <div class="aui-price-nub">
                                        <div class="aui-digit" >
                                            @if($coupon->type==1)
                                                <h2 style="font-size:14px"><em>￥</em>{{$coupon->money}}</h2>
                                            @endif
                                            @if($coupon->type==2)
                                                <h2 style="font-size:14px">{{$coupon->money}}<em>%</em></h2>
                                            @endif
                                        </div>
                                        <div class="aui-full">
                                            <p>{{$coupons['type'][$coupon->type]}}</p>
                                        </div>

                                    </div>
                                    <div class="aui-flex-box" >

                                        @if($coupon->type==1)
                                            <h2 >{{$coupon->money}}元现金券</h2>
                                        @endif
                                        @if($coupon->type==2)
                                            <h2 >{{$coupon->money}}%加息券</h2>
                                        @endif

                                        <h3>{{$coupon->created_at}}</h3>
                                        <h3>{{$coupon->exptime}}</h3>

                                        <button id="{{$coupon->couponsid}}" href="{{route('products',["coupon"=>$coupon->couponsid])}}" value="{{$coupon->status}}">立即使用</button>


                                    </div>
                                </a>

                        @endforeach
                    </div>

                    <!-- 已使用 -->
                    <div class="tab-panel-item tab-panel-item-clear">
                        @foreach($list[2] as $coupon)

                                <a href="javascript:;" class="aui-flex">
                                    <div class="aui-price-nub">
                                        <div class="aui-digit" >
                                            @if($coupon->type==1)
                                                <h2 style="font-size:14px"><em>￥</em>{{$coupon->money}}</h2>
                                            @endif
                                            @if($coupon->type==2)
                                                <h2 style="font-size:14px">{{$coupon->money}}<em>%</em></h2>
                                            @endif
                                        </div>
                                        <div class="aui-full">
                                            <p>{{$coupons['type'][$coupon->type]}}</p>
                                        </div>

                                    </div>
                                    <div class="aui-flex-box">
                                        @if($coupon->type==1)
                                            <h2 >{{$coupon->money}}元现金券</h2>
                                        @endif
                                        @if($coupon->type==2)
                                            <h2 >{{$coupon->money}}%加息券</h2>
                                        @endif

                                        <h3>{{$coupon->created_at}}</h3>

                                        <h3>{{$coupon->exptime}}</h3>
                                        <button id="{{$coupon->couponsid}}"  value="{{$coupon->status}}">已使用</button>
                                    </div>
                                </a>

                        @endforeach
                    </div>

                    <!-- 已过期 -->
                    <div class="tab-panel-item tab-panel-item-clear">
                        @foreach($list[3] as $coupon)

                                <a href="javascript:;" class="aui-flex">
                                    <div class="aui-price-nub">
                                        <div class="aui-digit" >
                                            @if($coupon->type==1)
                                                <h2 style="font-size:14px"><em>￥</em>{{$coupon->money}}</h2>
                                            @endif
                                            @if($coupon->type==2)
                                                <h2 style="font-size:14px">{{$coupon->money}}<em>%</em></h2>
                                            @endif
                                        </div>
                                        <div class="aui-full">
                                            <p>{{$coupons['type'][$coupon->type]}}</p>
                                        </div>

                                    </div>

                                    <div class="aui-flex-box">
                                        @if($coupon->type==1)
                                            <h2 >{{$coupon->money}}元现金券</h2>
                                        @endif
                                        @if($coupon->type==2)
                                            <h2 >{{$coupon->money}}%加息券</h2>
                                        @endif

                                        <h3>{{$coupon->created_at}}</h3>

                                        <h3>{{$coupon->exptime}}</h3>
                                        <button id="{{$coupon->couponsid}}"  value="{{$coupon->status}}">已过期</button>
                                    </div>
                                </a>

                       @endforeach
                    </div>
                </div>
            </div>
        </section>
    </section>


    <script type="text/javascript">

        var btn=document.getElementsByTagName("button")

        for(var i=0;i<btn.length;i++){
            (function(n){
                btn[n].onclick=function(){
                    var id =btn[n].id;
                    var type = btn[n].value;
                    if( type == 2 )
                    {
                        msg('提示','优惠券已使用过，无法使用',1);
                        return;
                    }
                    else if(  type == 3 ){
                        msg('提示','优惠券已过期，无法使用',1);
                        return;
                    }
                    else
                    {
                        msg('提示','您确定使用这张优惠券？',2,"{{route('products')}}?coupon="+id);
                    }
                }
            })(i);
        }
    </script>
@endsection


@section("footbox")

@endsection
@section("footcategory")

@endsection

@section("footer")

@endsection

