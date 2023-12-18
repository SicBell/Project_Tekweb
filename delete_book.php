<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login_page.php");
    exit();
}

// Check if the book id is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['msg'] = "Invalid book id.";
    header("Location: admin_page.php");
    exit();
}

$book_id = $_GET['id'];

require "db_connect.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve the image file name from the database
$sql = "SELECT gambar FROM books WHERE id = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $stmt->bind_result($gambar);

    if ($stmt->fetch()) {
        // Delete the image file from the directory
        $upload_dir = "img/"; // Update with your actual upload directory
        $image_path = $upload_dir . $gambar;
        
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }
    }

    $stmt->close();
}

// Prepare and execute the SQL statement to delete the book
$sql = "DELETE FROM books WHERE id = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['msg'] = "Buku berhasil dihapus.";
} else {
    $_SESSION['msg'] = "Gagal menghapus buku.";
}

// Close the database connection
$mysqli->close();

// Redirect back to the book list page
header("Location: admin_page.php");
exit();
?>
