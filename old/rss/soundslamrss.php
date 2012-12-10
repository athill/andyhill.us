<!DOCTYPE html PUBLIC
"-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>Soundslam New Feeds</title>
<link rel="stylesheet" type="text/css" href="feeds.css" />
</head>

<body>
<?php
$rss = "http://soundslam.com/soundslam.rss";

$code = file($rss) or die("Couldn't open remote file");
$name = preg_replace("/.*\/(.+\..+)$/", "$1", $rss);
touch("/home/andyhil/public_html/rss/$name") or die("Can't touch this");
chmod("/home/andyhil/public_html/rss/$name", 0777);
$file = fopen("/home/andyhil/public_html/rss/$name", "w") or die("couldn't open file");
foreach ($code as $line) {
	//$line = preg_replace("/[^\w\s\"\'<>&,.:=?#;@\/-]/", "", $line);
	fwrite($file, $line);
} 
fclose($file);
// XML file
// this needs to be a local file
$xml = $name;

// XSLT file
$style = "old_style.xsl";
foreach ($code as $line) {
	if (preg_match("/<rdf/", $line) > 0) {
		$style = "style.xsl";
		break;
	} elseif (preg_match("/rss/", $line) > 0) {
		$style = "old_style.xsl";
		break;
	}
}

$xslt = $style;

// create a new XSLT processor
$xp = xslt_create();

// transform the XML file as per the XSLT stylesheet
// return the result to $result
$result = xslt_process($xp, $xml, $xslt);
echo $result;
/*
if ($result) 
 {
	// print it
	echo $result;
} else {
	echo "must have been some error";
} */

// clean up
xslt_free($xp);

?>

<!-- The following code is a wrapper to support calls to some of the old xslt_* functions: -->

<?php

if (PHP_VERSION >= 5) {
   // Emulate the old xslt library functions
   function xslt_create() {
       return new XsltProcessor();
   }

   function xslt_process($xsltproc, 
                         $xml_arg, 
                         $xsl_arg, 
                         $xslcontainer = null, 
                         $args = null, 
                         $params = null) {
       // Start with preparing the arguments
       $xml_arg = str_replace('arg:', '', $xml_arg);
       $xsl_arg = str_replace('arg:', '', $xsl_arg);

       // Create instances of the DomDocument class
       $xml = new DomDocument;
       $xsl = new DomDocument;

       // Load the xml document and the xsl template
       $xml->loadXML($args[$xml_arg]);
       $xsl->loadXML($args[$xsl_arg]);

       // Load the xsl template
       $xsltproc->importStyleSheet($xsl);

       // Set parameters when defined
       if ($params) {
           foreach ($params as $param => $value) {
               $xsltproc->setParameter("", $param, $value);
           }
       }

       // Start the transformation
       $processed = $xsltproc->transformToXML($xml);

       // Put the result in a file when specified
       if ($xslcontainer) {
           return @file_put_contents($xslcontainer, $processed);
       } else {
           return $processed;
       }

   }

   function xslt_free($xsltproc) {
       unset($xsltproc);
   }
}

$arguments = array(
   '/_xml' => file_get_contents("newxslt.xml"),
   '/_xsl' => file_get_contents("newxslt.xslt")
);

$xsltproc = xslt_create();
$html = xslt_process(
   $xsltproc, 
   'arg:/_xml', 
   'arg:/_xsl', 
   null, 
   $arguments
);

xslt_free($xsltproc);
print $html;

?> 