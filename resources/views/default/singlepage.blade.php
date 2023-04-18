@extends('mobile.default.wap')

@section("header")
    @parent
    <div class="top" id="top" >
        <div class="kf">
            <p><a class="sb-back" href="javascript:history.back(-1)" title="返回"
                  style=" display: block; width: 40px;    height: 40px;
                          margin: auto; background: url('{{asset("mobile/images/arrow_left.png")}}') no-repeat 15px center;float: left;
                          background-size: auto 16px;font-weight:bold;">
                </a>
            </p>
            <div style="display: block;width:100%; position: absolute;top: 0;
     left: 0;text-align: center;  height: 40px; line-height: 40px; ">
                <a href="javascript:;" style="text-align: center;  font-size: 16px; ">{{Cache::get('CompanyLong')}}</a>
            </div>

        </div>
    </div>

@endsection

@section("js")
    @parent

@endsection

@section("css")
    @parent

    <style>
        .josephcs p img { width:100% !important;

        }
        .commSafe span{
            font-size:14px}
        .edui-faked-video {
            width: 100% !important;
        }
        .top{
            position: fixed;
        }
    </style>

@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')



    <div style="display:block;height: 40px;" class="baidutj"></div>

    <div class="container-wrap" >
        <div class="wrapwidth">
            <div class="safeindex"></div>
            <div class="service-container clearfix josephcs">






                <div class="serviceright">
                    <div class="about_container">

                        <div style="padding:10px 30px;" class="about_detail">
                            <div class="about_detail_box">
                                {!! \App\Formatting::Format($article->ccontent) !!}
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
    <script>$(".pic_shry .box .title").each(function (index) {
            $(this).click(function () {
                $(".pic_shry .box .title").removeClass("title_active");
                $(this).addClass("title_active");
                $(".pic_shry .box .cont_abou").slideUp();
                $(".pic_shry .box .cont_abou").eq(index).removeClass("hidden").slideDown();
            });
        });</script>

@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

