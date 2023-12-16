<?php
session_start();

// Check if the user is logged in and is not an admin
if (!isset($_SESSION['username']) || $_SESSION['user_type'] === 'admin') {
    header("Location: login_page.php");
    exit();
}

require "db_connect.php";

// Check if the book_id is provided
if (isset($_POST['book_id'])) {
    $bookId = $_POST['book_id'];

    // Start a transaction to ensure data consistency
    $mysqli->begin_transaction();

    try {
        // Update the book status to "ready"
        $updateSql = "UPDATE books SET book_status = 'ready' WHERE id = ?";
        $updateStmt = $mysqli->prepare($updateSql);
        $updateStmt->bind_param("i", $bookId);

        // Check if the book status is updated successfully
        if ($updateStmt->execute()) {
            // Remove the book entry from the user_borrowed_books table
            $deleteSql = "DELETE FROM user_borrowed_books WHERE book_id = ?";
            $deleteStmt = $mysqli->prepare($deleteSql);
            $deleteStmt->bind_param("i", $bookId);

            // Check if the entry is deleted successfully
            if ($deleteStmt->execute()) {
                // Commit the transaction if everything is successful
                $mysqli->commit();

                // Redirect back to the borrowed books page
                header("Location: borrowed_book.php");
                exit();
            } else {
                throw new Exception("Error deleting entry from user_borrowed_books: " . $deleteStmt->error);
            }
        } else {
            throw new Exception("Error updating book status: " . $updateStmt->error);
        }
    } catch (Exception $e) {
        // An error occurred, rollback the transaction
        $mysqli->rollback();

        // Print the error message
        echo "Transaction failed: " . $e->getMessage();
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
    }

    // Close the statements
    $updateStmt->close();
    $deleteStmt->close();
}

// Close the database connection
$mysqli->close();
?>
