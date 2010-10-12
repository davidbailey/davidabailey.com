<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>David Bailey<?php if ($_GET['tag']) {echo " | " , htmlspecialchars($_GET['tag']);} ?></title>
	<link href="http://davidabailey.com/index.php<?php if ($_GET['tag']) {echo "?tag=" , htmlspecialchars($_GET['tag']);} ?>" />
	<updated>2010-08-29T00:50:00Z</updated>
	<author><name>David Bailey</name><email>www@davidabailey.com</email></author>
<?php
$db = new PDO('sqlite:../database');
if ($_GET["tag"]) {
$query = $db->prepare('SELECT * FROM posts WHERE tags LIKE :tag ORDER BY date DESC');
$query->execute(array(':tag' => "%" . $_GET["tag"] . "%"));
}
else {
$query = $db->prepare('SELECT * FROM posts ORDER BY date DESC LIMIT 10 OFFSET ' . intval($_GET['page']) * 5);
$query->execute();
}
$articles = $query->fetchAll();
foreach ($articles as $article) {
	echo "<entry><title>" , $article['title'] , "</title><link href=\"http://davidabailey.com/index.php?title=" , str_replace(" ","%20",$article['title']) , '" />';
    echo "<id>tag:davidabailey.com," , date('Y-m-d',$article['date']) , ":/index.php?title=" , str_replace(" ","%20",$article['title']) , "</id>";
    echo "<updated>" , date('Y-m-d\TH:i:sP',$article['date']) , "</updated>";
    echo '<content type="html">' , htmlspecialchars($article['post']) , '</content>';
    echo "</entry>";
}
unset ($db);
?>
</feed>
