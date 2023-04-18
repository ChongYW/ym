//重写trim方法
String.prototype.trim = function()
{
	return this.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}

//千位符
function toThousands(num)
{
	if((num + '').trim() == '')
	{
		return '';
	}
	if(isNaN(num))
	{
		return '';
	}
	num = num + '';
	
	if(/^.*\..*$/.test(num))
	{
		var pointIndex = num.lastIndexOf('.');
		var intPart = num.substring(0, pointIndex);
		var pointPart = num.substring(pointIndex + 1, num.length);
		intPart = intPart + '';
		var re = /(-?\d+)(\d{3})/;
	
		while(re.test(intPart))
		{
			intPart = intPart.replace(re, '$1,$2');
		}
		num = intPart + '.' + pointPart;
	}
	else
	{
		num = num + '';
		var re = /(-?\d+)(\d{3})/;
	
		while(re.test(num))
		{
			num =num.replace(re, '$1,$2')
		}
	}
	return num;
}

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
	if(null == oParent || undefined == oParent) return [];
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

//绑定
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

//找相同
function findSame(arr, n)
{
	for(var i = 0; i < arr.length; i++)
	{
		if(arr[i] == n)
		{
			return true;	
		}	
	}
	return false;
}

//单个数字前面加0
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

//获取绝对高度
function getPos(obj)
{
	var l = 0;
	var t = 0;
	while(obj)
	{
		l += obj.offsetLeft;
		t += obj.offsetTop;
		obj = obj.offsetParent;	
	}
	return {left: l, top: t};	
}

//是否是父子级关系
function isChild(oParent, obj)
{
	while(obj)
	{
		if(obj == oParent)
		{
			return true;
		}
		obj = obj.parentNode;
	}
	return false; //不是子元素或自己
}

//设置cookie
function setCookie(name, value, iDay)
{
	var oDate=new Date();
	oDate.setDate(oDate.getDate() + iDay);
	document.cookie = name + '=' + value + ';expires=' + oDate + ';path=/';
}
	
//获取cookie
function getCookie(name)
{
	//'username=abc; password=123456; aaa=123; bbb=4r4er'
	var arr = document.cookie.split('; ');
	var i = 0;
	//arr->['username=abc', 'password=123456', ...]
	for(i = 0; i < arr.length; i++)
	{
		//arr2->['username', 'abc']
		var arr2 = arr[i].split('=');
		if(arr2[0] == name)
		{
			return arr2[1];
		}
	}
	return '';
}

//是否是app
function isApp()
{
	if(window.navigator.userAgent.indexOf("HSD-001APP") > 0)
	{
		//是app
		return true;
	}

	//不是app
	return false;
}

//是否ios
function isIos()
{
	if(window.navigator.userAgent.indexOf("iPhone") > 0 || window.navigator.userAgent.indexOf("iPad") > 0)
	{
		//是ios手机
		return true;	
	}
	
	//不是ios手机
	return false;
}
  
//是否pc
function isPc()
{
	var iPc = 1;
	if(window.navigator.userAgent.indexOf("Android") > 0)
	{
		iPc = 0;
	}
	else if(window.navigator.userAgent.indexOf("iPhone") > 0)
	{
		iPc = 0;
	}
	else if(window.navigator.userAgent.indexOf("iPad") > 0)
	{
		iPc = 0;	
	}
	if(iPc == 1)
	{
		return true;	
	}
	return false;
}

//会话存储对象
function sessionStorageSaveItem(key,value){
	sessionStorage.setItem(key, value);
}

//会话获取对象
function sessionStorageGetItem(key){
	return sessionStorage.setItem(key);
}

//默认选中红包
function selectDefaultCoupon(){
	var couponId = '';
	var couponType = 0;
	var couponFaceValue = 0;
	var selectedLiObj; //被选中的红包li标签DOM对象,默认初始值为undefine
	//判断二次支付是否已经选择红包
	$(".package_list li").each(function(){
		if(!$(this).hasClass("not_used") && $(this).hasClass("active")){
			couponFaceValue = $(this).find(".face_value span").text();
		}
	});
	if(couponFaceValue != 0){
		return false;//如果已经有默认红包着不继续筛选
	}
	
	$(".package_list li").each(function(){
		if(!$(this).hasClass("not_used")&&!$(this).hasClass("usd_list")){
			var couponIdInput =  $(this).find(".package_id").val();
			var couponTypeInput = $(this).find(".couponType").val();
			var couponFaceValueInput = $(this).find(".face_value span").text();
			//优先选中现金红包最大面值
			if(couponTypeInput == 10){
				if(parseFloat(couponFaceValueInput)>parseFloat(couponFaceValue)){
					couponId = couponIdInput;
					couponType = couponTypeInput;
					couponFaceValue = couponFaceValueInput;
					selectedLiObj = $(this);
				}
			}
		}
	});
	//没有选到现金红包、再选择加息红包
	if(couponFaceValue ==0 ){
		$(".package_list li").each(function(){
			if(!$(this).hasClass("not_used")&&!$(this).hasClass("usd_list")){
				var couponIdInput =  $(this).find(".package_id").val();
				var couponTypeInput = $(this).find(".couponType").val();
				var couponFaceValueInput = $(this).find(".face_value span").text();
				//优先选中加息红包最大面值
				if(couponTypeInput == 20){
					if(parseFloat(couponFaceValueInput)>parseFloat(couponFaceValue)){
						couponId = couponIdInput;
						couponType = couponTypeInput;
						couponFaceValue = couponFaceValueInput;
						selectedLiObj = $(this);
					}
				}
			}
		});
	}
	// 红包类型：10现金；20加息；30黄金
	if(couponType == 10){
		selectedLiObj.addClass("active");//给选中的红包标签加class标记
		$(".package_box").html("现金红包"+couponFaceValue+"元");
	}
	else if(couponType == 20){
		selectedLiObj.addClass("active");//给选中的红包标签加class标记
		$(".package_box").html("加息红包"+couponFaceValue+"%");
	}
	//赋值隐藏域红包属性
	setCouponProperties(couponId,couponType,couponFaceValue);
	//更新支付金额
	updateBuyAmount();
}