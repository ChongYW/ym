@extends('pc.financev2.pc')

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
            <ul class="art_list" id="view">
            @if($articlescategory)
                @foreach($articlescategory as $item)

                    <li>
                        <div class="title">
                            <h3>
                                <a href="{{route("singlepage",["links"=>$item->links])}}">&nbsp;{{$item->name}}</a>
                                <a href="{{route("singlepage",["links"=>$item->links])}}" class="show_detai show_detai_all">详情&gt;</a>
                            </h3>
                            <p><span>日期：&nbsp;{{$item->created_at}} </span></p>
                        </div>

                    </li>


                @endforeach
            @endif
            </ul>
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

