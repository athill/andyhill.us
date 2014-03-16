<?php
require_once("../inc/setup.inc.php");
$page = new Page();
$category = "nationalmall";

////geek out
$geekout=<<<EOT
This subsite uses the Galleria jQuery plugin, which is pretty nice. It's primarily 
out-of-the-box behavior, except that I took advantage of their API to display 
the title and description in the right sidebar.
EOT;
$page->template->template->geekOut($geekout);

////content
require_once("Galleria.class.php");
$gallery = new Galleria($category);
$gallery->render();

$page->end();
?>
