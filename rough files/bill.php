<?php
session_start();
include('backend/conn.php');
include('nav.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container m-5">
        <center>
            <h2>Add Products</h2>
        </center>
        <hr>
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
                <tr>
                    <td>
                        <select name="" id="item" class="form-select" onchange="updatePrice()">
                            <option value="" data-price="" data-unit="">Select Item</option>
                            <?php
                            include('backend/conn.php');
                            $sql = "SELECT * FROM products";
                            $result = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id'] . "' data-hsn='" . $row['hsn'] . "' data-price='" . $row['price'] . "' data-unit='" . $row['unit'] . "'>" . $row['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="number" id="price" class="form-control text-center" value="" readonly>
                    </td>
                    <td>
                        <input type="text" id="quantity" class="form-control text-center" value="1" onkeyup="amount()">
                    </td>
                    <td>
                        <input type="text" id="amount" class="form-control text-center" placeholder="00">
                    </td>
                    <td>
                        <button class="btn btn-primary" onclick="addRow()">+</button>
                    </td>
                </tr>
            </thead>
        </table>
    </div>




    <!-- Draft Bill -->
    <div class="container m-5" id="preview">
        <center>
            <h2>BILL</h2>
        </center>
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
                    <th></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6">Total</th>
                    <th id="total">00.00</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <div>
            <button type="button" class="btn btn-primary" onclick="preview()">Preview</button>
        </div>
    </div>

    <script>
        function preview() {
            var sourceTable = document.querySelector("#preview table tbody");
            var targetTable = document.querySelector(".container.m-5:nth-of-type(3) table tbody");

            // Clear the existing preview table
            targetTable.innerHTML = '';

            // Populate the preview table with current data
            var rows = sourceTable.querySelectorAll('tr');
            rows.forEach(function(row) {
                var newRow = targetTable.insertRow();
                var cells = row.querySelectorAll('td');

                // Copy each cell's content except the last cell (delete button)
                cells.forEach(function(cell, index) {
                    if (index < cells.length - 1) { // Exclude the last cell
                        newRow.insertCell(index).innerText = cell.innerText;
                    }
                });
            });

            // Update the total in the preview table
            var totalCell = document.querySelector("#total");
            var totalPreviewCell = document.querySelector(".container.m-5:nth-of-type(3) table tfoot tr th:last-child");
            totalPreviewCell.innerText = totalCell.innerText;

            // Show the preview section and hide the form section
            document.querySelector(".container.m-5:nth-of-type(1)").style.display = "none";
            document.querySelector(".container.m-5:nth-of-type(2)").style.display = "none";
            document.querySelector(".container.m-5:nth-of-type(3)").style.display = "block";
        }


        function updatePrice() {
            var item = document.getElementById("item");
            var price = item.options[item.selectedIndex].getAttribute("data-price");
            document.getElementById("price").value = price;
            amount();
        }

        function amount() {
            var price = parseFloat(document.getElementById("price").value);
            var quantity = parseInt(document.getElementById("quantity").value);
            if (!isNaN(price) && !isNaN(quantity)) {
                document.getElementById("amount").value = (price * quantity).toFixed(2);
            } else {
                document.getElementById("amount").value = '';
            }
        }

        function addRow() {
            var table = document.querySelector("#preview table tbody");
            var rowCount = table.rows.length;

            var itemSelect = document.getElementById("item");
            var selectedItem = itemSelect.options[itemSelect.selectedIndex];
            var selectedItemText = selectedItem.text;
            var hsn = selectedItem.getAttribute("data-hsn");
            var price = document.getElementById("price").value;
            var quantity = document.getElementById("quantity").value;
            var amount = document.getElementById("amount").value;
            var unit = selectedItem.getAttribute("data-unit");

            if (!selectedItem.value) {
                alert('Please select a product.');
                return;
            }

            // Check if the item already exists
            for (var i = 0; i < table.rows.length; i++) {
                if (table.rows[i].cells[1].innerText === selectedItemText) {
                    alert('This item is already added.');
                    return;
                }
            }

            var newRow = table.insertRow();

            newRow.insertCell(0).innerText = rowCount + 1;
            newRow.insertCell(1).innerText = selectedItemText;
            newRow.insertCell(2).innerText = hsn;
            newRow.insertCell(3).innerText = quantity;
            newRow.insertCell(4).innerText = unit;
            newRow.insertCell(5).innerText = price;
            newRow.insertCell(6).innerText = amount;

            var deleteCell = newRow.insertCell(7);
            deleteCell.innerHTML = '<button class="btn btn-danger" onclick="deleteRow(this)">Delete</button>';

            // Clear the form fields after adding a row
            document.getElementById("item").selectedIndex = 0;
            document.getElementById("price").value = '';
            document.getElementById("quantity").value = 1;
            document.getElementById("amount").value = '';

            updateTotal();
        }

        function deleteRow(btn) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);

            // Update serial numbers
            updateSerialNumbers();
            updateTotal();
        }

        function updateSerialNumbers() {
            var table = document.querySelector("#preview table tbody");
            for (var i = 0; i < table.rows.length; i++) {
                table.rows[i].cells[0].innerText = i + 1;
            }
        }

        function updateTotal() {
            var table = document.querySelector("#preview table tbody");
            var total = 0;

            for (var i = 0; i < table.rows.length; i++) {
                total += parseFloat(table.rows[i].cells[6].innerText);
            }

            document.getElementById("total").innerText = total.toFixed(2);
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>




<!-- Main Bill -->


<div class="container m-5">
    <center>
        <h2>Preview</h2>
    </center>
    <hr>
    <table style="width: 100%; text-align: center; border: none; ">
        <thead>
            <tr style="border: none;">
                <td colspan="7" style="border: none; font-size: 20px;"><b>INVOICE</b></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left;">
                    <img src="img.jpg" alt="">
                </td>
                <td colspan="4" style="text-align: right;">
                    <p style="font-size: 15px; margin: 0; padding: 0 0 5px 0;"><b>PN Services</b></p>
                    <p style="margin: 0; padding: 0;">Lumla Tawang</p>
                    <p style="margin: 0; padding: 0;">Phone No.: 888888888</p>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left; width: 50%;">Bil To</td>
                <td colspan="3" style="text-align: right;  width: 50%;">Invoice Detail</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: left; ">
                    <?php

                    $phone = '';

                    // Retrieve phone number from session
                    if (isset($_SESSION['phone'])) {
                        $phone = $_SESSION['phone'];
                        unset($_SESSION['phone']); // Optionally remove phone from session
                    }

                    if ($phone) {
                        // Sanitize and validate the phone number
                        $phone = mysqli_real_escape_string($conn, $phone);

                        // Prepare SQL query to prevent SQL injection
                        $stmt = $conn->prepare("SELECT * FROM customer WHERE phone = ?");
                        $stmt->bind_param("s", $phone);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            // Phone number exists, fetch and display customer details
                            while ($row = $result->fetch_assoc()) {
                                echo "Mobile Number: " . htmlspecialchars($row['phone']) . "<br>";
                                echo "Customer Name: " . htmlspecialchars($row['name']) . "<br>";
                                echo "Address: " . htmlspecialchars($row['address']) . "<br>";
                            }
                        } else {
                            echo "No customer found with this phone number.";
                        }
                    }
                    ?>
                </td>
                <td colspan="4" style="text-align: right; vertical-align: top;  ">
                    Invoice No.: 00005 <br>
                    Date: 00/00/2002 <br>
                    Date: 00/00/2002 <br>
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
        <tbody id="preview">
            <tr>

            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Total</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>00.00</th>
            </tr>
            <tr>
                <th>In Words:</th>
                <th colspan="6" style="text-align: left;">Only.</th>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center; height: 100px; vertical-align: top;">
                    <p>Terms and conditions</p>
                </td>
                <td colspan="4" style="text-align: center; vertical-align: top;">
                    <p>For the company</p>
                </td>
            </tr>
        </tfoot>
        <div>
        <button type="button" onclick="print()" class="btn btn-primary">Print</button>
        </div>
    </table>

    <style>
        table,
        th,
        td {
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
</div>






<!-- js -->
<script>
    function print() {
    var previewContent = document.querySelector(".container.m-5:nth-of-type(3)").innerHTML;
    var printWindow = window.open('', '', 'height=800,width=600');
    
    printWindow.document.write('<html><head><title>Print Preview</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('@media print {');
    printWindow.document.write('body { font-family: Arial, sans-serif; }');
    printWindow.document.write('table { width: 20%; border-collapse: collapse; }');
    printWindow.document.write('table, th, td { border: 1px solid black; padding: 5px; }');
    printWindow.document.write('thead { background-color: #f2f2f2; }');
    printWindow.document.write('@page { size: landscape; }');
    printWindow.document.write('}');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body >');
    printWindow.document.write(previewContent);
    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}



    function updatePrice() {
        var select = document.getElementById('item');
        var priceInput = document.getElementById('price');
        var selectedOption = select.options[select.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        priceInput.value = price;
        amount(); // Call amount() to update the amount based on the new price
    }

    function amount() {
        var price = parseFloat(document.getElementById('price').value) || 0;
        var quantity = parseFloat(document.getElementById('quantity').value) || 1; // Default to 1 if quantity is empty or invalid
        var amount = price * quantity;
        document.getElementById('amount').value = amount.toFixed(2); // To fix decimal places
    }

    // Call amount() on page load to set initial amount based on default quantity value
    window.onload = function() {
        amount();
    };
</script>

<!-- Modal HTML -->
<div class="modal fade" id="noCustomerModal" tabindex="-1" aria-labelledby="noCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noCustomerModalLabel">Customer Not Found</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                No customer was found with the provided phone number.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>