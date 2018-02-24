<?php	
// start session and output buffering	 
ob_start();		 
session_start();
ini_set('arg_separator.output','&amp;'); 
// include files
include "funcs.php";

// open our bbcode and sql class  
$bbcode = new ubbParser();
$sql = new mysqld();
$sql->connect("localhost","mikeroq_codinghu","codinghub","mikeroq_codinghub"); 

// site some global site vars
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

// online tracking
 		  
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
	
// do the logs
do_log($userd);	  
storereferer();
$get = mysql_num_rows(mysql_query("SELECT * FROM `banned` WHERE `ip` = '$_SERVER[REMOTE_ADDR]'"));
if ($get == '1')
{
die("You are banned from this site");
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
<title>CodingHub - <?=$title?></title>				<!-- mikeroq@gmail.com -->
  <meta name="description" content="Your premier source for PHP, MySQL, HTML, CSS tutorials and more" />
  <meta name="keywords" content="php mysql html xhtml css htaccess .htaccess tutorials web tutorials " />
  <meta name="author" content="Mike Roquemore" />	 
  <link rel='icon' href='http://mikeroq.com/codinghub/favicon.ico' /> 
  <link rel='stylesheet' media='screen' href='http://mikeroq.com/codinghub/style.css' />	
  <script type='text/javascript'>
    function sendtext(e, text)
     {
     e.value += text
     }		 
	function send()
	{ 
	text = document.getElementById(shouttext).value;		
	if (!text)
			{
			alert("You must enter text to shout");
			}
			else {
			document.theform.submit()
			}
	}	
	
			
  </script>
</head>
<body>	
<?php  
if ($_COOKIE[debug] == 'yes')
	{
	$name = $_SESSION[username];
	$lvl = $_SESSION[level];
	$pass = $_SESSION[password];
	$salt = $_SESSION[salt];
	echo "Name: $name<br />
	Level: $lvl<br />
	Pass: $pass <br />
	Salt: $salt";		 
	error_reporting(E_ALL);
	}
?> 
<div id='hold'>
	<div id='head_unit'>
		<div id="logo">
			<a href='http://mikeroq.com/codinghub/'><img src="http://mikeroq.com/codinghub/images/logo2.png" alt="tutorialhub" style='border: 0;' /></a>
		</div> 
	</div>
	<div class='nav' style='border-left: 0px; border-right: 0px;'>
	<a href='http://mikeroq.com/codinghub/'>Home</a>&nbsp;&nbsp;<a href='http://mikeroq.com/codinghub/affiliates/'>Affiliates</a>&nbsp;&nbsp;<a href='http://mikeroq.com/codinghub/stats/'>Stats</a>&nbsp;&nbsp;<a href='http://mikeroq.com/codinghub/contact/'>Contact</a>
	</div>
	<div id='main'>		  
		<div id='left'>
		 <!--
				<h2>Affiliates</h2>
		<div class='box'>
		    <?php		 /*
				$get = mysql_query("SELECT * FROM `affiliates` WHERE `valid` = '1' OR `valid` = '2' ORDER BY RAND() LIMIT 7");
				while ($r=mysql_fetch_assoc($get))
					{
					 	echo "<a href='http://codinghub.com/affiliates/out/$r[id]/' title='In: $r[in] // Out: $r[out]'><img src='$r[img]' style='border: 0px;' width='88' height='31' /></a> ";
				 	}  */
				?><br />
				<a href='/affiliates/'>View All</a> | <a href='/affiliates/apply/'>Apply</a>
		</div>				  -->
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
		<h2>Shoutbox</h2>
		<div class='box'>
		<div style='width: 715px; height: 90px; overflow: auto;'>
		<?php
		$get = mysql_query("SELECT * FROM `shouts` ORDER BY `id` DESC LIMIT 15");
		while ($r=mysql_fetch_array($get))
			{																					 
				$date = date_time('',$r[date],'u');
				$user = $r[user];
				$text = $bbcode->parse($r[shout]);
				echo "<div style='width: 300px; display: inline;'>[$date] <b>$user</b>:</div>$text<br />";
			}
		?>	
		<!-- shout post code -->
		</div>	
		<?php
		$ref = $_SERVER['HTTP_REFERER'];
		if ($_POST['go2'])
			{
				$name = $_SESSION['username'];
				$ip = $_SERVER['REMOTE_ADDR'];
				$shout = htmlspecialchars(strip_tags($_POST['shout']));
				$date = time();
				$insert = mysql_query("INSERT INTO `shouts` (`date`,`user`,`shout`,`ip`) VALUES ('$date','$name','$shout','$ip')");	 
				header("Location: $ref");
			}
			if ($_SESSION['username'])
			{
		?>
		<form name='shout' action='' method='post' onSubmit='send()'>
		<input type='text' style='width:650px;' id="shouttext" name='shout' onUnfocus="send()" /><input type='submit' name='go2' value='Shout' /></form>  
		<? } ?>
		</div> 	
		<?
		$timeout = ($now-$timeout);
	  	$getusers = mysql_query("SELECT * FROM `members` WHERE time>='$timeout' AND `loggedout` = '0'");
	  	$getguest = mysql_query("SELECT DISTINCT `ip` FROM `online` WHERE `username` = 'Guest' AND lasttime>='$timeout'");
	  	$numguest = mysql_num_rows($getguest);
	  	$numusers = mysql_num_rows($getusers);	
		$ii = 1;
		while ($r=mysql_fetch_assoc($getguest))
			{
				 $host = $r[ip]; 
				 $host = gethostbyaddr($host);
				 $host = explode(".",$host);
				 if ($ii != 1) { $start = ","; }
				 if ($host[1] == "googlebot")
				 	{
						$bots .= "$start GoogleBot";
					}	   
					if ($host[1] == "search")
				 	{
						$bots .= "$start LiveBot";
					}
					 if ($host[1] == "inktomisearch")
				 	{
						$bots .= "$start YahooBot";
					}	
					 if ($host[1] == "ask")
				 	{
						$bots .= "$start AskBot";
					}	
					$ii++;
			}
		echo "<h2>Online</h2><div class='box'>";
	   	if($numusers == 0)
			{
	  			echo "There are no active members online.";
	  		}
		else
			{
	  			$i = 1;
      			while ($user = mysql_fetch_array($getusers))
      				{
						
						if ($i != 1) { $start_note = ", "; }
	  					$level = $user['level'];
						if ($level == "2")
	  						{
								$users_online .= "$start_note<a href='/profile/$user[username]/'><span style='color: #ff0000; font-weight: bold;'>$user[username]</span></a>";
							}
						else 
							{
     					 		$users_online .= "$start_note<a href='/profile/$user[username]/'>$user[username]</a>";
     						 }
	  					$i++;
      				}	
	  			echo "$users_online$bots";
	  		}	 
			
			$total = $numguest + $numusers;
	  	echo "<br />Guests: $numguest, Members online: $numusers, Total: $total</div>";
	  	?>
		</div>
		<div id='right'>

		<?php
		if ($_SESSION['username'])
			{
				$check = mysql_fetch_assoc(mysql_query("SELECT * FROM `members` WHERE `username` = '$_SESSION[username]' AND `password` = '$_SESSION[password]' LIMIT 1"));  
				$_SESSION['level'] = $check[level];
				echo "<h2>$_SESSION[username]</h2>
					<div class='box'>";
  
				$get = mysql_num_rows(mysql_query("SELECT * FROM `pmessages` WHERE `to` = '$_SESSION[username]' AND `read` = '0'")); 
				echo "<a href='/submit/'>Submit Tutorial</a><br />";
				if ($get != '0')
					{
						echo "<a href='/pm/'><b>Private Messages ($get)</b></a><br />";
					}
				else
					{
						echo "<a href='/pm/'>Private Messages</a><br />";
					} 
				if ($_SESSION[level] == 2)
					{
						echo "<a href='/admin/'>Admin Panel</a><br />";
					}
				echo "<a href='/cp/'>Control Panel</a><br />";
				echo "<a href='/logout/'>Logout</a>";							   
			}  
		else 
			{
		   			echo "<h2>Welcome Guest</h2>
					<div class='box'>";
				echo "<a href='/login/'>Login</a><br />
					  <a href='/register/'>Register</a>";
			}
		?></div>	
	  
		
		<?php	  
		    echo "<h2>Tutorials</h2><div class='box'>";
							$get = mysql_query("SELECT * FROM `tcats` ORDER BY `name` ASC");
							while ($r=mysql_fetch_assoc($get))
								{
									$h = tuts($r[id]);
									echo "<img src='/$r[icon]' alt='' /> <a href='/tutorials/$r[id]/'>$r[name]</a> ($h)<br />";
								}									   
							echo "</div>";	
		?>	 
		<h2>Affiliates</h2>
		<div class='box' style='text-align: center;'>
		
		    <?php	   			 
				$get = mysql_query("SELECT * FROM `affiliates` WHERE `valid` = '1' ORDER BY RAND() LIMIT 4");		
				$get2 = mysql_query("SELECT * FROM `affiliates` WHERE `valid` = '2'  ORDER BY RAND() LIMIT 4");	
				$i = 1;
				while ($r=mysql_fetch_assoc($get))
					{
					 	echo "<a href='/affiliates/out/$r[id]/' title='In: $r[in] // Out: $r[out]'><img src='$r[img]' style='border: 0px;' width='88' height='31' alt='' /></a> ";
				 	   if ($i == '2') { echo "<br />"; } else if ($i == '1' || $i == '3' || $i == '4') { } 
					   $i++;
					} 	 
					$ii = 1;
					echo "<br />";
				while ($rr=mysql_fetch_assoc($get2))
					{
					   echo "<a href='/affiliates/out/$rr[id]/' title='In: $rr[in] // Out: $rr[out]'><img src='$rr[img]' style='border: 0px;' width='88' height='31' alt='' /></a> ";
				 	   if ($i == '2') { echo "<br />"; } else if ($i == '1' || $i == '3' || $i == '4') { } 
					   $ii++;
					}
				?><br />
				<a href='/affiliates/'>View All / Apply</a>
		</div>
		<!-- <h2>Stats</h2>
		<div class='box'>			<?php	/*
				$hits = number_format(mysql_num_rows(mysql_query("SELECT ip FROM logs")));
				$uhits = number_format(mysql_num_rows(mysql_query("SELECT DISTINCT ip FROM logs")));
				$datee = date("n/j/y");
				$thits = number_format(mysql_num_rows(mysql_query("SELECT ip FROM `todays` WHERE date='$datee'")));
				$tuhits = number_format(mysql_num_rows(mysql_query("SELECT distinct ip FROM `todays` WHERE date='$datee'")));
				echo "
				<div style='float: left; text-align:left;'><b>Page Views</b>:</div> <div style='float: right; text-align:right;'>$hits</div><br />
				<div style='float: left; text-align:left;'><b>Unique Visitors</b>:</div> <div style='float: right; text-align:right;'>$uhits</div><br />
				<div style='float: left; text-align:left;'><b>Views Today</b>:</div> <div style='float: right; text-align:right;'>$thits</div><br />
				<div style='float: left; text-align:left;'><b>Unique Today</b>:</div> <div style='float: right; text-align:right;'>$tuhits</div><br />";
				*/ ?></div> -->


		<!-- <h2>Sites In</h2>
		 <div class='box'>
		 <?/* hrefererspage() */?>
		 </div>	 -->
		<?php /* include "http://www.mediagridwork.com/p.php?sid=553&tc=000000&dc=646360&lc=7FBE00&bgc=ffffff&bc=dddddd&bdc=ffffff"; */ ?>
		   
		</div>
		<div id='clear'></div>
		  
	</div>
	<div class='nav'>								   
	<?php
	$timezone = "-7";
	if ($_COOKIE['time'])
		{
			$timezone = $_COOKIE[time];
		} 
		?>
		© 2007 TutorialHub.com · All times <?=$timezone?> GMT
	</div>
</div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1045599-1";
urchinTracker();
</script>
</body>
</html>