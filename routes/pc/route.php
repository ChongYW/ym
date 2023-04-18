<?php




Route::any('/', ['as'=>'index','uses'=>'IndexController@index']);//首页
Route::any('/index.html', ['as'=>'pc.index','uses'=>'IndexController@index']);//首页
Route::any('/appdown.html', ['as'=>'pc.appdown','uses'=>'IndexController@appdown']);//APP下载页面
Route::any('/Public/QrCode.html', ['as'=>'Public.QrCode','uses'=>'PublicController@APPQrCode']);//APP下载二维码
Route::any('/user/QrCode.html', ['as'=>'user.QrCode','uses'=>'PublicController@QrCode']);//我的推广二维码
Route::any('/Seal/{id}', ['as'=>'Seal','uses'=>'IndexController@Seal']);//公章
Route::any('/CompanySeal', ['as'=>'CompanySeal','uses'=>'IndexController@Seal']);//公章






Route::any('/products.html', ['as'=>'products','uses'=>'IndexController@products']);//商品首页
Route::any('/products/{links}.html', ['as'=>'products.links','uses'=>'IndexController@products']);//商品列表
Route::any('/product/{id}.html', ['as'=>'product','uses'=>'IndexController@product']);//商品详情



Route::any('/celebritys.html', ['as'=>'celebritys','uses'=>'IndexController@celebritys']);//名人列表
Route::any('/celebritys/{links}.html', ['as'=>'celebritys.links','uses'=>'IndexController@celebritys']);//名人列表
Route::any('/celebrity/{id}.html', ['as'=>'celebrity','uses'=>'IndexController@celebrity']);//名人详情

Route::any('/articles.html', ['as'=>'articles','uses'=>'IndexController@articles']);//新闻列表
Route::any('/articles/{links}.html', ['as'=>'articles.links','uses'=>'IndexController@articles']);//新闻列表
Route::any('/article/{id}.html', ['as'=>'article','uses'=>'IndexController@article']);//新闻详情


Route::any('/singlepages.html', ['as'=>'singlepages','uses'=>'IndexController@singlepages']);//新闻列表
Route::any('/xxx.html', ['as'=>'xxx','uses'=>'IndexController@xxx']);//新闻列表
Route::any('/singlepage/{links}.html', ['as'=>'singlepage.links','uses'=>'IndexController@singlepage']);//新闻列表
Route::any('/singlepages/{links}.html', ['as'=>'singlepages.links','uses'=>'IndexController@singlepage']);//新闻列表
Route::any('/singlepage/{id}.html', ['as'=>'singlepage','uses'=>'IndexController@singlepage']);//新闻详情
Route::any('/SendMsg.html', ['as'=>'SendMsg','uses'=>'IndexController@SendMsg']);//提交留言
Route::any('/ykgetmsg', ['as'=>'layim.ykgetmsg','uses'=>'PublicController@ykgetmsg']);//提交留言


/*****公共函数******/


Route::any('/login.html', ['as'=>'pc.login','uses'=>'PublicController@login']);//登录页面
Route::any('/loginout.html', ['as'=>'pc.loginout','uses'=>'PublicController@loginout']);//登出页面

Route::any('/register/{user}.html', ['as'=>'wap.register.user','uses'=>'PublicController@register']);//注册页面

Route::any('/register.html', ['as'=>'pc.register','uses'=>'PublicController@register']);//注册页面
Route::any('/forgot.html', ['as'=>'pc.forgot','uses'=>'PublicController@forgot']);//重置密码
Route::any('/zcxy.html', ['as'=>'pc.zcxy','uses'=>'PublicController@zcxy']);//注册协议
Route::any('/sendsms', ['as'=>'pc.sendsms','uses'=>'PublicController@sendsms']);//发送短信验证码
Route::any('/checkusername', ['as'=>'pc.checkusername','uses'=>'PublicController@checkusername']);//验证帐号是否可用
Route::get('/notice', ['as'=>'pc.notice.index','uses'=>'PublicController@notice']);/**notice**/
Route::get('/buylist/{id}', ['as'=>'pc.buylist','uses'=>'IndexController@buylist']);/**buylist**/
Route::get('/calculation', ['as'=>'calculation','uses'=>'IndexController@calculation']);/**calculation**/


/***路由兼容***/

Route::any('/pcindex.html', ['as'=>'wap.index','uses'=>'IndexController@index']);//首页
Route::any('/pcappdown.html', ['as'=>'wap.appdown','uses'=>'IndexController@appdown']);//APP下载页面
Route::any('/pclogin.html', ['as'=>'wap.login','uses'=>'PublicController@login']);//登录页面
Route::any('/pcloginout.html', ['as'=>'wap.loginout','uses'=>'PublicController@loginout']);//登出页面
Route::any('/pcregister.html', ['as'=>'wap.register','uses'=>'PublicController@register']);//注册页面
Route::any('/pcforgot.html', ['as'=>'wap.forgot','uses'=>'PublicController@forgot']);//重置密码
Route::any('/pczcxy.html', ['as'=>'wap.zcxy','uses'=>'PublicController@zcxy']);//注册协议
Route::any('/pcsendsms', ['as'=>'wap.sendsms','uses'=>'PublicController@sendsms']);//发送短信验证码
Route::any('/pccheckusername', ['as'=>'wapcheckusername','uses'=>'PublicController@checkusername']);//验证帐号是否可用
Route::get('/pcnotice', ['as'=>'wap.notice.index','uses'=>'PublicController@notice']);/**notice**/
Route::get('/pcbuylist/{id}', ['as'=>'wap.buylist','uses'=>'IndexController@buylist']);/**buylist**/


/****会员基本信息****/

Route::any('/user/msg.html', ['as'=>'user.msg','uses'=>'UserController@msg']);//用户消息数
Route::any('/user/msglist.html', ['as'=>'user.msglist','uses'=>'UserController@msglist']);//用户消息列表
Route::any('/user/MsgRead', ['as'=>'user.msgread','uses'=>'UserController@MsgRead']);//消息标记状态
Route::any('/user/MsgDel', ['as'=>'user.msgdel','uses'=>'UserController@MsgDel']);//用户消息删除
Route::any('/user/qiandao', ['as'=>'user.qiandao','uses'=>'UserController@qiandao']);//用户签到功能


Route::any('/user/index.html', ['as'=>'user.index','uses'=>'UserController@index']);//用户中心
Route::any('/user/my.html', ['as'=>'user.my','uses'=>'UserController@my']);//用户资料


Route::any('/user/edit.html', ['as'=>'user.edit','uses'=>'UserController@edit']);//资料修改
Route::any('/user/password.html', ['as'=>'user.password','uses'=>'UserController@password']);//密码修改

Route::any('/user/security.html', ['as'=>'user.security','uses'=>'UserController@security']);//安全问题
Route::any('/user/phone.html', ['as'=>'user.phone','uses'=>'UserController@phone']);//绑定手机
Route::any('/user/certification.html', ['as'=>'user.certification','uses'=>'UserController@certification']);//安全认证中心

Route::any('/user/bank.html', ['as'=>'user.bank','uses'=>'UserController@bank']);//我的银行卡
Route::any('/user/paypwd.html', ['as'=>'user.paypwd','uses'=>'UserController@paypwd']);//交易密码
Route::any('/user/retrieve.html', ['as'=>'user.paypwd.retrieve','uses'=>'UserController@retrieve']);//找回交易密码



Route::any('/user/SendCode', ['as'=>'user.SendCode','uses'=>'UserController@SendCode']);//发送短信验证码
Route::any('/user/SendRZCode', ['as'=>'user.SendRZCode','uses'=>'UserController@SendRZCode']);//发送短信验证码
Route::any('/user/sign', ['as'=>'user.sign','uses'=>'UserController@sign']);//我的签名
Route::any('/user/uploads/uploadimg', ['as'=>'uploads.uploadimg','uses'=>'UserController@uploadimg']);//我的签名


Route::any('/user/loginloglist.html', ['as'=>'user.loginloglist','uses'=>'UserController@loginloglist']);//用户登录日志

/**** 会员收益 财务功能 ****/
Route::any('/user/money/shouyimx.html', ['as'=>'user.shouyimx','uses'=>'MoneyController@shouyi']);//收益明细
Route::any('/user/money/shouyi/{id}.html', ['as'=>'user.shouyi','uses'=>'MoneyController@shouyi']);//收益明细
Route::any('/user/money/tender.html', ['as'=>'user.tender','uses'=>'MoneyController@tender']);//我的投资
Route::any('/user/agreement-{sgin}.html', ['as'=>'user.agreement','uses'=>'MoneyController@agreement']);//我的投资

Route::any('/user/products.html', ['as'=>'user.products','uses'=>'UserController@products']);//投资项目
Route::any('/user/mylink.html', ['as'=>'user.mylink','uses'=>'MoneyController@mylink']);//我的推广
Route::any('/user/record.html', ['as'=>'user.record','uses'=>'MoneyController@record']);//我的推广记录
Route::any('/user/QrCodeBg.html', ['as'=>'user.QrCodeBg','uses'=>'UserController@QrCodeBg']);//我的推广二维码
Route::any('/user/moneylog.html', ['as'=>'user.moneylog','uses'=>'MoneyController@moneylog']);//资金统计


Route::any('/user/Yuamount.html', ['as'=>'user.yuamount','uses'=>'MoneyController@yuamount']);//我的余额宝
Route::any('/user/yuamountAct.html', ['as'=>'user.yuamountAct','uses'=>'MoneyController@yuamountAct']);//我的余额宝



Route::any('/user/recharge.html', ['as'=>'user.recharge','uses'=>'MoneyController@recharge']);//充值
Route::any('/user/withdraw.html', ['as'=>'user.withdraw','uses'=>'MoneyController@withdraw']);//提现

Route::any('/user/recharges.html', ['as'=>'user.recharges','uses'=>'MoneyController@recharges']);//充值记录
Route::any('/user/withdraws.html', ['as'=>'user.withdraws','uses'=>'MoneyController@withdraws']);//提现记录

Route::any('/user/offline.html', ['as'=>'user.offline','uses'=>'MoneyController@offline']);//下线分红
Route::any('/user/budget.html', ['as'=>'user.offline.budget','uses'=>'MoneyController@budget']);//下线收支
Route::any('/user/payconfig.html', ['as'=>'user.payconfig','uses'=>'MoneyController@payconfig']);//支付方式


Route::any('/user/nowToMoney', ['as'=>'user.nowToMoney','uses'=>'UserController@nowToMoney']);//项目购买

Route::any('/user/Memberamount.html', ['as'=>'user.memberamount','uses'=>'UserController@Memberamount']);//帐户余额


/**大转盘**/
Route::any('/user/lotterys.html', ['as'=>'user.lotterys','uses'=>'LotterysController@index']);/**大转盘**/
Route::any('/user/lotterys/amount', ['as'=>'user.lotterys.amount','uses'=>'LotterysController@amount']);/**会员余额**/
Route::any('/user/lotterys/winlist', ['as'=>'user.lotterys.winlist','uses'=>'LotterysController@winlist']);/**会员余额**/
Route::any('/user/lotterys/click', ['as'=>'user.lotterys.click','uses'=>'LotterysController@click']);/**会员余额**/
Route::any('/user/lotterylist', ['as'=>'user.lotterylist','uses'=>'LotterysController@lotterylist']);/**会员余额**/


Route::any('/kefu.html', ['as'=>'layim.index','uses'=>'LayimController@index']);/**在线聊天**/

Route::any('/send', ['as'=>'layim.send','uses'=>'LayimController@send']);/**在线聊天消息发送**/
Route::any('/getmsg', ['as'=>'layim.getmsg','uses'=>'LayimController@getmsg']);/**在线聊天消息拉取**/
//Route::any('/kefu.html', ['as'=>'layim.kefu','uses'=>'LayimController@kefu']);/**在线聊天页面**/
Route::any('/uploadimgage', ['as'=>'layim.uploadimgage','uses'=>'LayimController@uploadimgage']);/**在线聊天上传图片**/






