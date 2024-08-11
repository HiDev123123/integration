<?php
include('backend/conn.php');
include('nav.php');
?>

<div class="container mt-5">
    <center>
        <h2>List of Product.</h2>
    </center>

    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">SL No</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM products";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $x = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                                <th scope="row"> ' . ++$x . ' </th>
                                <td>' . $row['name'] . '</td>
                                <td><img src="image/product_image/' . $row['image'] . '" width="60px" height="60px"></td>
                                <td>' . $row['price'] . '</td>
                                
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#update" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-price="' . $row['price'] . '">Update</button>
                                </td>
                                <td>
                                    <form action="backend/delete_product.php" method="POST">
                                        <input type="hidden" name="id" value="' . $row['id'] . '">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>';
                    
                }
            }
            ?>
</div>



<!-- Modal -->
<div class="modal fade" id="update" tabindex="-1" aria-labelledby="updateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!--Update Product data  -->
                <form id="" action="backend/update_product.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product ID</label>
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price">
                    </div>
                    
                    <div class="mt-3">
                        <button type="Submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var update = document.getElementById('update');
        update.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget;

            // Extract info from data-* attributes
            var productId = button.getAttribute('data-id');
            var productName = button.getAttribute('data-name');
            var productPrice = button.getAttribute('data-price');

            // Update the modal's content
            var modalIdInput = update.querySelector('#id');
            var modalNameInput = update.querySelector('#name');
            var modalPriceInput = update.querySelector('#price');

            modalIdInput.value = productId;
            modalNameInput.value = productName;
            modalPriceInput.value = productPrice;
        });
    });
</script>