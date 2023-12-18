<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login_page.php");
    exit;
}

require "db_connect.php";

if (isset($_POST['username']) || isset($_POST['email']) || isset($_POST['emailUser']) || isset($_FILES['profilePic'])) {
    $error = $_FILES['profilePic']['error'];
    $_SESSION['username'] = $_POST['username'];
    $tmpName = $_FILES['profilePic']['tmp_name'];
    $imgName = $_FILES['profilePic']['name'];
} else {
    $error = "";
    $imgName = "";
}

$username = $_SESSION['username'];

if (!($error === 0) && isset($_POST['username'])) {
    $new_username = $_POST['username'];
    $new_mail = $_POST['emailUser'];
    $old_mail = $_SESSION['email'];
    // Insert into database
    $sql = "UPDATE accounts
            SET username = '$new_username', email = '$new_mail'
            WHERE email = '$old_mail'";
    $mysqli->query($sql);
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
$_SESSION['page_name'] = 'index.php';

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
$result = mysqli_query($mysqli, $q);

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
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="library/autoComplete.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body style="background-color: #fac9a2">
    <?php require "header.php"; ?>
    <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner welcome-part align-self-center">
            <div class="carousel-item welcome-image active" width="100%">
                <img src="asset/background_login.jpg" class="img-fluid d-block" alt="...">
            </div>
            <div class="carousel-item welcome-image active" width="100%">
                <img src="asset/background_login.jpg" class="img-fluid d-block" alt="...">
            </div>
            <div class="carousel-item welcome-image active" width="100%">
                <img src="asset/background_login.jpg" class="img-fluid d-block" alt="...">
            </div>
            <div class="carousel-text mt-5 text-white d-flex justify-content-evenly vstack align-items-center">
                <h1 style="font-size: 3rem;" /h1>WELCOME,
                    <?php echo ucfirst($username); ?>
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- <div class="text" style="z-index: 15;"> -->
        <p style="text-align: center; font-size: 40px; color: darkblue;" class="uts mt-5">OUR COLLECTION</p>
        <p style="text-align: center; font-size: 40px; color: darkblue;" class="uts">----★----</p>
        <!-- </div> -->
        <span class="d-flex w-50 mx-auto justify-content-center mb-3">
            <div class="input-group">
                <input class="form-control" type="text" id="searchBook" placeholder="Search Book" autocomplete="off">
                <button class="btn btn-outline-primary" id="button-search"><svg xmlns="http://www.w3.org/2000/svg"
                        width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg></button>
            </div>
        </span>
        <div class="filter-button mb-5 d-flex justify-content-center w-50 mx-auto">
            <ul class="list-group list-group-horizontal" style="list-style-type: none;">
                <li><button type="button" class="btn btn-filter All me-2" aria-pressed="false">All</button>
                </li>
                <li><button type="button" class="btn btn-filter Fantasy me-2" aria-pressed="false">Fantasy</button>
                </li>
                <li><button type="button" class="btn btn-filter Science me-2" aria-pressed="false">Science
                        Fiction</button></li>
                <li><button type="button" class="btn btn-filter Action me-2" aria-pressed="false">Action &
                        Adventure</button></li>
                <li><button type="button" class="btn btn-filter Mystery me-2" aria-pressed="false">Mystery</button>
                </li>
                <li><button type="button" class="btn btn-filter Horror me-2" aria-pressed="false">Horror</button></li>
                <li><button type="button" class="btn btn-filter Thriller me-2" aria-pressed="false">Thriller &
                        Suspense</button></li>
                <li><button type="button" class="btn btn-filter Romance me-2" aria-pressed="false">Romance</button>
                </li>
                <li><button type="button" class="btn btn-filter Biography me-2" aria-pressed="false">Biography</button>
                </li>
                <li><button type="button" class="btn btn-filter History me-2" aria-pressed="false">History</button>
                </li>
            </ul>
        </div>
        <div class='d-flex justify-content-center'>
            <?php
            if (isset($_SESSION['success_message'])) {
                echo "<div class='d-flex justify-content-center w-50 alert alert-success' role='alert'>";
                echo $_SESSION['success_message'];
                echo "</div>";

                // Clear the session variable to avoid displaying the message again on page refresh
                unset($_SESSION['success_message']);
            }
            ?>
        </div>
        <div class="row book-result mb-3 hstack d-flex justify-content-center">
            <!-- <div class="col-lg-12 col-md-3 col-sm-6"> -->
            <div class="col-12">

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

        var inputButton;
        // var F = $(".Fantasy").attr("aria-pressed");
        // var S = $(".Science").attr("aria-pressed");
        // var H = $(".History").attr("aria-pressed");
        // var B = $(".Biography").attr("aria-pressed");
        // var R = $(".Romance").attr("aria-pressed");
        // var T = $(".Thriller").attr("aria-pressed");
        // var Ho = $(".Horror").attr("aria-pressed");
        // var A = $(".Action").attr("aria-pressed");
        // var M = $(".Mystery").attr("aria-pressed");

        $(".All").click(function () {
            // if (F == "false") {
            inputButton = "available"
            $.ajax({
                url: "showBooks.php",
                method: "POST",
                data: { inputButton: inputButton },

                success: function (data) {
                    $('.book-result').html(data);
                    $('.book-result').css("display", "block");
                }
            });
            // }
        })

        $(".Fantasy").click(function () {
            // if (F == "false") {
            inputButton = "Fantasy"
            $.ajax({
                url: "showBooks.php",
                method: "POST",
                data: { inputButton: inputButton },

                success: function (data) {
                    $('.book-result').html(data);
                    $('.book-result').css("display", "block");
                }
            });
            // }
        })

        $(".Science").click(function () {
            // if (S == "false") {
            inputButton = "Science";
            $.ajax({
                url: "showBooks.php",
                method: "POST",
                data: { inputButton: inputButton },

                success: function (data) {
                    $('.book-result').html(data);
                    $('.book-result').css("display", "block");
                }
            });
            // }
        })

        $(".Action").click(function () {
            // if (A == "false") {
            inputButton = "Action";
            $.ajax({
                url: "showBooks.php",
                method: "POST",
                data: { inputButton: inputButton },

                success: function (data) {
                    $('.book-result').html(data);
                    $('.book-result').css("display", "block");
                }
            });
            // }
        })

        $(".Mystery").click(function () {
            // // if (M == "false") {
            //     M = "true";
            //     $(".Mystery").attr("aria-pressed", M);
            inputButton = "Mystery";
            $.ajax({
                url: "showBooks.php",
                method: "POST",
                data: { inputButton: inputButton },

                success: function (data) {
                    $('.book-result').html(data);
                    $('.book-result').css("display", "block");
                }
            });
            // }
        })

        $(".Horror").click(function () {
            // // if (Ho == "false") {
            //     Ho = "true";
            //     $(".Horror").attr("aria-pressed", Ho);
            inputButton = "Horror";
            $.ajax({
                url: "showBooks.php",
                method: "POST",
                data: { inputButton: inputButton },

                success: function (data) {
                    $('.book-result').html(data);
                    $('.book-result').css("display", "block");
                }
            });
            // }
        })

        $(".Thriller").click(function () {
            // // if (T == "false") {
            //     T = "true";
            //     $(".Thriller").attr("aria-pressed", T);
            inputButton = "Thriller";
            $.ajax({
                url: "showBooks.php",
                method: "POST",
                data: { inputButton: inputButton },

                success: function (data) {
                    $('.book-result').html(data);
                    $('.book-result').css("display", "block");
                }
            });
            // }
        })

        $(".Romance").click(function () {
            // // if (R == "false") {
            //     R = "true";
            //     $(".Romance").attr("aria-pressed", R);
            inputButton = "Romance";
            $.ajax({
                url: "showBooks.php",
                method: "POST",
                data: { inputButton: inputButton },

                success: function (data) {
                    $('.book-result').html(data);
                    $('.book-result').css("display", "block");
                }
            });
            // }
        })

        $(".Biography").click(function () {
            // // if (B == "false") {
            //     $(".Biography").attr("aria-pressed", B);
            inputButton = "Biography";
            $.ajax({
                url: "showBooks.php",
                method: "POST",
                data: { inputButton: inputButton },

                success: function (data) {
                    $('.book-result').html(data);
                    $('.book-result').css("display", "block");
                }
            });
            // }
        })

        $(".History").click(function () {
            // if (H == "false") {
            inputButton = "History";
            $.ajax({
                url: "showBooks.php",
                method: "POST",
                data: { inputButton: inputButton },

                success: function (data) {
                    $('.book-result').html(data);
                    $('.book-result').css("display", "block");
                }
            });
            // }
        })


        $(document).ready(function () {
            var input = "available";
            <?php if (isset($_SESSION['username'])) { ?>
                $.ajax({
                    url: "showBooks.php",
                    method: "POST",
                    data: { input: input },

                    success: function (data) {
                        $('.book-result').html(data);
                        $('.book-result').css("display", "block");
                    }
                });
            <?php } ?>
            $("#searchBook").keyup(function () {
                input = $(this).val();
                if (input != "") {
                    $.ajax({
                        url: "showBooks.php",
                        method: "POST",
                        data: { input: input },

                        success: function (data) {
                            $('.book-result').html(data);
                            $('.book-result').css("display", "block");
                        }
                    });
                } else {
                    input = "available";
                    $.ajax({
                        url: "showBooks.php",
                        method: "POST",
                        data: { input: input },

                        success: function (data) {
                            $('.book-result').html(data);
                            $('.book-result').css("display", "block");
                        }
                    });
                }
            });
            $("#button_search").click(function () {
                input = $(this).val();
                if (input != "") {
                    $.ajax({
                        url: "showBooks.php",
                        method: "POST",
                        data: { input: input },

                        success: function (data) {
                            $("#searchBook").val(input);
                            $('.book-result').html(data);
                            $('.book-result').css("display", "block");
                        }
                    });
                } else {
                    $('.book-result').css("display", "none");
                }
            });
        });
    </script>

    <footer class="footer" style="background-color: #fab987">
        <div class="container bottom_border">
            <div class="row">
                <div class=" col-sm-4 text-center col-md col-12 col">
                    <h5 class="headin5_amrc col_white_amrc pt2">Find us</h5>
                    <!--headin5_amrc-->
                    <p class="mb10">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    <p><i class="fa fa-location-arrow"></i> Jl. Siwalankerto No.121-131, Siwalankerto, Kec. Wonocolo,
                        Surabaya, Jawa Timur 60236
                    </p>
                    <p><i class="fa fa-phone"></i> (031) 8439040 </p>
                    <p><i class="fa fa fa-envelope"></i> info@petra.ac.id </p>


                </div>





                <div class=" col-sm-4 col-md d-flex justify-content-center vstack col-12 col">
                    <h5 class="headin5_amrc d-flex align-self-center col_white_amrc pt2">Follow us</h5>
                    <!--headin5_amrc ends here-->

                    <ul class="d-flex justify-content-center mt-5 footer_ul2_amrc">
                        <li class="d-flex mb-3 justify-content-center"><a href="https://wa.me/0817333434"
                                target="_blank"> <img src="asset/whatsapp_icon.png" alt="Logo" width="45" height="45"
                                    class="align-text-center"></a></p>
                        </li>
                        <li class="d-flex mb-3 justify-content-center"><a
                                href="https://www.instagram.com/ui_library/?hl=en" target="_blank"> <img
                                    src="asset/instagram_icon.png" alt="Logo" width="45" height="45"
                                    class="align-text-center"></a></p>
                        </li>
                        <li class="d-flex justify-content-center"><a href="https://twitter.com/UI_library"
                                target="_blank"> <img src="asset/x_icon.png" alt="Logo" width="45" height="45"
                                    class="align-text-center"></a></p>
                        </li>
                    </ul>
                    <!--footer_ul2_amrc ends here-->
                </div>

                <div class=" col-sm-4 col-md text-center col-12 col text-end">
                    <h5 class="headin5_amrc col_white_amrc pt2">Library News</h5>
                    <!--headin5_amrc-->
                    <div class="col-12 mb-2">
                        <a href="https://www.independent.co.uk/news/world/americas/louisiana-banned-books-library-jeff-landry-b2324440.html"
                            class="mb10">The school librarian in the middle of Louisiana’s war on libraries</a>
                    </div>
                    <div class="col-12 mb-2">
                        <a
                            href="https://www.independent.co.uk/news/world/americas/meth-contamination-libraries-close-colorado-b2263932.html"><i
                                class="fa fa-location-arrow"></i> Meth contamination is forcing libraries to close in
                            Colorado
                        </a>
                    </div>
                    <div class="col-12">
                        <a
                            href="https://www.independent.co.uk/news/ap-money-libraries-republican-american-library-association-b2057656.html"><i
                                class="fa fa-phone"></i>Money spat resolved over LGBTQ books at Mississippi library</a>
                    </div>
                </div>
            </div>
        </div>

        <!--foote_bottom_ul_amrc ends here-->
        <p class="text-center">Copyright @2017 | Designed by <a href="#">YourLibrary Co.</a></p>
        <!--social_footer_ul ends here-->
        </div>

    </footer>
</body>


</html>