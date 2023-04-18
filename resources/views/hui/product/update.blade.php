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
        <label class="layui-form-label col-sm-1">栏目</label>
        <div class="layui-input-inline">
            <select name="category_id">
                {!! $tree_option !!}

            </select>

        </div>
    </div>




    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">项目排序</label>

        <div class="layui-input-inline">
            <input type="text" name="sort" placeholder="项目排序" autocomplete="off" class="layui-input" lay-verify="required" value="{{$edit->sort}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">会员等级</label>

        <div class="layui-input-inline">


            <select name="level">
                @if($memberlevel)
                    @foreach($memberlevel as $level)
                        <option value="{{$level->id}}" @if($edit->level==$level->id) selected="selected" @endif>{{$level->name}}</option>
                    @endforeach
                @endif

            </select>


        </div>
    </div>
    
    
    
    
    
    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">赠送项目id</label>

        <div class="layui-col-md3">
            <input type="text" name="zsid" lay-verify="required" required placeholder="赠送项目id" autocomplete="off" class="layui-input" value="{{$edit->zsid}}">
        </div>
    </div>
    
    
    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">赠送项目金额</label>

        <div class="layui-col-md3">
            <input type="text" name="zsje" lay-verify="required" required placeholder="赠送项目金额" autocomplete="off" class="layui-input" value="{{$edit->zsje}}">
        </div>
    </div>  
    
    
    

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">项目名称</label>

        <div class="layui-col-md3">
            <input type="text" name="title" lay-verify="required" required placeholder="项目名称" autocomplete="off" class="layui-input" value="{{$edit->title}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">项目副标题</label>

        <div class="layui-col-md3">
            <input type="text" name="shorttitle"  placeholder="项目副标题" autocomplete="off" class="layui-input" value="{{$edit->shorttitle}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">保理机构<font color="#FF0000">*</font></label>

        <div class="layui-col-md3">
            <input type="text" name="bljg" placeholder="保理机构" lay-verify="required" autocomplete="off" class="layui-input" value="{{$edit->bljg}}">
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">项目规模</label>

        <div class="layui-col-md3">
            <input type="text" name="xmgm" placeholder="项目规模 :x万" lay-verify="required" autocomplete="off" class="layui-input" value="{{$edit->xmgm}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">投资进度</label>

        <div class="layui-input-inline">
            <input type="text" name="xmjd" placeholder="投资进度" lay-verify="required" autocomplete="off" class="layui-input" value="{{$edit->xmjd}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">可投金额提示</label>

        <div class="layui-input-inline">
            <input type="text" name="ketouinfo" placeholder="可投金额提示" lay-verify="required" autocomplete="off" class="layui-input" value="{{$edit->ketouinfo}}">
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">进度自增量</label>

        <div class="layui-input-inline">
            <input type="text" name="rise" placeholder="进度自增量" lay-verify="required" autocomplete="off" class="layui-input" value="{{$edit->rise}}">
        </div>

        <label class="layui-form-label col-sm-1">进度自增次数</label>

        <div class="layui-input-inline">
            <input type="text" name="frequency" placeholder="进度自增次数" lay-verify="required" autocomplete="off" class="layui-input" value="{{$edit->frequency}}">
        </div>

        <label class="layui-form-label col-sm-1">操作间隔时间(小时)</label>

        <div class="layui-input-inline">
            <input type="text" name="interval_time" placeholder="进度间隔时间" lay-verify="required" autocomplete="off" class="layui-input" value="{{$edit->interval_time}}">
        </div>

        <label class="layui-form-label col-sm-1">自增操作时间</label>

        <div class="layui-input-inline">
            <input type="text" name="rise_time" placeholder="进度自增操作时间"  autocomplete="off" class="layui-input" value="{{$edit->rise_time}}">
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">起投金额</label>

        <div class="layui-input-inline">
            <input type="text" name="qtje" placeholder="起投金额" autocomplete="off" class="layui-input" value="{{$edit->qtje}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">最高金额</label>

        <div class="layui-input-inline">
            <input type="text" name="zgje" placeholder="最高金额  (0为无限制)" autocomplete="off" class="layui-input" value="{{$edit->zgje}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">投资人数</label>

        <div class="layui-input-inline">
            <input type="text" name="tzrs" placeholder="投资人数:x人" autocomplete="off" class="layui-input" value="{{$edit->tzrs}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">还款方式</label>

        <div class="layui-input-inline">
            <select name="hkfs">
                <option value="0" @if($edit->hkfs==0) selected="selected" @endif>按天付收益，到期还本</option>
                <option value="3" @if($edit->hkfs==3) selected="selected" @endif>按天付收益，等额本息返还</option>
                <option value="2" @if($edit->hkfs==2) selected="selected" @endif>按小时付收益，到期还本</option>
                <option value="1" @if($edit->hkfs==1) selected="selected" @endif>到期还本,到期付息</option>
                <option value="4" @if($edit->hkfs==4) selected="selected" @endif>每日复利,保本保息</option>
                     <option value="5" @if($edit->hkfs==5) selected="selected" @endif>5天付收益，到期还本</option>
                    <option value="10" @if($edit->hkfs==10) selected="selected" @endif>10天付收益，到期还本</option>
                    <option value="30" @if($edit->hkfs==30) selected="selected" @endif>30天付收益，到期还本</option>
                
                
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">是否重投</label>

        <div class="layui-input-inline">
            <select name="isft">
                <option value="0" @if($edit->isft==0) selected="selected" @endif>不能复投</option>
                <option value="1" @if($edit->isft==1) selected="selected" @endif>可以复投</option>
            </select>
        </div>

        <label class="layui-form-label col-sm-1">重投次数</label>
        <div class="layui-input-inline">
            <input type="number" name="futoucishu" placeholder="复投限制次数" autocomplete="off" class="layui-input" value="{{$edit->futoucishu}}" style="width: 70%">
        </div>



    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">可投金额</label>

        <div class="layui-input-inline">
            <input type="text" name="ktje" placeholder="可投金额: x元" autocomplete="off" class="layui-input" value="{{$edit->ktje}}">
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">交易收益</label>

        <div class="layui-input-inline">
            <input type="text" name="jyrsy" placeholder="交易收益: x%" autocomplete="off" class="layui-input" value="{{$edit->jyrsy}}">
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">下线提成设置(投资购买)</label>

        <div class="layui-input-inline">
            <select name="xxtc" lay-filter="xxtc">
                <option value="0" @if($edit->xxtc==0) selected="selected" @endif>系统提成比例</option>
                <option value="1" @if($edit->xxtc==1) selected="selected" @endif>自定义提成比例</option>
            </select>
        </div>

    </div>


        <?php
        $Memberticheng=\App\Memberticheng::orderBy("id","asc")->get();
        ?>
        @foreach($Memberticheng as $ticheng)
        <div class="layui-form-item xxtcblBox" @if($edit->xxtc==0) style="display: none;" @endif>
        <label class="layui-form-label layui-input-inline">{{$ticheng->name}}提成(%)</label>
        <div class="layui-input-inline">
            <input type="text" name="xxtcbl[{{$ticheng->id}}]" placeholder="{{$ticheng->name}}提成" autocomplete="off" class="layui-input" @if(isset($edit->xxtcbldata[$ticheng->id])) value="{{$edit->xxtcbldata[$ticheng->id]}}" @else value="0" @endif >
        </div>
        </div>
        @endforeach






    <div class="layui-form-item ">
        <label class="layui-form-label col-sm-1">购买记录数据</label>


        <div class="buydataList">

                <div class="layui-input-inline">
                    <label class="layui-form-label col-sm-1">最小购买数</label>
                    <input type="text" name="buydata[0]" placeholder="最小购买数" autocomplete="off" class="layui-input buydata" @if(isset($edit->buydatas[0]))value="{{$edit->buydatas[0]}}"@endif style="width: 80%;float: left;" lay-verify="required">
                </div>

                <div class="layui-input-inline">
                    <label class="layui-form-label col-sm-1">最大购买数</label>
                    <input type="text" name="buydata[1]" placeholder="最大购买数" autocomplete="off" class="layui-input buydata" @if(isset($edit->buydatas[1]))value="{{$edit->buydatas[1]}}"@endif style="width: 80%;float: left;" lay-verify="required">
                </div>

                <div class="layui-input-inline">
                    <label class="layui-form-label col-sm-1">基数位数</label>
                    <input type="text" name="buydata[2]" placeholder="基数位数" autocomplete="off" class="layui-input buydata" @if(isset($edit->buydatas[2]))value="{{$edit->buydatas[2]}}"@endif style="width: 80%;float: left;" lay-verify="required">
                </div>

        </div>


    </div>





    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">收益佣金倍数(投资分红)</label>

        <div class="layui-col-md6">
            <input type="text" name="tqsyyj" placeholder="提成收益佣金倍数 (填0本项目无佣金，填1为系统设置下线佣金1倍，填2就是下线佣金在系统设置基础翻倍，依次类推)" autocomplete="off" class="layui-input" value="{{$edit->tqsyyj}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">项目期限</label>

        <div class="layui-input-inline">
            <input type="text" name="shijian" placeholder="项目期限" autocomplete="off" class="layui-input" value="{{$edit->shijian}}">


        </div>

        <div class="layui-input-inline">


            <select name="qxdw">
                <option value="个交易日" @if($edit->qxdw=='个交易日') selected="selected" @endif>个交易日</option>
                <option value="个自然日" @if($edit->qxdw=='个自然日') selected="selected" @endif>个自然日</option>
                <option value="个小时"   @if($edit->qxdw=='个小时') selected="selected" @endif>个小时</option>
            </select>
        </div>
    </div>



    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">项目自动投满</label>


        <div class="layui-input-inline">
            <select name="isaouttm">
                <option value="0" @if($edit->isaouttm=='0') selected="selected" @endif>关闭自动投满</option>
                <option value="1" @if($edit->isaouttm=='1') selected="selected" @endif>开启自动投满</option>
            </select>
        </div>

        <div class="layui-input-inline">
            <input type="text" name="endingtime" placeholder="到期时间" autocomplete="off" class="layui-input" id="endingtime" value="{{$edit->endingtime}}">
        </div>

    </div>


    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">投资状态</label>


        <div class="layui-input-inline">
            <select name="tzzt" lay-filter="tzzts">
                <option value="0" @if($edit->tzzt=='0') selected="selected" @endif>投资中</option>
                <option value="1" @if($edit->tzzt=='1') selected="selected" @endif>已投满</option>
                <option value="-1" @if($edit->tzzt=='-1') selected="selected" @endif>待发布</option>
            </select>
        </div>
    </div>



    <div class="layui-form-item tzzts" @if($edit->tzzt!='-1')style="display: none"@endif>
        <label class="layui-form-label col-sm-1">倒计时广告</label>


        <div class="layui-input-block">
            <input type="text" name="countdownad" placeholder="倒计时广告" autocomplete="off" class="layui-input" id="countdownad" value="{{$edit->countdownad}}">
        </div>
    </div>



    <div class="layui-form-item tzzts" @if($edit->tzzt!='-1')style="display: none"@endif>
        <label class="layui-form-label col-sm-1">购买倒计时</label>


        <div class="layui-input-inline">
            <input type="text" name="countdown" placeholder="购买倒计时" autocomplete="off" class="layui-input" id="countdown" value="{{$edit->countdown}}">
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">发布时间</label>


        <div class="layui-input-inline">
            <input type="text" name="created_at" placeholder="发布时间" autocomplete="off" class="layui-input" id="created_at" value="{{$edit->created_at}}">
        </div>
    </div>


    <div class="layui-form-item">

        <label class="layui-form-label col-sm-1">产品图片</label>



        <div class="layui-col-md6">

            <button type="button" class="layui-btn" id="thumb_url" style="float:left;">
                <i class="layui-icon">&#xe67c;</i>上传产品图片
            </button>

            <span class="imgshow" style="float:left;width:100%;margin: 2px;">
                @if($edit->pic!='')
                    <img src="{{$edit->pic}}" width="100" style="float:left;"/>
                    @endif
            </span>

            <input type="text" name="pic" lay-verify="required" value="{{$edit->pic}}" class="layui-input thumb" placeholder="产品图片" style="float:left;width:50%;">


            <script>


                /*
                function buydataDel(OBJ){
                    $(OBJ).parent().remove();
                    $(".buydata").each(function (DN) {
                        $(this).attr({"name":"buydata["+DN+"]"});
                    });
                }

                function buydataAdd(){

                    var buydataLength=$(".buydata").length;
                    var _html='<div class="layui-input-inline"><input type="text" name="buydata['+buydataLength+']" placeholder="购买数据" autocomplete="off" class="layui-input buydata" value="100" style="width: 80%;float: left;"><i class="layui-icon" onclick="buydataDel(this)" style="font-size: 26px;color: red;">&#xe640;</i></div>';

                    $(".buydataList").append(_html);
                    $(".buydata").each(function (DN) {
                        $(this).attr({"name":"buydata["+DN+"]"});
                    });
                }
                */

                layui.use('upload', function(){


                    var upload = layui.upload;

                    //执行实例
                    var uploadInst = upload.render({
                        elem: '#thumb_url' //绑定元素
                        ,url: '{{route("admin.uploads.uploadimg")}}?_token={{ csrf_token() }}' //上传接口
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

        <label class="layui-form-label col-sm-1">保险公章图片</label>



        <div class="layui-col-md6">

            <button type="button" class="layui-btn" id="thumb_url2" style="float:left;">
                <i class="layui-icon">&#xe67c;</i>上传保险公章图片
            </button>

            <span class="imgshow2" style="float:left;width:100%;margin: 2px;">
                @if($edit->insuranceseal!='')
                    <img src="{{$edit->insuranceseal}}" width="100" style="float:left;"/>
                    @endif
            </span>

            <input type="text" name="insuranceseal"  value="{{$edit->insuranceseal}}" class="layui-input thumb2" placeholder="保险公章图片" style="float:left;width:50%;">


            <script>

                layui.use('upload', function(){


                    var upload = layui.upload;

                    //执行实例
                    var uploadInst = upload.render({
                        elem: '#thumb_url2' //绑定元素
                        ,url: '{{route("admin.uploads.uploadimg")}}?_token={{ csrf_token() }}' //上传接口
                        , field:'thumb'
                        ,done: function(src){
                            //上传完毕回调

                            console.log(src);
                            if(src.status==0){
                                layer.msg(src.msg,{time:500},function(){

                                    $(".imgshow2").html('<img src="'+src.src+'?t='+new Date()+'" width="100" style="float:left;"/>');

                                    $(".thumb2").val(src.src);

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
        <label class="layui-form-label col-sm-1">使用优惠券</label>

        <div class="layui-input-block" style="height: 30px;">

            @if($Coupons)
                @foreach($Coupons as $v)
                    @if($v->type==1)
                        <input type="checkbox" value="{{$v->id}}" name="coupon[]" title="{{$v->name}}" lay-skin="primary" @if(in_array($v->id,explode(",",$edit->coupon)))checked @endif>
                    @endif
                @endforeach
            @endif



        </div>


    </div>

<div class="layui-form-item">
        <label class="layui-form-label col-sm-1">使用加息券</label>


        <div class="layui-input-block" style="height: 30px;">

            @if($Coupons)
                @foreach($Coupons as $v)
                    @if($v->type==2)
                    <input type="checkbox" value="{{$v->id}}" name="coupon[]" title="{{$v->name}}" lay-skin="primary" @if(in_array($v->id,explode(",",$edit->coupon)))checked @endif>
                    @endif
                @endforeach
            @endif



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

            laydate.render({
                elem: '#endingtime' //指定元素
                ,type: 'datetime'
                ,trigger: 'click' //采用click弹出
            });

            laydate.render({
                elem: '#countdown' //指定元素
                ,type: 'datetime'
                ,trigger: 'click' //采用click弹出
            });
        });
    </script>


	 <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">图片文字</label>

        <div class="layui-input-inline">
            <input type="text" name="wzone" placeholder="文字1" autocomplete="off" class="layui-input" value="{{$edit->wzone}}">
        </div>
		 <div class="layui-input-inline">
            <input type="text" name="wztwo" placeholder="文字2" autocomplete="off" class="layui-input" value="{{$edit->wztwo}}">
        </div>
		 <div class="layui-input-inline">
            <input type="text" name="wzthree" placeholder="文字3" autocomplete="off" class="layui-input" value="{{$edit->wzthree}}">
        </div>

    </div>

    <div class="layui-form-item">
        <label class="layui-form-label col-sm-1">图片文字样式</label>

        <div class="layui-input-block">
            <input type="text" name="tagcolor" placeholder="图片文字样式" autocomplete="off" class="layui-input" value="{{$edit->tagcolor}}">
        </div>



    </div>



    @if(Cache::get('editor')=='markdown')

        <div class="layui-form-item">
            <label class="layui-form-label col-sm-1">产品说明</label>
            <div class="layui-input-block">

                <div id="container" class="editor">
                    <textarea name="content" style="display:none;">{!! $edit->content !!}</textarea>
                </div>

                @include('markdown::encode',['editors'=>['container']])
            </div>
        </div>




    @elseif(Cache::get('editor')=='u-editor')
        <div class="layui-form-item">
            <label class="layui-form-label col-sm-1">产品说明</label>
            <div class="layui-input-block">



            @include('UEditor::head')

            <!-- 加载编辑器的容器 -->
                <script id="container" name="content" type="text/plain">
                    {!! $edit->content !!}
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


            </div>
        </div>

    @else

        <div class="layui-form-item editor">

            <label class="layui-form-label col-sm-1">产品说明</label>

            <div class="layui-input-block">

                <textarea name="content" id="container" class="layui-hide" lay-filter="container">{!! $edit->content !!}</textarea>




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


                        function setdescr(){
                            if($('[name="descr"]').val()==''){
                                $('[name="descr"]').val(cutstr(layedit.getText(layeditIndex),200));
                            }
                            setTimeout(function () {
                                setdescr();
                            },5000);
                        }
                        setdescr();


                        $("#layui-btn").click(function(){
                            $("#container").val(layedit.getContent(layeditIndex));

                        });

                        //自定义验证规则

                        form.verify({
                            container: function(value) {
                                layedit.sync(layeditIndex);
                            }
                        });


                        form.render(); //更新全部


                        /**
                         * js截取字符串，中英文都能用
                         * @param str：需要截取的字符串
                         * @param len: 需要截取的长度
                         */
                        function cutstr(str, len) {
                            var str_length = 0;
                            var str_len = 0;
                            str_cut = new String();
                            str_len = str.length;
                            for (var i = 0; i < str_len; i++) {
                                a = str.charAt(i);
                                str_length++;
                                if (escape(a).length > 4) {
                                    //中文字符的长度经编码之后大于4
                                    str_length++;
                                }
                                str_cut = str_cut.concat(a);
                                if (str_length >= len) {
                                    str_cut = str_cut.concat("...");
                                    return str_cut;
                                }
                            }
                            //如果给定字符串小于指定长度，则返回源字符串；
                            if (str_length < len) {
                                return str;
                            }
                        }

                    });

                </script>

            </div>

        </div>

    @endif



    <script>

        var layeditIndex;


        layui.use(['form','layedit'], function(){

            var form = layui.form;




            form.on('select(xxtc)', function(data){
                console.log(data.elem); //得到select原始DOM对象
                console.log(data.value); //得到被选中的值
                console.log(data.othis); //得到美化后的DOM对象

                if(data.value==1){
                    $(".xxtcblBox").show();
                }else{
                    $(".xxtcblBox").hide();
                }
            });

            form.on('select(tzzts)', function(data){
                console.log(data.elem); //得到select原始DOM对象
                console.log(data.value); //得到被选中的值
                console.log(data.othis); //得到美化后的DOM对象

                if(data.value=='-1'){
                    $(".tzzts").show();
                }else{
                    $(".tzzts").hide();
                }
            });


            form.render(); //更新全部




        });

    </script>


@endsection
@section("layermsg")
    @parent
@endsection


@section('form')

@endsection
