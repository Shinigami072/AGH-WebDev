<?php
include_once "common.php";


$blogname = $_POST["blogname"];
$blogdesc = $_POST["blogdesc"];
$user = $_POST["user"];
$password = $_POST["password"];
$sem = sem_get(BLOG_SEM);
sem_acquire($sem);
$blogPath = getBlog($BASE_PATH,$user,md5($password)) !==false;
//echo $blogPath ? "true":"false";
if ((isset($_POST["password"]) and
    isset($_POST["user"]) and mb_strlen($user)>0 and
    isset($_POST["blogname"]) and mb_strlen($blogname)>0 and
    !mb_ereg_match("[/*]",$blogname)and
    isset($_POST["blogdesc"]) and
    !$blogPath and
    !file_exists("$BASE_PATH/$blogname")
)) {

    if (mkdir("$BASE_PATH/$blogname")) {
        createInfoFile("$BASE_PATH/$blogname", $user, $password, $blogdesc);
        header("Location: blog.php?nazwa=$blogname");
        sem_release($sem);
        return;
    }
    sem_release($sem);

}
else{
    sem_release($sem);

    if(!isset($_POST["password"])) {
        $err = "nie podano hasła";
    }elseif(!isset($_POST["user"])  or mb_strlen($user)<=0){
        $err = "nie podano nazwy użytkownika";
    }elseif(!isset($_POST["blogname"]) or mb_strlen($blogname)<=0){
        $err = "nie podano nazwy bloga";
    }elseif(mb_ereg_match("[/*]",$blogname)){
        $err = "niepoprawna nazwa bloga";
    }elseif(!isset($_POST["blogdesc"])){
        $err = "nie podano opisu bloga";
    }elseif($blogPath){
        $err = "podany użytkownik posiada już blog";
    }elseif(file_exists("$BASE_PATH/$blogname")){
        $err = "podany blog już istnieje";
    }

    $blogdesc=htmlspecialchars($blogdesc);
    $blogname=htmlspecialchars($blogname);
    $user=htmlspecialchars($user);
    $err=htmlspecialchars($err);

    header("Location: createBlog.php?err=$err&user=$user&blogname=$blogname&blogdesc=$blogdesc");//todo: error-handling
}



?>
