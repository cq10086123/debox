<?php
/*
Name:多仓加密
Version:1.0
Author:酷点
Author QQ:3089807626
Author Url:
*/

if (!isset($app_res) or !is_array($app_res)) out(100); //如果需要调用应用配置请先判断是否加载app配置
$key = explode("|",$app_res["livePass"])[0];
$iv = explode("|",$app_res["livePass"])[1];
$http = strpos(strtolower($_server['server_protocol']),'https')  === false ? 'http' : 'https';
if ($app_res['app_jsonc'] == null || $app_res['app_jsonc'] == "") {
	$app_res['app_jsonc'] = explode("api.php",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0] . "/app/duocang.json";
}
$url = $app_res["app_jsonc"];
$data = gethttps($url);
$jmdata = aes($data,$key,$iv,0);
die($jmdata);
    
?>