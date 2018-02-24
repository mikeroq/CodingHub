<h2>Login</h2><div class='box'><?php



      if ($_POST['login']) 
	  		{
           			$username = htmlspecialchars("$_POST[username]");
					$r = mysql_fetch_assoc(mysql_query("SELECT `salt` FROM `members` WHERE `username` = '".mysql_escape_string($username)."'"));
					$salt = $r['salt'];
					$pass = $_POST['password'];	 
					$pass = sha1(sha1($pass) . sha1($salt));
					/*
					echo $salt . "<br>";
					echo $_POST['password'] . "<br>";
					echo $pass . "<br>";
					 */
					$check1 = mysql_query("SELECT * FROM `members` WHERE `username` = '".mysql_escape_string($username)."' AND `password` ='$pass'");
					if (mysql_num_rows($check1) == "0")
						{
						$ut = "Username and password do not match";
						}
					
					if ($ut)
						{
							echo "<div class='error'>The following error has occured:<p>
							$ut</div>"; 
							$go = FALSE;
		   				 }	
						 else {
						 $go = TRUE;
					$a = mysql_fetch_assoc($check1);
					
					// set some variables
					$_SESSION['username'] = $username;
					$_SESSION['password'] = $pass;
					$_SESSION['level'] = $a['level'];
					$_SESSION['salt'] = $salt;
					$_SESSION['userid'] = $a['id'];
					$_SESSION['timezone'] = $a['timezone'];
					$_SESSION['dst'] = $a['dst'];
					if ($_POST[remember] == 1)
						{
							setcookie("hash",$pass,time()+(60*60*24*5), "/", ".fourseventy.com");
							 	 
						}
					$del = $sql->query("DELETE FROM `online` WHERE `ip` = '$_SERVER[REMOTE_ADDR]'");
					$update = $sql->query("UPDATE `members` SET `loggedout` = '0' WHERE `id` = '$_SESSION[userid]'");
					if ($del == FALSE) 
						{
							$sql->error(mysql_error());
					
						}
					else 
						{
							$reff = "/cp/";
							header("Location: $reff");
						}
							 
					}	
				}
      	   ?>

     <form method="post" action="">
         <fieldset><legend>Login</legend>
		 <table><tr><td width='200px'>Username</td><td>
		 <input type="text" name="username" class='txt' value="" /></td></tr>
		 <tr><td width='200px'>Password</td><td>
         <input type="password" name="password" class='txt' value="" /></td></tr><tr>
		 <tr><td width='200px'>Remember Me?</td><td><input type="checkbox" name="remember" value='1' /></td></tr><tr>
		  <tr><td width='200px'>&nbsp;</td><td><input type="submit" name="login" id="login" value="Login" accesskey="s"/></td></tr></table></fieldset>
        </form>	
		<fieldset><legend>Other Links</legend>
		<a href='/forgot/'>Forgot your password?</a><br />
		<a href='/register/'>Register an account</a></fieldset>
	</div>
