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

        <label class="layui-form-label col-sm-1">类型</label>



        <div class="layui-input-inline">

            <input type="text" name="pay_code" lay-verify="required" required placeholder="类型" autocomplete="off" class="layui-input" value="{{ $edit->pay_code }}">

        </div>

    </div>










    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">名称</label>

        <div class="layui-input-inline">

            <input type="text" name="pay_name"  lay-verify="required" class="layui-input" placeholder="名称" value="{{ $edit->pay_name }}">

        </div>

    </div>


    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">手动收款码切换</label>
        <div class="layui-input-block">
            <input type="radio" name="pay_pic_on" value="1" title="启用切换" @if($edit->pay_pic_on==1)checked="checked"@endif>

            <input type="radio" name="pay_pic_on" value="0" title="禁用切换" @if($edit->pay_pic_on==0)checked="checked"@endif>


        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">自动收款码切换</label>
        <div class="layui-input-block">
            <input type="radio" name="pay_pic_auto" value="1" title="启用自动切换" @if($edit->pay_pic_auto==1)checked="checked"@endif>
            <input type="radio" name="pay_pic_auto" value="2" title="启用自动下架" @if($edit->pay_pic_auto==2)checked="checked"@endif>

            <input type="radio" name="pay_pic_auto" value="0" title="禁用自动" @if($edit->pay_pic_auto==0)checked="checked"@endif>


        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">自动收款码切换笔数</label>
        <div class="layui-input-block">
            <input type="text" name="pay_order_number"  lay-verify="required" class="layui-input pay_order_number" placeholder="自动收款码切换笔数" value="{{ $edit->pay_order_number }}">


        </div>
    </div>






    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">收款码名称</label>

        <div class="layui-input-inline">

            <input type="text" name="pay_codename"  lay-verify="required" class="layui-input pay_codename" placeholder="收款码名称" value="{{ $edit->pay_codename }}">

        </div>

    </div>





    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">收款二维码</label>



        <div class="layui-input-block">

            <button type="button" class="layui-btn" id="thumb_wxerw" style="float:left;">
                <i class="layui-icon">&#xe67c;</i>上传二维码
            </button>

            <span class="imgshow_wxerw" style="float:left;width:100%;margin: 2px;">
                 <img src="{{$edit->pay_pic}}" width="100" style="float:left;"/>
            </span>

            <input type="text" name="pay_pic"  value="{{$edit->pay_pic}}" class="layui-input wxerw" placeholder="微信二维码" style="float:left;width:50%;">





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



<style>

    .boxbroder{
        border: 2px #0E774A solid;
    }

    .boxbroder img {
        height: 276px;
    }
</style>



    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">选择收款码</label>

        <div class="layui-input-block">


        @foreach($codes as $code)
                <span class="box{{$code->id}} @if($code->pay_name==$edit->pay_codename) boxbroder @endif" style="float:left;width:20%;margin: 2px;float: left;">

                    <div style="position:absolute;z-index:101;margin-top:5px;margin-left:5px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;background-color:#FF6A78;color:#F5F2F2;">名称:{{$code->pay_name}}</div>

                    <div style="position:absolute;z-index:101;margin-top:30px;margin-left:5px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;background-color:{{$code->pay_status?'darkgreen':'red'}};color:#F5F2F2;">状态:{{$code->pay_status?'上架中':'已下架'}}</div>

                    <div style="position:absolute;z-index:101;margin-top:55px;margin-left:5px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;background-color:black;color:#F5F2F2;">次数:{{$code->pay_number}}</div>

                    <img src="{{$code->pay_pic}}" width="100%" height="280" style="float:left;" onclick="setcode('{{$code->id}}','{{$code->pay_name}}','{{$code->pay_pic}}')"/>




                    <div style="bottom:10px;z-index:101;margin-bottom:15px;margin-right:5px;text-align:center; border-radius: 5px;padding-left:5px;padding-right:5px;background-color:#CCCCCC;color:#F5F2F2;">

                        <i class="layui-icon" style="font-size: 26px;color: green;margin-right: 10px;" onclick="edit_code({{$code->id}},{{$code->pay_pid}})">&#xe642;</i>

                        <i class="layui-icon" style="font-size: 26px;color: red;" onclick="delcode({{$code->id}})">&#xe640;</i>
                    </div>




            </span>
        @endforeach



        </div>

    </div>








    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">收款银行</label>

        <div class="layui-input-inline">

            <input type="text" name="recipient_bank"  class="layui-input recipient_bank" placeholder="收款银行" value="{{ $edit->recipient_bank }}">

        </div>

    </div>




    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">收款人</label>

        <div class="layui-input-inline">

            <input type="text" name="recipient_payee"   class="layui-input recipient_payee" placeholder="收款人" value="{{ $edit->recipient_payee }}">

        </div>

    </div>




    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">收款帐号</label>

        <div class="layui-input-inline">

            <input type="text" name="recipient_account"  class="layui-input recipient_account" placeholder="收款帐号" value="{{ $edit->recipient_account }}">

        </div>

    </div>





    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">银行信息</label>

        <div class="layui-input-block">


            <textarea name="pay_bank"   class="layui-textarea">{!!  $edit->pay_bank !!}</textarea>



        </div>

    </div>


    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">支付说明</label>

        <div class="layui-input-block">


            <textarea name="pay_desc"    class="layui-textarea">{!!  $edit->pay_desc !!}</textarea>



        </div>

    </div>



    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">状态</label>
        <div class="layui-input-block">
            <input type="radio" name="enabled" value="1" title="启用" @if($edit->enabled==1)checked="checked"@endif>

            <input type="radio" name="enabled" value="0" title="禁用" @if($edit->enabled==0)checked="checked"@endif>


        </div>
    </div>


<script>
    function setcode(id,pay_codename,src) {

        $(".boxbroder").removeClass("boxbroder");
        $(".box"+id).addClass("boxbroder");
        $(".imgshow_wxerw").html('<img src="'+src+'?t='+new Date()+'" width="100" style="float:left;"/>');

        $(".wxerw").val(src);
        $(".pay_codename").val(pay_codename);
    }


    function edit_code(cid,pid) {


        var index=   layer.open({
            title:'上传收款二维码',
            type: 2,
            fixed: false,
            maxmin: true,
            area: ['95%', '95%'],
            btn:['更新','取消'],
            yes:function(index,layero){
                var ifname="layui-layer-iframe"+index;
                var Ifame=window.frames[ifname];
                var FormBtn=eval(Ifame.document.getElementById("layui-btn"));
                FormBtn.click();
            },
            content: ['{{ route($RouteController.".upcode")}}?action=edit&cid='+cid+'&id='+pid,'yes'],
            end: function () {
                location.reload(true);

            },
            error: function(msg) {
                var json=JSON.parse(msg.responseText);
                var errormsg='';
                $.each(json,function(i,v){
                    errormsg+=' <br/>'+ v.toString();
                } );
                layer.alert(errormsg);

            }
        });
    }


    function delcode(id) {

        layer.confirm('确认要删除选中吗？',function(index) {
            $.post("{{ route($RouteController.".codedelete") }}", {
                _token: "{{ csrf_token() }}",
                id: id
            }, function (data) {


                if (data.status == 0) {
                    layer.msg(data.msg, {time: "2000"}, function () {

                        $(".box" + id).remove();


                    });
                } else {
                    layer.msg(data.msg, {icon: 5, time: "1000"});
                }


            });
        });
    }
</script>


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





