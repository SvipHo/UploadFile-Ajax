<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 2015/12/7
 * Time: 22:10
 */
$res["error"] = "";//错误信息
$res["msg"] = "";//提示信息
if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'],'./upload/'.$_FILES['fileToUpload']['name'])){
    $res["msg"] = "img src=./upload/{$_FILES['fileToUpload']['name']}";
}else{
    $res["error"] = "error";
}
echo json_encode($res);