<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Lab PHP</title>
</head>
<body>
<?php
function sanitize($text)
{
    $midsanit = strip_tags($text);
    // $midsanit=preg_split('//u', $midsanit, null, PREG_SPLIT_NO_EMPTY);
    $out = "";
    for ($i = 0; $i < mb_strlen($midsanit); $i++) {
        if (ctype_alnum(mb_substr($midsanit, $i, 1))) {
            $out = $out . mb_substr($midsanit, $i, 1);
        } elseif (mb_substr($midsanit, $i, 1) == '_') {
            $out = $out . "\w";
        }
    }
    return $out;
}
function mb_trim($str) {
    return preg_replace("/(^\s+)|(\s+$)/us", "", $str);
}
?>
<?php if ($_POST["search_word"] == null) { ?>

<form action="form.php" method="post">
    Wzorzec do wyszukania:<input type="text" name="search_word" value="" pattern="(\w+">
    <input type="submit" value="Szukaj">
</form>


<ul>
    <?php
    } else {

        // print_r($_GET);
        // print_r($_POST);
        $search_world = sanitize($_POST["search_word"]);
        $search_world_display = strip_tags($_POST["search_word"]);

        $regex = "^" . $search_world . "\$";
        print_r("wyszukiwanie: <span>$search_world_display:</span><br/>");

        $plik = fopen("DB.txt", 'r');
        while (!feof($plik)) {
            $s = mb_trim(fgets($plik));
            if (mb_ereg_match($regex, $s))
                echo "<li><samp>" . htmlentities($s) . "</samp></li>";

        }
        fclose($plik);
    }
    ?>
</ul>
</body>
</html>
