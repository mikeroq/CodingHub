<?php		
if (!$_SESSION[username])
	{
		header("Location: /login/");
	}

$maxwidth = "100";
$maxheight = "100";
$get = $_GET['act'];   

switch($get)
	{
		case "upload":
			if (isset($_POST['upload'])) 
				{
					$filetype = $_FILES['ufile']['type'];
					$filetype = substr($filetype,0,5);
					if ($filetype == 'image') 
						{
							$old = $_FILES['ufile']['name'];
							$ext = explode(".",$old);	
							$ext = $ext[1];	 
							$old = $_FILES['ufile']['tmp_name'];
							$newid = "images/avatars/";
							$newid .= "$_SESSION[username].";
							$newid .= $ext;
							$mysock = getimagesize($_FILES['ufile']['tmp_name']);
							$imagewidth = $mysock[0];
							$imageheight = $mysock[1];
							if ($imagewidth <= "$maxwidth" && $imageheight <= "$maxheight") 
								{
									copy($old, $newid);	
									$insert = mysql_query("UPDATE `members` SET `ext` = '$ext' WHERE `username` = '$_SESSION[username]'");
									echo "<div class='error'>Your avatar has been uploaded</div>";
								}
							else 
								{
									echo "<div class='error'>Your image is too large. Max size is 100x100 pixels</div>";
								}
						}
					else 
						{
							echo "<div class='error'>The image you have tried to upload is not an image</div>";
						}
				 } 
						?> 
						
						<h2>Avatar</h2><div class='box'>	  
						<fieldset><legend>Upload Avatar</legend>
						<form action="" method="post" enctype="multipart/form-data">
						<input name="ufile" type="file" id="ufile" size="20" /><br />
						<input type="submit" name="upload" value="Upload" accesskey="s" /></form></fieldset>
						</div>
						<? 
			break;
			case "delete": 	 
			$g = mysql_fetch_assoc(mysql_query("SELECT `ext` FROM `members` WHERE `username` = '$_SESSION[username]'"));
			$ext = $g['ext'];  
			if ($ext)
				{ 
					
					unlink("images/avatars/$_SESSION[username].$ext");		  
					$insert = mysql_query("UPDATE `members` SET `ext` = '' WHERE `username` = '$_SESSION[username]'");
					echo "<div class='error'>Your avatar has been deleted</div>";
				}
			break;	 
		}	  

?> 
