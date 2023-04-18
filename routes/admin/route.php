<?php

/*
+--------+-----------+------------------------------+-----------------+------------------------------------------------------+--------------+
dongchunhongdeMacBook-Pro-2:lara58 dongchunhong$ php artisan route:list
    +--------+-----------+------------------------------+-----------------+------------------------------------------------------+--------------+
| Domain | Method    | URI                          | Name            | Action                                               | Middleware   |
+--------+-----------+------------------------------+-----------------+------------------------------------------------------+--------------+
|        |           |
|        | GET|HEAD  | admin/article                | article.index   | \Admin\ArticleController@index                       | web          |
|        | POST      | admin/article                | article.store   | \Admin\ArticleController@store                       | web          |
|        | GET|HEAD  | admin/article/create         | article.create  | \Admin\ArticleController@create                      | web          |
|        | GET|HEAD  | admin/article/{article}      | article.show    | \Admin\ArticleController@show                        | web          |
|        | PUT|PATCH | admin/article/{article}      | article.update  | \Admin\ArticleController@update                      | web          |
|        | DELETE    | admin/article/{article}      | article.destroy | \Admin\ArticleController@destroy                     | web          |
|        | GET|HEAD  | admin/article/{article}/edit | article.edit    | \Admin\ArticleController@edit                        | web          |
|        |  |
+--------+-----------+------------------------------+-----------------+------------------------------------------------------+--------------+

    */


//Route::get('article/index', 'ArticleController@index');
//资源路由
//Route::resource('article', 'ArticleController');

Route::any('/', ['as'=>'index.index','uses'=>'IndexController@index']);//后台首页
Route::any('Index', ['as'=>'index.index','uses'=>'IndexController@index']);//后台首页
Route::any('Main', ['as'=>'index.main','uses'=>'IndexController@main']);//后台首页
Route::any('CacheFlush', ['as'=>'index.cacheflush','uses'=>'IndexController@CacheFlush']);//后台首页
Route::any('msgconut', ['as'=>'playSound.msgconut','uses'=>'IndexController@msgconut']);

//积分兑换管理 jfexchanges
Route::any('jfexchange/store', ['as'=>'jfexchange.store','uses'=>'JfexchangeController@store']);
Route::any('jfexchange/lists', ['as'=>'jfexchange.lists','uses'=>'JfexchangeController@lists']);
Route::any('jfexchange/index', ['as'=>'jfexchange.index','uses'=>'JfexchangeController@index']);
Route::any('jfexchange/update', ['as'=>'jfexchange.update','uses'=>'JfexchangeController@update']);
Route::any('jfexchange/delete', ['as'=>'jfexchange.delete','uses'=>'JfexchangeController@delete']);
Route::any('jfexchange/sendsms', ['as'=>'jfexchange.sendsms','uses'=>'JfexchangeController@sendsms']);


//管理员
Route::any('admin/store', ['as'=>'admin.store','uses'=>'AdminController@store']);
Route::any('admin/lists', ['as'=>'admin.lists','uses'=>'AdminController@lists']);
Route::any('admin/check', ['as'=>'admin.check','uses'=>'AdminController@check']);
Route::any('admin/checkusername', ['as'=>'admin.checkusername','uses'=>'AdminController@checkusername']);
Route::any('admin/update', ['as'=>'admin.update','uses'=>'AdminController@update']);
Route::any('admin/show', ['as'=>'admin.show','uses'=>'AdminController@show']);
Route::any('admin/delete', ['as'=>'admin.delete','uses'=>'AdminController@delete']);
Route::any('admin/index', ['as'=>'admin.index','uses'=>'AdminController@index']);
Route::any('admin/switchonoff', ['as'=>'admin.switch','uses'=>'AdminController@switchonoff']);
Route::any('admin/kefu', ['as'=>'admin.kefu','uses'=>'AdminController@kefu']);

//个人中心
Route::any('manage/index', ['as'=>'manage.index','uses'=>'ManageController@index']);
Route::any('manage/update', ['as'=>'manage.update','uses'=>'ManageController@index']);
Route::any('manage/resetpw', ['as'=>'manage.resetpw','uses'=>'ManageController@index']);

//管理组
Route::any('auth/store', ['as'=>'auth.store','uses'=>'AuthController@store']);
Route::any('auth/lists', ['as'=>'auth.lists','uses'=>'AuthController@lists']);
Route::any('auth/update', ['as'=>'auth.update','uses'=>'AuthController@update']);
Route::any('auth/delete', ['as'=>'auth.delete','uses'=>'AuthController@delete']);
Route::any('auth/set', ['as'=>'auth.set','uses'=>'AuthController@set']);

//文章分类
Route::any('category/store', ['as'=>'category.store','uses'=>'CategoryController@store']);
Route::any('category/lists', ['as'=>'category.lists','uses'=>'CategoryController@lists']);
Route::any('category/index', ['as'=>'category.index','uses'=>'CategoryController@index']);
Route::any('category/update', ['as'=>'category.update','uses'=>'CategoryController@update']);
Route::any('category/delete', ['as'=>'category.delete','uses'=>'CategoryController@delete']);
Route::any('category/atindex', ['as'=>'category.atindex','uses'=>'CategoryController@atindex']);


//文章
Route::any('article/store', ['as'=>'article.store','uses'=>'ArticleController@store']);
Route::any('article/lists', ['as'=>'article.lists','uses'=>'ArticleController@lists']);
Route::any('article/index', ['as'=>'article.index','uses'=>'ArticleController@index']);
Route::any('article/update', ['as'=>'article.update','uses'=>'ArticleController@update']);
Route::any('article/delete', ['as'=>'article.delete','uses'=>'ArticleController@delete']);
Route::any('article/getcategory', ['as'=>'article.getcategory','uses'=>'ArticleController@getclassify']);
Route::any('article/show', ['as'=>'article.show','uses'=>'ArticleController@show']);
Route::any('article/settop', ['as'=>'article.settop','uses'=>'ArticleController@settop']);

//积分商品
Route::any('jfshops/store', ['as'=>'jfshops.store','uses'=>'JfshopController@store']);
Route::any('jfshops/lists', ['as'=>'jfshops.lists','uses'=>'JfshopController@lists']);
Route::any('jfshops/index', ['as'=>'jfshops.index','uses'=>'JfshopController@index']);
Route::any('jfshops/update', ['as'=>'jfshops.update','uses'=>'JfshopController@update']);
Route::any('jfshops/delete', ['as'=>'jfshops.delete','uses'=>'JfshopController@delete']);
//Route::any('jfshops/getcategory', ['as'=>'jfshops.getcategory','uses'=>'JfshopController@getclassify']);
Route::any('jfshops/show', ['as'=>'jfshops.show','uses'=>'JfshopController@show']);
Route::any('jfshops/settop', ['as'=>'jfshops.settop','uses'=>'JfshopController@settop']);

//名家
Route::any('celebrity/store', ['as'=>'celebrity.store','uses'=>'CelebrityController@store']);
Route::any('celebrity/lists', ['as'=>'celebrity.lists','uses'=>'CelebrityController@lists']);
Route::any('celebrity/index', ['as'=>'celebrity.index','uses'=>'CelebrityController@index']);
Route::any('celebrity/update', ['as'=>'celebrity.update','uses'=>'CelebrityController@update']);
Route::any('celebrity/delete', ['as'=>'celebrity.delete','uses'=>'CelebrityController@delete']);
Route::any('celebrity/getcelebrity', ['as'=>'celebrity.getcelebrity','uses'=>'CelebrityController@getcelebrity']);
Route::any('celebrity/settop', ['as'=>'celebrity.settop','uses'=>'CelebrityController@settop']);
Route::any('celebrity/gettop', ['as'=>'celebrity.gettop','uses'=>'CelebrityController@gettop']);


//商品
Route::any('product/store', ['as'=>'product.store','uses'=>'ProductController@store']);
Route::any('product/lists', ['as'=>'product.lists','uses'=>'ProductController@lists']);
Route::any('product/index', ['as'=>'product.index','uses'=>'ProductController@index']);
Route::any('product/update', ['as'=>'product.update','uses'=>'ProductController@update']);
Route::any('product/delete', ['as'=>'product.delete','uses'=>'ProductController@delete']);
Route::any('product/getcelebrity', ['as'=>'product.getcelebrity','uses'=>'ProductController@getcelebrity']);
Route::any('product/settop', ['as'=>'product.settop','uses'=>'ProductController@settop']);


//商品
Route::any('onlinemsg/store', ['as'=>'onlinemsg.store','uses'=>'OnlinemsgController@store']);
Route::any('onlinemsg/lists', ['as'=>'onlinemsg.lists','uses'=>'OnlinemsgController@lists']);
Route::any('onlinemsg/index', ['as'=>'onlinemsg.index','uses'=>'OnlinemsgController@index']);
Route::any('onlinemsg/update', ['as'=>'onlinemsg.update','uses'=>'OnlinemsgController@update']);
Route::any('onlinemsg/delete', ['as'=>'onlinemsg.delete','uses'=>'OnlinemsgController@delete']);
Route::any('onlinemsg/settop', ['as'=>'onlinemsg.settop','uses'=>'OnlinemsgController@settop']);






//广告类型管理
Route::any('advertisement/store', ['as'=>'advertisement.store','uses'=>'AdvertisementController@store']);
Route::any('advertisement/lists', ['as'=>'advertisement.lists','uses'=>'AdvertisementController@lists']);
Route::any('advertisement/index', ['as'=>'advertisement.index','uses'=>'AdvertisementController@index']);
Route::any('advertisement/update', ['as'=>'advertisement.update','uses'=>'AdvertisementController@update']);
Route::any('advertisement/delete', ['as'=>'advertisement.delete','uses'=>'AdvertisementController@delete']);



//广告数据管理
Route::any('advertisementdata/store', ['as'=>'advertisementdata.store','uses'=>'AdvertisementdataController@store']);
Route::any('advertisementdata/lists', ['as'=>'advertisementdata.lists','uses'=>'AdvertisementdataController@lists']);
Route::any('advertisementdata/index', ['as'=>'advertisementdata.index','uses'=>'AdvertisementdataController@index']);
Route::any('advertisementdata/update', ['as'=>'advertisementdata.update','uses'=>'AdvertisementdataController@update']);
Route::any('advertisementdata/delete', ['as'=>'advertisementdata.delete','uses'=>'AdvertisementdataController@delete']);
Route::any('advertisementdata/getposition', ['as'=>'advertisementdata.getposition','uses'=>'AdvertisementdataController@getposition']);


//站点管理
Route::any('site/store', ['as'=>'site.store','uses'=>'SiteController@store']);
Route::any('site/lists', ['as'=>'site.lists','uses'=>'SiteController@lists']);
Route::any('site/update', ['as'=>'site.update','uses'=>'SiteController@update']);
Route::any('site/delete', ['as'=>'site.delete','uses'=>'SiteController@delete']);


//广告链接
Route::any('link/store', ['as'=>'link.store','uses'=>'LinkController@store']);
Route::any('link/lists', ['as'=>'link.lists','uses'=>'LinkController@lists']);
Route::any('link/index', ['as'=>'link.index','uses'=>'LinkController@index']);
Route::any('link/update', ['as'=>'link.update','uses'=>'LinkController@update']);
Route::any('link/show', ['as'=>'link.show','uses'=>'LinkController@update']);
Route::any('link/delete', ['as'=>'link.delete','uses'=>'LinkController@delete']);



//设置
Route::any('seting/store', ['as'=>'seting.store','uses'=>'SetingController@store']);
Route::any('seting/lists', ['as'=>'seting.lists','uses'=>'SetingController@lists']);
Route::any('seting/update', ['as'=>'seting.update','uses'=>'SetingController@update']);
Route::any('seting/delete', ['as'=>'seting.delete','uses'=>'SetingController@delete']);
Route::any('seting/siteset', ['as'=>'seting.siteset','uses'=>'SetingController@siteset']);
Route::any('seting/uplodeimg', ['as'=>'seting.uplodeimg','uses'=>'SetingController@uplodeimg']);
Route::any('seting/systemphotos', ['as'=>'seting.systemphotos','uses'=>'SetingController@systemphotos']);
Route::any('seting/uploadvideo', ['as'=>'seting.uploadvideo','uses'=>'SetingController@uploadvideo']);







//登录日志
Route::any('loginlog/lists', ['as'=>'loginlog.lists','uses'=>'LoginlogController@lists']);
Route::any('loginlog/delete', ['as'=>'loginlog.delete','uses'=>'LoginlogController@delete']);

//操作日志
Route::any('log/lists', ['as'=>'log.lists','uses'=>'LogController@lists']);
Route::any('log/delete', ['as'=>'log.delete','uses'=>'LogController@delete']);




//菜单
Route::any('menu/store', ['as'=>'menu.store','uses'=>'MenuController@store']);
Route::any('menu/lists', ['as'=>'menu.lists','uses'=>'MenuController@lists']);
Route::any('menu/index', ['as'=>'menu.index','uses'=>'MenuController@index']);
Route::any('menu/update', ['as'=>'menu.update','uses'=>'MenuController@update']);
Route::any('menu/delete', ['as'=>'menu.delete','uses'=>'MenuController@delete']);
Route::any('menu/updatedisabled', ['as'=>'menu.updatedisabled','uses'=>'MenuController@updatedisabled']);
Route::any('menu/updates', ['as'=>'menu.updates','uses'=>'MenuController@updates']);
Route::any('menu/copy', ['as'=>'menu.copy','uses'=>'MenuController@copy']);


//上传
Route::any('uploads/uploadimg', ['as'=>'uploads.uploadimg','uses'=>'UploadsController@uploadimg']);
Route::any('uploads/uploadeditorimg', ['as'=>'uploads.uploadeditorimg','uses'=>'UploadsController@uploadeditorimg']);
Route::any('uploads/uploadclassifyimgage', ['as'=>'uploads.uploadclassifyimgage','uses'=>'UploadsController@uploadclassifyimgage']);
Route::any('uploads/uploadposdataimg', ['as'=>'uploads.uploadposdataimg','uses'=>'UploadsController@uploadposdataimg']);
Route::any('uploads/uploadfile', ['as'=>'uploads.uploadfile','uses'=>'UploadsController@uploadfile']);




/**理财开发新增 2019.06.21**/



//短信模板
Route::any('smstmp/store', ['as'=>'smstmp.store','uses'=>'SmstmpController@store']);
Route::any('smstmp/lists', ['as'=>'smstmp.lists','uses'=>'SmstmpController@lists']);
Route::any('smstmp/index', ['as'=>'smstmp.index','uses'=>'SmstmpController@index']);
Route::any('smstmp/update', ['as'=>'smstmp.update','uses'=>'SmstmpController@update']);
Route::any('smstmp/delete', ['as'=>'smstmp.delete','uses'=>'SmstmpController@delete']);

//支付参数
Route::any('payment/store', ['as'=>'payment.store','uses'=>'PaymentController@store']);
Route::any('payment/lists', ['as'=>'payment.lists','uses'=>'PaymentController@lists']);
Route::any('payment/index', ['as'=>'payment.index','uses'=>'PaymentController@index']);
Route::any('payment/update', ['as'=>'payment.update','uses'=>'PaymentController@update']);
Route::any('payment/delete', ['as'=>'payment.delete','uses'=>'PaymentController@delete']);
Route::any('payment/upcode', ['as'=>'payment.upcode','uses'=>'PaymentController@upcode']);
Route::any('payment/codedelete', ['as'=>'payment.codedelete','uses'=>'PaymentController@codedelete']);

//转盘设置
Route::any('lotteryconfig/store', ['as'=>'lotteryconfig.store','uses'=>'LotteryconfigController@store']);
Route::any('lotteryconfig/lists', ['as'=>'lotteryconfig.lists','uses'=>'LotteryconfigController@lists']);
Route::any('lotteryconfig/index', ['as'=>'lotteryconfig.index','uses'=>'LotteryconfigController@index']);
Route::any('lotteryconfig/update', ['as'=>'lotteryconfig.update','uses'=>'LotteryconfigController@update']);
Route::any('lotteryconfig/delete', ['as'=>'lotteryconfig.delete','uses'=>'LotteryconfigController@delete']);


//会员管理
Route::any('member/store', ['as'=>'member.store','uses'=>'MemberController@store']);
Route::any('member/lists', ['as'=>'member.lists','uses'=>'MemberController@lists']);
Route::any('member/index', ['as'=>'member.index','uses'=>'MemberController@index']);
Route::any('member/update', ['as'=>'member.update','uses'=>'MemberController@update']);
Route::any('member/delete', ['as'=>'member.delete','uses'=>'MemberController@delete']);
Route::any('member/switch', ['as'=>'member.switch','uses'=>'MemberController@switchonoff']);
Route::any('member/moneys', ['as'=>'member.moneys','uses'=>'MemberController@moneys']);
Route::any('member/frozen', ['as'=>'member.frozen','uses'=>'MemberController@frozen']);
Route::any('member/tree', ['as'=>'member.tree','uses'=>'MemberController@tree']);

//会员等级管理
Route::any('memberlevel/store', ['as'=>'memberlevel.store','uses'=>'MemberlevelController@store']);
Route::any('memberlevel/lists', ['as'=>'memberlevel.lists','uses'=>'MemberlevelController@lists']);
Route::any('memberlevel/index', ['as'=>'memberlevel.index','uses'=>'MemberlevelController@index']);
Route::any('memberlevel/update', ['as'=>'memberlevel.update','uses'=>'MemberlevelController@update']);
Route::any('memberlevel/delete', ['as'=>'memberlevel.delete','uses'=>'MemberlevelController@delete']);



//会员下线提成管理
Route::any('memberticheng/store', ['as'=>'memberticheng.store','uses'=>'MembertichengController@store']);
Route::any('memberticheng/lists', ['as'=>'memberticheng.lists','uses'=>'MembertichengController@lists']);
Route::any('memberticheng/index', ['as'=>'memberticheng.index','uses'=>'MembertichengController@index']);
Route::any('memberticheng/update', ['as'=>'memberticheng.update','uses'=>'MembertichengController@update']);
Route::any('memberticheng/delete', ['as'=>'memberticheng.delete','uses'=>'MembertichengController@delete']);


//会员充值管理
Route::any('memberrecharge/store', ['as'=>'memberrecharge.store','uses'=>'MemberrechargeController@store']);
Route::any('memberrecharge/lists', ['as'=>'memberrecharge.lists','uses'=>'MemberrechargeController@lists']);
Route::any('memberrecharge/index', ['as'=>'memberrecharge.index','uses'=>'MemberrechargeController@index']);
Route::any('memberrecharge/update', ['as'=>'memberrecharge.update','uses'=>'MemberrechargeController@update']);
Route::any('memberrecharge/delete', ['as'=>'memberrecharge.delete','uses'=>'MemberrechargeController@delete']);
Route::any('memberrecharge/sendsms', ['as'=>'memberrecharge.sendsms','uses'=>'MemberrechargeController@sendsms']);
Route::any('memberrecharge/soundignore', ['as'=>'memberrecharge.soundignore','uses'=>'MemberrechargeController@soundignore']);


//会员提款管理
Route::any('memberwithdrawal/store', ['as'=>'memberwithdrawal.store','uses'=>'MemberwithdrawalController@store']);
Route::any('memberwithdrawal/lists', ['as'=>'memberwithdrawal.lists','uses'=>'MemberwithdrawalController@lists']);
Route::any('memberwithdrawal/index', ['as'=>'memberwithdrawal.index','uses'=>'MemberwithdrawalController@index']);
Route::any('memberwithdrawal/update', ['as'=>'memberwithdrawal.update','uses'=>'MemberwithdrawalController@update']);
Route::any('memberwithdrawal/delete', ['as'=>'memberwithdrawal.delete','uses'=>'MemberwithdrawalController@delete']);
Route::any('memberwithdrawal/sendsms', ['as'=>'memberwithdrawal.sendsms','uses'=>'MemberwithdrawalController@sendsms']);
Route::any('memberwithdrawal/soundignore', ['as'=>'memberwithdrawal.soundignore','uses'=>'MemberwithdrawalController@soundignore']);



//用户站内消息
Route::any('membermsg/lists', ['as'=>'membermsg.lists','uses'=>'MembermsgController@lists']);
Route::any('membermsg/store', ['as'=>'membermsg.store','uses'=>'MembermsgController@store']);
Route::any('membermsg/delete', ['as'=>'membermsg.delete','uses'=>'MembermsgController@delete']);

//短信记录消息
Route::any('sendmobile/lists', ['as'=>'sendmobile.lists','uses'=>'SendmobileController@lists']);
Route::any('sendmobile/store', ['as'=>'sendmobile.store','uses'=>'SendmobileController@store']);
Route::any('sendmobile/update', ['as'=>'sendmobile.update','uses'=>'SendmobileController@update']);
Route::any('sendmobile/delete', ['as'=>'sendmobile.delete','uses'=>'SendmobileController@delete']);

//短信记录消息
Route::any('productbuy/lists', ['as'=>'productbuy.lists','uses'=>'ProductbuyController@lists']);
Route::any('productbuy/store', ['as'=>'productbuy.store','uses'=>'ProductbuyController@store']);
Route::any('productbuy/update', ['as'=>'productbuy.update','uses'=>'ProductbuyController@update']);
Route::any('productbuy/delete', ['as'=>'productbuy.delete','uses'=>'ProductbuyController@delete']);


//操作日志
Route::any('moneylog/lists', ['as'=>'moneylog.lists','uses'=>'MoneylogController@lists']);
Route::any('moneylog/delete', ['as'=>'moneylog.delete','uses'=>'MoneylogController@delete']);

//操作日志
Route::any('memberlogs/lists', ['as'=>'memberlogs.lists','uses'=>'MemberlogsController@lists']);
Route::any('memberlogs/delete', ['as'=>'memberlogs.delete','uses'=>'MemberlogsController@delete']);
Route::any('statistics/lists', ['as'=>'statistics.lists','uses'=>'StatisticsController@lists']);



Route::any('send', ['as'=>'layim.send','uses'=>'LayimController@send']);/**在线聊天消息发送**/
Route::any('getmsg', ['as'=>'layim.getmsg','uses'=>'LayimController@getmsg']);/**在线聊天消息拉取**/
Route::any('uploadimgage', ['as'=>'layim.uploadimgage','uses'=>'LayimController@uploadimgage']);/**在线聊天上传图片**/
Route::any('chatlog', ['as'=>'layim.chatlog','uses'=>'LayimController@chatlog']);/**在线聊天记录**/




/*****   优惠券功能   *****/
/*****  2020.03.25  *****/
/**优惠券**/
Route::any('coupons/store', ['as'=>'coupons.store','uses'=>'CouponsController@store']);
Route::any('coupons/lists', ['as'=>'coupons.lists','uses'=>'CouponsController@lists']);
Route::any('coupons/index', ['as'=>'coupons.index','uses'=>'CouponsController@index']);
Route::any('coupons/update', ['as'=>'coupons.update','uses'=>'CouponsController@update']);
Route::any('coupons/delete', ['as'=>'coupons.delete','uses'=>'CouponsController@delete']);
Route::any('coupons/grant', ['as'=>'coupons.grant','uses'=>'CouponsController@grant']);//优惠券发放
Route::any('coupons/grantqf', ['as'=>'coupons.grantqf','uses'=>'CouponsController@grantqf']);//优惠券发放
/**发放记录**/
Route::any('couponsgrant/store', ['as'=>'couponsgrant.store','uses'=>'CouponsgrantController@store']);
Route::any('couponsgrant/lists', ['as'=>'couponsgrant.lists','uses'=>'CouponsgrantController@lists']);
Route::any('couponsgrant/index', ['as'=>'couponsgrant.index','uses'=>'CouponsgrantController@index']);
Route::any('couponsgrant/update', ['as'=>'couponsgrant.update','uses'=>'CouponsgrantController@update']);
Route::any('couponsgrant/delete', ['as'=>'couponsgrant.delete','uses'=>'CouponsgrantController@delete']);


