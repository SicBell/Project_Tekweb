<!DOCTYPE html>
<html lang="en">

<?php require "Login.php" ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/header.css">
    <title>Header</title>
    <style>
        .nav-link:hover {
            background-color: cornsilk;
            transition: 0.5s;
        }

        .sign-out:hover {
            color: cornsilk;
            transition: 0.2s;
        }

        .nav-link {
            height: 100%;
        }

        a {
            color: #142236;
        }

        .sign-out {
            text-decoration: underline;
        }

        .container-fluid {
            z-index: 999;
        }
    </style>
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary py-0">
        <div class="container-fluid" style="background-color: #F4BF96;">
            <a class="navbar-brand me-1" href="#">
                <img src="asset/navbar-icon.png" alt="Logo" width="40" height="40" class="align-text-center">
                <a class="text-decoration-none ps-0" href="#">
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
                    <li class="nav-item">
                        <a class="nav-link active text rounded-1" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light rounded-1" href="borrowed_book.php">Log</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle rounded-1" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
                <?php if ($_SESSION['user_type'] == 'admin' && $_SESSION['page_name'] == 'index.php') { ?>
                    <a href="Admin_page.php" class="me-2">Go to Admin Page</a>
                <?php } ?>
                <?php if ($_SESSION['user_type'] == 'admin' && $_SESSION['page_name'] == 'admin_page.php') { ?>
                    <a href="Index.php" class="me-2">Go to Index Page</a>
                <?php } ?>
                <br><br>
                <a href="Profile.php"><img class="rounded-circle"
                        src="../Project_Tekweb/img/<?php echo $_SESSION['profile_pic'] ?>" alt="Logo" width="40"
                        height="40" class="align-text-center"></a>
                <li class="nav-item d-flex align-items-center">
                    <a class="active text rounded-1 sign-out p-1" aria-current="page" href="logout.php">SignOut</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light rounded-1" href="borrowed_book.php">Log</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light rounded-1" href="history_borrow.php">History</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle rounded-1" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
            </ul>
            <?php if ($_SESSION['user_type'] == 'admin' && $_SESSION['page_name'] == 'index.php') { ?>
                <a href="Admin_page.php" class="me-2">Go to Admin Page</a>
            <?php } ?>
            <?php if ($_SESSION['user_type'] == 'admin' && $_SESSION['page_name'] == 'admin_page.php') { ?>
                <a href="Index.php" class="me-2">Go to Index Page</a>
            <?php } ?>
            <a href="Profile.php"><img class="rounded-circle"
                    src="../Project_Tekweb/img/<?php echo $_SESSION['profile_pic'] ?>" alt="Logo" width="40" height="40"
                    class="align-text-center"></a>
            <li class="nav-item d-flex align-items-center">
                <a class="active text rounded-1 sign-out ps-2 p-1" aria-current="page" href="logout.php">SignOut</a>
            </li>

        </div>
    </nav>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script> -->
</body>

</html>