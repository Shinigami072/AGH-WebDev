<?php
header("content-type:application/xhtml+xml; charset =utf-8", "application/xhtml+xml; charset =utf-8");
include_once "common.php";


function createHTMLPost($blogPath,$blogname, $entry)
{
    $data = getPost($blogPath, $entry);

    $Postentry = htmlspecialchars($data["entry"]);

    $year = $data["year"];
    $month = $data["month"];
    $day = $data["day"];
    $hour = $data["hour"];
    $minute = $data["minute"];
    $second = $data["second"];

    $date = "$year-$month-$day, $hour:$minute:$second";
    echo "<li class=\"post\">\n";
    echo "<div class=\"content\"><pre>$Postentry</pre><br/><span class=\"date\">$date</span></div>";
    echo "<ul class=\"files\">";
    foreach (glob("$blogPath/$entry{0,1,2}.*", GLOB_BRACE) as $file) {
        $filename = basename($file);
        echo "<li><a href=\"$file\">$filename</a></li>";
    }
    echo "</ul>\n";
    echo "<h2>Komentarze:</h2>\n";
    echo "<ul class=\"comments\">\n";

    $max=0;
    $comments = [];
    foreach (glob("$blogPath/$entry.k/*") as $file) {
        $id = intval(basename($file));
        $comments[$id] = $file;
        $max=$id+1;
    }
    for($id=0;$id<$max;$id+=1){
        if($comments[$id] !==null)
         createHTMLcomment($comments[$id]);
    }
    $urlblog=htmlspecialchars($blogname);
    $urlEntry=htmlspecialchars($entry);
    echo "<a href=\"commentPasser.php?blogname=$urlblog&amp;entry=$urlEntry\" >Dodaj Komentarz</a>";
    echo "</ul>";
    echo "</li>\n";
}

function createHTMLcomment($commentPath)
{
    $comment = fopen($commentPath, "r");
    $reaction = htmlspecialchars(rtrim(fgets($comment)));
    $date = htmlspecialchars(rtrim(fgets($comment)));
    $user = htmlspecialchars(rtrim(fgets($comment)));
    $content = "";
    while (($line = fgets($comment)) !== False) {
        $content .= $line;
    }
    $content = htmlspecialchars($content);
    echo "<li class=\"comment$reaction\">$content<span class=\"date\">$date</span><span class=\"user\">$user</span></li>";
    fclose($comment);
}

function showBlog($blogPath, $blog)
{
    ?>
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pl">
    <head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset =utf-8"/>
        <link type="text/css" rel="stylesheet" href="Basic.css"/>
        <title><?php echo $blog?></title>
    </head>
    <body>
    <?php include("Menu.xhtml")?>
    <?php
    $info = readInfo($blogPath, False);
    echo "<h1>$blog</h1>";
    echo "<div class=\"desc\"><p>";
    echo htmlspecialchars($info["desc"]);
    echo "</p><span class=\"user\">";
    echo htmlspecialchars($info["user"]);
    echo "</span>";
    echo "</div>";
    $user=$info["user"];
    echo "<a href=\"createWpis.php?user=$user\">Dodaj Post</a>";
    echo "<ul class=\"posts\">";

    foreach (scandir($blogPath) as $entry) {
        if (mb_ereg_match('[0-9]{16}$', $entry)) {
            createHTMLPost($blogPath,$blog, $entry);
        }
    }

    echo "</ul>";
    ?>
    </body>
    </html>
    <?php
}

function listBlogs($BASE_PATH)
{
    ?>

    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pl">
    <head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset =utf-8"/>
        <link type="text/css" rel="stylesheet" href="Basic.css"/>
        <title>Lista Blogów</title>
    </head>
    <body>
    <?php include("Menu.xhtml")?>
    <ul class="blogs">
        <?php
        $sem = sem_get(BLOG_SEM);
        sem_acquire($sem);
        foreach (glob("$BASE_PATH/*/info") as $blog) {
            $blogName = dirname($blog);
            $info = readInfo($blogName, False);
            $desc = htmlspecialchars($info["desc"]);
            $user = htmlspecialchars($info["user"]);

            $blogActualName = htmlspecialchars(basename($blogName));
            echo "<li><a href=\"?nazwa=$blogActualName\">$blogActualName - $desc [$user]</a></li>";
        }
        sem_release($sem);
        ?>
    </ul>
    </body>
    </html>
    <?php
}



$blog = $_GET["nazwa"];
$blogPath = "$BASE_PATH/$blog";
if (!isset($_GET["nazwa"])) {


    listBlogs($BASE_PATH);

} else if (file_exists("$blogPath/info") and is_dir($blogPath)) {

    showBlog($blogPath, $blog);

} else {
    header("Status: 404 Not Found");
    ?>
    <h1>Błąd 404</h1>
    <p>Blog, którego szukasz, nie został znaleziony na tym serwerze</p>

    <?php
}
?>


