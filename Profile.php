<!DOCTYPE html>
<html lang="en">
<?php require "Login.php" ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <style>
        body,
        html {
            background-color: #F4BF96;
        }
    </style>
</head>
<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'user') {
    header("Location: login_page.php");
    exit();
}
?>

<body>
    <div class="container-fluid mx-auto rounded-3 p-3" style="width: 70%; margin-top: 5%; background-color: #F5EEDC;">
        <form method="post" action="Index.php" enctype='multipart/form-data'>
            <div class="mb-3 d-flex justify-content-center">
                <img class="rounded-circle" src="../Project_Tekweb2/img/<?php
                echo $_SESSION['profile_pic'] ?>" alt="Profile" width="100" height="100" class="align-text-center">
            </div>
            <div class="d-flex justify-content-center">
                <label for="username" class="form-label">Username</label>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" value="<?php echo $_SESSION['username'] ?>" id="username"
                    name="username" placeholder="Enter your username">
            </div>
            <div class="d-flex justify-content-center">
                <label for="email" class="form-label">Email Address</label>
            </div>
            <div class="mb-3">
                <input type="emailUser" class="form-control" value="<?php echo $_SESSION['email'] ?>" name="emailUser"
                    id="emailUser" aria-describedby="emailHelp" placeholder="Enter your email">
            </div>
            <div class="d-flex justify-content-center">
                <label for="profilePic" class="form-label">Profile Picture</label>
            </div>
            <div class="mb-3">
                <input type="file" class="form-control" id="profilePic" name="profilePic" aria-describedby="emailHelp"
                    accept=".jpg,.jpeg,.png">
                <div class="ms-1 limit-type" style="font-size: 12px;">
                    require .JPG, .JPEG, .PNG
                </div>
            </div>
            <div class="p-0 mb-1 d-flex justify-content-center form-check">
                <button type="submit" class="btn btn-primary">Save Change</button>
            </div>
        </form>
    </div>
    </div>
</body>

</html>