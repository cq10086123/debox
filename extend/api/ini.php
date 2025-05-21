<?php
/*
Name:获取配置
Version:1.0
Author:酷点
Author QQ:3089807626
Author Url:
*/
if (!isset($app_res) or !is_array($app_res)) out(100); //如果需要调用应用配置请先判断是否加载app配置

$http = strpos(strtolower($_server['server_protocol']),'https')  === false ? 'http' : 'https';
if ($app_res['app_json'] == null || $app_res['app_json'] == "") {
	$app_res['app_json'] = explode("api.php",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0] . "/app/api.json";
}
if ($app_res['liveUrl'] == null || $app_res['liveUrl'] == "") {
	$app_res['liveUrl'] = explode("api.php",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0] . "/app/live.txt";
}
if ($app_res['app_jsonc'] == null || $app_res['app_jsonc'] == "") {
	$app_res['app_jsonc'] = explode("api.php",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0] . "/app/duocang.json";
}
if ($app_res['ui_state_jk'] == "y") {
	$api_json = explode("api.php",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0]."api.php?act=jkjm";
} else {
	$api_json = $app_res['app_json'];
}
if ($app_res['ui_state_dcjm'] == "y") {
	$api_jsonc = explode("api.php",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0]."api.php?act=dcjm";
} else {
	$api_jsonc = $app_res['app_jsonc'];
}

// if ($app_res['ui_state_live'] == "y") {
// 	$app_res['liveUrl'] = explode("api.php",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0]."api.php?act=live";
// } else {
// 	$app_res['liveUrl'] = $app_res['liveUrl'];
// }

$ini_data = [ //基本配置
	'appkey' => $app_res['appkey'],
	'app_bb' => $app_res['app_bb'],
	'app_nshow' => $app_res['app_nshow'],
	'app_nurl' => $app_res['app_nurl'],
	'app_bb_mobile' => $app_res['app_bb_mobile'],
	'app_nshow_mobile' => $app_res['app_nshow_mobile'],
	'app_nurl_mobile' => $app_res['app_nurl_mobile'],
	'mode' => $app_res['mode'],
	'ui_state' => $app_res['ui_state'],
	'ui_app_banner' => $app_res['ui_app_banner'],
	'ui_state_live' => $app_res['ui_state_live'],
	'ui_state_jkjxkg' => $app_res['ui_state_jkjxkg'],
	'ui_state_livevip' => $app_res['ui_state_livevip'],
	'ui_state_jk' => $app_res['ui_state_jk'],
	'ui_state_dcjm' => $app_res['ui_state_dcjm'],
	'ui_logo' => $app_res['ui_logo'],
	'ad_slide' => $app_res['ad_slide'],
    'ad_slide_mobile' => $app_res['ad_slide_mobile'],
	'ad_slide_soundkg' => $app_res['ad_slide_soundkg'],
	'free_time' => $app_res['free_time'],
	'free_time_tip' => $app_res['free_time_tip'],
	'isToPay' => $app_res['isToPay'],
	'isNoticeShow' => $app_res['isNoticeShow'],
	'livePass' => $app_res['livePass'],
	// 'liveUrl' => $app_res['liveUrl'],
	'play_tips' => $app_res['play_tips'],
	'ui_startad_bj' => $app_res['ui_startad_bj'],
	'ui_startad' => $app_res['ui_startad'],
	'ui_startad_mobile' => $app_res['ui_startad_mobile'],
	'ui_startad_time' => $app_res['ui_startad_time'],
	'ui_startad_hdptime' => $app_res['ui_startad_hdptime'],
	'kami_url' => $app_res['kami_url'],
	'app_json' => $api_json,
	'app_jsonb' => $app_res['app_jsonb'],
	'app_jsonc' => $api_jsonc,
	'app_huodong' => $app_res['app_huodong'],
	'logon_way' => $app_res['logon_way'],
    'smtp_state' => $app_res['smtp_state'],
	'ui_paybackg' => $app_res['ui_paybackg'],
	'ui_kefu' => $app_res['ui_kefu'],
    'ui_kefu_mobile' => $app_res['ui_kefu_mobile'],
	'ui_kefu2' => $app_res['ui_kefu2'],
	'ui_group' => $app_res['ui_group'],
    'ui_group_mobile' => $app_res['ui_group_mobile'],
	'ui_button3backg' => $app_res['ui_button3backg'],
	'ui_buttonadimg' => $app_res['ui_buttonadimg'],
	'ui_button3backg2' => $app_res['ui_button3backg2'],
	'ui_buttonadimg2' => $app_res['ui_buttonadimg2'],
	'ui_button3backg3' => $app_res['ui_button3backg3'],
	'ui_buttonadimg3' => $app_res['ui_buttonadimg3'],
	'ui_vipdc' => $app_res['ui_vipdc'],
	'ui_vipdc_zdmc' => $app_res['ui_vipdc_zdmc'],
	'ui_vipdc_zdzh' => $app_res['ui_vipdc_zdzh'],
	'ui_vipdc_zdzhpass' => $app_res['ui_vipdc_zdzhpass'],
	'ui_vipzb' => $app_res['ui_vipzb'],
	'ui_vipzb_zdmc' => $app_res['ui_vipzb_zdmc'],
	'ui_vipzb_zdzh' => $app_res['ui_vipzb_zdzh'],
	'ui_vipzb_zdzhpass' => $app_res['ui_vipzb_zdzhpass'],
	'ui_removersc' => $app_res['ui_removersc'],
	'ui_remove_parses' => $app_res['ui_remove_parses'],
	'ui_remove_class' => $app_res['ui_remove_class'],
	'ui_remove_adjx' => $app_res['ui_remove_adjx'],
	'ui_parse_name' => $app_res['ui_parse_name'],
	'app_about' => $app_res['app_about']
];
if (isset($_GET['pay'])) {
	$pay_ini = [
		'state' => $app_res['pay_state'],
		'url' => $app_res['pay_url'],
		'appid' => $app_res['pay_id'],
		'appkey' => $app_res['pay_key'],
		'ali' => $app_res['pay_ali_state'],
		'wx' => $app_res['pay_wx_state'],
		'qq' => $app_res['pay_qq_state']
	];
}
if (isset($pay_ini) && is_array($pay_ini)) {
	$ini_data = array_merge($ini_data, ['pay' => $pay_ini]);
}
if (isset($_GET['homead'])) {
	$pay_ini = [
		'state' => $app_res['pay_state'],
		'url' => $app_res['pay_url'],
		'appid' => $app_res['pay_id'],
		'appkey' => $app_res['pay_key'],
		'ali' => $app_res['pay_ali_state'],
		'wx' => $app_res['pay_wx_state'],
		'qq' => $app_res['pay_qq_state']
	];
}

$app_homead = [];
$app_homead_res = Db::table('app_homead')->where('appid', $appid)->order('id desc')->select(); //获取首页广告配置
if (is_array($app_homead_res)) {
	foreach ($app_homead_res as $k => $v) {
		$rows = $app_homead_res[$k];
		
		$app_homead[] = [
			'name' => $rows['name'],
			'extend' => $rows['data'],
			'type' => $rows['type']
		];
	}
}
if (isset($app_homead) && is_array($app_homead)) {
	$ini_data = array_merge($ini_data, ['home_ad' => $app_homead]);
}

$pg = isset($data_arr['pg']) ? intval($data_arr['pg']) : 1;
$bnums = ($pg - 1) * $ENUMS;
$ret = [];
$notice_res = Db::table('app_notice')->where('appid', $appid)->order('id desc')->limit($bnums, $ENUMS)->select();
if (is_array($notice_res)) {
	foreach ($notice_res as $k => $v) {
		$rows = $notice_res[$k];
		$ret[] = [
			'content' => $rows['content'],
			'date' => date("Y-m-d H:i:s", $rows['time']),
			'name' => $rows['adm']
		];
	}
	// out(200, $ret, $app_res);
}
if (isset($ret) && is_array($ret)) {
	$ini_data = array_merge($ini_data, ['notice' => $ret]);
}
//解析
$ret_jx = [];
$app_exten_res = Db::table('app_exten')->where(['appid' => $appid, 'state' => 'y'])->order('id desc')->select(); //获取解析配置
if (is_array($app_exten_res)) {
	foreach ($app_exten_res as $k => $v) {
		$rows = $app_exten_res[$k];
		if ($rows['data'] != null && $rows['data'] != "") {
			if (strpos($rows['data'], ",")) {
				$data = explode(",", $rows['data']);
				$flags["flag"] = $data;
			} else {
				$flags["flag"] = $rows['data'];
			}
		}
		if ($rows['header'] != null && $rows['header'] != "") {
			$flags["header"] = [
				"User-Agent" => $rows['header']
			];
		}
		if ($rows["statejm"] == "y") {
			$url = explode("api.php",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0]."api.php?act=jxjm&id=".$rows["id"];
		} else {
			$url = $rows['api'];
		}
		
		$ret_jx[] = [
			'name' => $rows['name'],
			'type' => $rows['type'],
			'url' => $url,
			'encry' => $rows['statejm'],
			'ext' => json_encode($flags, 320),
		];
	}
}
if (isset($ret_jx) && is_array($ret_jx)) {
	$ini_data = array_merge($ini_data, ['analysis' => $ret_jx]);
}
//站点
$retSite = [];
$site_res = Db::table('site')->where(['appid' => $appid, 'state' => 'y'])->select(); //获取站点列表
if (is_array($site_res)) {
	foreach ($site_res as $k => $v) {
		$rows = $site_res[$k];

		if ($rows['type'] == "XML") {
			$rows['type'] = "0";
		} else if ($rows['type'] == "JSON") {
			$rows['type'] = "1";
		} else {
			$rows['type'] = "3";
		}
		if ($rows['playerType'] == "IJK") {
			$rows['playerType'] = "1";
		} else if ($rows['playerType'] == "EXO") {
			$rows['playerType'] = "2";
		} else {
			$rows['playerType'] = "1";
		}
		if ($rows["sitejm"] == "1") {
			$url = explode("api.php",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0]."extend/api/vodjm.php?id=".$rows["id"]."&app=".$app_res['id'];
		} else {
			$url = $rows['api'];
		}
		$retSite[] = [
			'gid' => $rows['id'],
			'gname' => $rows['name'],
			'gtype' => $rows['type'],
			'gplayerType' => $rows['playerType'],
			'gapiname' => $url,
			'extend' => $rows['extend'],
			'parse' => $rows['parse'],
			'sitejm' => $rows['sitejm'],
			'searchable' => $rows['searchable'],
			'quicksearch' => $rows['quicksearch'],
			'filterable' => $rows['filterable']
		];


	}
}
if (isset($retSite) && is_array($retSite)) {
	$ini_data = array_merge($ini_data, ['site' => $retSite]);
}
//屏保
$app_level = [];
$app_level_res = Db::table('app_level')->where('appid', $appid)->order('id desc')->select(); //获取屏保配置
if (is_array($app_level_res)) {
	foreach ($app_level_res as $k => $v) {
		$rows = $app_level_res[$k];
		$app_level[] = [
			'name' => $rows['name'],
			'extend' => $rows['data'],
			'searchable' => $rows['searchable']
		];
	}
}
if (isset($app_level) && is_array($app_level)) {
	$ini_data = array_merge($ini_data, ['level' => $app_level]);
}
//多仓
$app_duocang = [];
$app_duocang_res = Db::table('app_duocang')->where('appid', $appid)->order('id desc')->select(); //获取首页广告配置
if (is_array($app_duocang_res)) {
	foreach ($app_duocang_res as $k => $v) {
		$rows = $app_duocang_res[$k];
		if ($rows['status'] == "y") {
			if ($rows["status_dcjm"] == "y") {
				$url = explode("api.php",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0]."api.php?act=jkjm&type=dcjm&id=".$rows["id"];
			} else {
				$url = $rows['url'];
			}
			$app_duocang[] = [
				'sourceName' => $rows['name'],
				'sourceUrl' => $url
			];
		}
		
	}
}
if (isset($app_duocang) && is_array($app_duocang)) {
	$ini_data = array_merge($ini_data, ['storeHouse' => $app_duocang]);
}
// encryptionout(200, $ini_data);
// out(200,$ini_data);

//直播多仓
$app_zb = [];
$app_zb_res = Db::table('app_zb')->where('appid', $appid)->order('id desc')->select(); //获取首页广告配置
if (is_array($app_zb_res)) {
	foreach ($app_zb_res as $k => $v) {
		$rows = $app_zb_res[$k];
		if ($rows['status'] == "y") {
			if ($rows["status_zbjm"] == "y") {
				$url = explode("api.php",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0]."api.php?act=jkjm&type=zbjm&id=".$rows["id"];
			} else {
				$url = $rows['url'];
			}



			$app_zb[] = [
				'zbName' => $rows['name'],
				'zbUrl' => $url
			];
		}
		
	}
}
if (isset($app_zb) && is_array($app_zb)) {
	$ini_data = array_merge($ini_data, ['zblist' => $app_zb]);
}
// encryptionout(200, $ini_data);

if ($app_res["ui_state_infojm"] == "y") {
	encryptionout(200, $ini_data);
} else {
	out(200,$ini_data);
}

?>