<html>

<head>

<title>Andy's Family and Friends Page</title>

</head>

<body>

<?php

$path = "/home/andyhil/www/family/";

$count = count($a);
print "Length: $count\n"; 



//This is where it begins
$description = ereg_replace("####", '"', $description);
$description = ereg_replace("@@@@","'", $description);



//$hash = array();
$handle = fopen("${path}assoc.txt", "r");
while (!feof ($handle)) {
    $buffer = fgets($handle, 1024);
    if (preg_match("/^:.*/", $buffer)) {
    }
    else {  
      list($pic, $desc) = split(":", $buffer, 2);
      $hash[$pic] = $desc;
    }
}

print "<br />pic: $picture, desc: $description<br />\n";

$hash[$picture] = $description;
ksort($hash);
include("redopages.php");
redo($hash);

?>

</body>

</html>



