<?php
if (!isset($_POST['name']) || $_POST['name'] =="" ||
		!isset($_POST['email']) || $_POST['email'] =="" ||
		!isset($_POST['subject']) || $_POST['subject'] =="" ||
		!isset($_POST['message']) || $_POST['message'] =="") {
	header("Location: contact.php?mssg=Please complete all fields.");
}

$to = "andyhil@andyhill.us";
$message = $_POST['name'] . 
	"(" . $_SERVER['REMOTE_ADDR']  . "/" .
  $_SERVER['REMOTE_HOST'] . 
	") said: \n\n" . $_POST['message'];

$headers = "From: " . $_POST['email'] . "\r\n" .
   'X-Mailer: PHP/' . phpversion();

if (mail($to, $_POST['subject'], $message, $headers)) {
	header("Location: contact.php?mssg=Message sent");
} else {
	echo "There was an error. Please try again.";
}
?>
