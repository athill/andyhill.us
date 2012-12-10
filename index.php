<?php
require_once("inc/application.php");
////Geekout
$h->startBuffer();
$g1=<<<EOT
This site uses PHP as its server side language. My thanks to the PHP team. 
All the navigation is generated using an 
XML file that defines the structure of the site. 
EOT;
$h->p($g1);
////g2
$h->startBuffer();
$h->tnl("jQuery is used heavily. My thanks to the jQuery team as well as the " .
	"authors of the brilliant plugins I make use of. Specifically, this site uses ");
$h->a("http://users.tpg.com.au/j_birch/plugins/superfish/", "Superfish", 'target="blank"');
$h->tnl(" for its global (top) navigation menu and ");
$h->a("http://bassistance.de/jquery-plugins/jquery-plugin-treeview/", "jQuery Treeview", 'target="blank"');
$h->tnl(" for second-tier (side) navigation. Other plugins will be acknowledged on their ". 
	"resective pages' Geek Outs");
$g2 = $h->endBuffer();
$h->p(trim($g2));
////g3
$g3=<<<EOT
The primary engine of the site is contained in application.php, which sets defaults for 
the infrastructure of the site. This includes setting basic convenience variables such as 
which page is being viewed, as well as more complex settings, such as which CSS and 
JavaScript modules to load. These settings can be overridden for an entire directory 
in special files called "directorySettings.php" or in the file itself where you can override 
both the default and directory settings. The page rendering uses a template model, with a 
base template class providing core functionality, while specific templates can override 
or ignore default functionality, styles, and behaviors. 
EOT;
$h->p($g3);

$geekout = $h->endBuffer();

$template->template->geekOut($geekout);

////content
$p1 = <<<EOT
My name is Andy Hill. I am a programmer in 
<a href="http://bloomington.in.gov/" target="_blank">Bloomington, Indiana</a>. 
Primarily a web developer. I got my Bachelor of Science in Computer Science from 
<a href="https://www.iu.edu/" target="_blank">Indiana University</a> 
at the age of 33. I currently work for the University in 
<a href="https://usss.iu.edu/" target="_blank">University Student Services and Systems</a>. 
There is no relationship between Indiana University and this site.
EOT;

$p2 = <<<EOT
This site is primarily a playground for me to play with web programming technologies, 
though there is value to the content as well (I especially find the 
<a href="/news/">News</a> page practical). Many pages will have a "Geek Out" button 
at the top. Clicking on this will 
toggle technical information about the technologies used on the page.
EOT;


$h->p($p1);
$h->p($p2);

$template->footer();
?>
