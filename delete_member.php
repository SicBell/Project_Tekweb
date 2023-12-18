<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login_page.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['msg'] = "Invalid member id.";
    header("Location: admin_member.php");
    exit();
}

$user_id = $_GET['id'];

require "db_connect.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Prepare and execute the SQL statement to delete the book
$sql = "DELETE FROM accounts WHERE Id = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['msg'] = "user berhasil dihapus.";
} else {
    $_SESSION['msg'] = "Gagal menghapus User.";
}

// Close the database connection
$mysqli->close();

// Redirect back to the book list page
header("Location: admin_member.php");
exit();
?>
