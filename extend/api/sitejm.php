<?php
/*
Name:站点加密
Version:1.0
Author:酷点
Author QQ:3089807626
Author Url:
*/

if (!isset($app_res) or !is_array($app_res)) out(100); //如果需要调用应用配置请先判断是否加载app配置
$id = $_REQUEST['id'];
$site_res = Db::table('site')->where('appid', $appid)->order('id desc')->select();
$key = explode("|",$app_res["livePass"])[0];
$iv = explode("|",$app_res["livePass"])[1];
if (is_array($site_res)) {
	foreach ($site_res as $k => $v) {
		$rows = $site_res[$k];
        if ($rows['id'] == $id) {
            $url = $rows['api'];
            $data = gethttps($url);
            $jmdata = aes($data,$key,$iv,0);
            die($data);
        }
    }
}
?>