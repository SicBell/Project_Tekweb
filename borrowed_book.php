<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_page.php");
    exit();
}

require "db_connect.php";

$username = $_SESSION['username'];

// Fetch borrowed books for the user
$sql = "SELECT * FROM user_borrowed_books";
$stmt = $mysqli->prepare($sql); 
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any borrowed books
if ($result->num_rows > 0) {
    $borrowedBooks = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $borrowedBooks = [];
}

// Close the database connection
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/borrowed_books.css">
    <title>Borrowed Books</title>
</head>

<body>
<div class="container mt-5">
    <h2>Borrowed Books</h2>
    <?php if (!empty($borrowedBooks)): ?>
        <ul>
            <?php foreach ($borrowedBooks as $book): ?>
                <li class="mt-3">
                    <?php echo $book['book_title']; ?>
                    <form action="borrowBook.php" method="post" style="display: inline;">
                        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                        <button class="btn btn-danger" type="submit" name="return">Return</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No books borrowed.</p>
    <?php endif; ?>
</div>
</body>

</html>
