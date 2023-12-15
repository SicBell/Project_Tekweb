<?php

// Include necessary files and configurations
$mysqli = require __DIR__ . "/db_connect.php";
$mail = require __DIR__ . "/mailer.php";

// Query books with return date equal to tomorrow
$tomorrow = date("Y-m-d", strtotime("+1 day"));
$sql = "SELECT * FROM user_borrowed_books WHERE return_date = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $tomorrow);
$stmt->execute();
$result = $stmt->get_result();

// Iterate over books with return date tomorrow
while ($book = $result->fetch_assoc()) {
    $userId = $book['user_id'];
    $bookTitle = $book['book_title'];

    // Query user email based on user ID
    $userEmailSql = "SELECT email FROM accounts WHERE id = ?";
    $userEmailStmt = $mysqli->prepare($userEmailSql);
    $userEmailStmt->bind_param("i", $userId);
    $userEmailStmt->execute();
    $userEmailResult = $userEmailStmt->get_result();

    // If user email is found, send the email reminder
    if ($userEmailRow = $userEmailResult->fetch_assoc()) {
        $userEmail = $userEmailRow['email'];

        // Email content
        $mail->setFrom("noreply@example.com");
        $mail->addAddress($userEmail);
        $mail->Subject = "Book Return Reminder";
        $mail->Body = "Hello,\n\nYour borrowed book '$bookTitle' is due for return tomorrow. Please ensure to return it on time.\n\nThank you.";

        // Send email
        try {
            $mail->send();
            echo "Email sent successfully to $userEmail for book '$bookTitle'.<br>";
        } catch (Exception $e) {
            echo "Error sending email to $userEmail for book '$bookTitle': {$mail->ErrorInfo}<br>";
        }
    }

    $userEmailStmt->close();
}

$stmt->close();
$mysqli->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Sent!</title>
</head>
<body>
  <div>
    <p>Emails have been sent to remind users of upcoming book returns.</p>
  </div>
</body>
</html>
