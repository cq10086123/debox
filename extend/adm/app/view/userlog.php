<?php
/*
Sort:12
Hidden:false
Name:用户日志
Url:app_userlog
Version:1.0
Author:酷点
Author QQ:3089807626
Author Url:www.eruyi.cn
*/
$id = $_REQUEST["id"];
$appid = $_REQUEST["appid"];
$type = $_REQUEST["type"];

if ($type == 1) {
    $result1 = array();
    $directory  = '../app/records/'.$id;
    $result1 = scandir($directory);
} elseif ($type == 2) {
    $result1 = array();
    $directory  = '../app/records/'.$appid;
    $result1 = scandir($directory);
    $file = '../app/records/'.$appid.'/'.$id;
    $txt = file_get_contents($file);
    $jsonArr = json_decode($txt,true);
} else {
    $result2 = array();
    $directory  = '../app/records';
    $contents = scandir($directory);
    foreach ($contents as $item) {
        if (is_dir("{$directory}/{$item}") && !in_array($item, ['.', '..'])) {
            // echo "文件夹名称: {$item}\n";
            $result2[] = $item;
        }
    }
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .acenter {
            text-align: center
        }
    </style>
    <title>Document</title>
</head>

<body>
    <form action="#" method="post">
 
                <div class="row">
                <div class="colll-xl-4" style="width:300px;">
                        <div class="card">
                            <div class="card-body" id="news">
                                <h4 class="header-title mt-2">分类</h4>
                                <div>
                                    <div class="timeline-alt pb-0" id="news_list">
                                        <?php
                                            if (empty($type)) {
                                                $type = 1;
                                                for ($i=count($result2)-1; $i >= 0; $i--) { 
                                                    // if ($i >= 1) {
                                                        echo '
                                                            <div class="timeline-item">
                                                                <div class="timeline-item-info">
                                                                    <a href="../admin/?app_userlog&id='.$result2[$i].'&type='.$type.'&appid='.$result2[$i].'" class="text-primary font-weight-bold mb-1 d-block" id="readfile">'.$result2[$i].'</a>
                                                                </div>
                                                            </div>
                                                        ';
                                                    // }
                                                    
                                                }
                                            } else {
                                                $type = 2;
                                                for ($i=count($result1)-1; $i >= 0; $i--) { 
                                                    if ($i > 1) {
                                                        echo '
                                                            <div class="timeline-item">
                                                                <div class="timeline-item-info">
                                                                    <a href="../admin/?app_userlog&id='.$result1[$i].'&type='.$type.'&appid='.$appid.'" class="text-primary font-weight-bold mb-1 d-block" id="readfile">'.$result1[$i].'</a>
                                                                </div>
                                                            </div>
                                                        ';
                                                    }
                                                    
                                                }
                                            } 
                                            
                                        
                                        
                                        ?>
                                        
                            
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card-->
                    </div>


                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                            <table id="table1" border="1">
                                <tr>
                                    <th class="acenter" width="80px" height="30px">Ip</th>
                                    <th class="acenter" width="80px" height="30px">Time</th>
                                    <th class="acenter" width="80px" height="30px">Area</th>
                                    <th class="acenter" width="80px" height="30px">Version</th>
                                    <th class="acenter" width="80px" height="30px">Brand</th>
                                    <th class="acenter" width="80px" height="30px">Model</th>
                                    <th class="acenter" width="80px" height="30px">Tv|Mobile</th>
                                    <th class="acenter" width="80px" height="30px">AppId</th>
                                </tr>
                                <?php 
                                    echo "当前总数:".count($jsonArr['list']);
                                    for ($i=count($jsonArr["list"])-1; $i >= 0; $i--) { 
                                        $ip = $jsonArr["list"][$i]["Ip"];
                                        $time = $jsonArr["list"][$i]["Time"];
                                        $Area = $jsonArr["list"][$i]["Area"];
                                        $Version = $jsonArr["list"][$i]["Version"];
                                        $Brand = $jsonArr["list"][$i]["Brand"];
                                        $Model = $jsonArr["list"][$i]["Model"];
                                        $tvMobile = $jsonArr["list"][$i]["tvMobile"];
                                        $AppId = $jsonArr["list"][$i]["AppId"];
                                        echo 
                                            '<tr>
                                                <td class="acenter" width="130px" height="30px" border="0">
                                                    '.$ip.'
                                                </td>
                                                <td class="acenter" width="160px" height="30px" border="0">
                                                    '.$time.'
                                                </td>
                                                <td class="acenter" width="250px" height="30px" border="0">
                                                    '.$Area.'
                                                </td>
                                                <td class="acenter" width="130px" height="30px" border="0">
                                                    '.$Version.'
                                                </td>
                                                <td class="acenter" width="130px" height="30px" border="0">
                                                    '.$Brand.'
                                                </td>
                                                <td class="acenter" width="130px" height="30px" border="0">
                                                    '.$Model.'
                                                </td>
                                                <td class="acenter" width="130px" height="30px" border="0">
                                                    '.$tvMobile.'
                                                </td>
                                                <td class="acenter" width="130px" height="30px" border="0">
                                                    '.$AppId.'
                                                </td>
                                            </tr>';
                                    }

                                   
                                   
                                ?>
                            </table>
                            
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