<?php
include('backend/conn.php');
include('nav.php');
?>

<div class="container mt-5">
    <center>
        <h2>This is Index Page</h2>
    </center>
</div>

<!-- Preview of Products -->

<div class="container">
    <div class="row">
        <?php
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-sm-6 col-md-4 col-lg-3 mt-5 text-center">
                        <div class="card p-2 align-items-center" style="width: 100%;">
                            <img src="image/product_image/' . $row['image'] . '" class="card-img-top" style="height: 40%; width: 40%" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">' . $row['name'] . '</h5>
                                <p class="card-text">Price: ' . $row['price'] . '</p>
                                <a href="#" class="btn btn-primary">View</a>
                            </div>
                        </div>
                    </div>';
            }
        }
        ?>
    </div>
</div>
