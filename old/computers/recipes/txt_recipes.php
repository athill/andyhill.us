<?php
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("andyhil_recipes") or die("Couldn't select db");

$recipes = file("recipes.txt") or die("Couldn't open");
$has_title = false;
$has_region = false;
$has_ingredients = false;
$has_steps = false;
$alternate = 0;

$id = 0;

foreach ($recipes as $line) {
	$line = rtrim($line);
	$line = addslashes($line);
	if ($has_steps && $line == "") {	
		print("$line<br />\n");
		$has_title = false;
		$has_region = false;
		$has_ingredients = false;
		$has_steps = false;
		$alternate = 0;
	} else if ($has_ingredients && $line == "") {
		print("steps: $line<br />\n");
		$has_steps = true;
	} else if ($has_region && !$has_ingredients && $line == "") {
		print("ingred: $line<br />\n");
		$has_ingredients = true;
	} else if ($line == "") {
		print("'' $line<br />\n");
	}
	else if (!$has_title) {
		print("title: $line<br />\n");
		$title = $line;
		$has_title = true;
	} else if (!$has_region) {
		print("region: $line<br />\n");
		$region = $line;
		$has_region = true;
	} else if ($has_ingredients && !$has_steps) {
		print("ingred: $line, alt:: $alternate<br />\n");
		if ($alternate == 0) {
			$query = "INSERT INTO recipes(name, region) VALUES('$title', '$region')";
			print("$query<br /><br />\n");
			mysql_query($query) or die("couldn't insert $query");
			$query = "SELECT recipe_id FROM recipes WHERE name='$title'";
			$result = mysql_query($query) or die("couldn't select id");
			$sql_line = mysql_fetch_array($result);
			$id = $sql_line['recipe_id'];	
			$type = $line;
		} else if (($alternate % 2) == 0) {
			$type = $line;
		} else {
			$quantity = $line;
			$query = "INSERT INTO ingredients(recipe_id, type, quantity) " .
				"VALUES('$id', '$type', '$quantity')";  
			mysql_query($query) or die("couldn't insert $query");
			print("$query<br /><br />\n");
		}
		$alternate++;	
	} else {
		$has_steps = true;
		print("step: $line<br />\n");
		$query = "INSERT INTO directions(recipe_id, step) VALUES('$id', '$line')";
		mysql_query($query) or die("Couldn't insert step $query");
		print("$query<br /><br />\n");
	}
} 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
</head>

<body>

</body>
</html>
