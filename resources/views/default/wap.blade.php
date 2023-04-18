<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" id="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>@if(isset($title)){{$title}}@else{{\Cache::get('CompanyLong')}}@endif</title>
    <meta name="keywords" content="{{\Cache::get('keywords')}}" />
    <meta name="description" content="{{\Cache::get('description')}}" />


    @section('css')
        <link rel="stylesheet" type="text/css" href="/mobile/static/css/style.css"/>
    @show
    @section('js')

        <script type="text/javascript" src="{{asset("mobile/static/js/jquery.js")}}"></script>
        <script type="text/javascript" src="{{asset("mobile/public/layer_mobile/layer.js")}}"></script>
        <script type="text/javascript" src="{{asset("mobile/static/js/jquery.superslide.2.1.1.js")}}"></script>
    @show

</head>

<body>
<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
@section('header')
@show

<!--主体-->
@yield('body')
<!--主体 end-->

@section('footbox')
@show



@section('footer')

    <div class="footer-copyright">
        <div class="copyright">

            <p>版权所有 © {{\Cache::get("CompanyLong")}}</p>
            <p class="right">
            {{\Cache::get("icp")}}
            </p>



          {{--  <table style="   text-align: center;   margin: 0 auto;">

                <tr>
                    <td><a   title="网站信用"><img  style="width: 90px;height: auto;" src="{{asset("/mobile/img/cert_0_1.png")}}" alt="网站信用" /></a></td>
                    <td><a target="cyxyv" href="https://v.yunaq.com/certificate?domain=www.echejf.com&from=label&code=90030"> <img src="https://aqyzmedia.yunaq.com/labels/label_sm_90030.png"></a></td>

                </tr>
                <tr>

                    <td><a><img  style="width: 90px;height: auto;" src="{{asset("/mobile/img/aqkx_124x47.png")}}" alt="安全联盟认证" width="124" height="47" /></a></td>
                    <td><a><img src="{{asset("/mobile/img/hy_124x47.png")}}" alt="安全联盟认证" width="124" height="47" /></a></td> </tr>




            </table>--}}
            <div style="clear: both;"></div>

            <br>
            <br>
            <br>

        </div>
    </div>
    </div>

@show

@section('footcategory')


   {{-- <!--底部菜单开始--> --}}
    <link href="{{asset("mobile/static/css/zzsc.css")}}" rel="stylesheet" type="text/css"/>
    <script>
        $(function() {
            $(".yb_top").click(function() {
                $("html,body").animate({
                    'scrollTop': '0px'
                }, 300)
            });
        });
    </script>
    <style>
        .f_home {
            background: url('{{asset("mobile/static/images/navhomeh.png")}}') no-repeat top center;
            background-size: 21px;
            color: #D8232C;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        .f_account {
            background: url('{{asset("mobile/static/images/navacc.png")}}') no-repeat top center;
            background-size: 19px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        .f_borrow {
            background: url('{{asset("mobile/static/images/navborrow.png")}}') no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        .f_invest {
            background: url('{{asset("mobile/static/images/navinvest.png")}}') no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        .f_touz {
            background: url('{{asset("mobile/static/images/chongzhi.gif")}}') no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        .f_geng {
            background: url('{{asset("mobile/static/images/shezhi.gif")}}') no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }

        .piaofang {
            background: url('{{asset("mobile/static/images/maoyan.png")}}') no-repeat top center;
            background-size: 21px;
            text-align: center;
            color: #9f9f9f;
            font-size: 12px;
            box-sizing: border-box;
            padding-top: 20px;
        }
        @if(Cache::get('BoxOffice')=='开启')
        .yb_bar ul li {

            width: 16.3%;
            height: 43px;
            font: 16px/53px 'Microsoft YaHei';
            color: #fff;
            text-align: center;
            margin-bottom---: 3px;
            border-radius--: 3px;
            transition: all .5s ease;
            overflow: hidden;
            float: left;
        }
        @endif

    </style>
    <div class="yb_conct">
        <div class="yb_bar">
            <ul>

                @if($footcategory)
                    @foreach($footcategory as $keyi=>$category)

                        @if(Cache::get('BoxOffice')=='开启' && $keyi==3)
                            <li><a href="/piaofang" title="票房" class="piaofang" id="menupf">票房</a></li>


                        @endif

                        @if($category->model=='links')
                            <li><a href="{{$category->links}}" title="{{$category->name}}" class="{{$category->classname}}" id="menu{{$keyi}}">{{$category->name}}</a></li>
                        @else
                            <li><a href="{{route($category->model.".links",["links"=>$category->links])}}" title="{{$category->name}}" class="{{$category->classname}}" id="menu{{$keyi}}">{{$category->name}}</a></li>
                        @endif
                    @endforeach
                @endif


            </ul>
        </div>
    </div>
    {{-- <!--底部菜单结束--> --}}


@show



@section('playSound')
    @if(isset($Member))
<script type="text/javascript">
    //播放提示音
    function playSound(name,str){
        $("#"+name+"").html('<embed width="0" height="0"  src="/mobile/public/Front/sound/'+str+'" autostart="true" loop="false">');

        if(document.getElementById("'"+name+"'")){
            document.getElementById("'"+name+"'").Play();
        }
    }

    function total() {
        $.get("{{route('user.msg')}}",function(data){

            //top_msg = parseInt($("#top_msg").text()); //统计未读短信

            //赋值到模板
            $("#top_msg").html(data.msgs); //统计未读短信

            @if(Cache::get('UserMsgSound')=='开启')
            //未读站内短信提示

            if (data.playSound > 0 && data.msgs > 0) {
                playSound('top_playSound','msg.mp3');
            }else if (data.layims > 0) {
                playSound('top_playSound','default.mp3');
            }

            @endif
        },'json');
    }
    total();
    setInterval("total()",15000);


</script>




    @endif
@show




@section('Memberamount')

@show



@show
<font id="top_playSound"></font>
{!! Cache::get("wapcode") !!}
</body>
</html>