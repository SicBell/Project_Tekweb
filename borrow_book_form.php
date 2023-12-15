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
    echo "<div class='card' style='width: 18rem;'>";
    echo "<img src='img/{$book['gambar']}' class='card-img-top' alt='{$book['title']}'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>{$book['title']}</h5>";
    echo "<p class='card-text'>Author: {$book['pengarang']}</p>";
    echo "<p class='card-text'>Synopsis: {$book['sinopsis']}</p>";
    echo "<p class='card-text'>Genre: {$book['genre']}</p>";
    echo "<p class='card-text'>Publication Year: {$book['tahun_terbit']}</p>";

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
