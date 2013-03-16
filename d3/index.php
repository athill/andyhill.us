<?php
$local['jsModules']['d3'] = true;
$local['scripts'] = array('index.js');
include('../inc/application.php');
$h->startBuffer();
$g3=<<<EOT
<a href="http://d3js.org/" target="_blank">D3.js</a> is a JavaScript library for manipulating 
documents based on data. Most of what I've done is just tutorials and simple things, but I'd 
like to do more things like <a href="${site['webroot']}/d3/line.php">this</a>.
EOT;
$h->p($g3);

$geekout = $h->endBuffer();
$template->template->geekOut($geekout);
//print_r($GLOBALS['site']);
?>

    <div id="viz"></div>

    <div id="slide"></div>

	<div id="viz2"></div>
    
<?php
$template->footer();
?>