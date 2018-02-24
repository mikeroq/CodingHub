<h2>Tutorial Category</h2>
<div class='box'>
	<?php
	if ($_SESSION['level'] == 2)
		{
			switch($_GET[act])
				{
					default:
						if ($_POST['gotut'])
							{
								$name = $_POST['name'];
								$icon = $_POST['icon'];
								$insert = mysql_query("INSERT INTO `tcats` (`icon`,`name`) VALUES ('$icon','$name')");
								$test = mysql_num_rows(mysql_query("SELECT * FROM `tutorials` WHERE `name` = '$name'"));
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
						<form action='/tutcat/' method='post'>
						<fieldset>
						<legend>Tutorial Category</legend> 
						<table>
						<tr>
						<td width='200px'>Name</td>
						<td><input type='text' class='txt' name='name' style='width: 250px;'/></td>
						</tr>
						<tr>
						<td width='200px'>Icon</td>
						<td><input type='text' class='txt' name='icon' style='width: 250px;' /></td>
						</tr>
						<tr><td width='200px'>&nbsp;</td>
						<td><input type='submit' name='gotut' value='Add Category' /></td></tr></table</fieldset>
						<?php
						}
						break;
						case "edit":  
						$id = $_GET['id']; 
						$get = mysql_fetch_assoc(mysql_query("SELECT * FROM `tcats` WHERE `id` = '$id' LIMIT 1"));
						$namee = $get[name];
						$iconn = $get[icon];
						if ($_POST['edittut'])
							{
								$name = $_POST['name'];
								$icon = $_POST['icon'];
								$insert = mysql_query("UPDATE `tcats` SET `icon` = '$icon', `name` = '$name' WHERE `id` = '$id'");
								
								echo "Tutorial category edited";
								$show = 0;		
								
							}
						else if ($show = '1' || !$_POST['submit']) 
							{
				
							?>
						<form action='/tutcat/edit/<?=$id?>/' method='post'>
						<fieldset>
						<legend>Tutorial Category</legend> 
						<table>
						<tr>
						<td width='200px'>Name</td>
						<td><input type='text' class='txt' name='name' value='<?=$namee?>' style='width: 250px;'/></td>
						</tr>
						<tr>
						<td width='200px'>Icon</td>
						<td><input type='text' class='txt' name='icon' value='<?=$iconn?>' style='width: 250px;' /></td>
						</tr>
						<tr><td width='200px'>&nbsp;</td>
						<td><input type='submit' name='edittut' value='Edit Category' /></td></tr></table</fieldset>
						<?php
						}
						break;
					}
				}
						else {
						echo "Admin only";
						}
?>
</div>
