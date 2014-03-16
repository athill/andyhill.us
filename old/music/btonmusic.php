<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN"
		
	"http://www.w3.org/TR/html4/loose.dtd">

<html>

<!-- Last updated: 12-18-03 -->

<head>
	
	<title> Local Music in Bloomington </title>
	<link rel=stylesheet type="text/css" href="styles.css" />
<?php
if ($band) {
  $arr = array();
  $handle = fopen("localbands.txt", "r");
  while ($line = fgets($handle)) {
    $arr[] = $line;
  }
  fclose($handle);
  $arr[] = "$band\n";
  sort($arr);
  $handle = fopen("localbands.txt", "w");
  foreach ($arr as $line) {
    fwrite($handle, $line);
  }
  fclose($handle);
}
?>

</head>

<body bgcolor="#6699FF" alink="white" vlink="white">


<h1>Bloominton's Local Music Scene</h1>

The local artist on this page are displayed dynamically using PHP and a text file.

<h3>

Check out <a href="../cgi-bin/blog/other.cgi?subject=local">The latest</a>

<p>
Back to •<a href="index.html">music</a>
•<a href="../home/">home</a>
•<a href="../index.htm">opening page</a>
</p>

<p>
(Mostly)Local Labels: 
•<a href="http://www.thegreatvitaminmystery.com">The Great Vitamin 
   Mystery</a>
•<a href="http://www.jagjaguwar.com">Jagjaguwar</a>
•<a href="http://www.family-vineyard.com">Family Vineyard</a>
•<a href="http://www.affirmation.com">Affirmation</a><br>

Productions: 

•Flophouse Productions
</p>

<p>
One of my favorite things to to is to go see local and independent bands.  
I used to go to almost every show I could, though age and finances prevent 
me from being as active now as I was then.  The main place I go see shows is 
<a href="http://www.secondstory.thenightclub.com">Second Story</a>(website by 
<a href="http://www.andrewstorms.com">Andrew Storms</a>).  If you ever come to 
Bloomington and it's still open(which is in doubt right now) it's where I'd 
go.  The other hot spot(which is sadly closed now) was the Cellar Lounge.  Another 
venue I see shows at is  Vertigo, Space 101, and 
Uncle Festers. All-age venues include <a href="http://bloomington.in.us/~rhinos">Rhino's</a>, 
<a href="http://www.buskirkchumley.org">The Buskirk Chumley Theater</a> and the 
<a href="http://www.artlives.org">John Waldron Arts 
Center</a>. At any of these venues, you can find everything from bluegrass to 
hard-core, hip-hop to garage punk.  Some of the local bands I've seen 
include:
</p>
<br />

<table cellspacing="5">
<?php
$handle = fopen("localbands.txt", "r");
$counter = 0;
while ($line = fgets($handle)) {
   $line = ereg_replace("\n", "", $line);
   if ($counter%4 == 0) {
     print "<tr>\n";
   }
     print "\t<td>&#149$line</td>\n";
   if ($counter%4 == 3) {
    print "</tr>\n";
   }
   $counter++ ;
}
fclose($handle);
if (counter%4 != 3) {
  print "</tr>\n";
}
?>
</table>


There are also a lot of good underground touring bands I've seen. Some of 
whom include:
<ul>
  <li>The Trash Brats</li>
  <li>The Meices</li>
  <li>Dead Bolt</li>
  <li>Superchunk</li>
  <li>The Poster Children</li>
  <li>Man Or Astroman?</li>
  <li>Big Hat</li>
  <li>Frank Black(sadly not much of it)</li>
  <li>Buffalo Daughter</li>
  <li>Laughing Hyenas</li>
  <li>Love Life</li>
</ul> 

</h3>

</body>

</html>
