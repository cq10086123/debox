<?php
/*
Name:支付
Version:1.0
Author:绿豆屋
Author QQ:3178156778
Author Url:www.lvdoui.net
*/

if (!isset($app_res) or !is_array($app_res)) out(100); //如果需要调用应用配置请先判断是否加载app配置
if ($app_res['logon_way'] == 1) out(164, $app_res); //不是账号登录方式不允许使用当前操作
$ua = isset($data_arr['ua']) && !empty($data_arr['ua']) ? intval($data_arr['ua']) : 0; //0=pc(电脑扫码),1=H5(手机唤起),2=如意支付
$order = isset($data_arr['order']) && !empty($data_arr['order']) ? purge($data_arr['order']) : return_code(130, $app_res, $ua); //订单号为空
$user = isset($data_arr['account']) ? purge($data_arr['account']) : ''; //请输入账号
$token = isset($data_arr['token']) ? purge($data_arr['token']) : ''; //请输TOKEN
$way = isset($data_arr['way']) && !empty($data_arr['way']) ? purge($data_arr['way']) : return_code(131, $app_res, $ua); //支付方式
$gid = isset($data_arr['gid']) && !empty($data_arr['gid']) ? purge($data_arr['gid']) : return_code(132, $app_res, $ua); //商品ID
$res_goods_order = Db::table('goods_order')->where(['`order`' => $order])->find(); //false
if ($res_goods_order) return_code(168, $app_res, $ua); //订单已存在
if ($app_res['pay_state'] == 'n' or empty($app_res['pay_url']) or empty($app_res['pay_id']) or empty($app_res['pay_key'])) return_code(133, $app_res, $ua); //判断是否可支付
if (empty($app_res['pay_notify'])) return_code(134, $app_res, $ua); //没有设置异步通知地址
if ($way == 'ali' && $app_res['pay_ali_state'] == 'n') return_code(135, $app_res, $ua); //不支持该支付方式
if ($way == 'wx' && $app_res['pay_wx_state'] == 'n') return_code(135, $app_res, $ua); //不支持该支付方式
if ($way == 'qq' && $app_res['pay_qq_state'] == 'n') return_code(135, $app_res, $ua); //不支持该支付方式
$res_goods = Db::table('goods')->where(['id' => $gid, 'appid' => $appid])->find(); //false
if (!$res_goods) return_code(136, $app_res, $ua); //商品不存在
if (!empty($user)) {
	$res_user = Db::table('user')->where(['appid' => $appid], "(", ")")->where('(user', $user)->whereOr(['email' => $user, 'phone' => $user], ")")->find(); //false
	if (!$res_user) return_code(122, $app_res, $ua); //账号不存在
	if ($res_user['ban'] > time() || $res_user['ban'] == 999999999) return_code(114, $app_res, $ua, $res_user['ban_notice']); //账号被禁用
} elseif (!empty($token)) {
	$res_logon = Db::table('user_logon', 'as logon')->field('U.*')->JOIN('user', 'as U', 'logon.uid=U.id')->where('U.appid', $appid)->where('logon.token', $token)->find(); //false
	if (!$res_logon) out(127, $app_res); //TOKEN不存在或已失效
	if ($res_logon['ban'] > time() || $res_logon['ban'] == 999999999) return_code(114, $app_res, $ua, $res_logon['ban_notice']); //账号被禁用
	$res_user['id'] = $res_logon['id'];
} else {
	return_code(110, $app_res, $ua);
}
if (defined('USER_LOG') && USER_LOG == 1) {
	Db::table('log')->add(['uid' => $res_user['id'], 'type' => $act, 'status' => 200, 'time' => time(), 'ip' => getip(), 'appid' => $appid]);
} //记录日志
$o_info = 'money=' . $res_goods['money'] . '&name=' . $res_goods['name'] . '&notify_url=' . $app_res['pay_notify'] . '&out_trade_no=' . $order . '&pid=' . $app_res['pay_id'] . '&return_url=' . WEB_URL . '/order.php&sitename=' . $app_res['name'] . '&type=' . $way . 'pay';

$sign = md5Sign($o_info, $app_res['pay_key']);

$add_res = Db::table('goods_order')->add(['order' => $order, 'uid' => $res_user['id'], 'gid' => $gid, 'name' => $res_goods['name'], 'money' => $res_goods['money'], 'o_time' => time(), 'p_type' => $way]); //订单入库
if (!$add_res) return_code(137, $app_res, $ua); //订单入库失败

$data = $o_info . '&sign=' . $sign . '&sign_type=MD5';

if ($app_res['pay_url'])
	if (strstr($app_res['pay_url'], 'submit.php')) {
		$pay_url = $app_res['pay_url'];
	} else {
		$pay_url = $app_res['pay_url'] . '/submit.php';
	}
	
//二维码生成
//$payurl='https://api.isoyu.com/qr/?m=0&e=L&p=5&url= '.urlencode($pay_url."?".$data);
//echo "<img src='" . $payurl . "' align='center' />";

$payurl=$pay_url."?".$data;
echo "<script>location.href='" . $payurl . "';</script>";


/**
 * 发送HTTP请求方法
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @param  array $header 请求头
 * @param  bool $multi 是否传输文件
 * @return array  $data   响应数据
 */
function http($url, $params, $method = 'POST', $multi = false){
    $headers = array();

$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.87 Safari/537.36";

$headers[] = "Content-Type:application/json";
    $opts = array(
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER     => $headers
    );
    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)){
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $params = $multi ? $params : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if($error) throw new Exception('请求发生错误：' . $error);
    return  $data;
}
function return_code($code, $app, $ua, $msg = '')
{
	if ($ua == 2) {
		echo "<script>location.href='?code=" . $code . "';</script>";
		return;
	} else {
		out($code, $msg, $app);
	}
}
function md5Sign($prestr, $key)
{
	$prestr = $prestr . $key;
	return md5($prestr);
}
?>