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

    <div class="othertop">发现</div>
    <h1 class="about_tit" style="background:#f1f1f1;">关于我们</h1>
    <ul class="about_outer">
        <li>
            @if($articlescategory)
                @foreach($articlescategory as $item)
                    <a href="{{route("singlepage",["links"=>$item->links])}}" class="commSafe accRight"><img src="{{$item->thumb_url}}">{{$item->name}}</a>
                @endforeach
            @endif
        </li>
    </ul>




@endsection

@section('footcategoryactive')

@endsection
@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

