<?php
$ingred = array();
$amt = array();
$step = array();
foreach ($_POST as $param => $val) {
	if ($val != "") {
		print("$param -> $val<br />\n");
		if (preg_match("/ingred/", $param)) $ingred[] = $val;
		if (preg_match("/amt/", $param)) $amt[] = $val;
		print("$val<br />\n");
		if (preg_match("/step/", $param)) $step[] = $val;
		$$param = $val;
	}
}
$query = "INSERT INTO recipes(name, region) VALUES('$name', '$region')";
mysql_query($query) or die("couldn't insert $query" . mysql_error());
$query = "SELECT recipe_id FROM recipes WHERE name='$name'";
$result = mysql_query($query) or die("couldn't select id");
$line = mysql_fetch_array($result);
$id = $line['recipe_id'];
for ($i = 0; $i < $num_ingred; $i++) {
	if ($ingred[$i] != "") {
		$query = "INSERT INTO ingredients(recipe_id, type, quantity) VALUES('$id', '$ingred[$i]', '$amt[$i]')";
		mysql_query($query) or die("Couldn't insert ingredient $i");
	}
}
for ($i = 0; $i < $num_steps; $i++) {
	if ($step[$i] != "") {
		$query = "INSERT INTO directions(recipe_id, step) VALUES('$id', '$step[$i]')";
		mysql_query($query) or die("Couldn't insert step $i");
	}
}
?>