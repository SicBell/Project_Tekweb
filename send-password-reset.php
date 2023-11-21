<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './db_connect.php';
// Function to send the password reset email
function sendPasswordResetEmail($recipientsemail, $token) {
    $mail = new PHPMailer(true);
    $recipientsemail = $_POST['email'];
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Google's SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'SicLibrary1986@gmail.com'; // Your Gmail email address
        $mail->Password   = 'ljgl wexj bsuh dabl'; // Your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('warrenmiltaico6@gmail.com', 'Your Name');
        $mail->addAddress($recipientsemail); // Add a recipient

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
