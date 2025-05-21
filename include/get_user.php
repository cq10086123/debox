<?php
header('Content-type: text/json;charset=utf-8');
include 'db.class.php';
$user = $_GET['user'];
$res_user = Db::table('user')->where('user',$user)->find();

echo json_encode($res_user);

?>