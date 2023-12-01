<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login_page.php");
    exit();
}

require "db_connect.php";

$username = $_SESSION['username'];

// Fetch books from the database
$sql = "SELECT * FROM books";
$result = $mysqli->query($sql);

// Check if there are any books
if ($result->num_rows > 0) {
    $books = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $books = [];
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php require "header.php"; ?>
    <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" width="100%">
                <img src="asset/background_login.jpg" class="img-fluid d-block" alt="...">
            </div>
            <div class="carousel-item">
                <img src="asset/background_login.jpg" class="img-fluid d-block" alt="...">
            </div>
            <div class="carousel-item">
                <img src="asset/background_login.jpg" class="img-fluid d-block" alt="...">
            </div>
            <div class="carousel-text text-white d-flex justify-content-center">
                <h1>WELCOME,
                    <?php echo $username; ?>
                </h1>
            </div>
        </div>
    </div>
    <div class="container">
        <p style="text-align: center; font-size: 40px; color: darkblue;" class="uts">OUR COLLECTION</p>
        <p style="text-align: center; font-size: 40px; color: darkblue;" class="uts">----★-----</p>
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="card" style="width: 25rem;">
                        <img data-bs-target="#book<?php echo $book['id']; ?>" data-bs-toggle="modal"
                            src="img/<?php echo $book['gambar']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="modal fade" id="book<?php echo $book['id']; ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h3 style="text-align: center; font-size: 20px; color: darkblue;" class="uts">
                                                <?php echo $book['title']; ?>
                                            </h3>
                                            <p style="text-align: center; font-size: 20px; color: darkblue;" class="uts">
                                                ----★-----</p>
                                            <img src="img/<?php echo $book['gambar']; ?>" class="card-img-top" alt="...">
                                            <h4 style="text-align:center" >SYNOPSIS</h4>
                                            <p style="text-align: center; font-size: 20px; color: darkblue;" class="uts">
                                                <?php echo $book['sinopsis']; ?>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" style="color: blue; align-items: center;"
                                                class="btn btn-primary" data-bs-dismiss="modal">Close Window</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</body>

</html>