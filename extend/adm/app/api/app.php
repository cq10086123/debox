<?php
/*
Name:应用管理API
Version:1.0
Author:易如意
Author QQ:51154393
Author Url:www.eruyi.cn
*/
if (!isset($islogin)) header("Location: /"); //非法访问
if ($act == 'add') { //添加APP
	$name = isset($_POST['name']) ? purge($_POST['name']) : '';
	$bb = isset($_POST['bb']) ? purge($_POST['bb']) : '';
	$appid = isset($_POST['appid']) ? intval($_POST['appid']) : 0;
	if ($name == '') json(201, '应用名字不能为空');
	$app_res = Db::table('app')->where('name', $name)->find();
	if ($app_res) json(201, '应用名称重复');
	if ($appid > 0) {
		$app_res = Db::table('app')->where('id', $appid)->find();
		if (!$app_res) json(201, '继承应用不存在');
		$app_res['name'] = $name;
		$app_res['appkey'] = md5(time());
		if ($bb != '') $app_res['app_bb'] = $bb;
		$app_res['appkey'] = md5(time());
		unset($app_res['id']);
		$add = $app_res;
	} else {
		if ($bb == '') $bb = '1.0.0';
		$add = ['name' => $name, 'app_bb' => $bb, 'appkey' => md5(time())];
	}
	$res = Db::table('app')->add($add);
	//die($res); 
	if ($res) {
		if (defined('ADM_LOG') && ADM_LOG == 1) {
			Db::table('log')->add(['group' => 'adm', 'type' => 'app_add', 'status' => 200, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
		} //记录日志
		json(200, '添加成功');
	} else {
		if (defined('ADM_LOG') && ADM_LOG == 1) {
			Db::table('log')->add(['group' => 'adm', 'type' => 'app_add', 'status' => 201, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
		} //记录日志
		json(201, '添加失败');
	}
}
if ($act == 'edit') { //编辑应用
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$update['name'] = isset($_POST['name']) ? purge($_POST['name']) : '';
	$update['appkey'] = isset($_POST['appkey']) ? purge($_POST['appkey']) : '';

	$update['state'] = isset($_POST['state']) ? purge($_POST['state']) : 'y'; //应用状态
	$update['mi_state'] = isset($_POST['mi_state']) ? purge($_POST['mi_state']) : 'y'; //加密状态
	$update['smtp_state'] = isset($_POST['smtp_state']) ? purge($_POST['smtp_state']) : 'n'; //邮箱状态
	$update['pay_state'] = isset($_POST['pay_state']) ? purge($_POST['pay_state']) : 'n'; //支付状态
	$update['logon_state'] = isset($_POST['logon_state']) ? purge($_POST['logon_state']) : 'y'; //登录状态
	$update['reg_state'] = isset($_POST['reg_state']) ? purge($_POST['reg_state']) : 'y'; //注册状态

	$update['reg_ipon'] = isset($_POST['reg_ipon']) ? intval($_POST['reg_ipon']) : ''; //IP重复注册间隔
	$update['reg_inon'] = isset($_POST['reg_inon']) ? intval($_POST['reg_inon']) : ''; //设备重复注册间隔
	$update['reg_award'] = isset($_POST['reg_award']) ? purge($_POST['reg_award']) : ''; //注册奖励类型
	$update['reg_award_num'] = isset($_POST['reg_award_num']) ? intval($_POST['reg_award_num']) : 0; //注册奖励数
	$update['inv_award'] = isset($_POST['inv_award']) ? purge($_POST['inv_award']) : ''; //邀请奖励类型
	$update['inv_award_num'] = isset($_POST['inv_award_num']) ? intval($_POST['inv_award_num']) : 0; //邀请奖励数
	$update['reg_notice'] = isset($_POST['reg_notice']) ? purge($_POST['reg_notice']) : ''; //注册关闭通知

	$update['logon_way'] = isset($_POST['logon_way']) ? intval($_POST['logon_way']) : 0; //登录方式
	$update['logon_check_in'] = isset($_POST['logon_check_in']) ? purge($_POST['logon_check_in']) : ''; //登录时验证设备信息
	$update['logon_check_t'] = isset($_POST['logon_check_t']) ? intval($_POST['logon_check_t']) : 0; //设备换绑间隔时间
	$update['logon_num'] = isset($_POST['logon_num']) ? intval($_POST['logon_num']) : 0; //多设备登录数
	$update['diary_award'] = isset($_POST['diary_award']) ? purge($_POST['diary_award']) : ''; //签到奖励类型
	$update['diary_award_num'] = isset($_POST['diary_award_num']) ? intval($_POST['diary_award_num']) : 0; //签到奖励数
	$update['logon_notice'] = isset($_POST['logon_notice']) ? purge($_POST['logon_notice']) : ''; //登录关闭通知

	$update['smtp_host'] = isset($_POST['smtp_host']) ? purge($_POST['smtp_host']) : ''; //邮箱服务器
	$update['smtp_user'] = isset($_POST['smtp_user']) ? purge($_POST['smtp_user']) : ''; //邮箱账号
	$update['smtp_pass'] = isset($_POST['smtp_pass']) ? purge($_POST['smtp_pass']) : ''; //邮箱密码
	$update['smtp_port'] = isset($_POST['smtp_port']) ? intval($_POST['smtp_port']) : 25; //邮箱端口

	$update['pay_url'] = isset($_POST['pay_url']) ? purge($_POST['pay_url']) : ''; //支付地址
	$update['pay_id'] = isset($_POST['pay_id']) ? purge($_POST['pay_id']) : ''; //支付ID
	$update['pay_key'] = isset($_POST['pay_key']) ? purge($_POST['pay_key']) : ''; //支付KEY
	$update['pay_ali_state'] = isset($_POST['pay_ali_state']) ? purge($_POST['pay_ali_state']) : 'y'; //支付宝状态
	$update['pay_wx_state'] = isset($_POST['pay_wx_state']) ? purge($_POST['pay_wx_state']) : 'y'; //微信状态
	$update['pay_qq_state'] = isset($_POST['pay_qq_state']) ? purge($_POST['pay_qq_state']) : 'y'; //QQ状态
	$update['pay_notify'] = isset($_POST['pay_notify']) ? purge($_POST['pay_notify']) : ''; //异步通知地址
	$update['mi_type'] = isset($_POST['mi_type']) ? intval($_POST['mi_type']) : 0; //加密类型
	$update['mi_sign'] = isset($_POST['mi_sign']) ? purge($_POST['mi_sign']) : ''; //数据签名
	$update['mi_time'] = isset($_POST['mi_time']) ? intval($_POST['mi_time']) : 0; //时间校验
	$update['mi_rsa_private_key'] = isset($_POST['mi_rsa_private_key']) ? purge($_POST['mi_rsa_private_key']) : ''; //RSA私钥
	$update['mi_rsa_public_key'] = isset($_POST['mi_rsa_public_key']) ? purge($_POST['mi_rsa_public_key']) : ''; //RSA公钥
	$update['mi_rc4_key'] = isset($_POST['mi_rc4_key']) ? purge($_POST['mi_rc4_key']) : ''; //RC4秘钥
	$update['mode'] = isset($_POST['mode']) ? purge($_POST['mode']) : 'y'; //运营模式

	$update['app_bb'] = isset($_POST['app_bb']) ? purge($_POST['app_bb']) : '1.0'; //APP版本
	$update['app_nurl'] = isset($_POST['app_nurl']) ? purge($_POST['app_nurl']) : ''; //更新链接
	$update['app_nshow'] = isset($_POST['app_nshow']) ? purge($_POST['app_nshow']) : ''; //更新内容
	$update['app_bb_mobile'] = isset($_POST['app_bb_mobile']) ? purge($_POST['app_bb_mobile']) : '1.0'; //mobileAPP版本
	$update['app_nurl_mobile'] = isset($_POST['app_nurl_mobile']) ? purge($_POST['app_nurl_mobile']) : ''; //mobile更新链接
	$update['app_nshow_mobile'] = isset($_POST['app_nshow_mobile']) ? purge($_POST['app_nshow_mobile']) : ''; //mobile更新内容
	$update['notice'] = isset($_POST['notice']) ? purge($_POST['notice']) : ''; //关闭通知

	$update['ui_state'] = isset($_POST['ui_state']) ? purge($_POST['ui_state']) : 'y'; //加密状态
	$update['ui_state_live'] = isset($_POST['ui_state_live']) ? purge($_POST['ui_state_live']) : 'y';
	$update['ui_state_jkjxkg'] = isset($_POST['ui_state_jkjxkg']) ? purge($_POST['ui_state_jkjxkg']) : 'y';
	$update['ui_state_livevip'] = isset($_POST['ui_state_livevip']) ? purge($_POST['ui_state_livevip']) : 'n';
	$update['ui_state_infojm'] = isset($_POST['ui_state_infojm']) ? purge($_POST['ui_state_infojm']) : 'y';
	$update['ui_state_jk'] = isset($_POST['ui_state_jk']) ? purge($_POST['ui_state_jk']) : 'y';
	$update['ui_state_dcjm'] = isset($_POST['ui_state_dcjm']) ? purge($_POST['ui_state_dcjm']) : 'y';
	$update['app_json'] = isset($_POST['app_json']) ? purge($_POST['app_json']) : '';
	$update['kami_url'] = isset($_POST['kami_url']) ? purge($_POST['kami_url']) : '';
	$update['app_jsonb'] = isset($_POST['app_jsonb']) ? purge($_POST['app_jsonb']) : '';
	$update['app_jsonc'] = isset($_POST['app_jsonc']) ? purge($_POST['app_jsonc']) : '';
	$update['app_huodong'] = isset($_POST['app_huodong']) ? purge($_POST['app_huodong']) : '';
	$update['ui_paybackg'] = isset($_POST['ui_paybackg']) ? purge($_POST['ui_paybackg']) : '';
	$update['ui_kefu'] = isset($_POST['ui_kefu']) ? purge($_POST['ui_kefu']) : '';
    $update['ui_kefu_mobile'] = isset($_POST['ui_kefu_mobile']) ? purge($_POST['ui_kefu_mobile']) : '';
	$update['ui_kefu2'] = isset($_POST['ui_kefu2']) ? purge($_POST['ui_kefu2']) : '';
	$update['ui_button3backg'] = isset($_POST['ui_button3backg']) ? purge($_POST['ui_button3backg']) : '';
	$update['ui_buttonadimg'] = isset($_POST['ui_buttonadimg']) ? purge($_POST['ui_buttonadimg']) : '';
	$update['ui_button3backg2'] = isset($_POST['ui_button3backg2']) ? purge($_POST['ui_button3backg2']) : '';
	$update['ui_buttonadimg2'] = isset($_POST['ui_buttonadimg2']) ? purge($_POST['ui_buttonadimg2']) : '';
	$update['ui_button3backg3'] = isset($_POST['ui_button3backg3']) ? purge($_POST['ui_button3backg3']) : '';
	$update['ui_buttonadimg3'] = isset($_POST['ui_buttonadimg3']) ? purge($_POST['ui_buttonadimg3']) : '';
	$update['ui_vipdc'] = isset($_POST['ui_vipdc']) ? purge($_POST['ui_vipdc']) : '';
	$update['ui_vipdc_zdmc'] = isset($_POST['ui_vipdc_zdmc']) ? purge($_POST['ui_vipdc_zdmc']) : '';
	$update['ui_vipdc_zdzh'] = isset($_POST['ui_vipdc_zdzh']) ? purge($_POST['ui_vipdc_zdzh']) : '';
	$update['ui_vipdc_zdzhpass'] = isset($_POST['ui_vipdc_zdzhpass']) ? purge($_POST['ui_vipdc_zdzhpass']) : '';
	$update['ui_vipzb'] = isset($_POST['ui_vipzb']) ? purge($_POST['ui_vipzb']) : '';
	$update['ui_vipzb_zdmc'] = isset($_POST['ui_vipzb_zdmc']) ? purge($_POST['ui_vipzb_zdmc']) : '';
	$update['ui_vipzb_zdzh'] = isset($_POST['ui_vipzb_zdzh']) ? purge($_POST['ui_vipzb_zdzh']) : '';
	$update['ui_vipzb_zdzhpass'] = isset($_POST['ui_vipzb_zdzhpass']) ? purge($_POST['ui_vipzb_zdzhpass']) : '';
	$update['ui_group'] = isset($_POST['ui_group']) ? purge($_POST['ui_group']) : '88888888';
    $update['ui_group_mobile'] = isset($_POST['ui_group_mobile']) ? purge($_POST['ui_group_mobile']) : '88888888';
	$update['ui_logo'] = isset($_POST['ui_logo']) ? purge($_POST['ui_logo']) : '';
	$update['ad_slide'] = isset($_POST['ad_slide']) ? purge($_POST['ad_slide']) : '';
    $update['ad_slide_mobile'] = isset($_POST['ad_slide_mobile']) ? purge($_POST['ad_slide_mobile']) : '';
	$update['ad_slide_soundkg'] = isset($_POST['ad_slide_soundkg']) ? purge($_POST['ad_slide_soundkg']) : '';
	$update['free_time'] = isset($_POST['free_time']) ? purge($_POST['free_time']) : '';
	$update['free_time_tip'] = isset($_POST['free_time_tip']) ? purge($_POST['free_time_tip']) : '';
	$update['isToPay'] = isset($_POST['isToPay']) ? purge($_POST['isToPay']) : '';
	$update['isNoticeShow'] = isset($_POST['isNoticeShow']) ? purge($_POST['isNoticeShow']) : '';
	$update['livePass'] = isset($_POST['livePass']) ? purge($_POST['livePass']) : '';
	$update['liveUrl'] = isset($_POST['liveUrl']) ? purge($_POST['liveUrl']) : '';
	$update['play_tips'] = isset($_POST['play_tips']) ? purge($_POST['play_tips']) : '';
	$update['ui_startad_bj'] = isset($_POST['ui_startad_bj']) ? purge($_POST['ui_startad_bj']) : '';
	$update['ui_startad'] = isset($_POST['ui_startad']) ? purge($_POST['ui_startad']) : '';
	$update['ui_startad_mobile'] = isset($_POST['ui_startad_mobile']) ? purge($_POST['ui_startad_mobile']) : '';
	$update['ui_startad_time'] = isset($_POST['ui_startad_time']) ? purge($_POST['ui_startad_time']) : '';
	$update['ui_startad_hdptime'] = isset($_POST['ui_startad_hdptime']) ? purge($_POST['ui_startad_hdptime']) : '';
	$update['ui_app_banner'] = isset($_POST['ui_app_banner']) ? purge($_POST['ui_app_banner']) : '';
	$update['ui_removersc'] = isset($_POST['ui_removersc']) ? purge($_POST['ui_removersc']) : '';
	$update['ui_remove_parses'] = isset($_POST['ui_remove_parses']) ? purge($_POST['ui_remove_parses']) : '';
	$update['ui_remove_class'] = isset($_POST['ui_remove_class']) ? purge($_POST['ui_remove_class']) : '';
	$update['ui_remove_adjx'] = isset($_POST['ui_remove_adjx']) ? purge($_POST['ui_remove_adjx']) : '';
	$update['ui_parse_name'] = isset($_POST['ui_parse_name']) ? purge($_POST['ui_parse_name']) : '';
	$update['app_about'] = isset($_POST['app_about']) ? purge($_POST['app_about']) : '';

	// json(201,$update['ui_state']);
	$app_res = Db::table('app')->where('name', $update['name'])->find();
	if ($app_res) {
		if ($app_res['id'] != $id) json(201, '应用名称重复');
	}

	$res = Db::table('app')->where('id', $id)->update($update);
	//die($res); 
	if ($res) {
		if (defined('ADM_LOG') && ADM_LOG == 1) {
			Db::table('log')->add(['group' => 'adm', 'type' => 'app_edit', 'status' => 200, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
		} //记录日志
		json(200, '编辑成功');
	} else {
		if (defined('ADM_LOG') && ADM_LOG == 1) {
			Db::table('log')->add(['group' => 'adm', 'type' => 'app_edit', 'status' => 201, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
		} //记录日志
		json(201, '编辑失败');
	}
}
if ($act == 'del') { //删除应用
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if ($id) {
		$ids = '';
		foreach ($id as $value) {
			$ids .= intval($value) . ",";
		}
		$ids = rtrim($ids, ",");
		$res = Db::table('app')->where('id', 'in', '(' . $ids . ')')->del(); //false
		//die($res);
		if ($res) {
			if (defined('ADM_LOG') && ADM_LOG == 1) {
				Db::table('log')->add(['group' => 'adm', 'type' => 'app_del', 'status' => 200, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
			} //记录日志
			json(200, '删除成功');
		} else {
			if (defined('ADM_LOG') && ADM_LOG == 1) {
				Db::table('log')->add(['group' => 'adm', 'type' => 'app_del', 'status' => 201, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
			} //记录日志
			json(201, '删除失败');
		}
	} else {
		json(201, '没有需要删除的数据');
	}
}
//站点管理
if ($act == 'siteadd') {
	$name = isset($_POST['name']) ? purge($_POST['name']) : '';
	$type = isset($_POST['type']) ? purge($_POST['type']) : 'Spider';
	$playerType = isset($_POST['playerType']) ? purge($_POST['playerType']) : 'IJK';
	$api = isset($_POST['api']) ? purge($_POST['api']) : 'csp_AppYsV2';
	$extend = isset($_POST['extend']) ? purge($_POST['extend']) : '';
	$parse = isset($_POST['parse']) ? purge($_POST['parse']) : '';
	$appid = isset($_POST['appid']) ? intval($_POST['appid']) : 0;
	$searchable = isset($_POST['searchable']) ? intval($_POST['searchable']) : 0;
	$quicksearch = isset($_POST['quicksearch']) ? intval($_POST['quicksearch']) : 0;
	$filterable = isset($_POST['filterable']) ? intval($_POST['filterable']) : 0;
	$sitejm = isset($_POST['sitejm']) ? intval($_POST['sitejm']) : 0;
	if ($name == '') json(201, '请设置网站名称');
	if ($api == '') json(201, '请设置api');
	// if($extend == '')json(201,'请设置扩展接口');
	if ($appid == 0) json(201, '绑定应用为空');

	$app_res = Db::table('app')->where('id', $appid)->find();
	if (!$app_res) json(201, '应用不存在');
	$site_res = Db::table('site')->where(['appid' => $appid, 'name' => $name])->find();
	if ($site_res) json(201, '商品已存在');

	$add_res = Db::table('site')->add(['name' => $name, 'type' => $type, 'playerType' => $playerType, 'api' => $api, 'extend' => $extend, 'parse' => $parse, 'appid' => $appid, 'searchable' => $searchable, 'quicksearch' => $quicksearch, 'filterable' => $filterable, 'sitejm' => $sitejm]);
	//die($res); 
	if ($add_res) {
		if (defined('ADM_LOG') && ADM_LOG == 1) {
			Db::table('log')->add(['group' => 'adm', 'type' => 'site_add', 'status' => 200, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
		} //记录日志
		json(200, '添加成功');
	} else {
		if (defined('ADM_LOG') && ADM_LOG == 1) {
			Db::table('log')->add(['group' => 'adm', 'type' => 'site_add', 'status' => 201, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
		} //记录日志
		json(201, '添加失败');
	}
}
if ($act == 'siteedit') {
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$update['name'] = isset($_POST['name']) ? purge($_POST['name']) : '';
	$update['type'] = isset($_POST['type']) ? purge($_POST['type']) : 'Spider';
	$update['playerType'] = isset($_POST['playerType']) ? purge($_POST['playerType']) : 'IJK';
	$update['api'] = isset($_POST['api']) ? purge($_POST['api']) : 'csp_AppYsV2';
	$update['extend'] = isset($_POST['extend']) ? purge($_POST['extend']) : '';
	$update['parse'] = isset($_POST['parse']) ? purge($_POST['parse']) : '';
	$update['appid'] = isset($_POST['appid']) ? intval($_POST['appid']) : 0;
	$update['state'] = isset($_POST['state']) ? purge($_POST['state']) : 'y';
	$update['searchable'] = isset($_POST['searchable']) ? intval($_POST['searchable']) : 0;
	$update['quicksearch'] = isset($_POST['quicksearch']) ? intval($_POST['quicksearch']) : 0;
	$update['filterable'] = isset($_POST['filterable']) ? intval($_POST['filterable']) : 0;
	$update['sitejm'] = isset($_POST['sitejm']) ? intval($_POST['sitejm']) : 0;
	if ($update['name'] == '') json(201, '请设置网站名称');
	if ($update['api'] == '') json(201, '请设置api');
	// if($update['extend'] == '')json(201,'请设置扩展接口');
	if ($update['appid'] == 0) json(201, '绑定应用为空');

	$app_res = Db::table('app')->where('id', $update['appid'])->find();
	if (!$app_res) json(201, '应用不存在');

	$site_res = Db::table('site')->where(['appid' => $update['appid'], 'name' => $update['name']])->find();
	if ($site_res) {
		if ($site_res['id'] != $id) json(201, '商品已存在');
	}

	$res = Db::table('site')->where('id', $id)->update($update);
	//die($res); 
	if ($res) {
		if (defined('ADM_LOG') && ADM_LOG == 1) {
			Db::table('log')->add(['group' => 'adm', 'type' => 'site_edit', 'status' => 200, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
		} //记录日志
		json(200, '编辑成功');
	} else {
		if (defined('ADM_LOG') && ADM_LOG == 1) {
			Db::table('log')->add(['group' => 'adm', 'type' => 'site_edit', 'status' => 201, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
		} //记录日志
		json(201, '编辑失败');
	}
}
if ($act == 'sitedel') { //删除商品
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if ($id) {
		$ids = '';
		foreach ($id as $value) {
			$ids .= intval($value) . ",";
		}
		$ids = rtrim($ids, ",");
		$res = Db::table('site')->where('id', 'in', '(' . $ids . ')')->del(); //false
		//die($res);
		if ($res) {
			if (defined('ADM_LOG') && ADM_LOG == 1) {
				Db::table('log')->add(['group' => 'adm', 'type' => 'site_del', 'status' => 200, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
			} //记录日志
			json(200, '删除成功');
		} else {
			if (defined('ADM_LOG') && ADM_LOG == 1) {
				Db::table('log')->add(['group' => 'adm', 'type' => 'site_del', 'status' => 201, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
			} //记录日志
			json(201, '删除失败');
		}
	} else {
		json(201, '没有需要删除的数据');
	}
}
?>