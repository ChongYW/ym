@extends('pc.finance.pc')

@section("header")
    @parent
@endsection

@section("js")
    @parent
    <script type="text/javascript" src="{{ asset("admin/lib/layui/layui.js")}}" charset="utf-8"></script>
@endsection

@section("css")
    @parent
    <link href="{{asset("admin/lib/layui/css/layui.css")}}" rel="stylesheet" type="text/css"/>
@endsection



@section('body')



    <div class="w1190 article">
        <!--左侧导航-->
        <script type="text/javascript" src="/public/minileft.asp"></script><div class="art_menu"><h2>网站栏目</h2><ul>

                @if(isset($NavCategory))
                    @foreach($NavCategory as $nak=>$categoryb)

                        @if($categoryb->model!='links')

                            @if(isset($category))
                                <li><a @if($categoryb->id==$category->id) class="now" @endif href="{{route($categoryb->model.".links",["links"=>$categoryb->links])}}">{{$categoryb->name}}</a></li>
                            @else
                                <li><a href="{{route($categoryb->model.".links",["links"=>$categoryb->links])}}">{{$categoryb->name}}</a></li>
                            @endif

                        @endif

                    @endforeach
                @endif

            </ul></div>

        <div class="art_detail">
            <div class="art_detai_tit">

                <h3>{{\App\Formatting::Format($article->name)}}</h3>
                <p><span>发布时间：{{$article->created_at}}</span> </p>
            </div>
            <div class="art_detai_cont">
                @if(Cache::get('editor')=='markdown')


                    <div id="container" class="editor">
                        <textarea name="content" style="display:none;">{!! \App\Formatting::Format($article->ccontent) !!}</textarea>
                    </div>

                    @include('markdown::decode',['editors'=>['container']])

                @else
                    {!! \App\Formatting::Format($article->ccontent) !!}
                @endif
            </div>
        </div>

    </div>

    <div class="cle"></div>






@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

