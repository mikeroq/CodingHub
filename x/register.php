<script type='text/javascript'>
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
}
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

</script>
   <h2>Register</h2><div class='box'>
 <?php 
   $setting = mysql_fetch_array(mysql_query("SELECT * FROM settings WHERE id = '5'"));
   if ($setting[value] == "0")
   {
   echo "<div class='error'>Registrations are currently disabled.</div>";
   } 	 
   else {
   $go = FALSE;
      if (isset($_POST['register'])) 
	  		{
           			$_SESSION[usernamee] = $_POST[username];
					$_SESSION[emaile] = $_POST[email];
					$_SESSION[email2e] = $_POST[email2];
					$username = htmlspecialchars($_POST[username]);
		   			$pass = htmlspecialchars($_POST[password]);
		   			$pass2 = htmlspecialchars($_POST[password2]);
		   			$email = htmlspecialchars($_POST[email]); 
		   			$email2 = htmlspecialchars($_POST[email2]);	 
					$check1 = mysql_query("SELECT * FROM members WHERE username = '$username'");
					$check2 = mysql_query("SELECT * FROM members WHERE email = '$email'");
					if (mysql_num_rows($check1) != "0")
						{
						$ut = "The username you have selected has been taken.<br />";
						}
					if (mysql_num_rows($check2) != "0")
						{
						$et = "The email address you have supplied belongs to another account.<br />";
						}
					 if (!$username)
						{
							$ue = "You must enter a username. <br />";
						}	
					 else if (strlen($username)>16 || strlen($username)<3)
		   				{
							$ue = "Username must be at least 3 characters in legenth, and must be no longer then 15 characters in legenth.<br />";
						}
					if (!$pass || !$pass2)
						{
							$pe = "You must enter a password.<br />";
						}
					else if ($pass != $pass2)
						{
							$pe = "The passwords you have entered do not match.<br />"; 
						}
					 if (!$email || !$email2)
						{
							$ee = "You must enter an email address.<br />";
						}
					else if ($email != $email2)
						{
							$ee = "The email addresses you entered do not match.<br />"; 
						} 
					if (!$_POST[agree])
						{
							$a = "You must agree to the terms of service.";
						}
					if ($ue || $pe || $ee || $ut || $et || $a)
						{
							echo "<div class='error'>The following errors have occured:<p>
							$ue $ut $pe $ee $et $a</div>"; 
							$go = FALSE;
		   				 }
					else if (!$ue && !$pe && !$ee && !$c && !$a && !$ut && !$et) 	
					{
					$go = TRUE;
					$hide = 'y';
					}	 
					}  
					if ($hide != 'y')
					{
      	   ?>

     	<form method="post" action="?x=register">
         	<fieldset>
				<legend>User Info</legend>
		 		<table>
					<tr>
						<td width='200px'>Username</td>
						<td><input type="text" class="txt" name="username" id="username" value="<?=$_SESSION[usernamee]?>" /> Between 3 and 16 characters.</td>
					</tr>
					<tr>
						<td width='200px'>Password</td>
						<td><input type="password" class="txt" name="password" id="password" value="" onblur="check1('password','status1')"/><span id='status1'></span></td>
					</tr>
					<tr>
						<td width='200px'>Confirm Password</td>
						<td><input type="password" class="txt" name="password2" id="password2" value="" onblur="check2('password','password2','status')" /><span id='status'></span></td>
					</tr>
					<tr>
		<td width='200px'>Email</td><td>
		 <input type="text" class="txt" name="email" id="email" value="<?=$_SESSION[emaile]?>" onblur="check1('email','status4')"/><span id='status4'></span></td></tr><tr>	
		  <td width='200px'>Confirm Email</td><td>
		<input type="text" class="txt"  name="email2" id="email2" value="<?=$_SESSION[email2e]?>" onblur="check2('email','email2','status3')" /><span id='status3'></span></td></tr></table></fieldset>
		 <fieldset><legend>Terms of Service</legend><table><tr><td>	
		<div class="alt1" style="border:thin inset; padding:6px; background: #efefef; height:175px; overflow:auto; width: 600px;">
		<strong>Rules</strong>
		<p />Registration to this site is free! We do insist that you abide by the rules and policies detailed below. 
If you agree to the terms, please check the 'I agree' checkbox and press the 'Register' button below. 
If you would like to cancel the registration, <a href='index.php'>click here</a> to return to the site index.
<p />
Although the administrators of CodingHub will attempt to keep all objectionable user submitted content off this site, 
it is impossible for us to review all user submitted content. All user submitted content express the views of the author not the owners of CodinhHub. The owners of CodingHub
will be held responsible for any user submitted content.
<p />
By agreeing to these rules, you warrant that you will not post any content that are obscene, vulgar, 
sexually-oriented, hateful, threatening, or otherwise violative of any laws.
<p />
The owners of CodingHub reserve the right to get rid of any content at any time without any notice.</div><br />
		 <input type='checkbox' name='agree' style='margin-bottom: 2px;'>I agree to follow the terms of service set forth on this site.</input></td></tr><tr>
		 <td colspan='2'>
		 <input type="submit" name="register" id="register" accesskey="s" value="Register" /></td></tr></table></fieldset>
        </form>

   <?php
   	}
	if ($go == TRUE)
	{
	$password = sha1($pass);
	$salt = mt_rand();	
	$password = sha1($password . sha1($salt));  
	$time = time();
	$ip = $_SERVER['REMOTE_ADDR'];
	$register = mysql_query("INSERT INTO `members` ( `username` , `password` , `email` , `salt`, `regdate` , `level` , `regip` ) VALUES ('$username', '$password', '$email', '$salt' , '$time', '0' ,'$ip' )");
	/*$get = mysql_fetch_array(mysql_query("SELECT * FROM settings WHERE id = '1'"));	 
	$subject = $get[value];
	$get = mysql_fetch_array(mysql_query("SELECT * FROM settings WHERE id = '2'"));
	$message = $get[value];
	$pm = mysql_query("INSERT INTO `pmessages` ( `subject` , `message` , `to` , `from` , `date`) VALUES('$subject', '$message', '$username', 'mikeroq', '$time' )"); */
	$_SESSION['usernamee'] = '';
	echo "You have successfully registered with our site.<br />To begin using your account please <a href='/login/'>login</a>.";
	}
	}																																											  
   ?>
	</div>




