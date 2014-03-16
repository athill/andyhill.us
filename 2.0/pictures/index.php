<?php
$xmlFile = $GLOBALS['fileroot'] . "/pictures/images.xml";
//parse the XML
if(!$xml=simplexml_load_file($xmlFile)) {
	trigger_error('Error reading XML file',E_USER_ERROR);
}		

foreach ($xml as $category) {
	$header = $category['header'];
	$h->odiv('class="pictures-group"');
	$h->h(2, $header);
	if (array_key_exists('comment', $category)) {
		$h->div($category['comment'], 'class="comment"');
	}
	foreach ($category as $image) {
		$h->odiv('class="picture"');
		$h->startBuffer();
		$h->etag("img", 'src="'.$image['src'].'" class="image"');
		$h->a($image['src'] , trim($h->endBuffer()), 
			"title=\"".$image['title']."\" rel=\"lightbox[$header]\"");
		$h->cdiv();

	}
	$h->cdiv();
}
