<?php
include("db_connect.php");
include("Sign_up.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Perform validation on the email address

    // Generate a unique token for password reset
    $token = md5(uniqid(rand(), true));

    // Store the hashed token and expiration time in the database
    $tokenHash = password_hash($token, PASSWORD_DEFAULT);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    $stmt = $conn->prepare("UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?");
    $stmt->bind_param("sss", $tokenHash, $expiresAt, $email);
    $stmt->execute();
    $stmt->close();

    // Send the password reset email
    require 'send-password-reset.php';
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <form action="" method="post" class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Forgot Password</div>
                    <div class="input-boxes">
                        <div class="input-box">
                            <i id="logo" class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="button input-box">
                            <input type="submit" value="Send Reset Email">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
