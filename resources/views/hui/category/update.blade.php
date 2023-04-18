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

            <input type="text" name="name" lay-verify="required" required placeholder="名称" autocomplete="off" class="layui-input" value="{{ $edit->name }}">

        </div>

    </div>








    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">上级</label>

        <div class="layui-input-inline">

            <select name="parent">
                <option value="0">一级栏目</option>
                {!! $tree_option !!}
            </select>

        </div>

    </div>


    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">模板风格</label>
        <div class="layui-input-block" style="height: 30px;">
                @if($WapTemplates)
                    @foreach($WapTemplates as $v)
                    <input type="checkbox" value="{{$v}}" name="templates[]" title="WAP-{{$v}}" lay-skin="primary" @if(in_array($v,explode(",",$edit->templates)))checked @endif>
                    @endforeach
                @endif
                @if($PcTemplates)
                    @foreach($PcTemplates as $v)
                            <input type="checkbox" value="{{$v}}" name="templates[]" title="PC-{{$v}}" lay-skin="primary" @if(in_array($v,explode(",",$edit->templates)))checked @endif>
                    @endforeach
                @endif


        </div>

    </div>


    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">缩略图</label>



        <div class="layui-input-inline">

            <button type="button" class="layui-btn" id="thumb_url">
                <i class="layui-icon">&#xe67c;</i>上传图片
            </button>

            <br/>

            <input type="hidden" name="thumb_url"  class="thumb" value="{{$edit->thumb_url}}">

            <span class="imgshow">@if($edit->thumb_url!='')<img src="{{$edit->thumb_url}}" width="100" style="float:left;"/>@endif</span>

            <script>

                layui.use('upload', function(){


                    var upload = layui.upload;

                    //执行实例
                    var uploadInst = upload.render({
                        elem: '#thumb_url' //绑定元素
                        ,url: '{{route("admin.uploads.uploadclassifyimgage")}}?_token={{ csrf_token() }}&name=' //上传接口
                        , field:'thumb'
                        ,done: function(src){
                            //上传完毕回调

                            console.log(src);
                            if(src.status==0){
                                layer.msg(src.msg,{time:500},function(){

                                    $(".imgshow").html('<img src="'+src.src+'?t='+new Date()+'" width="100" style="float:left;"/>');

                                    $(".thumb").val(src.src);

                                });
                            }

                        }
                        ,error: function(){
                            //请求异常回调
                        }
                    });

                });

            </script>



        </div>

    </div>




    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">模型</label>

        <div class="layui-input-inline">

            <select name="model" lay-filter="s_model">
                @if($modellist)
                    @foreach($modellist as $v)
                        <option value="{{$v['key']}}" @if($edit->model==$v['key']) selected @endif>{{$v['name']}}</option>
                    @endforeach
                @endif
            </select>

        </div>

    </div>



    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">标题</label>

        <div class="layui-input-inline">

            <input type="text" name="ctitle"  class="layui-input" placeholder="标题" value="{{ $edit->ctitle }}">

        </div>

    </div>



    <div class="layui-form-item " >

        <label class="layui-form-label col-sm-1 links">外链地址</label>

        <div class="layui-input-inline">

            <input type="text" name="links"  class="layui-input" placeholder="外链地址" value="{{ $edit->links }}" >

        </div>

    </div>


    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">关键字</label>

        <div class="layui-input-inline">

            <input type="text" name="ckeywords"  class="layui-input" placeholder="关键字" value="{{ $edit->ckeywords }}" >

        </div>

    </div>
    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">发布时间</label>


        <div class="layui-input-inline">
            <input type="text" name="created_at" placeholder="发布时间" autocomplete="off" class="layui-input" id="created_at" value="{{$edit->created_at}}">
        </div>
    </div>


    <script>

        layui.use(['laydate'], function() {

            var laydate = layui.laydate;
            laydate.render({
                elem: '#created_at' //指定元素
                ,type: 'datetime'
                ,trigger: 'click' //采用click弹出
            });


        });
    </script>

    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">描述</label>

        <div class="layui-input-inline">


            <textarea name="cdescription"  class="layui-textarea">{!!  $edit->cdescription !!}</textarea>



        </div>

    </div>

    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">样式名称</label>

        <div class="layui-input-inline">

            <input type="text" name="classname" lay-verify="" autocomplete="" class="layui-input" placeholder="样式名称" value="{{ $edit->classname }}">

        </div>

    </div>

    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">背景颜色</label>

        <div class="layui-input-inline">

            <input type="tel" name="color" lay-verify="" autocomplete="" class="layui-input" placeholder="背景颜色" value="{{ $edit->color }}">

        </div>

    </div>




    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">排序</label>

        <div class="layui-input-inline">

            <input type="tel" name="sort" lay-verify="required|number" autocomplete="" class="layui-input" placeholder="排序" value="{{ $edit->sort }}">

        </div>

    </div>






    @if(Cache::get('editor')=='markdown')

    <div id="container" class="editor">
        <textarea name="ccontent" style="display:none;">{!! $edit->ccontent !!}</textarea>
    </div>

    @include('markdown::encode',['editors'=>['container']])
    @elseif(Cache::get('editor')=='u-editor')

        @include('UEditor::head')

        <!-- 加载编辑器的容器 -->
        <script id="container" name="ccontent" class="editor" type="text/plain">
            {!!  $edit->ccontent !!}
        </script>


        <!-- 实例化编辑器 -->
        <script type="text/javascript">
            var ue = UE.getEditor('container', {
                autoHeightEnabled: true,
                autoFloatEnabled: true,
                // initialFrameWidth:95,
                initialFrameHeight:300,

            });

            ue.ready(function() {
                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
            });

        </script>

    @else

        <div class="layui-form-item editor">

            <label class="layui-form-label col-sm-1">内容</label>

            <div class="layui-input-block">

        <textarea name="ccontent" id="container" class="layui-hide" lay-filter="container">{!!  $edit->ccontent !!}</textarea>




        <script>

            var layeditIndex;


            layui.use(['form','layedit'], function(){

                var form = layui.form;

                var layedit = layui.layedit;
                layedit.set({
                    uploadImage: {
                        url: '{{route("admin.uploads.uploadeditorimg")}}?_token={{ csrf_token() }}'
                        ,type: 'post'
                    }
                });

                layeditIndex = layedit.build('container', {
                    tool: [
                        'code',
                        'strong' //加粗
                        ,'italic' //斜体
                        ,'underline' //下划线
                        ,'del' //删除线
                        ,'|' //分割线
                        ,'left' //左对齐
                        ,'center' //居中对齐
                        ,'right' //右对齐
                        ,'link' //超链接
                        ,'unlink' //清除链接
                        ,'image' //图片
                    ],
                    height: 400
                });

                $("#layui-btn").click(function(){
                    $("#container").val(layedit.getContent(layeditIndex));
                });

                //自定义验证规则

                form.verify({
                    container: function(value) {
                        layedit.sync(layeditIndex);
                    }
                });

            });

        </script>
                <div>

                </div>
    @endif





@endsection

@section("layermsg")

    @parent

@endsection





@section('form')

    <script>



        var s_classify='{{$edit->parent}}';

        layui.use('form', function(){

            var form = layui.form;


            @if(Cache::get('editor')=='markdown')
            if($("[name='model']").val()=='singlepages'){
                $('.editor').show();
            }else{
                $('.editor').hide();
            }

            @else
            if($("[name='model']").val()=='singlepages'){
                $('.editor').show();
            }else{
                $('.editor').hide();
            }
            @endif



            if($("[name='model']").val()=='links'){
                $('.links').text('外链地址(URL)');
                $("[name='links']").attr({'placeholder':'外链地址(URL)'});
            }else{
                $('.links').text('目录地址(英文)');
                $("[name='links']").attr({'placeholder':'目录地址(英文)'});
            }

            //各种基于事件的操作，下面会有进一步介绍



            //自定义验证规则

            form.verify({





            });



            //监听提交

            form.on('submit(go)', function(data){

                return true;

            });



            form.on('select(s_model)', function(data){

                @if(Cache::get('editor')=='markdown')
                    if(data.value=='singlepages'){
                        $('.editor').show();
                    }else{
                        $('.editor').hide();
                    }
                @else
                    if(data.value=='singlepages'){
                        $('.editor').show();
                    }else{
                        $('.editor').hide();
                    }
                @endif


                if($("[name='model']").val()=='links'){
                    $('.links').text('外链地址(URL)');
                    $("[name='links']").attr({'placeholder':'外链地址(URL)'});
                }else{
                    $('.links').text('目录地址(英文)');
                    $("[name='links']").attr({'placeholder':'目录地址(英文)'});
                }



            });







            var storeid =$("[name='storeid']").val();

            if(storeid>0){

              //  getdatas(storeid);

            }



            function  getdatas(storeid){







            }





            var classify_html='';

            function set_html(classify,index_i=0){

                if(index_i==0){

                    classify_html='';

                }

                var listkeys='';

                for(var ki=0;ki<index_i;ki++){

                    listkeys+='┕';

                }



                for(var i in classify){

                    if(s_classify==classify[i].id){

                        var selected=' selected="selected"';

                    }else{

                        var selected='';

                    }

                    classify_html+='<option value="'+classify[i].id+'" '+selected+'>'+listkeys+classify[i].name+'</option>';



                    if(classify[i].parents.length>0){

                        index_i++;

                        set_html(classify[i].parents,index_i);

                    }

                }

                $(".s_classify").html(classify_html);



                form.render(); //更新全部

            }







        });





    </script>

    @endsection





