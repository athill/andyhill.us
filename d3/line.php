<?php
$local['jsModules']['d3'] = true;
$local['jsModules']['ui'] = true;
$local['scripts'] = array('/js/linechart.jquery.js');

include('../inc/application.php');

$h->tbr('Modified from <a href="http://www.verisi.com/resources/d3-tutorial-basic-charts.htm#s2" target="_blank">http://www.verisi.com/resources/d3-tutorial-basic-charts.htm#s2</a>.');

$h->br();

$h->tbr('Source: <a href="http://www.whitehouse.gov/sites/default/files/omb/budget/fy2013/assets/hist01z1.xls" target="_blank">http://www.whitehouse.gov/sites/default/files/omb/budget/fy2013/assets/hist01z1.xls</a>.');

http://www.whitehouse.gov/sites/default/files/omb/budget/fy2013/assets/hist01z1.xls

?>

    <div id="line-chart"></div>

    <div id="line-chart2"></div>

    
<?php

$h->scriptfile(array('/js/linechart.jquery.js', 'line.js'));

$template->footer();
?>