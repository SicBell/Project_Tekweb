<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin' || $_SESSION['admin_type'] == 'book') {
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
            $result = $mysqli->query($sql);
            if ($result) {
                $username = $new_username;
            }
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
$_SESSION['page_name'] = 'admin_member.php';


if ($_SESSION['admin_type'] == 'member') {
    $q = "SELECT username FROM accounts WHERE user_type = 'user' ORDER BY username";
    $result = mysqli_query($mysqli, $q);

    $data = array();

    foreach ($result as $row) {
        $data[] = array(
            'label' => $row['username'],
            'value' => $row['username']
        );
    }
} else {
    $q = "SELECT username FROM accounts ORDER BY username";
    $result = mysqli_query($mysqli, $q);

    $data = array();

    foreach ($result as $row) {
        $data[] = array(
            'label' => $row['username'],
            'value' => $row['username']
        );
    }
}


// $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// $countQuery = "SELECT COUNT(*) as total FROM accounts WHERE username LIKE '%$search_query%' AND user_type = 'user'";
// $countResult = $mysqli->query($countQuery);
// $totalRows = $countResult->fetch_assoc()['total'];
$totalRows;
if ($_SESSION['admin_type'] == 'member') {
    $countQuery = "SELECT COUNT(*) as total FROM accounts WHERE user_type = 'user'";
    $countResult = $mysqli->query($countQuery);
    $totalRows = $countResult->fetch_assoc()['total'];
} else {
    $countQuery = "SELECT COUNT(*) as total FROM accounts";
    $countResult = $mysqli->query($countQuery);
    $totalRows = $countResult->fetch_assoc()['total'];
}

$mysqli->close();
// Number of records to display per page
$recordsPerPage = 10;

// Get the current page from the URL parameter
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($current_page - 1) * $recordsPerPage;

require "header.php";

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
    <script src="library/autoComplete.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
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
    <p>.</p>
    <div class="container">
        <div class="row mt-5">
            <div class="input-group mb-3">
                <!-- <form class="d-flex" role="search" action="Admin_Member.php" method="GET"> -->
                <input class="text" type="text" placeholder="Search by Name" id="searchUser" autocomplete="off"
                    aria-label="Search" name="search_query">
                <button class="btn btn-outline-primary" id="button-search"><svg xmlns="http://www.w3.org/2000/svg"
                        width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg></button>
            </div>
            <?php if (isset($_SESSION['msg'])) { ?>
                <div class="alert alert-warning mb-3" role="alert">
                    <?php echo $_SESSION['msg'];
                    $_SESSION['msg'] = null;
                    ?>
                </div>
            <?php } ?>
            <!-- </form> -->
            <div class="col-12 acc-result">

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

</body>
<script>
    $(".delete_user").click(function () {
        return confirm('Are you sure you want to delete this user?');
    })

    var auto_complete = new Autocomplete(document.getElementById('searchUser'), {
        data: <?php echo json_encode($data); ?>,
        maximumItems: 10,
        highlightTyped: true,
        highlightClass: 'fw-bold text-primary'
    });

    // Close the modal when clicking outside the image
    window.onclick = function (event) {
        var modal = document.getElementById('imageModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

    $(document).ready(function () {
        var input = "user";
        <?php if (isset($_SESSION['username'])) { ?>
            $.ajax({
                url: "search_user.php",
                method: "POST",
                data: { input: input, start: <?php echo $start_from ?>, record: <?php echo $recordsPerPage ?> },

                success: function (data) {
                    $('.acc-result').html(data);
                    $('.acc-result').css("display", "block");
                }
            });
        <?php } ?>
        $("#searchUser").keyup(function () {
            input = $(this).val();
            if (input != "") {
                $.ajax({
                    url: "search_user.php",
                    method: "POST",
                    data: { input: input, start: <?php echo $start_from ?>, record: <?php echo $recordsPerPage ?> },

                    success: function (data) {
                        $('.acc-result').html(data);
                        $('.acc-result').css("display", "block");
                    }
                });
            } else {
                input = "user";
                $.ajax({
                    url: "search_user.php",
                    method: "POST",
                    data: { input: input, start: <?php echo $start_from ?>, record: <?php echo $recordsPerPage ?> },

                    success: function (data) {
                        $('.acc-result').html(data);
                        $('.acc-result').css("display", "block");
                    }
                });
            }
        });
        $("#button_search").click(function () {
            input = $("#searchUser").val();
            if (input != "") {
                $.ajax({
                    url: "search_user.php",
                    method: "POST",
                    data: { input: input, start: <?php echo $start_from ?>, record: <?php echo $recordsPerPage ?> },

                    success: function (data) {
                        $("#searchUser").val(input);
                        $('.acc-result').html(data);
                        $('.acc-result').css("display", "block");
                    }
                });
            } else {
                $('.acc-result').css("display", "none");
            }
        });
    });
</script>

</html>