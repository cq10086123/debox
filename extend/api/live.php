<?php
/*
Name:直播加密
Version:1.0
Author:酷点
Author QQ:3089807626
Author Url:
*/
if (!isset($app_res) or !is_array($app_res)) out(100); //如果需要调用应用配置请先判断是否加载app配置
$url = $app_res["liveUrl"];
$pass = explode("|",$app_res['livePass']);
$key = $pass[0];
$iv = $pass[1];
$data = gethttps($url);
// $jmdata = base64_encode(openssl_encrypt($data,"AES-128-CBC",$key,OPENSSL_RAW_DATA, $iv));
$jmdata = aes($data,$key,$iv,3);
echo $jmdata;




?>