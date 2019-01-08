<?php
include_once "common.php";

$user = $_POST["user"];
$password = $_POST["password"];
$blogPath = getBlog($BASE_PATH,$user,md5($password));
$date = $_POST["date"];
$time = $_POST["time"];

$data["blogentry"]=$_POST["blogentry"];
$data["files"]=$_FILES["files"];

if(

                isset($user)and mb_strlen($user)>0 and
                isset($password)and mb_strlen($password)>0and
                ($blogPath!==False) and
                isset($date) and
                isset($time) and
                isset($data["blogentry"]) and
                (fileCount($data["files"])<=3)and
                mb_ereg_match("[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}","$date $time")



){
    $sem = sem_get(WPIS_SEM);
    sem_acquire($sem);
    createPost($blogPath,get_name($blogPath,get_datetime("$date $time")),$data);
    sem_release($sem);
    $blogname=basename($blogPath);
    header("Location: blog.php?nazwa=$blogname");
    return;
}

else{
            $err="";
            if(!isset($_POST["password"]) or mb_strlen($password)>0) {
                $err = "nie podano hasła";
            }elseif(!isset($_POST["user"]) or mb_strlen($user)>0){
                $err = "nie podano nazwy użytkownika";
            }elseif($blogPath===False){
                $err = "nie ma odpowiadającego bloga";
            }elseif(!mb_ereg_match("[0-9]{4}-[0-9]{2}-[0-9]{2}","$date")){
                $err = "niepoprawny format daty";
            }elseif(!mb_ereg_match("[0-9]{2}:[0-9]{2}","$time")){
                $err = "niepoprawny format godziny";
            }elseif(fileCount($data["files"])>3){
                $err = "za dużo plików - maksymalnie 3";
            }

            $blogentry=$data["blogentry"];
            header("Location: createWpis.php?err=$err&user=$user&blogentry=$blogentry");//todo errors

}
?>
