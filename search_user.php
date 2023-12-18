<?php
session_start();
require "db_connect.php";

// Get the search query from the form
$search_query = isset($_POST['input']) ? $_POST['input'] : '';
$start_from = $_POST['start'];
$recordsPerPage = $_POST['record'];

if ($_SESSION['admin_type'] == 'member') {
    $countQuery = "SELECT COUNT(*) as total FROM accounts WHERE username LIKE '%$search_query%' AND user_type = 'user'";
    $countResult = $mysqli->query($countQuery);
    $totalRows = $countResult->fetch_assoc()['total'];
} else {
    $countQuery = "SELECT COUNT(*) as total FROM accounts WHERE username LIKE '%$search_query%'";
    $countResult = $mysqli->query($countQuery);
    $totalRows = $countResult->fetch_assoc()['total'];
}

if ($_SESSION['admin_type'] == 'member') {
    $query = "SELECT * FROM accounts WHERE username LIKE '%$search_query%' AND user_type = 'user' LIMIT $start_from, $recordsPerPage";
} else {
    $query = "SELECT * FROM accounts WHERE username LIKE '%$search_query%' LIMIT $start_from, $recordsPerPage";
}

$result = $mysqli->query($query);
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID User</th>
            <th>Profile</th>
            <th>Username</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Admin Type</th>
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
                        <?php echo $row['Id']; ?>
                    </td>
                    <td>
                        <?php
                        $gambarPath = 'img/' . $row['profile_pic'];
                        $gambarName = $row['profile_pic'];
                        echo "<img style='width: 100px; height: 100px; border-radius: 50%; object-fit: cover;' id='profile_user' src='img/$gambarName' alt='image.png'>";
                        ?>
                    </td>
                    <td>
                        <?php echo $row['username']; ?>
                    </td>
                    <td>
                        <?php echo $row['email']; ?>
                    </td>
                    <td>
                        <?php echo $row['user_type']; ?>
                    </td>
                    <td>
                        <?php echo $row['admin_type'] == "" ? "(Akun ini hanya user biasa)" : $row['admin_type']; ?>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="edit_member.php?id=<?php echo $row['Id']; ?>">Edit</a>
                        <a href="delete_member.php?id=<?php echo $row['Id']; ?>" onclick="return confirm('Are you sure you want to delete this account?')" class="delete_user btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='7'>No Member Found.</td></tr>";
        }
        ?>
    </tbody>
</table>