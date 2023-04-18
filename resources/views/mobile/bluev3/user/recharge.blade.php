@extends('mobile.bluev3.wap')

@section("header")

@endsection

@section("js")
    @parent
<script type="text/javascript" src="{{ asset("js/clipboard.min.js")}}" charset="utf-8"></script>
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
        <div class="othertop-font">充值</div>
    </div>

    <div class="header-nbsp"></div>
    <div class="record_outer">
    <table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0" style="margin-top:10px;" height="90">
        <tbody><tr>
            <td height="34" style="background:#F9F9F9;border-top:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px; font-size:12px; padding-left:10px;">充值请联系客服：</td>
        </tr>
        <tr>
            <td height="60" style="border-top:#e6e6e6 solid 1px;border-left:#e6e6e6 solid 1px;border-right:#e6e6e6 solid 1px;border-bottom:#e6e6e6 solid 1px; font-size:16px; text-align:center;">
                <div class='ttt1'>

                    @if($Payments)
                        @foreach($Payments as $pk=>$Payment)
                            <input  type="radio" name="paymentid" value="{{$Payment->id}}" title="{{$Payment->pay_name}}" onchange="payconfig({{$Payment->id}})"  class="paymentid{{$Payment->id}}"><img src="/payico/{{$Payment->id}}.png" width="80" onclick="$('.paymentid{{$Payment->id}}').click()"/>
                        @endforeach
                    @endif

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
            #recharge img{
                width: 50%;
            }
        </style>


        <form id="recharge">



        </form>
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

            var _token="{{csrf_token()}}";
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



        function keydown(obj){

            var paymentid=$("[name='paymentid']").val();
            if($(obj).val()>=$(obj).data('min')){
                $('.pay_pic').show();
            }else{
                $('.pay_pic').hide();

            }

            if($(obj).val()>$(obj).data('max') && $(obj).data('max')>0){
               layer.alert('单笔充值最高'+$(obj).data('max')+'元');
                $(obj).val($(obj).data('max'));
                //$('.pay_pic').hide();
            }
        }

    </script>
        <script type="text/javascript" src="/layim/layui.js"></script>

        <link rel="stylesheet" type="text/css" href="/layim/css/layui.css"/>

<script>

            layui.use('upload', function(){


                var upload = layui.upload;

                //执行实例
                var uploadInst = upload.render({
                    elem: '#thumb_url' //绑定元素
                    ,url: '{{route("uploads.uploadimg")}}?_token={{ csrf_token() }}' //上传接口
                    , field:'thumb'
                    ,done: function(src){
                        //上传完毕回调

                        console.log(src);
                        if(src.status==0){
                            layer.msg(src.msg,{time:500},function(){

                                $(".imgshow").html('<img src="'+src.src+'?t='+new Date()+'" width="100" style="float:left;"/>');



                            });
                        }

                    }
                    ,error: function(){
                        //请求异常回调
                    }
                });

            });



        </script>






@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

