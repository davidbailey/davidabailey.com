<!DOCTYPE html><html><head><title>David Bailey<?php if ($_GET['title']) {echo " | " , str_replace("\'","'",htmlspecialchars($_GET["title"]));} if ($_GET['tag']) {echo " | " , htmlspecialchars($_GET['tag']);} ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="description" content="davidabailey.com"/>
<style type="text/css">
<?php
$db = new PDO('sqlite:../database'); 
$query = 'SELECT * FROM backgrounds ORDER BY RANDOM() LIMIT 1;';
$bg = $db->query($query)->fetch();
unset ($db); 
?>
body {background: url('/backgrounds/<?php echo $bg['filename'];?>'); background-attachment: fixed; background-repeat: no-repeat; background-size: 100% 100%; -moz-background-size: 100% 100%; margin: 0 0 0 0; padding: 0 0 0 0}
h1,h2,h3,h4,h5 {margin: 4px 4px 0px 0px; font-family: sans-serif; font-weight: normal}
h1,h2,h3 {color:white; text-shadow: black 0.1em 0.1em 0.2em}
h2,h3,h5 {font-size:12px}
h4 {font-size:24px}
a {text-decoration:none}
a:visited.black,a:link.black {color:black}
a:visited.white,a:link.white {color:white}
img,table {border: 0}
table {margin-left: auto; margin-right: auto}
tr {vertical-align: top}
div.center,h3 {margin-left: auto; margin-right: auto; text-align: center}
div.box {width: 85%; margin-left: auto; margin-right: auto; background-color: #fff; border-radius: 5px; -moz-border-radius: 5px; padding: 10px; box-shadow: 5px 5px 10px #000; -webkit-box-shadow: 5px 5px 10px #000; -moz-box-shadow: 5px 5px 10px #000; overflow:auto}
</style>
<?php if ($_GET["title"]) {
echo <<<COMMENTJS
<script type="text/javascript">
function submitcomment() {
	var req;
	try { req = new XMLHttpRequest(); } 
	catch (e) { try{ req = new ActiveXObject("Msxml2.XMLHTTP"); } 
	catch (e) { try{ req = new ActiveXObject("Microsoft.XMLHTTP"); } 
	catch (e) { return false; } } }
  	if (req != undefined) {
  	var author = encodeURIComponent(document.getElementById("author").value)
  	var title = encodeURIComponent(document.getElementById("title").value)
  	var comment = encodeURIComponent(document.getElementById("comment").value)
	req.open("GET", "/comment.php?author="+author+"&title="+title+"&comment="+comment, true);
	req.onreadystatechange = function() { if (req.readyState == 4 && req.status == 200) { document.getElementById('commentform').innerHTML = req.responseText; } };
    req.send("");
  	}
}
</script>
COMMENTJS;
} ?>
</head><body>
<table style="width:90%"><tr>
<td><h1><a href="/index.php" class=white>David&nbsp;Bailey</a></h1><h2>
<?php 
$db = new PDO('sqlite:../database'); 
$query = 'SELECT * FROM oneline ORDER BY RANDOM() LIMIT 1;';
$oneline = $db->query($query)->fetch();
unset ($db);
if ($oneline['link']) {echo "<a href=\"" , $oneline['link'] , "\" class=\"white\">" , $oneline['line'] , "</a>";}
else {echo $oneline['line'];}
?>
</h2></td><td><img src="/icons/1.gif" width="40"/></td>
<td><h3><a href="mailto:www@davidabailey.com" class=white><img src="/icons/mail.png" width="40" height="40"/><br/>Email&nbsp;Me</a></h3></td>
<td><h3><a href="/atom.php<?php if ($_GET['tag']) {echo "?tag=" , htmlspecialchars($_GET['tag']);} ?>" class=white><img src="/icons/atom.png" width="40" height="40"/><br/>Subscribe</a></h3></td>
<td><img src="/icons/1.gif" width="40" height="40"/></td>
<td><h3><a href="http://delicious.com/davidabailey" class=white><img src="/icons/delicious.png" width="40" height="40"/><br/>Delicious</a></h3></td>
<td><h3><a href="http://www.facebook.com/p/David_Bailey/3422260" class=white><img src="/icons/facebook.png" width="40" height="40"/><br/>Facebook</a></h3></td>
<td><h3><a href="http://flickr.com/photos/davidbailey/" class=white><img src="/icons/flickr.png" width="40" height="40"/><br/>Flickr</a></h3></td>
<td><h3><a href="http://www.43things.com/person/dabailey" class=white><img src="/icons/43things.png" width="40" height="40"/><br/>43&nbsp;Things</a></h3></td>
<td><h3><a href="http://www.linkedin.com/pub/david-bailey/16/905/952" class=white><img src="/icons/linkedin.png" width="40" height="40"/><br/>LinkedIn</a></h3></td>
<td><h3><a href="http://www.summitpost.org/user_page.php?user_id=58076" class=white><img src="/icons/summitpost.png" width="40" height="40"/><br/>SummitPost</a></h3></td>
<td><h3><a href="http://www.amazon.com/gp/registry/wishlist/3LSPU5WVO0JXO" class=white><img src="/icons/amazon.png" width="40" height="40"/><br/>Wishlist</a></h3></td>
<td><h3><a href="http://dabailey.yelp.com/" class=white><img src="/icons/yelp.png" width="40" height="40"/><br/>Yelp</a></h3></td>
<td style="width:100%"></td>
<td><form action="http://www.google.com/search" method="get"><input type="search" name="as_q" value="search davidabailey.com" style="width: 180px" onfocus="this.value = (this.value=='search davidabailey.com')? '' : this.value;"/><input type="hidden" name="sitesearch" value="davidabailey.com"></form></td>
</tr></table>
<?php
$db = new PDO('sqlite:../database');
if ($_GET["title"]) {
$query = $db->prepare('SELECT * FROM posts WHERE title = :title');
$query->execute(array(':title' => str_replace("\'","'",$_GET["title"])));
}
elseif ($_GET["tag"]) {
$query = $db->prepare('SELECT * FROM posts WHERE tags LIKE :tag ORDER BY date DESC');
$query->execute(array(':tag' => "%" . $_GET["tag"] . "%"));
}
else {
$query = $db->prepare('SELECT * FROM posts ORDER BY date DESC LIMIT 5 OFFSET ' . intval($_GET['page']) * 5);
$query->execute();
}
$articles = $query->fetchAll();
foreach ($articles as $article) {
	echo '<br/><div class="box" >';
    echo '<h4><a href="/index.php?title=' , str_replace(" ","%20",$article['title']) , '" class="black">' , $article['title'] , '</a></h4>';
    echo "<h5>" , date('j F Y',$article['date']) , " | ";
    if ($article['comments']) {echo '<a href="/index.php?title=' , str_replace(" ","%20",$article['title']) , '#comments" class=black>' , $article['comments'] , " Comment";
    if ($article['comments'] != 1) {echo "s";}
    if ($article['comments']) {echo "</a>";}
    }
    else {echo "0 Comments";}
    echo " | Tags: ";
    $tags = explode ("|", $article['tags']);
    foreach ($tags as $tag) { echo '<a href="/index.php?tag=' , $tag , '" class=black>' , $tag , '</a> ';}
    if (!$article['tags']) {echo 'none';}
    echo "</h5><br/>" , $article['post'] , '</div><br/>';
}
if ($_GET["title"]) {
echo "<div class=\"box\"><span id=\"commentform\"><textarea id=\"comment\" rows=\"10\" cols=\"100\" onfocus=\"this.value = (this.value=='Leave a comment...')? '' : this.value;\">Leave a comment...</textarea><br/><input type=\"text\" size=\"25\" id=\"author\" value=\"Your Name or Anonymous\" onfocus=\"this.value = (this.value=='Your Name or Anonymous')? '' : this.value;\"/>&nbsp;<input type=\"hidden\" id=\"title\" value=\"" . $article['title'] . "\"/><input type=\"submit\" value=\"Comment\" onclick=\"submitcomment(); return false;\"/></span></div><br/>";
if ($article['comments']) {
$query = $db->prepare('SELECT * FROM comments WHERE title = :title ORDER BY date');
$query->execute(array(':title' => $article['title']));
$comments = $query->fetchAll();
foreach ($comments as $comment) {
if (!$firstcomment) {echo "<a name=\"comments\"/>"; $firstcomment = 1;}
echo "<div class=\"box\">";
echo "<h4>" , $comment['author'] , "</h4>" , "<h5>" , date('j F Y',$comment['date']) , "</h5>" , $comment['comment'];
echo "</div><br/>";
}
}
}
unset ($db);
?>
<div class="box">
<?php
if (intval($_GET['page']) > 0) {echo "<div style=\"float: left; width: 15%\">&nbsp;<a href=\"/index.php?page=" , intval($_GET[page]) - 1 , "\">Newer Items</a></div>"; }
else {echo "<div style=\"float: left; width: 15%\">&nbsp;</div>"; }
echo '<div style="width: 70%; float: left; text-align: center"><i>background: <a href="' , $bg[url] , '">' , $bg[title] , '</a></i></div>';
$db = new PDO('sqlite:../database');
$query = $db->prepare('SELECT COUNT(*) FROM posts');
$query->execute();
$numposts = $query->fetch();
if (!$_GET['title'] && !$_GET['tag'] && (intval($_GET['page']) + 1) * 5 < $numposts[0]) {echo "<div style=\"float: left;  width: 15%; text-align: right\"><a href=\"/index.php?page=" , intval($_GET[page]) + 1 , "\">Older Items</a>&nbsp;</div>";}
else {echo "<div style=\"float: right; width: 15%\">&nbsp;</div>"; }
?>
<div style="clear:both;"></div>
</div>
<br/></body></html>
