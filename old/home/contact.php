<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

<meta name="copyright" content="Andy Hill" />
<link rel="stylesheet" href="home.css" type="text/css" />


<link rel="shortcut icon" href="http://andyhill.us/images/andyicon.ico" /


<meta name="author" content="Andy Hill" />

<title>Contact Andy</title>
</head>
<body>
<h1>Contact Andy</h1>

<?php
if (isset($_GET['mssg'])) {
	print("<div class=\"alert\">" . $_GET['mssg'] . "</div>\n");
}
?>

<form action="contact_submit.php" method="post" id="contact">
<table align="center">
<tr>
	<th>Name:</th>
	<td><input type="text" name="name" size="50" maxlength="50" /></td>
</tr>
<tr>
  <th>E-mail:</th>
  <td><input type="text" name="email" size="50" maxlength="50" /></td>
</tr>
<tr>
  <th>Subject:</th>
  <td><input type="text" name="subject" size="50" maxlength="50" /></td>
</tr>
<tr>
	<th valign="top">Message:</th>
	<td><textarea name="message" cols="50" rows="15"></textarea></td>
</tr>
<tr>
	<th colspan="2"><input type="submit" value="Send" /></th>
</tr>
</table>
</form>

</body>
</html>

