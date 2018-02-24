<?php
if (!$_SESSION[username])
	{
		header("Location: /login/");
	}
	?>
<script type='text/javascript'>		  
function check1 ( p1,status)
{
pass1 = document.getElementById ( p1 ) .value;
 if ( !pass1 )
{
document.getElementById ( status ) .innerHTML = '<img src="/images/cross.png" />';
}
else
{
document.getElementById ( status ) .innerHTML = '<img src="/images/tick.png" />';
}
}	
function check2 ( p1, p2, status )
{
pass1 = document.getElementById ( p1 ) .value;
pass2 = document.getElementById ( p2 ) .value;
if ( pass1 != pass2 )
{
document.getElementById ( status ) .innerHTML = '<img src="/images/cross.png" />';
} 
else if ( !pass2 )
{
document.getElementById ( status ) .innerHTML = '';
}
else
{
document.getElementById ( status ) .innerHTML = '<img src="/images/tick.png" />';
}
}</script>
<h2>Change Password</h2>
<div class='box'>
<?php
$go = $_POST['go'];
if ($go)
	{
		$pass = addslashes($_POST['pass']);
		$pass2 = addslashes($_POST['pass2']);
		$get = mysql_query("SELECT * FROM `members` WHERE `username` = '$_SESSION[username]' LIMIT 1");
		$get = mysql_fetch_assoc($get);	   
		if (!$get || $pass != $pass2)
			{
				echo "Passwords don't match.";
			}
		else
			{
				  
				$salt = $get['salt'];
				$password = sha1( sha1( $pass ) . sha1( $salt ) );
				$update = mysql_query("UPDATE `members` SET `password` = '$password' WHERE `username` = '$_SESSION[username]'");
				$to = $get['email'];
				$from = "From: noreply@codinghub.com";
				$subject = "Password Changed"; 	
				$message = "You have just changed your password. This is your new password:\n $pass\n Do not lose this password, we cannot retreive your password. If you lose this, you must reset your password.\n\n CodingHub";
				mail($to,$subject,$message,$from) or die("The email could not be sent, please try again later");
				echo "Password Changed";
			}	
	}
else
	{
		echo "Enter your new password below<p>";
		echo "<form action='' method='post'>";
		?>
			  <fieldset><legend>New Password</legend>
			  <table><tr>
			  <td width='200px'>New Password</td><td><input type='password' name='pass' id='pass' onblur='check1("pass","status")' /><span id='status'></span></td></tr><tr>
			  <td width='200px'>Confirm Password</td><td><input type='password' name='pass2'  id='pass2' onblur='check2("pass","pass2","status2")' /><span id='status2'></span></td></tr><tr>
			  <td width='200px'>&nbsp;</td><td><input type='submit' name='go' value='Change Password' /></td></tr></table></fieldset>
	 <?
	}	  
			  
?>
</div>
