<?php
/********************************************|
| CodingHub Forum                            |
|--------------------------------------------|
| Copyright 2006 Mike Roquemore              |
|********************************************/
$id = clean($_GET[id]);
$act = clean($_GET[act]);

switch($act)
	{
		default: 
		// forum / category lists
		$parents = mysql_query("SELECT * FROM `forums` ORDER BY `pos` ASC");
		while ($r=mysql_fetch_assoc($parents))
			{
				echo "<h2>$r[name]</h2><div class='box'>";
				$children = mysql_query("SELECT * FROM `cats` WHERE `pid` = '$r[id]'");	 
				echo "<table width='100%' cellspacing='0' cellpadding='2' border='0'>";
				echo "<tr style='background: #efefef;'>
				<td width='50%'>Name</td>
				<td width='12%' style='text-align: center;'>Topics</td>
				<td width='13%' style='text-align: center;'>Replies</td>
				<td width='25%' style='text-align: right;'>Last Post</td></tr>";
				while ($c=mysql_fetch_assoc($children))
					{
						$posts = mysql_num_rows(mysql_query("SELECT `id` FROM `thread` WHERE `cid` = '$c[id]'"));
						$replies = mysql_num_rows(mysql_query("SELECT `id` FROM `post` WHERE `cid` = '$c[id]'"));
						echo "<tr><td width='50%' valign='top'><a href='/forum/view/$c[id]/'>$c[name]</a><br />$c[desc]</td>
						<td width='12%' style='text-align: center;'>$posts</td>
						<td style='text-align: center;'>$replies</td>";
						$last = mysql_query("SELECt * FROM `post` WHERE `cid` = '$c[id]'");
						$last2 = mysql_num_rows($last);
						if ($last2 == '0')
						{
						$last = "Never";
						}
						else {
						$last = mysql_fetch_assoc($last);
						$name = $last[user];
						$time = $last[time];
						$time = nixtime($time);	
						$last = "By <a href='/profile/$name/'>$name</a><br />$time";
						}
						echo"<td style='text-align: right;'>$last</td></tr>";
					}
				echo "</table>";
				echo "</div>";
			}
		break;
		
		case "cat":
		// viewing category	 
		$id = addslashes(strip_tags($_GET[id]));
		$parent = mysql_fetch_array(mysql_query("SELECT * FROM `cats` WHERE `id` = '$id'")); 
		$child = $parent[name];	   
		$parent = mysql_fetch_array(mysql_query("SELECT `name` FROM `forums` WHERE `id` = '$parent[pid]'")); 
		$parent = $parent[name];  
		echo "<div style='float: right; display: block; margin-top: 5px; margin-right: 5px;'><a style='color: #fff' href='/forum/newtopic/$id/'>New Topic</a></div>
		<h2><a href='/forum/'>$parent</a> » $child</h2><div class='box'>";
		$get = mysql_query("SELECT * FROM `thread` WHERE `cid` = '$id' ORDER BY `lasttime` DESC"); 
		echo "<table width='100%' cellspacing='0' cellpadding='2' border='0'>";
		echo "<tr style='background: #efefef;'>
		<td width='50%'>Topic Name</td>
		<td width='12%' style='text-align: center;'>Views</td>
		<td width='13%' style='text-align: center;'>Replies</td>
		<td width='25%' style='text-align: right;'>Last Post</td></tr>";
		$check = mysql_num_rows($get);
		if ($check =='0')
			{
				echo "<tr><td colspan='4'>There are no threads in this category</td></tr>";
			}
		else {
		while ($r=mysql_fetch_assoc($get))
			{			
				
				$views = $r[views];
				$replies = mysql_num_rows(mysql_query("SELECT id FROM post WHERE cid = $id"));
				$replies--;	
				$last = mysql_query("SELECT * FROM `post` WHERE `tid` = '$r[id]'");
				$last = mysql_fetch_assoc($last);
				$name = $last[user];
				$time = $last[time];
				$time = nixtime($time);	
				$last = "By <a href='/profile/$name/'>$name</a><br />$time";

				echo "<tr><td width='50%' valign='top'><a href='/forum/topic/$r[id]/'>$r[title]</a><br />
				<span style='font-size: 10px;'>Topic starter: <a href='/profile/$r[user]/'>$r[user]</a></span></td>
				<td width='12%' style='text-align: center;'>$views</td>
				<td style='text-align: center;'>$replies</td>
				<td style='text-align: right;'>$last</td></tr>";
			}		   
			}
		echo "</table></div>";
		break;
		
		case "thread":
		// viewing thread
		$get = mysql_query("SELECT * FROM `post` WHERE `tid` = '$id' ORDER BY `id` ASC");
		$get2 = mysql_num_rows($get);
		if ($get2 == '0')
			{
				echo "Invalid Thread";
			}
		else 
			{
						$get2 = '';
				//get thread title
				$gett = mysql_fetch_assoc(mysql_query("SELECT `title` FROM `thread` WHERE `id` = '$id'"));
				$title = $gett[title];   
				$gett = '';
				echo "<h2>$title</h2>";
				// get posts
				while ($r=mysql_fetch_assoc($get))
					{
						// show posts
						// figure out style for posts
						// ok vb style
						// perfect lets get into it	
						$user = mysql_fetch_assoc(mysql_query("SELECT * FROM `members` WHERE `username` = '$r[user]'"));
						$name = $user[username];
						$lvl = $user[level];
						$posts = mysql_num_rows(mysql_query("SELECT `id` FROM `post` WHERE `user` = '$name'"));	 
						$ext = $user[ext];
						$avatar = "$name.$ext";
						if ($lvl == '2')
							{
								$username = "<span style='font-weight: bold; color: #ff0000;'>$name</span>";
							}
						else 
							{ 
								$username = $name; 
							}					   
						$now = time();
						$timeout = 600;
						$timeout = ($now-$timeout);
						if ($user[time] > $timeout)
							{
								$status = "online";
							}
						else 
							{
								$status = "offline";
							}		
						$sig = $bbcode->parse($user[sig]);
						$sig = str_replace("[img]","<img src='",$sig);
						$sig = str_replace("[/img]","' alt='' />",$sig);
						$join = nixtime($user[regdate]);	
						$post = $bbcode->parse($r[post]);
						$post = str_replace("[img]","<img src='",$post);
						$post = str_replace("[/img]","' alt='' />",$post);
						echo "<div class='box'>
						<div style='width: 100%; padding: 0; padding-top: 5px; background: #efefef;'>
						<table cellpadding=\"0\" cellspacing=\"6\" border=\"0\" width=\"100%\">
						<tr>
							<td>
								<a href='/profile/$name/'><img src='/images/avatars/$avatar'   alt='' border='0' /></a>
							</td>
							<td nowrap='nowrap'>
								<div id='postmenu_1268446'>
									<a style='font-size: 14px;' href='/profile/$name/'>$username</a>
									<img class='inlineimg' src='/images/$status.gif' alt='' border='0' />
								</div>
						   </td>			
							<td width='100%'>&nbsp;</td>
							<td valign='top' nowrap='nowrap'>
						   	<div style='font-size: 10px;'>
							<div>Join Date: $join</div>
							";
							if ($user[location]) 
								{
									echo "<div>Location: $user[location]</div>";
								}
							echo "<div>Posts: $posts</div></div></td></tr></table></div>";
							echo "$post<hr />$sig</div>";
							$user ='';
							$post = '';
							$join = '';
							$timeout = '';
						    $sig = '';
							$status = '';
							$name = '';	
							$avatar = '';
							$lvl = '';
							$title = '';
							$username = '';
					}
				// show a quick reply box, since this seems to be omitted
				echo "<h2>Quick Reply</h2>
				<div class='box' style='text-align: center;'>
				<textarea name='post' style='width: 714px; height: 120px; text-align: left;'></textarea>
				<input type='submit' name='postreply' value='Post Quick Reply' style='margin: 0 auto;' />
				</div>";
			}
		break;
	}
?>