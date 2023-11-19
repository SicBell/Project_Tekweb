<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login_page.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome, Admin</title>
</head>
<body>
    <h2>Welcome, Admin <?php echo $username; ?>!</h2>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
