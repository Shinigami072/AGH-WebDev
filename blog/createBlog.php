<?php
header("content-type:application/xhtml+xml; charset =utf-8", "application/xhtml+xml; charset =utf-8");
echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>'."\n"; ?>
<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pl">
<head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset =utf-8"/>
    <title>Tworzenie blogu</title>
</head>
<body>
<?php include("Menu.xhtml")?>
<?php if(isset($_GET["err"])){?>
<p><?php echo $_GET["err"]?></p>
<?php }?>
<form action="nowy.php" method="post">
    <label for="blogname">Nazwa Bloga:</label><br/>
    <input name="blogname" id="blogname" type="text" value="<?php echo $_GET["blogname"]?>"/><br/>
    <label for="blogdesc">Opis Bloga:</label><br/>
    <textarea name="blogdesc" id="blogdesc" cols="80" rows="10" ><?php echo $_GET["blogdesc"]?></textarea><br/>
    <label for="user">Nazwa Użytkownika:</label><br/>
    <input name="user" id="user" type="text"  value="<?php echo $_GET["user"]?>"/><br/>
    <label for="password">Hasło:</label><br/>
    <input name="password" id="password" type="password"/><br/>
    <input type="submit" value="Utwórz"/>
    <input type="reset" value="Wyczyść"/>
</form>
</body>
</html>