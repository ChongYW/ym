@extends('mobile.default.wap')

@section("header")
    @parent
    <div class="top" id="top" >
        <div class="kf">
            <p><a class="sb-back" href="javascript:history.back(-1)" title="返回"
                  style=" display: block; width: 40px;    height: 40px;
                          margin: auto; background: url('{{asset("mobile/images/arrow_left.png")}}') no-repeat 15px center;float: left;
                          background-size: auto 16px;font-weight:bold;">
                </a>
            </p>
            <div style="display: block;width:100%; position: absolute;top: 0;
     left: 0;text-align: center;  height: 40px; line-height: 40px; ">
                <a href="javascript:;" style="text-align: center;  font-size: 16px; ">{{Cache::get('CompanyLong')}}</a>
            </div>

        </div>
    </div>

    <link rel="stylesheet" href="{{asset("mobile/public/Front/css/common.css")}}" />

    <link rel="stylesheet" type="text/css" href="{{asset("mobile/public/style/css/style.css")}}"/>
    <link href="{{asset("mobile/public/Front/user/user.css")}}" type="text/css" rel="stylesheet">
    <script type="text/javascript" charset="utf-8" src="{{asset("mobile/public/Front/user/user.js").'?t='.time()}}"></script>

@endsection

@section("js")
    @parent

     <script type="text/javascript" src="{{ asset("admin/lib/layui/layui.js")}}" charset="utf-8"></script>
     <script type="text/javascript" src="{{ asset("js/clipboard.min.js")}}" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset("admin/lib/layui/css/layui.css")}}"/>
@endsection

@section("css")

    @parent


@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')
    <?php


    ?>

    <div class="user_zx_right" >
        <div class="box" style="margin-top: 50px">
            <div class="tagMenu">
                <ul class="menu">
                    <li ><a href="{{route("user.moneylog")}}">资金统计</a></li>
                    <li class="current"><a href="{{route("user.recharge")}}">马上充值</a></li>
                    <li><a href="{{route("user.recharges")}}">充值记录</a></li>
                    <li><a href="{{route("user.withdraw")}}">马上提现</a></li>
                    <li><a href="{{route("user.withdraws")}}">提现记录</a></li>
                    <li><a href="{{route("user.offline")}}">下线分成记录</a></li>

                </ul>
                <div class="hite"> <span id="account"></span> </div>
            </div>
        </div>




        <div class="myinfo" style="padding: 6px; margin-bottom: 15px;background:#fff;">
            <p style="margin:15px 0px;">温馨提示：尊敬的会员，请牢记网站最新提供的二维码支付，别用以前的二维码支付，公司充值金额比较大，需要经常更换二维码，方便为您充值，谢谢配合。</p>
            <table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0" style="margin-top:10px;" height="90">
                <tbody><tr>
                    <td height="34" style="background:#F9F9F9;border-top:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px; font-size:12px; padding-left:10px;">充值类型：</td>
                </tr>
                <tr>
                    <td height="60" style="border-top:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; font-size:16px; text-align:center;">
                        <div class='ttt1'>

                            @if($Payments)
                                @foreach($Payments as $pk=>$Payment)
                                    <input  type="radio" name="paymentid" value="{{$Payment->id}}" title="{{$Payment->pay_name}}" onchange="payconfig({{$Payment->id}})"  class="paymentid{{$Payment->id}}"><img src="/payico/{{$Payment->id}}.png" width="80" onclick="payconfig({{$Payment->id}})"/>
                                @endforeach
                            @endif
                                {{--@if($pk==0) checked="checked"@endif--}}
                        </div>
                    </td>
                </tr>

                </tbody>
            </table>



            <style>
                .tb_class1{
                    background:#F9F9F9;border-top:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;
                }
                .tb_class2{
                    border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; padding-left:5px;
                }
                .tb_class3{
                    background:#F9F9F9;border-top:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px; font-size:16px; text-align:center;
                }
                .tb_class4{
                    margin-top:10px;
                }
            </style>




            <form action="" method="post" id="recharge">



            </form>
        </div>



    </div>

<script>
    @if($Payments)
        @foreach($Payments as $k=> $Payment)
            @if($k==0)
            //payconfig({{$Payment->id}})
            @endif

        @endforeach
    @endif


            var IndexNum=0;
    var picList=new Array();
    var picNameList=new Array();
    $(document).on("click",".fnTab",function(){

        //alert(picNameList[IndexNum]+picList[IndexNum]);
        $(".codepic").attr({src:picList[IndexNum]});
        $(".codepica").attr({href:picList[IndexNum]});
        $(".codename").val(picNameList[IndexNum]);
        IndexNum++;
        if(IndexNum==picList.length){
            IndexNum=0;
        }
    });


    function setImg() {

        $(".codepic").attr({src:picList[IndexNum]});
        $(".codepica").attr({href:picList[IndexNum]});
        $(".codename").val(picNameList[IndexNum]);
    }

    function payconfig(id) {

                $(".paymentid"+id).attr({checked:true});
        var _token=$("[name='_token']").val();
        $.ajax({
            type : "POST",
            url : "{{route("user.payconfig")}}",
            dataType : "json",
            data:{
                payid:id,
                _token:_token,
            },
            success : function (data) {
                if(data.status == 0){


                    $("form").html(data.html);


                }else{


                    layer.open({
                        content: data.msg,
                        btn: '确定',
                        shadeClose: false,
                        yes: function(index){
                            layer.close(index);
                        }
                    });
                }
            }
        });


/*
        layer.open({
            content: id,
            btn: '确定',
            shadeClose: false,
            yes: function(index){

                layer.close(index);
            }
        });*/


    }


    function SubForm() {

       var datas= $("#recharge").serialize();

        $.ajax({
            url: '{{route("user.recharge")}}',
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
                             window.location.reload();
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

