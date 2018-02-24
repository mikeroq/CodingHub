<h2>Report</h2>
<div class='box'>
<?php
$id = htmlspecialchars(addslashes($_GET['id']));
if (!$id)
	{
		echo "No tutorial selected to report";
	}
else {
$tut = mysql_fetch_assoc(mysql_query("SELECT id,title,author FROM `tutorials` WHERE `id` = '$id' LIMIT 1"));
echo "<b>Tutorial</b>: $tut[title]<br /><b>Author</b>: $tut[author]";
echo "<br /><br />Tutorials cannot be reported at this time";
}
?>
</div>