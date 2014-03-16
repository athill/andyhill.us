<?php
exit(1);
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("andyhil_recipes") or die("Couldn't select db");
$num_ingred = 10;
$num_steps = 10;
if (isset($_POST['ingred1'])) {
	include("insertRecipeInDb.php");
	include("writeXmlFromDb.php");
	print("recipe added");
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

<form action="add_recipe.php" method="post">
<table align="center">
<tr>
	<td>Name: </td>
	<td colspan="4"><input type="text" name="name" /></td>
</tr>
<tr>
	<td>Region: </td>
	<td colspan="4">
	<select name="region">
	<option value="Chinese">Chinese</option>
	<option value="Japanese">Japanese</option>
	<option value="Italian">Italian</option>
	<option value="French">French</option>
	<option value="English">English</option>
	<option value="Cajun">Cajun</option>
	<option value="Other">Other</option>
	
	</select>
	</td>
</tr>
<?php
$num_ingred = 10;
$num_steps = 10;
for ($i = 0; $i < $num_ingred; $i++) {
	print("<tr><td>Ingredient:</td>");
	print("<td><input type='text' name='ingred$i' /></td>\n");
	print("<td>Amount:</td>");
	print("<td><input type='text' name='amt$i' /></td></tr>\n");
}

for ($i = 0; $i < $num_steps; $i++) {
	print("<tr><td>Step $i:</td>");
	print("<td colspan='3'><input type='text' name='step$i' size='50' /></td></tr>\n");
}
?>
<tr>
<td colspan='4'><input type="submit" value="Add Recipe" /></td>
</tr>
</table>

</form>

<body>
</body>
</html>
