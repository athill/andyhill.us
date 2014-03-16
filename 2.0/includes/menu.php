<?php
//print("<pre>");
//print_r($vals);
//print("</pre>");
$level = 1;
$subdir = "";
if ($GLOBALS['menuStyle'] == "popup") {
	print("<div id=\"dhtmlgoodies_menu\">\n");
	aLink("${view}&menuStyle=tree", "Tree Menu");
	print("<ul>\n");
	
} else {
	print("<div>\n");
	aLink("${view}&menuStyle=popup", "Popup Menu");
	print("<ul class=\"mktree\">\n");
}
$i = 2;
foreach ($vals as $val) {
	if ($GLOBALS['menuStyle'] == "tree" || $val['level'] < 4) {
		if ($val['tag'] == "LINK" || ($val['tag'] == "LINKS" && $val['type'] == "complete")) {
			print("<li>");
			doLink($val, $subdir);
			print("</li>\n");
		} else if ($val['tag'] == "LINKS" && $val['type'] == "open") {
			print("<li>\n");
			doLink($val, $subdir);
			$subdir .= $val['attributes']['HREF'];
			
			print("<ul>\n");
			$i++;
		} else if ($val['tag'] == "LINKS" && $val['type'] == "close") {
//			print("before: $subdir");
			$subdir = preg_replace("/(.*\/)[^\/]+\/$/", "$1", $subdir);
			if ($subdir == "/") $subdir = "";
//			print("after: $subdir");		
			print("</li>\n</ul>\n");
		}	
	}
}
print("</ul>\n");
print("</div>\n");


?>