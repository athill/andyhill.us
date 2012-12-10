<!DOCTYPE html PUBLIC
"-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>
<!-- Last updated: 5-25-2004  -->

<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>Andy's Music Page</title>
	<link rel="stylesheet" type="text/css" href="styles.css" />

<script language="JavaScript" type="text/javascript">
<!-- hide the script	
var table=new Array();
var count = 0;
function addElement(name, tribUrl, soundUrl, thoughtUrl, linkUrl) {

	table[count++] = new Array(name, tribUrl, soundUrl, thoughtUrl, linkUrl);
	
}


<?php
//connect to db
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("andyhil_music") or die("Couldn't select db"); 

//retrieve and sort fields
$query = "select * from music order by mykey";
$result = mysql_query($query) or die("Query failed");

//create index to entries 
while ($line = mysql_fetch_array($result)) {
  $mykey=$line['mykey'];
  $artist=$line['artist'];
  $tribute=$line['tribute'];
  $sample=$line['sample'];
  $thoughts=$line['thoughts'];
  $link=$line['link'];
  if ($tribute != "") {
    $trib="tribute2.html#$mykey";
  } else {
    $trib="";
  }
  if ($sample != "") {
    $sample = "tunes/$sample";
  }
  if ($thoughts != "") {
    $thou="thoughts2.html#$mykey";
  } else {
    $thou="";
  }
  if ($link != "") {
    $ln="links2.html#$mykey";
  } else {
    $ln="";
  }
  print "addElement(\"$artist\", \"$trib\", \"$sample\",";
  print "\"$thou\", \"$ln\");\n";
}

mysql_close($dbh);
?> 

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

</head>

<body bgcolor="#6699FF" vlink="white" alink="white">

<h1>Andy's Music Page</h1>

Check out <a href="../cgi-bin/blog/other.cgi?subject=music" 
onmouseover="window.status='The Latest!!!';return true;"
onmouseout="window.status='';return true;">the Latest!</a><br />

Back to &bull;<a href="../home">home</a>&bull;<a href="../index.htm">
opening page</a>

<p>
I love music and so this page will eventually be filled with links and audio clips 
and such for the people I like to listen to. I've listened to 
everything from Depeche Mode to Pink Floyd to Pantera, so it's hard to represent everything. 
I've also listened to a lot of <a href="westcoast.html" 
onmouseover="window.status='Westsi-eede';return true;"
onmouseout="window.status='';return true;">"Westcoast" rap</a>, though I 
haven't much 
lately.  Also, be sure to check out the <a href="btonmusic.php" 
onmouseover="window.status='Music in Bloomington, IN';return true;"
onmouseout="window.status='';return true;">Local Music Page</a> for the 
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

</body>
</html>












