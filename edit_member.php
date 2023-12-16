<?php
session_start();
require "db_connect.php";
$user = null;

// Function to get book details by ID
function getUserDetails($mysqli, $userId)
{
    $stmt = $mysqli->prepare("SELECT * FROM accounts WHERE Id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $userDetails = null;
    if ($result->num_rows > 0) {
        $userDetails = $result->fetch_assoc();
    }

    $stmt->close();

    return $userDetails;
}

$err_msg = "";

// Check if the book id is provided in the URL
if (count($_GET) > 0 && isset($_GET['id'])) {
    $userId = $_GET['id'];
    $user = getUserDetails($mysqli, $userId);
}

// Check if the form is submitted and the book ID is set
if (count($_POST) > 0 && isset($user['Id'])) {
    if ($_POST['password'] !== $_POST['cpass']) {
        $err_msg = "Mohon ulangi input passwordnya";
    } else {
        $username = $_POST['username'];
        $profilePicture = $_POST['pp'];
        $password = $_POST['password'];
        $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : "";
        $admin_type = isset($_POST['admin_type']) ? $_POST['admin_type'] : "";

        $stmt;
        // Handle image upload
        if (isset($_FILES['pp']) && $_FILES['pp']['error'] === 0) {
            $upload_dir = "img/";
            $newImageName = $username . '.' . pathinfo($_FILES['pp']['name'], PATHINFO_EXTENSION);

            move_uploaded_file($_FILES['pp']['tmp_name'], $upload_dir . $newImageName);
            if ($user_type == "") {
                $stmt = $mysqli->prepare("UPDATE accounts SET username=?, profile_pic=?, password=? WHERE id=?");
                $stmt->bind_param("sssi", $username, $newImageName, $password, $user['Id']);
            } else {
                $stmt = $mysqli->prepare("UPDATE accounts SET username=?, profile_pic=?, password=?, user_type=?, admin_type=? WHERE id=?");
                $stmt->bind_param("sssssi", $username, $newImageName, $password, $user_type, $admin_type, $user['Id']);
            }
        } else {
            if ($user_type == "" || $admin_type == "") {
                $stmt = $mysqli->prepare("UPDATE accounts SET username=?, password=? WHERE id=?");
                $stmt->bind_param("ssi", $username, $password, $user['Id']);
            } else {
                $stmt = $mysqli->prepare("UPDATE accounts SET username=?, password=?, user_type=?, admin_type=? WHERE id=?");
                $stmt->bind_param("ssssi", $username, $password, $user_type, $admin_type, $user['Id']);
            }
        }

        $res = $stmt->execute();

        if ($res) {
            $_SESSION['msg'] = "Berhasil update data.";
            header("Location: Admin_Member.php");
            exit;
        } else {
            $err_msg = "Gagal mengupdate data: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 d-flex flex-row justify-content-between">
                <h1>Edit Member</h1>
                <span class="d-flex align-items-center"><a class="btn btn-secondary"
                        href="./Admin_member.php">Kembali</a></span>
            </div>
            <div class="col-12">
                <?php if ($err_msg != "") { ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo $err_msg;
                        $err_msg = "";
                        ?>
                    </div>
                <?php } ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label" for="uname">Edit Username</label>
                        <input type="text" class="form-control" id="uname" name="username"
                            value="<?php echo $user ? htmlspecialchars($user['username']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="PP">Edit Profile Picture</label>
                        <input type="file" class="form-control" id="PP" name="pp" accept=".jpg, .jpeg, .png">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Edit Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="cpass">
                    </div>
                    <?php if ($_SESSION['user_type'] == 'admin' && $_SESSION['admin_type'] == 'super') { ?>
                        <div class="mb-3">
                            <label class="form-label" for="u_type">Edit User Type</label>
                            <select id="u_type" name="user_type" class="form-select" aria-label="Default select example">
                                <option value="<?php echo $user ? htmlspecialchars($user['user_type']) : ''; ?>">Pilih User
                                    Type</option>
                                <option value="user">User/Member</option>
                                <option value="admin">Admin/Pengelola</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="u_type">Edit Admin Type</label>
                            <select id="u_type" name="admin_type" class="form-select" aria-label="Default select example">
                                <option value="<?php echo $user ? htmlspecialchars($user['admin_type']) : ''; ?>" selected>
                                    Pilih Admin Type</option>
                                <option value="super">Super Admin</option>
                                <option value="book">Book Admin</option>
                                <option value="member">Member/User Admin</option>
                            </select>
                        </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label class="form-label">Edit Email</label>
                        <input type="text" class="form-control" name="email"
                            value="<?php echo $user ? htmlspecialchars($user['email']) : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>