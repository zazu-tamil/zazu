<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST['send'])) {
    $name    = htmlspecialchars($_POST['name']);
    $email   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        echo "<script>alert('Fill all fields!'); history.back();</script>";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'naveenmanogaren@gmail.com';
        $mail->Password   = 'fmpg ccab mvnp pxnn'; // Replace with real Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('naveenmanogaren@gmail.com', 'Zazu Contact Form');
        $mail->addAddress('naveenmanogaren@gmail.com');  
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Website: ' . $subject;
        $mail->Body    = "
            <h3>New Contact Form Message</h3>
            <p><b>Name:</b> $name</p>
            <p><b>Email:</b> $email</p>
            <p><b>Subject:</b> $subject</p>
            <p><b>Message:</b><br>$message</p>
        ";

        $mail->send();
        echo "<script>alert('Thank you! Message sent successfully.'); window.location.href='contact.html';</script>";

    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
