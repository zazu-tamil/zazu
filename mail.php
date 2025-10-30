<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["send"])) {

    $mail = new PHPMailer(true);

    try {
        // =========================
        // SMTP SERVER CONFIGURATION
        // =========================
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'naveen@zazutech.in';  // Your email
        $mail->Password = 'Naveen$2025';             // Your password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Sender
        $mail->setFrom('naveen@zazutech.in', 'Zazu Technologies');
        $mail->addAddress('info@zazutech.in'); // Receiver
        $mail->addCC('tamil@zazutech.in'); 
        $mail->addReplyTo($_POST["email"], $_POST["name"]);

        // Check which form was submitted
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            // =============================
            // CAREER FORM PROCESSING
            // =============================

            $name = htmlspecialchars($_POST["name"]);
            $email = htmlspecialchars($_POST["email"]);
            $phone = htmlspecialchars($_POST["phone"]);
            $position = htmlspecialchars($_POST["subject"]);
            $message = nl2br(htmlspecialchars($_POST["message"]));

            // Attach resume
            $fileTmpPath = $_FILES['resume']['tmp_name'];
            $fileName = $_FILES['resume']['name'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExt = ['pdf', 'doc', 'docx'];

            if (in_array($fileExt, $allowedExt)) {
                $mail->addAttachment($fileTmpPath, $fileName);
            }

            // Email content for career form
            $mail->isHTML(true);
            $mail->Subject = "New Career Application: $position";
            $mail->Body = '
            <div style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
                <h2 style="color: #2c3e50;">New Career Application Received</h2>
                <hr>
                <p><strong>Name:</strong> ' . $name . '</p>
                <p><strong>Email:</strong> ' . $email . '</p>
                <p><strong>Phone:</strong> ' . $phone . '</p>
                <p><strong>Position Applied For:</strong> ' . $position . '</p>
                <p><strong>Message:</strong><br>' . $message . '</p>
                <p><strong>Resume:</strong> Attached File</p>
                <hr>
                <small style="color:#888;">Sent from Zazu Technologies Career Page.</small>
            </div>';

            // Send mail
            $mail->send();
            echo "<script>alert('✅ Thank you! Your application has been submitted successfully.'); window.location.href='careers.html';</script>";

        } else {
            // =============================
            // CONTACT FORM PROCESSING
            // =============================

            $name = htmlspecialchars($_POST["name"]);
            $email = htmlspecialchars($_POST["email"]);
            $subject = htmlspecialchars($_POST["subject"]);
            $message = nl2br(htmlspecialchars($_POST["message"]));

            // Email content for contact form
            $mail->isHTML(true);
            $mail->Subject = "New Contact Message: $subject";
            $mail->Body = '
            <div style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
                <h2 style="color: #2c3e50;">New Contact Form Message</h2>
                <hr>
                <p><strong>Name:</strong> ' . $name . '</p>
                <p><strong>Email:</strong> ' . $email . '</p>
                <p><strong>Subject:</strong> ' . $subject . '</p>
                <p><strong>Message:</strong><br>' . $message . '</p>
                <hr>
                <small style="color:#888;">Sent from Zazu Technologies Contact Page.</small>
            </div>';

            // Send mail
            $mail->send();
            echo "<script>alert('✅ Thank you! Your message has been sent successfully.'); window.location.href='contact.html';</script>";
        }

    } catch (Exception $e) {
        echo "<script>alert('❌ Sorry, message could not be sent. Error: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
?>