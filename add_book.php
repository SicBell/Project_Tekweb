<?php
require "db_connect.php";
session_start();

if (count($_POST) > 0) {
    $title = $_POST['title'];
    $pengarang = $_POST['pengarang'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $genre = $_POST['genre'];
    $sinopsis = $_POST['sinopsis'];

    $err_msg = "";

    if ($_FILES["gambar"]["error"] === 4) {
        echo "<script> alert('Image Does Not Exist'); </script>";
    } else {
        $filename = $_FILES["gambar"]["name"];
        $fileSize = $_FILES["gambar"]["size"];
        $tmpName = $_FILES["gambar"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $filename);
        $imageExtension = strtolower(end($imageExtension));
        
        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script> alert('Invalid Image Format');</script>";
        } else if ($fileSize > 1000000) {
            echo "<script> alert('Image Size Exceeds 1MB');</script>";
        } else {
            $newImageName = $title . '.' . $imageExtension;
            move_uploaded_file($tmpName, 'img/' . $newImageName);
        }
    }

    // Using prepared statement to prevent SQL injection
    $sql = "INSERT INTO books (`title`, `gambar`, `pengarang`, `tahun_terbit`, `genre`, `sinopsis`) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssss", $title, $newImageName, $pengarang, $tahun_terbit, $genre, $sinopsis);

    $res = $stmt->execute();

    if ($res) {
        $_SESSION['msg'] = "Berhasil menambah buku";
        header("Location: Admin_page.php");
        die();
    } else {
        echo "Tidak dapat menambah buku";
        die();
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 d-flex flex-row justify-content-between">
                <h1>Tambah Buku</h1>
                <span class="d-flex align-items-center"> <a class="btn btn-secondary" href="./Admin_page.php">Kembali</a></span>
            </div>
            <div class="col-12">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" name="title" value="">
                    </div>
                    <div class="mb-3">
                        <label for="formFileMultiple" class="form-label">Gambar</label>
                        <input class="form-control" name="gambar" accept=".jpg, .jpeg, .png" type="file" id="formFileMultiple" multiple>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Pengarang</label>
                        <input type="text" class="form-control" name="pengarang" value="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Tahun Terbit</label>
                        <input type="date" class="form-control" name="tahun_terbit" value="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Sinopsis</label>
                        <textarea class="form-control" name="sinopsis" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Genre </label>
                        <select name="genre" id="" class="form-control">
                            <option value="">--Select Genre--</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Science Fiction">Science Fiction</option>
                            <option value="Action & Adventure">Action & Adventure</option>
                            <option value="Mystery">Mystery</option>
                            <option value="Horror">Horror</option>
                            <option value="Thriller & Suspense">Thriller & Suspense</option>
                            <option value="Romance">Romance</option>
                            <option value="Biography">Biography</option>
                            <option value="History">History</option>
                        </select>
                    </div>
                    <button name="submit" type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>