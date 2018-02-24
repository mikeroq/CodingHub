<?php	   
$user = $_GET['user']; 
$id = $_GET['id'];

if ($user) {
$getuserinfo="SELECT * from members where username ='$user'";	 
}
if ($id) {										
$getuserinfo="SELECT * from members where id ='$id'";	
}
$getuserinfo2=mysql_query($getuserinfo) or die("Could not get user info");
$g=mysql_fetch_array($getuserinfo2);
if (!$g[username]) {
echo "<div class='box'>Invalid user profile</div>";
}
else {			
    $Level = $g['level'];
	$Level = str_replace("0","Member",$Level);
	$Level = str_replace("1","Moderator",$Level);
	$Level = str_replace("2","<span style='color: #ff0000'><b>Admin</b></span>",$Level);
	$Level = str_replace("3","<b><u>Banned</u></b>",$Level);  
	if (!$g[aim]) {
	$g[aim] = "Not Specified";
	} 
	if (!$g[msn]) {
	$g[msn] = "Not Specified";
	}
	if (!$g[yim]) {
	$g[yim] = "Not Specified";
	}
	if (!$g[gtalk]) {
	$g[gtalk] = "Not Specified";
	} 
	if (!$g[location]) {
	$g[location] = "CodingHub";
	}				
	if (!$g[interests]) {
	$g[interests] = "Not Specified";
	}									   
	$use2r = $_SESSION['username'];
	$ext = $g['ext'];
	$path = "/images/avatars/$use2r.$ext"; 	   
    $comments = mysql_num_rows(mysql_query("SELECT * FROM `comments` WHERE `name` = '$user'"));
	$tutorials = mysql_num_rows(mysql_query("SELECT * FROM `tutorials` WHERE `author` = '$user'"));
	if ($ext)
		{
			$avatar = '<img src="'.$path.'" alt="" />';
		}
	$since = date_time("F j<\s\u\p>S</\s\u\p>, Y",$g[regdate],'n');   
	$dd = date_time('F j<\s\u\p>S</\s\u\p>, Y g:ia',$g[time],'n');
  echo "<h2>$g[username]</h2><div class='box'>";
  echo "<fieldset><legend>Basic Info</legend>";
  echo "<div style='float: left;'><table><tr><td width='200'>Position</td><td>$Level</td></tr>
  		<tr><td width='200'>Page Views</td><td>$g[pages]</td></tr>	 
		<tr><td width='200'>Tutorials Submitted</td><td>$tutorials</td></tr>
		<tr><td width='200'>Comments Posted</td><td>$comments</td></tr>
		<tr><td width='200'>Member Since</td><td>$since</td></tr>
		<tr><td width='200'>Last Visited</td><td>$dd</td></tr></table></div>
		<div style='float: right;'>$avatar</div><div style='clear: both;'></div></fieldset>
		
		";
  echo "<fieldset><legend>Contact Info</legend><table><tr><td width='200'>Website</td><td>";
  if ($g[sitetitle]&&$g[siteurl]) {  
  echo "<a href='$g[siteurl]'>$g[sitetitle]</a>";
  }
  else if ($g[siteurl]) {
  echo "<a href=$g[siterl]>$g[siteurl]</a>";
  }
  else {
  echo "Not Specified";
  }
  echo "</td></tr>
  <tr><td width='200'>Aim</td><td>$g[aim]</td></tr>	 
  <tr><td width='200'>Msn</td><td>$g[msn]</td></tr>
  <tr><td width='200'>Google Talk</td><td>$g[gtalk]</td></tr>
  <tr><td width='200'>Yahoo</td><td>$g[yim]</td></tr></table></fieldset>"; 
   echo "<fieldset><legend>Personal Info</legend><table><tr>
  <tr><td width='200'>Location</td><td>$g[location]</td></tr>	 
  <tr><td width='200'>Interests</td><td>$g[interests]</td></tr></table></fieldset>
  ";   
  if ($g[sig])
  	{
 	 	$sig = $bbcode->parse($g['sig']);	
		$sig = str_replace("[img]","<img src='",$sig);
		$sig = str_replace("[/img]","' alt='' />",$sig);			   
  		echo "<fieldset><legend>Signature</legend>$sig</fieldset>";
	} 
	echo "</div>";
  }
?>
