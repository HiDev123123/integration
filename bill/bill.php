<!DOCTYPE html>
<html lang="en">

<head>
    <title>Index Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
</head>

<body style="background-color: #f5f5f6;">

    <main>
        <center>
            <div class="container mt-5 p-3">
                <h2>Invoice Generator</h2>
                <form class="row p-3 mt-4" id="myForm">
                    <div class="col">
                        <select name="item" id="item" class="form-control">
                            <option value="0" class="form-control">Select an item</option>
                            <?php
                            include '../backend/conn.php';
                            $sql = "SELECT name FROM products";
                            $result = $conn->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['name'] . "' class='form-control'>" . $row['name'] . "</option>";
                            }


                            $sql = "SELECT num FROM invoice_numbers ORDER BY id DESC LIMIT 1";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            $row['num'] + 1;
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <input type="number" name="price" id="price" class="form-control" readonly>
                    </div>
                    <div class="col">
                        <input type="number" name="quantity" id="quantity" class="form-control">
                    </div>
                    <div class="col">
                        <input type="number" name="amount" id="amount" class="form-control" readonly>
                    </div>
                    <div class="col-2">
                        <input type="button" id="addrow" class="btn btn-primary w-50" value="ADD">
                    </div>
                </form>
            </div>

            <!-- display the added data here -->
            <div class="container m-5 p-4">
                <form action="submit.php" method="post" class="form-group">
                    <div class="row mb-3">
                        <div class="col-3">
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone Number">
                        </div>

                        <div class="col-2">
                                <input type="text" name="num" id="num" value="<?php echo $row['num'] + 1; ?>" class="form-control" style="display: none;">
                                <input type="text" name="invoice" id="invoice" class="form-control" readonly>
                        </div>
                    </div>

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>sl no</th>
                                <th>name</th>
                                <th>price</th>
                                <th>quantity</th>
                                <th>amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        </tbody>
                    </table>

                    <div class="form-group">
                        <button>Submit</button>
                    </div>
                </form>
            </div>
    </main>

    <script src="bootstrap/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script>
        document.getElementById('addrow').addEventListener('click', function() {
    let tbody = document.getElementById('tbody');
    
    if (!tbody) {
        console.error("tbody element not found.");
        return;
    }

    // Retrieve and sanitize form values
    let itemValue = document.getElementById('item').value.trim(); // Remove any leading/trailing spaces
    let quantityValue = parseFloat(document.getElementById('quantity').value) || 0;
    let priceValue = parseFloat(document.getElementById('price').value) || 0.00;

    // Create a new table row
    let row = document.createElement('tr');

    // Create and populate table cells
    let cell1 = document.createElement('td');
    let cell2 = document.createElement('td');
    let cell3 = document.createElement('td');
    let cell4 = document.createElement('td');
    let cell5 = document.createElement('td');
    let cell6 = document.createElement('td');

    // Calculate and format the amount
    let amountValue = (quantityValue * priceValue).toFixed(2);

    cell1.innerHTML = tbody.rows.length + 1; // Serial number
    cell2.innerHTML = itemValue || 'N/A'; // Item name
    cell3.innerHTML = quantityValue; // Quantity
    cell4.innerHTML = priceValue.toFixed(2); // Price
    cell5.innerHTML = amountValue; // Amount
    cell6.innerHTML = "<button type='button' class='btn btn-danger btn-sm' onclick='deleteRow(this)'>Delete</button>";

    // Create hidden inputs for form submission  
    let itemInput = document.createElement('input');
    itemInput.type = 'hidden';
    itemInput.name = 'items[]';
    itemInput.value = itemValue;

    let quantityInput = document.createElement('input');
    quantityInput.type = 'hidden';
    quantityInput.name = 'quantities[]';
    quantityInput.value = quantityValue;

    let priceInput = document.createElement('input');
    priceInput.type = 'hidden';
    priceInput.name = 'prices[]';
    priceInput.value = priceValue;

    // Append hidden inputs to the row
    row.appendChild(itemInput);
    row.appendChild(quantityInput);
    row.appendChild(priceInput);

    // Append cells to the row
    row.appendChild(cell1);
    row.appendChild(cell2);
    row.appendChild(cell3);
    row.appendChild(cell4);
    row.appendChild(cell5);
    row.appendChild(cell6);

    // Append the row to the table body
    tbody.appendChild(row);
    
    // Reset the form fields
    document.getElementById('item').value = '';
    document.getElementById('quantity').value = '';
    document.getElementById('price').value = '';
});



































// document.getElementById('addrow').addEventListener('click', function() {
//     let tbody = document.getElementById('tbody');
    
//     if (!tbody) {
//         console.error("tbody element not found.");
//         return;
//     }

//     // Creating the table row
//     let row = document.createElement('tr');

//     // Creating the table cells
//     let cell1 = document.createElement('td');
//     let cell2 = document.createElement('td');
//     let cell3 = document.createElement('td');
//     let cell4 = document.createElement('td');
//     let cell5 = document.createElement('td');
//     let cell6 = document.createElement('td');

//     // Assigning the values in the cells
//     cell1.innerHTML = tbody.rows.length + 1; // Set serial number
//     cell2.innerHTML = document.getElementById('item').value || 'N/A';
//     cell3.innerHTML = document.getElementById('quantity').value || 0;
//     cell4.innerHTML = document.getElementById('price').value || 0.00;
//     cell5.innerHTML = (document.getElementById('quantity').value * document.getElementById('price').value) || 0.00;
//     cell6.innerHTML = "<button type = 'button' class='btn btn-danger btn-sm' onclick='deleteRow(this)'>Delete</button>";

//     // Appending cells to the row
//     row.appendChild(cell1);
//     row.appendChild(cell2);
//     row.appendChild(cell3);
//     row.appendChild(cell4);
//     row.appendChild(cell5);
//     row.appendChild(cell6);

//     // Appending the row to the table body
//     tbody.appendChild(row);
    
//     // Reset the form
//     document.getElementById('item').value = '';
//     document.getElementById('quantity').value = '';
//     document.getElementById('price').value = '';

    
// });

// delete button 
function deleteRow(button) {
    // Find the row to delete
    let row = button.closest('tr');

    // Check if the row was found
    if (!row) {
        console.error("Row element not found.");
        return;
    }

    // Log the row for debugging
    console.log("Deleting row:", row);

    // Remove the row from the table
    row.remove();

    // Recalculate the serial numbers
    let tbody = document.getElementById('tbody');
    for (let i = 0; i < tbody.rows.length; i++) {
        tbody.rows[i].cells[0].innerText = i + 1;
    }
}


    </script>
</body>

</html>