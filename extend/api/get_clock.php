<?php
/*
Name:验证会员
Version:1.0
Author:绿豆屋
Author QQ:3178156778
Author Url:www.lvdoui.net
*/
if (!isset($app_res) or !is_array($app_res)) out(100); //如果需要调用应用配置请先判断是否加载app配置
if ($app_res['logon_way'] == 1) out(164, $app_res); //不是账号登录模式不允许使用当前操作
$token = isset($data_arr['token']) && !empty($data_arr['token']) ? purge($data_arr['token']) : out(125, $app_res); //请输TOKEN
$res_logon = Db::table('user_logon', 'as logon')->field('U.*')->JOIN('user', 'as U', 'logon.uid=U.id')->where('logon.appid', $appid)->where('U.appid', $appid)->where('logon.token', $token)->find(); //false
if (!$res_logon) out(127, $app_res); //TOKEN不存在或已失效
if ($res_logon['ban'] > time() || $res_logon['ban'] == 999999999) out(114, $res_logon['ban_notice'], $app_res); //账号被禁用
if ($app_res['diary_award_num'] == 0) out(146, $app_res); //签到功能未启用
$res = Db::table('log')->where(['uid' => $res_logon['id'], 'type' => $act])->where('time', 'between', [timeRange('t_a'), timeRange('t_b')])->find();
if ($res) out(201, '今天已经签到过了', $app_res); //今天已经签到过了

// 判断签到逻辑，根据不同的签到奖励类型返回不同的结果
if ($app_res['diary_award'] == 'vip') {
	if ($res_logon['vip'] == '999999999') out(199, $app_res);
	if ($res_logon['vip'] > time()) {
		$vip = $res_logon['vip'] + 3600 * $res_fen['vip_num'];
	} else {
		$vip = time() + 3600 * $res_fen['vip_num'];
	}

	out(200, '今天还没签到', $app_res);
} elseif ($app_res['diary_award'] == 'fen') {
	$fen = $res_logon['fen'] + $app_res['diary_award_num'];

	out(200, '今天还没签到', $app_res);
}
?>