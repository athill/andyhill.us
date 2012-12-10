<html>

<head>

<title>Change description</title>

</head>

<body>

<?php


//read assoc.txt into a hash array
$handle = fopen("${path}assoc.txt", "r");
while (!feof ($handle)) {
    $buffer = fgets($handle, 1024);
//ignore lines without a picture
    if (preg_match("/^:.*/", $buffer)) {
    }
    else {
      list($pic, $desc) = split(":", $buffer, 2);
      $hash[$pic] = $desc;
    }
}
//change the appropriate hash element
$hash[$picture] = $description;

include("redopages.php");
redo($hash);

?>

<a href="fam1.html">First page</a>

</body>

</html>
