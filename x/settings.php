<h2>Site Settings</h2>
<div class='box'> 
<?php
if ($_SESSION[username])
	{
		if ($_POST['goh'])
			{
				$timezone = clean($_POST['time']);
				$dst = clean($_POST['dst']);
				if (isset($dst) && $dst == 1)
					{
						$ds = 1;
					}
				else {
						$ds = 0;
					}
				$update = $sql->query("UPDATE `members` SET `timezone` = '$timezone', `dst` = '$ds' WHERE `id` = '$_SESSION[userid]'");
				
				if ($update == FALSE)
					{
						$sql->error(mysql_error());
					}
				else if ($update == TRUE)
				{
				$_SESSION['timezone'] = $timezone;
				$_SESSION['dst'] = $dst;
				echo "Your timezone has been updated";
				}
			}
		else {
		// array to store timezones
		$timezones = array(
		"-12" => "(GMT- 12:00) Eniwetok, Kwajalein",
		"-11" => "(GMT -11:00) Midway Island, Samoa",
		"-10" => "(GMT -10:00) Hawaii",
		"-9" => "(GMT -9:00) Alaska",
		"-8" => "(GMT -8:00) Pacific Time (US &amp; Canada)",
		"-7" => "(GMT -7:00) Mountain Time (US &amp; Canada)",
		"-6" => "(GMT -6:00) Central Time (US &amp; Canada), Mexico City",
		"-5" => "(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima",
		"-4" => "(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz",
		"-3.5" => "(GMT -3:30) Newfoundland",
		"-2" => "(GMT -3:00) Brazil, Buenos Aires, Georgetown",
		"-1" => "(GMT -2:00) Mid-Atlantic",
		"0" => "(GMT -1:00 hour) Azores, Cape Verde Islands",
		"1" => "(GMT) Western Europe Time, London, Lisbon, Casablanca",
		"2" => "(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris",
		"3" => "(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg",
		"3.5" => "(GMT +3:30) Tehran",
		"4" => "(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi",
		"4.5" => "(GMT +4:30) Kabul",
		"5" => "(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent",
		"5.5" => "(GMT +5:30) Bombay, Calcutta, Madras, New Delhi",
		"6" => "(GMT +6:00) Almaty, Dhaka, Colombo",
		"7" => "(GMT +7:00) Bangkok, Hanoi, Jakarta",
		"8" => "(GMT +8:00) Beijing, Perth, Singapore, Hong Kong",
		"9" => "(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk",
		"9.5" => "(GMT +9:30) Adelaide, Darwin",
		"10" => "(GMT +10:00) Eastern Australia, Guam, Vladivostok",
		"11" => "(GMT +11:00) Magadan, Solomon Islands, New Caledonia",
		"12" => "(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka",);
		echo "<form name='time' method='post' action=''>
		<fieldset><legend>Timezone Settings</legend>
			<table>
				<tr>
					<td width='200px'>Timezone</td>
					<td>
						<select name='timezone'>";
						$r = $sql->assoc("SELECT `timezone`,`dst` FROM `members` WHERE `id` = '$_SESSION[userid]' LIMIT 1");
					
						foreach ($timezones as $key => $value) {
						if ($key == $r[timezone])
							{
								$selected = "SELECTED";
							}
						else { $selected = '';
						}
						echo "<option value='$key' $selected>$value</option>\n";
						}
						}
			  echo "	</select>
					</td>
				</tr>
				<tr>
				<tr>
					<td>Daylight Saving in effect? </td>";
					
					if ($r[dst] == 1) { $select = " checked"; }
					echo "<td><input type='checkbox' name='dst' id='dst' value='1'$select /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type='submit' name='goh' value='Change' /></td>
				</tr>
			</table>
		</fieldset>";		
		}
		echo "</div>";
		
?>