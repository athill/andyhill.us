<?php
if (!isset($dbh)) {
	$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db ("andyhil_recipes") or die("Couldn't select db");
}
print("Writing file<br />\n");
$new = fopen("recipes2.xml", "w") or die("Couldn't open");
fwrite($new, "<?xml version=\"1.0\"?>\n");
fwrite($new, "<recipes \n");
fwrite($new, "xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n");
fwrite($new, "xsi:noNamespaceSchemaLocation=\"recipes.xsd\">\n");
$query = "SELECT * FROM recipes ORDER BY name";
$result = mysql_query($query) or die("Couldn't select recipes");
while ($line = mysql_fetch_array($result)) {
	//retrieve field names and assign to variables of same name
	for ($i = 0; $i < mysql_num_fields($result); $i++) {
		$fld = 	mysql_field_name($result, $i);
		$$fld = $line[$fld];
	}
	fwrite($new, "\t<recipe>\n");
	fwrite($new, "\t\t<name>$name</name>\n");
	fwrite($new, "\t\t<region>$region</region>\n");
	fwrite($new, "\t\t<ingredients>\n");
	$ingred_query = "SELECT type, quantity FROM ingredients WHERE recipe_id='$recipe_id' ORDER BY ingredient_id";
	$ingred_result = mysql_query($ingred_query);
	while ($ingred_line = mysql_fetch_array($ingred_result)) {
		$type = $ingred_line['type'];
		$quantity = $ingred_line['quantity'];
		fwrite($new, "\t\t\t<ingredient>\n");
		fwrite($new, "\t\t\t\t<type>$type</type>\n");
		fwrite($new, "\t\t\t\t<quantity>$quantity</quantity>\n");
		fwrite($new, "\t\t\t</ingredient>\n");
	}
	fwrite($new, "\t\t</ingredients>\n");
	fwrite($new, "\t\t<directions>\n");
	$step_query = "SELECT step FROM directions WHERE recipe_id='$recipe_id' ORDER BY direction_id";
	$step_result = mysql_query($step_query);
	while ($step_line = mysql_fetch_array($step_result)) {
		$step = $step_line['step'];
		fwrite($new, "\t\t\t<step>$step</step>\n");
	}
	fwrite($new, "\t\t</directions>\n");
	fwrite($new, "\t</recipe>\n");	
}	
fwrite($new, "</recipes>\n");
print("File is written<br />\n");
include("recipes2.xml");
?>