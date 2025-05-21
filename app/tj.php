<?php 
include './IpLocation.php'; 
$version = $_REQUEST["version"];
$brand = $_REQUEST["brand"];
$model = $_REQUEST["model"];
$appid = $_REQUEST["appid"];
$tvMobile = $_REQUEST["tv"];
$ip = GetUserIP();
$iplocation = new IpLocation();     
$location = $iplocation->getlocation($ip);
$folderPath = './records/'.$appid;
if(!is_dir($folderPath)){
    mkdir($folderPath,0777,true);
}
$time = date('Y-m-d H:i:s');
// $txt = 'ip:'.$ip.','.'time:'.$time.',area:'.$location['country'].$location['area'].','.'version:'.$version.','."brand:".$brand.','."model:".$model."\n";
$array_list = array(
    "Ip" => $ip,
    "Time" => $time,
    "Area" => $location['country'].$location['area'],
    "Version" => $version,
    "Brand" => $brand,
    "Model" => $model,
    "tvMobile" => $tvMobile,
    "AppId" => $appid
);
if (!file_exists('./records/'.$appid.'/'.date("Y-m-d").'.txt')) {
    $jsonArr["list"][] = $array_list;
} else {
    $text = file_get_contents('./records/'.$appid.'/'.date("Y-m-d").'.txt');
    $jsonArr = json_decode($text,true);
    $jsonArr["list"][] = $array_list;
}

$json = json_encode($jsonArr,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

echo $json;

file_put_contents('./records/'.$appid.'/'.date("Y-m-d").'.txt',$json);

function GetUserIP(){
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $arr = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
        return $arr[0];
    }else{
        return $_SERVER['REMOTE_ADDR'];
    }
}



function getIpAddress($ip){
    while(true){
        $result = curl_get('http://ip.chinaz.com/'.$ip);
        $result = str_replace(array("\r\n", "\r", "\n"), "", $result);
        preg_match('/<span class="Whwtdhalf w45-0 lh45">[\s\S]*?<em>(.*?)<\/em>/',$result,$matcher);
        if(!empty($matcher[1])){
            return $ip.'('.$matcher[1].')';
            break;
        }
    }
    
}   

function curl_get($url, $timeout = 5)
{
$ch = curl_init();                                                      //初始化 curl
curl_setopt($ch, CURLOPT_URL, $url);                                    //要访问网页 URL 地址
curl_setopt($ch, CURLOPT_NOBODY, false);                                //设定是否输出页面内容
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                         //返回字符串，而非直接输出到屏幕上
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, false);                        //连接超时时间，设置为 0，则无限等待
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);                            //数据传输的最大允许时间超时,设为一小时
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);                       //HTTP验证方法
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                        //不检查 SSL 证书来源
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);                        //不检查 证书中 SSL 加密算法是否存在
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);                         //跟踪爬取重定向页面
curl_setopt($ch, CURLOPT_AUTOREFERER, true);                            //当Location:重定向时，自动设置header中的Referer:信息
curl_setopt($ch, CURLOPT_ENCODING, '');                                 //解决网页乱码问题
curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

$httpheaders = array();
$httpheaders[] = "CLIENT-IP: {$_SERVER['HTTP_CLIENT_IP']}";
$httpheaders[] = "X-FORWARDED-FOR: {$_SERVER['HTTP_X_FORWARDED_FOR']}";
curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheaders);

$data = curl_exec($ch);                                                 //运行 curl，请求网页并返回结果
$str = htmlspecialchars($data);
curl_close($ch);                                                        //关闭 curl
return $data;
}
?>
