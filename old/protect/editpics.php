<html>

<head>

<title>Edit Pictures</title>

<script language="JAVASCRIPT" type="TEXT/JAVASCRIPT">

<!-- Hide from older browsers
function submitIt(myform) {
  myform.description.value = myform.description.value.replace(/"/g, "####");
  myform.description.value = myform.description.value.replace(/'/g, "@@@@");
  alert("regex");
  return true;
}
// -->

</script>


</head>

<body>


<!-- Add a picture -->
<FORM METHOD="POST" ENCTYPE="multipart/form-data" action="add_desc.php">
<h3>Add Picture</h3>
Please choose a picture to upload.
<input type="file" name="file">
<input type="submit" value="Upload"> 
</form>

<!-- Remove a picture -->
<form action="../family/rempic.php">
<h3>Remove picture</h3>
<select name="pic">
<?php
$path = "/home/andyhil/www/family/";

//Put directory listing of images into array and use for 
//drop down list
$d = dir("${path}images");
while (false !== ($pic = $d->read())) {
    if ($pic != "." && $pic != "..") {
      print "\t<option value='$pic'>$pic</option>\n";
      $a[] = $pic;
    }
}
$d->close();
?>
</select>
<input type="submit" value="Remove picture">
</form>

<!-- Change a picture's description -->
<form onSubmit="submitIt(this);" action="../family/chng_desc.php">
<h3>Change Description:</h3>
Picture:
<select name="picture">
<?php
//Populate drop-down list with array
foreach ($a as $pic) {
  print "\t<option value='$pic'>$pic</option>";
}
?>
</select>
<br />
New Description: 
<input type="text" name="description">
<br />
<input type="submit" value="Change Desciption">

</form>

</body>

</html>
