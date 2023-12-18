<?php
require "db_connect.php";
$book = null;

// Function to get book details by ID
function getBookDetails($mysqli, $bookId)
{
    $stmt = $mysqli->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookDetails = null;
    if ($result->num_rows > 0) {
        $bookDetails = $result->fetch_assoc();
    }

    $stmt->close();

    return $bookDetails;
}

$err_msg = "";

// Check if the book id is provided in the URL
if (count($_GET) > 0 && isset($_GET['id'])) {
    $bookId = $_GET['id'];
    $book = getBookDetails($mysqli, $bookId);
}

// Check if the form is submitted and the book ID is set
if (count($_POST) > 0 && isset($book['id'])) {
    $title = $_POST['title'];
    $pengarang = $_POST['pengarang'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $genre = $_POST['genre'];
    $sinopsis = $_POST['sinopsis'];

    // Handle image upload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $upload_dir = "img/";
        $newImageName = $title . '.' . pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);

        move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $newImageName);

        $stmt = $mysqli->prepare("UPDATE books SET title=?, gambar=?, pengarang=?, tahun_terbit=?, genre=?, sinopsis=? WHERE id=?");
        $stmt->bind_param("ssssssi", $title, $newImageName, $pengarang, $tahun_terbit, $genre, $sinopsis, $book['id']);
    } else {
        $stmt = $mysqli->prepare("UPDATE books SET title=?, pengarang=?, tahun_terbit=?, genre=?, sinopsis=? WHERE id=?");
        $stmt->bind_param("sssssi", $title, $pengarang, $tahun_terbit, $genre, $sinopsis, $book['id']);
    }

    $res = $stmt->execute();

    if ($res) {
        $_SESSION['msg'] = "Berhasil update data.";
        header("Location: Admin_page.php");
        exit;
    } else {
        $err_msg = "Gagal mengupdate data: " . $stmt->error;
    }

    $stmt->close();
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
                <h1>Edit Book</h1>
                <span class="d-flex align-items-center"><a class="btn btn-secondary" href="./Admin_page.php">Kembali</a></span>
            </div>
            <div class="col-12">
                <p><?php echo $err_msg; ?></p>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Book Title</label>
                        <input type="text" class="form-control" name="title" value="<?php echo $book ? htmlspecialchars($book['title']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Picture</label>
                        <input type="file" class="form-control" name="gambar" accept=".jpg, .jpeg, .png">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Author</label>
                        <input type="text" class="form-control" name="pengarang"
                            value="<?php echo $book ? htmlspecialchars($book['pengarang']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Published Date</label>
                        <input type="date" class="form-control" name="tahun_terbit"
                            value="<?php echo $book ? $book['tahun_terbit'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Synopsis</label>
                        <textarea class="form-control" name="sinopsis" rows="3"><?php echo $book ? htmlspecialchars($book['sinopsis']) : ''; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Genre</label>
                        <input type="text" class="form-control" name="genre" value="<?php echo $book ? htmlspecialchars($book['genre']) : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
