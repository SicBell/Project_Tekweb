<?php

// $token = $_POST["token"];

// $token_hash = hash("sha256", $token);

// $mysqli = require __DIR__ . "/db_connect.php";

// $sql = "SELECT * FROM accounts
//         WHERE reset_token_hash = ?";

// $stmt = $mysqli->prepare($sql);

// $stmt->bind_param("s", $token_hash);

// $stmt->execute();

// $result = $stmt->get_result();

// $user = $result->fetch_assoc();

// if ($user === null) {
//     die("token not found");
// }

// if (strtotime($user["reset_token_expires_at"]) <= time()) {
//     die("token has expired");
// }

// if ($_POST["password"] !== $_POST["password_confirmation"]) {
//     die("Passwords must match");
// }

// $password = $_POST['password'];
// $sql = "UPDATE accounts
//         SET password = ?,
//             reset_token_hash = NULL,
//             reset_token_expires_at = NULL
//         WHERE Id = ?";

// $stmt = $mysqli->prepare($sql);

// $stmt->bind_param("ss", $password, $user["Id"]);

// $stmt->execute();


?>
<!doctype html>
<html lang="en">
  <head>
  <style>
    body {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #EA906C;
    }

    .card {
      width: 500px; /* Set your desired width */
      height: 600px; /* Make it square */
    }
    #btn-login{
        background-color: #F8F0E5;
    }
    #btn-login:hover{
        background-color: #EADBC8;
    }
  </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body style=" background-color: #FFC5C5;">
  <div class="card">
  <div  class="card-header" style="background-color: #E0F4FF" >
    Notification!
  </div>
  <div class="card-body" style="background-color: #F4BF96;" >
    <h5 class="card-title">Password updated. You can now login.</h5>
    
    <a href="login_page.php"  id="btn-login" class="btn ">Login</a>
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
