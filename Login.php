<?php
include("db_connect.php");
if (isset($_POST["Login"])) {
  $username = mysqli_real_escape_string($conn, $_POST['Login_username']);
  $password = mysqli_real_escape_string($conn, $_POST['Login_password']);

  $sql = "SELECT * FROM accounts WHERE username ='$username' AND password = '$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    // Start a session
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['user_type'] = $row['user_type'];

    if ($row['user_type'] == 'admin') {
      header("Location: Admin_page.php");
      exit();
    } else {
      header("Location: Index.php");
      exit();
    }
  } else {
    echo '<script>
                        window.location.href = "login_page.php";
                        alert("Login failed. Invalid username or password.")
                    </script>';
  }
}
mysqli_close($conn);
?>