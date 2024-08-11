<?php
include('backend/conn.php');
include('nav.php');

if (isset($_GET['invoice'])) {
    $invoice_number = $_GET['invoice'];

    // Fetch the invoice details using the invoice number
    $query = "SELECT i.invoice, i.c_phone, i.p_name, i.quantity, p.price, i.date
              FROM invoice i
              JOIN products p ON i.p_name = p.name
              WHERE i.invoice = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $invoice_number);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Display the invoice details
        $invoice_details = $result->fetch_all(MYSQLI_ASSOC);
        $first_entry = $invoice_details[0];
        $total_amount = 0;
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Invoice Details</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                table {
                    width: 100%;
                    text-align: center;
                    border: none;
                }
                .invoice-header td {
                    border: none;
                }
                .invoice-header p {
                    margin: 0;
                    padding: 0;
                }
                .print-btn {
                    margin: 20px 0;
                    text-align: center;
                }
            </style>
        </head>
        <body>
        <div class="container mt-5">
            <table class="table-bordered">
                <thead>
                    <tr class="invoice-header">
                        <td colspan="7" style="font-size: 20px;"><b>INVOICE</b></td>
                    </tr>
                    <tr class="invoice-header">
                        <td colspan="4" style="text-align: left;">
                            <img src="img.jpg" alt="Company Logo">
                        </td>
                        <td colspan="3" style="text-align: right;">
                            <p style="font-size: 15px;"><b>PN Services</b></p>
                            <p>Lumla Tawang</p>
                            <p>Phone No.: 888888888</p>
                        </td>
                    </tr>
                    <tr class="invoice-header">
                        <td colspan="4" style="text-align: left;">Bill To</td>
                        <td colspan="3" style="text-align: right;">Invoice Detail</td>
                    </tr>
                    <tr class="invoice-header">
                        <td colspan="4" style="text-align: left;">
                            <p>Name and Address of the customer</p>
                            <p>Phone: <?php echo htmlspecialchars($first_entry['c_phone']); ?></p>
                            <p>Email: </p>
                        </td>
                        <td colspan="3" style="text-align: right;">
                            <p>Invoice No.: <?php echo htmlspecialchars($first_entry['invoice']); ?></p>
                            <p>Date: <?php echo htmlspecialchars($first_entry['date']); ?></p>
                        </td>
                    </tr>
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
                    $sl_no = 1;
                    foreach ($invoice_details as $row) {
                        $amount = $row['quantity'] * $row['price'];
                        $total_amount += $amount;
                        ?>
                        <tr>
                            <td><?php echo $sl_no++; ?></td>
                            <td><?php echo htmlspecialchars($row['p_name']); ?></td>
                            <td><?php echo htmlspecialchars('HSN'); // Replace with actual HSN if available ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars('Unit'); // Replace with actual unit if available ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($amount); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <th colspan="6" style="text-align: right;"><strong>Total</strong></th>
                        <th id="totalAmount"><?php echo htmlspecialchars($total_amount); ?></th>
                    </tr>
                    <tr>
                        <th>In Words:</th>
                        <th colspan="6" id="amountInWords">Loading...</th>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: left; height: 100px; vertical-align: top;">
                            <p>Terms and conditions</p>
                        </td>
                        <td colspan="3" style="text-align: center; vertical-align: top;">
                            <p>For the company</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="print-btn">
                <button onclick="printInvoice()" class="btn btn-primary">Print Invoice</button>
            </div>
        </div>
        <script>
        const single_digit = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
        const double_digit = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        const below_hundred = ['Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        function translate(n) {
            let word = "";
            if (n === 0) return 'Zero';
            if (n < 10) {
                word = single_digit[n] + ' ';
            } else if (n < 20) {
                word = double_digit[n - 10] + ' ';
            } else if (n < 100) {
                let rem = translate(n % 10);
                word = below_hundred[Math.floor(n / 10) - 2] + ' ' + rem;
            } else if (n < 1000) {
                word = single_digit[Math.floor(n / 100)] + ' Hundred ' + translate(n % 100);
            } else if (n < 1000000) {
                word = translate(Math.floor(n / 1000)).trim() + ' Thousand ' + translate(n % 1000);
            } else if (n < 1000000000) {
                word = translate(Math.floor(n / 1000000)).trim() + ' Million ' + translate(n % 1000000);
            } else {
                word = translate(Math.floor(n / 1000000000)).trim() + ' Billion ' + translate(n % 1000000000);
            }
            return word.trim();
        }

        function displayAmountInWords() {
            const totalAmountElement = document.getElementById('totalAmount');
            const amountInWordsElement = document.getElementById('amountInWords');
            const amount = parseFloat(totalAmountElement.textContent.replace(/,/g, ''));
            const words = translate(amount);
            amountInWordsElement.textContent = words;
        }

        window.onload = function() {
            displayAmountInWords();
        };

        function printInvoice() {
            window.print();
        }
        </script>
        </body>
        </html>
        <?php
    } else {
        echo "<div class='container mt-5'>No results found for Invoice Number: " . htmlspecialchars($invoice_number) . "</div>";
    }

    $stmt->close();
} else {
    echo "<div class='container mt-5'>No invoice number provided.</div>";
}

$conn->close();
?>
