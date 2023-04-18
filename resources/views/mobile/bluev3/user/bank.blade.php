@extends('mobile.bluev3.wap')

@section("header")

@endsection

@section("css")

    @parent

@endsection

@section("js")

    @parent


@endsection

@section("onlinemsg")

@endsection

@section('body')


    <?php
    if($Member->realname==''){
    ?>
    <script>
        layer.open({
            content: '请先进行实名认证',
            btn: '确定',
            shadeClose: false,
            yes: function(index){
                parent.location.href='{{route("user.certification")}}';

                layer.close(index);
            }
        });
    </script>
    <?php
      }
    ?>





    <div class="othertop">
        <a class="goback" href="{{route('user.index')}}"><img src="{{asset("mobile/bluev3/img/goback.png")}}" style="margin: 0px;"/></a>
        <div class="othertop-font">绑定银行卡</div>
    </div>


    <div class="header-nbsp"></div>


    @if($Member->isbank==1)

        <div class="mycard">
            <p>
                <span class="card_name">{{$Member->bankname}}  [储蓄卡]</span>
                <a href="#" style="float: right;">{{$Member->realname}}</a>
            </p>
            <p><span class="card_type">{{$Member->bankaddress}}</span></p>
            <p>
                <span class="card_num">{{$Member->bankcode}}</span>

            </p>
        </div>






   @else


    <form action="" method="post" class="mycard_add" style="display: block">
        <h3>添加银行卡</h3>
        <div class="input_text">
            <i><img src="/mobile/bluev3/img/icon_card.png"></i>
            <input type="text" name="bankrealname" class="right" id="bankrealname" value="{{$Member->realname}}" placeholder="请输入开户人姓名">
        </div>

        <div class="input_text">
            <i><img src="/mobile/bluev3/img/icon_card.png"></i>
            <input type="text" name="bankname" id="bankname" placeholder="请输入所属银行，如：中国工商银行">
        </div>
        <div class="input_text">
            <i><img src="/mobile/bluev3/img/icon_card.png"></i>
            <input type="text" name="bankaddress" id="bankaddress" value="{{$Member->bankaddress}}" placeholder="请输入开户银行，如：北京海定区支行">
        </div>
        <div class="input_text">
            <i><img src="/mobile/bluev3/img/icon_card.png"></i>
            <input type="text" name="bankcode" id="bankcode" value="{{$Member->bankcode}}" placeholder="请输入储蓄卡号">
        </div>
        <div class="error_tips"></div>
        <p class="action">
            <input class="finishReg sub" onclick="SubForm();" id="subcard" type="button" value="立即添加">

            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>



        </p>
    </form>









    <script>


        function SubForm(id) {


            $.ajax({
                url: '{{route("user.bank")}}',
                type: 'post',
                data: $("form").serialize(),
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
                                history.go(-1);
                            }

                            layer.close(index);
                        }
                    });
                }
            });
        }

    </script>
@endif

@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

