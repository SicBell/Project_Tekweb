<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// Function to send the password reset email
function sendPasswordResetEmail($to, $token) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com'; // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your_email@example.com'; // SMTP username
        $mail->Password   = 'your_password'; // SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('your_email@example.com', 'Your Name');
        $mail->addAddress($to); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset';
        $mail->Body    = "Click the link below to reset your password: <br><a href='http://yourwebsite.com/reset-password.php?token=$token'>Reset Password</a>";

        $mail->send();
        echo 'Password reset email sent successfully!';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
