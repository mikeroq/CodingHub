<?php 
if(!isset($_GET['page'])){ 
$page = 1; 
}else{
$page = $_GET['page']; 
} 
$max_results = 7;
$from = (($page * $max_results) - $max_results);
$list = mysql_query("SELECT * from logs order by id ASC LIMIT $from,$max_results");
while ($r=mysql_fetch_array($list)) {
$ref = $r['ref'];
if (!$ref) {
$ref = "None Recorded";
}
else {
$ref = "<a href='$ref'>$ref</a>";
}

if ($logged[level] == "2")
	{
		$ip = $r[ip];
	}
else {
$ip = $r[ip];
$ip = explode(".",$ip);
$ip = "$ip[0].$ip[1].X.X";
$r[host] = "";	  
$date = date("F jS, Y g:ia",$r[date]);
}
echo "<div class='box'>
IP/Host: $ip / $r[host]<br />
Page accessed: <a href='$r[page]'>$r[page]</a><br />
Referer: $ref<br />
Browser: $r[agent]<br />
Date: $date</div>";
} 
$total_results = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM logs"),0);
echo "<span class='page'>Pages:</span> ";
$total_pages = ceil($total_results/$max_results);	
if ($page > 1)
	{
		$page2 = $_GET['page'];
		$page2--;
		echo "<a href='/logs/page/$page2/' class='page'>«</a> ";	
	}		
for($i = 1; $i <= $total_pages; $i++){
if(($page) == $i){
echo "<span class='page2'>$i</span>&nbsp;";
}else{
echo "<a href='/logs/page/$i/' class='page'>$i</a> ";

} 
}	
if ($page != $total_pages)
	{
		$page = $_GET['page'];
		$page++;
		echo "<a href='/logs/page/$page/' class='page'>»</a> ";	
	}
echo "<br /><br />";
?>
