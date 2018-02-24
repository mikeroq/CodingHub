<?php
class mysqld {
	
	function connect($server,$user,$pass,$db)
		{
			@mysql_connect($server,$user,$pass);
			@mysql_select_db($db);
		}
	
	function assoc($sql)
		{
			$q = @mysql_query($sql);
			return mysql_fetch_asssoc($q);
		}	
	function rows($sql)	
		{
			$q = @mysql_query($sql);
			return mysql_num_rows($q);
		}  
}
?>
