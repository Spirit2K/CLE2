<?php
// Bestanden voor PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$body = file_get_contents('php/templates/contact-mail.html');
$body = str_replace('{naam}', $_POST['naam'], $body);
$body = str_replace('{datum}', $_POST['datum'], $body);
$body = str_replace('{tijd}', $_POST['tijd'], $body);
$body = str_replace('{aantal}', $_POST['aantalpersonen'], $body);
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {

    //$mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'hrstudent768@gmail.com';
    $mail->Password = 'E^14DD9gYqDa';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    //Recipients
    $mail->setFrom('hrstudent768@gmail.com', 'Mailer');
    $mail->addAddress($_POST['email'], $_POST['naam'] );     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('hrstudent768@gmail.com');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Bedankt voor uw reservering.';
    $mail->Body    = $body;
    $mail->AltBody = 'Here is your message';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}