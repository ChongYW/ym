@extends('mobile.bluev3.wap')

@section("header")



@endsection

@section("js")
    @parent
<script src="{{asset("mobile/bluev3/newindex/js/slider.js")}}"></script>
@endsection

@section("css")

    @parent
    <link rel="stylesheet" href="{{asset("mobile/bluev3/css/div3.css")}}"/>

@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')
    <div class="othertop" style="color:#F1F3F4">
        <a class="goback" href="javascript:history.back();"><img src="{{asset("mobile/bluev3/img/goback.png")}}" style="margin: 0px;"/></a>

        <div class="othertop-font">投标项目</div>
    </div>


    <div class="header-nbsp"></div>
          <div class="newtit">
                <div class="x_gg_l  color " onclick="nav('all',$(this))">
                    <b>全部</b>
                </div>

                @if($ProductsCategory)
                    @foreach($ProductsCategory as $Ckey=>$CategoryList)



                        <div class="x_gg_l" onclick="nav('{{$CategoryList->links}}',$(this))">
                           <b>{{$CategoryList->name}}</b>
                        </div>



                    @endforeach
                @endif

            </div>
            <div class="platformData PCategoryall">
            </div>


      @if($ProductsCategory)
                        @foreach($ProductsCategory as $Ckey2=> $PCategory)
                            @if(count($PCategory->Products)>0)
                             <div class="platformData PCategory{{$PCategory->links}}"  style="display: none;" >
                                    @foreach($PCategory->Products as $Pro)
                        <a class="tier" href="{{route("product",["id"=>$Pro->id])}}">
                            <div class="img-box" @if($Pro->tzzt==1)style="background: url(/wap/image/js.png) no-repeat 130px bottom;background-size: 130px;"@endif >



                        

                        <?php if($Pro->tzzt == -1){?>

                                    <?php if($Pro->countdownad!=''){
                            echo '<div style="position:absolute;z-index:101;margin-top:100px;text-align:center; border-radius: 5px;width: 75%; margin-left:10%;'.$tagcolor.'">'.$Pro->countdownad.'</div>';
                        }?>


                                    <?php if($Pro->countdown!=''){
                            echo '<div style="position:absolute;z-index:101;margin-top:130px;text-align:center; border-radius: 5px;width: 75%; margin-left:10%;'.$tagcolor.'" id="djs'.$Pro->id.'"></div><script>getDate("'.$Pro->countdown.'","'.$Pro->id.'");</script>';
                        }?>

                                    <?php } ?>


                        <img src="{{$Pro->pic}}" style="width:100%;height: 160px;">

                    </div>
                    <div class="info-box">
                        <div class="ib-head"  style="font-size: 4.2vw;">
                            <span>{{$Pro->title}}</span>&nbsp;&nbsp;
                            @if($Pro->issy==1)
                                <span class="i_span bxb-color-icon bxb-color-red">热</span>
                            @endif
                        </div>

                        <div class="ib-body">
                            <div class="cl-3">
                                <p>
                                    <span class="red" style="color: #f20;font-weight:bold;"><b>{{$Pro->shijian}}</b></span>{{$Pro->qxdw=='个小时'?'小时':'天'}}</p>
                                <p>投资期限</p>
                            </div>
                            <div class="cl-3">

                                @if($Pro->hkfs == 4)
                                    <p><span class="red" >
                                                    <b>{{\App\Product::Benefit($Pro->id,$Pro->qtje)}}</b>
                                                </span>
                                    </p>
                                @else

                                    <p><span class="red" ><b>{{$Pro->jyrsy*$Pro->qtje/100}}</b></span></p>
                                @endif
                                @if($Pro->hkfs == 4)
                                    <p>总收益（元）</p>
                                @else

                                    @if(Cache::get('ShouYiRate')=='年')
                                        <p>年化收益（元）</p>
                                    @else
                                        <?php if ($Pro->qxdw == '个小时') { ?>
                                        <p>每时收益（元）</p>
                                        <?php } else { ?>
                                        <p>每日收益（元）</p>
                                        <?php } ?>
                                    @endif

                                @endif

                            </div>
                            <div class="cl-3">
                                <p><span class="red" >{{$Pro->qtje}}</span></p>
                                <p>起购金额（元）</p>
                            </div>


                        </div>
                        <div class="ib-foot">
                            <div class="text">
                                <p>预期收益率：<span style="color: #f20;">{{$Pro->jyrsy}}%</span></p>
                                <p>项目规模：<span style="color: #000000;">{{$Pro->xmgm}}万元</span></p>
                                <p>
                                    @if($Pro->hkfs==0)
                                        按天付收益，到期还本
                                    @elseif($Pro->hkfs==1)
                                        按周期付收益，到期还本
                                    @elseif($Pro->hkfs==2)
                                        按时付收益，到期还本
                                    @elseif($Pro->hkfs==3)
                                        按天付收益，等额本息返还
                                    @elseif($Pro->hkfs == 4)
                                        每日复利,保本保息
                                  @elseif($Pro->hkfs == 5)
                                              每5天付一次收益，到期还本
                                             @elseif($Pro->hkfs == 10)
                                                每10天付一次收益，到期还本
                                             @elseif($Pro->hkfs == 30)
                                              每30天付一次收益，到期还本
                                              @endif
                                </p>
                            </div>
                            <div class="other">



                                @if($Pro->xmjd>=100 || $Pro->tzzt==1)
                                    <button class="now-btn" style="background-color: #888;">项目已满</button>
                                @elseif($Pro->tzzt==-1)
                                    <button class="now-btn" style="background-color: #888;">待开放</button>
                                @else
                                    <button class="now-btn">立即投资</button>
                                @endif
                            </div>
                        </div>
                        <div class="plan">
                            <span>项目进度：</span>
                            <div class="plan-wrap">

                                <div class="plan-con" style="width:{{$Pro->xmjd}}%;background-color: #ff0000;"></div>

                            </div>
                            <span class="plan-text">{{$Pro->xmjd}}%</span>
                        </div>
                        @if($Pro->xmjd>=100)
                            <img class="over" src="{{asset("mobile/bluev3/img/over2.png")}}" style="display: block;position: absolute;right: 0;margin-top: -2rem;"/>
                        @endif
                    </div>
                </a>
                    @endforeach
      </div>

    @endif

    @endforeach
    @endif

  <script>
    var _AllHtml='';
    $(".platformData").each(function () {


        if($(this).index()>1){
            _AllHtml+=$(this).html();
        }




    });
    $(".platformData").eq(0).html(_AllHtml);

    function nav(obj,nav) {
        $(".platformData").hide();
        $(".PCategory"+obj).show();
        $(".x_gg_l").removeClass('color');
        $(nav).addClass('color');
    }
</script>
    <style>
    .newtit div.color b{
        color: red;
    }


</style>
<style>


    .project-cont .project-img {
        width: 100%;
        float: left;
        padding: 5px;

    }
    .project-cont .project-list {
        width: 100%;

    }
</style>

@endsection
@section('footcategoryactive')

@endsection

@section('footcategory')
    @parent
@endsection

@section("footer")
    @parent
@endsection

