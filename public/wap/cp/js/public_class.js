//项目前缀
var urlPerfix = $("#urlPerfix").val();
//选项卡
function Tab(id)
{
	this.oTab = document.getElementById(id);
	this.aBtn = getByClassName(this.oTab, 'btns');
	this.aBox = getByClassName(this.oTab, 'boxs');
}

//设置选项卡 没有事件
Tab.prototype.setTab = function(index)
{
	for(var i = 0; i < this.aBox.length; i++)
	{
		this.aBox[i].style.display = 'none';
	}
	this.aBox[index].style.display = 'block';
};

//设置选项卡 有事件
Tab.prototype.switchTab = function(sEven, fn)
{
	var This = this;
	for(var i = 0; i < this.aBtn.length; i++)
	{
		this.aBtn[i].index = i;
		this.aBtn[i][sEven] = function()
		{
			This.switchTabHandle(this.index);
			fn && fn(this);
		};
	}
};

//选项卡控制
Tab.prototype.switchTabHandle = function(index)
{
	for(var i = 0; i < this.aBox.length; i++)
	{
		removeClass(this.aBtn[i], 'on');
		this.aBox[i].style.display = 'none';
	}
	addClass(this.aBtn[index], 'on');
	this.aBox[index].style.display = 'block';
};

//单选框
function Radio()
{
	this.aInput = document.getElementsByTagName('input');
	
	//调用方法
	this.setRadio();
}

//单选实现
Radio.prototype.radio = function(name)
{
	var aSelect = document.getElementsByName(name);
	var aCell = getByClassName(aSelect[0].parentNode.parentNode, 'cell');
	var aSpan = [];
	for(var i = 0; i < aSelect.length; i++)
	{
		var oSpan = document.createElement('span');
		aSelect[i].parentNode.insertBefore(oSpan, aSelect[i]);
		aSpan.push(oSpan);
		oSpan.index = i;
		oSpan.parentNode.index = i;
		var oCell = getByClassName(oSpan.parentNode, 'cell')[0];
		if(aSelect[i].checked)
		{
			oSpan.className = 'radio_on';
			if(oCell)
			{
				oCell.style.border = '1px solid #FF9E12';
			}
		}
		else
		{
			oSpan.className = 'radio_off';
			if(oCell)
			{
				oCell.style.border = '1px solid #eee';	
			}
		}
		oSpan.onclick = function(ev)
		{
			var oEvent = ev || event;
			for(var i = 0; i < aSpan.length; i++)
			{
				aSpan[i].className = 'radio_off';
				if(aCell[i])
				{
					aCell[i].style.border = '1px solid #eee';
				}
			}
			aSpan[this.index].className = 'radio_on';	
			aSelect[this.index].checked = true;	
			var oCell = getByClassName(this.parentNode, 'cell')[0];
			if(oCell)
			{
				oCell.style.border = '1px solid #FF9E12';	
			}
			oEvent.cancelBubble = true;
		};
		oSpan.parentNode.onclick = function()
		{
			for(var i = 0; i < aSpan.length; i++)
			{
				aSpan[i].className = 'radio_off';
				if(aCell[i])
				{
					aCell[i].style.border = '1px solid #eee';
				}
			}
			aSpan[this.index].className = 'radio_on';	
			aSelect[this.index].checked = true;	
			var oCell = getByClassName(this, 'cell')[0];
			if(oCell)
			{
				oCell.style.border = '1px solid #FF9E12';	
			}
		};
		aSelect[i].style.display = 'none';
	}
};

//执行单选
Radio.prototype.setRadio = function()
{
	var arr = [];
	for(var i = 0; i < this.aInput.length; i++)
	{
		//一个name只执行一次
		if(this.aInput[i].getAttribute('radio') == 'myradio' && !findSame(arr, this.aInput[i].name) &&  this.aInput[i].type == 'radio')
		{
			this.radio(this.aInput[i].name);
			arr.push(this.aInput[i].name);
		}
	}
};

//复选框
function CheckBox()
{
	this.aInput = document.getElementsByTagName('input');
	this.index = 0;
	
	//调用方法
	this.checkbox();
}

//复选实现
CheckBox.prototype.checkbox = function()
{
	var This = this;
	var aSpan = [];
	var aInput = [];
	for(var i = 0; i < this.aInput.length; i++)
	{
		if(this.aInput[i].getAttribute('checkbox') == 'mycheckbox')
		{
			var oSpan = document.createElement('span');
			if(this.aInput[i].checked)
			{
				oSpan.className = 'check_on';
			}
			else
			{
				oSpan.className = 'check_off';
			}
			this.aInput[i].parentNode.insertBefore(oSpan, this.aInput[i]);
			aSpan.push(oSpan);
			aInput.push(this.aInput[i]);
			oSpan.index = This.index;
			oSpan.parentNode.index = This.index;
			This.index++;
			oSpan.onclick = function(ev)
			{
				var oEvent = ev || event;
				if(This.aInput[this.index].checked)
				{
					this.className = 'check_off';
					This.aInput[this.index].checked = false;
				}
				else
				{
					this.className = 'check_on';
					This.aInput[this.index].checked = true;
				}
				oEvent.cancelBubble = true;
			}
			oSpan.parentNode.onclick = function()
			{
				if(This.aInput[this.index].checked)
				{
					aSpan[this.index].className = 'check_off';
					This.aInput[this.index].checked = false;
				}
				else
				{
					aSpan[this.index].className = 'check_on';
					This.aInput[this.index].checked = true;
				}
			}
			this.aInput[i].style.display = 'none';
			for(var j = 0; j < aSpan.length; j++)
			{
				aInput[j].index = j;
				aInput[j].onchange = function()
				{
					if(this.checked)
					{
						aSpan[this.index].className = 'check_on';
					}	
					else
					{
						aSpan[this.index].className = 'check_off';	
					}
				}
			}
		}	
	}
}

//倒计时对象
function Countdown(obj)
{	
	this.oText =  obj;	
	this.oTimer = null;
	this.sCountTime = 0;
}

//获取倒计时时间
Countdown.prototype.getCountTime = function()
{
	this.sCountTime = this.oText.getAttribute('count_time');
};	

//开始倒计时
Countdown.prototype.setCountdown = function(fn)
{
	var This = this;
	this.getCountTime();
	var iTotalSec = this.sCountTime;
	this.oTimer = setInterval(function(){
		iTotalSec--;
		var iTime = iTotalSec;
		var iSurDay = toDouble(parseInt(iTime / 86400));
		iTime %= 86400;
		var iSurHour = toDouble(parseInt(iTime / 3600));
		iTime %= 3600;
		var iSurMin = toDouble(parseInt(iTime / 60));
		iTime %= 60;
		var iSurSec = toDouble(iTime);
		
		This.oText.innerHTML = iSurMin + ':' + iSurSec;
		
		if(iTotalSec < 0)
		{
			This.oText.innerHTML = '00:00';
			clearInterval(This.oTimer);
			fn && fn();
		}	
	}, 1000);
}

//倒计时对象
function CountdownHanld(obj)
{	
	//继承父级的属性
	Countdown.apply(this, arguments);
}

//继承方法
CountdownHanld.prototype = new Countdown();
CountdownHanld.prototype.constructor = CountdownHanld;

//重写倒计时
CountdownHanld.prototype.setCountdown = function(fnHanler,fn)
{
	var This = this;
	this.getCountTime();
	var iTotalSec = this.sCountTime;
	this.oTimer = setInterval(function(){
		iTotalSec--;
		var iTime = iTotalSec;
		var iSurDay = toDouble(parseInt(iTime / 86400));
		iTime %= 86400;
		var iSurHour = toDouble(parseInt(iTime / 3600));
		iTime %= 3600;
		var iSurMin = toDouble(parseInt(iTime / 60));
		iTime %= 60;
		var iSurSec = toDouble(iTime);
		
		This.oText.innerHTML = iSurMin + ':' + iSurSec;
		
		if(iTotalSec < 0)
		{
			This.oText.innerHTML = '00:00';
			clearInterval(This.oTimer);
			fn && fn();
		}else{
			fnHanler && fnHanler();
		}	
	}, 1000);
};

//实时金价
function PriceOfGold(id)
{
	this.oPriceOfGold = document.getElementById(id);
	
	this.fPriceOfGold = 0.00;	
	this.oTimer = null;
}

//获取金价
PriceOfGold.prototype.getPriceOfGold = function()
{
	if(this.oPriceOfGold && this.oPriceOfGold.getAttribute('price_of_gold'))
	{
		this.fPriceOfGold = parseFloat(this.oPriceOfGold.getAttribute('price_of_gold'));
	}
}

//定时设置金价
PriceOfGold.prototype.setPriceOfGoldByHeartbeat = function(iTime)
{
	if(!iTime)
	{
		iTime = 30000;
	}
	var This = this;
	this.oTimer = setInterval(function(){
		This.setPriceOfGold();
	}, iTime);
}

//设置金价处理函数
PriceOfGold.prototype.setPriceOfGold = function()
{


}

//新手专享金优惠金价
function PriceOfGoldInPreferential(id)
{
	//继承父级的属性
	PriceOfGold.apply(this, arguments);
}

//继承方法
PriceOfGoldInPreferential.prototype = new PriceOfGold();
PriceOfGoldInPreferential.prototype.constructor = PriceOfGoldInPreferential;

//重写方法
//设置金价处理函数
PriceOfGoldInPreferential.prototype.setPriceOfGold = function()
{
	var This = this;
	var sPriceOfGold = $("#novicePrice").val();
	if(This.oPriceOfGold)
	{
		This.oPriceOfGold.setAttribute('price_of_gold', sPriceOfGold);
		This.fPriceOfGold = sPriceOfGold;
		var sPriceOfGold1 = sPriceOfGold.split('.')[0];
		var sPriceOfGold2 = sPriceOfGold.split('.')[1];
		This.oPriceOfGold.innerHTML = '<em>' + sPriceOfGold1 + '</em>' + '<span>.' + sPriceOfGold2 + '</span>';
		
		//更新计算金价
		//1.新手专享金
		if(typeof oGoldpurchase != 'undefined' && typeof oGoldpurchase.setGramsNumForNoviceGold != 'undefined' && oGoldpurchase.bUpdateGoldForNovice == true)
		{
			oGoldpurchase.calculatePriceOfGoldForNoviceGold();
		}
	}
}


//新手专享金优惠金价
function PriceOfGoldInPreferential(id)
{
	//继承父级的属性
	PriceOfGold.apply(this, arguments);
}

//继承方法
PriceOfGoldInPreferential.prototype = new PriceOfGold();
PriceOfGoldInPreferential.prototype.constructor = PriceOfGoldInPreferential;

//重写方法
//设置金价处理函数
PriceOfGoldInPreferential.prototype.setPriceOfGold = function()
{
	var This = this;
	var sPriceOfGold = $("#novicePrice").val();
	if(This.oPriceOfGold)
	{
		This.oPriceOfGold.setAttribute('price_of_gold', sPriceOfGold);
		This.fPriceOfGold = sPriceOfGold;
		var sPriceOfGold1 = sPriceOfGold.split('.')[0];
		var sPriceOfGold2 = sPriceOfGold.split('.')[1];
		This.oPriceOfGold.innerHTML = '<em>' + sPriceOfGold1 + '</em>' + '<span>.' + sPriceOfGold2 + '</span>';
		
		//更新计算金价
		//1.新手专享金
		if(typeof oGoldpurchase != 'undefined' && typeof oGoldpurchase.setGramsNumForNoviceGold != 'undefined' && oGoldpurchase.bUpdateGoldForNovice == true)
		{
			oGoldpurchase.calculatePriceOfGoldForNoviceGold();
		}
	}
}

//弹窗
function Window(id)
{
	this.oBg = document.getElementById('bg');
	this.oWindow = document.getElementById(id);	
	this.aPop = document.getElementsByClassName('pop');
	this.oCloseBtn = getByClassName(this.oWindow, 'close_btn')[0];
	this.oOkBtn = getByClassName(this.oWindow, 'ok_btn')[0];
	this.oText = getByClassName(this.oWindow, 'text')[0];
	
	this.hideWindowByCloseBtn();
	this.hideWindowByOkBtn();
}

//显示弹窗
Window.prototype.showWindow = function()
{
	$(this.oBg).fadeIn(200);
	$(this.oWindow).fadeIn(200);
};

//隐藏弹窗
Window.prototype.hideWindow = function()
{
	$(this.oBg).fadeOut(200);
	$(this.oWindow).fadeOut(200);
};

//隐藏弹窗(背景不隐藏)
Window.prototype.hidePop = function()
{
	$(this.oWindow).fadeOut(200);
};

//通过关闭按钮隐藏弹窗
Window.prototype.hideWindowByCloseBtn = function(fn)
{
	var This = this;
	if(this.oCloseBtn)
	{
		this.oCloseBtn.onclick = function()
		{
			This.hideWindow();
			fn && fn();
		};
	}
};

//通过关闭按钮隐藏弹窗
Window.prototype.hideWindowByOkBtn = function(fn)
{
	var This = this;
	if(this.oOkBtn)
	{
		this.oOkBtn.onclick = function()
		{
			This.hideWindow();
			fn && fn();
			// 重新加载页面
			$("#status").val(1020);
			$("#couponType").val(30);
			$("#pagingReqForm").submit();
		};
	}
};

//通过关闭按钮隐藏弹窗
Window.prototype.hideWindowByBg = function(fn)
{
	var This = this;
	if(this.oBg)
	{
		this.oBg.onclick = function()
		{
			$(This.oBg).fadeOut(200);
			for(var i = 0; i < This.aPop.length; i++)
			{
				$(This.aPop[i]).fadeOut(200);	
			}
		};
	}
};

//改变文字值
Window.prototype.setText = function(str)
{
	if(this.oText)
	{
		this.oText.innerHTML = str;
	}
};

//下拉菜单
function DownMenu(idMenu, idBtn)
{
	this.oDownMenuCon = document.getElementById(idMenu);
	this.oBtn = document.getElementById(idBtn);
	
	this.oBottomBox = document.getElementById('bottom_box');
	
	this.iHeight = 0;
	this.iScrollHeight = 0;
	this.bClick = true;
	
	//获取默认高度
	this.getHeight();
}

//获取默认高度
DownMenu.prototype.getHeight = function()
{
	this.sHeight = getStyle(this.oDownMenuCon, 'height');
};

//有一定高度的菜单
DownMenu.prototype.slideMenu = function()
{
	var This = this;
	this.iScrollHeight = this.oDownMenuCon.children[0].scrollHeight;
	if(parseFloat(this.sHeight) > this.iScrollHeight)
	{
		this.oBtn.style.display = 'none';
		this.oDownMenuCon.style.height = 'auto';
	}
	this.oBtn.onclick = function()
	{
		if(This.bClick)
		{
			$(This.oDownMenuCon).animate({height: This.iScrollHeight}, 50, function(){
				if(typeof window.webkit != 'undefined')
				{
					window.webkit.messageHandlers.FSWebBridge.postMessage({funcName:"fixContainerHeight", params:getPos(This.oBottomBox).top});
				}
			});
			addClass(this, 'up');
			This.bClick = false;
		}
		else 
		{
			$(This.oDownMenuCon).animate({height: This.sHeight}, 50, function(){
				if(typeof window.webkit != 'undefined')
				{
					window.webkit.messageHandlers.FSWebBridge.postMessage({funcName:"fixContainerHeight", params:getPos(This.oBottomBox).top});
				}
			});
			removeClass(this, 'up');
			This.bClick = true;
		}
	};
};

//直接显示隐藏菜单
DownMenu.prototype.showHideMenu = function()
{
	var This = this;
	this.oBtn.onclick = function()
	{
		var oIco = this.getElementsByClassName('more_item')[0];
		if(getStyle(This.oDownMenuCon, 'display') == 'block')
		{
			$(This.oDownMenuCon).slideUp(function(){
				if(typeof window.webkit != 'undefined')
				{
					window.webkit.messageHandlers.FSWebBridge.postMessage({funcName:"fixContainerHeight", params:getPos(This.oBottomBox).top})
				}	
			});
			removeClass(oIco, 'up');
			This.bClick = false;
		}
		else 
		{
			$(This.oDownMenuCon).slideDown(function(){
				if(typeof window.webkit != 'undefined')
				{
					window.webkit.messageHandlers.FSWebBridge.postMessage({funcName:"fixContainerHeight", params:getPos(This.oBottomBox).top})
				}
			});
			addClass(oIco, 'up');
			This.bClick = true;
		}
	}
}

//明文密码
function ShowPassword(id)
{
	this.oShowPassword = document.getElementById(id);
	this.oEyeBtn = getByClassName(this.oShowPassword.parentNode, 'signInEye')[0];
	this.bTrue = true;
	
	this.showPassword();	
}

//明文密码
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
		if(This.bTrue)
		{
			This.oShowPassword.setAttribute('type','text');
			addClass(this, 'openEyes');
			This.bTrue = !This.bTrue;	
		}
		else
		{
			
			This.oShowPassword.setAttribute('type','password');
			removeClass(this, 'openEyes');
			This.bTrue = !This.bTrue;	
		}	
		This.oShowPassword.value = str;
	};	
};

//设置黄金订单购买方式
function SetGoldBuyInfo(buyMethod){
	//金额去掉千分符
	var buyAmount = String($("#cash").val());
	while(buyAmount.indexOf(',') != -1){
		buyAmount = buyAmount.replace(',', '');
	}
	if(buyAmount==""){
		buyAmount=0;
	}
	$("#buyAmount").val(buyAmount);
	
	//克重去掉千分符
	var fGrams = String($("#grams").val());
	while(fGrams.indexOf(',') != -1){
		fGrams = fGrams.replace(',', '');
	}
	if(fGrams==""){
		fGrams=0;
	}
	$("#buyGram").val(fGrams);
	$("#buyMethod").val(buyMethod);
}

//黄金购买
function Goldpurchase()
{
	this.oCash = document.getElementById('cash');
	this.oGramCon = document.getElementById('gram_con');
	
	this.oAdd = document.getElementById('add');
	this.oSubtract = document.getElementById('subtract');
	this.oGrams = document.getElementById('grams');
	this.oCashCon = document.getElementById('cash_con');
	
	this.oPriceOfGold = document.getElementById('price_of_gold');
	
	//黄金看涨跌
	this.oExpectedReturn = document.getElementById('expected_return')
	this.oMinRate = document.getElementById('min_rate');
	this.oMaxRate = document.getElementById('max_rate');
	this.oTerm = document.getElementById('term');
	
	this.oBalance = document.getElementById('balance');
	this.oBananceBtn = document.getElementById('balance_btn');
	this.oBananceBtn2 = document.getElementById('balance_btn2');
	
	this.reCash1 = /^(\d|([1-9]\d+))(\.\d{0,2})?$/;	
	this.reCash2 = /(\d|([1-9]\d+))(\.\d{0,2})?/g;
	this.reGrams1 = /^[0-9]{1,13}(\.[0-9]{0,3})?$/;	
	this.reGrams2 = /[0-9]{1,13}(\.[0-9]{0,3})?/g;
	this.reGrams3 = /^1$/;
	this.reGrams4 = /1/g;
	this.fPriceOfGold = 0.00;	
	
	this.iGrams = 0;
	
	//用于30秒更新金价后更新需要的价格和能买入的克数
	this.bUpdateGoldForInsured = false;   //保价金，定期金共用
	this.bUpdateGoldForNovice = false;   //新手专享金
}

//获取金价
Goldpurchase.prototype.getPriceOfGold = function()
{
	if(this.oPriceOfGold && this.oPriceOfGold.getAttribute('price_of_gold'))
	{
		this.fPriceOfGold = parseFloat(this.oPriceOfGold.getAttribute('price_of_gold'));
	}
}

//新手专享金输入克数计算价格
Goldpurchase.prototype.setGramsNumForNoviceGold = function()
{
	//用于30秒更新金价后，买金输入处相应做出变化
	this.bUpdateGoldForNovice = true;
	var This = this;
	this.oGrams.onkeyup = function()
	{
		var sInputValue = this.value;
		//去掉千分符
		while(sInputValue.indexOf(',') != -1)
		{
			sInputValue = sInputValue.replace(',', '');
		}
		if(!This.reGrams3.test(sInputValue))
		{
			if(!sInputValue.match(This.reGrams4))
			{
				this.value = 1;
				This.iGrams = 1;
			}
			else
			{
				var iGrams = sInputValue.match(This.reGrams4)[0];
				this.value = toThousands(iGrams);;
				This.iGrams = iGrams;
			}
		}
		else
		{
			This.iGrams = sInputValue;
			this.value = toThousands(This.iGrams);
		}
		
		//计算价格
		This.calculatePriceOfGoldForNoviceGold();
	}	
};

//根据克数控制价格(新手专享金）
Goldpurchase.prototype.calculatePriceOfGoldForNoviceGold = function()
{
	this.getPriceOfGold();
	var fGrams;
	if(this.oGrams.value == '')
	{
		fGrams = 0;
	}
	else
	{
		fGrams = this.iGrams;
	}
	var fPrice = fGrams * this.fPriceOfGold;
	this.oCashCon.innerHTML = toThousands(fPrice.toFixed(2));  //（保留2位小数，超出位数往2位小数进1） 现在只是保留两位，没有四舍五入，到时修改
}

//稳盈金输入价格计算克数
Goldpurchase.prototype.setPriceNum = function()
{
	//用于30秒更新金价后，买金输入处相应做出变化
	this.bUpdateGoldForInsured = true;
	var This = this;
	this.oCash.onkeyup = function()
	{
		var sInputValue = this.value;
		//去掉千分符
		while(sInputValue.indexOf(',') != -1)
		{
			sInputValue = sInputValue.replace(',', '');
		}
		if(!This.reCash1.test(sInputValue))
		{
			if(!sInputValue.match(This.reCash2))
			{
				this.value = '';
				This.iCash = 0;
			}
			else
			{
				if(sInputValue.lastIndexOf('.') != -1)
				{
					var iCash = sInputValue.substring(0, sInputValue.indexOf('.') + 3);
				}
				else
				{
					var iCash = sInputValue.match(This.reCash2).join('');
				}
				this.value = toThousands(iCash);
				This.iCash = iCash;
			}
		}
		else
		{
			This.iCash = sInputValue;
			this.value = toThousands(This.iCash);
		}
		
		//计算克重
		This.calculateGramsOfGold();
	}	
}

//稳盈金余额全投
Goldpurchase.prototype.setPriceNumForBalance = function()
{
	//用于30秒更新金价后，买金输入处相应做出变化
	this.bUpdateGoldForInsured = true;
	var This = this;
	this.oBananceBtn.onclick = function()
	{
		var sInputValue = This.oBalance.value;
		//去掉千分符
		while(sInputValue.indexOf(',') != -1)
		{
			sInputValue = sInputValue.replace(',', '');
		}
		if(!This.reCash1.test(sInputValue))
		{
			if(!sInputValue.match(This.reCash2))
			{
				this.value = '';
				This.iCash = 0;
			}
			else
			{
				if(sInputValue.lastIndexOf('.') != -1)
				{
					var iCash = sInputValue.substring(0, sInputValue.indexOf('.') + 3);
				}
				else
				{
					var iCash = sInputValue.match(This.reCash2).join('');
				}
				this.value = toThousands(iCash);
				This.iCash = iCash;
			}
		}
		else
		{
			This.iCash = sInputValue;
			This.oCash.value = toThousands(This.iCash);
		}
		
		//计算克重
		This.calculateGramsOfGold();
	}	
}

//根据价格控制黄金
Goldpurchase.prototype.calculateGramsOfGold = function()
{
	this.getPriceOfGold();
	var fCash;
	if(this.oCash.value == '')
	{
		fCash = 0;
	}
	else
	{
		fCash = this.iCash;
	}
	var fGrams = fCash / this.fPriceOfGold;
	var fGrams_fixed4 = fGrams.toFixed(4);
	var fGramsNum = fGrams_fixed4.substring(0, fGrams_fixed4.indexOf('.') + 4);
	this.oGramCon.innerHTML = toThousands(fGramsNum);
}

//稳盈金输入克数计算价格
Goldpurchase.prototype.setGramsNum = function()
{
	//用于30秒更新金价后，买金输入处相应做出变化
	this.bUpdateGoldForInsured = true;
	var This = this;
	this.oGrams.onkeyup = function()
	{
		var sInputValue = this.value;
		//去掉千分符
		while(sInputValue.indexOf(',') != -1)
		{
			sInputValue = sInputValue.replace(',', '');
		}
		if(!This.reGrams1.test(sInputValue))
		{
			if(!sInputValue.match(This.reGrams2))
			{
				this.value = '';
				This.iGrams = 0;
			}
			else
			{
				if(sInputValue.lastIndexOf('.') != -1)
				{
					var iGrams = sInputValue.substring(0, sInputValue.indexOf('.') + 3);
				}
				else
				{
					var iGrams = sInputValue.match(This.reGrams2).join('');
				}
				this.value = toThousands(iGrams);
				This.iGrams = iGrams;
			}
		}
		else
		{
			This.iGrams = sInputValue;
			this.value = toThousands(This.iGrams);
		}
		
		//计算价格
		This.calculatePriceOfGold();
	}	
}


//稳盈金输入克数计算价格  余额全投
Goldpurchase.prototype.setGramsNumForBalance = function()
{
	//用于30秒更新金价后，买金输入处相应做出变化
	this.bUpdateGoldForInsured = true;
	var This = this;
	this.oBananceBtn2.onclick = function()
	{
		var sGramsValue = This.oBalance.value;
		var fPriceOfGold = oPriceOfGold.fPriceOfGold;;
		var sGrams = (sGramsValue / fPriceOfGold).toString();
		var iGrams = sGrams.substring(0, sGrams.indexOf('.') + 4);
		
		This.iGrams = iGrams;
		This.oGrams.value = toThousands(This.iGrams);
		
		//计算价格
		This.calculatePriceOfGold();
	}	
}

//根据克数控制价格
Goldpurchase.prototype.calculatePriceOfGold = function()
{
	this.getPriceOfGold();
	var fGrams;
	if(this.oGrams.value == '')
	{
		fGrams = 0;
	}
	else
	{
		fGrams = this.iGrams;
	}
	var fPrice = fGrams * this.fPriceOfGold;
	var sPrice = fPrice + '';

	//（保留2位小数，超出位数往2位小数进1）
	if(sPrice.indexOf('.') != -1)
	{
		if(typeof(sPrice.split('.')[1][2]) != 'undefined')
		{
			var fPriceNum = Number(sPrice.substring(0, sPrice.indexOf('.') + 3)) + 0.01;
			this.oCashCon.innerHTML = toThousands(fPriceNum.toFixed(2));
		}
		else
		{
			this.oCashCon.innerHTML = toThousands(fPrice.toFixed(2));
		}
	}
	else
	{
		this.oCashCon.innerHTML = toThousands(fPrice.toFixed(2));
	}
}

//打开app
function OpenApp(id)
{
	this.oBtn = document.getElementById(id);
	
	this.openApp();
}

//打开app
OpenApp.prototype.openApp = function()
{
	this.oBtn.onclick = function()
	{
		var oIfr = document.createElement('iframe');  
		oIfr.src = 'comhsdfinance://openMJB';  
		oIfr.style.display = 'none';  
		document.body.appendChild(oIfr);  
		setTimeout(function(){  
			document.body.removeChild(oIfr);  
		},3000)  
	}
}

//解析url
function ParseUrl()
{
	this.oInvitationCodeBox = document.getElementById('invitationCode_box');
	this.sUrl = window.location.href;
	//id
	this.sRecomCode = '';
	//渠道
	this.sChannelName = '';	
}

//解析url
ParseUrl.prototype.parseUrl = function()
{
	if(this.sUrl.indexOf('?') != -1)
	{
		var sData = this.sUrl.split('?')[1];
		
		if(sData.indexOf('&') != -1)
		{
			if(sData.split('&')[0].indexOf('=') != -1 && sData.split('&')[1].indexOf('=') != -1)
			{
				this.hideInvitationCodeBox();
				
				this.parseUrlHandle();

				//发送信息
				this.sendInformation();
			}
		}
		else
		{
			if(sData.indexOf('=') != -1)
			{
				this.hideInvitationCodeBox();
				
				this.parseUrlHandle();
				
				//发送信息
				this.sendInformation();
			}
		}
	}
	else
	{
		this.showInvitationCodeBox();
	}
}

//解析url详情
ParseUrl.prototype.parseUrlHandle = function()
{
	var arr = this.sUrl.split('?')[1].split('&');
				
	for(var i = 0; i < arr.length; i++)
	{
		var arr2 = arr[i].split('=');
		if(arr2[0] == 'recomCode')
		{
			//id
			this.sRecomCode = arr2[1];
			//设置cookie
			setCookie('recomCode', this.sRecomCode, 1);
				
		}
		else if(arr2[0] == 'sp')
		{
			//渠道
			this.sChannelName = arr2[1];
			//设置cookie
			setCookie('sp', this.sChannelName, 1);	
		}
	}
}

//发送信息
ParseUrl.prototype.sendInformation = function()
{
	var This = this;
	$.ajax({
		url: urlPerfix + '/jsonp/setRecommendParam.do',
		data: {
			recomCode: This.sRecomCode,
			sp: This.sChannelName
		},
		dataType: 'jsonp',
		jsonp: 'callback',
		success: function(data){

		},
		error: function(){
			
		}	
	});	
}

//显示推荐人input
ParseUrl.prototype.showInvitationCodeBox = function()
{
	if(this.oInvitationCodeBox)
	{
		this.oInvitationCodeBox.style.display = 'block';	
	}
}

//隐藏推荐人input
ParseUrl.prototype.hideInvitationCodeBox = function()
{
	if(this.oInvitationCodeBox)
	{
		this.oInvitationCodeBox.style.display = 'none';	
	}
}

//显示隐藏推荐人input
ParseUrl.prototype.switchInvitationCodeBox = function()
{
	if(!getCookie('recomCode') && this.sChannelName.indexOf('zhanye') == -1)
	{
		this.showInvitationCodeBox();
	}
	else
	{
		this.hideInvitationCodeBox();
	}	
}

//密码强度
function PasswordStrength(id)
{
	this.oPassword = document.getElementById(id);
	this.oPasswordStrength = document.getElementById('password_strength');
	this.aBox = this.oPasswordStrength.getElementsByTagName('span');
	
	//方法调用
	this.testStrength();
}

//显示强度检测框
PasswordStrength.prototype.showStrengthBox = function()
{
	$(this.oPasswordStrength).fadeIn(200);
}

//隐藏强度检测框
PasswordStrength.prototype.hideStrengthBox = function()
{
	$(this.oPasswordStrength).fadeOut(200);
}

//强度控制
PasswordStrength.prototype.switchBox = function(index)
{
	for(var i = 0; i < this.aBox.length; i++)
	{
		removeClass(this.aBox[i], 'active');	
	}
	addClass(this.aBox[index], 'active');
}

PasswordStrength.prototype.testStrength = function()
{
	var This = this;
	if(this.oPassword)
	{
		this.oPassword.onkeyup = function()
		{
			var sPassword = this.value;
			var reSpecialCharacters = /~|`|@|#|\$|%|\^|&|\*|\-|_|=|\+|\||\\|\?|\/|\(|\)|<|>|\[|\]|{|}|"|,|\.|;|'|\!/;  //特殊字符
			var reNum = /\d/;  //数字
			var reLetter = /[a-zA-Z]/;   //字母
			var reUpperLetter = /[A-Z]/;   //大写字母   
			var reLowerLetter = /[a-z]/;   //小写字母
			
			//1、纯字母：安全性低
			//2、字母+数字，字母+特殊字符：安全性中
			//3、含大小写字母+数字，字母+数字+特殊字符：安全性高
			//4、纯数字，数字+特殊字符：不允许设置
			
			//位数判断，小于6位隐藏，否则显示
			if(sPassword.length < 8)
			{
				This.hideStrengthBox();
			}
			else
			{
				This.showStrengthBox();
			}
			
			if(!reLetter.test(sPassword) || (reLetter.test(sPassword) && !reSpecialCharacters.test(sPassword) && !reNum.test(sPassword)))
			{
				This.switchBox(0);	
			}
			else if((reLowerLetter.test(sPassword) && !reUpperLetter.test(sPassword) && reNum.test(sPassword) && !reSpecialCharacters.test(sPassword)) || (reUpperLetter.test(sPassword) && !reLowerLetter.test(sPassword) && reNum.test(sPassword) && !reSpecialCharacters.test(sPassword)) || (reLetter.test(sPassword) && reSpecialCharacters.test(sPassword) && !reNum.test(sPassword)))
			{
				This.switchBox(1);	
			}
			else if((reUpperLetter.test(sPassword) && reLowerLetter.test(sPassword) && reNum.test(sPassword)) || (reLetter.test(sPassword) && reNum.test(sPassword) && reSpecialCharacters.test(sPassword)))
			{
				This.switchBox(2);
			}
		}
	}
}

//推荐人
function Recommender()
{
	this.oInvitationBtn = document.getElementById('invitation_btn');
	if(this.oInvitationBtn)
	{
		this.oIco = this.oInvitationBtn.getElementsByTagName('i')[0];
	}
	this.oInvitationCon = document.getElementById('invitation_con');
	
	this.switchRecommender();
}

//显示隐藏推荐人
Recommender.prototype.switchRecommender = function()
{
	var This = this;
	if(this.oInvitationBtn)
	{
		this.oInvitationBtn.onclick = function()
		{
			if(getStyle(This.oInvitationCon, 'display') == 'block')
			{
				$(This.oInvitationCon).slideUp();
				removeClass(This.oIco, 'up');
			}
			else
			{
				$(This.oInvitationCon).slideDown();
				addClass(This.oIco, 'up');
			} 
		}
	}
}


//刷新验证码
function refreshCode (type)
{
	var oTtimeNow = new Date();
	$('.checkCode').attr('src', urlPerfix + '/kaptcha/createImage?d=' + oTtimeNow + '&code_id=' + type);
}


//黄金红包兑换
function ExchangeForGoldPackage(id)
{
	this.oPackageDetail = document.getElementById(id);
	this.oExchangeBtn = document.getElementById('gold_exchange');
	this.aExchangeBtn = getByClassName(this.oPackageDetail, 'exchange');
	this.oLoadingImages = document.getElementById('loading_images');
	this.oSuccess_grams = document.getElementById('success_grams');
	this.oMessage = document.getElementById('message');
	this.oGoldMessage = document.getElementById('goldMessage');
	
	this.oOneKeyExchange = document.getElementById('one_key_exchange');	
	
	this.oGetgoldtc = new Window('getgoldtc');         //兑换成功
	this.oLosegoldtc = new Window('losegoldtc');       //兑换失败
	this.oInExchange = new Window('in_exchange');      //兑换中
	this.oExchangeSuccess = new Window('exchange_success');  //一键兑换成功
	this.oNoExchange = new Window('no_exchange');      //不能兑换
	
	this.bExchanged = true;
	this.sCouponId = '';
	this.sFaceValue = '';
	this.iExchangeState = 0;
}

//弹窗里的兑换
ExchangeForGoldPackage.prototype.exchangeForPop = function()
{
	var This = this;
	if(this.oExchangeBtn)
	{
		this.oExchangeBtn.onclick = function()
		{
			var oD_couponId = getByClassName(this.parentNode, 'd_couponId')[0];
			var oD_faceValue = getByClassName(this.parentNode, 'd_faceValue')[0];
			This.sCouponId = oD_couponId.value;
			This.sFaceValue = oD_faceValue.value;
			This.exchangeHandle();
		}
	}
}

//兑换
ExchangeForGoldPackage.prototype.exchange = function()
{
	var This = this;
	for(var i = 0; i < this.aExchangeBtn.length; i++)
	{
		this.aExchangeBtn[i].onclick = function()
		{
			var oD_couponId = getByClassName(this.parentNode, 'd_couponId')[0];
			var oD_faceValue = getByClassName(this.parentNode, 'd_faceValue')[0];
			This.sCouponId = oD_couponId.value;
			This.sFaceValue = oD_faceValue.value;
			This.exchangeHandle();	
		}	
	}
}

//兑换详情
ExchangeForGoldPackage.prototype.exchangeHandle = function()
{
	var This = this;
	
	//算当前毫秒数
	var iTimeFirst = new Date().getTime();
	this.oLoadingImages.style.marginTop = 0;
	this.oLoadingImages.src = urlPerfix +'/static/images/package/in_exchange1.gif';
	this.oInExchange.showWindow();
	setTimeout(function(){
		This.oLoadingImages.style.marginTop = '.3rem';
		This.oLoadingImages.src = urlPerfix +'/static/images/package/in_exchange2.gif';
	}, 880);
	
	$.ajax({
		url: urlPerfix +'/coupon/useGoldCoupon.do',
		data:{
			couponId: This.sCouponId	
		},
		type: 'post',
		success: function(data){
			//算当前毫秒数
			var iTimeEnd = new Date().getTime();
			if((iTimeEnd - iTimeFirst) < 2000)  //低于2秒，停留到2秒再出结果
			{
				setTimeout(function(){
					if(data.resultCode == 200){
						This.bExchanged = true;  //======== 领到成功
					}
					else{
						This.bExchanged = false;  //======== 领到失败
					}
					//领取结果
					This.exchangeResult(data);
					
				}, (2000 - (iTimeEnd - iTimeFirst)));
			}
			else
			{
				if(data.resultCode == 200){
					This.bExchanged = true;  //======== 领到成功
				}
				else{
					This.bExchanged = false;  //======== 领到失败
				}
				
				//领取结果
				This.exchangeResult(data);
			}
		},
		error:function(){
			
		}	
	});
}

//兑换结果（成功或失败）
ExchangeForGoldPackage.prototype.exchangeResult = function(data)
{
	this.oInExchange.hidePop();
	var message = data.resultMsg;
	
	if(this.bExchanged)  //领取成功
	{
		this.oSuccess_grams.innerHTML = this.sFaceValue;
		this.oMessage.innerHTML = message;
		this.oGetgoldtc.showWindow();
	}
	else
	{
		this.oLosegoldtc.showWindow();	
	}
}

//一键兑换
ExchangeForGoldPackage.prototype.oneKeyExchange = function()
{
	var This = this;
	this.oOneKeyExchange.onclick = function()
	{
		$.ajax({
			url: urlPerfix + '/coupon/queryUseableCouponNum.do',
			data:{
				couponId: ''	
			},
			type: 'post',
			success: function(data){
				if(data.content==0)
				{
					oNoExchange.showWindow();
				}
				else
				{
					This.oneKeyExchangeHandle();
				}
			},
			error:function(){
				
			}	
		});
	}
}

//一键兑换详情
ExchangeForGoldPackage.prototype.oneKeyExchangeHandle = function()
{
	var This = this;
	
	//算当前毫秒数
	var iTimeFirst = new Date().getTime();
	this.oLoadingImages.style.marginTop = 0;
	this.oLoadingImages.src = urlPerfix + '/static/images/package/in_exchange1.gif';
	this.oInExchange.showWindow();
	setTimeout(function(){
		This.oLoadingImages.style.marginTop = '.3rem';
		This.oLoadingImages.src = urlPerfix + '/static/images/package/in_exchange2.gif';
	}, 880);
	
	$.ajax({
		url: urlPerfix + '/coupon/useAllGoldCoupon.do',
		data:{
			couponId: ''	
		},
		type: 'post',
		success: function(data){
			//算当前毫秒数
			var iTimeEnd = new Date().getTime();
			if((iTimeEnd - iTimeFirst) < 2000)  //低于2秒，停留到2秒再出结果
			{
				setTimeout(function(){
					//领取结果
					This.oneKeyExchangeResult(data);
					
				}, (2000 - (iTimeEnd - iTimeFirst)));
			}
			else
			{
				//领取结果
				This.oneKeyExchangeResult(data);
			}
		},
		error:function(){
			
		}	
	});
}

//一键兑换结果（成功或失败）
ExchangeForGoldPackage.prototype.oneKeyExchangeResult = function(data)
{
	this.oInExchange.hidePop();
	if(data.resultCode == 200)
	{
		var str = '本次共兑换' + data.content.length +'个黄金红包，所有红包兑换完毕';	
		var totalGram = data.content.totalGram;
		var message = data.content.message;
		$("#useGoldTip").text(str);
		$("#success_goldGram").text(totalGram);
		this.oGoldMessage.innerHTML = message;
		this.oExchangeSuccess.showWindow();	
	}
	else{
		this.oLosegoldtc.showWindow();
	}
}
	

//选择红包
function SelectPackage()
{
	this.oUse_package_btn = document.getElementById('use_package_btn');
	this.oUse_package_con = document.getElementById('use_package_con');
	this.oPackage_box = getByClassName(this.oUse_package_btn, 'package_box')[0];
	this.oPackage_list_con = getByClassName(this.oUse_package_con, 'package_list_con')[0];
	this.oPackage_list = getByClassName(this.oUse_package_con, 'package_list')[0];
	this.aPackage_list = this.oPackage_list.children;
	
	this.oNoChose = document.getElementById('no_chose');
	
	this.oMyPackage = new Window('use_package_con'); //我的红包
}

//初始化
SelectPackage.prototype.init = function()
{
	if(this.aPackage_list.length == 0)
	{
		addClass(this.oPackage_box, 'off');
		this.oPackage_box.innerHTML = '暂无红包可用<i></i>';
	}
	else
	{
//		var oPackageName = getByClassName(this.aPackage_list[0], 'package_name')[0];
//		var oFaceValue = getByClassName(this.aPackage_list[0], 'face_value')[0];
//		this.oPackage_box.innerHTML = oFaceValue.children[0].innerHTML + oFaceValue.children[1].innerHTML + oPackageName.value;
	}
}

//选择红包
SelectPackage.prototype.selectPackage = function()
{
	var This = this;
	this.oUse_package_btn.onclick = function()
	{
		if(!hasClass(this, 'off'))
		{
			if(getStyle(This.oUse_package_con, 'display') == 'block')
			{
				This.oMyPackage.hideWindow();
			}
			else
			{
				This.oMyPackage.showWindow();
			}
		}
	}
}

//选择红包详情
SelectPackage.prototype.selectHandle = function(fn)
{
	var This = this;
	if(this.aPackage_list.length != 0)
	{
		for(var i = 0; i < this.aPackage_list.length; i++)
		{
			this.aPackage_list[i].index = i;
			this.aPackage_list[i].onclick = function()
			{
				if(!hasClass(this, 'lock_item'))
				{
					for(var i = 0; i < This.aPackage_list.length; i++)
					{
						removeClass(This.aPackage_list[i], 'active');
					}
					removeClass(This.oNoChose, 'active');
					addClass(this, 'active');
					var oPackageName = getByClassName(This.aPackage_list[this.index], 'package_name')[0];
					var oFaceValue = getByClassName(This.aPackage_list[this.index], 'face_value')[0];
					This.oPackage_box.innerHTML = oPackageName.value + oFaceValue.children[0].innerHTML + oFaceValue.children[1].innerHTML +'<i></i>';
					var oBox = getByClassName(this, 'package_id')[0];
					var oType = getByClassName(this, 'couponType')[0];
					$("#couponType").val(oType.value);
					$("#faceValue").val(oFaceValue.children[0].innerHTML)
					fn && fn(oBox.value);
					setTimeout(function(){
						This.oMyPackage.hideWindow();
					}, 100);
				}
			}	
		}	
	}
	
	this.oNoChose.onclick = function()
	{
		This.oPackage_box.innerHTML = this.children[0].innerHTML + '<i></i>';
		for(var i = 0; i < This.aPackage_list.length; i++)
		{
			removeClass(This.aPackage_list[i], 'active');
		}
		addClass(this, 'active');
		setTimeout(function(){
			This.oMyPackage.hideWindow();
		}, 100);
	}
}