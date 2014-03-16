<html>

<head>
<title>Update Music</title>
</head>
<body>
<h1 align="center">Update Music Page</h1>

<table>
<tr>
  <td width='15%'>
<?php
//connect to db
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die          ( 'I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("andyhil_music") or die("Couldn't select db"); 

//retrieve and sort fields
$query = "select mykey from music order by mykey";
$result = mysql_query($query) or die("Query failed");


?>
</td>
<td width='85%'>
<form action="../music/updatemusic.php">

<h3>Key</h3>
<select name="mykey">

<?php
 
while ($line = mysql_fetch_array($result)) {
  $key=$line['mykey'];
  print "<option value='$key'>$key\n";
}

?>
</select>
<p>


<h3>Field</h3>
<select name="field">

<option value="artist">artist
<option value="link">link
<option value="mykey">mykey
<option value="sample">sample
<option value="thoughts">thoughts
<option value="tribute">tribute



</select>
<h3>Value</h3>
<textarea name="value" rows="4" cols="65"></textarea>

<input type="submit" value="submit">
</form>
</td>
</tr>
</table>
</body>

</html>








