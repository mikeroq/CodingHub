<?php		   
if ($_POST['go'])
	{
		$text = $_POST['text'];
		$text = str_replace("<","&lt;",$text);
		$text = str_replace(">","&gt;",$text);
		echo "Output:<br /><pre>$text</pre>";	
	}			 

echo "<form action='' method='post'><p><textarea name='text'></textarea><br/><input type='submit' name='go' value='Post' /></form>";   
echo "<p>Source Code:<br /><pre>";
$source = highlight_string("<?php		   
if (\$_POST['go'])
	{
		\$text = \$_POST['text'];
		\$text = str_replace(\"<\",\"&lt;\",\$text);
		\$text = str_replace(\">\",\"&gt;\",\$text);
		echo \"Output:<br /><pre>\$text</pre>\";	
	}			 

echo \"<form action='' method='post'><p><textarea name='text'></textarea><br/><input type='submit' name='go' value='Post' /></form>\";
?>");
echo "</pre>";
?>