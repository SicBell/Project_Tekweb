<!DOCTYPE html>
<html lang="en">

<?php require "Login.php" ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Header</title>
    <style>
        .nav-link:hover {
            background-color: cornsilk;
            color: brown;
            transition: 0.5s;
        }

        .sign-out:hover {
            color: cornsilk;
            transition: 0.2s;
        }

        .nav-link {
            height: 100%;
            color: white;
        }

        a {
            color: #142236;
        }

        .container-fluid {
            z-index: 999;
        }
    </style>
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary py-0">
        <div class="container-fluid" style="background-color: #c6936b;">
            <a class="navbar-brand me-1" href="#">
                <img src="asset/navbar-icon.png" alt="Logo" width="40" height="40" class="align-text-center">
                <a class="text-decoration-none ps-0" href="index.php">
                    <h4>YourLibrary</h4>
                </a>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if ($_SESSION['user_type'] == 'admin') { ?>
                        <li class="ms-2 nav-item">
                            <a class="nav-link rounded-1" href="borrowed_book.php">Log</a>
                        </li>
                    <?php } ?>
                    <?php if ($_SESSION['user_type'] == 'user') { ?>
                    <li class="nav-item ms-">
                        <a class="nav-link rounded-1" href="history_borrow.php">History</a>
                    </li>
                    <?php } ?>
                </ul>
                <?php if ($_SESSION['user_type'] == 'admin' && ($_SESSION['admin_type'] == 'member' || $_SESSION['admin_type'] == 'super') && $_SESSION['page_name'] == 'Index.php') { ?>
                    <a href="Admin_member.php" class="me-2 p-2 nav-link rounded-1 text-decoration-none">Go to Member Admin Page</a>
                <?php } ?>
                <?php if ($_SESSION['user_type'] == 'admin' && ($_SESSION['admin_type'] == 'book' || $_SESSION['admin_type'] == 'super') && $_SESSION['page_name'] == 'Index.php') { ?>
                    <a href="Admin_page.php" class="me-2 p-2 nav-link rounded-1 text-decoration-none">Go to Book Admin Page</a>
                <?php } ?>
                <?php if ($_SESSION['page_name'] != 'Index.php') { ?>
                    <a href="Index.php" class="me-2 nav-link p-2 rounded-1 text-decoration-none">Go to Home Page</a>
                <?php } ?>
                <br>
                <a href="Profile.php"><img class="object-fit-cover me-2 rounded-circle"
                        src="../Project_Tekweb/img/<?php echo $_SESSION['profile_pic'] ?>" alt="Logo" width="40"
                        height="40" class="align-text-center"></a>
                <li class="nav-item d-flex align-items-center">
                    <a class="btn btn-danger text rounded-1 ps-2 p-1" aria-current="page" href="logout.php">Signout</a>
                </li>

            </div>
    </nav>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script> -->
</body>

</html>