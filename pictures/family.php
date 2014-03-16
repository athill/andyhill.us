<?php
require_once("../inc/startup.inc.php");
$page = new Page();

$category = "family";

require_once("Galleria.class.php");
$gallery = new Galleria($category);
$gallery->render();

$page->end();
?>
