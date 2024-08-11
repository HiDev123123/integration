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
                <th scope="col">Name</th>
                <th scope="col">Mobile Number</th>
                <th scope="col">Address</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM customer";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $x = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                                <th scope="row"> ' . ++$x . ' </th>
                                <td>' . $row['name'] . '</td>
                                <td>'. $row['phone'].'</td>
                                <td>'. $row['address'].'</td>
                            </tr>';
                    
                }
            }
            ?>
</div>

