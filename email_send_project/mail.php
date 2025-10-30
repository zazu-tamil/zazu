<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["send"])) {

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'admin@uniquecollege.in';  // Your email
        $mail->Password   = '2025@uniquE';             // Your password
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        // Sender: Must be the authenticated email
        $mail->setFrom('admin@uniquecollege.in', 'Zazu Contact Form');

        // Recipient
        $mail->addAddress('admin@uniquecollege.in'); // Or info@zazutech.in

        // Reply-To: Visitor's email so you can reply directly
        $mail->addReplyTo($_POST["email"], $_POST["name"]);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';

        $mail->Body = '
        <div style="font-family: Arial, sans-serif; font-size: 16px; color: #333; line-height: 1.6;">
            <h2 style="color: #2c3e50;">New Message from Contact Form</h2>
            <hr>
            <p><strong>Name:</strong> ' . htmlspecialchars($_POST["name"]) . '</p>
            <p><strong>Email:</strong> ' . htmlspecialchars($_POST["email"]) . '</p>
            <p><strong>Subject:</strong> ' . htmlspecialchars($_POST["subject"]) . '</p>
            <p><strong>Message:</strong><br>' . nl2br(htmlspecialchars($_POST["message"])) . '</p>
            <hr>
            <small style="color: #7f8c8d;">Sent from Zazu Technologies website contact form.</small>
        </div>';

        $mail->send();
        
        // Success: Redirect
        echo "<script>alert('Thank you! Your message has been sent.'); window.location.href='contact.html';</script>";

    } catch (Exception $e) {
        // Error: Show user-friendly message
        echo "<script>alert('Sorry, message could not be sent. Error: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
?>