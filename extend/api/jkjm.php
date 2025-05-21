<?php
/*
Name:站点加密
Version:1.0
Author:酷点
Author QQ:3089807626
Author Url:
*/

if (!isset($app_res) or !is_array($app_res)) out(100); //如果需要调用应用配置请先判断是否加载app配置
$type = $_REQUEST['type'];
$id = $_REQUEST['id'];
if ($type == "dcjm") {
    $exten_res = Db::table('app_duocang')->where('appid', $appid)->order('id desc')->select();
    $id = $_REQUEST['id'];
    $key = explode("|",$app_res["livePass"])[0];
    $iv = explode("|",$app_res["livePass"])[1];
    if (is_array($exten_res)) {
        foreach ($exten_res as $k => $v) {
            $rows = $exten_res[$k];
            if ($rows['id'] == $id) {
                $data = gethttps($rows['url']);
                $jmdata = aes($data,$key,$iv,0);
                die($jmdata);
            }
        }
    }
} elseif ($type == "zbjm") {
    $exten_res = Db::table('app_zb')->where('appid', $appid)->order('id desc')->select();
    $id = $_REQUEST['id'];
    $key = explode("|",$app_res["livePass"])[0];
    $iv = explode("|",$app_res["livePass"])[1];
    if (is_array($exten_res)) {
        foreach ($exten_res as $k => $v) {
            $rows = $exten_res[$k];
            if ($rows['id'] == $id) {
                $data = gethttps($rows['url']);
                $jmdata = aes($data,$key,$iv,0);
                die($jmdata);
            }
        }
    }

} else {
    $http = strpos(strtolower($_server['server_protocol']),'https')  === false ? 'http' : 'https';
    if ($app_res['app_json'] == null || $app_res['app_json'] == "") {
        $app_res['app_json'] = explode("api.php",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0] . "/app/api.json";
    }
    $url = $app_res["app_json"];
    $key = explode("|",$app_res["livePass"])[0];
    $iv = explode("|",$app_res["livePass"])[1];
    $data = gethttps($url);
    $jmdata = aes($data,$key,$iv,0);
    die($jmdata);
}



?>