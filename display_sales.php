<?php
include('backend/conn.php');
include('nav.php');
?>

<div class="container mt-5">
    <center>
        <h2>Total Sales.</h2>
    </center>

    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">SL No</th>
                <th scope="col">Invoice</th>
                <th scope="col">Phone</th>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM  invoice";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $x = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo    '<tr>
                                <th scope="row"> ' . ++$x . ' </th>
                                <td> ' .  $row['invoice'] .'</td>
                                <td> ' .  $row['c_phone'] .'</td>
                                <td> ' .  $row['p_name'] .'</td>
                                <td> ' .  $row['quantity'] .'</td>
                                <td> ' .  $row['date'] .'</td>
                                
                            </tr>';
                }
            }
            ?>
</div>