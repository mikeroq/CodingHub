<h2>Apply</h2>
<div class='box'>
	<?php
	if ($_SESSION[username])
		{
			if ($_POST['goaff'])
				{
					$name = $_POST['name'];
					$url = $_POST['url'];
					$img = $_POST['img'];
					$insert = mysql_query("INSERT INTO `affiliates` (`name`,`url`,`img`,`valid`) VALUES ('$name','$url','$img','0')") or die(mysql_error());
					$get = mysql_query("SELECT id FROM `affiliates` WHERE `url` = '$url'");
					$get2 = mysql_fetch_assoc($get);
					$test = mysql_num_rows($get);
					if ($test != '1')
						{
							echo "Affiliate add failed";
							
						}
					else {
					echo "Your affiliate request has been added, please use the following URL and image code below.<br />
					<b>URL:</b> http://codinghub.com/affiliates/in/$get2[id]/<br />
					<b>IMG:</b> http://codinghub.com/images/aff.png<br /><br />
					You should recieve an email if you have been approved or denied within 24 hours.";
					}
				} 
				else {
			?>
	<form action='' method='post'>
		<fieldset>
			<legend>Site Details</legend> 
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
						<tr><td width='200px'>&nbsp;</td>
						<td><input type='submit' name='goaff' value='Add Affiliate' /></td></tr></table</fieldset>
<?php
}
}
else {
echo "Only members can apply for affiliation.";
}
?>
</div>
<div class='boxtop'><h2>Affiliates</h2></div>
<div class='box'><?php
$get = mysql_query("SELECT * FROM `affiliates` WHERE `valid` = '1' ORDER BY `inn` DESC");
while ($r=mysql_fetch_array($get))
	{
		echo "<a href='http://codinghub.com/affiliates/out/$r[id]/' title='In: $r[inn] // Out: $r[out]'><img src='$r[img]' style='border: 0px;' width='88' height='31' alt='' /></a> ";
	}
$mode = $_GET['mode'];	 
$id = addslashes($_GET[id]);
	switch($mode)
	{
	case "out":
	$get = mysql_query("SELECT * from `affiliates` where id = '$id'");
	$aff = mysql_fetch_array($get);
	$update = mysql_query("update `affiliates` set out = out +1 where `id` = '$id'");
	header("Location: $aff[url]");
	break;
	case 'in':
	if ($_GET[id])
	{
	$update = mysql_query("update `affiliates` set inn = inn +1 where `id` = '$id'");
	header("Location: http://codinghub.com/");
	}
	break;
	}
?></div> 
<div class='boxtop'><h2>Topsites</h2></div>
<div class='box'><?php
$get = mysql_query("SELECT * FROM `affiliates` WHERE `valid` = '2' ORDER BY `inn` DESC");
while ($r=mysql_fetch_array($get))
	{
		echo "<a href='http://codinghub.com/affiliates/out/$r[id]/' title='In: $r[inn] // Out: $r[out]'><img src='$r[img]' style='border: 0px;' width='88' height='31' alt=''/></a> ";
	}
	?></div> 
	
	<div class='boxtop'><h2>Affiliation Rules</h2></div>
<div class='box'>
To become an affiliate of this site you must meet the following rules:
<ul>
	<li><b>100+ unique</b> hits per day</li>
	<li>Quality content</li>
	<li>Related content to web design and development</li>
	<li>No free templates or free forums</li>
	<li>Must have a TLD (top level domain eg. .com, .net, .co.uk. .com.au, .org)</li>
	<li>Have our affiliate button up on your site before you apply</li>	  
<li>Exceptions can be made to the rules, sign up anyway, you might just get approved</li>
</ul>
<img src='../images/aff.png' alt='' />
</div>						   
