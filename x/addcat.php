<h2>Submit Tutorial</h2>
<div class='box'>
	<?php
	if ($_SESSION['username'] == 'mikeroq')
		{
			if ($_POST['gotut'])
				{
					$nammme = $_POST['nammme'];
					$icon = $_POST['icon'];
					$insert = mysql_query("INSERT INTO `tcats` (`icon`,`name`) VALUES ('$icon','$nammme')");
					$test = mysql_num_rows(mysql_query("SELECT * FROM `tutorials` WHERE `name` = '$nammme'"));
					if ($test != '1')
						{
							echo "Tutorial category addition failed.";
							$show = 0;
						}
					else {
					echo "Tutorial category added";
					$show = 0;		
					}
				}
			else if ($show = '1' || !$_POST['submit']) 
				{
			?>
	<form action='' method='post'>
		<fieldset>
			<legend>Tutorial Category</legend> 
			<table>
					<tr>
						<td width='200px'>Name</td>
						<td><input type='text' class='txt' name='nammme' style='width: 250px;'/></td>
					</tr>
							<tr>
						<td width='200px'>Icon</td>
						<td><input type='text' class='txt' name='icon' style='width: 250px;' /></td>
					</tr>
						<tr><td width='200px'>&nbsp;</td>
						<td> <input type='submit' name='gotut' value='Add Category' /></td></tr></table</fieldset>
<?php
}
}
else {
echo "Only members can submit tutorials, please <a href='/loging/'>login</a> or <a href='/register/'>register</a>";
}
?>
</div>
