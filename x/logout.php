<?php  
$ref = $_SERVER['HTTP_REFERER'];
if (!$ref) {
$ref = "/index.php";
}
$query = $sql->query("UPDATE `members` SET `loggedout` = '1' WHERE `id` = $_SESSION[userid]");

session_destroy();	
$_SESSION['username'] = '';
$_SESSION['password'] = '';
$_SESSION['level'] = '';
$_SESSION['salt'] = '';
$_SESSION['userid'] = '';
$user = '';

header("Location: $ref");
?> 
