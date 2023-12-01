<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login_page.php");
    exit();
}

$username = $_SESSION['username'];
require "header.php";

require "db_connect.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT * FROM books"; // Adjust this query based on your actual table name

$result = $mysqli->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome, Admin <?php echo $username; ?>!</title>

    <!-- Add the modal styles -->
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
            padding-top: 60px;
        }

        .modal-dialog {
            max-width: 800px;
            margin: auto;
        }

        .modal-content {
            width: 100%;
        }

        .modal-body img {
            width: 100%;
            height: auto;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 d-flex flex-row justify-content-between">
                <h1>Daftar Buku</h1>
                <span class="d-flex align-items-center"><a class="btn btn-primary" href="./add_book.php">Tambah Buku</a></span>
            </div>
            <div class="col-12">
                <p><?php if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        $_SESSION['msg'] = null;
                    } ?></p>
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
                        if ($result->num_rows > 0) {
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
                                    <td><?php echo $row['book_status'];?> </td>
                                    <td>
                                        <a class="btn btn-primary" href="edit_book.php?id=<?php echo $row['id']; ?>">Ubah</a>
                                        <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">Hapus</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='7'>Tidak ada buku.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal container for displaying enlarged image -->
    <div class="modal" id="imageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="enlargedImg" src="" alt="Enlarged Image">
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript function to handle image click and display enlarged image -->
    <script>
        function displayEnlargedImg(imgPath) {
            var modal = document.getElementById('imageModal');
            var img = document.getElementById('enlargedImg');

            // Set the image source to the clicked image path
            img.src = imgPath;

            // Show the modal
            modal.style.display = 'block';
        }

        // Close the modal when clicking outside the image
        window.onclick = function(event) {
            var modal = document.getElementById('imageModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    </script>
</body>
</html>

<?php
// Close the database connection
$mysqli->close();
?>
