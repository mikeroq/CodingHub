<?php
$id = addslashes(strip_tags($_GET[id]));
$get = mysql_query("SELECT * from `ads` where id = '$id'");
	$aff = mysql_fetch_array($get);
	$update = mysql_query("update `ads` set clicks = clicks +1 where `id` = '$id'");
	header("Location: $aff[url]");
	?>