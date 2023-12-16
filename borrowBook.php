<?php
// borrowBook.php

session_start();

if (!isset($_SESSION['username'])) {
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}

require "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['borrow'])) {
        $bookId = $_POST['book_id'];
        $username = $_SESSION['username'];

        // Ensure you have a valid return date in your form
        $returnDate = $_POST['return_date'];

        $maxAllowedDate = date("Y-m-d", strtotime("+7 days"));

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
            $_SESSION['success_message'] = "Book borrowed successfully!";

            $mysqli->close();

            header("Location: index.php"); 
            exit();
        } else {
            echo json_encode(["error" => "Error retrieving user information"]);
        }
    } elseif (isset($_POST['return'])) {
        $bookId = $_POST['book_id'];

        $updateSql = "UPDATE books SET book_status = 'available' WHERE id = $bookId";
        if (!$mysqli->query($updateSql)) {
            echo json_encode(["error" => "Error updating book status: " . $mysqli->error]);
            exit();
        }

        $deleteSql = "DELETE FROM user_borrowed_books WHERE book_id = $bookId";
        if (!$mysqli->query($deleteSql)) {
            echo json_encode(["error" => "Error deleting from user_borrowed_books: " . $mysqli->error]);
            exit();
        }
        $_SESSION['success_message'] = "Book returned successfully!";

        $mysqli->close();

        header("Location: index.php"); 
        exit();
    } else {
        echo json_encode(["error" => "Invalid request"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>