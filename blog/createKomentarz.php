<?php header("content-type:application/xhtml+xml; charset =utf-8", "application/xhtml+xml; charset =utf-8");
echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>'."\n"; ?>
<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pl">
<head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset =utf-8"/>
    <link type="text/css" rel="stylesheet" href="Basic.css"/>
    <title>Tworzenie Wpisu</title>
</head>
<body>
<?php include("Menu.xhtml")?>
<?php if(isset($_GET["err"])){?>
    <p><?php echo $_GET["err"]?></p>
<?php }?>
<form action="koment.php" method="post">
    <label for="reaction">Reakcja:</label><br/>
    <select name="reaction" id="reaction">
        <option selected="selected" label="Pozytywna">Pozytywna</option>
        <option label="Neutralna">Neutralna</option>
        <option label="Negatywna">Negatywna</option>
    </select>
    <label for="commententry">Treść:</label><br/>
    <textarea name="commententry" id="commententry" cols="80" rows="10"><?php echo $_GET["commententry"]?></textarea><br/>
    <label for="user">Nazwa Użytkownika:</label><br/>
    <input name="user" id="user" type="text"  value="<?php echo $_GET["user"]?>"/><br/>
    <input type="submit" value="Utwórz"/>
    <input type="reset" value="Wyczyść"/>
</form>
</body>
</html>