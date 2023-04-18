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

        <div class="othertop-font">{{$title}}</div>
    </div>
    <div class="news_detail">

        <div> {!! \App\Formatting::Format($article->ccontent) !!}</div>
    </div>


    <style>

        .news_detail img{
            width: 100%;
        }
    </style>
@endsection

@section('footcategoryactive')

@endsection
@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

