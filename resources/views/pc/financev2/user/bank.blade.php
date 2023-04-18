@extends('pc.financev2.pc')

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




                    <div class="user-r white-bg bfc">
                        <div class="r-user-border white-bg bfc">
                            <h2 class="r-user-title">银行卡信息</h2>
                            <div class="bank-account clearfix">


                                <div class="bank-account clearfix">


                                    @if( $Member->card=='')



                                    <div class="model-box bank-card fl" style="display:block">



                                        <div class="bank-add-button">
                                            <a href="{{route("user.security")}}" class="red">请实名认证后再来添加银行卡,点我立即认证</a>
                                        </div>


                                    </div>

                                    @else


                                        @if( $Member->bankrealname=='' || $Member->bankname=='' || $Member->bankcode=='' || $Member->bankaddress=='')
                                        <form action="" method="post" class="layui-form">

                                        <div class="fl" style="display:block">
                                            <div class="cle"></div>


                                            <div id="real_name_div" class="window-cont layui-layer-wrap" style="display: ;">
                                                <div class="bank-ts">您绑定银行卡的开户名必须与您认证的实名一致，否则将无法成功提现。</div>
                                                <div class="bank-form">
                                                    <div class="mb clearfix">
                                                        <label>开户人姓名:</label>
                                                        <p> <input name="bankrealname" id="cardname" value="{{$Member->bankrealname}}"  type="text">
                                                        </p>
                                                    </div>
                                                    <div class="mb clearfix">
                                                        <label>选择银行:</label>
                                                        <p>

                                                            <input name="bankname" id="bankname" value="{{$Member->bankname}}" type="text">


                                                        </p>
                                                    </div>
                                                    <div class="mb clearfix">
                                                        <label>账号:</label>
                                                        <p>
                                                            <input name="bankcode" id="bankcard" value="{{$Member->bankcode}}" type="text">
                                                        </p>
                                                    </div>
                                                    <div class="mb clearfix">
                                                        <label>开户行:</label>
                                                        <p>
                                                            <input name="bankaddress" id="kaihuhang" value="{{$Member->bankaddress}}" type="text">
                                                        </p>
                                                    </div>
                                                    <div class="sure-btn clearfix">
                                                        <input class="btn green-btn" onclick="SubForm()" id="subcard" type="button" value="立即添加">
                                                        <span id="tip" style="color:#F00;"></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                        </form>

                                        <script>


                                            //Demo
                                            layui.use('form', function(){
                                                var form = layui.form;

                                                //监听提交
                                                form.on('submit(formDemo)', function(data){
                                                    layer.msg(JSON.stringify(data.field));
                                                    return false;
                                                });

                                                form.render();
                                            });


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
                                                                    window.location.href='{{route('user.index')}}';
                                                                }

                                                                layer.close(index);
                                                            }
                                                        });
                                                    }
                                                });
                                            }

                                        </script>


                                            @else

                                            <div class="fl" style="display:block">
                                                <div class="cle"></div>



                                                <div class="model-box bank-card newBankCard">
                                                    <div class="head">
                                                        <div class="bank-logo">{{$Member->bankname}}</div>
                                                    </div>
                                                    <div class="content">
                                                        <ul>
                                                            <li><b>卡号</b> <em>{{$Member->bankcode}}</em></li>
                                                            <li><b>户名</b>{{$Member->bankrealname}}</li>
                                                            <li class="clearfix"><b>开户行</b>
                                                                <span class="ov-h">
          {{$Member->bankaddress}}</span> </li>
                                                        </ul>
                                                    </div>
                                                    <div class="foot">
                                                        <div class="bank-action"></div>
                                                    </div>
                                                </div>
                                                </div>

                                            @endif

                                        @endif

                                </div>






                                {{--<div class="fl" style="display:block">
                                    <div class="cle"></div>



                                    <div class="model-box bank-card newBankCard">
                                        <div class="head">
                                            <div class="bank-logo">中国农业银行</div>
                                        </div>
                                        <div class="content">
                                            <ul>
                                                <li><b>尾号</b> <em>6226235614782356</em></li>
                                                <li><b>户名</b>张三丰</li>
                                                <li class="clearfix"><b>开户行</b> <span class="ov-h">
          合肥长江支行</span> <!----></li>
                                            </ul>
                                        </div>
                                        <div class="foot">
                                            <div class="bank-action"></div>
                                        </div>
                                    </div>





                                    <div id="real_name_div" class="window-cont" style="display:">
                                        <div class="bank-ts">您绑定银行卡的开户名必须与您认证的实名一致，否则将无法成功提现。</div>
                                        <div class="bank-form">
                                            <div class="mb clearfix">
                                                <label>开户人姓名:</label>
                                                <p> <input name="info[cardname]" id="cardname" value="张三丰" disabled="disabled" type="text">
                                                </p>
                                            </div>
                                            <div class="mb clearfix">
                                                <label>选择银行:</label>
                                                <p>
                                                    <select class="inputSelect" name="info[yinhang]" id="yinhang">
                                                        <option value="">--请选择--</option>

                                                        <option value="中国农业银行">中国农业银行</option>
                                                        <option value="中国工商银行">中国工商银行</option>
                                                        <option value="中国建设银行">中国建设银行</option>
                                                        <option value="中国银行">中国银行</option>
                                                        <option value="招商银行">招商银行</option>
                                                        <option value="交通银行">交通银行</option>
                                                        <option value="浦发银行">浦发银行</option>
                                                        <option value="广发银行">广发银行</option>
                                                        <option value="中信银行">中信银行</option>
                                                        <option value="中国光大银行">中国光大银行</option>
                                                        <option value="兴业银行">兴业银行</option>
                                                        <option value="深圳发展银行">深圳发展银行</option>
                                                        <option value="中国民生银行">中国民生银行</option>
                                                        <option value="华夏银行">华夏银行</option>
                                                        <option value="平安银行">平安银行</option>
                                                        <option value="中国邮政储蓄银行">中国邮政储蓄银行</option>
                                                        <option value="渤海银行">渤海银行</option>
                                                        <option value="东亚银行">东亚银行</option>
                                                        <option value="宁波银行">宁波银行</option>
                                                        <option value="微商银行">微商银行</option>
                                                        <option value="富滇银行">富滇银行</option>
                                                        <option value="广州银行">广州银行</option>
                                                        <option value="上海农村商业银行">上海农村商业银行</option>
                                                        <option value="大连银行">大连银行</option>
                                                        <option value="东莞银行">东莞银行</option>
                                                        <option value="河北银行">河北银行</option>
                                                        <option value="江苏银行">江苏银行</option>
                                                        <option value="宁夏银行">宁夏银行</option>
                                                        <option value="齐鲁银行">齐鲁银行</option>
                                                        <option value="厦门银行">厦门银行</option>
                                                        <option value="苏州银行">苏州银行</option>
                                                        <option value="温州市商业银行">温州市商业银行</option>
                                                        <option value="上海银行">上海银行</option>
                                                        <option value="杭州银行">杭州银行</option>
                                                        <option value="南京银行">南京银行</option>
                                                    </select>
                                                </p>
                                            </div>
                                            <div class="mb clearfix">
                                                <label>账号:</label>
                                                <p>
                                                    <input name="info[bankcard]" id="bankcard" value="" type="text">
                                                </p>
                                            </div>
                                            <div class="mb clearfix">
                                                <label>开户行:</label>
                                                <p>
                                                    <input name="info[kaihuhang]" id="kaihuhang" value="" type="text">
                                                </p>
                                            </div>
                                            <div class="sure-btn clearfix">
                                                <input class="btn green-btn" onclick="bankcards();" id="subcard" type="button" value="立即添加">
                                                <span id="tip" style="color:#F00;"></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>--}}

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>






    </div>





@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

