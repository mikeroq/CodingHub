<?php
$crlf=chr(13).chr(10);
$br='<br />'.$crlf;
$p='<br /><br />'.$crlf;
foreach ($_SERVER as $key => $datum)
	{
		echo $key.' : '.$datum.$br;
	}
echo $p;
?>