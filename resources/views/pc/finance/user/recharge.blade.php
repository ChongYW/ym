@extends('pc.finance.pc')

@section("header")
    @parent

@endsection

@section("js")

    @parent

@endsection

@section("css")

    @parent
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/user/user.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/user/member.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("pc/finance/css/user/public.css")}}"/>

@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')




    <div class="w1200">
        <div class="cur_pos"><a href="/"> 首页</a> &gt; <a href="{{route('user.index')}}" target="_blank">会员中心</a></div>
        <div class="noticewrapbg" style=" background-color:#FFF">
            <div class="notice">
                <div class="title" style="margin-left:10px;"><a href="#">最新公告</a></div>
                <div class="marquee" style="line-height:24px; font-size:14px; width:1000px;padding-top: 10px;">
                    <ul style="margin-top: 0px;">
                        <marquee scrolldelay="200" onmouseout="this.start()" onmouseover="this.stop()"><strong
                                    style="color: rgb(0, 0, 255); font-family: 'Microsoft YaHei', tahoma, arial, sans-serif; font-size: 18px; line-height: 27px;"> {{Cache::get('gg')}} </strong>
                        </marquee>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="wrapper">


                <div class="clearfix">


                    @include('pc.finance.user.userleft')



                    <div class="r-user-border white-bg bfc">
                        <ul class="user-tabs-menu clearfix" current="2">
                            <li><a href="{{route("user.bank")}}">银行账户</a></li>
                            <li class="selected"><a href="{{route("user.recharge")}}">账户充值</a></li>
                            <li><a href="{{route("user.recharges")}}">充值记录</a></li>
                        </ul>
                        <div class="user-tabs-cont">
                            <div class="u-recharge"><script type="text/javascript"> _baidu_com('trs1')</script><div class="prompt">
                                    <dl>
                                        <dt>
                                            温馨提示：</dt>
                                        <dd>
                                            1. 银行卡快捷充值：单笔限额<font color="#FF0000">50000</font>元，次数不限。</dd>
                                        <dd>
                                            2. 微信充值：扫二维码充值，单笔限额<font color="#FF0000">50000</font>元，次数不限。</dd>
                                        <dd>
                                            3. 手机银行、网银、赠送<font color="#FF0000">1%-3%</font>彩金</dd>

                                    </dl>
                                </div>


                                <div class="accout-tx">


                                        <div class="mb clearfix">
                                            <label>帐户可用余额：</label>
                                            <p><span>￥<font style="color:#F00; font-size:22px;font-weight:700"><?php echo sprintf("%.2f",$Member->amount); ?></font>元</span></p>
                                        </div>


                                        <div class="mb clearfix">
                                            <label><span class="red3">*</span>充值方式：</label>

                                            @if($Payments)
                                                @foreach($Payments as $pk=>$Payment)
                                                    <input  type="radio" name="paymentid" value="{{$Payment->id}}" title="{{$Payment->pay_name}}" onchange="payconfig({{$Payment->id}})" @if($pk==0) checked="checked"@endif class="paymentid{{$Payment->id}}"> <img src="/payico/{{$Payment->id}}.png" width="80" onclick="payconfig({{$Payment->id}})"/>
                                                @endforeach
                                            @endif



                                               </div>


                                        <form action="" method="post" id="recharge">



                                        </form>

                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>






    </div>


    <script>
        @if($Payments)
        @foreach($Payments as $k=> $Payment)
        @if($k==0)
        payconfig({{$Payment->id}})
        @endif

        @endforeach
        @endif

        var IndexNum=0;
        var picList=new Array();
        var picNameList=new Array();
        $(document).on("click",".fnTab",function(){

            //alert(picNameList[IndexNum]+picList[IndexNum]);
            $(".codepic").attr({src:picList[IndexNum]});
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

