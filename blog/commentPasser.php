<?php
include_once("common.php");
$blogname = $_GET["blogname"];
$entry = $_GET["entry"];
$file = "$BASE_PATH/".htmlspecialchars_decode($blogname)."/".htmlspecialchars_decode($entry);
if (file_exists($file)) {
    setcookie("blogname", "$blogname",time()+360);
    setcookie("entry", "$entry.k",time()+360);
    header("Location: createKomentarz.php");
}