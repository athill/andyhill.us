<?php
session_start();
require('../vendor/autoload.php');

$data = $_POST;

require('PastorEmail.php');
$pastorEmailer = new PastorEmailer();

if (isset($_FILES['data-file'])) {
	$dataFile = $_FILES['data-file'];
	//// TODO: upload file
	$target_dir = "uploads/";
	if (!file_exists($target_dir)) {
		mkdir($target_dir);
	}
	$target_path = $target_dir . basename($dataFile['name']); 

	if (move_uploaded_file($dataFile['tmp_name'], $target_path)) {
	    echo "The file ".  basename($dataFile['name']). 
	    " has been uploaded";
	} else {
	    echo "There was an error uploading the file, please try again!";
	}
	unlink($target_path);
	rmdir($target_dir);
	//// send emails
	// $status = [];
	// foreach ($data as $datum) {
	// 	$email = $datum['email'];
	// 	// $email = 'andy@andyhill.us';
	// 	$status[] = $pastorEmail->email($datum['name'], $email, $datum['type']);
	// }
} else {
	$status = $pastorEmailer->email($data['name'], $data['email'], $data['type']); 	
}

$_SESSION['message'] = $status;
header('location: index.php');


