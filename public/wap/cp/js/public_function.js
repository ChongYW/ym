//��дtrim����
String.prototype.trim = function()
{
	return this.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}

//ǧλ��
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

//��ȡ��������ʽ
function getStyle(obj, name)
{
	return obj.currentStyle ? obj.currentStyle[name] : getComputedStyle(obj, false)[name];
}

//�˶����
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

//ͨ��class��ȡԪ��
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

//���class
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

//ɾ��class
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

//�Ƿ���ĳ��class
function hasClass(obj, sClass)
{
	var re = new RegExp('\\b' + sClass + '\\b');
	if(re.test(obj.className))
	{
		return true;
	}	
	return false;
}

//��
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

//�����
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

//����ͬ
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

//��������ǰ���0
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

//��ȡ���Ը߶�
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

//�Ƿ��Ǹ��Ӽ���ϵ
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
	return false; //������Ԫ�ػ��Լ�
}

//����cookie
function setCookie(name, value, iDay)
{
	var oDate=new Date();
	oDate.setDate(oDate.getDate() + iDay);
	document.cookie = name + '=' + value + ';expires=' + oDate + ';path=/';
}
	
//��ȡcookie
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

//�Ƿ���app
function isApp()
{
	if(window.navigator.userAgent.indexOf("HSD-001APP") > 0)
	{
		//��app
		return true;
	}

	//����app
	return false;
}

//�Ƿ�ios
function isIos()
{
	if(window.navigator.userAgent.indexOf("iPhone") > 0 || window.navigator.userAgent.indexOf("iPad") > 0)
	{
		//��ios�ֻ�
		return true;	
	}
	
	//����ios�ֻ�
	return false;
}
  
//�Ƿ�pc
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

//�Ự�洢����
function sessionStorageSaveItem(key,value){
	sessionStorage.setItem(key, value);
}

//�Ự��ȡ����
function sessionStorageGetItem(key){
	return sessionStorage.setItem(key);
}

//Ĭ��ѡ�к��
function selectDefaultCoupon(){
	var couponId = '';
	var couponType = 0;
	var couponFaceValue = 0;
	var selectedLiObj; //��ѡ�еĺ��li��ǩDOM����,Ĭ�ϳ�ʼֵΪundefine
	//�ж϶���֧���Ƿ��Ѿ�ѡ����
	$(".package_list li").each(function(){
		if(!$(this).hasClass("not_used") && $(this).hasClass("active")){
			couponFaceValue = $(this).find(".face_value span").text();
		}
	});
	if(couponFaceValue != 0){
		return false;//����Ѿ���Ĭ�Ϻ���Ų�����ɸѡ
	}
	
	$(".package_list li").each(function(){
		if(!$(this).hasClass("not_used")&&!$(this).hasClass("usd_list")){
			var couponIdInput =  $(this).find(".package_id").val();
			var couponTypeInput = $(this).find(".couponType").val();
			var couponFaceValueInput = $(this).find(".face_value span").text();
			//����ѡ���ֽ��������ֵ
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
	//û��ѡ���ֽ�������ѡ���Ϣ���
	if(couponFaceValue ==0 ){
		$(".package_list li").each(function(){
			if(!$(this).hasClass("not_used")&&!$(this).hasClass("usd_list")){
				var couponIdInput =  $(this).find(".package_id").val();
				var couponTypeInput = $(this).find(".couponType").val();
				var couponFaceValueInput = $(this).find(".face_value span").text();
				//����ѡ�м�Ϣ��������ֵ
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
	// ������ͣ�10�ֽ�20��Ϣ��30�ƽ�
	if(couponType == 10){
		selectedLiObj.addClass("active");//��ѡ�еĺ����ǩ��class���
		$(".package_box").html("�ֽ���"+couponFaceValue+"Ԫ");
	}
	else if(couponType == 20){
		selectedLiObj.addClass("active");//��ѡ�еĺ����ǩ��class���
		$(".package_box").html("��Ϣ���"+couponFaceValue+"%");
	}
	//��ֵ������������
	setCouponProperties(couponId,couponType,couponFaceValue);
	//����֧�����
	updateBuyAmount();
}