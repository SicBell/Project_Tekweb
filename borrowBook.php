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

        $sql = "SELECT * FROM books WHERE id = '$bookId'";
        $result = mysqli_query($mysqli, $sql);
        $row;
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
        }
        $bookTitle1 = $row['title'];
        $bookPicture1 = $row['gambar'];
        $bookAuthor1 = $row['pengarang'];
        $bookDate1 = date("d-m-Y", strtotime($row['tahun_terbit']));
        $bookGenre1 = $row['genre'];

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

            $sql = "SELECT borrow_date, return_date FROM user_borrowed_books WHERE book_id =$bookId";
            $result = mysqli_query($mysqli, $sql);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
            }

            $borrowDate = date("d-m-Y", strtotime($row['borrow_date']));
            $returnDate = date("d-m-Y", strtotime($row['return_date']));

            $email = $_SESSION['email'];

            $mail = require __DIR__ . "/mailer.php";
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Borrow Book Details";
            $mail->Body ="
            Thank you for borrowing in YourLibrary.
            <br>
            Here is your book detail:
            <br>
            <img style='' src='cid:book'>
            <br>
            Title: $bookTitle1
            <br>
            Author: $bookAuthor1
            <br>
            Release Date: $bookDate1
            <br>
            Genre: $bookGenre1
            <br><br>
            You are recorded as borrowing this book on $borrowDate and you must return it on $returnDate
            <br><br>
            Thank you for your concern and happy reading! &#128214; &#x2764;
            ";

            $mail->AddEmbeddedImage("img/$bookPicture1", "book");
            try {
                $mail->send();

            } catch (Exception $e) {

                echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                exit;
            }

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