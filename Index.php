<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login_page.php");
    exit();
}

require "db_connect.php";

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

$q = "SELECT title FROM books ORDER BY title";
$result = mysqli_query($mysqli, $sql);

$data = array();

foreach ($result as $row) {
    $data[] = array(
        'label' => $row['title'],
        'value' => $row['title']
    );
}

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
    <script src="library/autoComplete.js"></script>
</head>

<body>
    <?php require "header.php"; ?>
    <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner welcome-part">
            <div class="carousel-item welcome-image active" width="100%">
                <img src="asset/background_login.jpg" class="img-fluid d-block" alt="...">
            </div>
            <div class="carousel-text text-white d-flex justify-content-center">
                <h1>WELCOME,
                    <?php echo ucfirst($username); ?>
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid p-0">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner quote-part">
                <div class="carousel-item quote-image active" data-bs-interval="5000">
                    <img src="asset/quote1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item quote-image" style="background-color: #24324f;" data-bs-interval="5000">
                    <img src="asset/quote2.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <p style="text-align: center; font-size: 40px; color: darkblue;" class="uts">OUR COLLECTION</p>
        <p style="text-align: center; font-size: 40px; color: darkblue;" class="uts">----★----</p>
        <span class="d-flex justify-content-center mb-3">
            <form class="d-flex me-2 w-50" role="search">
                <div class="input-group">
                    <input class="form-control" type="text" id="searchBook" placeholder="Search Book" autocomplete="off"
                        aria-describedby="button-addon2" data-filter="data.json">
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg></button>
                </div>
            </form>
        </span>
        <div class="row">
            <!-- <div class="col-lg-12 col-md-3 col-sm-6"> -->
            <div class="col-12 hstack">
                <?php foreach ($books as $book): ?>
                    <?php if ($book['book_status'] !== 'borrowed'): ?>
                        <!-- <div class="col-lg-4 col-md-3 col-sm-6"> -->
                        <div class="col-4 me-2">
                            <div class="card">
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
                                                    <h3 style="text-align: center; font-size: 20px; color: darkblue;"
                                                        class="uts">
                                                        <?php echo $book['title']; ?>
                                                    </h3>
                                                    <p style="text-align: center; font-size: 20px; color: darkblue;"
                                                        class="uts">
                                                        ----★----</p>
                                                    <img src="img/<?php echo $book['gambar']; ?>" class="card-img-top"
                                                        alt="...">
                                                    <h4 style="text-align:center">SYNOPSIS</h4>
                                                    <p style="text-align: center; font-size: 20px; color: darkblue;"
                                                        class="uts">
                                                        <?php echo $book['sinopsis']; ?>
                                                    </p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" style="color: blue; align-items: center;"
                                                        class="btn btn-primary" data-bs-dismiss="modal">Close Window</button>
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="redirectToBorrowForm(<?php echo $book['id']; ?>)">
                                                        Borrow Book
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <script>
        function redirectToBorrowForm(bookId) {
            // Redirect to borrow_book_form.php with the book ID as a parameter
            window.location.href = "borrow_book_form.php?bookId=" + bookId;
        }

        var auto_complete = new Autocomplete(document.getElementById('searchBook'), {
            data: <?php echo json_encode($data); ?>,
            maximumItems: 10,
            highlightTyped: true,
            highlightClass: 'fw-bold text-primary'
        }); 
    </script>

</body>

</html>