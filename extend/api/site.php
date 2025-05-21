<?php
/*
Name:获取站点配置
Version:1.0
Author:酷点
Author QQ:3089807626
Author Url:
*/
if (!isset($app_res) or !is_array($app_res)) out(100); //如果需要调用应用配置请先判断是否加载app配置
$ret = [];
$site_res = Db::table('site')->where(['appid' => $appid, 'state' => 'y'])->select(); //获取商品列表
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
		if ($rows['sitejm'] == 1) {
			$sitejm = "http://192.168.2.208/cysht/api.php?act=sitejm.php&id=".$rows['id'];
		} else {
			$sitejm = $rows['api'];
		}
		if ($rows['playerType'] == "IJK") {
			$rows['playerType'] = "1";
		} else if ($rows['playerType'] == "EXO") {
			$rows['playerType'] = "2";
		} else {
			$rows['playerType'] = "1";
		}
		
		$ret[] = [
			'gid' => $rows['id'],
			'gname' => $rows['name'],
			'gtype' => $rows['type'],
			'playerType' => $rows['playerType'],
			'gapiname' => $sitejm,
			'extend' => $rows['extend'],
			'parse' => $rows['parse'],
			'searchable' => $rows['searchable'],
			'quicksearch' => $rows['quicksearch'],
			'filterable' => $rows['filterable'],
			'sitejm' => $rows['sitejm']
		];
	}
	// encryptionout(200, $ret, $app_res);
	out(200, $ret, $app_res);
}
out(201, '自定义接口获取失败', $app_res);
?>