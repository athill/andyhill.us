<html>
<head>
<title>Update Record</title>
</head>
<body>
<?php
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("andyhil_music") or die("Couldn't select db"); 
print "$value<br>\n"; 
if ($field == "link") { 
 $value = ereg_replace ("\n", "<br>", $value);
}
$query = "update music set $field='$value' where mykey='$mykey'";
print $query . "<br>";
mysql_query($query) or die("update failed");
include("redopages.php");
?>

<h1>Update Successful</h1>

</body>

</html>




