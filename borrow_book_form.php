<?php
require "db_connect.php";

// Retrieve the book ID from the URL parameter
$bookId = isset($_GET['bookId']) ? $_GET['bookId'] : null;

// Fetch book details based on the book ID
$sql = "SELECT * FROM books WHERE id = $bookId";
$result = mysqli_query($mysqli, $sql);

// Check if the query was successful
if ($result && mysqli_num_rows($result) == 1) {
    $book = mysqli_fetch_assoc($result);

    // Calculate the maximum date (20 days from now)
    $maxDate = date("Y-m-d", strtotime("+7 days"));

    // Display book details in a card
    echo "<body style ='display: flex; align-items: center;justify-content: center;'>";
    echo "<div class='card' style='width: 35rem; padding:  45px 0 0 0;'>";
    echo "<img src='img/{$book['gambar']}' class='card-img-top' alt='{$book['title']}'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>{$book['title']}</h5>";
    echo "<p class='card-text'>Author: {$book['pengarang']}</p>";
    echo "<p class='card-text'>Synopsis: {$book['sinopsis']}</p>";
    echo "<p class='card-text'>Genre: {$book['genre']}</p>";
    echo "<p class='card-text'>Publication Year: {$book['tahun_terbit']}</p>";
    echo "</body>";

    // Form to initiate the borrowing process with Return Date input
    echo "<form action='borrowBook.php' method='post'>";
    echo "<input type='hidden' name='book_id' value='{$book['id']}'>";

    // Add Return Date input with max attribute
    echo "<div class='mb-3'>";
    echo "<label for='returnDate' class='form-label'>Return Date</label>";
    echo "<input type='date' class='form-control' id='returnDate' name='return_date' required max='{$maxDate}'>";
    echo "</div>";

    // Add Borrow button
    echo "<button type='submit' class='btn btn-primary' name='borrow'>Borrow</button>";
    echo "</form>";

    echo "</div>";

    // You can also add a form or button for the user to proceed with borrowing
} else {
    // Handle the case when the book ID is not valid or the book doesn't exist
    echo "Book not found.";
}

// Close the database connection
mysqli_close($mysqli);
?>

<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login_page.php");
    exit();
}

require "db_connect.php";

$username = $_SESSION['username'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php require "header.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

