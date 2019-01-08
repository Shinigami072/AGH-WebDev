<?php
/**
 * Created by PhpStorm.
 * User: shinigami
 * Date: 06/12/18
 * Time: 14:15
 */
$BASE_PATH = ".";

define("WPIS_SEM",1000);
define("KOME_SEM",1001);
define("BLOG_SEM",1002);

//RRRRMMDDGGmmSSUU

function get_name($blogpath,$date)
{
    $seconds = date_format(date_create(), "s");
    $prefix = date_format($date, "YmdHi");

    do {
        $unique = rand(10, 99);
    }while(file_exists("$blogpath/$prefix$seconds$unique"));
    $name = "$prefix$seconds$unique";

    return $name;
}

function get_datetime($time)
{
    return date_create_from_format("Y-m-d H:i", $time);
}

function createInfoFile($path, $user, $password, $desc)
{
//    echo "$path/info";
    $info = fopen("$path/info", "w");
    flock($info,LOCK_EX);
    fwrite($info, "$user\n");
    $password = md5($password);
    fwrite($info, "$password\n");
    fwrite($info, "$desc");
    fclose($info);
    flock($info,LOCK_UN);
}

function readInfo($infoPath, $short = True)
{
    $infoFile = fopen("$infoPath/info", "r");
    flock($infoFile,LOCK_SH);

    $user = rtrim(fgets($infoFile));
    $info["user"] = $user;
    $password = rtrim(fgets($infoFile));
    $info["password"] = $password;
    $desc = "";

    if (!$short) {
        while (false !== ($line = fgets($infoFile))) {
            $desc .= $line;
        }
    }
    $info["desc"] = $desc;
    fclose($infoFile);
    flock($infoFile,LOCK_UN);

    return $info;
}

function fileCount($files)
{
    $file_count = count($files["name"]);
    $j = 0;
    for ($i = 0, $j = 0; $i < $file_count; $i++) {
        if ($files["error"][$i] == 0) {
            $j++;
        }
    }

    return $j;

}

function createPost($path, $name, $data)
{
    $post = fopen("$path/$name", "w");
    flock($post,LOCK_EX);
    fwrite($post, $data["blogentry"]);
    fclose($post);
    flock($post,LOCK_UN);


    setlocale(LC_ALL, 'en_US.UTF-8');
    if ($data["files"] !== null) {
        $file_count = count($data["files"]["name"]);

        for ($i = 0, $j = 0; $i < $file_count; $i++) {
            if ($data["files"]["error"][$i] == 0) {
                $ext = pathinfo($data["files"]["name"][$i], PATHINFO_EXTENSION);
                move_uploaded_file($data["files"]["tmp_name"][$i], "$path/$name$j.$ext");
                $j++;
            }
        }

    }
}

function createComment($commentPath, $reaction, $user, $comment)
{
    mkdir($commentPath);
    $sem = sem_get(KOME_SEM);
    sem_acquire($sem);
    $i = count(glob("$commentPath/*"));

    $commentFile = fopen("$commentPath/$i", "w");
    flock($commentFile,LOCK_EX);

    fwrite($commentFile, "$reaction\n");
    $date = date_format(date_create(), "Y-m-d, H:i:s");;
    fwrite($commentFile, "$date\n");
    fwrite($commentFile, "$user\n");
    fwrite($commentFile, "$comment\n");

    fclose($commentFile);
    flock($commentFile,LOCK_UN);
    sem_release($sem);

}


function getBlog($BASE_PATH, $user, $password)
{

    $dir = opendir($BASE_PATH);
    while (false !== ($blogname = readdir($dir))) {
        if ($blogname == "." or $blogname == "..")
            continue;

        if (is_dir("$BASE_PATH/$blogname")) {
            $info = readInfo("$BASE_PATH/$blogname");
            $pass = $info["password"];
            $usr = $info["user"];
            $a = ($usr === $user) ? "true" : "false";
            $b = ($pass === $password) ? "true" : "false";
//            print_r("$user===$usr $a\n");
//            print_r("$password===$pass $b\n");
            if ($usr === $user and $pass === $password) {
                closedir($dir);
//                echo "\"$BASE_PATH/$blogname\" $a $b";
                return "$BASE_PATH/$blogname";
            }

        }
    }
    closedir($dir);


    return false;
}


function getPost($path, $name)
{
    $data["entry"] = "";
    $post = fopen("$path/$name", "r");
    while (($ext = fgets($post)) !== False)
        $data["entry"] .= $ext;
    fclose($post);
    $data["name"] = $name;
    $data["year"] = substr($name, 0, 4);
    $data["month"] = substr($name, 4, 2);
    $data["day"] = substr($name, 6, 2);
    $data["hour"] = substr($name, 8, 2);
    $data["minute"] = substr($name, 10, 2);
    $data["second"] = substr($name, 12, 2);
    $data["unique"] = substr($name, 14, 2);

    return $data;
}


