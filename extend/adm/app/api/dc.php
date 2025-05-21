<?php
/*
Name:仓库配置API
Version:1.0
Author:易如意
Author QQ:51154393
Author Url:www.eruyi.cn
*/
if (!isset($islogin)) header("Location: /"); //非法访问
if ($act == 'add') { //添加配置
	$url = isset($_POST['url']) ? purge($_POST['url']) : '';
	$name = isset($_POST['name']) ? purge($_POST['name']) : '';
	$status = isset($_POST['status']) ? purge($_POST['status']) : 'y';
	$status_dcjm = isset($_POST['status_dcjm']) ? purge($_POST['status_dcjm']) : 'y';
	$appid = isset($_POST['appid']) ? purge($_POST['appid']) : '10000';
	if ($url == '') json(201, '链接为空');
	if ($name == '') json(201, '名称为空');
	if ($appid == '') json(201, 'appid为空');
	$duocang_res = Db::table('app_duocang')->where(['name' => $name])->find();
	if ($duocang_res) json(201, '接口名已存在，换个名字吧');
	$add_res = Db::table('app_duocang')->add(['url' => $url, 'name' => $name,'status' => $status,'status_dcjm' => $status_dcjm,'appid' => $appid]);
	if ($add_res) {
		if (defined('ADM_LOG') && ADM_LOG == 1) {
			Db::table('log')->add(['group' => 'adm', 'type' => 'app_duocang_add', 'status' => 200, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
		} //记录日志
		json(200, '添加成功');
	} else {
		if (defined('ADM_LOG') && ADM_LOG == 1) {
			Db::table('log')->add(['group' => 'adm', 'type' => 'app_duocang_add', 'status' => 201, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
		} //记录日志
		json(201, '添加失败');
	}
}
if ($act == 'edit') { //编辑配置
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$update['url'] = isset($_POST['url']) ? purge($_POST['url']) : '';
	$update['name'] = isset($_POST['name']) ? purge($_POST['name']) : '';
	$update['status'] = isset($_POST['status']) ? purge($_POST['status']) : 'n';
	$update['status_dcjm'] = isset($_POST['status_dcjm']) ? purge($_POST['status_dcjm']) : 'n';
	$update['appid'] = isset($_POST['appid']) ? purge($_POST['appid']) : '10000';
	if ($update['url'] == '') json(201, '链接为空');
	if ($update['name'] == '') json(201, '名称为空');
	if ($update['appid'] == '') json(201, 'appid为空');
	/*$duocang_res = Db::table('duocang')->where(['name' => $update['name']])->find();
	if ($duocang_res) {
		if ($exten_res['id'] != $id) json(201, '接口名已存在');
	}*/
	$res = Db::table('app_duocang')->where('id', $id)->update($update);
	//die($res); 
	if ($res) {
		if (defined('ADM_LOG') && ADM_LOG == 1) {
			Db::table('log')->add(['group' => 'adm', 'type' => 'app_duocang_edit', 'status' => 200, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
		} //记录日志
		json(200, '编辑成功');
	} else {
		if (defined('ADM_LOG') && ADM_LOG == 1) {
			Db::table('log')->add(['group' => 'adm', 'type' => 'app_duocang_edit', 'status' => 201, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
		} //记录日志
		json(201, '编辑失败');
	}
}
if ($act == 'del') { //删除配置
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if ($id) {
		$ids = '';
		foreach ($id as $value) {
			$ids .= intval($value) . ",";
		}
		$ids = rtrim($ids, ",");
		$res = Db::table('app_duocang')->where('id', 'in', '(' . $ids . ')')->del(); //false
		//die($res);
		if ($res) {
			if (defined('ADM_LOG') && ADM_LOG == 1) {
				Db::table('log')->add(['group' => 'adm', 'type' => 'app_duocang_del', 'status' => 200, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
			} //记录日志
			json(200, '删除成功');
		} else {
			if (defined('ADM_LOG') && ADM_LOG == 1) {
				Db::table('log')->add(['group' => 'adm', 'type' => 'app_duocang_del', 'status' => 201, 'time' => time(), 'ip' => getip(), 'data' => json_encode($_POST)]);
			} //记录日志
			json(201, '删除失败');
		}
	} else {
		json(201, '没有需要删除的数据');
	}
}
?>