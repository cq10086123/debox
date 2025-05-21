<?php
/*
Name:获取屏保配置
Version:1.0
Author:绿豆屋
Author QQ:3178156778
Author Url:www.lvdoui.net
*/
if (!isset($app_res) or !is_array($app_res)) out(100); //如果需要调用应用配置请先判断是否加载app配置
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
	encryptionout(200, $app_level, $app_res);
}
out(201, '自定义接口获取失败', $app_res);
?>