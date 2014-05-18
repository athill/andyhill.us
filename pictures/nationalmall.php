<?php
require_once("../inc/setup.inc.php");
$page = new Page();

$category = "nationalmall";

require_once("Galleria.class.php");
$gallery = new Galleria($category);
$gallery->render();

$page->end();
?>
