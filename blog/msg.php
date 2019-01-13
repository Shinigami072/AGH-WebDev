<?php
/**
 * Created by PhpStorm.
 * User: shinigami
 * Date: 13/01/19
 * Time: 12:27
 */
include_once "common.php";

if(isset($_POST["username"]) && strlen($_POST["username"]) && isset($_POST["msg"])){
    $d = date_create();
    $username = $_POST["username"];
    $msg = $_POST["msg"];
    mkdir("$BASE_PATH/msgs/");
    $file = fopen("$BASE_PATH/msgs/".date_timestamp_get($d),"a");
    flock($file,LOCK_EX);
    fwrite($file,"$username : $msg\n");
    fclose($file);
    flock($file,LOCK_UN);
    header("Status: 200 OK");
}else{
    header("status: 403 Frobidden");
    print_r($_POST);
}