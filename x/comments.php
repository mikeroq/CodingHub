<?php
$name = $_SESSION['username'];
$ip = $_SERVER['REMOTE_ADDR'];
$comment = $_POST['comment'];
$go = $_POST['go'];			   
$date = time();
$id = $_GET['id'];
if ($go)
	{
		$insert = mysql_query("INSERT INTO `comments` (`tid`,`name`,`comment`,`ip`,`date`) VALUES ('$id','$name','$comment','$ip','$date')");
		header("Location: /tutorials/view/$id/#comments");
	}
?>
