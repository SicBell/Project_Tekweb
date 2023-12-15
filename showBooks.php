<?php
require "db_connect.php";

if (isset($_POST['input'])) {

    $input = $_POST['input'];

    $query = "SELECT * FROM books WHERE title LIKE '{$input}%' OR pengarang LIKE '{$input}%' OR tahun_terbit LIKE '%{$input}%'
        OR genre LIKE '{$input}%' OR book_status = '{$input}';";

    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {
        foreach ($result as $row) {
            if ($row['book_status'] !== 'borrowed') { ?>
                <!-- <div class="col-lg-4 col-md-3 col-sm-6"> -->
                <div class="col-3 me-2">
                    <div class="card">
                        <img data-bs-target="#book<?php echo $row['id']; ?>" data-bs-toggle="modal"
                            src="img/<?php echo $row['gambar']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="modal fade" id="book<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h3 style="text-align: center; font-size: 20px; color: darkblue;" class="uts">
                                                <?php echo $row['title']; ?>
                                            </h3>
                                            <p style="text-align: center; font-size: 20px; color: darkblue;" class="uts">
                                                ----★----</p>
                                            <img src="img/<?php echo $row['gambar']; ?>" class="card-img-top" alt="...">
                                            <h4 style="text-align:center">SYNOPSIS</h4>
                                            <p style="text-align: center; font-size: 20px; color: darkblue;" class="uts">
                                                <?php echo $row['sinopsis']; ?>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" style="color: blue; align-items: center;" class="btn btn-primary"
                                                data-bs-dismiss="modal">Close Window</button>
                                            <a href="/Project_Tekweb/img/scunt1.png" download="scunt1.png">
                                                <button type="button" class="btn btn-primary"
                                                    onclick="redirectToBorrowForm(<?php echo $row['id']; ?>)">
                                                    Borrow Book
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        }
    } else {
        echo "<h6 class='text-danger text-center mt-3'>No data found</h6>";
    }
}
?>