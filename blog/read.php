<?php
/**
 * Created by PhpStorm.
 * User: shinigami
 * Date: 13/01/19
 * Time: 15:49
 */
include_once "common.php";

if(isset($_POST["timestamp"]) && strlen($_POST["timestamp"]) && is_int($_POST["timestamp"])){
    $timestamp = intval($_POST["timestamp"]);
}
else{
    $timestamp =0;
}
$dir = opendir("$BASE_PATH/msgs/");
$maxstamp=-1;
while (false !== ($commname= readdir($dir))) {
    if ($commname == "." or $commname == "..")
        continue;

    if (!is_dir("$BASE_PATH/msgs/$commname")) {
       if(intval($commname)>$timestamp){
           if(intval($commname)>$maxstamp){
               $maxstamp=intval($commname);
           }
           echo file_get_contents("$BASE_PATH/msgs/$commname");
       }
    }
}
closedir($dir);