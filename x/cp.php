<?php
if (!$_SESSION[username])
	{
		header("Location: /login/");
	}
	?>			   
	<script type='text/javascript'>
function cdelete(delUrl,URL) {
	if (confirm("Are you sure you want to delete your avatar")) {
		document.location = delUrl;
	}
	else if(alert("Your avatar will not be deleted"))
	{
		document.location = URL;	
		}
}
</script>
<h2>Control Panel</h2><div class='box'>
<fieldset><legend>Profile</legend>
<a href="/profile/<?=$_SESSION['username']?>/">View</a><br />
<a href="/editprofile/">Edit Profile</a>
</fieldset>
<fieldset><legend>Site Settings</legend>  
<a href="/settings/">Settings</a><br />
<?php
$g = mysql_fetch_assoc(mysql_query("SELECT `ext` FROM `members` WHERE `username` = '$_SESSION[username]'"));
			$ext = $g['ext'];
			if ($ext)
				{ 
					echo "<a href='' onClick='javascript:cdelete(\"/avatar/delete/\",\"/cp/\");'>Delete Avatar</a>";
				}
			else {
				  echo "<a href='/avatar/upload/'>Upload Avatar</a>";  
				  }
				?> </fieldset>	
<fieldset><legend>Private Messages</legend>
<a href="/pm/">Inbox</a><br />
<a href="/pm/write/">Compose</a></fieldset>	   
<fieldset><legend>Bank</legend>
<a href="/bank/" class='strike'>Bank Home</a><br /> 
<a href="/bank/lottery/" class='strike'>Lottery</a><br /> 
<a href="/bank/pointslist/" class='strike'>Points Chart</a></fieldset>
<fieldset><legend>Misc</legend>
<a href="/changepass/">Change Password</a><br /> 
<a href="/upgrade/" class='strike'>Upgrade Account</a><br /> 
<a href="/logout/">Logout</a></fieldset>
</div>
