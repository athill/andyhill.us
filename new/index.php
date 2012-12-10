<?php $lorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel est odio. Ut sit amet lacus dolor, ut luctus mauris. Aenean pulvinar malesuada dui, vitae volutpat augue porta eu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc vitae fringilla metus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sodales, sem eu pharetra ultricies, enim nisl viverra odio, quis consectetur lorem risus a lectus. Etiam risus mi, sollicitudin id ultrices quis, eleifend eu metus. Nam aliquet metus nec nibh aliquam eget adipiscing urna rhoncus. In non ante at dolor convallis elementum et ut arcu. Fusce ligula nunc, sollicitudin quis scelerisque quis, accumsan ut ipsum. Duis in ligula sit amet risus dapibus ultrices. Suspendisse fermentum tristique enim id pretium. Sed viverra, leo quis posuere auctor, orci sapien bibendum quam, eget laoreet dolor arcu vel sapien." ?>

<?php
require_once("inc/application.php");

//echo $_SERVER['SCRIPT_FILENAME'];
$h->tnl($lorem);
$local['template'] = "new";

$h->tnl($lorem);
$h->br();
$h->a('http://andyhill.us', "Here's a link");

$template->footer();
?>
