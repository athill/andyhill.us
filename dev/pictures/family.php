<?php
require_once("../inc/application.php");

$category = "family";

require_once("Galleria.class.php");
$gallery = new Galleria($category);
$gallery->render();

$template->footer();
?>
