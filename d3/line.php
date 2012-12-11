<?php
$local['jsModules']['d3'] = true;
$local['scripts'] = array('line.js');
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

    <div id="line-chart"></div>



    
<?php
$template->footer();
?>