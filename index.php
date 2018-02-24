<?php	
// start session and output buffering	 
ob_start();		 
session_start();
ini_set('arg_separator.output','&amp;'); 
include "funcs.php";
$bbcode = new ubbParser();
$sql = new mysqld();
$sql->connect("localhost","mikeroq_codinghu","codinghub","mikeroq_codinghub"); 
$user = $_SESSION['username']; 
$timeout = 600;
$now = time(); 		 
$date = date("n/j/y");		   
$ip = $_SERVER['REMOTE_ADDR'];
if ($user)
{
$check = mysql_fetch_assoc(mysql_query("SELECT * FROM `members` WHERE `username` = '$user' AND `password` = '$_SESSION[password]' LIMIT 1"));  
$_SESSION['level'] = $check[level];
}
$dat = date("n/j/y");	
if ($user) 
	{	
		$update = mysql_query("UPDATE `members` SET `time` = '$now', `date` = '$dat', `pages` = pages+1 WHERE `username` ='$_SESSION[username]'");	
	}		  
if (!$_SESSION['username']) 
	{
		$userd = "Guest";
	}
else 
	{
		$userd = $_SESSION['username'];
	}					  
$checkd = mysql_num_rows(mysql_query("SELECT * FROM `online` WHERE `ip` = '$ip'"));
if($checkd == 0 && !$user)
	{
		$newuser = mysql_query("INSERT INTO `online` (`username`,`lasttime`,`ip`) VALUES ('$userd','$now','$ip')");
	}
else
	{
		$update = mysql_query("UPDATE online SET lasttime='$now' WHERE ip='$ip'");
	}  
	
do_log($userd);	  
storereferer();
$get = mysql_num_rows(mysql_query("SELECT * FROM `banned` WHERE `ip` = '$_SERVER[REMOTE_ADDR]'"));
if ($get == '1')
{
die("You are banned from this site");
} 
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
	<?php
						   
										
				$x = $_GET['x'];
				switch($x)
					{	
				default:
				$title = "Your source for Tutorials and more!";
				break;
				case "stats":
				$title = "Site Stats";
				break;
				case "admin":
				$title = "Admin Panel";
				break;
				case "services":
				$title = "services";
				break;
				case "contact":
				$title = "Contact";
				break; 	  
				case "affiliates":
				$title = "Affiliates";
				break;
				case "advertise":
				$title = "Advertise";
				break;
				case "login":
				$title = "Login";	   
				case "register":
				$title = "Register";
				break;
				case "profile":
				$name = $_GET[user];
				$title = "Viewing profile - $name";
				break;
				
				case "tutorials":
				$iid = $_GET[id];
				$catt = $_GET[cid];	  
				if ($catt) {
				$name = mysql_fetch_array(mysql_query("SELECT name FROM `tcats` WHERE `id` = '$catt'"));
				$name = $name['name'];
				$title = "$name tutorials";		
				}
				else {
				$name = mysql_fetch_array(mysql_query("SELECT title FROM `tutorials` WHERE `id` = '$iid'"));
				$name = $name['title'];
				$title = "$name";
				}
				break; 
				}
				?>
<title>CodingHub - <?=$title?></title>
<meta name="description" content="Your premier source for PHP, MySQL, HTML, CSS tutorials and more" />
  <meta name="keywords" content="php mysql html xhtml css htaccess .htaccess tutorials web tutorials " />
  <meta name="author" content="Mike Roquemore" />	 
  <link rel='icon' href='http://mikeroq.com/codinghub/favicon.ico' /> 
	<link rel='stylesheet' type='text/css' href='style.css' />
	
</head>
<body>
<div id='container_top'>
	<div id='top'>
		<div id='logo'>
			<a href='#'>CodingHub</a>
		</div>
		<ul id='nav'>
			<li><a href='#'>tools</a></li>
			<li><a href='#'>forums</a></li>
			<li><div style='width: 50px'>&nbsp;</div></li>
			<li><a href='#'>webmaster</a></li>
			<li><a href='#'>photoshop</a></li>
			<li><a href='#'>javascript</a></li>
			<li><a href='#'>mysql</a></li>
			<li><a href='#'>php</a></li>
			<li><a href='#'>html / css</a></li>
			
			
		</ul>
		<div class='clear'></div>
	</div>
</div>
<div id='main'>

<div id='auth_bar'>
	<div id='message'>
		Thanks for dropping by Guest!
	</div>
	<div id='auth'>
		<input type='text' name='username' value='username' /> <input type='password' value='password' name='password' /> <input type='submit' name='go' value='login' /> <input type='button' value='sign up' />
	</div>
	<div class='clear'></div>
</div>
<?php 
$x = $_GET['x'];
if (file_exists("x/$x.php")) 
	{
		include ("x/$x.php");
	} 
else if(!$x)
	{
		include("x/home.php");
	}
else
	{
		include("x/404.php");
	}
?>
<div id='footer'>
	<div id='copyright'>
	<?php
	$timezone = "-6";
	if ($_COOKIE['time'])
		{
			$timezone = $_COOKIE[time];
		} 
		?>
		 &copy; 2006-2014 CodingHub & Mike Roquemore. All times <?=$timezone?> GMT.
	</div>
	<div id='stats'>
		<a href='#'>About Us</a> | <a href='#'>Contact Us</a> | <a href='#'>Report Content</a> | <a href='#'>Legal</a>
	</div>
</div>
</body>
</html>