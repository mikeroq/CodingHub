<h2>Contact TutorialHub</h2>
<div class='box'> 
	<?php
		if ($_POST['go'])
			{
				$email = $_POST['from']; 
				$ip = $_SERVER['REMOTE_ADDR'];	
				$name = $_POST['name'];
				$ms = $_POST['msg']; 		
				$subject = $_POST['subject'];		
				$msg = "Name: $name\nEmail: $email\nIP: $ip\nMessage: $ms";			
				$mail = @mail("mikeroq@gmail.com","TutorialHub: $subject","$msg");
				if ($mail == TRUE)
					{
						echo "<div class='error'>Your message has been sent. You will recieve a response within a few hours.<br />Thanks</div>";
					}
				else 
					{
						echo "<div class='error'>Your message could not be sent. Please try again later.<br />Thanks</div>";
					} 
			}	  
	?>
	<form action='' method='post'>
		<fieldset>
			<legend>Contact Info</legend> 
			<table>
				<tr>
					<td width='200px'>Your Name</td>
					<td><input type='text' class='txt' name='name' style='width: 250px;'/></td>
				</tr>
				<tr>
					<td width='200px'>Email Address</td>
					<td><input type='text' class='txt' name='email' style='width: 250px;'/></td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend>Message</legend>
			<table>
				<tr>
					<td width='200px'>Subject</td>
					<td>
						<select class='text' style='width: 250px;' name='subject'>
							<option value='#'>Choose a Subject</option>
							<option value='Bug'>Bug Report</option>
							<option value='Suggestion'>Site Suggestion</option>
							<option value='Feedback'>Site Feedback</option>
							<option value='Tutorial Rip'>Ripped Tutorial</option>
							<option value='Other'>Other</option>
						</select>
					</td>
				</tr>	 
				<tr>
					<td width='200px' valign='top'>Message</td>
					<td><textarea rows='20' cols='60' name='body'></textarea></td>
				</tr>
				<tr>
					<td width='200px'>&nbsp;</td>
					<td><input type='submit' name='go' value='Send Message' /></td>
				</tr>
			</table>
		</fieldset>
	</form>
</div>

