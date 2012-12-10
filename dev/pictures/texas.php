<?php
require_once("../inc/application.php");

$category = "texas";

require_once("Galleria.class.php");
$gallery = new Galleria($category);
$gallery->render();

$template->footer();
?>
