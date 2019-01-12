<?php echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>'."\n"; ?>

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
<script src="validateWpis.js" language="JavaScript"></script>
<form action="wpis.php" enctype="multipart/form-data" method="post" onreset="loadFormData();return false;" onsubmit="return validateAll()" >
    <label for="blogentry">Treść:</label><br/>
    <textarea name="blogentry" id="blogentry" cols="80" rows="10"><?php echo $_GET["blogentry"]?></textarea><br/>
    <label for="user">Nazwa Użytkownika:</label><br/>
    <input name="user" id="user" type="text" value="<?php echo $_GET["user"]?>"/><br/>
    <label for="password">Hasło:</label><br/>
    <input name="password" id="password" type="password"/><br/>
    <label for="date">Data:</label><br/>
    <input name="date" id="date" value="<?php echo date("Y-m-d")?>"/><br/>
    <label for="time">Godzina:</label><br/>
    <input name="time" id="time" type="text" value="<?php echo date("H:i")?>" readonly="readonly"/><br/>
    <label for="files0">Choose file to upload</label>
    <div class="files">
        <input type="file" id="files0" name="files[0]" onchange="addFiles(this)"/>
    </div>
    <input type="submit" value="Utwórz"/>
    <input type="reset" value="Wyczyść"/>
</form>

</body>
</html>
