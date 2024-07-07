<?php
//You will need to run composer require "swiftmailer/swiftmailer:^6.0"
require_once 'vendor/autoload.php';
include_once('../../config/config.php');

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, "ssl"))
  ->setUsername(SENDER_EMAIL)
  ->setPassword(SENDER_PASSWORD);

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('My Subject'))
  ->setFrom([SENDER_EMAIL => 'AMIS INFO'])
  ->setTo(['pndunguedu@gmail.com', 'jamiedean639@gmail.com' => 'A name'])
  ->setBody('Hope this message finds you well. It is just a greeting.');

// Send the message
try {
  $result = $mailer->send($message);
  echo 'Message has been sent successfully.';
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
 ?>