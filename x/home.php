<div class='box_top big double'>
	<div class='left'>
	Recently Added Tutorials
	</div>
	<div class='right'>
	
	</div>
	<div class='clear'></div>
</div>
<div class='main_area_two'>
<?php
$get = mysql_query("SELECT * FROM `tutorials` WHERE `lvl` = '0' ORDER BY `date` DESC LIMIT 8");
$i = 0;

while ($r=mysql_fetch_assoc($get))
	{																 
		
		$i++;
		if ($i == 2) { $two = " latest_two"; $i = 0; }
			else { $two = ''; }
		$cat = mysql_fetch_assoc(mysql_query("SELECT name FROM `tcats` WHERE `id` = '$r[cid]'"));
		$cat = $cat[name];
		$date_added = date_time('n/j/y',$r[date],"nt");
		echo "<div class='latest_block$two'>
	<img src='images/cat_icons/php.png' /><span class='title'><a href='#'>$r[title]</a></span>
	<div class='desc'>$r[desc]</div>
	<span class='author'>Submitted by: <a href='#'>$r[author]</a> on $date_added</span>
	<div class='clear'></div>
</div>";

	}
?>
<!--

<div class='latest_block latest_two'>
	<img src='images/cat_icons/html_css.png' /><span class='title'><a href='#'>Naresh's TechTuts Layout</a></span>
	<div class='desc'>Learn how to recreate the layout that started it all on TechTuts back in the hayday of 2005, when Adam wasn't here and...</div>
	<span class='author'>Submitted by: <a href='#'>Adam Bray</a> on August 4<sup>th</sup>, 2011</span>
	<div class='clear'></div>
</div>
<div class='latest_block'>
	<img src='images/cat_icons/photoshop.png' /><span class='title'><a href='#'>Steal a site's PSD with Photoshop!</a></span>
	<div class='desc'>Learn to use the little known trick in photoshop to reverse engineer a PSD file that gives you a full copy of the...</div>
	<span class='author'>Submitted by: <a href='#'>Adam Asshole</a> on August 4<sup>th</sup>, 2011</span>
	<div class='clear'></div>
</div>
<div class='latest_block latest_two'>
	<img src='images/cat_icons/webmaster.png' /><span class='title'><a href='#'>Learn how to mismanage a Website!</a></span>
	<div class='desc'>Learn how to buy a decent website and turn it into a pile of steaming shit in less then 10 steps with my... </div>
	<span class='author'>Submitted by: <a href='#'>Dan</a> on August 4<sup>th</sup>, 2011</span>
	<div class='clear'></div>
</div>
<div class='latest_block'>
	<img src='images/cat_icons/php.png' /><span class='title'><a href='#'>Naresh's Usersystem Redux!</a></span>
	<div class='desc'>Learn how to create a dynamic, scaling, robust, and secure user system. Coded from the ashes of Naresh's user system, this...</div>
	<span class='author'>Submitted by: <a href='#'>Mike Roquemore</a> on August 4<sup>th</sup>, 2011</span>
	<div class='clear'></div>
</div>
<div class='latest_block latest_two'>
	<img src='images/cat_icons/html_css.png' /><span class='title'><a href='#'>Naresh's TechTuts Layout</a></span>
	<div class='desc'>Learn how to recreate the layout that started it all on TechTuts back in the hayday of 2005, when Adam wasn't here and...</div>
	<span class='author'>Submitted by: <a href='#'>Adam Bray</a> on August 4<sup>th</sup>, 2011</span>
	<div class='clear'></div>
</div>
<div class='latest_block'>
	<img src='images/cat_icons/mysql.png' /><span class='title'><a href='#'>PHP Usersystem with AJAX, MySQL, HTML5 an...</a></span>
	<div class='desc'>Learn to use the little known trick in photoshop to reverse engineer a PSD file that gives you a full copy of the...</div>
	<span class='author'>Submitted by: <a href='#'>Adam Asshole</a> on August 4<sup>th</sup>, 2011</span>
	<div class='clear'></div>
</div>
<div class='latest_block latest_two'>
	<img src='images/cat_icons/javascript.png' /><span class='title'><a href='#'>Learn how to mismanage a Website!</a></span>
	<div class='desc'>Learn how to buy a decent website and turn it into a pile of steaming shit in less then 10 steps with my... </div>
	<span class='author'>Submitted by: <a href='#'>Dan</a> on August 4<sup>th</sup>, 2011</span>
	<div class='clear'></div>
</div>-->
</div> 
<div id='left_half'>
	<div class='box_top big half'>
		News & Announcements
	</div>
	<div class='main_area_two half'>
		The following features have been added since March 2011:<br />
		 <ul>
		 	<li>Working Timezone Support</li>
			<li>Correct Online user/guest calculations</li>
			<li>More to come</li>
			
		</ul>
	</div>
</div>
<div id='right_half'>
	<div class='box_top big half'>
		Most Popular Tutorials
	</div>
	<div class='main_area_two half'>
		Naresh USersystem
	</div>
</div>
<div class='clear'></div>
</div>