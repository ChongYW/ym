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

        <label class="layui-form-label col-sm-1">等级名称</label>



        <div class="layui-input-inline">

            <input type="text" name="name" lay-verify="required" required placeholder="等级名称" autocomplete="off" class="layui-input" value="{{ $edit->name }}">

        </div>

    </div>






    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">分红奖励利率</label>

        <div class="layui-input-inline">

            <input type="text" name="rate"   lay-verify="required" class="layui-input" placeholder="充值奖励利率:%" value="{{ $edit->rate }}" >

        </div>
        <label class="layui-form-label col-sm-1" style="text-align: left">%</label>

    </div>







    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">投资额要求</label>

        <div class="layui-input-block">
            <input type="text" name="inte"  class="layui-input " placeholder="投资额要求" value="{{$edit->inte}}" >


        </div>

    </div>


    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">每日玩转次数</label>

        <div class="layui-input-block">
            <input type="text" name="wheels"  class="layui-input " placeholder="每日玩转次数" value="{{$edit->wheels}}">


        </div>

    </div>
<div class="layui-form-item">

        <label class="layui-form-label col-sm-1">等级分佣（%）</label>

        <div class="layui-input-block">
            <input type="text" name="djfy"  class="layui-input " placeholder="百分比" value="{{$edit->djfy}}">


        </div>

    </div>



@endsection

@section("layermsg")

    @parent

@endsection





@section('form')



@endsection





