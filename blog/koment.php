<?php
header("content-type:application/xhtml+xml; charset =utf-8", "application/xhtml+xml; charset =utf-8");

include_once "common.php";

//$user = $_POST["user"];
//$password = $_POST["password"];
//$blogPath = getBlog($BASE_PATH,$user,md5($password));
//$date = $_POST["date"];
//$time = $_POST["time"];
//
//$data["blogentry"]=$_POST["blogentry"];
//$data["files"]=$_FILES["files"];

//if(
//        !(
//                isset($user)and
//                isset($password)and
//                ($blogPath!==False) and
//                isset($date) and
//                isset($time) and
//                isset($data["blogentry"]) and
//                (fileCount($data["files"])<4)and
//                mb_ereg_match("[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}","$date $time")
//        )
//){
//
//}
//label><br/>
//    <select name="reaction" id="reaction">
//        <option selected="selected" label="Pozytywna">Pozytywna</option>
//        <option label="Neutralna">Neutralna</option>
//        <option label="Negatywna">Negatywna</option>
//    </select>
//    <label for="commententry">Treść:</label><br/>
//    <textarea name="commententry" id="commententry" cols="80" rows="10"/><br/>
//    <label for="user">Nazwa Użytkownika:</label><br/>
//    <input name="user" id="user" t

$user = $_POST["user"];
$comment = $_POST["commententry"];
$reaction = $_POST["reaction"];
if (!(isset($user) and mb_strlen($user)>0 and isset($comment) and isset($reaction) and isset($_COOKIE["blogname"])and isset($_COOKIE["entry"])and mb_ereg_match("Pozytywna|Neutralna|Negatywna", $reaction))) {
    $err="";

    if((!isset($user)) or mb_strlen($user)<=0){
        $err = "podaj użytkownika";
    }elseif (!isset($comment)){
        $err = "podaj komentarz";
    }elseif (!isset($_COOKIE["blogname"])){
        $err = "nie znaleziono bloga";
    }elseif (!isset($_COOKIE["entry"])){
        $err = "nie znaleziono posta";
    }elseif(!isset($reaction) or !mb_ereg_match("Pozytywna|Neutralna|Negatywna", $reaction)){
        $err = "nieprawidłowa reakcja";
    }

    header("Location: createKomentarz.php?err=$err&user=$user&commententry=$comment");
    return;
}

$blogname = htmlspecialchars_decode($_COOKIE["blogname"]);
$entryname = htmlspecialchars_decode($_COOKIE["entry"]);

$commentPath = "$BASE_PATH/$blogname/$entryname";
createComment($commentPath, $reaction, $user, $comment);
header("Location: blog.php?nazwa=$blogname");
?>
