@extends('hui.layouts.appstore')

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
            <input type="text" name="name" lay-verify="required|name" required placeholder="请输入名称" autocomplete="off" class="layui-input" value="{{ $errors->store->first('name') }}">
        </div>
    </div>






    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">有效天数</label>
        <div class="layui-input-inline">
            <input type="tel" name="expdata" lay-verify="expdata" required autocomplete="" class="layui-input" placeholder="有效时间(天)" value="5">
        </div>
    </div>



    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">排序</label>
        <div class="layui-input-inline">
            <input type="tel" name="sort" lay-verify="sort" required autocomplete="" class="layui-input" placeholder="排序" value="10">
        </div>
    </div>




    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">金额/加息</label>
        <div class="layui-input-inline">
            <input type="text" name="money" lay-verify="required|money" required placeholder="金额/加息(0.01)" autocomplete="off" class="layui-input" value="{{ $errors->store->first('money') }}">
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">类型</label>
        <div class="layui-input-inline">
            <select name="type" lay-filter="s_type">

                @if(config("coupons.type"))
                    @foreach(config("coupons.type") as $tk=>$v)
                        <option value="{{$tk}}" >{{$v}}</option>
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
                            <option value="{{$tk}}">{{$v}}</option>
                        @endforeach
                    @endif

                </select>
            </div>


    </div>






    <div class="layui-form-item layui-form-text">

        <div class="layui-input-block">
            <textarea placeholder="请填写描述" class="layui-textarea" name="remark">{{ $errors->store->first('remarks') }}</textarea>
        </div>
    </div>



@endsection
@section("layermsg")
    @parent
@endsection


@section('form')
    <script>
        layui.use('laydate', function(){
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#offdate' //指定元素
            });


        });

        layui.use('form', function(){
            var form = layui.form;

            //各种基于事件的操作，下面会有进一步介绍

            //自定义验证规则
            form.verify({
                username: function(value){
                    if(value.length < 2){
                        return '帐号也太短了吧';
                    }
                }
                ,password: [/(.+){6,12}$/, '密码必须6到12位']
                ,password2: function(value){
                    if(value != $("input[name='password']").val()){
                        return '两次输入的密码不一致';
                    }
                }
                ,phone: function(value){
                    if(value != '' && !/^1[3|4|5|7|8]\d{9}$/.test(value)){
                        return '手机必须11位，只能是数字！';
                    }
                }

                ,email: function(value){
                    if(value !='' && !/^[a-z0-9._%-]+@([a-z0-9-]+\.)+[a-z]{2,4}$|^1[3|4|5|7|8]\d{9}$/.test(value)){
                        return '邮箱格式不对';
                    }
                }

            });


            });


        </script>
    @endsection
