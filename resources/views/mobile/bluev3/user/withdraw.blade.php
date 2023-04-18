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
    @parent
@endsection

@section('body')

    <div class="othertop">
        <a class="goback" href="javascript:history.back();"><img src="{{asset("mobile/bluev3/img/goback.png")}}" style="margin: 0px;"/></a>
        <div class="othertop-font">提现</div>
    </div>


    <div class="header-nbsp"></div>


    <!-- 提现 -->
    <form action="" method="post" id="withdraw">
        <div class="blank_card">
            <label>提现银行</label>
            <select name="cardid" id="cardid" class="right">

                <option value="{{$Member->bankcode}}">{{$Member->realname}} | {{$Member->bankname}} | {{$Member->bankcode}} </option>                                    </select>
        </div>
        <div class="blank_card">
            <p>提现金额：</p>
            <label class="big">￥</label><input class="right" type="text" name="amount" id="amount" maxlength="8" placeholder="提现金额最低为<?php echo Cache::get("withdrawalmin");?>元" value="<?php echo Cache::get("withdrawalmin");?>">
            <p>可提现金额 <span id="userMoney"><?php echo $Member->amount; ?></span>元</p>
        </div>

        <div class="blank_card">
            <label>交易密码</label><input type="password" class="right" name="paypwd" id="paypwd" placeholder="输入支付密码" maxlength="18">
        </div>
        <button type="button" class="finishReg input_btn" id="tixian-btn" onclick="SubForm()">申请提现</button>

        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

    </form>








<script>


    function SubForm() {

       var datas= $("#withdraw").serialize();

        $.ajax({
            url: '{{route("user.withdraw")}}',
            type: 'post',
            data: datas,
            dataType: 'json',
            error: function () {
            },
            success: function (data) {
                layer.open({
                    content: data.msg,
                    btn: '确定',
                    shadeClose: false,
                    yes: function(index){
                        if(data.status==0){
                            // window.location.reload();
                            window.location.href='{{route('user.index')}}';
                        }else if(data.url){
                            window.location.href=data.url;
                        }
                        layer.close(index);
                    }
                });
            }
        });
    }

</script>

@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

