<?php

$html = <<<EOT
<ul class="class-name" id="unique-id">
	<li>Nav Item 1</li>
	<li>Nav Item 2
		<ul>
			<li>First Child of Nav Item 2</li>
			<li>Second Child of Nav Item 2</li>
		</ul>
	</li>
	<li>Nav Item 3</li>
</ul>
EOT;
$pre = str_replace("<", "&lt;", $html);
$pre = str_replace(">", "&gt;", $pre);

$geekout=<<<EOT
<p>
The site is powered by 
<a href="http://php.net" target="_blank"><abbr title="PHP Hypertext Processor">PHP</abbr></a>. At work, 
I use Adobe 
<a href="http://www.adobe.com/products/coldfusion-family.html" target="_blank">ColdFusion</a>.
Both are 
<a href="http://en.wikipedia.org/wiki/Server-side_scripting" target="_blank">server-side scripting</a> 
languages. What that means is that they run on a web 
server and generate the content sent to the browser. Often they will interact with outside 
data sources (for example a 
<a href="http://en.wikipedia.org/wiki/Database" target="_blank">database</a>, a text file, 
<a href="http://en.wikipedia.org/wiki/Xml" target="_blank">
<abbr title="eXtensible Markup Language">XML</abbr>
</a>, or
<a href="http://en.wikipedia.org/wiki/JSON" target="_blank">
<abbr title="JavaScript Object Notation">JSON</abbr>
</a>) as well as user interaction 
to generate dynamic content. 
</p>



<p>
In addition to resources such as images and videos, the web programmer provides three types 
of content to the web browser: 
<a href="http://en.wikipedia.org/wiki/Html" target="_blank"><abbr title="HyperText Markup Language">HTML</abbr></a>, 
<a href="http://en.wikipedia.org/wiki/CSS" target="_blank"><abbr title="Cascading Style Sheets">CSS</abbr></a>, and 
<a href="http://en.wikipedia.org/wiki/Javascript" target="_blank">JavaScript</a> (also known as 
<a href="http://en.wikipedia.org/wiki/ECMAScript" target="_blank">ECMAScript</a>. 
Although there is intermingling of functionality, HTML provides the logical structure of the page 
(header, navigation, aside, footer, etc.), CSS provides the presentation (layout, color, fonts, etc.),
and JavaScript provides interactivity. Generally, JavaScript and CSS files are static files, while the 
HTML and which JavaScript and CSS files to include are generated dynamically.
</p>
<p>
A perfect example of this is the navigation. Both the top and sidebar menus on the 
<a href="$webroot/inspire/" target="_blank">Inspiration</a> page are represented by 
HTML unordered lists. To wit:
<pre>
$pre
</pre>
<div style="clear: both"></div>
"ul" stands for "unordered list". By default, this is a bulleted (as opposed to 
numbered (or ordered)) list. Most tags in HTML have opening and closing tags of the 
form &lt;tagName&gt;...&lt;/tagName&gt;.
</p>
EOT;

?>
