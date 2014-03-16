<?php
//connect to db
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("andyhil_music") or die("Couldn't select db"); 

//insert shift into db
if (isset($_POST['hours_worked'])) {
	$hours_worked = $_POST['hours_worked'];
	$description = $_POST['description'];
	$shift_date = $_POST['yr'] . "-" . $_POST['mo'] . "-" . $_POST['dy'];
	$query = "INSERT INTO schedule(shift_date, hours_worked, description) " . 
		"VALUES('$shift_date', '$hours_worked', '$description')";
	mysql_query($query) or die("Couldn't insert: " . mysql_error()); 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Admin schedule</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<h2>Admin schedule</h2>
<h3>Add a shift</h3>
<?php
$dy = date("d");
$mo = date("m");
$yr = date("Y");

print("<form action='index.php' method='post'>\n");
print("Month: <select name='mo'>\n");
for ($i = 1; $i < 13; $i++) {
	$i < 10 ? $val = "0" . $i : $val = $i;
	print("<option value='$val'");
	if ($val == $mo) print(" selected='selected'");
	print(">$val</option>\n");
}
print("</select>\n");

print("Day: <select name='dy'>\n");
for ($i = 1; $i < 32; $i++) {
	$i < 10 ? $val = "0" . $i : $val = $i;
	print("<option value='$val'");
	if ($val == $dy) print(" selected='selected'");
	print(">$val</option>\n");
}
print("</select>\n");

print("Year: <select name='yr'>\n");

print("<option value='" . $yr - 1 . "'>" . $yr - 1 . "</option>\n");
print("<option value='" . $yr . "' selected='selected'>" . $yr . "</option>\n");
print("<option value='" . $yr + 1 . "'>" . $yr + 1 . "</option>\n");
print("</select>\n"); 

print("Hours worked: <input type='text' name='hours_worked' size='4' /><br />\n");
print("Description: <br /><textarea rows='4' cols='50' name='description'></textarea>\n");
print("<br /><input type='submit' value='Add Shift' />\n");
print("</form><br />\n");
?>

<h3>View schedule</h3>
<?php
if (isset($_POST['show_mo'])) {
	$this_mo = $_POST['show_mo'];
	$this_yr = $_POST['show_yr'];
} else {
	$this_mo =  date("m");
	$this_yr = date("Y");
}

print("<form action='index.php' method='post'>\n");
print("Month: <select name='show_mo'>\n");
for ($i = 1; $i < 13; $i++) {
	$i < 10 ? $val = "0" . $i : $val = $i;
	print("<option value='$val'");
	if ($val == $this_mo) print(" selected='selected'");
	print(">$val</option>\n");
}
print("</select>\n");

print("Year: <select name='show_yr'>\n");
print("<option value='" . $this_yr - 1 . "'>" . $this_yr - 1 . "</option>\n");
print("<option value='" . $this_yr . "' selected='selected'>" . $this_yr . "</option>\n");
print("<option value='" . $this_yr + 1 . "'>" . $this_yr + 1 . "</option>\n");
print("</select>\n"); 
print("<input type='submit' value='Show Month' />\n");
print("</form>\n");
?>
<table border="1">
<tr>
	<th>Date</th>
	<th>Hours</th>
	<th>Description</th>
</tr>
<?php
$total_hours = 0;
$query = "SELECT * FROM schedule WHERE shift_date LIKE '$this_yr-$this_mo-%'";
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) {
	print("<tr>\n");
	print("\t<td>" . $line['shift_date'] . "</td>\n");
	print("\t<td>" . $line['hours_worked'] . "</td>\n");
	print("\t<td>" . $line['description'] . "</td>\n");		
	print("</tr>\n");
	$total_hours += $line['hours_worked'];	
}
?>
<tr>
	<td colspan="2">Total hours worked</td>
	<td><?php print $total_hours; ?></td>
</tr>
</table>
</body>
</html>
