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

$h->tbr('Modified from <a href="http://www.verisi.com/resources/d3-tutorial-basic-charts.htm#s2" target="_blank">http://www.verisi.com/resources/d3-tutorial-basic-charts.htm#s2</a>.');

$h->br();

$h->tbr('Source: <a href="http://www.whitehouse.gov/sites/default/files/omb/budget/fy2013/assets/hist01z1.xls" target="_blank">http://www.whitehouse.gov/sites/default/files/omb/budget/fy2013/assets/hist01z1.xls</a>.');

http://www.whitehouse.gov/sites/default/files/omb/budget/fy2013/assets/hist01z1.xls

?>

    <div id="line-chart"></div>



    
<?php
$template->footer();
?>