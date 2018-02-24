<h2>Edit Tutorial</h2>
<div class='box'>
	<?php	 
	$show = 1;
	if ($_SESSION['level'] == 2)
		{
			
			if ($_POST['gotut'])
				{
					$author = $_POST['author'];
					$id = $_GET['id'];
					$title = addslashes(strip_tags($_POST['title'])); 
					$cat = $_POST['cat'];
					$body = addslashes($_POST['body']);	 
					$date = time();	  
					$desc = addslashes(strip_tags($_POST['desc']));	  
					if ($author && $title && $body && $desc)
						{
									 
					$insert = mysql_query("UPDATE `tutorials` SET `cid` = '$cat',`title` = '$title',`desc` = '$desc',`author` = '$author',`tut` = '$body' WHERE `id` = '$id'");
					echo "Tutorial Edited";
					$show = 0;		
					} 
					else {
					echo "<div class='error'>All fields must be filled out</div>";
					$show = 1;
					}
				}
			else if ($show == '1' || !$_POST['gotut']) 
				{
				$id = $_GET['id'];
				$get = mysql_query("SELECT * FROM `tutorials` WHERE `id` = '$id' LIMIT 1");
				
				while($r=mysql_fetch_assoc($get))
					{
					$titler = $r[title];
					$descr = $r[desc];
					$authorr = $r[author];
					$bodyr = $r[tut];
			
					echo "<form action='' method='post'>
					<fieldset>
						<legend>Tutorial Info</legend> 
						<table>
					<tr>
						<td width='200px'>Title</td>
						<td><input type='text' class='txt' name='title' style='width: 250px;' value='$titler'/></td>
					</tr>
					<tr>
						<td width='200px'>Author</td>
						<td><input type='text' class='txt' name='author' style='width: 250px;' value='$authorr' /></td>
					</tr>
					<tr>
						<td width='200px'>Description</td>
						<td><input type='text' class='txt' name='desc' style='width: 250px;' value='$descr'/></td>
					</tr>
					<tr>
						<td width='200px'>Category</td>
						<td><select name='cat'>";
							
							$gett = mysql_query("SELECT * FROM `tcats` ORDER BY `name` ASC");
							while ($rr=mysql_fetch_assoc($gett))
								{
									$cid = $r[cid];
									$rid = $rr[id];
									if($rid == $cid) {
									echo "<option value='$rr[id]' selected>$rr[name]</option>";
									}
									else {
									echo "<option value='$rr[id]'>$rr[name]</option>";
								}									   				   }
							echo "
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
							<td><textarea rows='20' cols='60' name='body'>$bodyr</textarea>
							</td>
							</tr>
						<tr><td width='200px'>&nbsp;</td>
						<td><input type='submit' name='gotut' value='Edit Tutorial' /></td></tr></table</fieldset>
						";
					}
				}  
		}
	else 
		{
			echo "Only members can submit tutorials, please <a href='/loging/'>login</a> or <a href='/register/'>register</a>";
		}
?>
</div>
