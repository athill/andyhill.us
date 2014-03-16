<?php
$img = "IMG_20100924_110928.jpg";
$bin = '/usr/bin/';


$local['stylesheets']= array('/css/main.css');
$local['template'] = "Basic";
require_once('../../inc/application.php');


//$dir = '../img/nationalmall/';
$img = '/pictures/img/family/liam.jpg';


$output = array();
//$op = exec($bin.'mogrify ', $out);
$command = $bin.'mogrify -resize 400 '.$fileroot.$img;
echo $command;
$result = exec($command, $output);
echo 'result: '. $result;
print_r($output);

$h->img($img, 'test image');

$template->footer();
?>
