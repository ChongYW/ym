var urlPerfix = $("#urlPerfix").val();
//可用红包
function AvailablePackage()
{
	this.oAvailBtn = document.getElementById('avail_btn');
	this.oAvailablePackage = new Window('available_package'); //可用红包	
	
	this.showAvailablePackage();
}

//显示可用红包
AvailablePackage.prototype.showAvailablePackage = function()
{
	var This = this;
	if(this.oAvailBtn)
	{
		this.oAvailBtn.onclick = function()
		{
			This.oAvailablePackage.showWindow();
			This.oAvailablePackage.hideWindowByBg();
		}
	}
}

//选项卡
var oTab = new Tab('tab');
oTab.switchTab('onclick');

//下拉
var oDownMenu1 = new DownMenu('detail_con', 'moreBtn1');
oDownMenu1.slideMenu()

var oDownMenu2 = new DownMenu('question1', 'btn1');
oDownMenu2.showHideMenu();

//弹窗
var oAddBankCard = new Window('add_bank_card'); //未绑卡
var oRealName = new Window('real_name'); //未实名

//可用红包
var oAvailablePackage = new AvailablePackage();

//红包滚动条
$(".package_con").mCustomScrollbar();

$(".novice_btn").click(function(){
	var params = {};
	req.invoke("buyCheck", params, function(data) {
		resultCode = data.resultCode;
		if (data.resultCode == 200) {
	        //订单确认页面
			var productId = $("#productId").val();
			location.href = urlPerfix + "/gold/buyInsured.html?id="+productId;
		} else if(data.resultCode ==102){
			//未登陆
			location.href = urlPerfix + "/login.html";
		}
		else if(data.resultCode == 103) {
			oRealName.showWindow();
		}
		else if(data.resultCode == 104) {
			oAddBankCard.showWindow();
		}
	});
});

$(".check_more").click(function(){
	$("#queryMore").submit();
});

/*//30秒更新一下金价
var oPriceOfGold = new PriceOfGold('price_of_gold');
//获取金价
oPriceOfGold.getPriceOfGold();
//第一次获取
oPriceOfGold.setPriceOfGold();
//定时获取(30秒)
oPriceOfGold.setPriceOfGoldByHeartbeat();*/
