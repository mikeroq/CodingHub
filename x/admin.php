<script type='text/javascript'>
function cdelete(delUrl,URL) {
	if (confirm("Are you sure you want to approve this tutorial?")) {
		document.location = delUrl;
	}
	else if(alert("The tutorial will not be approved."))
	{
		document.location = URL;	
		}
}
function cdelete2(delUrl,URL) {
	if (confirm("Are you sure you want to delete this tutorial?")) {
		document.location = delUrl;
	}
	else if(alert("The tutorial will not be deleted"))
	{
		document.location = URL;	
		}
}
</script>
<h2>Admin</h2>
<div class='box'>
<?php
if ($_SESSION[level] == 2)
	{
?>
<fieldset><legend>Approve Tutorials</legend>
<?php	 
switch ($_GET[act])
{
	default:
$get = mysql_query("SELECT * FROM `tutorials` WHERE lvl = '1'");
$check = mysql_num_rows($get);
if ($check == '0')
{
echo "No tutorials are awaiting to be approved";
}
else {
while ($r=mysql_fetch_assoc($get))
	{
		echo "<a href='/tutorials/view/$r[id]'>$r[title]</a> -  <a href='' onclick='javascript:cdelete(\"/admin/app/$r[id]/\",\"/admin/\");'>Approve</a> | <a href='' onclick='javascript:cdelete2(\"/admin/del/$r[id]/\",\"/admin/\");'>Deny</a><br />";
	} 
}
break;
case "del":
$delete = mysql_query("DELETE FROM `tutorials` WHERE `id` = '$_GET[id]' LIMIT 1");
header("Location: /admin/");
break;
case "app":
$delete = mysql_query("UPDATE `tutorials` SET `lvl` = '0' WHERE `id` = '$_GET[id]' LIMIT 1");
header("Location: /admin/");
break;	
}
?>
</fieldset>
<fieldset><legend>Approve Affiliates</legend>
<?php	 
switch ($_GET[act])
{
	default:
$get = mysql_query("SELECT * FROM `affiliates` WHERE valid = '0'");
$check = mysql_num_rows($get);
if ($check == '0')
{
echo "No affiliates are awaiting to be approved<br />";
}
else {
while ($r=mysql_fetch_assoc($get))
	{
		echo "<a href='$r[url]'>$r[name]</a> - <a href='' onclick='javascript:cdelete(\"/admin/appa/$r[id]/\",\"/admin/\");'>Approve</a> | <a href='' onclick='javascript:cdelete2(\"/admin/dela/$r[id]/\",\"/admin/\");'>Deny</a><br />";
	} 
} 
echo "<a href='/addaff/'>Add Affiliate</a>";
break;
case "dela":
$delete = mysql_query("DELETE FROM `affiliates` WHERE `id` = '$_GET[id]' LIMIT 1");
header("Location: /admin/");
break;
case "appa":
$delete = mysql_query("UPDATE `affiliates` SET `valid` = '1' WHERE `id` = '$_GET[id]' LIMIT 1");
header("Location: /admin/");
break;	
}
?>
</fieldset>	
<fieldset><legend>Manage Tutorials</legend>
<?											 
$get = mysql_query("SELECT * FROM `tutorials` WHERE lvl = '0'");
while ($r=mysql_fetch_assoc($get))
	{
		echo "<a href='/tutorials/view/$r[id]'>$r[title]</a> - <a href='/tutedit/$r[id]/'>Edit</a> | <a href='' onclick='javascript:cdelete2(\"/admin/del/$r[id]/\",\"/admin/\");'>Delete</a><br />";
	}
?></fieldset> 
<fieldset><legend>Manage Tutorial Categorys</legend>
<?											 
$get = mysql_query("SELECT * FROM `tcats` ORDER BY `name`");
while ($r=mysql_fetch_assoc($get))
	{
		echo "$r[name] - <a href='/tutcat/edit/$r[id]/'>Edit</a> | <a href='' onclick='javascript:cdelete2(\"/admin/delt/$r[id]/\",\"/admin/\");'>Delete</a><br />";
	}  
	echo "<a href='/tutcat/'>Add Tutorial Category</a>";

?></fieldset>
<? 
}
else {
echo "Get the fuck out you little bitch, your IP address has just been submitted to INTERPOL. FUCK OFF!";
}
?> 
</div>