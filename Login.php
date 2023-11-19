<?php
include("db_connect.php");
if (isset($_POST["Login"])) {
  $username = mysqli_real_escape_string($conn, $_POST['Login_username']);
  $password = mysqli_real_escape_string($conn, $_POST['Login_password']);

  $sql = "SELECT * FROM accounts WHERE username ='$username' AND password = '$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) {
      // Start a session
      session_start();
      $_SESSION['username'] = $username;
      header("Location: index.php");
      exit();
  } else {
    echo '<script>
                        window.location.href = "login_page.php";
                        alert("Login failed. Invalid username or password.")
                    </script>';
  }
}
mysqli_close($conn);
?>