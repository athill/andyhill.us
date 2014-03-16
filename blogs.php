<?php

require_once('inc/setup.inc.php');
$page = new Page();
$geekout=<<<EOT
<p>
Both these blogs use 
<a href="http://wordpress.org/" target="_blank">WordPress</a>, 
which isn't really geeky at all. You can administrate a WordPress blog 
without coding at all. It's free, open source, and highly configurable. 
There's even 
<a href="http://wordpress.com/" target="_blank">free hosting available</a>.
That said, if you want to geek out, you can design themes and author 
plug-ins.
</p>
<p>
Many thanks to the WordPress team, as well as the theme and plug-in developers.
</p> 
EOT;
$page->template->template->geekOut($geekout);

$h->op();
$h->a('http://andyhill.us/codeblog/', 'codeblog', 
	'target="_blank"');
$text=<<<EOT
 is a blog related especially to code, but branches into other 
technologies that relate to the web, such as audio, video, and image 
editors.
EOT;
$h->tnl($text);
$h->cp();


$h->op();
$h->a('http://ttmsoia.andyhill.us', 'trying to make sense of it all', 
	'target="_blank"');
$text=<<<EOT
 is about everything else, often concerning politics and religion (you've 
been warned), but potentially whatever's on my mind.
EOT;
$h->tnl($text);
$h->cp();

$page->end();
?>