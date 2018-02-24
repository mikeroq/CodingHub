<h2>Change Password</h2>
<div class='box'>
<?php
$go = $_POST['go'];
if ($go)
	{
		$password = addslashes($_POST['pass']);
		$password = addslashes($_POST['pass2']);
		$get = mysql_query("SELECT * FROM `members` WHERE `email` = '$email' LIMIT 1");
		$get = mysql_fetch_assoc($get);	   
		if (!$get[username])
			{
				echo "Email Address does not exist in our system";
			}
		else
			{
				  
				$salt = $get['salt'];
				$password = sha1( sha1( $generate ) . sha1( $salt ) );
				$update = mysql_query("UPDATE `members` SET `password` = '$password' WHERE `email` = '$email'");
				$to = $get['email'];
				$from = "From: noreply@codinghub.com";
				$subject = "Password Reset"; 	
				$message = "Your password has been reset. This is your new password:\n $generate\n Do not lose this email, we cannot retreive your password.\n\n CodingHub";
				mail($to,$subject,$message,$from) or die("The email could not be sent, please try again later");
				echo "Your new password has been mailed to <b>$email</b>";
			}	
	}
else
	{
		echo "Enter your new password below<p>";
		echo "<form action='' method='post'>
			  <fieldset><legend>New Password</legend>
			  <table><tr>
			  <td width='200px'>New Password</td><td><input type='text' name='pass' /></td></tr><tr>
			  <td width='200px'>Confirm Password</td><td><input type='text' name='pass2' /></td></tr><tr>
			  <td width='200px'>&nbsp;</td><input type='submit' name='go' value='Change Password' /></tr></table></fieldset>";
	}	  
			  
?>
</div>