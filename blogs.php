<?php
require_once('inc/setup.inc.php');
$page = new Page();

function getExternalLink($href, $label) {
	global $h;
	return $h->rtn('a', [$href, $label, 'target="_blank"']);
} 

//// geekout
$staticSiteLink = getExternalLink('https://davidwalsh.name/introduction-static-site-generators', 'static web site');
$githubLink = getExternalLink('https://github.com/', 'GitHub');
$jekyllLink = getExternalLink('https://jekyllrb.com/', 'Jeckyll');
$rubyLink = getExternalLink('https://www.ruby-lang.org/en/', 'Ruby');
$geekout=<<<EOT
<p>
Both blogs are a mess. Thankfully, the content is fairly secure.
<ul>
	<li>
	Codeblog is a $staticSiteLink hosted by $githubLink at athill.github.io. It uses the $jekyllLink static site generator. What this means is that there is no server-side programming language (e.g., PHP). Instead, Jekyll (written in $rubyLink) takes my site templates and media and generates a static website (html, images, javascript, css, etc.). This can improve performance, as the server-side code does not have to generate each page request, but it's limiting (e.g., you don't have a server to get data from).
	</i>
	<li>
	trying to make sense of it all uses the <a href="http://wordpress.org/" target="_blank">WordPress</a> blogging/website framework.  
	It's a powerful PHP framework and does a lot for you, but can be limiting unless you really get to know it, which I have not done, so it's primarily just a vehicle for content.
	</li>
</ul>
</p> 
EOT;
$page->template->template->geekOut($geekout);

//// content
$h->p("As of this writing, I haven't updated either of these blogs for a while. I still like the ideas, so I'll try to address that.");

$codeblogLink = getExternalLink('http://athill.github.io', 'codeblog');
$text=<<<EOT
$codeblogLink is a blog related especially to code, but branches into other 
technologies that relate to the web, such as audio, video, and image 
editors. 
EOT;
$h->p($text);


$ttmsoiaLink = getExternalLink('http://ttmsoia.andyhill.us', 'trying to make sense of it all');
$text=<<<EOT
$ttmsoiaLink is about everything else, sometimes concerning politics and religion (you've 
been warned), but potentially whatever's on my mind.
EOT;
$h->p($text);

$page->end();