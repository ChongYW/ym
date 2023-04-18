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


@endsection

@section("js")
    @parent

     <script type="text/javascript" src="{{ asset("admin/lib/layui/layui.js")}}" charset="utf-8"></script>
@endsection

@section("css")

    @parent

    <style type="text/css">

        .top{
            position: fixed;
        }
    </style>
@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')

    <div style="display:block;height: 40px;" class="baidutj"></div>

    <div class="post">
        <div class="post-meta" style="background-color: #ffffff;">新闻资讯 > <a href="#">{{$article->category_name}}</a></div>
        <div class="post-main">
            <h3>{{\App\Formatting::Format($article->title)}}</h3>
            <p class="date"></p>
            <div class="post-bd">

                @if(Cache::get('editor')=='markdown')


                    <div id="container" class="editor">
                        <textarea name="content" style="display:none;">{!! \App\Formatting::Format($article->content) !!}</textarea>
                    </div>

                    @include('markdown::decode',['editors'=>['container']])

                @else
                    {!! \App\Formatting::Format($article->content) !!}
                @endif



            </div>
        </div>
    </div>

    <div class="abpic">
    </div>








@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

