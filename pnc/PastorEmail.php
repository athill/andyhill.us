<?php

class PastorEmail {

	function __construct($mail) {
	}

	function email($name, $email, $type) {
		$subject = ' Pastor Information Form response from United Presbyterian Church';


		//// Build message
		$templatefile = 'templates/'.strtolower($type).'.html';
		$message = file_get_contents($templatefile);
		$message = str_replace('[Name]', $name, $message);


		//// Build email
		$mail = new PHPMailer();
		$mail->From      = 'andy@andyhill.us';
		$mail->FromName  = 'Andy Hill';
		$mail->Subject   = $subject;
		$mail->Body      = $message;
		$mail->AddAddress($email);
		$mail->isHTML(true);      

		if ($type == 'Match') {
			$mail->addAttachment('ministry_information_form_2015.doc', 'UPC Ministry Information Form, 2015');    // Optional name	
		}

		$mail->addCC('andy@andyhill.us');



		//// send email
		$status = '';
		if(!$mail->send()) {
		    $status = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    $status = 'Sent: <div class="well">'.$message.'</div> to: '.$email.' ('.$name.')';
		}		
		return $status;
	}
}