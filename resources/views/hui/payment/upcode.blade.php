@extends('hui.layouts.appatc')



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





    <input type="hidden" name="pay_pid"  lay-verify="required" class="layui-input" placeholder="" value="{{ $pid }}">
    <input type="hidden" name="action"  lay-verify="required" class="layui-input" value="{{$action}}">
    <input type="hidden" name="cid"   class="layui-input" value="{{$cid}}">

    @if($action=='add')

    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">名称</label>

        <div class="layui-input-inline">

            <input type="text" name="pay_name"  lay-verify="required" class="layui-input" placeholder="类型" value="{{ $edit->pay_name }}">

        </div>

    </div>



    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">状态</label>

        <div class="layui-input-inline">

                <input type="radio" name="pay_status" value="1" title="上架中" checked="checked">

                <input type="radio" name="pay_status" value="0" title="已下架" >


        </div>

    </div>


    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">展示次数</label>

        <div class="layui-input-inline">

            <input type="text" name="pay_number"  lay-verify="required" class="layui-input" placeholder="展示次数" value="1">

        </div>

    </div>


    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">收款二维码</label>



        <div class="layui-input-block">

            <button type="button" class="layui-btn" id="thumb_wxerw" style="float:left;">
                <i class="layui-icon">&#xe67c;</i>上传二维码
            </button>

            <span class="imgshow_wxerw" style="float:left;width:100%;margin: 2px;">

            </span>

            <input type="text" name="pay_pic"  value="" class="layui-input wxerw" placeholder="微信二维码" style="float:left;width:50%;">





            <script>



                layui.use('upload', function(){


                    var upload = layui.upload;

                    //执行实例
                    var uploadInst = upload.render({
                        elem: '#thumb_wxerw' //绑定元素
                        ,url: '{{route("admin.uploads.uploadimg")}}?_token={{ csrf_token() }}' //上传接口
                        , field:'thumb'
                        ,done: function(src){
                            //上传完毕回调

                            console.log(src);
                            if(src.status==0){
                                layer.msg(src.msg,{time:500},function(){

                                    $(".imgshow_wxerw").html('<img src="'+src.src+'?t='+new Date()+'" width="100" style="float:left;"/>');

                                    $(".wxerw").val(src.src);

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


@else


        <div class="layui-form-item">

            <label class="layui-form-label col-sm-1">名称</label>

            <div class="layui-input-inline">

                <input type="text" name="pay_name"  lay-verify="required" class="layui-input" placeholder="类型" value="{{ $cedit->pay_name }}">

            </div>

        </div>



        <div class="layui-form-item">

            <label class="layui-form-label col-sm-1">状态</label>

            <div class="layui-input-inline">

                <input type="radio" name="pay_status" value="1" title="上架中" @if($cedit->pay_status==1)checked="checked" @endif>

                <input type="radio" name="pay_status" value="0" title="已下架" @if($cedit->pay_status==0)checked="checked" @endif>


            </div>

        </div>


        <div class="layui-form-item">

            <label class="layui-form-label col-sm-1">展示次数</label>

            <div class="layui-input-inline">

                <input type="text" name="pay_number"  lay-verify="required" class="layui-input" placeholder="展示次数" value="{{ $cedit->pay_number }}">

            </div>

        </div>


        <div class="layui-form-item">

            <label class="layui-form-label col-sm-1">收款二维码</label>



            <div class="layui-input-block">

                <button type="button" class="layui-btn" id="thumb_wxerw" style="float:left;">
                    <i class="layui-icon">&#xe67c;</i>上传二维码
                </button>

                <span class="imgshow_wxerw" style="float:left;width:100%;margin: 2px;">
                    @if($cedit->pay_pic!='')
                    <img src="{{ $cedit->pay_pic }}" width="100" style="float:left;"/>
                        @endif
                </span>

                <input type="text" name="pay_pic"  value="{{ $cedit->pay_pic }}" class="layui-input wxerw" placeholder="微信二维码" style="float:left;width:50%;">





                <script>



                    layui.use('upload', function(){


                        var upload = layui.upload;

                        //执行实例
                        var uploadInst = upload.render({
                            elem: '#thumb_wxerw' //绑定元素
                            ,url: '{{route("admin.uploads.uploadimg")}}?_token={{ csrf_token() }}' //上传接口
                            , field:'thumb'
                            ,done: function(src){
                                //上传完毕回调

                                console.log(src);
                                if(src.status==0){
                                    layer.msg(src.msg,{time:500},function(){

                                        $(".imgshow_wxerw").html('<img src="'+src.src+'?t='+new Date()+'" width="100" style="float:left;"/>');

                                        $(".wxerw").val(src.src);

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





