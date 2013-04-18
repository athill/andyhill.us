<?php
include_once('../../inc/application.php');

$pages = array(
	'404'=>array(
		'title'=>'Not Found',
		'content'=>'The requested URL <!--#echo var="REQUEST_URI" --> was not found on this server. Thanks for visiting.'
	),
	'400'=>array(
		'title'=>'Cannot be found',
		'content'=>'The requested URL <!--#echo var="REQUEST_URI" --> cannot be found. Thanks for visiting.'
	),
	'500'=>array(
		'title'=>'Internal Server Error',
		'content'=>debugInfo()
	)	
);


foreach ($pages as $id => $atts) {
	$site['pageTitle'] = $id.' '.$atts['title'];
	$h->startBuffer();
	$template->head();
	$template->heading();	
	$h->h1($atts["title"]);
	$h->p($atts['content']);
	$template->footer();
	$content = trim($h->endBuffer());
	$errorFile = $site['fileroot'].'/'.$id.'.shtml';
	$h->tbr($errorFile);
	// file_put_contents($errorFile, $content);
}




$template->footer();


function debugInfo() {
	global $h;
	$vars = array(
		'HTTP_REFERER', 'REMOTE_ADDR', 'REQUEST_URI', 'HTTP_HOST', 'HTTP_USER_AGENT', 'REDIRECT_STATUS'
	);
	$h->startBuffer();
	foreach ($vars as $var) {
		$h->odl();
		$h->dt($var);
		$h->dd('<!--#echo var="'.$var.'" -->');
		$h->cdl();
	}
	return trim($h->endBuffer());

}

?>