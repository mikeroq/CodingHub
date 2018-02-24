	<script type='text/javascript'>
function cdelete(delUrl,URL) {
	if (confirm("Are you sure you want to delete this message?")) {
		document.location = delUrl;
	}
	else if(alert("Your message will not be deleted"))
	{
		document.location = URL;	
		}
}
</script>
<h2>Private Messages</h2><div class='box'>
<?php
if ($_SESSION[username])
	{
		switch($_GET[page])
			{	
				default:
					echo "Invalid way to reach this page";
				break;
				case 'write':
					if (!$_POST['send'])
						{
						 	echo "<form method='post' action=''>
							To<br />";	
							if (!$_GET['name'])
								{
									echo "<select name='to'>";				   
								    $getusers = mysql_query("SELECT * FROM members ORDER BY 'username' ASC");
            						while ($users = MySQL_Fetch_Array($getusers)) 
										{
    										echo "<option value='$users[username]'>$users[username]</option>";
										}
									echo "</select>";
								}
							else 
								{
									echo "<b>$_GET[name]</b><input type=hidden value='$_GET[name]'> - <a href='/pm/write/'>Change</a>"; 
								}
							echo "<br />Subject<br />
							<input type=\"text\" name=\"subject\" size=\"20\">
							<br />Message<br />
							<textarea rows=\"7\" name=\"message\" cols=\"35\"></textarea><br />
							<input type=\"submit\" value=\"Submit\" name=\"send\"> 
							</form>";
						}
					if ($_POST['send'])
						{
							$subject = htmlspecialchars(addslashes("$_POST[subject]"));
							$message = htmlspecialchars(addslashes("$_POST[message]"));
							$to = htmlspecialchars(addslashes("$_POST[to]")); 
							$date = time();
							$send = mysql_query("INSERT INTO `pmessages` (`subject`,`message`,`to`,`from`,`read`,`date`) VALUES ('$subject','$message','$to','$_SESSION[username]','0','$date')");
							echo "Your message to <b>$to</b> was sent.<br /><a href='/pm/'>Private Messages Inbox</a>";
						}
				break;
				case 'delete': 
					$id = addslashes($_GET['id']);
					if (!$id)
						{
							echo "You have selected an non existant message to delete.";
						}
					else
						{
							$getmsg = mysql_query("SELECT * from pmessages where id = '$id'");
							$msg = mysql_fetch_array($getmsg);
							if ($msg[to] != $_SESSION[username])
								{
									echo "This message was not sent to you. You cannot delete it.";
								}  
							else {
							$delete  = mysql_query("delete from pmessages where id = '$id'");
							header("Location: /pm/");	
							}
						}
				break;
				case 'inbox':
					echo "<table  border='0' width='100%' cellspacing='0' style='font-size: 10px; font-family: verdana; border-bottom: 1px #000 solid;'>
					<tr>
					<td align='center' style='font-size: 10px; text-align: left; font-family: verdana;'>Subject</td>
					<td align='center' style='font-size: 10px; text-align: center; font-family: verdana;' width='125'>From</td>
					<td align='center' style='font-size: 10px; text-align: center; font-family: verdana;' width='125'>Date</td>
					<td width='25' style='font-size: 10px; text-align: center; font-family: verdana;'>Delete</td>
					</tr>
					</table>";
					$get = mysql_query("SELECT * FROM `pmessages` WHERE `to` = '$_SESSION[username]' ORDER BY `id` DESC") or die(mysql_error());
					$nummessages = mysql_num_rows($get);
					if ($nummessages == 0)
						{
							echo "You have no private messages.";
						}
					else
						{
							echo("<table border='0' width='100%' cellspacing='1' style='font-size: 10px; font-family: verdana;'>");
							while ($messages = mysql_fetch_array($get))
								{
									echo "<tr><td style='font-size: 10px; font-family: verdana;'>";
									if ($messages[read] == "0") 
										{
											echo "<b>";
										}
									echo ("<a href=\"/pm/view/$messages[id]/\">"); 
									if ($messages[reply] == '1')	 
										{
											echo ("RE: ");
										}
									echo ("$messages[subject]</a>");
									if ($messages[read] == "1") 
										{
											echo "</b>";
										}
									$date = nixtime($messages[date]);
									echo "</td>
									<td width=\"125\" style='font-size: 10px; text-align: center; font-family: verdana;'><a href='/profile/$messages[from]/'>$messages[from]</a></td>
									<td width=\"125\" style='font-size: 10px; text-align: center; font-family: verdana;'>$date</td>
									<td width=\"25\" style='font-size: 10px; text-align: center; font-family: verdana;'><a href='' onclick='javascript:cdelete(\"/pm/delete/$messages[id]/\",\"/pm/\");'>Delete</a></td>
									</tr>";
								}
							echo "</table>";
						}
				break;
				case 'view':
					if (!$_GET[id])
						{
							echo "You have selected an invalid message.";
						}
					else
						{
							$id = addslashes($_GET['id']);
							$getmsg= mysql_query("SELECT * from pmessages where id = '$id'");	
							$msg = mysql_fetch_array($getmsg);	  
							//the above lines get the message, and put the details into an array.
							if ($msg[to] == $_SESSION[username])
								{
							//makes sure that this message was sent to the logged in member
							if (!$_POST[message])
							{
							//the form has not been submitted, so we display the message and the form
							$markread = mysql_query("UPDATE `pmessages` SET `read` = '1' where `id` = '$id'");
							//this line marks the message as read.
							$msg[message] = $bbcode->parse($msg[message]);	
							$date = nixtime($msg[date]);
							//removes slashes and converts new lines into line breaks.
							echo "<form method=\"POST\" style=\"margin: 0px;\">
							<b>To:</b> $user<br />
							<b>From:</b> <a href='/profile/$msg[from]/'>$msg[from]</a><br /> 
							<b>Date:</b> $date<br />
							<b>Subject:</b> $msg[subject]<br />
							<hr />
							$msg[message]
							<hr align='left' style='width: 400px;' />
							";
							$sig = mysql_fetch_array(mysql_query("SELECT * FROM `members` WHERE `username` = '$msg[from]'"));
							$sig = $bbcode->parse($sig['sig']);
							$sig = str_replace("[img]","<img src='",$sig);
							$sig = str_replace("[/img]","' alt='' />",$sig);	
							echo "
							$sig<br />
							<hr />
							<b>Reply</b><br />
							<textarea rows=\"6\" name=\"message\" cols=\"45\"></textarea>
							<br /><input type=\"submit\" value=\"Submit\" name=\"send\">
							</form>";
							}
if ($_POST[message])
{
//the form HAS been submitted, now we insert it into the database
$message = htmlspecialchars(addslashes("$_POST[message]"));
$date = date("m/d/y g:i a");
$do = mysql_query("INSERT INTO `pmessages` ( `subject` , `message` , `to` , `from` , `read` ,
`date`, `reply`) VALUES
('$msg[title]', '$message', '$msg[from]', '$_SESSION[username]',
'0', '$date', '1')");
echo ("Your message has been sent");
}
}
else
{
//hmm..this message was NOT sent to the logged in user...so we won't display it.
echo ("This message WAS NOT sent to you. Dont even try to read someone elses mail.");
}}
break;
}
echo("<br /><div align=\"center\"><a href=\"/pm/\">Inbox</a> | <a href=\"/pm/write/\">New Message</a></div>");
}
?></div>


