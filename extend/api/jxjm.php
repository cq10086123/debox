<?php
/*
Name:解析加密
Version:1.0
Author:酷点
Author QQ:3089807626
Author Url:
*/

if (!isset($app_res) or !is_array($app_res)) out(100); //如果需要调用应用配置请先判断是否加载app配置
$exten_res = Db::table('app_exten')->where('appid', $appid)->order('id desc')->select();
$id = $_REQUEST['id'];
$url = $_REQUEST['url']; 
$key = explode("|",$app_res["livePass"])[0];
$iv = explode("|",$app_res["livePass"])[1];
if (is_array($exten_res)) {
	foreach ($exten_res as $k => $v) {
		$rows = $exten_res[$k];
        if ($rows['id'] == $id) {
            $data = gethttps($rows['api'].$url);
            $jmdata = aes($data,$key,$iv,0);
            die($jmdata);
        }
    }
}


?>