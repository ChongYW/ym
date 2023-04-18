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
    <script type="text/javascript" src="{{ asset("pc/finance/js/calculator.js")}}" charset="utf-8"></script>
     <script type="text/javascript" src="{{ asset("admin/lib/layui/layui.js")}}" charset="utf-8"></script>
@endsection

@section("css")

    @parent
    <link href="{{asset("pc/finance/css/css/c_main.min.css")}}" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .c_calculatorCpmLeft{padding: 36px 0 0 36px;}
        .c_calculatorCpmRight ul.c_cpmscroll{width: 100%;}
        .c_calculatorCpmRight ul dd, .c_calculatorCpmRight ul dl.c_dd_titlecpm dd{width: 140px;}
        .c_libottomcpm{width: 100%;}
    </style>
@endsection

@section("onlinemsg")
    @parent
@endsection

@section('body')

    <style type="text/css">
        .c_calculatorCpmLeft{padding: 36px 0 0 36px;}
        .c_calculatorCpmRight ul.c_cpmscroll{width: 100%;}
        .c_calculatorCpmRight ul dd, .c_calculatorCpmRight ul dl.c_dd_titlecpm dd{width: 18%;}
        .c_libottomcpm{width: 100%;}
        .c_calculator_all {
            width: 100%;
        }
        .c_calculatorCpmLeft span {
            color: #777;
            font-size: 14px;
             position: absolute;

            top: 0;
            line-height: 40px;
            float: left;
        }
    </style>


    <div style="width: 100%;border-top: 1px solid #e7e7e7;background-color: #f4f7f8;padding: 30px 0;">
        <div style="width:100%;height:870px;border: 1px solid #ccc;background-color: #fff;margin: auto;">
            <!-- S 计算器-->
            <div class="c_calculatorCpmBox" style="display:block;position: relative;width: 100%;">
                <h1>收益计算器</h1>
                <form class="c_calculatorCpmLeft calculatorCpmLeft" style="width:100%">
                    <div style="text-align:center;margin-bottom:10px;">
                        <img alt="@if(isset($title)){{$title}}@else{{\Cache::get('CompanyLong')}}@endif" src="\uploads\{{\Cache::get('pclogo').'?t='.time()}}" height="40">
                    </div>
                    <div class="c_calculator_all" style="width: 100%;">
                        <label>投资金额</label>
                        <input type="text" id="account" maxlength="7" class="c_nullinput nullinput" placeholder="意向投资金额">元

                    </div>

                    <div class="c_calculator_all">
                        <label>投资期限</label>
                        <input type="text" class="c_nullinput nullinput" id="periods" maxlength="3" placeholder="期望投资期限">日
                        <span class="tyepname"></span>
                    </div>
                    <div class="c_calculator_all">
                        <label>日化利率</label>
                        <input type="text" id="apr" class="c_nullinput nullinput" maxlength="5" placeholder="期望日化利率">%
                        <span></span>
                    </div>
                    <div class="c_calculator_all">
                        <label>还款方式</label>
                        <select id="flagstatus" class="select_showbox" style="display: inline-block;background: none;">
                            <!--<option value="1">到期还本还息</option>
                            <option value="2">按天付息到期还本</option>
                            <option value="3">按交易日付息还本</option>-->
                            <option value="1">一次性还本付息</option>
                            <option value="2">每日返息，到期还本</option>
                            <option value="3">每周返息，到期还本</option>
                            <option value="4">每月返息，到期还本</option>
                            <option value="5">每日复利，保本保息</option>
                            <option value="6">交易日返息，到期还本</option>
                        </select>
                    </div>
                    <div class="c_calculator_all">
                        <input type="button" class="c_cpmbuttons y_cpmbuttons" value="计算收益" onclick="jssy()">
                        <input type="reset" class="c_cpmresets y_cpmresets" value="重新计算">
                        <div style="text-align: center; margin-right: 10px; color: rgb(255, 120, 0); margin-top: 1px; display: none;" id="calculErr"></div>
                    </div>
                </form>
                <div class="c_calculatorCpmRight calculatorCpmRight" style="width: 100%;float: left;">
                    <ul class="c_cpmscroll cpmscroll" id="calculatorList">
                        <li>
                            <dl class="c_dd_titlecpm dd_titlecpm">
                                <dd>收款日期</dd>
                                <dd>收款金额</dd>
                                <dd>收回本金</dd>
                                <dd>收回利息</dd>
                                <dd class="c_cpmlastdd">剩余本息</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd class="c_cpmlastdd "></dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd class="c_cpmlastdd "></dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd class="c_cpmlastdd "></dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd class="c_cpmlastdd "></dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd class="c_cpmlastdd "></dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd class="c_cpmlastdd "></dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd class="c_cpmlastdd "></dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd></dd>
                                <dd class="c_cpmlastdd "></dd>
                            </dl>
                        </li>
                    </ul>
                    <ul class="c_ul_bottomcpm ul_bottomcpm c_bottomcpm">
                        <li>
                            <dl>
                                <dd>总结</dd>
                                <dd>0.00</dd>
                                <dd>0.00</dd>
                                <dd>0.00</dd>
                                <dd class="c_cpmlastdd cpmlastdd"></dd>
                            </dl>
                        </li>
                        <li class="c_libottomcpm libottomcpm">实际总收益：<span>￥0元</span></li>
                    </ul>
                </div>
            </div>
            <div class="c_calculatorCpmBottom calculatorCpmBottom" style="height: 859px;"></div>
        </div>
    </div>







@endsection


@section("footbox")
    @parent
@endsection

@section("footer")
    @parent
@endsection

