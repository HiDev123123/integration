<?php
session_start();
include('backend/conn.php');
include('nav.php');

$bill = isset($_SESSION['bill']) ? $_SESSION['bill'] : [];
unset($_SESSION['bill']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Bill</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        table, th, td {
            border: 1px solid;
            border-collapse: collapse;
            padding: 5px 20px;
            font-size: small;
        }

        table img {
            height: 50px;
            width: 50px;
        }
    </style>
</head>
<body>
    <div class="container m-5">
        <center><h2>Preview Bill</h2></center>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SL NO</th>
                    <th>Item</th>
                    <th>HSN</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                if (!empty($bill)) {
                    foreach ($bill as $index => $item) {
                        $total += $item['amount'];
                        echo "<tr>
                                <td>" . ($index + 1) . "</td>
                                <td>" . htmlspecialchars($item['item']) . "</td>
                                <td>" . htmlspecialchars($item['hsn']) . "</td>
                                <td>" . htmlspecialchars($item['quantity']) . "</td>
                                <td>" . htmlspecialchars($item['unit']) . "</td>
                                <td>" . htmlspecialchars($item['price']) . "</td>
                                <td>" . htmlspecialchars($item['amount']) . "</td>
                              </tr>";
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6">Total</th>
                    <th><?php echo number_format($total, 2); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
