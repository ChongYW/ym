var pageCount = 15;
var pageIndexCount = 5;

//获取计算后的样式
function getStyle(obj, name)
{
	return obj.currentStyle ? obj.currentStyle[name] : getComputedStyle(obj, false)[name];
}

//运动框架
function startMove(obj, json, options)
{
	options = options || {};
	options.time = options.time || 700;
	options.type = options.type || 'easy_out';
	var start = {};
	var dis = {};
	for(var name in json)
	{
		if(name == 'opacity')
		{
			start[name] = Math.round(parseFloat(getStyle(obj, name)) * 100);	
		}
		else
		{
			start[name] = parseInt(getStyle(obj, name));	
		}
		if(isNaN(start[name]))
		{
			switch(name)
			{
				case 'left':
					start[name] = obj.offsetLeft;
					break;
				case 'top':
					start[name] = obj.offsetTop;
					break;
				case 'width':
					start[name] = obj.offsetWidth;
					break;
				case 'height':
					start[name] = obj.offssetHeight;
					break;
				case 'marginLeft':
					start[name] = 0;
					break;
				case 'marginTop':
					start[name] = 0;
					break;
				case 'marginRight':
					start[name] = 0;
					break;
				case 'marginBottom':
					start[name] = 0;
					break;
				case 'paddingLeft':
					start[name] = 0;
					break;
				case 'paddingTop':
					start[name] = 0;
					break;
				case 'paddingRight':
					start[name] = 0;
					break;
				case 'paddingBottom':
					start[name] = 0;
					break;
				case 'opacity':
					start[name] = 100;
					break;
				case 'borderLeftWidth':
					start[name]= 0; 
					break;
				case 'borderRightWidth':
					start[name] = 0;
					break;
				case 'borderTopWidth':
					start[name] = 0;
					break;
				case 'borderBottomWidth':
					start[name] = 0;
					break;
			}
		}
		dis[name] = json[name] - start[name];	
	}	
	
	var count = parseInt(options.time / 30);
	var n = 0;
	
	clearInterval(obj.oTimer);
	obj.oTimer = setInterval(function(){
		n++;
		for(var name in json)
		{
			switch(options.type)
			{
				case 'easy_out':
					var a = 1 - n / count;
					var iCur = start[name] + dis[name] * (1 - a * a * a);
					break;	
				case 'easy_in':
					var a = n / count;
					var iCur = start[name] + dis[name] * (a * a * a);
					break;
				case 'linear':
					var iCur = start[name] + dis[name] / count * n;
					break;
			}
			if(name == 'opacity')
			{
				obj.style.opacity = iCur / 100;
				obj.style.filter = 'alpha(opacity:' + iCur + ')';	
			}
			else
			{
				obj.style[name] = iCur + 'px';	
			}	
		}
		if(n == count)
		{
			clearInterval(obj.oTimer);
			options.fn && options.fn(obj);	
		}	
	}, 30);
}

//通过class获取元素
function getByClassName(oParent, sClass)
{
	if(oParent.getElementsByClassName)
	{
		return oParent.getElementsByClassName(sClass);	
	}	
	var aEle = oParent.getElementsByTagName('*');
	var re = new RegExp('\\b' + sClass + '\\b');
	var aResult = [];
	for(var i = 0; i < aEle.length; i++)
	{
		if(re.test(aEle[i].className))
		{
			aResult.push(aEle[i]);
		}	
	}
	return aResult;
}

//添加class
function addClass(obj, sClass)
{ 
    var aClass = obj.className.split(' ');
    if (!obj.className)
	{
        obj.className = sClass;
        return;
    }
    for (var i = 0; i < aClass.length; i++)
	{
        if (aClass[i] === sClass) return;
    }
    obj.className += ' ' + sClass;
}

//删除class
function removeClass(obj, sClass)
{ 
    var aClass = obj.className.split(' ');
    if (!obj.className) return;
    for (var i = 0; i < aClass.length; i++)
	{
        if (aClass[i] === sClass)
		{
            aClass.splice(i, 1);
            obj.className = aClass.join(' ');
            break;
        }
    }
}

//绑定事件
function addEvent(obj, sEv, fn)
{
	if(obj.addEventListener)
	{
		obj.addEventListener(sEv, function (ev){
			if(false == fn.call(obj, ev))
			{
				ev.preventDefault();
				ev.cancelBubble = true;
			}
		}, false)
	}
	else
	{
		obj.attachEvent('on' + sEv, function (){
			if(false == fn.call(obj, event))
			{
				event.cancelBubble = true;
				return false;
			}
		})
	}
}

//解除绑定
function removeEvent(obj, sEv, fn)
{
	if(obj.removeEventListener)
	{
		obj.removeEventListener(sEv, fn, false);
	}
	else
	{
		obj.detachEvent('on' + sEv, fn);
	}
}

//获取绝对高度
function getPos(obj)
{
	var iLeft = 0;
	var iTop = 0;
	while(obj)
	{
		iLeft += obj.offsetLeft;
		iTop += obj.offsetTop;
		obj = obj.offsetParent;	
	}
	return {left:iLeft, top:iTop};
};

//是否有某个class
function hasClass(obj, sClass)
{
	var re = new RegExp('\\b' + sClass + '\\b');
	if(re.test(obj.className))
	{
		return true;
	}	
	return false;
}

//设置scrollTop
function setTop(iTop)
{
	document.documentElement.scrollTop = document.body.scrollTop = iTop;
}

//获取scrollTop
function getTop()
{
	return document.documentElement.scrollTop || document.body.scrollTop;	
}

//判断是否微信打开
function isWeiXin()
{
	var ua = window.navigator.userAgent.toLowerCase();
	if(ua.match(/MicroMessenger/i) == 'micromessenger')
	{
		return true;
	}
	return false;
}

//去掉数字头部的'0'
function offZero(num)
{
	if(num.charAt(0) == '0')
	{
		return 	num.charAt(1);
	}
	else
	{
		return 	num;
	}
}

//将单个数字在前面补零
function toDouble(num)
{
	if(num < 10)
	{
		return 	'0' + num;
	}
	else
	{
		return 	'' + num;
	}
}

//判断设备
function Terminal()
{
	this.oDownload = document.getElementById('download');
	this.oVersions = document.getElementById('versions');
	this.oChoice_btn = document.getElementById('choice_btn');
	
	this.downloadBtn1 = document.getElementById('download_btn1');
	this.downloadBtn2 = document.getElementById('download');
	
	this.oBg_box = document.getElementById('bg_box');
	this.oWeixin_box = document.getElementById('weixin_box');
	
	//版本信息
	this.sAgent = navigator.userAgent;
}

//显示下载按钮或版本信
Terminal.prototype.switchPart = function()
{
	//手机处理
	if(this.sAgent.indexOf("Android") > 0 || this.sAgent.indexOf("iPhone") > 0)
	{
		this.showDownload();
	}
	else
	{
		this.showVersions();
	}
}

//点击下载按钮
Terminal.prototype.downloadHandle_List = function()
{
	var This = this;
	this.downloadBtn1.onclick = function()
	{
		This.download(This.downloadBtn1);
	}
}

//点击下载按钮
Terminal.prototype.downloadHandle_footer = function()
{
	var This = this;
	this.downloadBtn2.onclick = function()
	{
		This.download(This.downloadBtn2);
	}
}

//下载
Terminal.prototype.download = function(obj)
{
	if(isWeiXin())
	{
		this.showWeixinTip();
	}
	else
	{
		if(this.sAgent.indexOf("Android") > 0)
		{
			obj.href = 'https://www.heshidai.com/app-download.html';
		}
		else if(this.sAgent.indexOf("iPhone") > 0 || this.sAgent.indexOf("iPad") > 0)
		{
			obj.href = 'https://#';
		}
		else
		{
			obj.href = 'https://#';
		}
	}
}

//显示微信提示框
Terminal.prototype.showWeixinTip = function()
{
	this.oBg_box.style.display = 'block';
	this.oWeixin_box.style.display = 'block';
}

//隐藏微信提示框
Terminal.prototype.hideWeixinTip = function()
{
	this.oBg_box.style.display = 'none';
	this.oWeixin_box.style.display = 'none';
}

//点击背景关闭微信提示框
Terminal.prototype.hideWeixinTipByBg = function()
{
	var This = this;
	this.oBg_box.onclick = function()
	{
		This.hideWeixinTip();
	}
}

//微信下安卓或苹果下的按钮样式切换
Terminal.prototype.switchBtn = function()
{
	//手机处理
	if(this.sAgent.indexOf("Android") > 0)
	{
		this.oChoice_btn.className = 'android_btn'; 
	}
	else if(this.sAgent.indexOf("iPhone") > 0)
	{
		this.oChoice_btn.className = 'iphone_btn'; 
	}
}

//显示下载按钮
Terminal.prototype.showDownload = function()
{
	this.oDownload.style.display = 'block';
	this.oVersions.style.display = 'none';
}

//显示版本信息
Terminal.prototype.showVersions = function()
{
	this.oDownload.style.display = 'none';
	this.oVersions.style.display = 'block';
}

//进度条对象
function ProgressBar(obj)
{
	this.oProgressBar = obj;
	this.oBarTotal = getByClassName(this.oProgressBar, 'progressBar')[0];
	this.oBar = getByClassName(this.oProgressBar, 'bar')[0];	
	this.oValue = getByClassName(this.oProgressBar, 'percent')[0];
	
	this.setProgressBar();
}

//初始化进度条
ProgressBar.prototype.setProgressBar = function()
{
	var iVal = parseInt(this.oValue.innerHTML);
	var ratio = iVal / 100;	
	
	this.oBar.style.width = 0;
	startMove(this.oBar,{'width': ratio * this.oBarTotal.offsetWidth});
	
}

//倒计时对象
function Countdown(obj, oCountDown)
{
	this.oText = obj;
	this.oCountDown = oCountDown;
	this.oTimer = null;
	this.sCountTime = this.oCountDown.value;
	this.txt = '';
}	

//开始倒计时
Countdown.prototype.setCountdown = function(txt)
{
	var This = this;
	
	if(!txt)
	{
		this.txt = '立即投资';
	}
	else
	{
		this.txt = txt;
	}
	
	var iTotalSec = Number(this.sCountTime);
	
	
	this.oTimer = setInterval(function(){
		iTotalSec--;
		var iTime = iTotalSec;

		var iSurHour = toDouble(parseInt(iTime / 3600));
		iTime %= 3600;
		var iSurMin = toDouble(parseInt(iTime / 60));
		iTime %= 60;
		var iSurSec = toDouble(iTime);
		
		This.oText.innerHTML = iSurHour + ':' + iSurMin + ':' + iSurSec;
		
		if(iTotalSec <= 0)
		{
			clearInterval(This.oTimer);
			This.oText.innerHTML = This.txt;
		}		
	}, 1000);
}


//弹窗对象
function Window(idBg, idWindow)
{
	this.oBg = document.getElementById(idBg);
	this.oWindow = document.getElementById(idWindow);
	this.oReturnBtn = getByClassName(this.oWindow, 'returnBtn')[0];
	
	this.hideWindowByBtn();
}

//显示窗口
Window.prototype.showWindow = function()
{
	this.oBg.style.display = 'block';
	this.oWindow.style.display = 'block';	
}

//隐藏窗口
Window.prototype.hideWindow = function()
{
	this.oBg.style.display = 'none';
	this.oWindow.style.display = 'none';	
}

//通过按钮隐藏窗口
Window.prototype.hideWindowByBtn = function()
{
	var This = this;
	this.oReturnBtn.onclick = function()
	{
		This.hideWindow();
	}	
}

//返回顶部对象
function ReturnToTop(idBtn)
{
	this.oBtn = document.getElementById(idBtn);	
	this.oTimer = null;
	this.bScroll = true;
	
	this.showBtn();
	this.ReturnToTop();
}

//点击按钮返回顶部
ReturnToTop.prototype.ReturnToTop = function()
{
	var This = this;
	this.oBtn.onclick = function()
	{
		This.toTop();	
	}	
}

//显示隐藏返回顶部按钮
ReturnToTop.prototype.showBtn = function()
{
	var This = this;
	var iClientHeight = 0;//document.documentElement.clientHeight / 8;
	
	addEvent(window, 'scroll', scrollTab);
	function scrollTab()
	{
		if(getTop() > iClientHeight)
		{
			startMove(This.oBtn, {opacity:100});	
		}
		else
		{
			startMove(This.oBtn, {opacity:0});		
		}
		removeEvent(window, 'scroll', scrollTab);
	}
}

//返回顶部
ReturnToTop.prototype.toTop = function()
{
	var This = this;
	clearInterval(this.oTimer);
	this.oTimer = setInterval(function(){
		This.bScroll = true;
		var iScrollTop = getTop();
		var iSpeed = iScrollTop / 8;
		setTop(iScrollTop - iSpeed);
		
		if(getTop() <= 0)
		{
			clearInterval(This.oTimer);	
		}	
	}, 30);
	
	window.onscroll = function()
	{
		if(!This.bScroll)
		{
			clearInterval(This.oTimer);	
		}
		This.bScroll = false;
	}
}

//登陆页面选项卡
function Tab(id)
{
	this.oTab = document.getElementById(id);
	this.oUl = this.oTab.getElementsByTagName('ul')[0];
	this.aBtn = this.oUl.getElementsByTagName('li');
	this.aBox = getByClassName(this.oTab, 'form_box');	
	this.iNow = 0;
	
	this.setTab();
}

//点击切换页面
Tab.prototype.setTab = function()
{
	var This = this;
	for(var i = 0; i < this.aBtn.length; i++)
	{
		this.aBtn[i].index = i;
		this.aBtn[i].onclick = function()
		{
			This.iNow = this.index;
			This.tab();
		}
	}	
}

//选项卡
Tab.prototype.tab = function()
{
	for(var i = 0; i < this.aBtn.length; i++)
	{
		this.aBtn[i].className = '';
		this.aBox[i].style.display = 'none';	
	}
	this.aBtn[this.iNow].className = 'active';	
	this.aBox[this.iNow].style.display = 'block';
}

//显示隐藏明文密码对象
function ShowPassword(id)
{
	this.oShowPassword = document.getElementById(id);
	this.oEyeBtn = getByClassName(this.oShowPassword.parentNode, 'signInEye')[0];
	this.bTrue = true;
	
	this.showPassword();	
}

//显示隐藏明文密码
ShowPassword.prototype.showPassword = function()
{
	var This = this;
	this.oEyeBtn.onclick = function()
	{
		var str = This.oShowPassword.value;
		This.oShowPassword.focus();
		if(This.bTrue)
		{
			This.oShowPassword.type = 'text';
			addClass(this, 'signInEye_active');
			This.bTrue = !This.bTrue;	
		}
		else
		{
			This.oShowPassword.type = 'password';
			removeClass(this, 'signInEye_active');
			This.bTrue = !This.bTrue;	
		}	
		This.oShowPassword.value = str;
	}	
}

//转换窗口对象
function SwitchWindow()
{
	this.aSwitchWindow = getByClassName(document, 'form_box');	
}

//通过class转换窗口
SwitchWindow.prototype.switchWindow = function(sClass)
{
	for(var i = 0; i<this.aSwitchWindow.length; i++)
	{
		this.aSwitchWindow[i].style.display = 'none';
		if(hasClass(this.aSwitchWindow[i], sClass))
		{
			this.aSwitchWindow[i].style.display = 'block';
		}
	}
}

//推荐人id对象
function RecommendedPerson()
{
	this.oReferee_id = document.getElementById('referee_id');
	this.oReferee_wrap = document.getElementById('referee_wrap');
	this.iMarginBottom = parseInt(getStyle(this.oReferee_wrap, 'marginBottom'));
	this.oError = getByClassName(this.oReferee_wrap, 'error')[0];
	this.bTrue = true;
	
	//设置高度
	this.getHeight();
	
	//显示隐藏推荐人ID窗口
	this.showRecommendedPersonBox();
}

//设置高度
RecommendedPerson.prototype.getHeight = function()
{
	this.iHeightWrap1 = parseInt(getStyle(this.oReferee_wrap, 'height'));
	this.oReferee_wrap.style.height = 'auto';
	this.oReferee_wrap.style.display = 'block';
	this.oError.style.display = 'block';
	this.iHeightWrap2 = this.oReferee_wrap.offsetHeight;
	this.oError.style.display = 'none';
	this.oReferee_wrap.style.display = 'none';
	
}

//显示隐藏推荐人ID窗口
RecommendedPerson.prototype.showRecommendedPersonBox = function()
{
	var This = this;
	this.oReferee_id.onclick = function()
	{	
		if(This.bTrue)
		{
			This.oReferee_wrap.style.height = '0px';
			This.oReferee_wrap.style.display = 'block'; 
			if(This.oError.style.display == 'block')
			{
				var iHeight = This.iHeightWrap2;
			}
			else
			{
				var iHeight = This.iHeightWrap1;	
			}
			startMove(This.oReferee_wrap, {height:iHeight, opacity:100, marginBottom:This.iMarginBottom}, {fn:function(obj){
				obj.style.height = 'auto';	
			}});
			This.bTrue = !This.bTrue;
			addClass(this, 'referee_id_down');
		}
		else
		{
			startMove(This.oReferee_wrap, { height:0, opacity:0,marginBottom:0}, {fn:function(obj){
				obj.style.display = 'none';	
			}});
			This.bTrue = !This.bTrue;
			removeClass(this, 'referee_id_down');
		}
	}
}

//表单验证对象
function FormCheck(id)
{
	this.json={
		phone:        /(^[1][3][0-9]{9}$)|(^[1][4][0-9]{9}$)|(^[1][5][0-9]{9}$)|(^[1][7][0-9]{9}$)|(^[1][8][0-9]{9}$)/,
		graphic_code: /^[a-zA-Z0-9]{4}$/,
		code:         /^\d{6}$/,
		username:	  /^[a-zA-Z0-9_]{3,16}$/,
		password:     /^[0-9|a-z|A-Z]{6,20}$/,
		password1:     /^[^\u4e00-\u9fa5|\s]{6,20}$/,
		password2:    /^[^\u4e00-\u9fa5|\s+]{6,20}$/,
		realName:     /^([\u4e00-\u9fa5\·]{1,10})$/,
		personId:	  /^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/,
		userNameAndMailbox: /^([\.\w]+@([a-z0-9][a-z0-9\-]{0,61}[a-z0-9]|[a-z0-9])(\.[a-z]{2,4}){1,2})|([a-zA-Z0-9_]{3,16})$/,
		amount:         /^\d{1,}[\.]?\d*$/,
		cash:		/^[1-9]\d{2,}[\.]?\d*$/,
		withdrawals:/^\d{1,}[\.]?\d*$/,
		RechargeIn:/^\d+\.\d{1,2}|\d+$/,
		bankCard: /^(\d{16}|\d{19})$/,
		referee:      /./,
		bankId:		/^(\d{16}|\d{19}|\d{18})$/
	};
	
	this.oForm = document.getElementById(id);
	//this.aInput = this.oForm.getElementsByTagName('input');
	this.oSubmit_btn = getByClassName(this.oForm, 'submit_btn')[0];
	this.oErrorBox = document.getElementById('errorBox');
	
	this.aError = getByClassName(this.oForm, 'error');
	this.aInput = getByClassName(this.oForm, 'input_box');
	this.aClose_btn_success = getByClassName(this.oForm, 'close_btn_success');
	this.aClose_btn_error = getByClassName(this.oForm, 'close_btn_error');
	
	this.bHaved = false;
	if(this.aError[0])
	{
		this.iHeight = parseInt(getStyle(this.aError[0], 'height'));
	}
	
	this.focusIn();
	
	this.showCloseBtn();
	this.clearValue();
	
	var This = this;
}

//输入显示删除按钮
FormCheck.prototype.showCloseBtn = function()
{
	var This = this;
	for(var i = 0; i < this.aInput.length; i++)
	{
		this.aInput[i].index = i;
		this.aInput[i].oninput = function()
		{
			This.showSuccessBtn(This.aClose_btn_success[this.index]);
		}
	}
}

//输入显示删除按钮
FormCheck.prototype.clearValue = function()
{
	var This = this;
	for(var i = 0; i < this.aClose_btn_success.length; i++)
	{
		this.aClose_btn_success[i].index = i;
		this.aClose_btn_success[i].onclick = function()
		{
			This.aInput[this.index].value = '';
			This.aInput[this.index].focus();
			This.hideSuccessBtn(this);
		}
	}
}

//只能输入11位数字
FormCheck.prototype.restrictedInput = function(id)
{
	this.oInput = document.getElementById(id);
	this.oInput.onkeyup = this.oInput.onafterpaste= function()
	{
		this.value = this.value.replace(/\D/g, '');
		if(this.value.length > 11)
		{
			this.value = this.value.substring(0, 11);
		}
	}		
}

//显示验证成功后关闭按钮
FormCheck.prototype.showSuccessBtn = function(oClose_btn_success)
{
	oClose_btn_success.style.display = 'block';
	startMove(oClose_btn_success, {opacity:100}, {time:300});
}

//显示验证失败后关闭按钮
FormCheck.prototype.showErrorBtn = function(oClose_btn_error)
{
	oClose_btn_error.style.display = 'block';
	startMove(oClose_btn_error, {opacity:100}, {time:300});
}

//隐藏验证成功后关闭按钮
FormCheck.prototype.hideSuccessBtn = function(oClose_btn_success)
{
	startMove(oClose_btn_success, {opacity:0}, {time:300, fn:function(obj){
		obj.style.display = 'none';
	}});
}

//隐藏验证失败后关闭按钮
FormCheck.prototype.hideErrorBtn = function(oClose_btn_error)
{
	startMove(oClose_btn_error, {opacity:0}, {time:300, fn:function(obj){
		obj.style.display = 'none';
	}});
}

//添加错误时边框
FormCheck.prototype.addErrorBorder = function(oInput)
{
	addClass(oInput, 'error_border');
	removeClass(oInput, 'focus_border');
}

//删除错误时边框
FormCheck.prototype.removeErrorBorder = function(oInput)
{
	removeClass(oInput, 'error_border');
}

//添加input框焦点时边框
FormCheck.prototype.addFocusBorder = function(oInput)
{
	addClass(oInput, 'focus_border');
	removeClass(oInput, 'error_border');
}

//删除input框焦点时边框
FormCheck.prototype.removeFocusBorder = function(oInput)
{
	removeClass(oInput, 'focus_border');
}

//边框高亮
FormCheck.prototype.HighlightBorder = function(oInput)
{
	this.oError = getByClassName(oInput.parentNode, 'error')[0];
	this.oClose_btn_success = getByClassName(oInput.parentNode, 'close_btn_success')[0];
	this.oClose_btn_error = getByClassName(oInput.parentNode, 'close_btn_error')[0];
	
	this.addFocusBorder(oInput);
	this.hideSuccessBtn(this.oClose_btn_success);
	this.hideErrorBtn(this.oClose_btn_error);
	this.hideErrorBox(this.oError);
}

//输入正确时清除输入信息
FormCheck.prototype.reSetInputValueWhenSuccess = function(oClose_btn_success, oInput)
{
	var This = this;
	oClose_btn_success.onclick = function()
	{
		oInput.value = '';
		oInput.focus();
		This.hideSuccessBtn(oClose_btn_success);
	}
}

//输入错误时清除输入信息
FormCheck.prototype.reSetInputValueWhenError = function(oError, oInput, oClose_btn_error)
{
	var This = this;
	oClose_btn_error.onclick = function()
	{
		oInput.value = '';
		This.removeErrorBorder(oInput);
		This.hideErrorBox(oError, oClose_btn_error, oInput);
		oInput.focus();
		This.hideErrorBtn(oClose_btn_error);
	}
}

//input框聚焦时边框高亮
FormCheck.prototype.focusIn = function()
{
	var This = this;
	
	//输入框聚焦时
	for(var i = 0; i < this.aInput.length; i++)
	{
		var re = this.json[this.aInput[i].id];
		if(re)
		{
			(function (re){
				This.aInput[i].onfocus=function ()
				{
					This.HighlightBorder(this);
				}
			})(re);
		}
	}
}

//表单验证
FormCheck.prototype.formCheck = function(fnSuccess, fnSecondDetection)
{
	this.fnSuccess = fnSuccess;
	this.fnSecondDetection = fnSecondDetection;
	
	var This = this;
	
	//光标失去焦点时验证
	for(var i = 0; i < this.aInput.length; i++)
	{
		var re = this.json[this.aInput[i].id];
		if(re)
		{
			(function (re){
				This.aInput[i].onblur=function ()
				{
					if(this.value == '')
					{
						This.removeFocusBorder(this);
						return;	
					}
					This.check(this, re);
				}
			})(re);
		}
	}
	
	//点击提交按钮时验证
	this.onSubmit();
}

//点击提交按钮时验证
FormCheck.prototype.onSubmit = function()
{
	var This = this;
	if(this.oSubmit_btn)
	{
		this.oSubmit_btn.onclick = function()
		{
			var bCanBeSubmit = true;
			for(var i = 0; i < This.aInput.length; i++)
			{
				var re = This.json[This.aInput[i].id];
				
				if(re)
				{
					if(This.check(This.aInput[i], re) == false)
					{
						bCanBeSubmit = false;
						break;
					}
				}
			}
			
			//验证通过，调用回调函数
			if(bCanBeSubmit)
			{
				This.fnSuccess(this);
			}
			else
			{
				return false;		
			}
		}
	}
}

//验证
FormCheck.prototype.check = function(oInput, re)
{
	this.oError = getByClassName(oInput.parentNode, 'error')[0];
	this.oClose_btn_success = getByClassName(oInput.parentNode, 'close_btn_success')[0];
	this.oClose_btn_error = getByClassName(oInput.parentNode, 'close_btn_error')[0];
	var inpVal = oInput.value;
	if(inpVal != '')
	{
		//第一关
		if(oInput.id=="withdrawals"){
			while (inpVal.indexOf(",") != -1) {
				inpVal = inpVal.replace(",","");
			}
		}
		if(oInput.id=="bankId"){
			while (inpVal.indexOf(" ") != -1) {
				inpVal = inpVal.replace(" ","");
			}
		}
		if(re.test(inpVal))
		{
			//第二关、二次校验
			if(!this.fnSecondDetection)	//不需要二次校验
			{
				this.hideErrorBoxAndshowSuccessBtn(this.oError, this.oClose_btn_success, oInput);
				this.reSetInputValueWhenSuccess(this.oClose_btn_success, oInput);
				return true;
			}
			else
			{
				if(false == this.fnSecondDetection(oInput))
				{
					this.setAndShowErrorBox(this.oError, oInput, this.oClose_btn_error, this.oClose_btn_success);
					this.reSetInputValueWhenError(this.oError, oInput, this.oClose_btn_error);
					return false;
				}
				else
				{
					this.hideErrorBoxAndshowSuccessBtn(this.oError, this.oClose_btn_success, oInput);
					this.reSetInputValueWhenSuccess(this.oClose_btn_success, oInput);
					return true;
				}
			}
		}
		else
		{
			this.setAndShowErrorBox(this.oError, oInput, this.oClose_btn_error, this.oClose_btn_success);
			this.reSetInputValueWhenError(this.oError, oInput, this.oClose_btn_error);
			return false;
		}
	}
	else
	{
		if(oInput.id == 'referee') return true;
		this.setAndShowErrorBox(this.oError, oInput, this.oClose_btn_error, this.oClose_btn_success);
		this.reSetInputValueWhenError(this.oError, oInput, this.oClose_btn_error);
		return false;
	}
}

//第二次验证
FormCheck.prototype.secondCheck = function(oInput)
{
	if(oInput.id == 'graphic_code')
	{
		//客户端图形验证码
		var sCodeClient = oInput.value;
		
		//异步获取服务图形验证码 sCodeServer 并赋值
		var sCodeServer = sCodeClient;
		if(sCodeClient != sCodeServer)
		{
			return false;	
		}	
	}
	else if(oInput.id == 'code')
	{
		//客户端短信验证码
		var sCodeClient = oInput.value;
		
		//异步获取服务端短信验证码 sCodeServer 并赋值
		var sCodeServer = sCodeClient;
		if(sCodeClient != sCodeServer)
		{
			return false;	
		}	
	}
}

//验证错误提示
FormCheck.prototype.setAndShowErrorBox = function(oError, oInput, oClose_btn_error, oClose_btn_success)
{
	var str = '';
	if(oInput.id == 'phone')
	{
		if(oInput.value == '' || oInput.value == '输入手机号码')
		{
			str = '请输入手机号码';
		}
		else
		{
			str = '请输入正确的手机号码';
		}
	}
	else if(oInput.id == 'graphic_code')
	{
		if(oInput.value == '' || oInput.value == '图形验证码')
		{
			str = '请输入图形验证码';
		}
		else
		{
			str = '请输入正确的图形验证码';
		}
	}
	else if(oInput.id == 'code')
	{
		if(oInput.value == '' || oInput.value == '输入短信验证码')
		{
			str = '请输入短信验证码';
		}
		else
		{
			str = '请输入正确的短信验证码';
		}	
	}
	else if(oInput.id == 'password' || oInput.id == 'password2' || oInput.id == 'password3')
	{
		if(oInput.value == '' || oInput.value == '输入密码')
		{
			str = '请输入密码';
		}
		else if(oInput.bPasswordError)
		{
			str = '两次密码输入不一致';
			oInput.bPasswordError = false;	
		}
		else
		{
			str = '密码格式错误';	
		}	
	}
	else if(oInput.id == 'username')
	{
		if(this.bHaved)
		{
			str = '用户名已被注册';
		}
		else
		{
			if(oInput.value == '' || oInput.value == '输入用户名')
			{
				str = '请输入用户名';
			}
			else
			{
				str = '用户名格式错误';
			}	
		}
	}
	else if(oInput.id == 'realName')
	{

		if(oInput.value == '' || oInput.value == '请输入真实姓名')
		{
			str = '请输入真实姓名';
		}
		else
		{
			str = '真实姓名格式错误';
		}	
	}
	else if(oInput.id == 'personId')
	{

		if(oInput.value == '' || oInput.value == '请输入身份证号')
		{
			str = '请输入身份证号';
		}
		else
		{
			str = '身份证号格式错误';
		}	
	}
	else if(oInput.id == 'userNameAndMailbox')
	{

		if(oInput.value == '' || oInput.value == '邮箱 / 用户名')
		{
			str = '请输入邮箱或用户名';
		}
		else
		{
			str = '邮箱或用户名格式错误';
		}
	}
	else if(oInput.id == 'amount')
	{

		if(oInput.value == '')
		{
			str = '请输入金额';
		}
		else 
		{
			str = '金额格式错误';
		}	
	}
	else if(oInput.id == 'referee')
	{

		if(oInput.value == '' || oInput.value == '推荐人ID（选填）')
		{
			str = '请输入推荐人ID';
		}
		else
		{
			str = '推荐人ID格式错误';
		}
	}else if(oInput.id == 'cash')
	{

		if(oInput.value == '')
		{
			str = '请输入金额';
		}
		else if(Number(oInput.value) < 100)
		{
			str = '投资金额必须大于100元';
		}
		else
		{
			str = '金额格式错误';
		}	
	}
	else if(oInput.id == 'withdrawals')
	{

		if(oInput.value == '')
		{
			str = '请输入金额';
		}
		else if(Number(oInput.value) < 2)
		{
			str = '提现金额必须大于2元';
		}
		else
		{
			str = '金额格式错误';
		}	
	}
	else if(oInput.id == 'RechargeIn')
	{

		if(oInput.value == '')
		{
			str = '请输入金额';
		}
//		else if(Number(oInput.value) < 100)
//		{
//			str = '充值金额必须大于100元';
//		}
		else
		{
			str = '金额格式错误';
		}	
	}else if(oInput.id == 'bankId')
	{

		if(oInput.value == '' || oInput.value == '请输入银行卡号')
		{
			str = '请输入银行卡号';
		}
		else
		{
			str = '银行卡号格式错误';
		}	
	}
	this.setErrorTextAndshowErrorBox(oError, oInput, oClose_btn_error, oClose_btn_success, str);
}

//设置错误提示内容
FormCheck.prototype.setErrorText = function(oError, str)
{
	oError.innerHTML = str;
}

//显示错误提示窗口
FormCheck.prototype.showErrorBox = function(oError)
{
	oError.style.display = 'block';
	startMove(oError, {height:this.iHeight, opacity:100}, {time:300});
}

//隐藏错误提示窗口
FormCheck.prototype.hideErrorBox = function(oError)
{
	startMove(oError, {height:0, opacity:0, marginBottom:0}, {time:300, fn:function(obj){
		obj.style.display = 'none';
	}});
}

FormCheck.prototype.setAndShowError = function(oError, str)
{
	oError.style.height = 0;
	this.setErrorText(oError, str);
	this.showErrorBox(oError);
}

//隐藏错误提示窗口并显示成功关闭按钮
FormCheck.prototype.hideErrorBoxAndshowSuccessBtn = function(oError, oClose_btn_success, oInput)
{
	this.hideErrorBox(oError);
	this.showSuccessBtn(oClose_btn_success);
	this.removeErrorBorder(oInput);
}

//设置错误内容并且明显错误提示框
FormCheck.prototype.setErrorTextAndshowErrorBox = function(oError, oInput, oClose_btn_error, oClose_btn_success, str)
{
	this.setErrorText(oError, str);
	this.showErrorBox(oError);
	this.showErrorBtn(oClose_btn_error);
	this.hideSuccessBtn(oClose_btn_success);
	this.addErrorBorder(oInput);
}

//设置错误内容并且明显错误提示框
FormCheck.prototype.setErrorValue = function(oError, oInput, oClose_btn_error, oClose_btn_success, str)
{
	this.setErrorTextAndshowErrorBox(oError, oInput, oClose_btn_error, oClose_btn_success, str);
	this.reSetInputValueWhenError(oError, oInput, oClose_btn_error);
}

//光标聚焦时value值改变对象
function ChangeValue (id, str)
{
	this.oInput = document.getElementById(id);
	this.str = str;
	
	this.changeValue(this.str);
}

//改变输入框值
ChangeValue.prototype.changeValue = function(str)
{
	var This = this;
	
	addEvent(this.oInput, 'focus', focus);
	addEvent(this.oInput, 'blur', blur);
	
	function focus()
	{
		if(This.oInput.placeholder == str)
		{
			This.oInput.placeholder = '';	
		}
		removeEvent(This.oInput, 'focus', focus);
	}
	
	function blur()
	{
		if(This.oInput.value == '')
		{
			This.oInput.placeholder = str;	
		}
		removeEvent(This.oInput, 'blur', blur);
	}
}

//短信验证码处理对象
function Code(idCodeBtn, idPhone, idGraphic_code)
{
	this.oCodeBtn = document.getElementById(idCodeBtn);
	this.oPhone = document.getElementById(idPhone);
	this.oGraphic_code = document.getElementById(idGraphic_code);
	
	this.bCanObtainCode = true;	
	this.oTimer = null;
	this.iNum = 120;
	
	//this.obtainCode();
}

//获取短信验证码
Code.prototype.obtainCode = function()
{
	var This = this;
	this.oCodeBtn.onclick = function()
	{
		var rePhone = oControl.oFormCheck1.json.phone;
		var graphic_code = oControl.oFormCheck1.json.graphic_code;
		if(This.oPhone.value != '')
		{
			if(rePhone.test(This.oPhone.value))
			{
				if(This.oGraphic_code.value != '')
				{
					if(graphic_code.test(This.oGraphic_code.value))
					{
						if(This.bCanObtainCode)
						{
							//向手机发送验证码
							This.sPhoneNumber = This.oPhone.value;
							This.imgCode = This.oGraphic_code.value;
							This.sentCode(This.sPhoneNumber, This.imgCode);
						}
					}
					else
					{
						oControl.oFormCheck1.setErrorTextAndshowErrorBox('请输入正确的图形验证码');
					}
				}
				else
				{
					oControl.oFormCheck1.setErrorTextAndshowErrorBox('请输入图形验证码');
				}
			}
			else
			{
				oControl.oFormCheck1.setErrorTextAndshowErrorBox('请输入正确的手机号码');
			}
		}
		else
		{
			oControl.oFormCheck1.setErrorTextAndshowErrorBox('请输入手机号码');
		}
	}
}

//向手机发送验证码
Code.prototype.sentCode = function(sPhoneNumber, sImgCode)
{
	//代码
	//alert(sPhoneNumber); 手机号码
	//alert(sImgCode) 图形验证码
	//发送成功调用下面方法，并且把bCanObtainCode设置成false
	This = this;
	var param = {};
	param["phone"] = sPhoneNumber;
	param["imgCode"] = sImgCode;
	$.ajax({
		type: "post",
		contentType:"application/json",
		url: "phoneCodeSMSForReg",
		data: JSON.stringify(param),
		success: function(data){
			data = eval("("+data+")");
			if(data.errorNo=="200"){
				This.noObtain();
				This.setCountdown()
				This.bCanObtainCode = false;
			}else {
				alert(data.msg);
			}
		}
	});
}

//不能获取
Code.prototype.noObtain = function()
{
	addClass(this.oCodeBtn, 'noObtain');
	this.oCodeBtn.innerHTML = this.getCountTime() + '秒后重新获取';
}

//可以获取
Code.prototype.canobtain = function()
{
	removeClass(this.oCodeBtn, 'noObtain');
	this.oCodeBtn.innerHTML = '获取短信验证码';
}

//获取倒计时时间
Code.prototype.getCountTime = function()
{
	return 120;
}

//倒计时
Code.prototype.setCountdown = function()
{
	var This = this;
	this.iNum = this.getCountTime();
	clearInterval(this.oTimer);
	this.oTimer = setInterval(function(){
		This.countdown();
	},1000);
}

//倒计时
Code.prototype.countdown = function()
{
	this.iNum--;
	this.oCodeBtn.innerHTML = this.iNum + '秒后重新获取';
	if(this.iNum == 0)
	{
		clearInterval(this.oTimer);	
		this.bCanObtainCode = true;
		this.canobtain();
	}
}

//第二个发送短信验证码
function CodeForFindPassword(idCodeBtn, idPhone, idGraphic_code)
{
	//继承父级的属性
	Code.apply(this, arguments);
}

//继承父级的方法
CodeForFindPassword.prototype = new Code();
CodeForFindPassword.prototype.constructor = CodeForFindPassword;

//获取短信验证码  重写方法
CodeForFindPassword.prototype.obtainCode = function()
{
	var This = this;
	this.oCodeBtn.onclick = function()
	{

		if(This.bCanObtainCode)
		{
			//向手机发送验证码
			This.sentCode();
		}
	}
}

//向手机发送验证码 重写方法
CodeForFindPassword.prototype.sentCode = function()
{
	//发送成功调用下面方法，并且把bCanObtainCode设置成false
	//三方支付 发送交易短信验证码
	This = this;
	var param = {};
	param["mobilePhone"] = $("#mobilePhone").val();
	$.ajax({
		type: "post",
		url: basePath + "register/forgetYeepayPWDPhoneSMS",
		data: param,
		success: function(data){
			data = eval("("+data+")");
			if(data =="0"){
				This.noObtain();
				This.setCountdown()
				This.bCanObtainCode = false;
			}else if(data  == "-1"){
				window.location.href = basePath + "login";
			}else {
				alert(data);
			}
		}
	});
}

//第三个发送短信验证码
function CodeForAddBankCard(idCodeBtn, idPhone, idGraphic_code)
{
	//继承父级的属性
	Code.apply(this, arguments);
}

//继承父级的方法
CodeForAddBankCard.prototype = new Code();
CodeForAddBankCard.prototype.constructor = CodeForAddBankCard;

//获取短信验证码  重写方法
CodeForAddBankCard.prototype.obtainCode = function()
{
	var This = this;
	this.oCodeBtn.onclick = function()
	{
		var rePhone = /(^[1][3][0-9]{9}$)|(^[1][4][0-9]{9}$)|(^[1][5][0-9]{9}$)|(^[1][7][0-9]{9}$)|(^[1][8][0-9]{9}$)/;
		if(This.oPhone.value != '')
		{
			if(rePhone.test(This.oPhone.value))
			{
				if(This.bCanObtainCode)
				{
					//向手机发送验证码
					This.sPhoneNumber = This.oPhone.value;
					
					This.sentCode(This.sPhoneNumber);
				}
			}
		}
	}
}

//向手机发送验证码 重写方法
CodeForAddBankCard.prototype.sentCode = function(sPhoneNumber)
{
	//发送成功调用下面方法，并且把bCanObtainCode设置成fal
	//alert(sPhoneNumber);
	var param ={};
	param["bankCode"] = $("#bankCode").val();
	param["bankName"] = $("#bankName").val();
	param["cardNo"] = $("#cardNo").val();
	param["mobilePhone"] = $("#phone").val();
	param["cardType"] = $("#cardType").val();
	var This = this;
	$.ajax({
		type : "post",
		url : basePath + "bankcard/yeepayBindCardCode",
		data : param,
		async : false,
		success : function(data){
				data = eval("("+data+")");
				if(data.code == "1"){
					$("#bindCardId").val(data.bindCardId);
					This.noObtain();
					This.setCountdown()
					This.bCanObtainCode = false;
				}else{
					//alert(data.msg);
					oControl.oFormCheck.setErrorValue(oControl.oFormCheck.aError[1], oControl.oFormCheck.aInput[1], oControl.oFormCheck.aClose_btn_error[1], oControl.oFormCheck.aClose_btn_success[1], data.msg);
				}
			}
		});
	
}

//第四个发送短信验证码
function CodeForRecharge(idCodeBtn, idPhone, idGraphic_code)
{
	//继承父级的属性
	Code.apply(this, arguments);
}

//继承父级的方法
CodeForRecharge.prototype = new Code();
CodeForRecharge.prototype.constructor = CodeForRecharge;

//获取短信验证码  重写方法
CodeForRecharge.prototype.obtainCode = function()
{
	var This = this;
	this.oCodeBtn.onclick = function()
	{
		if(This.bCanObtainCode)
		{
			//向手机发送验证码
			//This.sPhoneNumber = This.oPhone.value;
			This.sentCode(This.sPhoneNumber);
		}
	}
}

//向手机发送验证码 重写方法
CodeForRecharge.prototype.sentCode = function(sPhoneNumber)
{
	//发送成功调用下面方法，并且把bCanObtainCode设置成fal
	//alert(sPhoneNumber);
	var This = this;
	var param = {};
	param["rechargeId"] = $("#rechargeId").val();
	$.ajax({
		type: "post",
		url: basePath + "bankcard/yeepaySendRechargeSms",
		data: param,
		success: function(data){
			data = eval("("+data+")");
			if(data =="1"){
				This.noObtain();
				This.setCountdown()
				This.bCanObtainCode = false;
			}else if(data  == "-1"){
				window.location.href = basePath + "login";
			}else {
				alert(data);
			}
		}
	});
}

//显示隐藏图形验证码窗口对象
function Graphic_code_box(id)
{
	this.oGraphic_code_box = document.getElementById(id);
	this.oInput = this.oGraphic_code_box.getElementsByTagName('input')[0];
}

//显示图形验证码,并初始化一些方法
Graphic_code_box.prototype.showGraphic_code_box = function(obj)
{
	this.oGraphic_code_box.style.display = 'block';
	this.oInput.id = 'graphic_code';
	var re = obj.json['graphic_code'];
	if(re)
	{
		this.oInput.onblur=function ()
		{
			if(this.value == '')
			{
				obj.removeFocusBorder(this);
				return;	
			}
			obj.check(this, re);
		}
		
		this.oInput.onfocus=function ()
		{
			obj.HighlightBorder(this);
		}
	}
	var oChange5 = new ChangeValue('graphic_code', '图形验证码');
}

//隐藏图形验证码
Graphic_code_box.prototype.hideGraphic_code_box = function()
{
	this.oGraphic_code_box.style.display = 'none';
	this.oInput.id = '';
}

//加载对象
function Loading(id)
{
	this.oSection_box = document.getElementById(id);
	this.oLoading = getByClassName(this.oSection_box.parentNode, 'loadingBar')[0];
	this.oLoadingMove = document.getElementById('loadingMove');
	
	//能继续加载的标志
	this.bEnd = false;
}

//加载中
Loading.prototype.loading = function()
{
	this.oLoading.innerHTML = '<i></i>加载中…';
	addClass(this.oLoading, 'icon');
}

//松手开始加载
Loading.prototype.swiperUp = function()
{
	this.oLoading.innerHTML = '松手开始加载';
	addClass(this.oLoading, 'icon');	
}

//加载成功后
Loading.prototype.swiperSuccess = function()
{
	removeClass(this.oLoading, 'icon');
	this.oLoading.innerHTML = '点击加载更多';
}

//加载成功后
Loading.prototype.swiperSuccessbyClick = function()
{
	removeClass(this.oLoading, 'icon');
	this.oLoading.innerHTML = '点击加载更多';
}

//没有更多了
Loading.prototype.noMore = function()
{
	removeClass(this.oLoading, 'icon');
	this.oLoading.innerHTML = '没有更多了';
	//不能继续加载
	this.bEnd = true;
}

//点击加载数据
Loading.prototype.loadingByClick = function(sUrl, param, bLoadingByScroll)
{
	var This = this;
	if(this.oLoadingMove)
	{
		this.oLoadingMove.onclick = function()
		{
			This.clickHandle(sUrl, param, bLoadingByScroll);
		}
	}
	if(this.oLoading)
	{
		this.oLoading.onclick = function()
		{
			This.clickHandle(sUrl, param, bLoadingByScroll);
		}
	}
}

//点击处理方法
Loading.prototype.clickHandle = function(sUrl, param, bLoadingByScroll)
{
	this.bLoadingByScroll = bLoadingByScroll;
	if(this.oLoadingMove)
	{
		this.oLoadingMove.style.display = 'none';	
	}
	this.oLoading.style.display = 'block';
	this.loadingHandle(sUrl, param);
	if(!bLoadingByScroll)
	{
		this.doLoadingByScroll(sUrl, param);
	}
}

//滚动到一定位置加载数据
Loading.prototype.doLoadingByScroll = function(sUrl, param)
{
	var This = this;
	addEvent(window, 'scroll', scrollTab);
	function scrollTab()
	{
		var winH = document.documentElement.clientHeight;
		var iScrollTop = getTop();
		if(iScrollTop > This.oSection_box.scrollHeight + getPos(This.oSection_box).top - winH + 50 && !This.bEnd)
		{
			//拖到最下面
			This.bEnd = true;  //不能再加载下一次
			This.loadingHandle(sUrl, param); 
		}	
		removeEvent(window, 'scroll', scrollTab);
	}
}

//初始化进度条
Loading.prototype.initProgressBar = function(obj)
{
	var oProgressBar_box = getByClassName(obj, 'progressBar_box')[0];
	var oProgressBar = new ProgressBar(oProgressBar_box);
}

//加载控制
Loading.prototype.loadingHandle = function(sUrl, param)
{
	var This = this;
	switch(this.oSection_box.id)
	{
		case 'productList':
			param["newBorrowType"] = 1;
			var sumCountpage = $("#sumCountPage").val();
			if(sumCountpage != "" && typeof(sumCountpage) != 'undefined'){
				param["pageNumber"]=sumCountpage;
			}else{
				param["pageNumber"]=0;
			}
			break;
		
		case 'investment_record':
			var sumCountpage = $("#sumCountPage").val();
			if(sumCountpage != "" && typeof(sumCountpage) != 'undefined'){
				param["pageNumber"]=sumCountpage;
			}else{
				param["pageNumber"]=0;
			}
			break;	
		case 'purchase_amount':
			var sumCountpage = $("#sumCountPage").val();
			if(sumCountpage != "" && typeof(sumCountpage) != 'undefined'){
				param["pageNumber"]=sumCountpage;
			}else{
				param["pageNumber"]=0;
			}
			break;
		case 'couponAvailable':
			var pageNumberUseCash = $("#pageNumberUseCash").val();
			if(pageNumberUseCash != "" && typeof(pageNumberUseCash) != 'undefined'){
				param["pageNumber"]=pageNumberUseCash;
			}else{
				param["pageNumber"]=0;
			}
			break;
		case 'couponNotAvailable':
			var pageNumberNoCash = $("#pageNumberNoCash").val();
			if(pageNumberNoCash != "" && typeof(pageNumberNoCash) != 'undefined'){
				param["pageNumber"]=pageNumberNoCash;
			}else{
				param["pageNumber"]=0;
			}
			break;
		case 'purchase_box':
			//购买
			var pageNumber = $("#pageNumberBuy").val();
			if(pageNumber != "" && typeof(pageNumber) != 'undefined'){
				param["pageNumber"]=pageNumber;
			}else{
				param["pageNumber"]=0;
			}
			break;	
		case 'profit_box':
			//收益
			var pageNumber = $("#pageNumberIncome").val();
			if(pageNumber != "" && typeof(pageNumber) != 'undefined'){
				param["pageNumber"]=pageNumber;
			}else{
				param["pageNumber"]=0;
			}
			break;	
		case 'redeem_box':
			//赎回
			var pageNumber = $("#pageNumberRedeem").val();
			if(pageNumber != "" && typeof(pageNumber) != 'undefined'){
				param["pageNumber"]=pageNumber;
			}else{
				param["pageNumber"]=0;
			}
			break;	
	}
	
	$.ajax({
		url: sUrl,
		type:'post',
		beforeSend: function(){
			This.loading();
		},
		data : param,  
		success: function(data){
			//改变下载条样式，文字
			if(!This.bLoadingByScroll)
			{
				This.swiperSuccess();
			}
			else
			{
				This.swiperSuccessbyClick();
			}
			
			//ajax请求
			switch(This.oSection_box.id)
			{
				case 'productList':
					This.ajaxIndex(data);
					break;
				case 'investment_record':
					This.ajaxInvestmentRecord(data);
					break;	
				case 'purchase_amount':
					This.ajaxPurchaseAmount(data);
					break;
				case 'couponAvailable':
					This.ajaxCouponAvailable(data);
					break;
				case 'couponNotAvailable':
					This.ajaxCouponNotAvailable(data);
					break;	
				case 'purchase_box':
					//购买
					This.ajaxHqbBuy(data);
					break;
				case 'profit_box':
					//收益
					This.ajaxHqbIncome(data);
					break;
				case 'redeem_box':
					//赎回
					This.ajaxHqbRedeem(data);
					break;
			}
		},
		error: function(){
			This.oLoading.innerHTML = '加载失败，请上拉重新加载';
			//能继续加载的标志
			This.bEnd = false;
		}
	});
}

//首页ajax请求
Loading.prototype.ajaxIndex = function(data)
{
	var pageNumberT = $("#pageNumberT").val();
	var ajaxT = true;
	if(pageNumberT == "1"){
		ajaxT = false;
	}
	//加载完
	if(ajaxT)
	{
		$("#productList").html(data);
		//进度条
		var aProgressBar_box = getByClassName(document, 'progressBar_box');
		for(var i = 0; i < aProgressBar_box.length; i++)
		{
			var oProgressBar = new ProgressBar(aProgressBar_box[i]);
		}
		
		//倒计时
		var aCountDown = getByClassName($("#productList").get(0), 'countDown');
		var aCountTime = getByClassName($("#productList").get(0), 'countTime');
		for(var i = 0; i < aCountDown.length; i++)
		{
			var oCountDown = new Countdown(aCountDown[i], aCountTime[i]);
			oCountDown.setCountdown();
		}

		//能继续加载的标志
		this.bEnd = false;
	}
	else
	{
		this.noMore();
	}
	
	var sumCountpage = $("#sumCountPage").val();
	var pageNumberTEnd = $("#pageNumberT").val();
	if(sumCountpage < pageIndexCount || data == '' || pageNumberTEnd == "1"){
		this.noMore();	
	}
}

//投资记录ajax请求
Loading.prototype.ajaxInvestmentRecord = function(data)
{	
	var pageNumberT = $("#pageNumberT").val();
	var ajaxT = true;
	if(pageNumberT == "1"){
		ajaxT = false;
	}
	//meiyou加载完
	if(ajaxT)
	{
		$("#investment_record").html(data);
		
		//能继续加载的标志
		this.bEnd = false;
	}
	else
	{
		this.noMore();	
	}
	
	var sumCountpage = $("#sumCountPage").val();
	var pageNumberTEnd = $("#pageNumberT").val();
	if(sumCountpage < pageCount || data == '' || pageNumberTEnd == "1"){
		this.noMore();	
	}
}

//购买记录ajax请求
Loading.prototype.ajaxPurchaseAmount = function(data)
{	
	var pageNumberT = $("#pageNumberT").val();
	var ajaxT = true;
	if(pageNumberT == "1"){
		ajaxT = false;
	}
	if(ajaxT)
	{
		$("#purchase_amount").html(data);
		//能继续加载的标志
		this.bEnd = false;
	}
	else
	{
		this.noMore();	
	}
	
	var sumCountpage = $("#sumCountPage").val();
	var pageNumberTEnd = $("#pageNumberT").val();
	if(sumCountpage < pageCount || data == '' || pageNumberTEnd == "1"){
		this.noMore();	
	}
}

//优惠券（可用）ajax请求
Loading.prototype.ajaxCouponAvailable = function(data)
{
	var pageNumberT = $("#pageNumberTUseCash").val();
	var ajaxT = true;
	if(pageNumberT == "1"){
		ajaxT = false;
	}
	if(ajaxT)
	{
		$("#couponAvailable").html(data);
		//能继续加载的标志
		this.bEnd = false;
	}
	else
	{
		this.noMore();	
	}
	
	var pageNumberUseCash = $("#pageNumberUseCash").val();
	var pageNumberTEnd = $("#pageNumberTUseCash").val();
	if(pageNumberUseCash < pageIndexCount || data == '' || pageNumberTEnd == "1"){
		this.noMore();	
	}
}

//优惠券（过期）ajax请求
Loading.prototype.ajaxCouponNotAvailable = function(data)
{
	var pageNumberT = $("#pageNumberT").val();
	var ajaxT = true;
	if(pageNumberT == "1"){
		ajaxT = false;
	}
	if(ajaxT)
	{	
		$("#couponNotAvailable").html(data);
		//能继续加载的标志
		this.bEnd = false;
	}
	else
	{
		this.noMore();	
	}
	
	var pageNumberNoCash = $("#pageNumberNoCash").val();
	var pageNumberTEnd = $("#pageNumberT").val();
	if(pageNumberNoCash < pageIndexCount || data == '' || pageNumberTEnd == "1"){
		this.noMore();	
	}
}

//天天盈收益
Loading.prototype.ajaxHqbIncome = function(data)
{	
	var pageNumberT = $("#pageNumberTIncome").val();
	var ajaxT = true;
	if(pageNumberT == "1"){
		ajaxT = false;
	}
	//meiyou加载完
	if(ajaxT)
	{
		$("#profit_box").html(data);
		
		//能继续加载的标志
		this.bEnd = false;
	}
	else
	{
		this.noMore();	
	}
	
	var pageNumber = $("#pageNumberIncome").val();
	var pageNumberTEnd = $("#pageNumberTIncome").val();
	if(pageNumber < pageCount || data == '' || pageNumberTEnd == "1"){
		this.noMore();	
	}
}

//天天盈购买
Loading.prototype.ajaxHqbBuy = function(data)
{	
	var pageNumberT = $("#pageNumberTBuy").val();
	var ajaxT = true;
	if(pageNumberT == "1"){
		ajaxT = false;
	}
	//meiyou加载完
	if(ajaxT)
	{
		$("#purchase_box").html(data);
		
		//能继续加载的标志
		this.bEnd = false;
	}
	else
	{
		this.noMore();	
	}
	var pageNumber = $("#pageNumberBuy").val();
	var pageNumberTEnd = $("#pageNumberTBuy").val();
	if(pageNumber < pageCount || data == '' || pageNumberTEnd == "1"){
		this.noMore();	
	}
}

//天天盈赎回
Loading.prototype.ajaxHqbRedeem = function(data)
{	
	var pageNumberT = $("#pageNumberTRedeem").val();
	var ajaxT = true;
	if(pageNumberT == "1"){
		ajaxT = false;
	}
	//meiyou加载完
	if(ajaxT)
	{
		$("#redeem_box").html(data);
		$("#reddemMoreBtn").show();
		//能继续加载的标志
		this.bEnd = false;
	}
	else
	{
		this.noMore();	
	}
	
	var pageNumber = $("#pageNumberRedeem").val();
	var pageNumberTEnd = $("#pageNumberTRedeem").val();
	
	var list = $("#list").val();
	if(list <= 0 ){
		$("#reddemMoreBtn").hide();
	}
	if(pageNumber < pageCount || data == '' || pageNumberTEnd == "1"){
		this.noMore();	
	}
}

//投资记录选项卡(切换效果)
//投资记录选项卡
function TabBox(id)
{
	this.oTab = document.getElementById(id);
	this.oTabUl = this.oTab.getElementsByTagName('ul')[0];
	this.aLi = this.oTabUl.getElementsByTagName('li');
	this.aCon = getByClassName(this.oTab, 'con');
	//alert(this.aCon.length);
	this.show();
	
	this.index = 0;

}

//显示切换
TabBox.prototype.show = function()
{
	var This = this;
	for(i=0;i<this.aLi.length;i++)
	{ 
		this.aLi[i].index = i;
		this.aLi[i].onclick = function()
		{	
			This.index = this.index;
			for(i=0;i<This.aLi.length;i++)
			{
				This.aLi[i].className =" ";
				This.aCon[i].style.display='none';
			}	
			this.className ="on";
			This.aCon[this.index].style.display='block';
		}	
	}
}


