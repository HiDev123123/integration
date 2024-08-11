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

