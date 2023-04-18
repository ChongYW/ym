//头部菜单
function Menu()
{
	this.oBtn1 = document.getElementById('list_btn1');
	this.oBtn2 = document.getElementById('list_btn2');
	this.oMenu = document.getElementById('menu');
	this.oBg = document.getElementById('bg2');
	
	this.switchMenu();
}

//显示隐藏菜单
Menu.prototype.switchMenu = function()
{
	var This = this;
	if(this.oBtn1 && this.oBtn2 && this.oBg)
	{
		this.oBtn1.onclick = this.oBtn2.onclick = this.oBg.onclick = function()
		{
			if(getStyle(This.oMenu, 'right') == '0px')
			{
				This.hideMenu();
			}
			else
			{
				This.showMenu();
			}
		}
	}
}

//显示菜单
Menu.prototype.showMenu = function()
{
	var This = this;
	$(this.oBg).fadeIn(50)
	$(This.oMenu).animate({right:0});	
}

//隐藏菜单
Menu.prototype.hideMenu = function()
{
	var This = this;
	$(this.oMenu).animate({right:'-1.5rem'});	
	$(This.oBg).fadeOut(50);
}

//头部菜单
var oMenu = new Menu();

if(typeof PriceOfGold != 'undefined')
{
    //30秒更新一下金价(头部导航)
	var oPriceOfGoldTop = new PriceOfGold('price_of_gold_top');
	//第一次更新
	oPriceOfGoldTop.setPriceOfGold();
	//30秒后更新
	oPriceOfGoldTop.setPriceOfGoldByHeartbeat();
}

// 下载APP浮层
$(".down_app").click(function(){
	if (navigator.userAgent.match(/(iPhone|iPod);?/i)) {
		setTimeout(function(){
			window.location.href = "http://#simple.jsp?pkgname=";	
		}, 300);
		window.location.href = "comhsdfinance://openMJB";
	}else if(navigator.userAgent.match(/android/i)){
		 setTimeout(function(){
			window.location.href = "http://#simple.jsp?pkgname=";	
		}, 300);
		 window.location.href = "comhsdfinance://openMJB";
	}else{
		  window.location.href = "http://#simple.jsp?pkgname=";
	}
});

// 下载APP层关闭
$('.app_con .close_btn').click(function(){
	$('.app_con').hide();		
});

$('.new_share .close').click(function(){
	$('.new_share').hide();	
});

// 打开APP
var oOpen = document.getElementById('down_app2');
if(oOpen != null){
	var oOpenApp = new OpenApp('down_app2')
}
