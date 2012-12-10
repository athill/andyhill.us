
<?php
$uploadDir = '/home/andyhil/www/family/images/';
$picture = $_FILES['file']['name']; 
$uploadFile = $uploadDir . $_FILES['file']['name'];
print "<pre>";
print "$uploadFile<br />";
if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile))
{
    print "File is valid, and was successfully uploaded. ";
    print "Here's some more debugging info:\n";
    print_r($_FILES);
}
else
{
    print "Possible file upload attack!  Here's some debugging info:\n";
    print_r($_FILES);
}
print "</pre>";
?>
<html>

<head>

<title>
Describe the picture
</title>
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

<form action="../family/family.php" onSubmit="submitIt(this);">
<input type="text" name="description">
<?php
print "pic: $picture<br />";

print "<input type='hidden' name='picture' value='$picture'>";
?>

<input type="submit" value="Submit" onSubmit="submitIt(this);">
</form>

</body>

</html>
