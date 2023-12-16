<?php
require "db_connect.php";

// Retrieve the book ID from the URL parameter
$bookId = isset($_GET['bookId']) ? $_GET['bookId'] : null;

// Fetch book details based on the book ID
$sql = "SELECT * FROM books WHERE id = $bookId";
$result = mysqli_query($mysqli, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login_page.php");
    exit();
}

require "db_connect.php";

$username = $_SESSION['username'];


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
        .default {
            color: #c19776;
        }

        .focus {
            color: #f4bf96 !important;
        }
    </style>
</head>

<body style ="background-color : #4cb6b6;">
    <?php
    require "header.php";
    // Check if the query was successful
    if ($result && mysqli_num_rows($result) == 1) {
        $book = mysqli_fetch_assoc($result);

        // Calculate the maximum date (20 days from now)
        $maxAllowedDate = date("Y-m-d", strtotime("+7 days"));
        ?>
        <div class="container d-flex justify-content-center">
            <div class="card my-3" style="width: 75%; padding: 50px 0 0 0; background-color: #99d5d5;">
                <h1 class="align-self-center mt-2 card-title">
                    <?php echo $book['title'] ?>
                </h1>
                <img class="d-flex align-self-center mt-3" src="img/<?php echo $book['gambar'] ?>"
                    style="max-width: 50%; max height: 50%;" alt="<?php echo $book['title'] ?>">
                <div class="card-body pb-2 d-flex vstack text-center">
                    <span class="hstack d-flex justify-content-evenly">
                        <a class="fs-4 fw-bold text-decoration-none default" id="pengarang" role="button">Author</a>
                        <a class="fs-4 fw-bold text-decoration-none default focus" id="sinopsis" role="button">Synopsis</a>
                        <a class="fs-4 fw-bold text-decoration-none default" id="genre" role="button">Genre</a>
                        <a class="fs-4 fw-bold text-decoration-none default" id="tahun" role="button">Published Date</a>
                    </span>
                    <span class="mt-4">
                        <h4 id="author" style="display: none;" class="card-text">
                            <?php echo $book['pengarang'] ?>
                        </h4>
                        <h4 id="rangkuman" style="display: block;" class="card-text">
                            <?php echo $book['sinopsis'] ?>
                        </h4>
                        <h4 id="type" style="display: none;" class="card-text">
                            <?php echo $book['genre'] ?>
                        </h4>
                        <h4 id="year" style="display: none;" class="card-text">
                            <?php echo $book['tahun_terbit'] ?>
                        </h4>
                    </span>
                    <form class="mt-5" action='borrowBook.php' method='post'>
                        <input type='hidden' name='book_id' value='<?php echo $book['id']; ?>'>
                        <div class='mb-3 d-flex justify-content-center vstack'>
                            <label for='returnDate' class='form-label'>Return Date</label>
                            <input type='date' class='form-control d-flex align-self-center w-50' id='returnDate'
                                name='return_date' required max='<?php echo $maxAllowedDate ?>'>
                        </div>
                        <button type='submit' style="background-color: #5a4637; border-color: #5a4637;"
                            class='btn mt-3 btn-primary' name='borrow'>Borrow</button>
                    </form>
                    <a href="Index.php">Go back to home page</a>
                </div>
            </div>
        </div>
        <script>
            $("#pengarang").click(function () {
                $("#pengarang").addClass("focus");
                $("#sinopsis").removeClass("focus");
                $("#genre").removeClass("focus");
                $("#tahun").removeClass("focus");
                $('#author').css("display", "block");
                $('#rangkuman').css("display", "none");
                $('#type').css("display", "none");
                $('#year').css("display", "none");
            })

            $("#sinopsis").click(function () {
                $("#sinopsis").addClass("focus");
                $("#pengarang").removeClass("focus");
                $("#genre").removeClass("focus");
                $("#tahun").removeClass("focus");
                $('#author').css("display", "none");
                $('#rangkuman').css("display", "block");
                $('#type').css("display", "none");
                $('#year').css("display", "none");
            })

            $("#genre").click(function () {
                $("#genre").addClass("focus");
                $("#pengarang").removeClass("focus");
                $("#sinopsis").removeClass("focus");
                $("#tahun").removeClass("focus");
                $('#author').css("display", "none");
                $('#rangkuman').css("display", "none");
                $('#type').css("display", "block");
                $('#year').css("display", "none");
            })

            $("#tahun").click(function () {
                $("#tahun").addClass("focus");
                $("#pengarang").removeClass("focus");
                $("#sinopsis").removeClass("focus");
                $("#genre").removeClass("focus");
                $('#author').css("display", "none");
                $('#rangkuman').css("display", "none");
                $('#type').css("display", "none");
                $('#year').css("display", "block");
            })
            mysqli_close($mysqli);
        </script>

        <?php
        // You can also add a form or button for the user to proceed with borrowing
    } else {
        // Handle the case when the book ID is not valid or the book doesn't exist
        echo "Book not found.";
    }

    // Close the database connection
    
    ?>
</body>

</html>
