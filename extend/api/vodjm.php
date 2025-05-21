<?php
/*
Name:站点加密
Version:1.0
Author:酷点
Author QQ:3089807626
Author Url:
*/
include_once "../../include/db.config.php";
// echo DB_USER;
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
// 检测连接
if ($conn->connect_error) {
	die("连接失败: " . $conn->connect_error);
}
$appid = $_REQUEST['app'];
$id = $_REQUEST['id'];
$ac = $_REQUEST['ac'];
$ids = $_REQUEST['ids'];
$wd = $_REQUEST['wd'];
$t = $_REQUEST['t'];
$pg = $_REQUEST['pg'];
$h = $_REQUEST['h'];

$table = "eruyi_app";
$sql = "SELECT * FROM $table";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row["id"] == $appid) {
            $livepass = $row["livePass"];
        }
    }
}
$key = explode("|",$livepass)[0];
$iv = explode("|",$livepass)[1];

$table1 = "eruyi_site";
$sql1 = "SELECT * FROM $table1";
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    while($row = $result1->fetch_assoc()) {
		$arr[] = $row;
    }
}
//关闭连接
$conn->close();
// print_r($key);
for ($i=0; $i < count($arr); $i++) { 
	// print_r($arr[$i]['id']);
	if ($arr[$i]['id'] == $id && $arr[$i]["appid"] == $appid) {           
		// echo $arr[$i]['api'].'?ac='.$ac.'&t='.$t.'&pg='.$pg.'&h='.$h.'&ids='.$ids.'&wd='.$wd;
		$api = str_replace("?ac=list","",$arr[$i]['api']);
		// echo $api;
		$data = curl_get($api.'?ac='.$ac.'&t='.$t.'&pg='.$pg.'&h='.$h.'&ids='.$ids.'&wd='.$wd);
		// echo $data;
		$jmdata = aes($data,$key,$iv,0);
		die($jmdata);
	}
}
// $exten_res = Db::table('site')->where('appid', $appid)->order('id desc')->select();


// if (is_array($exten_res)) {
//     foreach ($exten_res as $k => $v) {
//         $rows = $exten_res[$k];
//         if ($rows['id'] == $id) {           
//             // echo $rows['api'].'?ac='.$ac.'&t='.$t.'&pg='.$pg.'&h='.$h.'&ids='.$ids.'&wd='.$wd;
//             $api = str_replace("?ac=list","",$rows['api']);
//             $data = gethttps($api.'?ac='.$ac.'&t='.$t.'&pg='.$pg.'&h='.$h.'&ids='.$ids.'&wd='.$wd);
//             $jmdata = aes($data,$key,$iv,0);
//             die($jmdata);
//         }
//     }
// }
function aes($code,$key,$iv,$mode){   //$mode 为0 加密   1为解密 2为不加密  $pwd 为密码   $code为需要加解密的文本
	if ($mode == 0) {
		return base64_encode(openssl_encrypt($code,"AES-128-CBC",$key,OPENSSL_RAW_DATA, $iv)); 
	} elseif ($mode == 1) {
		return openssl_decrypt(base64_decode($code),"AES-128-CBC",$key,OPENSSL_RAW_DATA, $iv);
	} else {
		return $code;
	}
}
function curl_get($url, $ua = 'p', $timeout = 10, $referer = '', $cookie = '',$headers = '')
{
    $ch = curl_init();                                                      //初始化 curl
    curl_setopt($ch, CURLOPT_URL, $url);                                    //要访问网页 URL 地址
    curl_setopt($ch, CURLOPT_NOBODY, false);                                //设定是否输出页面内容
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                         //返回字符串，而非直接输出到屏幕上
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);                        //连接超时时间，设置为 0，则无限等待
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);                            //数据传输的最大允许时间超时,设为一小时
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);                       //HTTP验证方法
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                        //不检查 SSL 证书来源
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);                        //不检查 证书中 SSL 加密算法是否存在
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);                         //跟踪爬取重定向页面
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);                            //当Location:重定向时，自动设置header中的Referer:信息
    curl_setopt($ch, CURLOPT_ENCODING, '');                                 //解决网页乱码问题
    curl_setopt($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch, CURLOPT_COOKIE , $cookie);
//    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
    if ($ua == 'a'){
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36');
    } elseif ($ua == 'p'){
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36');
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    }
    // $httpheaders = array();
    // $httpheaders[] = "CLIENT-IP: {$_SERVER['HTTP_CLIENT_IP']}";
    // $httpheaders[] = "X-FORWARDED-FOR: {$_SERVER['HTTP_X_FORWARDED_FOR']}";
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheaders);
    $data = curl_exec($ch);                                                 //运行 curl，请求网页并返回结果
    curl_close($ch);                                                        //关闭 curl
    return $data;
}

?>