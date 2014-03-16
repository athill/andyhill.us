<html>

<head>
<title>Add Artist</title>
</head>
<body>
<h1 align="center">Add Artist to Music Page</h1>
<table>
<tr>
<td>
<b><u>Keys</u></b>
<br />

<?php
//connect to db
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die          ( 'I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("andyhil_music") or die("Couldn't select db");

//retrieve and sort fields
$query = "select * from music order by mykey";
$result = mysql_query($query) or die("Query failed");

while ($line = mysql_fetch_array($result)) {
  $key=$line['mykey'];
  $artist=$line['artist'];
  print "$key($artist)<br />\n";
}
?>

</td>
<td>
<form action="../music/addmusic.php">
<h3>Key</h3>
<input type="text" name="mykey">
<h3>Aritst</h3>
<input type="text" name="artist">
<h3>Tribute</h3>
<input type="text" name="tribute">
<h3>Sample</h3>
<input type="text" name="sample">
<h3>Thoughts</h3>
<textarea name="thoughts" rows="4" cols="65"></textarea>
<h3>Link</h3>
<textarea name="link" rows="4" cols="65"></textarea>
<input type="submit" value="submit">
</form>
</td>
</tr>
</table>


</body>

</html>







