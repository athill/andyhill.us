<?php

//connect to db
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die          ( 'I cannot connect to the database because: ' . mysql_error());
mysql_select_db ("andyhil_music") or die("Couldn't select db");


//open and write top of links page
$fp=fopen("/home/andyhil/www/music/links2.html", "w")
     or die("Couldn't open file");
fwrite($fp, "<!DOCTYPE html PUBLIC");
fwrite($fp, "'-//W3C//DTD XHTML 1.0 Transitional//EN'\n");
fwrite($fp, "'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n\n"); 
fwrite($fp, "<html>\n\n<head>\n\n<title>Andy's Music Links Page</title>\n");
fwrite($fp, "<link rel=stylesheet type='text/css' href='styles.css'>\n\n");
fwrite($fp, "</head>\n\n<body bgcolor='#6699FF' vlink='white' alink='white'>\n");
fwrite($fp, "<h1>Andy's Music Link Page</h1>\n<a name='top'></a>\n");
fwrite($fp, "<font face='Comic Sans MS'>\n<h3>\n");

//open and write top of thoughts page
$fp2=fopen("/home/andyhil/www/music/thoughts2.html", "w")
     or die("Couldn't open file");
fwrite($fp2, "<!DOCTYPE html PUBLIC");
fwrite($fp2, "'-//W3C//DTD XHTML 1.0 Transitional//EN'\n");
fwrite($fp2, "'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n\n");
fwrite($fp2, "<html>\n\n<head>\n\n<title>Andy's Music Thoughts Page</title>\n");
fwrite($fp2, "<link rel=stylesheet type='text/css' href='styles.css'>\n\n");
fwrite($fp2, "</head>\n\n<body bgcolor='#6699FF' vlink='white' alink='white'>\n");
fwrite($fp2, "<h1>Andy's Music Thoughts Page</h1>\n<a name='top'></a>\n");
fwrite($fp2, "<font face='Comic Sans MS'>\n<h3>\n");

//open and write top of thoughts page
$fp3=fopen("/home/andyhil/www/music/tribute2.html", "w")
     or die("Couldn't open file");
fwrite($fp3, "<!DOCTYPE html PUBLIC");
fwrite($fp3, "'-//W3C//DTD XHTML 1.0 Transitional//EN'\n");
fwrite($fp3, "'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n\n");
fwrite($fp3, "<html>\n\n<head>\n\n<title>Andy's Music Tributes Page</title>\n");
fwrite($fp3, "<link rel=stylesheet type='text/css' href='styles.css'>\n\n");
fwrite($fp3, "</head>\n<body bgcolor='#6699FF' vlink='white' alink='white'>\n");
fwrite($fp3, "<h1>Andy's Music Tributes Page</h1>\n<a name='top'></a>\n");
fwrite($fp3, "<font face='Comic Sans MS'>\n<h3>\n");

//retrieve and sort fields
$query = "select * from music order by mykey";
$result = mysql_query($query) or die("Query failed");

while ($line = mysql_fetch_array($result)) {
  $mykey=$line['mykey'];
  $artist=$line['artist'];
  $thoughts=$line['thoughts'];
  $link=$line['link'];
  $tribute=$line['tribute'];
  if ($link != "") {
    fwrite($fp, "&#149;<a href='#$mykey'>$artist</a>");
  }
  if ($thoughts != "") {
    fwrite($fp2, "&#149;<a href='#$mykey'>$artist</a>");
  }
  if ($tribute != "") {
    fwrite($fp3, "&#149;<a href='#$mykey'>$artist</a>");
  }
}


//create index to entries

$query = "select * from music order by mykey";
$result = mysql_query($query) or die("Query failed");



//create entries
while ($line = mysql_fetch_array($result)) {
  $mykey=$line['mykey'];
  $artist=$line['artist'];
  $thoughts=$line['thoughts'];
  $link=$line['link'];
  $tribute=$line['tribute'];

  if ($link != "") {
    fwrite($fp, "<p>\n<a name='$mykey'><b>$artist</b></a>\n<br>\n$link");
  }
  if ($thoughts != "") {
    fwrite($fp2, "<p>\n<a name='$mykey'><b>$artist</b></a>\n<br>\n$thoughts");
  }
  if ($tribute != "") {
    fwrite($fp3, "<p>\n<a name='$mykey'><b>$artist</b></a>\n<br>\n");
    fwrite($fp3, "<img src='images/$tribute'/>\n");
  }
}

//finish html doc
$date = date ("l dS of F Y h:i:s A");
fwrite($fp, "<p>\nLast updated: $date\n");
fwrite($fp2, "<p>\nLast updated: $date\n");
fwrite($fp3, "<p>\nLast updated: $date\n");
fwrite($fp, "</body>\n</html>");
fwrite($fp2, "</body>\n</html>");
fwrite($fp3, "</body>\n</html>");

//close links, thoughts, and tribute pages
fclose($fp);
fclose($fp2);
fclose($fp3);
//close db
mysql_close($dbh);
?>
Done.
