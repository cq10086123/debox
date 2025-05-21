<?php
/*
Sort:11
Hidden:false
Name:接口编辑
Url:app_jkgl
Version:1.0
Author:易如意
Author QQ:51154393
Author Url:www.eruyi.cn
*/
$id = $_REQUEST['id'];
$txt = $_REQUEST['add_content'];
if (strstr($txt,"storeHouse")) {
    unlink("../app/duocang.json");
    if (file_put_contents("../app/duocang.json", $txt) !== false) {
        echo "文件保存成功！";
    } else {
        echo "文件保存失败！";
    }
} elseif (strstr($txt,"\"sites\"")) {
    unlink("../app/api.json");
    if (file_put_contents("../app/api.json", $txt) !== false) {
        echo "文件保存成功！";
    } else {
        echo "文件保存失败！";
    }
} elseif (strstr($txt,"#genre#")) {
    unlink("../app/live.txt");
    if (file_put_contents("../app/live.txt", $txt) !== false) {
        echo "文件保存成功！";
    } else {
        echo "文件保存失败！";
    }
}
if ($id == 1) {
    $filename = "../app/api.json"; // 要读取的文件路径
    $contents = file_get_contents($filename); // 读取文件内容
} elseif ($id == 2) {
    $filename = "../app/duocang.json"; // 要读取的文件路径
    $contents = file_get_contents($filename); // 读取文件内容
} elseif ($id == 3) {
    $filename = "../app/live.txt"; // 要读取的文件路径
    $contents = file_get_contents($filename); // 读取文件内容
} else {
    $contents = "";
}
// echo $contents;




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .jianju {
            margin-left: 10px;
            display: inline-block;
            font-weight: 400;
            color: #FFFFFF;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: #727CF5;;
            border: 1px solid transparent;
            padding: .45rem .9rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .15rem;
            -webkit-transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out
        }
        .col-xl-81 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 66.66667%;
            flex: 0 0 66.66667%;
            max-width: 100%
        }
        .colll-xl-4 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 33.33333%;
            flex: 0 0 33.33333%;
            max-width: 20.33333%
        }
        .aleft {
            float: left;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <form action="#" method="post">
                默认接口路径:/app/api.json  默认多仓路径:/app/duocang.json 默认直播路径:/app/live.txt 如果不是这个路径的文件请不要在这里修改
        <div class="col-lg-4">
            <div class="text-lg-right">
                <div class="input-group">  
                    <div class="input-group-append">
                        <button class="btn-primary jianju" type="submit" name="save" value="save">保存</button>
                        
                    </div>
                </div>
            </div>
        </div>
        <ol class="breadcrumb m-0">

        </ol>
 
                <div class="row">
                <div class="colll-xl-4" style="width:60px;">
                        <div class="card">
                            <div class="card-body" id="news">
                                <h4 class="header-title mt-2">分类</h4>
                                <div>
                                    <div class="timeline-alt pb-0" id="news_list">
                                        
                                        <div class="timeline-item">
                                            <div class="timeline-item-info">
                                                <a href="../admin/?app_jkgl&id=1" class="text-primary font-weight-bold mb-1 d-block" id="readfile">默认接口编辑</a>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-item-info">
                                                <a href="../admin/?app_jkgl&id=2" class="text-primary font-weight-bold mb-1 d-block">默认多仓编辑</a>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-item-info">
                                                <a href="../admin/?app_jkgl&id=3" class="text-primary font-weight-bold mb-1 d-block">默认直播编辑</a>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card-->
                    </div>


                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                            <textarea class="form-control form-control-light mb-2" placeholder="管理内容" id="add_content" name="add_content" rows="25"><?php echo $contents;?></textarea>
                            
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                    
                </div>
                <!-- end row-->







    </form>
    <script>
        
    </script>
</body>

</html>