<?php
$local['jsModules']['d3'] = true;
$local['scripts'] = array('barchart.js');
$local['headerExtra'] = <<<EOT
<style>
.chart div {
   font: 10px sans-serif;
   background-color: steelblue;
   text-align: right;
   padding: 3px;
   margin: 1px;
   color: white;
}

.chart rect {
   stroke: white;
   fill: steelblue;
 }

</style>
EOT;

include('../inc/application.php');

?>

    <div id="viz"></div>

    <div id="dynamic"></div>

    
<?php
$template->footer();
?>