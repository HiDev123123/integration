<?php
include '../backend/conn.php'; // Ensure this file includes your database connection setup

// Retrieve and sanitize POST data
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$invoiceNumber = isset($_POST['invoice']) ? trim($_POST['invoice']) : '';
$items = isset($_POST['items']) ? $_POST['items'] : [];
$quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];
$prices = isset($_POST['prices']) ? $_POST['prices'] : [];
$newnum = isset($_POST['num']) ? trim($_POST['num']) : '';

// Insert the new invoice number into invoice_numbers table
$sql = "INSERT INTO invoice_numbers (num) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $newnum);

if ($stmt->execute()) {
    // Invoice number inserted successfully

    // Prepare SQL for inserting invoice items
    $sql = "INSERT INTO invoice (c_phone, invoice, p_name, quantity) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $allItemsInserted = true;

    // Insert each item into invoice table
    foreach ($items as $index => $item) {
        $quantity = isset($quantities[$index]) ? (int)$quantities[$index] : 0;
        $price = isset($prices[$index]) ? (float)$prices[$index] : 0.00;

        // The amount is calculated here, but not used in the invoice table
        $amount = $quantity * $price;

        $stmt->bind_param("ssss", $phone, $invoiceNumber, $item, $quantity);

        if (!$stmt->execute()) {
            $allItemsInserted = false;
            break; // Stop execution if an error occurs
        }
    }

    if ($allItemsInserted) {
        echo "Invoice successfully created!";
        header("Location: ../index.php"); // Redirect to index.php after successful creation
        exit();
    } else {
        echo "Error: Failed to insert some items.";
    }
} else {
    // Handle insertion error for invoice number
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();

