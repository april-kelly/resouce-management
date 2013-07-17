<?php
require_once('Mail.php');
require_once('Mail\mime.php');

$message = new Mail_mime();
$text = file_get_contents("text.txt");
$html = file_get_contents("html.html");

$message->setTXTBody($text);
$message->setHTMLBody($html);
$body = $message->get();
$extraheaders = array("From"=>"liam@bluetent.com", "Subject"=>"My Subject");
$headers = $message->headers($extraheaders);

$mail = Mail::factory("mail");
$mail->send("liam@bluetent.com", $headers, $body);