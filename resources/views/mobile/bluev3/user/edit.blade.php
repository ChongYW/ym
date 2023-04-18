@extends('mobile.bluev3.wap')

@section("header")

@endsection

@section("js")
    @parent


@endsection

@section("css")

    @parent


@endsection

@section("onlinemsg")

@endsection

@section('body')


    <div class="othertop">
        <a class="goback" href="{{route('user.index')}}"><img src="{{asset("mobile/bluev3/img/goback.png")}}" style="margin: 0px;"/></a>
        <div class="othertop-font">帐号设置</div>
    </div>



    <div class="header-nbsp"></div>
    <!-- 账号设置 -->
    <ul class="user_list set">
        <li class="txt"><a><img src="/mobile/bluev3/img/user_tel.png">手机号<span>{{\App\Member::DecryptPassWord($Member->mobile)}}</span></a></li>
    </ul>
    <ul class="user_list set">

       <li class="txt"><a href="{{route("user.certification")}}">
               <img src="/mobile/bluev3/img/user_cert1.png">实名认证
               <span>@if($Member->card!='')已完成@else未认证@endif</span>
           </a>
       </li>

        <li><a href="{{route("user.password")}}"><img src="/mobile/bluev3/img/user_lpwd.png">修改登录密码</a></li>
        <li><a href="{{route("user.paypwd")}}"><img src="/mobile/bluev3/img/user_ppwd.png">修改支付密码</a></li>
    </ul>







@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

