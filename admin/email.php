<?php

require("includes/sendgrid/sendgrid-php.php");

$from = new SendGrid\Email("Sender Fullname", "chernand@redhat.com");
$subject = "Sending with SendGrid is Fun";
$to = new SendGrid\Email("Recv Fullname", "paintball814@gmail.com");
$content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");
$mail = new SendGrid\Mail($from, $subject, $to, $content);

$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($mail);
if ($response->statusCode() == 202) {
	echo "<h1>Email Sent</h1>";
} else {
	echo "<h1>ERROR: Email failed</h1>";
}
//echo $response->statusCode();
//print_r($response->headers());
//echo $response->body();
?>
