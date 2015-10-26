<?php
$to = 'andy@andyhill.us';

$subject = 'Website Change Request';

$headers = "From: andy@andyhill.us\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = '<html><body>';
$message .= '<h1>Hello, World!</h1>';
$message .= '</body></html>';

mail($to, $subject, $message, $headers);