<html>
<head>
<title>Add to DB</title>
</head>
<body>
<?php
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("andyhil_music") or die("Couldn't select db"); 

$link = ereg_replace ("\n", "<br>", $link);

$query = "insert into music values(\"$mykey\", \"$artist\", \"$tribute\", \"$sample\", \"$thoughts\", \"$link\")";
print $query . "<br>";
mysql_query($query) or die("insert failed");

include("redopages.php");

<h1>Successfully Added to Database</h1>
<a href="index.html">Check it out</a>

</body>

</html>

























