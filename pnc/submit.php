<?php
require('../vendor/autoload.php');

$to = $_POST['email'];

$subject = 'Website Change Request';


//// Build message
$templatefile = 'templates/'.strtolower($_POST['type']).'.html';
$message = file_get_contents($templatefile);
$message = str_replace('[Name]', $_POST['name'], $message);


//// Build email
$mail = new PHPMailer();
$mail->From      = 'andy@andyhill.us';
$mail->FromName  = 'Andy Hill';
$mail->Subject   = 'Response';
$mail->Body      = $message;
$mail->AddAddress($_POST['email']);
$mail->isHTML(true);      

if ($_POST['type'] == 'Match') {
	$mail->addAttachment('ministry_information_form_2015.doc', 'UPC Ministry Information Form, 2015');    // Optional name	
}

//// send email
if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    print('Sent: <div>'.$message.'</div> to: '.$_POST['email'].' ('.$_POST['email'].')';
}


