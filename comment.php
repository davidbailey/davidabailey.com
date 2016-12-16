<?php
if (empty($_GET['title'])) {
	$db = new PDO('sqlite:../database'); 
	$query = $db->prepare('SELECT COUNT(*) FROM pendingcomments');
	$query->execute();
	unset ($db); 
	$numcomments = $query->fetch();
	echo "<feed><entry><content>" , $numcomments[0] , "</content></entry></feed>";
}
else {
	$db = new PDO('sqlite:../database'); 
	$query = $db->prepare('INSERT INTO pendingcomments VALUES (:title, :ip, :author, :date, :comment);');
	$query->execute(array(':title' => str_replace("\'","'",$_GET["title"]), ':ip' => ip2long($_SERVER['REMOTE_ADDR']), ':author' => 	$_GET["author"], ':date' => date('U'), ':comment' => $_GET["comment"]));
	unset ($db); 
	echo "<!DOCTYPE html>Thanks for your comment! I'll pass it on to my trained monkey for review.";
}
?>
