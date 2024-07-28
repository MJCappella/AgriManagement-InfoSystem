<?php
include_once 'vendor/autoload.php';
include_once('../../config/config.php');
function sendMessage($recipient='pndunguedu@gmail.com', $subject='Test', $message='Hello this is a test message')
{
    // Create the Transport
    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, "ssl"))
        ->setUsername(SENDER_EMAIL)
        ->setPassword(SENDER_PASSWORD);

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message($subject))
        ->setFrom([SENDER_EMAIL => 'AMIS INFO'])
        ->setTo([$recipient => 'A name'])
        ->setBody($message);

    // Send the message
    try {
        $result = $mailer->send($message);
        return json_encode(['sent' => true, 'message' => 'Message sent successfully']);
    } catch (Exception $e) {
       return json_encode(['sent' => false, 'message' => $e->getMessage()]);
    }
    return json_encode(['sent' => false, 'message' => 'Error sending email code']);
}
// echo(sendMessage());
?>