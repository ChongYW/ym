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
        <div class="othertop-font">立即投标</div>
    </div>


    <div class="form_outer">
        <form id="buy" class="layui-form">

              <div class="form_top">
                <p >
                    <span class="span_tit" id="acctName">账户可用余额（元）</span>
                    <span class="span_num" id="acctAmt">￥ {{$Memberamount}}元</span>
                </p>
                <p>
                    <span class="span_tit">项目可投金额（元）</span>
                    <span class="span_num">￥ <strong id = "maxNum">{{($productview->xmgm-$productview->xmgm*$productview->xmjd/100)*10000}} </strong>元</span>
                </p>
            </div>

            <input type="hidden" value="{{$productview->id}}" name="idPay"/>
            <input type="hidden" value="{{$productview->zgje>0?$productview->zgje:$Memberamount}}" id="maxNum2"/>
            <input type="hidden" value="{{$productview->qtje}}" id="minNum2"/>
            <input type="hidden" value="{{$Memberamount}}" id="userMoney"/>
            <input type="hidden" value="{{$Memberamount}}" id="userMoney2"/>

            <ul>
                <li>
                    <label>起投金额</label><span>￥ <em class="start">{{$productview->qtje}}</em> 元</span>
                </li>
                <li>
                    <label>结息时间</label><span>满 <em class="time"><?php if ($productview->hkfs == 2) { ?> <?php echo $productview->shijian; ?>个小时<?php } else { ?>24小时<?php } ?></em> 自动结息</span>
                </li>
                <li>
                    <label>投资金额</label><br/>
                    <div class="caculate">
                        <i class="btn_reduce">&minus;</i>
                        <input type="text" name="amountPay" id="money" value="{{$productview->qtje}}">
                        <i class="btn_add">+</i>
                    </div>
                </li>
                <li>
                    <label></label><span class="add">最低起投 <em class="time" id="minNum">{{$productview->qtje}}</em> 元，加一次为  <em class="time" id="addNum">100</em> 元</span>
                </li>

                <li>
                    <label style="padding-top: 8px;">加息劵：</label>
                <?php $Coupons=\App\Couponsgrant::GetUserCoupon($productview->id,$Member->id,2);?>

                    <select name="ratecoupon" id="ratecoupon" class="layui-form-item">
                        <option value="" title="">请选择加息券</option>
                        @if($Coupons)
                            @foreach($Coupons as $Coupon)
                                 <option value="{{$Coupon->id}}" title="{{$Coupon->money}}" >券号{{$Coupon->id}}-【{{$Coupon->money}}%】的加息劵</option>

                            @endforeach
                        @endif
                    </select>

                </li>

                <li>
                    <label style="padding-top: 8px;">现金券：</label>
                <?php $Couponsa=\App\Couponsgrant::GetUserCoupon($productview->id,$Member->id,1);?>

                    <select name="cashcoupon" id="cashcoupon" onchange="checkCashCoupon();">
                        <option value="" title="">请选择现金券</option>
                        @if($Couponsa)
                            @foreach($Couponsa as $Coupon)
                                <option value="{{$Coupon->id}}" title="{{$Coupon->money}}" >券号{{$Coupon->id}}-【{{$Coupon->money}}】元的现金劵</option>

                            @endforeach
                        @endif


                        </volist>
                    </select>
                </li>

                <li>
                    <label>支付密码</label>

                    <input name="pwdPay" type="password"  class="pwd" id="zfPassword" placeholder="默认为登录密码">
                </li>

            </ul>


            @if($productview->tzzt==1)
                <input type="button" class="finishReg input_btn"  value="投资已满额">
            @else
                <input type="button" class="finishReg input_btn"  lay-submit lay-filter="*" value="立即投资">
                <input type="button" class="input_btn"  lay-submit value="数据处理中" style="display: none">
            @endif
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

        </form>
    </div>

<style>

    .layui-form .layui-form-select{
        width: 60%;
    }

    .form_outer ul li input {
        font-size: .14rem;
    }

    .layui-form-select .layui-input {
        padding-right: 30px;
        cursor: pointer;
        width: 100%;
    }

    .goback img {
        width: .5rem;
        height: .5rem;
        /* margin: .15rem 0 0 0; */
    }

    .form_outer ul li input {
        font-size: .3rem;
    }

    .form_outer .caculate {
         margin-top: 0px;
    }
</style>



    <script>
        $().ready(function(){

            var minNum = Number($("#minNum").text());
            var maxNum = Number($("#maxNum").text());
            var maxNum2 = Number($("#maxNum2").val());
            var minNum2 = Number($("#minNum2").val());
            var userMoney = Number($("#userMoney").val());
            var addNum = Number($("#addNum").text());
            var ebaoMoney = {{$Memberamount}};

            $(".caculate .btn_reduce").click(function(){
                var number = Number($(this).next().val());
                if(number > minNum){
                    number = number - addNum;
                    $(this).next().val(number);
                }
            });

            $(".caculate .btn_add").click(function(){
                var number = Number($(this).prev().val());
                if(minNum2 == 1){
                    ;//1元购388项目
                }else{
                    var payType = $('input:radio:checked').val();
                    if(payType == '1'){
                        if(number < maxNum && number < maxNum2 && userMoney > number){
                            number = number + addNum;
                            $(this).prev().val(number);
                        }
                    }else{
                        if(number < maxNum && number < maxNum2 && ebaoMoney > number){
                            number = number + addNum;
                            $(this).prev().val(number);
                        }
                    }
                }
            });


        });
    </script>




    <script>
        layui.use('form', function(){
            var form = layui.form;



            form.on('submit(*)', function(data){

                $.ajax({
                    type: "POST",
                    data: data.field,
                    url: "{{route("user.nowToMoney")}}",
                    beforeSend: function () {
                        //finishReg input_btn
                        $(".input_btn").eq(1).show();
                        $(".finishReg").hide();
                    },
                    success: function (data) {

                        var status = data.status;
                        if (status) {
                            layer.msg(data.msg,function () {
                               // window.location.href = "{{route("product.buy",["id"=>$productview->id])}}";
                                window.location.href='{{route('user.tender')}}';
                            });

                        } else {
                            layer.msg(data.msg,function () {
                                if(data.url){
                                    window.location.href = data.url;
                                }

                                $(".input_btn").hide();
                                $(".finishReg").show();
                            });
                        }
                    },
                    error: function () {

                    },
                    dataType: "json"
                })

                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });

            form.render(); //更新全部


        });
    </script>

@endsection

@section('footcategoryactive')
    <script type="text/javascript">
        $("#menu1").addClass("active");
    </script>
@endsection

@section('footcategory')
    @parent
@endsection

@section("footer")
    @parent
@endsection

