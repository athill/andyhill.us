<?php
//connect to db
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("andyhil_music") or die("Couldn't select db"); 

//retrieve and sort fields
$query = "SELECT artist, aid, description FROM artists ORDER BY artist";
$result = mysql_query($query) or die("Query failed");

//create index to entries 

$letters = array();
$letterCount = array();
$letterCounter = 0;
$letterSearch = array();
while (list($artist, $id) = mysql_fetch_array($result)) {
	$letter = substr($artist, 0, 1);
	$letterIndex = array_search($letter, $letterSearch);
	print($letterIndex . "<br />");
	if (array_search($letter, $letterSearch) === FALSE) {
		$letterSearch[] = $letter;		
		$letters[] = array();
		$letters[$letterCounter]["letter"] = $letter;
		$letters[$letterCounter]["vals"] = array();
		$letterCount[$letter] = 0;
		$letterCounter++; 
	} 
	$lc = array_search($letter, $letterSearch);	
	
	$letters[$lc]["vals"][$letterCount[$letter]] = array();
	$letters[$lc]["vals"][$letterCount[$letter]]["artist"] = $artist;
	$letters[$lc]["vals"][$letterCount[$letter]]["id"] = $id;
	$letterCount[$letter]++; 
	
}
mysql_close($dbh);


print_r($letters);
?> 



<script language="JavaScript" type="text/javascript">
<!-- hide the script	



function arrayKeyExists(key, array) { 
	for (var i in array) {
		if (key.toUpperCase() == array[i].toUpperCase) return true;
	}
	return false;
}


function drawTable() {

	var n = 0;
	document.write("<table border='1' width='100%'>");
	while (table[n] != null) {
		document.write("<tr>");	
		document.write("<th width='20%'> </th>");
		for (i=n; i < (n + 4); i++) {
			if (table[i] == null) break;	
			document.write("<th width='20%'>" + table[i][0] + 
"</th>");
		}
		document.write("</tr><tr>");
		document.write("<td>Tribute<br />Sample" +
			"<br />Thoughts<br />Link<br />");
		for (i = n; i < (n + 4); i++) {
			if (table[i] == null) break;
			document.write("<td width='20%'>");
			if (table[i][1] != "") {
				document.write("<a href=" + table[i][1] + 
				 ">link</a><br />");
			}
			else document.write("null<br />"); 
			if (table[i][2] != "") {
				document.write("<a href=" + table[i][2] + 
				 ">link</a><br />");
			}
			else document.write("null<br />"); 
			if (table[i][3] != "") {
				document.write("<a href=" + table[i][3] + 
				 ">link</a><br />");
			}
			else document.write("null<br />");
			if (table[i][4] != "") {
				document.write("<a href=" + table[i][4] + 
				 ">link</a></td>");
			}
			else document.write("null</td>");  
		}
		document.write("</tr>");
		n += 4;				

	}
	document.write("</table>");
}
// back to html -->
</script>


<p>
I love music and so this page will eventually be filled with links and audio clips 
and such for the people I like to listen to. I've listened to 
everything from Depeche Mode to Pink Floyd to Pantera, so it's hard to represent everything. 
I've also listened to a lot of Westcoast" rap, though I 
haven't much 
lately.  Also, be sure to check out the <?php aLink("/media/local.php", "Local Music Page") ?> for the 
scoop on music in Bloomington, IN.
</p>
<p>
This page was created using PHP, MySQL, and JavaScript. The data is kept
in the MySQL database, which is retrieved by PHP. When I add a record to the database, the link, tribute, and thoughts pages are rewritten to reflect the 
new information. When this page is loaded, PHP creates the JavaScript which
creates the HTML to build the table.
</p>

<script language="JavaScript" type="text/javascript">
drawTable();
</script>