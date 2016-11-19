<?php

$directory['jsModules']['galleria'] = true;
$directory['stylesheets'] = array('pictures.css');
$directory['scripts'] = array('pictures.js');
$directory['leftSideBar'] = array('type' =>'menu', 'args' => array());

$h->startBuffer();
$h->odiv('id="galleria-sidebar"');
$h->div(' ', 'id="galleria-title"');
$h->div(' ', 'id="galleria-descr"');
$h->cdiv();
$rsb = $h->endBuffer();
$directory['rightSideBar'] = $rsb;

?>
