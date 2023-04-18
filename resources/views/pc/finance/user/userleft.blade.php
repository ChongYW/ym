<ul id="userLeft" class="user-l white-bg fl">
    <li style="margin-bottom:5px;">
        <h3><i class="icon icon1"></i><a href="{{route('user.index')}}" style="color:#FFF">我的账户</a></h3>
        <dl>
            <dd><a href="{{route('user.index')}}">帐户主页</a></dd>
            <dd><a href="{{route('user.yuamount')}}">我的余额宝</a></dd>
            <dd><a href="{{route('user.moneylog')}}">资金统计</a></dd>
            <dd><a href="{{route('user.withdraw')}}">我要提现</a></dd>
            <dd><a href="{{route('user.recharge')}}">在线充值</a></dd>
            <dd><a href="{{route('user.lotterys')}}" target="_blank">我要抽奖</a></dd>
            {{--<dd><a href="{{route('user.lotterylist')}}">抽奖记录</a></dd>--}}

        </dl>
    </li>
    <li>
        <h3><i class="icon icon2"></i>我的记录</h3>
        <dl>

            <dd><a href="{{route('user.shouyimx')}}">资金明细</a></dd>
            <dd><a href="{{route('user.recharges')}}">充值记录</a></dd>
            <dd><a href="{{route('user.withdraws')}}">提现记录</a></dd>

        </dl>
    </li>
    <li>
        <h3><i class="icon icon3"></i>投资管理</h3>
        <dl>
            <dd><a href="{{route('user.tender')}}">投资记录</a></dd>
            <dd><a href="{{route('products')}}" target="_blank">可投项目</a></dd>
        </dl>
    </li>

    <li>
        <h3><i class="icon icon4"></i>账户管理</h3>
        <dl>
            <dd><span></span><a href="{{route('user.security')}}">安全设置</a></dd>
            <dd><span></span><a href="{{route('user.bank')}}">银行卡信息</a></dd>
            <dd><span></span><a href="{{route('user.mylink')}}">邀请好友</a></dd>

        </dl>
    </li>

    <li>
        <h3><i class="icon icon4"></i>短消息<i class="arrow"></i></h3>
        <dl>
            <dd><span></span><a href="{{route('user.msglist')}}"> 收件箱</a></dd>

        </dl>
    </li>
    <li>
    </li>
</ul>