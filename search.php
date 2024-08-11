

<?php
include('backend/conn.php');
include('nav.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Invoice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <center>
        <h2>Search here...</h2>
        <br>
        <div class="form justify-content-center">
            <form method="GET" action="">
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4">
                        <input type="text" name="search" id="searchInput" placeholder="Enter Invoice Number" class="form-control">
                    </div>
                    <div class="col-2">
                        <input type="submit" class="btn btn-primary w-50" value="SEARCH">
                    </div>
                    <div class="col-2"></div>
                </div>
            </form>
        </div>
    </center>
</div>

<div class="container mt-5">
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">SL No</th>
                <th scope="col">Invoice</th>
                <th scope="col">Phone</th>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody id="results">
            <?php
            if (isset($_GET['search'])) {
                $search = $_GET['search'];

                // SQL query to search for the invoice number
                $query = "SELECT i.invoice, i.c_phone, i.quantity, p.name, p.price, i.date
                          FROM invoice i
                          JOIN products p ON i.p_name = p.name
                          WHERE i.invoice LIKE '%$search%'";

                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    $sl_no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$sl_no}</td>
                                <td>{$row['invoice']}</td>
                                <td>{$row['c_phone']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['price']}</td>
                                <td>{$row['quantity']}</td>
                                <td>" . ($row['price'] * $row['quantity']) . "</td>
                                <td>{$row['date']}</td>
                              </tr>";
                        $sl_no++;
                    }
                } else {
                    echo "<tr><td colspan='8'>No results found</td></tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>





