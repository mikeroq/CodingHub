<?php
$cat = htmlspecialchars(addslashes($_GET['cid']));
$sub = htmlspecialchars(addslashes($_GET['sid'])); 
$id = htmlspecialchars(addslashes($_GET['id'])); 
if ($cat)
	{
		if(!isset($_GET['page']))
			{ 
				$page = 1; 
			}
		else
			{
				$page = $_GET['page']; 
			} 
		$max_results = 20;
		$from = (($page * $max_results) - $max_results);	 
		$get = mysql_query("SELECT * FROM `tutorials` WHERE `cid` = '$cat' AND `lvl` = '0' ORDER BY `id` DESC LIMIT $from,$max_results");
		$name = mysql_fetch_array(mysql_query("SELECT `name` FROM `tcats` WHERE `id` = '$cat'"));
		$name = $name['name'];
		echo "<h2>Tutorials » $name</h2><div class='box'>";
		echo "<table cellspacing='0' cellpadding='3' width='100%'>
			<tr>
				<td width='60%'>Title / Description</td>
				<td width='9%'>Author</td>
				<td width='13%' style='text-align: center;'>Views</td>
				<td width='13%' style='text-align: center;'>Comments</td>
				<td width='5%' style='text-align: right;'>Added</td>
			<tr>";
			$i = 0;
		while ($r=mysql_fetch_assoc($get))
			{					
				
				$date = date_time("n/j/Y",$r[date],'n');		  
				$comments = mysql_num_rows(mysql_query("SELECT * FROM `comments` WHERE `tid` = '$r[id]'"));
				echo "<tr class='row".($i & 1)."'><td><a href='/tutorials/view/$r[id]/'><b>$r[title]</b></a><br />$r[desc]</td><td style='vertical-align: top;'>$r[author]</td><td style='text-align: center; vertical-align: top;'>$r[views]</td><td style='text-align: center; vertical-align: top;'>$comments</td><td style='text-align: right; vertical-align: top;'>$date</td></tr>";
				/*echo "<a href='/tutorials/view/$r[id]/' style='color: #ffffff;'>$r[title]</a>
				$r[desc]<br />
				b>Author</b>: <a href='/profile/$r[author]/'>$r[author]</a> <b>Views</b>: $r[views] <b>Comments</b>: $comments <b>Submitted</b>: $date";
				*/
				$i++;
			} 
		$total_results = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM `tutorials` WHERE `cid` = '$cat'"),0);
		echo "</table></div><span class='page'>Pages:</span> ";
		$total_pages = ceil($total_results/$max_results);	
		if ($page > 1)
			{
				$page2 = $_GET['page'];
				$page2--;
				echo "<a href='/tutorials/$cat/page/$page2/' class='page'>«</a> ";	
			}		
		for ($i = 1; $i <= $total_pages; $i++)
			{
				if ($page == $i)
					{
						echo "<span class='page2'>$i</span>&nbsp;";
					}
				else
					{
						echo "<a href='/tutorials/$cat/page/$i/' class='page'>$i</a> ";

					} 
			}	
		if ($page < $total_pages)
			{
				$page = $_GET['page'];
				$page++;
				echo "<a href='/tutorials/$cat/page/$page/' class='page'>»</a> ";	
			}
		echo "<br /><br />";
	} 
else if ($id)
	{
		$get = mysql_query("SELECT * FROM `tutorials` WHERE `id` = '$id' LIMIT 1");  
		$update = mysql_query("UPDATE `tutorials` SET views = views + 1 WHERE `id` = '$id'");
		$r=mysql_fetch_assoc($get);	  
		$body = $r['tut'];   
		$body = htmlspecialchars(stripslashes($body));
		$body = $bbcode->parse($body);
		$body = str_replace("[img]","<img src='",$body);
		$body = str_replace("[/img]","' alt='' />",$body);
		$date = date_time("M j, Y",$r[date],'n');
		$numcom = mysql_num_rows(mysql_query("SELECT `id` FROM `comments` WHERE `tid` = '$id'"));	
		$auth_com = mysql_num_rows(mysql_query("SELECT `id` FROM `comments` WHERE `name` = '$r[author]'"));
		$auth_tuts = mysql_num_rows(mysql_query("SELECT `id` FROM `tutorials` WHERE `author` = '$r[author]'"));
		$auth_posts = mysql_num_rows(mysql_query("SELECT `id` FROM `post` WHERE `user` = '$r[author]'"));
		
		echo "<div class='box_top' style='font-size: 18px;'>
$r[title]
</div>
<div id='main_area'>

<div id='right'>
	About <a href='#'>$r[author]</a><br />
	BIO Here
	<p><b>$r[author]'s Stats</b><br />
	Submitted <a href='#'>$auth_tuts tutorials</a><br />
	Commented <a href='#'>$auth_com times</a><br />
	Made <a href='#'>$auth_posts forum posts</a>
	</p>
	<p><b>Tutorial Stats</b><br />
	Views: $r[views]<br />
	Comments: $numcom<br />
	</p>
	<p><a href='#'>Report This Tutorial</a></p>
</div>

	<div id='left'>
	<div id='infobar'>
	Author: <a href='#'>$r[author]</a>. Submitted $date.
	</div>
	<div id='content'>
	<p>$body</p>
	<hr style='margin: 0; padding: 0; border-top: 1px #777 solid;' />
	<h4 style='margin: 3px 0px 3px 0px; display: inline;'>Comments</h4>";
	////////// comments //////
		
							  if(!isset($_GET['page'])){ 
							  $page = 1; 
							  }else{
							  $page = $_GET['page']; 
							  } 
							  $max_results = 7;
							  $from = (($page * $max_results) - $max_results);
							  $comments = mysql_query("SELECT * FROM `comments` WHERE `tid` = '$id' ORDER BY `date` DESC LIMIT $from,$max_results");
							  // show comments //
							  if (mysql_num_rows($comments) > 0)
							  {
							  while ($r=mysql_fetch_assoc($comments))
							  	{										   
									$date = date_time('',$r[date],'u');	
									$body = $r['comment'];   
							        $body = htmlspecialchars($body);
							        $body = $bbcode->parse($body);	
									echo "<div class='box'><a href='/profile/$r[name]/'>$r[name]</a> $date<hr />$body</div>";	
								}						  
							  // pagination //
							  $total_results = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM `comments` WHERE `tid` = '$id'"),0);
								echo "<span class='page'>Pages:</span> ";
								$total_pages = ceil($total_results/$max_results);	
								if ($page > 1)
									{
										$page2 = $_GET['page'];
										$page2--;
										echo "<a href='/tutorials/view/$cid/page/$page2/' class='page'>«</a> ";	
									}		
								for($i = 1; $i <= $total_pages; $i++){
								if(($page) == $i){
								echo "<span class='page2'>$i</span>&nbsp;";
								}else{
								echo "<a href='/tutorials/view/$cid/page/$i/' class='page'>$i</a> ";
								
								} 
								}	
								if ($page != $total_pages)
									{
										$page = $_GET['page'];
										$page++;
										echo "<a href='/tutorials/view/$cid/page/$page/' class='page'>»</a> ";	
									}
								echo "<br /><br />";
								}
							  // end pagination //
							  // start post comment //	  
							  if ($_SESSION['username'])
							  	{
							  ?>
							  <h2>Post Comment</h2><div class='box'>
							  <form action='/?x=comments&amp;id=<?=$id?>' method='post'>
							  <textarea cols='60' rows='4' name='comment'></textarea><br />
							  BBCODE: <b>Enabled</b><br />
							  <input type='submit' name='go' value='Post Comment' />
							  </div>							  
							  <?php	
							  }
							  else {
							  echo "<div class='box'>You must be a member to comment, <a href='?x=login'>login</a> or <a href='?x=register'>register</a></div>";
							  }
	echo "
	</div>
</div>
</div></div>";
/*		
		// views by ////
		echo "<h2>Viewed By</h2><div class='box'>";
		$sql = mysql_query("SELECT * FROM `logs` WHERE `page` LIKE '%tutorials&id=$r[id]%' AND `user` != 'Guest' GROUP BY user");
		$i = 1;
		while ($userrr = mysql_fetch_array($sql))
			{
				if ($i != 1) { $start_noteee = ", "; }
				$u = mysql_fetch_array(mysql_query("SELECT * FROM `members` WHERE `username` = '$userrr[user]'"));	
				if ($u[level] == "2")
					{
						$users_onlineee .= "$start_noteee<a href='/profile/$userrr[user]/'><span style='color: #ff0000; font-weight: bold;'>$userrr[user]</span></a>";
					}
				else 
					{
						$users_onlineee .= "$start_noteee<a href='/profile/$userrr[user]/'>$userrr[user]</a>";
					}
				$i++;
			}	
		echo "$users_onlineee";
		$sql = mysql_query("SELECT DISTINCT `ip` FROM `logs` WHERE `page` LIKE '%tutorials&id=$r[id]%' AND `user` = 'Guest' GROUP BY `ip`");
		$guests = mysql_num_rows($sql);
		echo "<br />Guests: $guests";
		echo "</div>"; */
		
					   }
					   ?>
