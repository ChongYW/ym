//项目前缀
var urlPerfix = $("#urlPerfix").val();
/**
 * 通讯组件
 */
var req = {
		// 发送请求
		send:function(url ,params, successHandler, errorHandler) {
			$.ajax({
				type: 'POST',
				url: url,
				data: params,
				dataType: "json",
				success:function(result){
					if(successHandler!=undefined){
						successHandler(result);
					} else if(errorHandler!=undefined){
						errorHandler(result);
					}else{
						//alert('111'+result.message);
						console.log(result.message);
					}
				},
				error:function(xhr){
					console.log(xhr.status);
				}  	  
			});
			
		},
		//url字典
		dictionary:{
			"login": urlPerfix + "/login.do", //登陆
			"sendLoginSms":urlPerfix + "/sendLoginSms.do", //发送短信登陆
			// ====== 账户 ====
			"checkUserLogin" : urlPerfix + "/checkUserLogin.do",//校验用户是否登陆
			"accountRealName": urlPerfix + "/account/realNameCode.do", // 账户实名
			"setAccountTradePwd": urlPerfix + "/account/setAccountTradePwd.do", // 设置交易密码
			// ====== 绑卡====
			"checkBankCard" : urlPerfix + "/account/checkBankCard.do", //校验银行卡号
			"applyBindCard" : urlPerfix + "/account/applyBindCard.do", //申请绑卡
			"confirmBindCard" : urlPerfix + "/account/confirmBindCard.do", //确认绑卡
			"resendBindCardSms" : urlPerfix + "/account/resendBindCardSms.do", //重发绑卡短信
			// ====== 交易====
			"getPrice" : urlPerfix + "/getPrice.do", //30秒获取时时金价
			"immediatelyBuy" : urlPerfix + "/gold/immediatelyBuy.do", // 立即购买
			"payTrade" : urlPerfix + "/gold/payTrade.do", //支付
			"resendPaymentSms" : urlPerfix + "/account/resendPaymentSms.do",   //快捷支付获取验证码
			"confirmPayment" : urlPerfix + "/account/confirmPayment.do",   //快捷支付付款
			"buyOrderPayStatus" : urlPerfix + "/gold/buyOrderPayStatus.do", //买金订单异步查询
			"goldBuy" : urlPerfix + "/gold/immediatelyBuy.do", // 立即购买
			"gainCouponByKeyWord" :urlPerfix + "/coupon/gainCouponByKeyWord.do", // 口令兑换
			"setRecommendCode" : urlPerfix + "/invite/setRecommendCode.do", //设置推荐码
			"buyCheck" : urlPerfix + "/gold/buyCheck.do", // 购买校验
		},
		
		invoke:function(method,params,success,failure){
			var url=this.dictionary[method];
			this.send(url, params, success, failure);
		}
};

/***
 * 刷新验证码
 */
function refreshCode () {
	var timenow = new Date();
	$(".checkCode").attr("src",urlPerfix + "/kaptcha/createImage?d=" + timenow);
}

/***
 * 刷新验证码
 */
function refreshCode (type) {
	var timenow = new Date();
	$(".checkCode").attr("src",urlPerfix + "/kaptcha/createImage?d=" + timenow+"&code_id="+type);
}

/**
 * 毫秒转日期  yyyy-MM-dd HH:mm
 * @param str
 * @returns {String}
 */
function getMyDate(str){  
    var oDate = new Date(str),  
    oYear = oDate.getFullYear(),  
    oMonth = oDate.getMonth()+1,  
    oDay = oDate.getDate(),  
    oHour = oDate.getHours(),  
    oMin = oDate.getMinutes(),  
    //oSen = oDate.getSeconds(),  
    //oTime = oYear +'-'+ getzf(oMonth) +'-'+ getzf(oDay) +' '+ getzf(oHour) +':'+ getzf(oMin) +':'+getzf(oSen);//最后拼接时间  
    oTime = oYear +'-'+ getzf(oMonth) +'-'+ getzf(oDay) +' '+ getzf(oHour) +':'+ getzf(oMin);//最后拼接时间  
    return oTime;  
};  
function getMyDate_day(str){  
    var oDate = new Date(str),  
    oYear = oDate.getFullYear(),  
    oMonth = oDate.getMonth()+1,  
    oDay = oDate.getDate(),  
    oTime = oYear +'-'+ getzf(oMonth) +'-'+ getzf(oDay);//最后拼接时间  
    return oTime;  
};

var change_date = function(days) {  
    // 参数表示在当前日期下要增加的天数  
    var now = new Date();  
    // + 1 代表日期加，- 1代表日期减  
    now.setDate((now.getDate() + 1) - 1 * days);  
    var year = now.getFullYear();  
    var month = now.getMonth() + 1;  
    var day = now.getDate();  
    if (month < 10) {  
        month = '0' + month;  
    }  
    if (day < 10) {  
        day = '0' + day;  
    }  

    return year + '-' + month + '-' + day;  
};  


//补0操作  
function getzf(num){  
    if(parseInt(num) < 10){  
        num = '0'+num;  
    }  
    return num;  
}  

/**
 * js加*处理
 * @param str 目标 
 * @param frontLen 前几
 * @param endLen 后几
 * @returns {String} 结果
 */
function plusXing (str,frontLen,endLen) { 
	var len = str.length-frontLen-endLen;
	var xing = '';
	for (var i=0;i<len;i++) {
		xing+='*';
	}
	return str.substring(0,frontLen)+xing+str.substring(str.length-endLen);
}