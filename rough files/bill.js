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

function preview() {
    var table = document.querySelector("#preview table tbody");
    var rows = table.querySelectorAll('tr');
    var billData = [];

    // Collect data from the table
    rows.forEach(function(row) {
        var rowData = [];
        row.querySelectorAll('td').forEach(function(cell) {
            rowData.push(cell.innerText);
        });
        billData.push(rowData);
    });

    // Prepare the form and submit data to preview.php
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'preview.php';

    billData.forEach(function(rowData, index) {
        var rowInput = document.createElement('input');
        rowInput.type = 'hidden';
        rowInput.name = 'bill[' + index + ']';
        rowInput.value = JSON.stringify(rowData);
        form.appendChild(rowInput);
    });

    // Add the total amount as hidden input
    var totalInput = document.createElement('input');
    totalInput.type = 'hidden';
    totalInput.name = 'total';
    totalInput.value = document.getElementById('total').innerText;
    form.appendChild(totalInput);

    // Append the form to the body and submit
    document.body.appendChild(form);
    form.submit();
}

