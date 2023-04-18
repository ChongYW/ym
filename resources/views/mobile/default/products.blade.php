@extends('mobile.default.wap')

@section("header")
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
                <a href="javascript:;" style="text-align: center;  font-size: 16px; ">{{\Cache::get('CompanyShort')}}</a>

            </div>



        </div>
    </div>



@endsection

@section("js")

    @parent
@endsection

@section("css")
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/user.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/index.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/public.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("mobile/static/css/style.css")}}"/>
    <style>
        .bd .conWrap .con{
            max-width:450px;
            min-width:320px!important;
            height:1430px!important;
            overflow:hidden;
            position:relative!important;

        }
        .bd .conWrap{
            height:auto!important;
            max-width:450px;
            min-width:320px;
        }
        .tzliebli {
            background: #fff;
            overflow: hidden;
            padding: 12px 0;
        }
        .tzliebli li {
            height: 50px;
            padding: 15px 0;
        }
        .tzliebli li a {
            display: block;
            height: 50px;
        }
        .tzliebli li a img {
            float: left;
            height: 50px;
            margin-left: 15px;
        }
        .tzliebli li a span {
            float: right;
            height: 50px;
            line-height: 50px;
            font-size: 20px;
            color: #666;
            font-weight: bold;
            font-family: "宋体";
            padding-right: 16px;
        }
        .tzliebli li font {
            float: left;
            font-size: 16px;
            padding-left: 10px;
            line-height: 24px;
        }
        .tzliebli li font b {
            display: block;
            font-weight: normal;
            font-size: 14px;
            color: #b8b8b8;
        }
    </style>

@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')


    <script type="text/javascript">
        $(".header").remove();
    </script>
    <div class="shouyi"><img src="{{asset("mobile/img/shouyi.jpg")}}"></div>
    <div class="licaibox">
        <div class="bd">
            <div class="main">
                <div class="tzliebli">
                    <ul>



                        @if($ProductsCategoryList)
                            @foreach($ProductsCategoryList as $CategoryList)


                                @if($CategoryList->model=='links')
                                    <li>
                                        <a href="{{$CategoryList->links}}">
                                            <span>></span>
                                            <img src="{{$CategoryList->thumb_url}}">
                                            <font>{{$CategoryList->name}}<b>{{$CategoryList->ckeywords}}</b></font>
                                        </a>
                                    </li>
                                @else

                                    <li>
                                        <a href="{{route($CategoryList->model.".links",["links"=>$CategoryList->links])}}">
                                            <span>></span>
                                            <img src="{{$CategoryList->thumb_url}}">
                                            <font>{{$CategoryList->name}}<b>{{$CategoryList->ckeywords}}</b></font>
                                        </a>
                                    </li>
                                @endif


                            @endforeach
                        @endif

                    </ul>
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

