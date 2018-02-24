<?php
if ($_SESSION[username])
	{
		if (!$_POST[update])
			{
				$user = $_SESSION['username'];
				$profile = mysql_query("SELECT * FROM `members` WHERE `username` = '$_SESSION[username]'");
				$profile = mysql_fetch_assoc($profile);
				echo "<h2>Edit Profile</h2><div class='box'>
					  <form method='post'>  
					  <fieldset><legend>Website</legend>
					  <table><tr>
					  <td width='200'>Site Title</td><td><input size='25' name='sitename'  value='$profile[sitetitle]' style='margin: 2px;'/></td></tr><tr>
					  <td width='200'>Site URL</td><td><input size='25' name='siteurl'  value='$profile[siteurl]' style='margin: 2px;'/></td>
					  </tr></table></fieldset>
				      <fieldset><legend>Basic Info</legend>
					  <table><tr>
					  <td width='200'>Location</td><td><input type='text' size='25'  name='location' value='$profile[location]' style='margin: 2px;'/></td></tr><tr>
					  <td width='200'>Interests</td><td><input size='25' name='int'  value='$profile[interests]' style='margin: 2px;' /></td>
					  </tr></table></fieldset>
					  <fieldset><legend>Contact Info</legend>
					  <table><tr>
					  <td width='200'>AOL Messenger</td><td><input size='25' name='aim'  value='$profile[aim]' style='margin: 2px;'/></td></tr><tr>
					  <td width='200'>MSN Messenger</td><td><input size='25' name='msn' value='$profile[msn]' style='margin: 2px;' /></td></tr><tr>
					  <td width='200'>Google Talk</td><td><input size='25' name='gtalk'  value='$profile[gtalk]' style='margin: 2px;' /></td></tr><tr>
					  <td width='200'>Yahoo Messenger</td><td><input size='25' name='yahoo'  value='$profile[yahoo]' style='margin: 2px;' /></td>
					  </tr></table></fieldset>
					  <fieldset><legend>Signature</legend>
					  <textarea name='sig' style='width: 300px; height: 100px;'>$profile[sig]</textarea><br />
					  <input type='submit' name='update' value='Update' accesskey='s' style='margin: 2px;' /></td></fieldset>
					  </form>
					  </div>";
			}
		else
			{
				$email = htmlspecialchars(strip_tags($_POST[email]));
				$aim = htmlspecialchars(strip_tags($_POST['aim']));
				$msn = htmlspecialchars(strip_tags($_POST['msn'])); 
				$yim = htmlspecialchars(strip_tags($_POST['yahoo']));  
				$int = htmlspecialchars(strip_tags($_POST['int']));	
				$gtalk = htmlspecialchars(strip_tags($_POST['gtalk']));
				$url =  htmlspecialchars(strip_tags($_POST['siteurl']));	 
				$url2 =  htmlspecialchars(strip_tags($_POST['sitename']));	
  				$location = htmlspecialchars(strip_tags($_POST['location']));
				$sig = htmlspecialchars(strip_tags($_POST['sig'])); 		   
				$user = $_SESSION[username];
				$update = mysql_query("UPDATE `members` SET `aim` = '$aim', `msn` = '$msn', `gtalk` = '$gtalk', `yahoo` = '$yim', `sitetitle` = '$url2', `siteurl` = '$url', `interests` = '$int', `location` = '$location'  , `sig` = '$sig' WHERE `username` = '$_SESSION[username]'");
				echo "<div class='box'>Your profile has been updated</div>";
}
}
else
{
echo ("<div class='box'>You must be logged in to edit your profile</div>");
}
?>
