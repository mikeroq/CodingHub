<h2>Stats</h2>
<div class='box'>
<fieldset><legend>Hit Stats</legend>
<?php	
$hits = number_format(mysql_num_rows(mysql_query("SELECT ip FROM logs")));
$uhits = number_format(mysql_num_rows(mysql_query("SELECT DISTINCT ip FROM logs")));
$datee = date("n/j/y");	
$dateee = explode("/",$datee);		 
$dateeee = $dateee[1] - 1;
$dateee = $dateee[0] . "/" . $dateeee . "/" . $dateee[2];
$thits = number_format(mysql_num_rows(mysql_query("SELECT ip FROM `todays` WHERE date='$datee'")));
$tuhits = number_format(mysql_num_rows(mysql_query("SELECT distinct ip FROM `todays` WHERE date='$datee'")));	 
$yes = number_format(mysql_num_rows(mysql_query("SELECT distinct ip FROM `todays` WHERE date='$dateee'")));
echo "
<div style='float: left; text-align:left;'>Total Page views:</div> <div style='float: right; text-align:right;'>$hits</div><br />
<div style='float: left; text-align:left;'>Today's Page views:</div> <div style='float: right; text-align:right;'>$thits</div><br />
<div style='float: left; text-align:left;'>Today's Unique visitors:</div> <div style='float: right; text-align:right;'>$tuhits</div><br />
<div style='float: left; text-align:left;'>Yesterday's Unique visitors:</div> <div style='float: right; text-align:right;'>$yes</div><br />";
?>
</fieldset>
<fieldset><legend>Site Stats</legend>
<?php	
$members = number_format(mysql_num_rows(mysql_query("SELECT id FROM members")));	
$mem = mysql_query("SELECT * FROM tutorials WHERE lvl = 0");
$tuts = number_format(mysql_num_rows($mem));
$tutviews = mysql_fetch_assoc(mysql_query("SELECT SUM(`views`) AS 'sum' FROM `tutorials`"));
$views = number_format($tutviews[sum]);
$tutviews = mysql_fetch_assoc(mysql_query("SELECT SUM(`inn`) AS 'sum' FROM `affiliates`"));
$affin = number_format($tutviews[sum]);
$tutviewss = mysql_fetch_assoc(mysql_query("SELECT SUM(`out`) AS 'sum' FROM `affiliates`")) or die(mysql_error());
$affout = number_format($tutviewss[sum]);
$aff = number_format(mysql_num_rows(mysql_query("SELECT `id` FROM `affiliates` WHERE `valid` = '1'")));
$comments = number_format(mysql_num_rows(mysql_query("SELECT id FROM comments")));
$shouts = number_format(mysql_num_rows(mysql_query("SELECT id FROM shouts")));			
$data = exec("uptime"); // Runs a process called Uptime, this will return the servers current uptime and load.
$data = split("load average:", $data); // Splits the “load average” part away from all the other junk.
$data = split(", ", $data[1]); // Get the data in front of “, “ from the “load average” data.
        
if($data[0] <= 0.99){ // If the current load is less than or equal to  0.99.
        $overall = str_replace("0.", "", $data[0]) . '%'; // Remove the 0. and add a % sign to the end.
    }elseif($data[0] >= 1){ // ElseIf the current load is greater than or equal to 1.
        $overall = ''.str_replace(".", "", $data[0]) . '%'; // Remove the . and add a % sign to the end.
    } // End ElseIf.

echo "
<div style='float: left; text-align:left;'>Tutorials:</div> <div style='float: right; text-align:right;'>$tuts</div><br />
<div style='float: left; text-align:left;'>Tutorial Views:</div> <div style='float: right; text-align:right;'>$views</div><br />
<div style='float: left; text-align:left;'>Comments:</div> <div style='float: right; text-align:right;'>$comments</div><br />
<div style='float: left; text-align:left;'>Shouts:</div> <div style='float: right; text-align:right;'>$shouts</div><br />
<div style='float: left; text-align:left;'>Members:</div> <div style='float: right; text-align:right;'>$members</div><br />
<div style='float: left; text-align:left;'>Server Load:</div> <div style='float: right; text-align:right;'>$overall</div><br />
";
?>
</fieldset>	 
<fieldset><legend>Affiliates</legend>
<?php
echo"<div style='float: left; text-align:left;'>Total Affiliates:</div> <div style='float: right; text-align:right;'>$aff</div><br />
<div style='float: left; text-align:left;'>Affiliate hits in:</div> <div style='float: right; text-align:right;'>$affin</div><br />
<div style='float: left; text-align:left;'>Affiliate hits out:</div> <div style='float: right; text-align:right;'>$affout</div><br />";
?>
</fieldset>
</div> 
