<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin' || $_SESSION['admin_type'] == 'member') {
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
$_SESSION['page_name'] = 'admin_page.php';

$username = $_SESSION['username'];
require "header.php";

require "db_connect.php";
// Number of records to display per page
$recordsPerPage = 10;

// Get the current page from the URL parameter
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($current_page - 1) * $recordsPerPage;

// Get the search query from the form
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Query to count total number of rows
$countQuery = "SELECT COUNT(*) as total FROM books WHERE title LIKE '%$search_query%'";
$countResult = $mysqli->query($countQuery);
$totalRows = $countResult->fetch_assoc()['total'];

// Perform a SQL query to get the books based on search and pagination
$query = "SELECT * FROM books WHERE title LIKE '%$search_query%' LIMIT $start_from, $recordsPerPage";
$result = $mysqli->query($query);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome, Admin
        <?php echo $username; ?>!
    </title>

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
            <form class="d-flex mt-5" role="search" action="search_book.php" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search by Title" aria-label="Search"
                    name="search_query">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <div class="col-12 d-flex flex-row justify-content-between">
                <h1>Book List</h1>
                <span class="d-flex align-items-center"><a class="btn btn-primary" href="./add_book.php">Add Book</a></span>
            </div>
            <div class="col-12">
                <p>
                    <?php if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        $_SESSION['msg'] = null;
                    } ?>
                </p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Publish Date</th>
                            <th>Genre</th>
                            <th>Synopsis</th>
                            <th>Picture</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row['id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['title']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['pengarang']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['tahun_terbit']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['genre']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['sinopsis']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $gambarPath = 'img/' . $row['gambar'];
                                        echo "<img src='$gambarPath' alt='Book Image' style='max-width: 100px; max-height: 100px;' onclick='displayEnlargedImg(\"$gambarPath\")'>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $row['book_status']; ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="edit_book.php?id=<?php echo $row['id']; ?>">Edit</a>
                                        <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="btn mt-2 btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
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
            <!-- Add pagination links at the bottom of the table -->
            <div class="col-12">
                <ul class="pagination">
                    <?php
                    $total_pages = ceil($totalRows / $recordsPerPage);

                    // Previous page link
                    if ($current_page > 1) {
                        echo "<li class='page-item'><a class='page-link' href='?page=" . ($current_page - 1) . "'>Previous</a></li>";
                    }

                    // Display page numbers
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<li class='page-item " . ($i == $current_page ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
                    }

                    // Next page link
                    if ($current_page < $total_pages) {
                        echo "<li class='page-item'><a class='page-link' href='?page=" . ($current_page + 1) . "'>Next</a></li>";
                    }
                    ?>
                </ul>
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
        window.onclick = function (event) {
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