<?php
session_start();
require('../vendor/autoload.php');

$data = $_POST;

require('PastorEmailer.php');
$pastorEmailer = new PastorEmailer();

if (isset($_FILES['data-file'])) {
	$dataFile = $_FILES['data-file'];
	//// upload file
	$target_dir = "uploads/";
	if (!file_exists($target_dir)) {
		mkdir($target_dir);
	}
	$target_path = $target_dir . basename($dataFile['name']); 
	if (move_uploaded_file($dataFile['tmp_name'], $target_path)) {
	    $data = json_decode(file_get_contents($target_path), true);
		//// send emails
		$status = [];
		foreach ($data as $datum) {
			$email = $datum['email'];
			// $email = 'andy@andyhill.us';
			$status[] = $pastorEmailer->email($datum['name'], $email, $datum['type']);
		}
	} else {
	    $status = "There was an error uploading the file, please try again!";
	}
	unlink($target_path);
	rmdir($target_dir);

} else {
	$status = $pastorEmailer->email($data['name'], $data['email'], $data['type']); 	
}

$_SESSION['message'] = $status;
header('location: index.php');


