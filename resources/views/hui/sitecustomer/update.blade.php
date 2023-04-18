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
        <label class="layui-form-label">名称</label>

        <div class="layui-input-inline">
            <input type="text" name="name" lay-verify="required" required placeholder="名称" autocomplete="off" class="layui-input" value="{{ $edit->name}}">
        </div>
    </div>





    <div class="layui-form-item">
        <label class="layui-form-label">UUID</label>
        <div class="layui-input-block">
            <a class="layui-btn" onclick="getuuid()" style="float:left;margin-right: 20px">生成UUID</a>
            <input type="text" name="uuid" lay-verify="required" autocomplete="" class="layui-input" placeholder="受权码 40位" value="{{ $edit->uuid}}" style="width:80%;float:left;">

        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">受权域名</label>
        <div class="layui-input-inline">
            <input type="text" name="domains" lay-verify="required" autocomplete="" class="layui-input" placeholder="域名 *表示不限制,多个以 ‘|’分割" value="{{ $edit->domains}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">运行域名</label>
        <div class="layui-input-inline">
            <input type="text" name="runhost" lay-verify="required" autocomplete="" class="layui-input" placeholder="运行域名" value="{{ $edit->runhost}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">类型</label>
        <div class="layui-input-inline">
            <input type="text" name="type" lay-verify="required" autocomplete="" class="layui-input" placeholder="类型" value="{{ $edit->type}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">有效期</label>
        <div class="layui-input-inline">
            <input type="text" name="expiretime" id="expiretime" lay-verify="required" autocomplete="" class="layui-input" placeholder="有效期" value="{{ $edit->expiretime}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">销售金额</label>
        <div class="layui-input-inline">
            <input type="text" name="money" lay-verify="required" autocomplete="" class="layui-input" placeholder="销售金额" value="{{ $edit->money}}">
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">联系人</label>
        <div class="layui-input-inline">
            <input type="text" name="contacts" lay-verify="required" autocomplete="" class="layui-input" placeholder="联系人" value="{{ $edit->contacts}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">电话</label>
        <div class="layui-input-inline">
            <input type="text" name="phone" lay-verify="required" autocomplete="" class="layui-input" placeholder="电话" value="{{ $edit->phone}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">QQ</label>
        <div class="layui-input-inline">
            <input type="text" name="qq" lay-verify="required" autocomplete="" class="layui-input" placeholder="联系人QQ" value="{{ $edit->qq}}">
        </div>
    </div>



@endsection
@section("layermsg")
    @parent
@endsection


@section('form')
    <script>

        layui.use(['form','upload','laydate'], function(){
            var form = layui.form();

            var laydate = layui.laydate;



            var start = {
                min: laydate.now()
                //max: laydate.now()
                ,istoday: false
                ,choose: function(datas){

                }
            };



            document.getElementById('expiretime').onclick = function(){
                start.elem = this;
                laydate(start);
            }




            //各种基于事件的操作，下面会有进一步介绍

            //自定义验证规则
            form.verify({
                name: function(value){
                    if(value.length < 2){
                        return '名称也太短了吧';
                    }
                }

            });




        });

        function getuuid(obj){

            $.post("{{ route($RouteController.".getuuid") }}",{
                _token:"{{ csrf_token() }}"
            },function(data){
                if(data.status==0){
                    $("[name='uuid']").val(data.data);
                }else{
                    layer.msg(data.msg,{icon:5});
                }
            });



        }
    </script>
@endsection




