<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Andy's Programming</title>
<style type="text/css">
<!--
body {background:black; color: #00FF00; font: normal 10pt Arial, sans-serif}
h1 {text-align:center;font:normal 30pt  "Lucida Console", arial, sans-serif}
h2 {font:normal 15pt "Lucida Console", arial, sans-serif}
a:link, a:visited {color:yellow;text-decoration:none}
a:hover {color:red;text-decoration:none}
.categoryHeader {
	text-decoration: underline;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<h1 align="center">Programming I've Done</h1>


Back to &bull;<a href="../home">home</a>&bull;<a href="../index.htm">
opening page</a>

<table align="center" cellspacing="10" cellpadding="10">
<tr>
<?php
$file = "links.xml";
$xml_parser = xml_parser_create();

if (!($fp = fopen($file, "r"))) {
   die("could not open XML input");
}
$in_list = false;
$data = fread($fp, filesize($file));
fclose($fp);
xml_parse_into_struct($xml_parser, $data, $vals, $index);
xml_parser_free($xml_parser);
foreach ($vals as $val) {
	if ($val['tag'] == "CATEGORY") {
		if ($val['type'] == "open") {
			print("\t<td valign=\"top\">\n");
			$name = $val['attributes']['NAME'];
			print("\t<span class=\"categoryHeader\">$name</span><br />\n");
		} else if ($val['type'] == "close") {
			print("\t</td>\n");
		}	
	} else if ($val["tag"] == "LINK") {
		$href = $name = $val['attributes']['HREF'];
		if ($in_list) print("\t\t<li>");
		else print("\t");
		print("<a href=\"$href\">" . $val["value"] . "</a>");
		if ($in_list) print("</li>\n");
		else print("<br />\n");
 	} else if ($val['tag'] == "LIST") {
		if ($val['type'] == "open") {
			$in_list = true;
			print("\t<ul>\n");
		} else if ($val['type'] == "close") {
			$in_list = false;
			print("\t</ul>\n");
		}
	} 
}
?>
</tr>
</table>
Tutorials: <a href="htmltutorial.html">HTML</a>
<div class="categoryHeader">This site:</div>
<ul>
  <li>All Pages: Rollover links--Cascading Style Sheets; Formatting--
      HTML/CSS</li>
  <li>Opening page: Layout--Cascading Style Sheets(DHTML); 
      Tree links--JavaScript;
      Counter--Perl/CGI; Flying bird--Animated GIF.</li>
  <li>Home Page: Time and date--JavaScript; Color Slider--Java Applet</li>
  <li>Music Page: Auto-table-generation--JavaScript; Data loading and 
      presentation--PHP and MySQL</li>
  <li>Blog and 'Latest' pages: Perl/CGI with MySQL</li>
  <li>Picture Pages: Page generation--PHP</li>
  <li>This page: Table at top--XML parsed by PHP</li>
</ul>

</body>
</html>
