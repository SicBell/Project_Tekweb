<?php
include("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database and is not expired
    $currentDateTime = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("SELECT email FROM users WHERE reset_token_hash = ? AND reset_token_expires_at > ?");
    $stmt->bind_param("ss", $token, $currentDateTime);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Token is valid, allow the user to reset the password
        // Display a form for the user to enter a new password
    } else {
        echo 'Invalid or expired token';
    }

    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission to update the password in the database
    $newPassword = $_POST['newPassword'];
    $token       = $_POST['token'];

    // Update the password and clear the reset_token in the database
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE reset_token_hash = ?");
    $stmt->bind_param("ss", $hashedPassword, $token);
    $stmt->execute();

    echo 'Password reset successful!';

    $stmt->close();
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
                    <div class="title">Reset Password</div>
                    <div class="input-boxes">
                        <div class="input-box">
                            <i id="logo" class="fas fa-lock"></i>
                            <input type="password" id="newPassword" name="newPassword" placeholder="Enter your new password" required>
                        </div>
                        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                        <div class="button input-box">
                            <input type="submit" value="Reset Password">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
