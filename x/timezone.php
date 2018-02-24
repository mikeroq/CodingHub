<?
  $timezone_local = $_GET['t'];
  $time = time();
  $timezone_offset = date("Z");
  $timezone_add = round($timezone_local*60*60);
  $time = round($time-$timezone_offset+$timezone_add);
  $date = date("l dS of F Y h:i:s A", $time);
  echo $date;
?> 