<h2>Submit Tutorial</h2>
<div class='box'>
	<?php
	if ($_SESSION['username'])
		{
			if ($_POST['gotut'])
				{
					$author = $_SESSION['username'];
					if ($_SESSION['username'] == 'mikeroq')
						{
							$author = $_POST['author'];
						}
					$title = addslashes(strip_tags($_POST['title'])); 
					$cat = $_POST['cat'];
					$body = addslashes($_POST['body']);	 
					$date = time();	  
					$desc = addslashes(strip_tags($_POST['desc']));	  
					if ($author && $title && $body && $desc)
						{
									 
					$insert = mysql_query("INSERT INTO `tutorials` (`cid`,`title`,`desc`,`author`,`tut`,`date`,`views`,`lvl`) VALUES ('$cat','$title','$desc','$author','$body','$date','1','1')") or die(mysql_error());
					$test = mysql_num_rows(mysql_query("SELECT * FROM `tutorials` WHERE `title` = '$title'"));
					if ($test != '1')
						{
							echo "Your tutorial could not be submitted at this time, please try again later, or send your tutorial via the contact page";
							$show = 0;
						}
					else {
					echo "Your tutorial is awaiting admin approval. Thanks for adding to our content!";
					$show = 0;		
					}
					} 
					else {
					echo "<div class='error'>All fields must be filled out</div>";
					$show = 1;
					}
				}
			else if ($show = '1' || !$_POST['submit']) 
				{
			?>
	<form action='' method='post'>
		<fieldset>
			<legend>Tutorial Info</legend> 
			<table>
					<tr>
						<td width='200px'>Title</td>
						<td><input type='text' class='txt' name='title' style='width: 250px;'/></td>
					</tr>
					<?php
					 if ($_SESSION[level] == 2)
					 	{
						?>
							<tr>
						<td width='200px'>Author</td>
						<td><input type='text' class='txt' name='author' style='width: 250px;' value='<?=$_SESSION[username]?>' /></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td width='200px'>Description</td>
						<td><input type='text' class='txt' name='desc' style='width: 250px;'/></td>
					</tr>
					<tr>
						<td width='200px'>Category</td>
						<td><select name='cat'>
							<?php
							$get = mysql_query("SELECT * FROM `tcats` ORDER BY `name` ASC");
							while ($r=mysql_fetch_assoc($get))
								{
									echo "<option value='$r[id]'>$r[name]</option>";
								}									   
							?>
							</select>  
						</td></tr></table>
				</fieldset>
				<fieldset>
					<legend>Tutorial</legend>
						<table>
							<td width='200px' valign='top'>Tutorial Body<br />
							BBCODE: <b>Enabled</b>
							<br /><font size='1'>
							[php][/php] - PHP Code<br />
							[code][/code] - Code<br />
							[b][/b] - Bold<br />
							[u][/u] - Underline<br />
							[i][/i] - Italics<br />
							[url][/url] - Link<br />
							[url=][/url] - Link with link text<br />
							[img][/img] - Image<br />
							
							</font>						
							</td>
							<td><textarea rows='20' cols='60' name='body'></textarea>
							</td>
							</tr>
						<tr><td width='200px'>&nbsp;</td>
						<td><input type='submit' name='gotut' value='Submit Tutorial' /></td></tr></table</fieldset>
<?php
}
}
else {
echo "Only members can submit tutorials, please <a href='/loging/'>login</a> or <a href='/register/'>register</a>";
}
?>
</div>
