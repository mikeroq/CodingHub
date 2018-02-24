<?php
$get = mysql_query("SELECT url FROM affiliates WHERE valid = '1'");
while ($r=mysql_fetch_assoc($get))
	{
		$url = $r[url];
		$url = explode("http://",$url);
		$url = $url[1];	
		$url = explode("/",$url);
		$url = $url[0];
		echo "http://$url<br />";
	}
?>