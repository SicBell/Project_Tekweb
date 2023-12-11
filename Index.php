<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login_page.php");
    exit();
}

require "db_connect.php";

$img_name;
$error;
$tmpName;
if (isset($_POST['username']) || isset($_POST['email']) || isset($_POST['emailUser']) || isset($_FILES['profilePic'])) {
    $_SESSION['profilePic'] = $_FILES['profilePic']['name'];
    $error = $_FILES['profilePic']['error'];
    $_SESSION['username'] = $_POST['username'];
    $tmpName = $_FILES['profilePic']['tmp_name'];
    $imgName = $_FILES['profilePic']['name'];
} else {
    $error = "";
    $img_name = "";
}

$username = $_SESSION['username'];

if (!($error === 0) && isset($_POST['username'])) {
    echo "unknown error occured!";
    exit;
} else {
    if (isset($_FILES['profilePic'])) {
        $img_ex = pathinfo($imgName, PATHINFO_EXTENSION);
        // echo $imgName;    
        $img_ex_to_lc = strtolower($img_ex);
        $allowed_exs = array('jpg', 'jpeg', 'png');
        if (in_array($img_ex_to_lc, $allowed_exs)) {
            $new_img_name = uniqid($username, true) . '.' . $img_ex_to_lc;
            $img_upload_path = '../Project_Tekweb/img/' . $new_img_name;
            move_uploaded_file($tmpName, $img_upload_path);

            $new_username = $_POST['username'];
            $new_mail = $_POST['emailUser'];
            $old_mail = $_SESSION['email'];
            // Insert into database
            $sql = "UPDATE accounts
            SET username = '$new_username', email = '$new_mail', profile_pic = '$new_img_name'
            WHERE email = '$old_mail'";
            $mysqli->query($sql);
        } else {
            echo "You cannot upload files of this type";
            exit;
        }
    }
}

$username = $_SESSION['username'];
// $password = $_SESSION['password'];

$sql = "SELECT * FROM accounts WHERE username ='$username'";
$result = mysqli_query($mysqli, $sql);
$row;
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
}
$username = $row['username'];
$password = $row['password'];
$_SESSION['email'] = $row['email'];
$_SESSION['profile_pic'] = $row['profile_pic'];
$_SESSION['username'] = $username;

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

<!-- index.html -->

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
                    <?php echo ucfirst($username); ?>
                </h1>
            </div>
        </div>
    </div>
    <div class="container">
        <p style="text-align: center; font-size: 40px; color: darkblue;" class="uts">OUR COLLECTION</p>
        <p style="text-align: center; font-size: 40px; color: darkblue;" class="uts">----★----</p>
        <div class="row">
            <?php foreach ($books as $book): ?>
                <?php if ($book['book_status'] !== 'borrowed'): ?>
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
                                                ----★----</p>
                                            <img src="img/<?php echo $book['gambar']; ?>" class="card-img-top" alt="...">
                                            <h4 style="text-align:center">SYNOPSIS</h4>
                                            <p style="text-align: center; font-size: 20px; color: darkblue;" class="uts">
                                                <?php echo $book['sinopsis']; ?>
                                            </p>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" style="color: blue; align-items: center;"
                                                class="btn btn-primary" data-bs-dismiss="modal">Close Window</button>
                                            <button type="button" style="color: blue; align-items: center;"
                                                class="btn btn-primary" onclick="addToCart(<?php echo $book['id']; ?>, '<?php echo $book['title']; ?>')">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<!-- Add a new modal for selecting return date -->
<div class="modal fade" id="returnDateModal" tabindex="-1" role="dialog" aria-labelledby="returnDateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnDateModalLabel">Select Return Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <label for="returnDate">Return Date:</label>
            <input type="date" id="returnDate" name="returnDate" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addToCartWithDate()">Add to Cart</button>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


<!-- JavaScript -->
<script>
    function addToCart(bookId, bookTitle) {
        console.log('Current Date:', new Date().toISOString().split('T')[0]);

        // Calculate the maximum date (current date + 7 days)
        var maxDate = new Date();
        maxDate.setDate(maxDate.getDate() + 7);

        // Format the maximum date to 'YYYY-MM-DD'
        var formattedMaxDate = maxDate.toISOString().split('T')[0];

        console.log('Maximum Date:', formattedMaxDate);

        // Set the maximum date dynamically
        document.getElementById('returnDate').setAttribute('max', formattedMaxDate);

        $('#returnDateModal').modal('show');

        window.selectedBookId = bookId;
        window.selectedBookTitle = bookTitle;
    }

    function addToCartWithDate() {
        // Retrieve the selected date from the input field
        var returnDate = document.getElementById('returnDate').value;

        // Make an AJAX request to your server with bookId, bookTitle, and returnDate
        $.ajax({
            type: "POST",
            url: "borrowBook.php",
            data: {
                id: window.selectedBookId,
                title: window.selectedBookTitle,
                returnDate: returnDate
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    alert(response.success);
                    // Optionally, you can close the modal after a successful request
                    $('#returnDateModal').modal('hide');
                } else if (response.error) {
                    alert(response.error);
                } else {
                    alert("Unexpected response from the server");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                alert("Error adding book to cart");
            }
        });
    }
</script>



</body>

</html>