$(function(){

    $("#appdiv").click(function(){
        $("div[t^=lackMoneyId]").addClass("dn");
        $("#appdiv").addClass("dn");
    });

    if(isShowHuoQiAMount()){
        $("#huoqiAmountDiv").show();
    }

    if(isShowAllInvest()){
        $("#allInvest").show();
    }else {
        $("#allInvest").hide();
    }

    /*$('#money').keyup(function(){
        if($(this).val() * 1 > totalAmount * 1){
            needCharge = true;
        }else{
            needCharge = false;
        }

        if((huoqiAmount * 1 > 0) && ($(this).val() * 1 <= totalAmount * 1) && ($(this).val() * 1 > userInvest * 1)){
            needHuoqi = true;
        }else{
            needHuoqi = false;
        }
    });*/
    $("#huoqiAmount").prop('checked', false);

    $("#huoqiAmount").change(function(){
        checkHuoqiAmount = $(this).prop('checked');
        if(checkHuoqiAmount){
            useHuoqi = true;
            if(isShowAllInvest()){
                $("#allInvest").show();
            }else {
                $("#allInvest").hide();
            }
        }else{
            useHuoqi = false;
            if(isShowAllInvest()){
                $("#allInvest").show();
            }else {
                $("#allInvest").hide();
            }
        }
    });

    $("#allInvest").click(function(){
        var userCanInvestAmount = 0;

        if((huoqiAmount * 1 <= 0) || (huoqiAmount * 1 > 0 && !checkHuoqiAmount)){
            userCanInvestAmount = userInvest;
        }else if(huoqiAmount * 1 > 0 && checkHuoqiAmount){
            userCanInvestAmount = totalAmount;
        }

        var amount = 0;
        if(userCanInvestAmount * 1 < leftAmountInt * 1){
            amount = userCanInvestAmount;
        }else{
            amount = leftAmountInt;
        }

        $("#money").val(amount);

        var count = 0;
        $("#addtion a").each(function(){
            if (typeof($(this).attr("filter"))!="undefined") {
                var mon = $(this).attr("filter");
                if ( parseInt(mon) > parseInt(amount) ) {
                    $(this).removeClass("quanhov");
                    $(this).addClass("quan_no");
                    $(this).children("img:last").attr("src","/jsonpublic/source/images/appnew/img/quan_c.png");
                    count++;
                } else {
                    $(this).children("img:last").attr("src","/jsonpublic/source/images/appnew/img/quan_b.png");
                    $(this).removeClass("quan_no");
                }
            }
        });
        $(".extratitle").html("可用<span class='cl08'>"+(parseInt(tickCount)-parseInt(count))+"</span>张加息劵");
    });

    $("#recharge2").click( function(){
        var lackMoney = $("#lackMoney2").html();
        if ( isEmpty(retQuery)){
            window.location = "/appV1/weiJumpRecharge?rechargeMoney=" +lackMoney ;
        }else{
            window.location = "/appV1/weiJumpRecharge?rechargeMoney=" +lackMoney+"&ret="+ retQuery ;
        }
        return false ;
    })
});

function isShowAllInvest(){
    if((huoqiAmount * 1 > 0 && checkHuoqiAmount) || (userInvest >= investUtilAmount)){
        return true;
    }
    return false;
}

function isShowHuoQiAMount(){

    if(huoqiAmount == null || typeof(huoqiAmount) == 'undefined'){
        return false;
    }

    if(huoqiAmount * 100 <= 0){
        return false;
    }

    if(investUtilAmount == null || typeof(investUtilAmount) == 'undefined' || investUtilAmount <= 0){
        investUtilAmount = 100;
    }

    if (huoqiAmount * 1 % investUtilAmount != 0) {
        return false;
    }

    return true;
}