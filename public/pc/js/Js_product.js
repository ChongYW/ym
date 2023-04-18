$(document).ready(function () {

    $(".select-result").hide()
    //作者
    $("#select1 dd").click(function () {
        $(this).addClass("selected").siblings().removeClass("selected");
        if ($(this).hasClass("select-all")) {
            $("#selectA").remove();
        } else {
            var copyThisA = $(this).clone();
            if ($("#selectA").length > 0) {
                $("#selectA a").html($(this).text());
            } else {
                $(".select-result").show();
                $(".select-result dl").append(copyThisA.attr("id", "selectA"));
            }
        }
        $("#btn_search").click();
    });
    //釉色
    $("#select2 dd").click(function () {
        $(this).addClass("selected").siblings().removeClass("selected");
        if ($(this).hasClass("select-all")) {
            $("#selectB").remove();
        } else {
            var copyThisB = $(this).clone();
            if ($("#selectB").length > 0) {
                $("#selectB a").html($(this).text());
            } else {
                $(".select-result").show();
                $(".select-result dl").append(copyThisB.attr("id", "selectB"));
            }
        }
        $("#btn_search").click();
    });
    //器型
    $("#select3 dd").click(function () {
        $(this).addClass("selected").siblings().removeClass("selected");
        if ($(this).hasClass("select-all")) {
            $("#selectC").remove();
        } else {
            var copyThisC = $(this).clone();
            if ($("#selectC").length > 0) {
                $("#selectC a").html($(this).text());
            } else {
                $(".select-result").show();
                $(".select-result dl").append(copyThisC.attr("id", "selectC"));
            }
        }
        $("#btn_search").click();
    });
    //口径
    $("#select4 dd").click(function () {
        $(this).addClass("selected").siblings().removeClass("selected");
        if ($(this).hasClass("select-all")) {
            $("#selectD").remove();
        } else {
            var copyThisD = $(this).clone();
            if ($("#selectD").length > 0) {
                $("#selectD a").html($(this).text());
            } else {
                $(".select-result").show();
                $(".select-result dl").append(copyThisD.attr("id", "selectD"));
            }
        }
        $("#btn_search").click();
    });
    //价格
    $("#select5 dd").click(function () {
        $(this).addClass("selected").siblings().removeClass("selected");
        if ($(this).hasClass("select-all")) {
            $("#selectE").remove();
        } else {
            var copyThisE = $(this).clone();
            if ($("#selectE").length > 0) {
                $("#selectE a").html($(this).text());
            } else {
                $(".select-result").show();
                $(".select-result dl").append(copyThisE.attr("id", "selectE"));
            }
        }
        $("#btn_search").click();
    });

    //功能
    $("#select6 dd").click(function () {
        $(this).addClass("selected").siblings().removeClass("selected");
        if ($(this).hasClass("select-all")) {
            $("#selectF").remove();
        } else {
            var copyThisF = $(this).clone();
            if ($("#selectF").length > 0) {
                $("#selectF a").html($(this).text());
            } else {
                $(".select-result").show();
                $(".select-result dl").append(copyThisF.attr("id", "selectF"));
            }
        }
        $("#btn_search").click();
    });
    //老盏
    $("#select7 dd").click(function () {
        $(this).addClass("selected").siblings().removeClass("selected");
        if ($(this).hasClass("select-all")) {
            $("#selectG").remove();
        } else {
            var copyThisG = $(this).clone();
            if ($("#selectG").length > 0) {
                $("#selectG a").html($(this).text());
            } else {
                $(".select-result").show();
                $(".select-result dl").append(copyThisG.attr("id", "selectG"));
            }
        }
        $("#btn_search").click();
    });
    window.onload = function () {

        //作者

        var type1 = decodeURIComponent(getUrlParam("type1"));

        if (type1 != null && type1 != "") {
            $("#select1 dd").each(function () {
                if ($(this).last().text() == type1) {
                    $(this).last().addClass("selected").siblings().removeClass("selected");
                    var copyThisA = $(this).last().clone();
                    $(".select-result").show();
                    $(".select-result dl").append(copyThisA.attr("id", "selectB"));
                }


            });
        }
        //釉色分类
        var type2 = decodeURIComponent(getUrlParam("type2"));
        if (type2 != null && type2 != "") {
            $("#select2 dd").each(function () {
                if ($(this).last().text() == type2) {
                    $(this).last().addClass("selected").siblings().removeClass("selected");
                    var copyThisB = $(this).last().clone();
                    $(".select-result").show();
                    $(".select-result dl").append(copyThisB.attr("id", "selectB"));
                }

            });
        }
        //经典器型
        var type3 = decodeURIComponent(getUrlParam("type3"));
        if (type3 != null && type3 != "") {
            $("#select3 dd").each(function () {
                if ($(this).last().text() == type3) {
                    $(this).last().addClass("selected").siblings().removeClass("selected");
                    var copyThisC = $(this).last().clone();
                    $(".select-result").show();
                    $(".select-result dl").append(copyThisC.attr("id", "selectC"));
                }

            });
        }
        //口径分类
        var type4 = decodeURIComponent(getUrlParam("type4"));
        if (type4 != null && type4 != "") {
            $("#select4 dd").each(function () {
                if ($(this).last().text() == type4) {
                    $(this).last().addClass("selected").siblings().removeClass("selected");
                    var copyThisD = $(this).last().clone();
                    $(".select-result").show();
                    $(".select-result dl").append(copyThisD.attr("id", "selectD"));
                }

            });
        }
        //功能分类
        var type5 = decodeURIComponent(getUrlParam("type5"));
        if (type5 != null && type5 != "") {
            $("#select6 dd").each(function () {
                if ($(this).last().text() == type5) {
                    $(this).last().addClass("selected").siblings().removeClass("selected");
                    var copyThisE = $(this).last().clone();
                    $(".select-result").show();
                    $(".select-result dl").append(copyThisE.attr("id", "selectF"));
                }

            });
        }
        //传世老盏
        var type6 = decodeURIComponent(getUrlParam("type6"));
        if (type6 != null && type6 != "") {
            $("#select7 dd").each(function () {
                if ($(this).last().text() == type6) {
                    $(this).last().addClass("selected").siblings().removeClass("selected");
                    var copyThisF = $(this).last().clone();
                    $(".select-result").show();
                    $(".select-result dl").append(copyThisF.attr("id", "selectG"));
                }

            });
        }

                var type7 = decodeURIComponent(getUrlParam("type7"));
                if (type7 != null && type7 != "") {
                    $("#select7 dd").each(function () {
                        if ($(this).last().text() == type7) {
                            $(this).last().addClass("selected").siblings().removeClass("selected");
                            var copyThisG = $(this).last().clone();
                            $(".select-result dl").append(copyThisG.attr("id", "selectG"));
                        }

                    });
                }

    }

    //获取url中的参数
    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]); return null; //返回参数值
    }


    $("#A_default").click(function () {
        $("#hid_Order").val('default');
        $(".Order a").removeClass('Cur');
        $(this).addClass('Cur');
        $("#btn_search").click();
    });
    $("#A_new").click(function () {
        $("#hid_Order").val('new');
        $(".Order a").removeClass('Cur');
        $(this).addClass('Cur');
        $("#btn_search").click();
    });
    $("#A_sales").click(function () {
        $("#hid_Order").val('sales');
        $(".Order a").removeClass('Cur');
        $(this).addClass('Cur');
        $("#btn_search").click();
    });
    $("#A_hot").click(function () {
        $("#hid_Order").val('hot');
        $(".Order a").removeClass('Cur');
        $(this).addClass('Cur');
        $("#btn_search").click();
    });
    $("#dt_ClearAll").click(function () {
        $(".select-result dd").remove();
    });
    $("#btn_search").click(function (type) {


        var type1 = $("#selectA a").last().text(); //作者
        var type2 = $("#selectB a").last().text(); //釉色分类
        var type3 = $("#selectC a").last().text(); //经典器型
        var type4 = $("#selectD a").last().text(); //口径分类
        var type5 = $("#selectF a").last().text(); //功能分类
        var type6 = $("#selectG a").last().text(); //传世老盏
        var type7 = $("#selectE a").last().text(); //价格分类

        var keyword = $("#keyword").val();
        var CelebrityType=$("#CelebrityType").val();
        var author=$("#author").val();
        var GlazeColor=$("#GlazeColor").val();
        var OrganShape=$("#OrganShape").val();
        var OldCalyx=$("#OldCalyx").val();
        var Caliber=$("#Caliber").val();
        var PriceList=$("#PriceList").val();
        var FunctionName=$("#FunctionName").val();

        var orderType = $("#hid_Order").val();

        if (type1 == "null" && type2 == "null" && type3 == "null" && type4 == "null" && type5 == "null" && type6 == "null" && type7 == "null") {
            var keyword = $("#keyword").val(); //decodeURI(getUrlParam("keyword"));
        }

       var OrderBy= $("#hid_Order").val();
        lists(1,
            {
                OrderBy:OrderBy,
                keyword:keyword,
                CelebrityType:CelebrityType,
                author:author,
                GlazeColor:GlazeColor,
                OrganShape:OrganShape,
                OldCalyx:OldCalyx,
                Caliber:Caliber,
                Price:PriceList,
                FunctionName:FunctionName,

            }
            );


    });

});