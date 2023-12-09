<?php
// borrowBook.php

session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'user') {
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}

require "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookId = $_POST['id'];
    $username = $_SESSION['username'];
    $returnDate = $_POST['returnDate'];

    // Check if return date is after the maximum allowed date
    $maxAllowedDate = "your_maximum_date_here"; // Replace with your actual maximum date
    if (strtotime($returnDate) > strtotime($maxAllowedDate)) {
        echo json_encode(["error" => "Return date exceeds the maximum allowed date"]);
        exit();
    }

    $updateSql = "UPDATE books SET book_status = 'borrowed' WHERE id = $bookId";
    if (!$mysqli->query($updateSql)) {
        echo json_encode(["error" => "Error updating book status: " . $mysqli->error]);
        exit();
    }

    $userIdSql = "SELECT id FROM accounts WHERE username = '$username'";
    $result = $mysqli->query($userIdSql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['id'];

        $bookTitleSql = "SELECT title FROM books WHERE id = $bookId";
        $bookResult = $mysqli->query($bookTitleSql);
        $bookRow = $bookResult->fetch_assoc();
        $bookTitle = $bookRow['title'];

        $borrowDate = date("Y-m-d");
        $insertSql = "INSERT INTO user_borrowed_books (user_id, username, book_id, book_title, borrow_date, return_date) VALUES ($userId, '$username', $bookId, '$bookTitle', '$borrowDate', '$returnDate')";
        if (!$mysqli->query($insertSql)) {
            echo json_encode(["error" => "Error inserting into user_borrowed_books: " . $mysqli->error]);
            exit();
        }

        $mysqli->close();

        echo json_encode(["success" => "Book borrowed successfully!"]);
    } else {
        echo json_encode(["error" => "Error retrieving user information"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
