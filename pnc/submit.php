<?php
require('../vendor/autoload.php');

echo 'here';

$to = $_POST['email'];

$subject = 'Website Change Request';

$headers = "From: andy@andyhill.us\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


$templatefile = 'templates/'.strtolower($_POST['type']).'.html';

echo 'file: '.$templatefile;

$template = file_get_contents($templatefile);
$template = str_replace('[Name]', $_POST['name'], $template);

$message = $template;
// $message .= '<h1>Hello, World!</h1>';


echo '<div>'.$message.'</div>';

// mail($to, $subject, $message, $headers);

$email = new PHPMailer();
$email->From      = 'andy@andyhill.us';
$email->FromName  = 'Andy Hill';
$email->Subject   = 'Response';
$email->Body      = $message;
$email->AddAddress($_POST['email']);


echo 'SENT';
// $file_to_attach = 'PATH_OF_YOUR_FILE_HERE';

$return = $email->Send();


var_dump($return);

// $email->AddAttachment( $file_to_attach , 'NameOfFile.pdf' );