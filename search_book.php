<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login_page.php");
    exit();
}

require "header.php";
require "db_connect.php";

// Get the search query from the form
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Perform a SQL query to search for books with matching titles
$query = "SELECT * FROM books WHERE title LIKE '%$search_query%'";
$result = $mysqli->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <!-- Add any additional styles or meta tags needed for the search results page -->
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <h2>Search Results</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul Buku</th>
                        <th>Pengarang</th>
                        <th>Tahun Terbit</th>
                        <th>Genre</th>
                        <th>Sinopsis</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['pengarang']; ?></td>
                            <td><?php echo $row['tahun_terbit']; ?></td>
                            <td><?php echo $row['genre']; ?></td>
                            <td><?php echo $row['sinopsis']; ?></td>
                            <td>
                                <?php
                                $gambarPath = 'img/' . $row['gambar'];
                                echo "<img src='$gambarPath' alt='Book Image' style='max-width: 100px; max-height: 100px;' onclick='displayEnlargedImg(\"$gambarPath\")'>";
                                ?>
                            </td>
                            <td><?php echo $row['book_status']; ?></td>
                            <td>
                                <a class="btn btn-primary" href="edit_book.php?id=<?php echo $row['id']; ?>">Ubah</a>
                                <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this book?')">Hapus</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php
// Close the database connection
$mysqli->close();
?>
