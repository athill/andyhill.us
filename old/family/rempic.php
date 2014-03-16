<html>

<head>

<title>Remove Picture</title>

</head>

<body>

<?php

$a = array();
$handle = fopen("assoc.txt", "r");
while (!feof ($handle)) {
    $buffer = fgets($handle, 1024);
    list($picture, $desc) = split(":", $buffer);
    print "$picture<br />";
    if ($pic == $picture) {}
    else {
      $a[] = $buffer;
    }
}
fclose($handle);

$handle = fopen("assoc.txt", "w");
foreach ($a  as $entry) {
  fwrite($handle, $entry);
}
fclose($handle);
if (unlink("/home/andyhil/www/family/images/$pic")) {
  print "<h1>$pic successfully removed.</h1>";
}

include("redopages.php");
$handle = fopen("assoc.txt", "r");
while (!feof ($handle)) {
    $buffer = fgets($handle, 1024);
    if (preg_match("/^:.*/", $buffer)) {
    }
    else {
      list($pic, $desc) = split(":", $buffer, 2);
      $hash[$pic] = $desc;
    }
}

redo($hash);
?>
<a href="fam1.html">First page</a>


</body>

</html>
