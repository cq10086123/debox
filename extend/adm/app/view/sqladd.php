<?php
/*
Sort:13
Hidden:false
Name:数据库管理
Url:app_sqladd
Version:1.0
Author:酷点
Author QQ:3089807626
Author Url:www.eruyi.cn
*/
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
// 检测连接
if ($conn->connect_error) {
	die("连接失败: " . $conn->connect_error);
}
$projectTable = $_REQUEST['projectTable'];
$projectNote = $_REQUEST['projectNote'];
$projectContent = $_REQUEST['projectContent'];
$projectType = $_REQUEST['projectType'];
$projectLength = $_REQUEST['projectLength'];
$projectdefault = $_REQUEST['projectdefault']; 
$appid = $_REQUEST['appid'];
if (!empty($projectTable) && !empty($projectNote) && !empty($projectType) && !empty($projectLength)) {
    creat_field($projectTable,$projectNote,$projectContent,$projectType,$projectLength,$projectdefault);
} else {
    // echo "请填写完整在提交";
}


function creat_field($projectTable,$projectNote,$projectContent,$projectType,$projectLength,$projectdefault) {
    global $conn;
    $sql = "DESC `$projectTable` `$projectNote`";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "字段已存在";

    } else {
        // echo "字段不存在";
        if (empty($projectLength)) {
            $projectLength = 255;
        }
        // if (empty($after)) {
        //     $sql = "ALTER TABLE `$projectTable` ADD `$projectNote` TEXT($projectLength) COMMENT '$projectContent'";
        // } else {
        //     $sql = "ALTER TABLE `$projectTable` ADD `$projectNote` TEXT($projectLength) COMMENT '$projectContent' AFTER `$after`";
        // }
        // $sql = "ALTER TABLE `app_config` ADD `hyz` varchar(100) DEFAULT '' AFTER `id`";
        $sql = "ALTER TABLE `$projectTable` ADD `$projectNote` $projectType($projectLength) COMMENT '$projectContent' DEFAULT '$projectdefault'";
        if ($conn->query($sql) === TRUE) {
            // echo '成功';
            // header("refresh:1;url='{$_SERVER['HTTP_REFERER']}'");
            print('添加成功');
        } else {
            echo "添加失败";
        }
    }
    

}
//关闭连接
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        
    </style>
    <title>Document</title>
</head>

<body>
    <form action="#" method="post"> 
        <div class="form-group col-md-12">
            <label>数据表名称【如:eruyi_app, 一定要写全名】</label>
            <div class="input-group">
                <input id="projectTable" name="projectTable" type="text" class="form-control" placeholder="如:eruyi_app" value="">
            </div>
        </div>
        <div class="form-group col-md-12">
            <label>字段名称</label>
            <div class="input-group">
                <input id="projectNote" name="projectNote" type="text" class="form-control" placeholder="" value="">
            </div>
        </div>
        <div class="form-group col-md-12">
            <label>字段注释</label>
            <div class="input-group">
                <input id="projectContent" name="projectContent" type="text" class="form-control" placeholder="" value="">
            </div>
        </div>
        <div class="form-group col-md-12">
            <label>字段类型</label>
            <div class="input-group">
                <input id="projectType" name="projectType" type="text" class="form-control" placeholder="" value="varchar">
            </div>
        </div>
        <div class="form-group col-md-12">
            <label>字段长度</label>
            <div class="input-group">
                <input id="projectLength" name="projectLength" type="text" class="form-control" placeholder="" value="255">
            </div>
        </div>
        <div class="form-group col-md-12">
            <label>默认值</label>
            <div class="input-group">
                <input id="projectdefault" name="projectdefault" type="text" class="form-control" placeholder="" value="">
            </div>
        </div>
        <div class="form-group col-md-12">
            
            <div class="input-group">
                <button type="submit" class="btn btn-block btn-primary" name="submit" id="submit" value="确认">提交</button>
            </div>
        </div>
        
    </form>

    
    <script>
        
    </script>
</body>

</html>
