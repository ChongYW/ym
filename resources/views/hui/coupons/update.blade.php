@extends('hui.layouts.appupdate')

@section('title', $title)
@section('here')

@endsection
@section('addcss')
    @parent
@endsection
@section('addjs')
    @parent
@endsection

@section("mainbody")
    @parent
@endsection

@section('formbody')

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">名称</label>

        <div class="layui-input-inline">
            <input type="text" name="name" lay-verify="required|name" required placeholder="请输入名称" autocomplete="off" class="layui-input" value="{{ $edit->name }}">
        </div>
    </div>






    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">有效天数</label>
        <div class="layui-input-inline">
            <input type="tel" name="expdata" lay-verify="expdata" required autocomplete="" class="layui-input" placeholder="有效时间(天)" value="{{ $edit->expdata }}">
        </div>
    </div>



    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">排序</label>
        <div class="layui-input-inline">
            <input type="tel" name="sort" lay-verify="sort" required autocomplete="" class="layui-input" placeholder="排序" value="{{ $edit->sort }}">
        </div>
    </div>




    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">金额/加息</label>
        <div class="layui-input-inline">
            <input type="text" name="money" lay-verify="required|money" required placeholder="金额/加息(0.01)" autocomplete="off" class="layui-input" value="{{ $edit->money }}">
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">类型</label>
        <div class="layui-input-inline">
            <select name="type" lay-filter="s_type">

                @if(config("coupons.type"))
                    @foreach(config("coupons.type") as $tk=>$v)
                        <option value="{{$tk}}" @if($edit->type==$tk) selected="selected" @endif>{{$v}}</option>
                    @endforeach
                @endif

            </select>
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>



    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">状态</label>
        <div class="layui-input-inline">
            <select name="status" lay-filter="s_status">

                @if(config("coupons.status"))
                    @foreach(config("coupons.status") as $tk=>$v)
                        <option value="{{$tk}}" @if($edit->status==$tk) selected="selected" @endif>{{$v}}</option>
                    @endforeach
                @endif

            </select>
        </div>


    </div>






    <div class="layui-form-item layui-form-text">

        <div class="layui-input-block">
            <textarea placeholder="请填写描述" class="layui-textarea" name="remark">{{ $edit->remark }}</textarea>
        </div>
    </div>



@endsection
@section("layermsg")
    @parent
@endsection


@section('form')

@endsection
