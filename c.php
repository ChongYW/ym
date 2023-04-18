<?php

TRUNCATE `loginlogs`;
TRUNCATE `logs`;
TRUNCATE `member`;
TRUNCATE `membercashback`;
TRUNCATE `memberlogs`;
TRUNCATE `membermsg`;
TRUNCATE `memberrecharge`;
TRUNCATE `memberwithdrawal`;
TRUNCATE `moneylog`;
TRUNCATE `onlinemsg`;
TRUNCATE `productbuy`;
TRUNCATE `sendmobile`;
TRUNCATE `layims`;
TRUNCATE `couponsgrantlist`;



ALTER TABLE `products` ADD `isaouttm` INT(1) NULL DEFAULT '0' AFTER `click_count`, ADD `endingtime` DATETIME NULL AFTER `isaouttm`;


20191225


INSERT INTO `setings` ( `name`, `keyname`, `value`, `valuelist`, `type`, `sort`, `remember_token`, `created_at`, `updated_at`) VALUES
( '手机端项目详情背景颜色A', 'ProductBackgroundA', 'background: #ff9900;', NULL, 'text', 1, NULL, '2019-12-25 09:16:35', '2019-12-25 09:37:15'),
( '手机端项目详情背景颜色B', 'ProductBackgroundB', 'background: #C102CD;', NULL, 'text', 1, NULL, '2019-12-25 09:17:13', '2019-12-25 09:37:16');

20191226


UPDATE `setings` SET `valuelist` = 'finance|financev2' WHERE `setings`.`id` = 104;



INSERT INTO `category` ( `parent`, `name`, `sort`, `thumb_url`, `model`, `color`, `ctitle`, `links`, `ckeywords`, `cdescription`, `ccontent`, `atindex`, `atfoot`, `isshow`, `ismenus`, `classname`, `click_count`, `created_at`, `updated_at`) VALUES
( 0, '影视资讯', 10, '/uploads/files/20191226/15773427115e0456f76399b.jpg', 'articles', '#000000', '影视资讯', 'movienews', '影视资讯', '影视资讯', '', 0, 0, 0, 0, NULL, 0, '2019-12-26 06:41:25', '2019-12-26 06:45:14');



INSERT INTO `setings` (`name`, `keyname`, `value`, `valuelist`, `type`, `sort`, `remember_token`, `created_at`, `updated_at`) VALUES
( '票房API开关', 'BoxOffice', '开启', '开启|关闭', 'radio', 1, NULL, '2019-12-26 07:47:29', '2019-12-26 08:37:30');


INSERT INTO `advertisements` ( `name`, `modelname`, `maxnum`, `thumb_url`, `extention`, `sort`, `created_at`, `updated_at`) VALUES
( '电脑端首页底部通栏', 'ad.banner', 1, '/uploads/files/20191226/15773502195e04744b0f3b5.jpg', NULL, 1, '2019-12-26 08:50:22', '2019-12-26 08:50:22');

INSERT INTO `advertisementdatas` ( `name`, `adverid`, `thumb_url`, `url`, `sort`, `title`, `description`, `code`, `created_at`, `updated_at`) VALUES
('通栏广告', 6, '/uploads/files/20191226/15773502505e04746a6fcdf.jpg', '#', 1, '通栏广告', NULL, NULL, '2019-12-26 08:50:57', '2019-12-26 08:50:57');



ALTER TABLE `products` ADD `insuranceseal` VARCHAR(255) NULL AFTER `ketouinfo`, ADD `tagcolor` VARCHAR(255) NULL DEFAULT 'background-color:#FF6A78;color:#F5F2F2;' AFTER `insuranceseal`;


20191229


ALTER TABLE `category` ADD `morec` INT(1) NOT NULL DEFAULT '0' COMMENT '手机端首页推荐' AFTER `ismenus`;



20191231


ALTER TABLE `member` ADD `remarks` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '会员备注' AFTER `mtype`;


ALTER TABLE `member` ADD `sourcedomain` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '来源域名' AFTER `reg_from`;





INSERT INTO `setings` (`name`, `keyname`, `value`, `valuelist`, `type`, `sort`, `remember_token`, `created_at`, `updated_at`) VALUES
( '项目详情会计师事务所名称', 'accountingfirm', '普华永道(PWC)会计师事务所和上海申京律师事务所(项目)', NULL, 'text', 1, NULL, '2019-12-31 05:57:01', '2019-12-31 05:57:01'),
('项目详情监管名称', 'supervise', '上海银行提供监管(项目)', NULL, 'text', 1, NULL, '2019-12-31 05:55:36', '2019-12-31 05:55:36');




20200112

UPDATE `setings` SET `valuelist` = 'default|film' WHERE `setings`.`id` = 103;

/public/mobile/film
/public/js/layui
/public/js/jquery.js
/public/wap/image/js.png
/public/js/layer/

/app/Http/Controllers/Wap/WheelController.php




20200120


/app/Http/Controllers/Wap/MoneyController.php
/app/Http/Controllers/Pc/MoneyController.php

/resources/views/mobile/film/user/recharge.blade.php
/resources/views/mobile/default/user/recharge.blade.php
/resources/views/pc/finance/user/recharge.blade.php
/resources/views/pc/finance2/user/recharge.blade.php

/public/payico

/resources/views/hui/index/index.blade.php
/app/Http/Controllers/Admin/IndexController.php
/app/Productbuy.php


20200123

ALTER TABLE `payment` ADD `pay_codename` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '默认' COMMENT '收款码名称' AFTER `pay_desc`;


ALTER TABLE `memberrecharge` ADD `pay_codename` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '二维码名称' AFTER `type`;



20200130

ALTER TABLE `memberwithdrawal` ADD `sound_ignore` INT(1) NOT NULL DEFAULT '0' COMMENT '忽略提醒' AFTER `status`;

ALTER TABLE `memberrecharge` ADD `sound_ignore` INT(1) NOT NULL DEFAULT '0' COMMENT '忽略提醒' AFTER `status`;


ALTER TABLE `products` ADD `status` INT(1) NOT NULL DEFAULT '1' COMMENT '项目状态' AFTER `tagcolor`;


ALTER TABLE `products` ADD `countdown` DATETIME NULL COMMENT '购买倒计时' AFTER `status`;

ALTER TABLE `products` ADD `countdownad` VARCHAR(255) NULL COMMENT '倒计时广告语' AFTER `countdown`;


20200208 20:45

ALTER TABLE `member` ADD `locking` INT(1) NULL DEFAULT '0' COMMENT '会员锁定状态' AFTER `remarks`;


INSERT INTO `setings` ( `name`, `keyname`, `value`, `valuelist`, `type`, `sort`, `remember_token`, `created_at`, `updated_at`) VALUES
( '会员锁定提醒', 'MemberLockingMsg', '请联系客服', NULL, 'text', 1, NULL, '2020-02-08 12:47:23', '2020-02-08 12:47:23');



2020 0210

ALTER TABLE `payment` ADD `pay_pic_on` INT(1) NOT NULL DEFAULT '0' COMMENT '二维码切换' AFTER `pay_codename`;



2020-02-27


ALTER TABLE `payment` ADD `pay_pic_auto` INT(1) NOT NULL DEFAULT '0' COMMENT '收款码自动切换开关' AFTER `pay_pic_on`, ADD `pay_order_number` INT(11) NOT NULL DEFAULT '1' COMMENT '切换充值订单数' AFTER `pay_pic_auto`;


ALTER TABLE `category` ADD `thumb_url2` VARCHAR(255) NULL COMMENT '缩略图2' AFTER `thumb_url`;

UPDATE `category` SET `thumb_url2`=`thumb_url`;


20200311

ALTER TABLE `payment` ADD `recipient_bank` VARCHAR(255) NULL COMMENT '收款银行' AFTER `enabled`, ADD `recipient_payee` VARCHAR(255) NULL COMMENT '收款人' AFTER `recipient_bank`, ADD `recipient_account` VARCHAR(255) NULL COMMENT '收款帐号' AFTER `recipient_payee`;

20200314


ALTER TABLE `paycode` ADD `pay_status` INT(1) NOT NULL DEFAULT '1' COMMENT '收款码状态' AFTER `pay_pid`, ADD `pay_number` INT(11) NOT NULL DEFAULT '1' COMMENT '展示次数' AFTER `pay_status`;


2020.03.16


ALTER TABLE `products` ADD `buydata` TEXT NULL COMMENT '购买金额数据' AFTER `xxtcbl`;


2020.03.24

ALTER TABLE `category` ADD `templates` VARCHAR(255) NOT NULL DEFAULT 'default' COMMENT '模板设置' AFTER `click_count`;


ALTER TABLE `advertisementdatas` ADD `templates` VARCHAR(255) NULL DEFAULT 'default' COMMENT '模板风格' AFTER `code`;




2020.03.25

/****

--
-- 表的结构 `coupons`
--

CREATE TABLE `coupons` (
`id` int(10) UNSIGNED NOT NULL,
`name` varchar(64) NOT NULL DEFAULT '现金券' COMMENT '商品名称',
`expdata` int(11) DEFAULT NULL COMMENT '有效天数',
`money` decimal(10,2) DEFAULT NULL COMMENT '面额',
`type` int(11) NOT NULL DEFAULT '1' COMMENT '商品类型，1现金券/2加息券',
`status` int(11) NOT NULL DEFAULT '1' COMMENT '状态：1有效/0无效',
`sort` int(11) NOT NULL DEFAULT '1' COMMENT '排序',
`remark` varchar(256) NOT NULL DEFAULT '' COMMENT '商品描述'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='优惠券表';

--
-- 转储表的索引
--

--
-- 表的索引 `coupons`
--
ALTER TABLE `coupons`
ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `coupons`
--
ALTER TABLE `coupons`
MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

 ***/


/*****

CREATE TABLE `couponsgrantlist` (
`id` int(10) UNSIGNED NOT NULL COMMENT '序号',
`uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
`channel` int(11) DEFAULT '1' COMMENT '兑换渠道',
`couponsid` char(32) NOT NULL DEFAULT '0' COMMENT '券编号',
`name` varchar(20) NOT NULL DEFAULT '无' COMMENT '券名称',
`type` int(11) NOT NULL DEFAULT '1' COMMENT '券类型',
`money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
`time` varchar(20) NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '抽奖时间',
`exptime` varchar(20) NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '奖品失效时间',
`status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '发放券状态：1可使用/2已使用/3已过期'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='发放记录';

 *****/

后台地址目录:BSAdminV5
http://域名/ZMAdminV5/bonus
http://域名/ZMAdminV5/YuEBao


/**
 默认时间报错处理

SQL

set global sql_mode='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'

 **/

