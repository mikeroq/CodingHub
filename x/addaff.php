<h2>Add Affiliate</h2>
<div class='box'>
	<?php
	if ($_SESSION[level] == 2)
		{
			if ($_POST['goaff'])
				{
					$name = $_POST['name'];
					$url = $_POST['url'];
					$img = $_POST['img'];
					$valid = $_POST['valid'];
					$insert = mysql_query("INSERT INTO `affiliates` (`name`,`url`,`img`,`valid`) VALUES ('$name','$url','$img','$valid')") or die(mysql_error());
					$get = mysql_query("SELECT * FROM `affiliates` WHERE `url` = '$url'");
					$get2 = mysql_fetch_assoc($get);
					$test = mysql_num_rows($get);
					if ($test != '1')
						{
							echo "Affiliate add failed";
							
						}
					else {
					echo "Affiliate has been added!<br /><br />
					<b>URL:</b> http://codinghub.com/affiliates/in/$get2[id]/<br />
					<b>IMG:</b> http://codinghub.com/images/aff.png";
					}
				}
			?>
	<form action='' method='post'>
		<fieldset>
			<legend>Affiliate</legend> 
			<table>
					<tr>
						<td width='200px'>Name</td>
						<td><input type='text' class='txt' name='name' style='width: 250px;'/></td>
					</tr>
						<tr>
						<td width='200px'>URL</td>
						<td><input type='text' class='txt' name='url' style='width: 250px;'/></td>
					</tr>
							<tr>
						<td width='200px'>Image URL</td>
						<td><input type='text' class='txt' name='img' style='width: 250px;' /></td>
					</tr>	 
						<tr>
						<td width='200px'>Type</td>
						<td>
						<select name='valid'>
						<option value='1'>Affiliate</option>
						<option value='2'>Topsite</option>
						<option value='0'>Deactive</option>
						</select>
						</td>
					</tr>
						<tr><td width='200px'>&nbsp;</td>
						<td><input type='submit' name='goaff' value='Add Affiliate' /></td></tr></table</fieldset>
<?php
}
else {
echo "Admin access only!";
}
?>
</div>
