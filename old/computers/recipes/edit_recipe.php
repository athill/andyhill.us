<?php
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("andyhil_recipes") or die("Couldn't select db");
$num_ingred = 12;
$num_steps = 10;
if (isset($_POST['name'])) {
	$recipe_id = $_POST['recipe_id'];
	$query = "DELETE FROM ingredients WHERE recipe_id='$recipe_id'";
	mysql_query($query);
	$query = "DELETE FROM directions WHERE recipe_id='$recipe_id'";
	mysql_query($query);
	$query = "DELETE FROM recipes WHERE recipe_id='$recipe_id'";
	mysql_query($query);
	include("insertRecipeInDb.php");
	include("writeXmlFromDb.php");
	print("recipe edited");
} elseif (isset($_POST['delete'])) {
	$recipe_id = $_POST['delete'];
	$query = "DELETE FROM ingredients WHERE recipe_id='$recipe_id'";
	mysql_query($query);
	$query = "DELETE FROM directions WHERE recipe_id='$recipe_id'";
	mysql_query($query);
	$query = "DELETE FROM recipes WHERE recipe_id='$recipe_id'";
	mysql_query($query);	
	include("writeXmlFromDb.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add a Recipe!!!</title>
</head>


<h2 align="center">Administer Recipes!!!</h4>

<a href="recipes.php">Go to recipes</a>

<h3>Edit a recipe</h3>
<form action="edit_recipe.php" method="post" />
<select name="edit">
<?php 
$query = "SELECT name, recipe_id FROM recipes ORDER BY name";
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) {
	$name = $line["name"];
	$recipe_id = $line["recipe_id"];
	print("<option value='$recipe_id'>$name</option>\n");
}
?>
</select>
<br />
<input type="submit" value="Edit Recipe" />
</form>

<h3>Delete a recipe</h3>
<form action="edit_recipe.php" method="post" />
<select name="delete">
<?php 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) {
	$name = $line["name"];
	$recipe_id = $line["recipe_id"];
	print("<option value='$recipe_id'>$name</option>\n");
}
?>
</select>
<br />
<input type="submit" value="Delete Recipe" />
</form>

<?php
if (isset($_POST['edit'])) {
	$recipe_id = $_POST['edit'];
	$query = "SELECT * FROM recipes WHERE recipe_id='$recipe_id'"; 
	$result = mysql_query($query);
	$line = mysql_fetch_array($result);
	$name = $line['name'];
	$region = $line['region'];
	$types = array();
	$quantities = array();
	$ids = array();
	$query = "SELECT * FROM ingredients WHERE recipe_id='$recipe_id' ORDER BY ingredient_id";
	$result = mysql_query($query);
	while ($line = mysql_fetch_array($result)) {
		$types[] = $line['type'];
		$quantities[] = $line['quantity'];
		$ids[] = $line['ingredient_id'];		
	}
	$steps = array();
	$step_ids = array();
	$query = "SELECT * FROM directions WHERE recipe_id='$recipe_id' ORDER BY direction_id";
	$result = mysql_query($query);
	while ($line = mysql_fetch_array($result)) {
		$steps[] = $line['step'];
		$step_ids[] = $line['direction_id'];
	}
} else {
	$name = "";
	$recipe_id = "";
}
?>
<form action="edit_recipe.php" method="post">
<table align="center">
<tr>
	<td>Name: </td>
	<td colspan="4"><input type="text" name="name" value="<?php echo $name; ?>" /></td>
</tr>
<tr>
	<td>Region: </td>
	<td colspan="4">
	<select name="region">
	<?php
	$regions = array("Chinese", "Japanese", "Italian", "French", "English", "Cajun", "Other");
	foreach ($regions as $reg) {
		print("<option value=\"Chinese\"");
		if ($reg == $region) print(" selected=\"selected\"");
		print(">$reg</option>\n");
	}
	?>
	
	</select>
	</td>
</tr>
<?php
for ($i = 0; $i < $num_ingred; $i++) {
	if ($ids[$i] != "") $j = $ids[$i];
	else $j = $i;
	print("<tr><td>Ingredient:</td>");
	print("<td><input type='text' name='ingred$i' value='$types[$i]' /></td>\n");
	print("<td>Amount:</td>");
	print("<td><input type='text' name='amt$i' value='$quantities[$i]' /></td></tr>\n");
}

for ($i = 0; $i < $num_steps; $i++) {
	if ($step_ids[$i] != "") $j = $ids[$i];
	else $j = $i;
	print("<tr><td>Step $i:</td>");
	print("<td colspan='3'><input type='text' name='step$i' value='$steps[$i]' size='50' /></td></tr>\n");
}
?>
<tr>
<td colspan='4'>
<?php 
if (isset($_POST['edit'])) {
	print("<input type=\"submit\" value=\"Edit $name\" />\n");
	print("<input type=\"hidden\" name=\"recipe_id\" value=\"$recipe_id\" />\n");
} else {
	print("<input type=\"submit\" value=\"Add recipe\" />\n");
}
?>
</td>
</tr>
</table>

</form>

<body>
</body>
</html>
