<?php
$local['jsModules']['d3'] = true;
$local['scripts'] = array('index.js');
include('../inc/application.php');
//print_r($GLOBALS['site']);
?>

    <div id="viz"></div>

    <div id="slide"></div>

	<div id="viz2"></div>
    
<?php
$template->footer();
?>