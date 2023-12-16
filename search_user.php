<?php

require "db_connect.php";

// Number of records to display per page
$recordsPerPage = 10;

// Get the current page from the URL parameter
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($current_page - 1) * $recordsPerPage;

// Get the search query from the form
$search_query = isset($_POST['search_query']) ? $_POST['search_query'] : '';

// Query to count total number of rows
$countQuery = "SELECT COUNT(*) as total FROM accounts WHERE username LIKE '%$search_query%' AND user_type = 'user'";
$countResult = $mysqli->query($countQuery);
$totalRows = $countResult->fetch_assoc()['total'];

$query = "SELECT * FROM accounts WHERE username LIKE '%$search_query%' AND user_type = 'user' LIMIT $start_from, $recordsPerPage";
$result = $mysqli->query($query);

if (mysqli_num_rows($result) > 0) {
    foreach ($result as $row) {
        ?>
        <p>
            <?php if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                $_SESSION['msg'] = null;
            } ?>
        </p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Profile</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Aksi</th>
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
                                <?php echo $row['profile_pic']; ?>
                            </td>
                            <td>
                                <?php echo $row['username']; ?>
                            </td>
                            <td>
                                <?php echo $row['email']; ?>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="">Ubah</a>
                                <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this book?')">Hapus</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada Member.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    <?php }
}
?>