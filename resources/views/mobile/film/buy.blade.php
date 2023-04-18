@extends('mobile.film.wap')

@section("header")

    <header>
        <a href="javascript:history.go(-1);"><img src="{{asset("mobile/film/images/back.png")}}" class="left backImg"></a>
        <span class="headerTitle">{{\App\Formatting::Format($productview->title)}}</span>

    </header>

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

    <form id="buy" class="layui-form">
    <div class="financeTop"><div class="max">


            <p class="financeDetail">账户可用余额(元)<br><span class="earningsNum" id="bal_value"  value="{{$Memberamount}}">¥{{$Memberamount}}</span></p>


        </div></div>





    <div class="formGroup"><span class="left">起投金额:</span> <span class="right"   id="qi_value"  value="100">¥<font style="color:#F00; font-size:22px;font-weight:700">{{$productview->qtje}}</font>元</span></div>


    <div class="formGroup"><span class="left">能否复投:</span> <span class="right"><font style="color:#F00; font-size:16px;font-weight:700"><?php if ($productview->isft == 0) {
                    echo  '不能复投';
                } elseif ($productview->isft == 1) {
                    echo  '可以复投';
                } ?></font></span></div>



    <div class="formGroup"><span class="left">结息时间:</span> <span class="right">满<b class='blue'> <?php if ($productview->hkfs == 2) { ?> <?php echo $productview->shijian; ?>个小时<?php } else { ?>24小时<?php } ?> </b>自动结息</span></div>


    <div class="formGroup"><span class="left">收益期限:</span> <span class="right">

<?php if ($productview->hkfs == 2) { ?>
            <?php echo $productview->shijian; ?>小时，每小时<?php }elseif($productview->hkfs == 4){} else { ?>
    每个自然日
    <?php } ?>
@if($productview->hkfs == 4)
        收益{{\App\Product::Benefit($productview->id,$productview->qtje)}}
    @else
        分红{{ $productview->shijian*$productview->jyrsy*$productview->qtje/100 }}
    @endif
    元，
    @if($productview->hkfs == 3)
        本息每日等额返还
    @elseif($productview->hkfs == 1)
        {{$productview->shijian}}个自然日到期本息返还
    @else
        <?php echo $productview->shijian; ?><?php if ($productview->hkfs == 2) { ?>小时<?php } else { ?>个自然日<?php } ?>到期返本
    @endif



</span></div>

    <div class="formGroup">

            <span class="left">投资金额:</span><input type="hidden" name="idPay" id="idPay" value="{{$productview->id}}"/>


            <input type="number" name="amountPay" id="amountPay" class="spinner value numtext right" value="{{$productview->qtje}}" placeholder="输入投资金额">


    </div>





    <div class="formGroup"><span class="left"></span> <span class="right"><p style="font-size:14px; text-align:right;">例如投资：<b id="calculate-amount-sync" style="color:#fe6c00">{{$productview->qtje}}</b> 元 可收益：<b style="color:#fe6c00">
                    <em>
                    @if($productview->hkfs==4)
                            {{\App\Product::Benefit($productview->id,$productview->qtje)}}
                        @else
                            {{ $productview->qtje+$productview->qtje*$productview->shijian*($productview->jyrsy/100)}}
                        @endif
                    </em>
                </b>元</p></span></div>





    <div class="formGroup" ><span class="left">支付密码</span> <span class="right"><input name="pwdPay" type="password"  class="right" id="zfPassword" placeholder="默认为登录密码"></span></div>








    <div class="cle"></div>


    <div id="sub-err" class="error right" style="color:#F00"></div>


    <div class="cle"></div>



        @if($productview->tzzt==1)
        <input type="button" class="finishReg"  value="投资已满额">
        @else
        <input type="button" class="finishReg"  lay-submit lay-filter="*" value="立即投资">
        @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

    </form>


    <script>
        layui.use('form', function(){
            var form = layui.form;



            form.on('submit(*)', function(data){

                $.ajax({
                    type: "POST",
                    data: data.field,
                    url: "{{route("user.nowToMoney")}}",
                    beforeSend: function () {

                    },
                    success: function (data) {

                        var status = data.status;
                        if (!status) {
                            layer.msg(data.msg,function () {
                                window.location.href = "{{route("product.buy",["id"=>$productview->id])}}";
                            });

                        } else {
                            layer.msg(data.msg,function () {
                                if(data.url){
                                    window.location.href = data.url;
                                }
                            });
                        }
                    },
                    error: function () {

                    },
                    dataType: "json"
                })

                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });



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

